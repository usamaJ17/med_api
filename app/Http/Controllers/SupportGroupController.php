<?php

namespace App\Http\Controllers;

use App\Models\SupportGroup;
use Illuminate\Http\Request;

class SupportGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groups = SupportGroup::all();
        if($request->ajax()){
            $data = [
                'status' => 200,
                'message' => 'All Support Groups fetched successfully',
                'data' => $groups,
            ];
            return response()->json($data, 200);   
        }
        return view('dashboard.support_groups.index', compact('groups'));
    }
    public function forApi(Request $request){
        $groups = SupportGroup::query();
        if(isset($request->type) && $request->type != null){
            $groups = $groups->where('type', $request->type);
        }
        $groups = $groups->get();
        $data = [
            'status' => 200,
            'message' => 'All Support Groups fetched successfully',
            'data' => $groups,
        ];
        return response()->json($data, 200);
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
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'url' => 'required|string',
        ]);
        SupportGroup::create($request->all());
        return redirect()->back()->with('success', 'Support Group created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportGroup $supportGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportGroup $supportGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupportGroup $supportGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportGroup $supportGroup)
    {
        $supportGroup->delete();
        return response()->json(true);
        // return redirect()->back()->with('success', 'Support Group deleted successfully');
    }
}
