<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ChatBox;
use App\Models\User;
use App\Models\Notifications;
use App\Models\ChatBoxMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getAllChats()
    {
        ChatBox::where('expired_at', '<', now())->update(['status' => 0]);
        $chatboxes = ChatBox::with('sender','receiver')->where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();
        $data = [
            'status' => 200,
            'message' => 'Chats Fetched Successfully',
            'data' => $chatboxes
        ];
        return response()->json($data);
    }

    private static function calculateExpiryTimeStamp($appId){
        $appointment = Appointment::find($appId);
        $endingDate = $appointment->appointment_date;
        $endingTime = $appointment->appointment_time;
        $appointmentDateTime = Carbon::parse("$endingDate $endingTime");
        return $appointmentDateTime->copy()->addDays(7);
    }
    
    public static function createChatBox($from_id, $to_id , $appId)
    {
        $expiredTime = self::calculateExpiryTimeStamp($appId);
        $chatbox = ChatBox::where('sender_id', $from_id)
            ->where('receiver_id', $to_id)->first();
        if(!$chatbox){
            ChatBox::where('sender_id', $to_id)
                ->where('receiver_id', $from_id)
                ->first();
        }
        if ($chatbox) {
            if ($chatbox->status == 0) {
                $chatbox->status = 1;
                $chatbox->appointment_id = $appId;
                $chatbox->expired_at = $expiredTime;
                $chatbox->save();
            }
        }else{
            $chatbox = ChatBox::create([
                'sender_id' => $from_id,
                'receiver_id' => $to_id,
                'appointment_id' => $appId,
                'expired_at' => $expiredTime,
                'status' => 1
            ]);
        }
        $sender = User::find($from_id); 
        $notificationData = [
            'title' => 'Chat Created',
            'description' => "<strong>New message Alert:</strong> You've received a new message from $sender->first_name $sender->last_name. Tap here to view and reply.",
            'type' => 'Chat',
            'from_user_id' => $from_id,
            'to_user_id' => $to_id,
            'is_read' => 0,
        ];        
        Notifications::create($notificationData);
        return $chatbox;
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
                }
                if($request->message_type == 'missed' || $request->message_type == 'incoming' || $request->message_type == 'outgoing'){
                    $message->duration = $request->duration;
                }
                $message->save();
                $msg = ChatBoxMessage::find($message->id);
                $chatbox->notification_to = $request->to_user_id;
                $chatbox->save();
                $this->incrementUnreadValue($chatbox->id);
                $data = [
                    'status' => 201,
                    'message' => 'Message Sent Successfully',
                    'data' => $msg
                ];
                broadcast(new MessageSent($message, $chatbox->id))->toOthers();
            }else{
                $data = [
                    'status' => 404,
                    'message' => 'Chat Box Not Active',
                ];
            }
        }else{
            $data = [
                'status' => 404,
                'message' => 'Chat Box Not Found',
            ];
        }
        return response()->json($data);
    }

    private function incrementUnreadValue($chat_id ){
        $chatBox = ChatBox::find($chat_id);
        if(auth()->user()->id == $chatBox->sender_id){
            $chatBox->unread_count_receiver = $chatBox->unread_count_receiver + 1;
        }else{
            $chatBox->unread_count_sender = $chatBox->unread_count_sender + 1;
        }
        $chatBox->save();
    }
    private function resetUnreadValue($chat_id ){
        $chatBox = ChatBox::find($chat_id);
        if(auth()->user()->id == $chatBox->sender_id){
            $chatBox->unread_count_sender = 0;
        }else{
            $chatBox->unread_count_receiver = 0;
        }
        $chatBox->save();
    }
    public function getMessage(Request $request){
        $chatbox = ChatBox::find($request->chat_box_id);
        if($chatbox){
            $messages = $chatbox->messages;
            $latest_message_id = $messages->last() ? $messages->last()->id : null;
            $msg = [
                'chats' => $messages,
                'last_message_id' => $latest_message_id
            ];
            $data = [
                'status' => 200,
                'message' => 'Messages Fetched Successfully',
                'data' => $msg
            ];
            $this->resetUnreadValue($chatbox->id);
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
            $messages = ChatBoxMessage::where('chat_box_id', $request->chat_box_id)
                ->where('id', '>', $request->last_message_id)
                ->get();
            $msg = [
                'chats' => $messages,
                'last_message_id' => $messages->last() ? $messages->last()->id : null
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
