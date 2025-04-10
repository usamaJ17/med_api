<?php

namespace App\Jobs;

use App\Models\ProfessionalDetails;
use App\Models\ProfessionalType;
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
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pushNotification = PushNotification::where('is_sent' , 0)->where('scheduled_at' , '<=' , now())->orderBy('created_at')->first();
        if (!$pushNotification) {
            Log::info('No push notification to send');
            return;
        }
        try {
            $tokens = [];
            if($pushNotification->to_role == 'professional' || $pushNotification->to_role == 'patient'){
                $role = $pushNotification->to_role == 'professional' ? 'medical' : 'patient';
                $role = Role::findByName($role);
                $tokens = User::role($role->name)
                ->whereNotNull('device_token')
                    ->where('device_token', '!=', '')
                    ->pluck('device_token')
                    ->toArray();
            } else {
                $professsionalTypeId = ProfessionalType::where('name', $pushNotification->to_role)->first()->id;
                $details = ProfessionalDetails::where('profession', $professsionalTypeId)->pluck('user_id')->toArray();
                $tokens = User::whereIn('id', $details)
                ->whereNotNull('device_token')
                    ->where('device_token', '!=', '')
                    ->pluck('device_token')
                    ->toArray();
            }
            $role = Role::findByName($role);
            $tokens = User::role($role->name)
            ->whereNotNull('device_token')
                ->where('device_token', '!=', '')
                ->pluck('device_token')
                ->toArray();
            if (empty($tokens)) {
                Log::error('Firebase Messaging Exception: no token found');
            }

            $messaging = Firebase::messaging();
            Log::info('Firebase Messaging instance created');
            Log::info($pushNotification->image_url);
            $notification = Notification::create($pushNotification->title, $pushNotification->body ,$pushNotification->image_url);
            $message = CloudMessage::new()
                ->withNotification($notification); // Standard notification payload

            $tokensPerBatch = 400;
            $tokenBatches = array_chunk($tokens, $tokensPerBatch);
            $report = null;
            $invalidTokens = [];
            foreach ($tokenBatches as $batch) {
                Log::info('before sending');
                $batchReport = $messaging->sendMulticast($message, $batch);
                Log::info('after sending');
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
            $pushNotification->is_sent = 1;
            $pushNotification->save();

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
