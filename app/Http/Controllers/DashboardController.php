<?php

namespace App\Http\Controllers;

use App\Custom\GraphFactory;
use App\Models\Appointment;
use App\Models\ProfessionalType;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Models\UserFeedback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function login()
    {
        return view('dashboard.auth.login');
    }
    public function index()
    {

        $startDate = Carbon::create(2024, 8, 1); // Sets the date to August 1st, 2024
        $endDate = Carbon::now()->addDay();

        $graphFactory = new GraphFactory($startDate, $endDate);
        $patientSignups = $graphFactory->getGraphData('patient_signups');
        $medicalSignups = $graphFactory->getGraphData('medical_signups');

        $patientSignupsStates = $graphFactory->getGraphData('patient_signups_states');
        $medicalSignupsStates = $graphFactory->getGraphData('medical_signups_states');

        $appointmentData = $graphFactory->getGraphData('appointments');
        $cancelAppointmentData = $graphFactory->getGraphData('cancel_appointments');
        $pro_cat_appointment = $graphFactory->getGraphData('pro_cat_appointments');
        $total_monthly_revenue = $graphFactory->getGraphData('revenue');

        $appointment_state_overview = $graphFactory->getGraphData('appointment_state_overview');

        $age = $graphFactory->getGraphData('age');
        $dailyPatientCountCat = [];
        $professionalCounts = User::whereHas("roles", function ($q) {
            $q->where("name", "medical");
        })
            ->whereBetween('created_at', [$startDate, $endDate]) // Filter users created within the last 15 days
            ->select('professional_type_id', DB::raw('count(*) as count'))
            ->groupBy('professional_type_id')
            ->get();
        foreach ($professionalCounts as $count) {
            $dailyPatientCountCat[$count->professional_type_name] = $count->count;
        }

        $total_revenue = TransactionHistory::sum('transaction_amount');
        $patients = User::whereHas("roles", function ($q) {
            $q->where("name", "patient");
        })->get();
        $medicals = User::whereHas("roles", function ($q) {
            $q->where("name", "medical");
        })->get();
        $appointments = Appointment::all();
        $threeDaysAgo = Carbon::now()->subDays(30);
        $result = Appointment::where('status', '!=', 'cancelled')
            ->where('appointment_date', '>=', $threeDaysAgo)
            ->select('med_id', DB::raw('count(*) as appointment_count'))
            ->groupBy('med_id')
            ->orderByDesc('appointment_count')
            ->first();

        // Extract the med_id and count
        $medIdWithMaxAppointments = $result->med_id ?? null;
        $maxDoc = User::find($medIdWithMaxAppointments);
        if(! $maxDoc){
            $maxDoc = User::whereHas("roles", function ($q) {
                $q->where("name", "medical");
            })->inRandomOrder()->get();
        }
        $maxAppointmentCount = $result->appointment_count ?? 0;
        return view('dashboard.index')->with(compact('appointment_state_overview', 'patientSignupsStates', 'medicalSignupsStates', 'patients', 'medicals','maxDoc','maxAppointmentCount', 'age', 'appointments', 'patientSignups', 'dailyPatientCountCat', 'total_revenue', 'total_monthly_revenue', 'medicalSignups', 'appointmentData', 'cancelAppointmentData', 'pro_cat_appointment'));
    }
    public function userFeedback(){
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now()->addDay();
        $graphFactory = new GraphFactory($startDate, $endDate);
        $userFeedback = $graphFactory->getGraphData('user_feedback');
        $userFeedbackData = UserFeedback::all();
        return view('dashboard.feedback')->with(compact('userFeedback','userFeedbackData'));
    }
}
