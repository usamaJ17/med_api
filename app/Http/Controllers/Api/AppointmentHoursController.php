<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppointmentHours;
use Illuminate\Http\Request;

class AppointmentHoursController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'appointment_type' => 'required|string',
            'consultation_fees' => 'required|string',
        ]);
        // add user_id to validated data
        $validatedData['duration'] = $request->duration;
        $validatedData['user_id'] = auth()->id();
        $validatedData['working_hours'] = json_decode($request->working_hours, true);
        // if a user has already created an appointment with the same appointment type and duration then update the appointment hours
        $appointment = AppointmentHours::query()->where('user_id', auth()->id())
            ->where('appointment_type', $request->appointment_type)
            ->first();
        if ($appointment) {
            $appointment->update($validatedData);
            $data = [
                'status' => 200,
                'message' => 'Appointment hours updated successfully',
                'data' => $appointment,
            ];
            return response()->json($data, 200);
        }
        $appointment = AppointmentHours::create($validatedData);
        $data = [
            'status' => 201,
            'message' => 'Appointment hours created successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 201);
    }

    public function show(Request $request)
    {
        $appointment = AppointmentHours::query()->where('user_id', auth()->id());
        if ($request->has('appointment_type')) {
            $appointment->where('appointment_type', $request->appointment_type);
        }
        if($request->has('duration')){
            $appointment->where('duration',$request->duration);
        }
        $appointment = $appointment->get();
        $data = [
            'status' => 200,
            'message' => 'Schedule fetched successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 200);
    }
    public function checkAvailability(Request $request){
        $appointment = AppointmentHours::query()->where('user_id', $request->professional_id);
        if ($request->has('appointment_type')) {
            $appointment->where('appointment_type', $request->appointment_type);
        }
        if($request->has('duration')){
            $appointment->where('duration',$request->duration);
        }
        $appointment = $appointment->get();
        $data = [
            'status' => 200,
            'message' => 'Schedule fetched successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 200);   
    }
}
