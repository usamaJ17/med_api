<?php

namespace App\Jobs;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessProfileImage implements ShouldQueue
{
    use Queueable ,InteractsWithQueue, SerializesModels;
    private $user_id;
    private $image_id;
    private $attempt;

    /**
     * Create a new job instance.
     */
    public function __construct($user_id, $image_id , $attempt = 0)
    {
        $this->attempt = $attempt;
        $this->user_id = $user_id;
        $this->image_id = $image_id;
    }

    /**
     * Execute the job.
     */ 
    public function handle(): void
    {
        $client = new Client();
        $apiUrl = 'https://api.magichour.ai/v1/image-projects/' . $this->image_id;
        $response = $client->get($apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . env('MAGIC_HOUR_API')
            ]
        ]);
        $response = json_decode($response->getBody(), true);
    
        if ($response['status'] == 'complete') {
            $imageUrl = $response['downloads'][0]['url'];
            $user = User::find($this->user_id);
            $media = $user->getFirstMedia(); // Get existing media
    
            if ($media) {
                $path = $media->getPath();
                $imageContents = file_get_contents($imageUrl);
                file_put_contents($path, $imageContents);
                $media->touch(); // Update timestamp
                $media->save();
            } else {
                $user->addMediaFromUrl($imageUrl)->toMediaCollection();
            }
        } else {
            if( $this->attempt < 3) {
                ProcessProfileImage::dispatch($this->user_id, $this->image_id , $this->attempt + 1)->delay(now()->addMinutes(3));
            }
        }
    }
}
