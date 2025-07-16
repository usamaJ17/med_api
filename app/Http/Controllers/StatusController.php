<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    //

    public function index()
    {
        $statuses = Status::all();
        return view('dashboard.status.index', compact('statuses'));
    }

    public function create()
    {
        return view('dashboard.status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,mkv,webm|max:10240',
            'caption' => 'required|string|max:1000',
        ]);

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filePath = $file->store('uploads', 'public');
        } else {
            return back()->withErrors(['file_path' => 'Status upload failed.'])->withInput();
        }

        Status::create([
            'user_id' => auth()->id(),
            'file_path' => $filePath,
            'caption' => $request->caption,
        ]);

        return back()->with('success', 'Status uploaded successfully!');
    }

    public function edit($id)
    {
        $status = Status::findOrFail($id);
        return view('dashboard.status.edit', compact('status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,mkv,webm|max:10240',
            'caption' => 'required|string|max:255',
        ]);

        try {
            $status = Status::findOrFail($id);

            if ($request->hasFile('file_path')) {
                if ($status->file_path && file_exists(public_path('files/' . $status->file_path))) {
                    unlink(public_path('files/' . $status->file_path));
                }

                $newFile = $request->file('file_path');
                $newFileName = time() . '_' . $newFile->getClientOriginalName();
                $newFile->move(public_path('files'), $newFileName);

                $status->file_path = $newFileName;
            }

            $status->caption = $request->caption;
            $status->save();

            return redirect()->route('status.index')->with('success', 'Status updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update status.');
        }
    }

    public function destroy($id)
    {
        try {
            $status = Status::findOrFail($id);

            $status->views()->delete();
            $status->reactions()->delete();
            $status->delete();

            return redirect()->back()->with('success', 'Status deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete status');
        }
    }
}
