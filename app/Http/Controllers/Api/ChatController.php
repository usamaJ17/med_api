<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatBox;
use App\Models\ChatBoxMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getAllChats()
    {
        $chatboxes = ChatBox::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();
        $data = [
            'status' => 200,
            'message' => 'Chats Fetched Successfully',
            'data' => $chatboxes
        ];
        return response()->json($data);
    }
    public static function createChatBox($from_id, $to_id)
    {
        $chatbox = ChatBox::where('sender_id', $from_id)
            ->where('receiver_id', $to_id)
            ->orWhere('sender_id', $to_id)
            ->where('receiver_id', $from_id)
            ->first();
        if ($chatbox) {
            if ($chatbox->status == 0) {
                $chatbox->status = 1;
                $chatbox->save();
            }
        }else{
            $chatbox = ChatBox::create([
                'sender_id' => $from_id,
                'receiver_id' => $to_id,
                'status' => 1
            ]);
        }
        return true;
    }
    public function sendMessage(Request $request){
        $chatbox = ChatBox::find($request->chat_box_id);
        if($chatbox){
            if($chatbox->status){
                $message = $chatbox->messages()->create([
                    'from_user_id' => auth()->id(),
                    'to_user_id' => $request->to_user_id,
                    'message' => $request->message,
                    'is_read' => 0
                ]);
                $chatbox->notification_to = $request->to_user_id;
                $chatbox->save();
                $data = [
                    'status' => 201,
                    'message' => 'Message Sent Successfully',
                    'data' => $message
                ];
                return response()->json($data);
            }else{
                $data = [
                    'status' => 404,
                    'message' => 'Chat Box Not Active',
                ];
                return response()->json($data);
            }
        }else{
            $data = [
                'status' => 404,
                'message' => 'Chat Box Not Found',
            ];
            return response()->json($data);
        }
    }
    public function getMessage(Request $request){
        $chatbox = ChatBox::find($request->chat_box_id);
        if($chatbox){
            $messages = $chatbox->messages;
                $data = [
                    'status' => 200,
                    'message' => 'Messages Fetched Successfully',
                    'data' => $messages
                ];
            return response()->json($data);
        }else{
            $data = [
                'status' => 404,
                'message' => 'Chat Box Not Found',
            ];
            return response()->json($data);
        }
    }
    public function deleteMessage(Request $request){
        $message = ChatBoxMessage::find($request->message_id);
        if($message){
            $message->delete();
            $data = [
                'status' => 200,
                'message' => 'Message Deleted Successfully',
            ];
            return response()->json($data);
        }else{
            $data = [
                'status' => 404,
                'message' => 'Message Not Found',
            ];
            return response()->json($data);
        }
    }
}
