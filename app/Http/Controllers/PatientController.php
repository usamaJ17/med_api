<?php

namespace App\Http\Controllers;

use App\Custom\GraphFactory;
use App\Models\Appointment;
use App\Models\Payouts;
use App\Models\TransactionHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = User::whereHas("roles", function($q){ $q->where("name", "patient"); })->with('wallet')->get();
        return view('dashboard.patients.index', compact('patients'));
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
        $patient = User::whereHas("roles", function($q){ $q->where("name", "patient"); })->with('professionalDetails.professions','professionalDetails.ranks')->find($id);
        $appointment = Appointment::where('user_id',$id)->get();
        if($patient){
            $startDate = Carbon::now()->subDays(14);
            $endDate = Carbon::now()->addDay();
            $graphFactory = new GraphFactory($startDate, $endDate, $id, "patient");
            $appointmentData = $graphFactory->getGraphData('appointments');
            $cancelAppointmentData = $graphFactory->getGraphData('cancel_appointments');
            // $uniq_cus = Appointment::where('med_id',$id)->distinct('user_id')->count();
            // $tot_app = Appointment::where('med_id',$id)->count();
            // $reviews = Review::where('med_id',$id)->get();
            return view('dashboard.patients.show', compact('patient','appointment','cancelAppointmentData','appointmentData'));
        }else{
            return redirect()->back()->with('error', 'Medical not found');
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(true);
    }
}
