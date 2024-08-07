<?php

namespace App\Events;

// app/Events/MessageSent.php

use App\User;
use App\Message;
use App\Models\ChatBox;
use App\Models\ChatBoxMessage;
use App\Models\User as ModelsUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that sent the message
     *
     * @var User
     */
    // public $user;

    /**
     * Message details
     *
     * @var Message
     */
    public $message;
    // public $chatbox;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChatBoxMessage $message)
    {
        // $this->user = $user;
        $this->message = $message;
        // $this->chatbox = $chatbox;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->message->id);
    }
        /**
     * Broadcast's event name
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }
     /**
     * Data sending back to client
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'chat_id' => $this->message->id,
            'message' => $this->message->toArray(),
        ];
    }
}

