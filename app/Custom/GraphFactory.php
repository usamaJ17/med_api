<?php

namespace App\Custom;

use App\Models\Appointment;
use App\Models\ProfessionalType;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Models\UserFeedback;
use Carbon\Carbon;

class GraphFactory
{
    protected $startDate;
    protected $endDate;
    protected $user_id;
    protected $role;

    public function __construct($start = null, $end = null, $user_id = null,$role = null)
    {
        $this->initializeDates($start, $end);
        $this->user_id = $user_id;
        $this->role = $role;
    }

    protected function initializeDates($start, $end)
    {
        if ($end) {
            $this->endDate = Carbon::parse($end);
        } else {
            $this->endDate = Carbon::now();
        }
        if ($start) {
            $this->startDate = Carbon::parse($start);
        } else {
            $this->startDate = $this->endDate->copy()->subDays(14);
        }
    }

    public function getGraphData(string $type)
    {
        // Reinitialize the date range to ensure each call is independent
        $this->initializeDates($this->startDate, $this->endDate);

        $formattedDates = [];
        $data = [];

        if ($type == 'pro_cat_appointments') {
            $data_cus = $this->getProCatAppointments();
            return [
                'date' => $data_cus[0],
                'data' => $data_cus[1],
            ];
        }else if($type == 'age'){
            return $this->getAgeData();
        } 
        elseif ($type==='patient_signups_states') {
            $patientData = [];
            $patientDates = [];
            $distinctStates = User::distinct()->pluck('state')->filter();
            for ($date = $this->startDate->copy(); $date->lte($this->endDate); $date->addDay()) {
                $formattedDate = $date->format('d M');
                foreach ($distinctStates as $state) {
                    $data = $this->getDataByType($type, $date, $state); 
                    $patientData[] = [
                        'date' => $formattedDate,
                        'state' => $state,
                        'value' => $data, 
                    ];
                }
                $patientDates[] = $formattedDate;
            }
            return [
                'date' => $patientDates,
                'data' => $patientData,
            ];
        } elseif ($type==='medical_signups_states') {
            $medicalData = [];
            $medicalDates = [];
            $distinctStates = User::distinct()->pluck('state')->filter();
            for ($date = $this->startDate->copy(); $date->lte($this->endDate); $date->addDay()) {
                $formattedDate = $date->format('d M');
                foreach ($distinctStates as $state) {
                    $data = $this->getDataByType($type, $date, $state);
                    $medicalData[] = [
                        'date' => $formattedDate,
                        'state' => $state,
                        'value' => $data, 
                    ];
                }
                $medicalDates[] = $formattedDate;
            }
            return [
                'date' => $medicalDates,
                'data' => $medicalData,
            ];
        } 
        elseif ($type==='appointment_state_overview') {
            $medicalData = [];
            $medicalDates = [];
            $distinctStates = User::distinct()->pluck('state')->filter();
            for ($date = $this->startDate->copy(); $date->lte($this->endDate); $date->addDay()) {
                $formattedDate = $date->format('d M');
                foreach ($distinctStates as $state) {
                    $data = $this->getDataByType($type, $date, $state);
                    $medicalData[] = [
                        'date' => $formattedDate,
                        'state' => $state,
                        'value' => $data, 
                    ];
                }
                $medicalDates[] = $formattedDate;
            }
            return [
                'date' => $medicalDates,
                'data' => $medicalData,
            ];
        }else {
            for ($date = $this->startDate->copy(); $date->lte($this->endDate); $date->addDay()) {
                $formattedDates[] = $date->format('d M');
                $data[] = $this->getDataByType($type, $date);
            }

            return [
                'date' => $formattedDates,
                'data' => $data,
            ];
        }
    }

    protected function getDataByType(string $type, $date, $state = null)
    {
        switch ($type) {
            case 'patient_signups':
                return $this->getPatientSignups($date);
            case 'medical_signups':
                return $this->getMedicalSignups($date);
            case 'patient_signups_states':
                return $this->getPatientSignupsByState($date, $state);
            case 'medical_signups_states':
                return $this->getMedicalSignupsByState($date, $state);
            case 'appointment_state_overview':
                return $this->getAppointmentByState($date, $state);
            case 'revenue':
                return $this->getDailyRevenue($date);
            case 'appointments':
                return $this->getAppointmentData($date);
            case 'cancel_appointments':
                return $this->getCancelAppointmentData($date);
            case 'user_feedback':
                return $this->getUserFeedbackData($date);
            default:
                throw new \Exception("Invalid graph type : ". $type);
        }
    }

