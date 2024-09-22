<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reminders = Reminder::all();
        return view('dashboard.reminder.index', compact('reminders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reminder = Reminder::create($request->all());
        $role = Role::findByName($request->role);
        $users = User::role($role->name)->get();

        // Attach users to the reminder
        foreach ($users as $user) {
            $reminder->users()->attach($user->id, ['is_read' => 0]);
        }
        return redirect()->back()->with('success', 'Reminder added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reminder $reminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reminder $reminder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reminder $reminder)
    {
        if ($reminder->role !== $request->role) {
            $reminder->update($request->all());
            $role = Role::findByName($request->role);
            $users = User::role($role->name)->get();
            $reminder->users()->sync($users->pluck('id')->toArray());
        } else {
            $reminder->update($request->all());
        }
        return redirect()->back()->with('success', 'Reminder updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        $reminder->users()->detach();
        $reminder->delete();
        return response()->json(true);
    }
}
