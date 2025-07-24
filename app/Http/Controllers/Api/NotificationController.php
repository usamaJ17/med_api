<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmailNotifications;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function save(Request $request){
        Notifications::create($request->all());
        return response()->json([ 'status' => 200, 'message' => 'Notification saved successfully'], 200);
    }
    public function getAll(Request $request){
        $notifications = Notifications::query();
        if($request->has('to_user_id')){
            $notifications->where('to_user_id', $request->to_user_id);
        }
        if($request->has('from_user_id')){
            $notifications->where('from_user_id', $request->from_user_id);
        }
        if(!$request->has('from_user_id') && !$request->has('to_user_id')){
            $notifications->where('from_user_id', Auth::user()->id)->orWhere('to_user_id', Auth::user()->id);
        }
        if($request->has('is_read')){
            $notifications->where('is_read', $request->is_read);
        }
        if($request->has('type')){
            $notifications->where('type', $request->type);
        }
        $notifications = $notifications->get();
        $data =[
            'notifications' => $notifications
        ];
        return response()->json(['status' => 200,'data' => $data , 'message' => 'Notification fetched successfully'], 200);
    }
    public function listEmailNotifications(){
        $emailNotifications = EmailNotifications::all();
        return view('dashboard.email_notifications.index', compact('emailNotifications'));
    }
    public function deleteEmailNotifications(Request $request){
        EmailNotifications::whereIn('id', $request->ids)->delete();
        return response()->json(['status' => 200,'message' => 'Email notifications deleted successfully'], 200);
    }
    public function changeStatus(Request $request){
        $notification = Notifications::find($request->id);
        $notification->is_read = $request->is_read;
        $notification->save();
        return response()->json(['status' => 200,'message' => 'Notification status changed successfully'], 200);
    }
    public function delete($id){
        Notifications::find($id)->delete();
        return response()->json(['status' => 200,'message' => 'Notification deleted successfully'], 200);
    }
}
