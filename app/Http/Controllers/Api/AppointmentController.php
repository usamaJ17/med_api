<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Review;
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
        $data = [
            'status' => 201,
            'message' => 'Appointment created successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 201);    
    }
    public function update(Request $request){
        $appointment = Appointment::query()->where('id', $request->appointment_id)->first();
        if(!$appointment){
            return response()->json([
                'status' => 404,
                'message' => 'Appointment not found',
            ], 404);
        }
        $request->merge([
            'status' => "upcoming",
        ]);
        // only update those fields which are present in the request
        $appointment->fill($request->all());
        $appointment->save();
        $data = [
            'status' => 200,
            'message' => 'Appointment updated successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 200);
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
    public function changePatientStatus(Request $request){
        $appointment = Appointment::query()->where('id', $request->appointment_id)->first();
        if(!$appointment){
            return response()->json([
                'status' => 404,
                'message' => 'Appointment not found',
            ], 404);
        }
        // change status of all appointments where user_id is the same as the user_id of the appointment
        $appointment->status = 'completed';
        $appointment->patient_status = $request->status;
        $appointment->save();
        $data = [
            'status' => 200,
            'message' => 'Appointment status changed successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 200);
    }
    public function changeStatus(Request $request){
        $appointment = Appointment::query()->where('id', $request->appointment_id)->first();
        if(!$appointment){
            return response()->json([
                'status' => 404,
                'message' => 'Appointment not found',
            ], 404);
        }
        // change status of all appointments where user_id is the same as the user_id of the appointment
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
            // check if atleast 1 user appointment is completed
            $status = 'In Progress';
            $total_count = $userAppointments->count();
            $completed_count = $userAppointments->where('status', 'completed')->count();
            if($completed_count == $total_count){
                if($userAppointments->where('patient_status', 'in_progress')->orWhere('patient_status', 'new_patient')->count() == 0){
                    $status = 'Recovered';
                }
            }else if($completed_count == 0){
                $status = 'New Patient';
            }
            $latestCompletedAppointment = $userAppointments->where('status', 'completed')->first();
            if(!$latestCompletedAppointment) {
                $latestCompletedAppointment = $userAppointments->first();
            }
            $latestAppointment = $userAppointments->first();

            // Prepare the result array
            $results[] = [
                'patient_id' => $userId,
                'patient_name' => $latestAppointment->patient_name,
                'last_appointment_date' => $latestAppointment->appointment_date,
                'gender' => $latestAppointment->gender,
                'age' => $latestAppointment->age,
                'diagnosis' => $latestCompletedAppointment->diagnosis,
                'status' => $status
            ];
        }
        $data = [
            'status' => 200,
            'message' => 'Patients fetched successfully',
            'data' => $results,
        ];
        return response()->json($data, 200);
    }
    public function addReview(Request $request){
        $review = Review::create($request->all());
        $data = [
            'status' => 200,
            'message' => 'Review added successfully',
            'data' => $review,
        ];
        return response()->json($data, 200);
    }
    public function updateReview(Request $request){
        $review = Review::where('id', $request->review_id)->first();
        if(!$review){
            return response()->json([
                'status' => 404,
                'message' => 'Review not found',
            ], 404);
        }else{
            $review->fill($request->all());
            $review->save();
            $data = [
                'status' => 200,
                'message' => 'Review updated successfully',
                'data' => $review,
            ];
            return response()->json($data, 200);
        
        }
    }
    public function getReview(Request $request){
        $reviews = Review::query();
        if(isset($request->med_id)){
            $reviews->where('med_id', $request->med_id);
        }
        if(isset($request->user_id)){
            $reviews->where('user_id', $request->user_id);
        }
        if(isset($request->appointment_id)){
            $reviews->where('appointment_id', $request->appointment_id);
        }
        $reviews = $reviews->get();
        $data = [
            'status' => 200,
            'message' => 'Reviews fetched successfully',
            'data' => $reviews,
        ];
        return response()->json($data, 200);
    }

}