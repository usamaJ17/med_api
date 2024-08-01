<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function login(){
        return view('dashboard.auth.login');
    }
    public function index(){

        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(14);
        $patientSignups = [];
        $medicalSignups = [];
        $formattedDates = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dailyPatientCount = User::whereHas("roles", function($q) {
                $q->where("name", "patient");
            })->whereDate('created_at', $date->toDateString())->count();
        
            $dailyMedicalCount = User::whereHas("roles", function($q) {
                $q->where("name", "medical");
            })->whereDate('created_at', $date->toDateString())->count();
        
            $patientSignups[] = $dailyPatientCount;
            $medicalSignups[] = $dailyMedicalCount;
            $formattedDates[] = $date->format('d M'); // Format date as '10 May', '11 May', etc.
        }

        $patients = User::whereHas("roles", function($q){ $q->where("name", "patient"); })->get();
        $medicals = User::whereHas("roles", function($q){ $q->where("name", "medical"); })->get();
        $appointments = Appointment::all();
        return view('dashboard.index')->with(compact('patients','medicals','appointments','patientSignups', 'medicalSignups','formattedDates'));
    }
}
