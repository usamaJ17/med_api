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
                    'message_type' => $request->message_type
                ]);
                if($request->hasFile('message')){
                    $message->addMediaFromRequest('message')
                        ->toMediaCollection();
                }else{
                    $message->message = $request->message;
                    $message->save();
                }
                $msg = ChatBoxMessage::find($message->id);
                $chatbox->notification_to = $request->to_user_id;
                $chatbox->save();
                $data = [
                    'status' => 201,
                    'message' => 'Message Sent Successfully',
                    'data' => $msg
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
            $latest_message_id = $messages->last()->id;
            $msg = [
                'chats' => $messages,
                'last_message_id' => $latest_message_id
            ];
            $data = [
                'status' => 200,
                'message' => 'Messages Fetched Successfully',
                'data' => $msg
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
    public function getNewMessage(Request $request){
        $chatbox = ChatBox::find($request->chat_box_id);
        if($chatbox){
            $messages = ChatBoxMessage::with('sender','receiver')->where('chat_box_id', $request->chat_box_id)
                ->where('id', '>', $request->last_message_id)
                ->get();
            $msg = [
                'chats' => $messages,
                'last_message_id' => $messages->last()->id
            ];
            $data = [
                'status' => 200,
                'message' => 'Messages Fetched Successfully',
                'data' => $msg
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
