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
    use Queueable ,InteractsWithQueue, Queueable, SerializesModels;
    private $user_id;
    private $image_id;

    /**
     * Create a new job instance.
     */
    public function __construct($user_id, $image_id)
    {
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
        if($response['status'] == 'complete'){
            $imageUrl = $response['downloads'][0]['url'];
            $user = User::find($this->user_id);
            $user->clearMediaCollection();
            $user->addMediaFromUrl($imageUrl)->toMediaCollection();
        }else{
            ProcessProfileImage::dispatch($this->user_id, $this->image_id);
        }
    }
}