    protected function getPatientSignups($date)
    {
        return User::whereHas("roles", function ($q) {
            $q->where("name", "patient");
        })->whereDate('created_at', $date->toDateString())->count();
    }

    protected function getMedicalSignups($date)
    {
        return User::whereHas("roles", function ($q) {
            $q->where("name", "medical");
        })->whereDate('created_at', $date->toDateString())->count();
    }
    protected function getPatientSignupsByState($date, $state)
    {
        return User::whereHas("roles", function ($q) {
                $q->where("name", "patient");
            })
            ->whereDate('created_at', $date->toDateString())
            ->where('state', $state)
            ->count();
    }
    protected function getAppointmentByState($date, $state)
    {
        return  Appointment::whereHas("user", function ($q) use ($state) {
                    $q->where("state", $state);
                })
                ->whereDate('created_at', $date->toDateString())
                ->count();
    }
    
    protected function getMedicalSignupsByState($date, $state)
    {
        return User::whereHas("roles", function ($q) {
                $q->where("name", "medical");
            })
            ->whereDate('created_at', $date->toDateString())
            ->where('state', $state)
            ->count(); 
    }
    
    protected function getDailyRevenue($date)
    {
        return TransactionHistory::whereDate('transaction_date', $date->toDateString())->sum('transaction_amount');
    }

    protected function getAppointmentData($date)
    {
        $app =  Appointment::query();
        if($this->user_id != null){
            if($this->role != null && $this->role == "patient"){
                $app =  $app->where('user_id', $this->user_id);
            }else{
                $app = $app->where('med_id', $this->user_id);
            }
        }
        $app =  $app->whereDate('appointment_date', $date->toDateString())->where('status', "!=" ,'cancelled')->count();
        return $app;
    }

    protected function getCancelAppointmentData($date)
    {
        $app =  Appointment::query();
        if($this->user_id != null){
            if($this->role != null && $this->role == "patient"){
                $app =  $app->where('user_id', $this->user_id);
            }else{
                $app = $app->where('med_id', $this->user_id);
            }
        }
        $app =  $app->whereDate('appointment_date', $date->toDateString())->where('status', 'cancelled')->count();
        return $app;
    }
    protected function getUserFeedbackData($date){
        $feedback = UserFeedback::where('created_at', $date->toDateString());
        $data = [
            'count' => $feedback->count(),
            'average_rating' => $feedback->avg('rating')
        ];
        return $data;
    }

    protected function getAgeData()
    {
        $ageGroups = [
            '0-5' => [0, 5],
            '5-10' => [5, 10],
            '10-15' => [10, 15],
            '15-20' => [15, 20],
            '20-25' => [20, 25],
            '25-30' => [25, 30],
            '30-35' => [30, 35],
            '35-40' => [35, 40],
            '40-45' => [40, 45],
            '45-50' => [45, 50],
            '50-55' => [50, 55],
            '55-60' => [55, 60],
            '60-65' => [60, 65],
            '65-70' => [65, 70],
            '70-75' => [70, 75],
            '75-80' => [75, 80],
            '80-85' => [80, 85],
            '85-90' => [85, 90],
            '90-95' => [90, 95],
            '95-100' => [95, 100],
        ];

        $age = [];
        foreach ($ageGroups as $groupName => $range) {
            $age[$groupName] = [];
        }

        $users = User::whereNotNull('dob')->get();

        foreach ($users as $user) {
            $userAge = Carbon::parse($user->dob)->age;
            foreach ($ageGroups as $groupName => $range) {
                if ($userAge >= $range[0] && $userAge < $range[1]) {
                    $age[$groupName][] = $user;
                    break;
                }
            }
        }

        foreach ($age as $groupName => $users) {
            $age[$groupName] = count($users);
        }

        return $age;
    }

    protected function getProCatAppointments()
    {
        $pro_cat_appointment = [];
        $formattedDates = [];

        for ($date = $this->startDate->copy(); $date->lte($this->endDate); $date->addDay()) {
            $formattedDates[] = $date->format('d M');
            $categories = ProfessionalType::all();
            foreach ($categories as $cat) {
                $catUsers = User::where('professional_type_id', $cat->id)->pluck('id')->toArray();
                $count = Appointment::whereIn('med_id', $catUsers)->whereDate('appointment_date', $date->toDateString())->count();
                $pro_cat_appointment[$cat->name][] = $count;
            }
        }

        return [
            $formattedDates,
            $pro_cat_appointment,
        ];
    }
}
