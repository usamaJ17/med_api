<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'med_id' => 'required|integer',
            'appointment_type' => 'required|string',
            'appointment_time' => 'required',
            'appointment_date' => 'required',
        ]);
        $request->merge([
            'user_id' => auth()->id(),
        ]);
        $appointment = Appointment::create($request->all());
        dd($appointment);
        $data = [
            'status' => 201,
            'message' => 'Appointment created successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 201);    
    }
    public function get(Request $request){
        $appointments = Appointment::query()->where('user_id', auth()->id());
        if($request->has('appointment_date')){
            $appointments->where('appointment_date', $request->appointment_date);
        }
        if($request->has('appointment_type')){
            $appointments->where('appointment_type', $request->appointment_type);
        }
        if($request->has('med_id')){
            $appointments->where('med_id', $request->med_id);
        }
        if($request->has('appointment_date_from') && $request->has('appointment_date_to')){
            $appointments->whereBetween('appointment_date', [$request->appointment_date_from, $request->appointment_date_to]);
        }
        if($request->has('appointment_date_from') && !$request->has('appointment_date_to')){
            $appointments->where('appointment_date', '>=', $request->appointment_date_from);
        }
        if($request->has('appointment_date_to') && !$request->has('appointment_date_from')){
            $appointments->where('appointment_date', '<=', $request->appointment_date_to);
        }
        if($request->has('status')){
            $appointments->where('status', $request->status);
        }
        $appointments = $appointments->get();
        $data = [
            'status' => 200,
            'message' => 'Appointments fetched successfully',
            'data' => $appointments,
        ];
        return response()->json($data, 200);
    }
    public function changeStatus(Request $request ,$id){
        $appointment = Appointment::query()->where('id', $id)->first();
        if(!$appointment){
            return response()->json([
                'status' => 404,
                'message' => 'Appointment not found',
            ], 404);
        }
        $appointment->status = $request->status;
        $appointment->save();
        $data = [
            'status' => 200,
            'message' => 'Appointment status changed successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 200);
    }
    public function getMyPatientsAppointments(Request $request){
        $appointments = Appointment::query()->where('med_id', auth()->id());
        if($request->has('appointment_date')){
            $appointments->where('appointment_date', $request->appointment_date);
        }
        if($request->has('appointment_type')){
            $appointments->where('appointment_type', $request->appointment_type);
        }
        if($request->has('user_id')){
            $appointments->where('user_id', $request->user_id);
        }
        if($request->has('appointment_date_from') && $request->has('appointment_date_to')){
            $appointments->whereBetween('appointment_date', [$request->appointment_date_from, $request->appointment_date_to]);
        }
        if($request->has('appointment_date_from') && !$request->has('appointment_date_to')){
            $appointments->where('appointment_date', '>=', $request->appointment_date_from);
        }
        if($request->has('appointment_date_to') && !$request->has('appointment_date_from')){
            $appointments->where('appointment_date', '<=', $request->appointment_date_to);
        }
        if($request->has('status')){
            $appointments->where('status', $request->status);
        }
        $appointments = $appointments->get();
        $data = [
            'status' => 200,
            'message' => 'Appointments fetched successfully',
            'data' => $appointments,
        ];
        return response()->json($data, 200);
    }
    public function getMyPatientsList(Request $request){
        $appointments = Appointment::where('med_id', auth()->user()->id)
        // ->with('user')
        ->orderBy('appointment_date', 'desc')
        ->get()
        ->groupBy('user_id');

        $results = [];

        foreach ($appointments as $userId => $userAppointments) {
            // Get the latest appointment where the appointment is completed
            $latestCompletedAppointment = $userAppointments->where('status', 'completed')->first();
            if(!$latestCompletedAppointment) {
                $latestCompletedAppointment = $userAppointments->first();
            }
            $latestAppointment = $userAppointments->first();
            $isOldPatient = $userAppointments->count() > 1;
            dd($latestAppointment , $userAppointments );

            // Prepare the result array
            $results[] = [
                'patient_id' => $userId,
                'patient_name' => $latestAppointment->patient_name,
                'last_appointment_date' => $latestAppointment->appointment_date,
                'gender' => $latestAppointment->gender,
                'age' => $latestAppointment->age,
                'diagnosis' => $latestCompletedAppointment->diagnosis,
                'status' => $userAppointments->patient_status
            ];
        }
        $data = [
            'status' => 200,
            'message' => 'Patients fetched successfully',
            'data' => $results,
        ];
        return response()->json($data, 200);
    }

}