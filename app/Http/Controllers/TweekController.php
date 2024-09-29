<?php

namespace App\Http\Controllers;

use App\Models\Tweek;
use Illuminate\Http\Request;

class TweekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tweeks = Tweek::all();
        return view('dashboard.tweek.index', compact('tweeks'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweek $tweek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweek $tweek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweek $tweek)
    {
        $tweek->value = $request->input('value');
        $tweek->save();
        dd($request->file('media') );
        if (count($request->media) > 0) {
            foreach ($request->file('media') as $file) {
                dd($file);
                $tweek->addMedia($file)->toMediaCollection();
            }
        }        
        return redirect()->back()->with('success', 'Tweek updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweek $tweek)
    {
        //
    }
}
