<?php

use App\Models\ChatBox;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat.{id}', function ($user, $id) {

    $participant = ChatBox::where([
        [
            'id',$id
        ]
    ])->first();

    return $participant !== null;
});
