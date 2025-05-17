<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppointmentHours;
use Illuminate\Http\Request;

class AppointmentHoursController extends Controller
{
    public function store(Request $request){
        $validator = \Validator::make($request->all(), [
            'appointment_type' => 'required|string|in:video,audio,chat',
            'duration' => 'nullable|string',
            'working_hours' => 'nullable|string',
            'consultation_fees' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
            'status' => 422,
            'errors' => $validator->errors(),
            ], 422);
        }
    
        $validatedData = $validator->validated();
        $validatedData['user_id'] = auth()->id();
        $validatedData['working_hours'] = json_decode($request->working_hours, true);
        $appointment = AppointmentHours::query()
            ->where('user_id', auth()->id())
            ->where('appointment_type', $validatedData['appointment_type'])
            ->first();

        if ($appointment) {
            if ($request->has('working_hours')) {
                $validatedData['working_hours'] = json_decode($request->working_hours, true);
            } else {
                $validatedData['working_hours'] = $appointment->working_hours;
            }
            if ($request->has('consultation_fees')) {
                $validatedData['consultation_fees'] = $request->consultation_fees;
            } else {
                $validatedData['consultation_fees'] = $appointment->consultation_fees;
            }
            if ($request->has('duration')) {
                $validatedData['duration'] = $request->duration;
            } else {
                $validatedData['duration'] = $appointment->duration;
            }
            $appointment->update($validatedData);
            return response()->json([
                'status' => 200,
                'message' => 'Appointment hours updated successfully',
                'data' => $appointment,
            ], 200);
        }
        $appointment = AppointmentHours::create($validatedData);
        return response()->json([
            'status' => 201,
            'message' => 'Appointment hours created successfully',
            'data' => $appointment,
        ], 200);
    }


    public function show(Request $request)
    {
        $appointment = AppointmentHours::query()->where('user_id', auth()->id());
        if ($request->has('appointment_type')) {
            $appointment->where('appointment_type', $request->appointment_type);
        }
        if ($request->has('duration')) {
            $appointment->where('duration', $request->duration);
        }
        $appointment = $appointment->get();
        $data = [
            'status' => 200,
            'message' => 'Schedule fetched successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 200);
    }
    public function checkAvailability(Request $request)
    {
        $appointment = AppointmentHours::query()->where('user_id', $request->professional_id);
        if ($request->has('appointment_type')) {
            $appointment->where('appointment_type', $request->appointment_type);
        }
        if ($request->has('duration')) {
            $appointment->where('duration', $request->duration);
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
