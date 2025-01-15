<?php

namespace App\Http\Controllers;

use App\Models\Tweek;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
         if ($request->hasFile('media') && is_array($request->file('media'))) {
             foreach ($request->file('media') as $file) {
                 $tweek->clearMediaCollection();
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
    public function getApiData(Request $request){
        $tweaks = Tweek::where('type', ucwords(str_replace('_', ' ', $request->type)))->get();
        if($tweaks->count() > 0){
            $tweaks = $tweaks->map(function ($tweek) {
                return [
                    'id' => $tweek->id,
                    'type' => $tweek->type,
                    'value' => $tweek->value,
                    'media' => $tweek->getAllMedia(),
                ];
            });
            $data = [
                'status' => 200,
                'message' => 'Tweek fetched successfully',
                'data' => $tweaks
            ];
        }else{
            $data = [
                'status' => 404,
                'message' => 'Tweek not found',
            ];
        }

        return response()->json($data);
    }
}
