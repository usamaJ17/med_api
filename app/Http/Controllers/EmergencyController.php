<?php

namespace App\Http\Controllers;

use App\Models\EmergencyHelp;
use App\Models\User;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $emer = EmergencyHelp::query();
        if(isset($request->user_id) && $request->user_id != null){
            $emer->where('user_id',$request->user_id);
        }else{
            $emer->where('status','requested');
        }
        $emer = $emer->get();
        return response()->json([
            'status' => 200,
            'message'=> 'Emergency Requests Fetched Successfully...',
            'data'   => $emer,
        ], 200);
    }
    public function simple(){
        $emer = EmergencyHelp::where('is_mid_night', 0)->get();
        return view('dashboard.emergencyhelp.simple')->with(compact('emer'));
    }
    public function midNight(){
        $emer = EmergencyHelp::where('is_mid_night', 1)->get();
        return view('dashboard.emergencyhelp.midnight')->with(compact('emer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $emer = EmergencyHelp::create([
            'user_id' => 7,
            'emergency_type' => $request->emergency_type,
            'requested_at' => now(),
            'is_mid_night' => $request->is_mid_night,
            'description' => $request->description,
            'description' => $request->duration,
            'description' => $request->method,
            'description' => $request->amount,
        ]);
        $professionals = User::query();
        $professionals->whereHas("roles", function($q){ $q->where("name", "medical"); });
        if(isset($request->is_mid_night) && $request->is_mid_night == 1){
            $professionals->where('can_night_emergency',1);
        }else{
            $professionals->where('can_emergency',1);
        }
        $professionals = $professionals->get(['id','device_token'])->toArray();
        $data = [];
        foreach($professionals as $professional){
            $data[] = [
                'med_id' => $professional['id'],
                'device_token' => $professional['device_token'],
            ];
        }
        $res_data = [
            'professionals'   => $data,
            'emergency_request_id' => $emer->id,
        ];
        return response()->json([
            'status' => 200,
            'message'=> 'Emergency Request Sent Successfully...',
            'data'   => $res_data,            
        ], 200);        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $emer = EmergencyHelp::find($id);
        $emer->status = "answered";
        $emer->med_id = $request->med_id;
        $emer->save();
        return response()->json([
            'status' => 200,
            'message'=> 'Emergency Request Updated Successfully...',
            'data'   => $emer,            
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        EmergencyHelp::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message'=> 'Emergency Request Deleted Successfully...',
        ], 200);
    }
    public function getEmergencyProfessionals(Request $request){
        $professionals = User::query();
        $professionals->whereHas("roles", function($q){ $q->where("name", "medical"); });
        if(isset($request->midnight) && $request->midnight == 1){
            $professionals->where('can_night_emergency',1);
        }else{
            $professionals->where('can_emergency',1);
        }
        $professionals = $professionals->get(['id','device_token'])->toArray();
        return response()->json([
            'status' => 200,
            'message'=> 'Professionals Fetched Successfully...',
            'data'   => $professionals,
        ], 200);
    }
}
