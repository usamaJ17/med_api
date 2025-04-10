<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalType;
use App\Models\PushNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PushNotificationController extends Controller
{
    public function index()
    {
        $pushNotifications = PushNotification::all();
        $professsionalTypes = ProfessionalType::all();
        return view('dashboard.push_notification.index', compact('pushNotifications' , 'professsionalTypes'));
    }


    public function show($id)
    {
        $pushNotification = PushNotification::findOrFail($id);
        return response()->json($pushNotification);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'to_role' => 'required',
            'scheduled_at' => 'required',
        ]);

        $notification = PushNotification::create([
            'title' => $request->title,
            'body' => $request->body,
            'to_role' => $request->to_role,
            'scheduled_at' => Carbon::createFromFormat('Y-m-d H:i', $request->scheduled_at),
        ]);
        if ($request->hasFile('image')) {
            $notification->addMediaFromRequest('image')->toMediaCollection('notification_image');
        }

        return redirect()->back()->with('success', 'Notification queued for sending');
    }

    public function edit(PushNotification $pushNotification)
    {
        return response()->json($pushNotification);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'to_role' => 'required',
            'scheduled_at' => 'required',
        ]);

        $pushNotification = PushNotification::findOrFail($id);
        $pushNotification->update([
            'title' => $request->title,
            'body' => $request->body,
            'to_role' => $request->to_role,
            'scheduled_at' => Carbon::createFromFormat('Y-m-d H:i', $request->scheduled_at),
        ]);
        if ($request->hasFile('image')) {
            $pushNotification->clearMediaCollection('notification_image');
            $pushNotification->addMediaFromRequest('image')->toMediaCollection('notification_image');
        }

        return redirect()->back()->with('success', 'Notification updated successfully');
    }

    public function destroy($id)
    {
        $pushNotification = PushNotification::findOrFail($id);
        $pushNotification->delete();
        return response()->json(true);
    }
}

