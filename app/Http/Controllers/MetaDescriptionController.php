<?php

namespace App\Http\Controllers;

use App\Models\MetaDescription;
use App\Models\Tweek;
use Illuminate\Http\Request;

class MetaDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $descriptions = MetaDescription::all();
        return view('dashboard.descriptions.index', compact('descriptions'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MetaDescription $description)
    {
        $description->description = $request->input('description');
        $description->save();
        return redirect()->back()->with('success', 'Description updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getApiData($page_uid){
        $description = MetaDescription::where('uid', $page_uid)->first();
        if($description){
            $data = [
                'status' => 200,
                'message' => 'Description fetched successfully',
                'data' => $description->description
            ];
        }else{
            $data = [
                'status' => 404,
                'data' => null,
                'message' => 'Description not found',
            ];
        }
        return response()->json($data);
    }
}
