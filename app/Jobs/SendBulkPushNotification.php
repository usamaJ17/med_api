<?php

namespace App\Jobs;

use App\Models\PushNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Kreait\Firebase\Exception\FirebaseException;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBulkPushNotification  implements ShouldQueue
{
    use Queueable ,InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $notificationId;
    public function __construct($notificationId)
    {
        $this->notificationId = $notificationId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pushNotification = PushNotification::find($this->notificationId);

        $role = $pushNotification->to_role == 'professional' ? 'medical' : 'patient';

        Log::info('ROLE: ' . $role);

        try {
            $role = Role::findByName($role);
            $tokens = User::role($role->name) // Use Spatie's scope
            ->whereNotNull('device_token')
                ->where('device_token', '!=', '')
                ->pluck('device_token')
                ->toArray();
            if (empty($tokens)) {
                Log::error('Firebase Messaging Exception: no token found');
            }

            $messaging = Firebase::messaging();
            $notification = Notification::create($pushNotification->title, $pushNotification->body);
            $message = CloudMessage::new()
                ->withNotification($notification); // Standard notification payload

            $tokensPerBatch = 400;
            $tokenBatches = array_chunk($tokens, $tokensPerBatch);
            $report = null;
            $invalidTokens = [];
            foreach ($tokenBatches as $batch) {
                $batchReport = $messaging->sendMulticast($message, $batch);
                if ($batchReport->hasFailures()) {
                     Log::warning('Some notifications failed to send in batch.');
                    foreach ($batchReport->failures()->getItems() as $failure) {
                         Log::error("Failed sending to token: " . $failure->target()->value() . " | Reason: " . $failure->error()->getMessage());
                        if ($this->isTokenUnregistered($failure->error())) {
                            $invalidTokens[] = $failure->target()->value();
                        }
                    }
                }
            }
            if (!empty($invalidTokens)) {
                User::whereIn('device_token', $invalidTokens)->update(['device_token' => null]);
                Log::info('Cleaned up invalid tokens.', ['count' => count($invalidTokens)]);
            };

        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            Log::error('Firebase Messaging Exception: Role not found' . $e->getMessage());
        } catch (\Kreait\Firebase\Exception\MessagingException|FirebaseException $e) {
            Log::error('Firebase Messaging Exception: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error sending notification: ' . $e->getMessage());
        }
    }
    private function isTokenUnregistered(\Throwable $error): bool
    {
        if (!$error instanceof \Kreait\Firebase\Exception\Messaging\MessagingError) {
            return false;
        }
        $message = strtolower($error->getMessage());
        return str_contains($message, 'unregistered') ||
            str_contains($message, 'invalid registration token') ||
            str_contains($message, 'mismatched sender id');
    }
}
