<?php

namespace App\Http\Controllers;

use App\Models\MetaDescription;
use App\Models\PushNotification;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    public function index()
    {
        $pushNotifications = PushNotification::all();
        return view('dashboard.push_notification.index', compact('pushNotifications'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        PushNotification::create([
            'title' => $request->title,
            'body' => $request->body,
            'to_role' => $request->to_role
        ]);

        return redirect()->back()->with('success', 'Notification queued for sending');
    }
}
