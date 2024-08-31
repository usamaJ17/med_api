<?php

namespace App\Http\Controllers;

use App\Custom\GraphFactory;
use App\Exports\ProfessionalsExport;
use App\Models\Appointment;
use App\Models\Article;
use App\Models\Payouts;
use App\Models\Review;
use App\Models\TransactionHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicals = User::whereHas("roles", function($q){ $q->where("name", "medical"); })->with('professionalDetails.professions','professionalDetails.ranks')->get();
        $fields = [];
        if($medicals->count() > 0){
            $fields = $medicals[0]->getAllProfessionalFields();
        }
        return view('dashboard.medicals.index', compact('medicals','fields'));
    }
    /**
     * Display a listing of the resource.
     */
    public function verification_requests()
    {
        $medicals = User::whereHas("roles", function($q){ $q->where("name", "medical"); })->where('verification_requested_at','!=',null)->with('professionalDetails.professions','professionalDetails.ranks')->get();
        return view('dashboard.medicals.verification_request', compact('medicals'));
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
        $medical = User::whereHas("roles", function($q){ $q->where("name", "medical"); })->with('professionalDetails.professions','professionalDetails.ranks')->find($id);
        $payouts = Payouts::where('user_id',$id)->get();
        $appointment = Appointment::where('med_id',$id)->get();
        $endDate = Carbon::now()->addDay();
        $formattedDates = [];
        $total_monthly_revenue = [];
        $startDate = $endDate->copy()->subDays(14);
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dailyrevinue = TransactionHistory::where('user_id', $id)->whereDate('transaction_date', $date->toDateString())->sum('transaction_amount');
            $total_monthly_revenue[] = $dailyrevinue;
            $formattedDates[] = $date->format('d M'); 

        }
        if($medical){
            $docs = $medical->GetAllMedia() ?? [];
            $startDate = Carbon::now()->subDays(14);
            $endDate = Carbon::now()->addDay();
            $total_revenue = TransactionHistory::where('user_id',$id)->sum('transaction_amount');
            $graphFactory = new GraphFactory($startDate, $endDate, $id);
            $appointmentData = $graphFactory->getGraphData('appointments');
            $cancelAppointmentData = $graphFactory->getGraphData('cancel_appointments');
            $atricals_count = Article::where('user_id',$id)->count();
            $uniq_cus = Appointment::where('med_id',$id)->distinct('user_id')->count();
            $tot_app = Appointment::where('med_id',$id)->count();
            $reviews = Review::where('med_id',$id)->get();
            return view('dashboard.medicals.show', compact('medical','docs','reviews','payouts','tot_app','appointment','uniq_cus','atricals_count','total_revenue','formattedDates','cancelAppointmentData','appointmentData','total_monthly_revenue'));
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
        //
    }

    /**
     * Export in excel
     */
    public function export(Request $request)
    {
        return Excel::download(new ProfessionalsExport($request->all()), 'Professional.xlsx');
    }
    public function completeVerification(Request $request){
        $medical = User::find($request->id);
        $medical->is_verified = $request->status;
        $medical->save();
        return response()->json(true);
    }
    public function emergencyStatus(Request $request){
        $medical = User::find($request->id);
        $medical->can_emergency = $request->can_emergency;
        $medical->save();
        return response()->json(true);
    }
    public function nightEmergencyStatus(Request $request){
        $medical = User::find($request->id);
        $medical->can_night_emergency = $request->can_night_emergency;
        $medical->save();
        return response()->json(true);
    }
}
