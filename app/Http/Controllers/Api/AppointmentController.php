<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentHours;
use App\Models\ChatBox;
use App\Models\ConsultationFee;
use App\Models\Review;
use App\Models\UserFeedback;
use App\Models\UserRefund;
use App\Models\PayForMeReceiptForPayee;
use App\Models\PayForMeReceiptForPayeeBeneficiary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AfterBookingAppointment;
use App\Mail\AfterBookingCancel;
use App\Mail\AppointmentCancelPatient;
use App\Mail\AppointmentBooking;
use App\Mail\PaymentReceipt;
use App\Mail\BeforeAppointment;
use App\Mail\HealthProfessionalCancelsAppointment;
use App\Mail\AppointmentCancel;
use App\Mail\AppointmentCompleted;
use App\Mail\BeforeAppointmentDoctor;
use App\Mail\AppointmentRescheduled;
use App\Mail\AfterConsultation;
use App\Mail\AfterAppointment;
use App\Models\Notifications;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function saveConsultationFee(Request $request){
        try {
            $validatedData = $request->validate([
                'consultation_type' => 'required|string',
                'fee' => 'required|string',
                'duration' => 'required|string',
            ]);
            $user = auth()->user();
            $consultationFee = ConsultationFee::firstOrNew(
                [
                    'consultation_type' => $validatedData['consultation_type'],
                    'user_id' => $user->id
                ]
            );
            $consultationFee->fee = $validatedData['fee'];
            $consultationFee->duration = $validatedData['duration'];
            $consultationFee->save();
            return response()->json([
                'status' => 200,
                'message' => 'Consultation fee updated successfully',
                'data' => $consultationFee
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 500,
                'error' => $ex->getMessage(),
            ], 500);
        }
    }

    // public function saveConsultationFee(Request $request)
    // {
    //     try {
    //         $validator = \Validator::make($request->all(), [
    //             'consultation_type' => 'required|string',
    //             'fee' => 'required|string',
    //             'duration' => 'required|string',
    //         ]);
        
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 422,
    //                 'errors' => $validator->errors(),
    //             ], 422);
    //         }
    //         $validatedData = $validator->validated();
    //         $user = auth()->user();
    //         $appointment = AppointmentHours::query()
    //             ->where('user_id', auth()->id())
    //             ->where('appointment_type', $validatedData['consultation_type'])
    //             ->first();
    //         if (!$appointment) {
    //             return response()->json(["status" => 404, "messge" => "No appointment found against this user", "data" => []]);
    //         }

    //         $consultationFee = ConsultationFee::where(["appointment_id" => $appointment->id, "consultation_type" => $request->consultation_type])->first();
    //         if (!$consultationFee) {
    //             $consultationFee = new ConsultationFee([
    //                 "consultation_type" => $request->consultation_type,
    //                 "appointment_id" => $appointment->id,
    //                 "user_id" => $user->id
    //             ]);
    //         }

    //         $consultationFee->fee = $request->fee;
    //         $consultationFee->duration = $request->duration;
    //         $consultationFee->save();
    //         return response()->json([
    //             "status" => 200,
    //             "message" => "Consultation updated successfully",
    //             "data" => $consultationFee
    //         ], 200);
    //     } catch (\Exception $ex) {
    //         return response()->json(["error" => $ex->getMessage()], 500);
    //     }
    // }
    public function getConsultationFee(Request $request){
        $consultationFee = ConsultationFee::where('user_id', $request->user_id)->get();
        if ($consultationFee) {
            $data = [
                'status' => 200,
                'message' => 'Consultation fee fetched successfully',
                'data' => $consultationFee,
            ];
        } else {
            $data = [
                'status' => 404,
                'message' => 'No consultation fee found for the specified user',
                'data' => null,
            ];
        }

        return response()->json($data, $data['status']);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'med_id' => 'required|integer',
            'appointment_type' => 'required|string',
            'appointment_time' => 'required',
            'appointment_date' => 'required',
        ]);
        // get 3 character code
        $code = rand(1111111, 9999999);
        $app = Appointment::where('appointment_code', $code)->first();
        while ($app) {
            $code = rand(1111111, 9999999);
            $app = Appointment::where('appointment_code', $code)->first();
        }
        $request->merge([
            'user_id' => auth()->id(),
            'appointment_code' => $code
        ]);
        $appointment = Appointment::create($request->all());   
        $user = auth()->user();
        $professional = User::find($request->med_id);    
        Mail::to([$user->email])
            ->send(new AfterBookingAppointment($professional->name_title . " " .$professional->first_name." ".$professional->last_name, $request->appointment_date,  $request->appointment_time, $request->appointment_type, $user->first_name." ".$user->last_name));
        Mail::to([$professional->email])
        ->send(new AppointmentBooking($professional->name_title . " " .$professional->first_name." ".$professional->last_name, $request->appointment_date,  $request->appointment_time, $request->age, $user->first_name." ".$user->last_name));
        $notificationData = [
            'title' => 'Appointment Created',
            'description' => "Exciting news, $professional->name_title $professional->first_name $professional->last_name! A new patient, $user->first_name $user->last_name, has booked an appointment with you on $request->appointment_date at $request->appointment_time. Your money is safe in our escrow account 🤗",
            'type' => 'Appointment',
            'from_user_id' => auth()->id(),
            'to_user_id' => $professional->id,
            'is_read' => 0,
        ];        
        Notifications::create($notificationData);
        $data = [
            'status' => 201,
            'message' => 'Appointment created successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 201);
    }
    public function update(Request $request)
    {
        $appointment = Appointment::query()->where('id', $request->appointment_id)->first();
        if (!$appointment) {
            return response()->json([
                'status' => 404,
                'message' => 'Appointment not found',
            ], 404);
        }
        $request->merge([
            'status' => "upcoming",
        ]);
        $originalDate = $appointment->appointment_date;
        $originalTime = $appointment->appointment_time;

        // only update those fields which are present in the request
        $appointment->fill($request->all());
        $appointment->save();
        if ($request->has('appointment_date') && $originalDate !== $appointment->appointment_date ||
            $request->has('appointment_time') && $originalTime !== $appointment->appointment_time) {
            // Send reschedule email
            $user = User::find($appointment->user_id);
            $professional = User::find($appointment->med_id);    
            if ($user && $professional) {
                $u_name = $user->first_name . " " . $user->last_name;
                $p_name = $professional->name_title . " " . $professional->first_name . " " . $professional->last_name;
    
                Mail::to($professional->email)->send(new AppointmentRescheduled(
                    $p_name,
                    $u_name,
                    $appointment->appointment_date,
                    $appointment->appointment_time
                ));
            }
            
            $notificationData = [
                'title' => 'Appointment Rescheduled',
                'description' => "📅 Appointment Rescheduled: $u_name has rescheduled their appointment to $appointment->appointment_date at $appointment->appointment_time. Please check your updated schedule. Thank you for your flexibility!",
                'type' => 'Appointment',
                'from_user_id' => auth()->id(),
                'to_user_id' => $appointment->med_id,
                'is_read' => 0,
            ];        
            Notifications::create($notificationData);
        }
        $data = [
            'status' => 200,
            'message' => 'Appointment updated successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 200);
    }
    public function get(Request $request)
    {
        $appointments = Appointment::query()->with('med')->where('user_id', auth()->id())->where('is_paid', 1);
        if ($request->has('appointment_date')) {
            $appointments->where('appointment_date', $request->appointment_date);
        }
        if ($request->has('appointment_type')) {
            $appointments->where('appointment_type', $request->appointment_type);
        }
        if ($request->has('med_id')) {
            $appointments->where('med_id', $request->med_id);
        }
        if ($request->has('appointment_date_from') && $request->has('appointment_date_to')) {
            $appointments->whereBetween('appointment_date', [$request->appointment_date_from, $request->appointment_date_to]);
        }
        if ($request->has('appointment_date_from') && !$request->has('appointment_date_to')) {
            $appointments->where('appointment_date', '>=', $request->appointment_date_from);
        }
        if ($request->has('appointment_date_to') && !$request->has('appointment_date_from')) {
            $appointments->where('appointment_date', '<=', $request->appointment_date_to);
        }
        if ($request->has('status')) {
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
    public function listAll()
    {
        $appointments = Appointment::all();
        return view('dashboard.appointments.index')->with(compact('appointments'));
    }
    public function getSubAccount(Request $request)
    {
        $appointments = Appointment::query()->where('sub_account_id', auth()->id())->where('is_paid', 1);
        if ($request->has('appointment_date')) {
            $appointments->where('appointment_date', $request->appointment_date);
        }
        if ($request->has('appointment_type')) {
            $appointments->where('appointment_type', $request->appointment_type);
        }
        if ($request->has('med_id')) {
            $appointments->where('med_id', $request->med_id);
        }
        if ($request->has('appointment_date_from') && $request->has('appointment_date_to')) {
            $appointments->whereBetween('appointment_date', [$request->appointment_date_from, $request->appointment_date_to]);
        }
        if ($request->has('appointment_date_from') && !$request->has('appointment_date_to')) {
            $appointments->where('appointment_date', '>=', $request->appointment_date_from);
        }
        if ($request->has('appointment_date_to') && !$request->has('appointment_date_from')) {
            $appointments->where('appointment_date', '<=', $request->appointment_date_to);
        }
        if ($request->has('status')) {
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
    public function changePatientStatus(Request $request)
    {
        $appointment = Appointment::query()->where('id', $request->appointment_id)->first();
        if (!$appointment) {
            return response()->json([
                'status' => 404,
                'message' => 'Appointment not found',
            ], 404);
        }
        // change status of all appointments where user_id is the same as the user_id of the appointment
        $appointment->status = 'completed';
        $appointment->patient_status = $request->status;
        if ($request->patient_status == 'cancelled') {
            
            $user = auth()->user();
            $professional = User::find($appointment->med_id);    
            Mail::to([$user->email])
            ->send(new AfterBookingCancel($professional->name_title . " " .$professional->first_name." ".$professional->last_name, $appointment->appointment_date,  $appointment->appointment_time, $appointment->appointment_type, $user->first_name." ".$user->last_name));
            
            $notificationData = [
                'title' => 'Appointment Canceled',
                'description' => "Your appointment with $professional->name_title $professional->first_name $professional->last_name has been successfully canceled and 100% refund issued. If you have any questions or need further assistance, please feel free to reach out to us via the app. Thanks",
                'type' => 'Appointment',
                'from_user_id' => auth()->id(),
                'to_user_id' => auth()->id(),
                'is_read' => 0,
            ];        
            Notifications::create($notificationData);

            Mail::to([$professional->email])
            ->send(new AppointmentCancelPatient($professional->name_title . " " .$professional->first_name." ".$professional->last_name,$appointment->appointment_date,  $appointment->appointment_time, $user->first_name." ".$user->last_name));
            
            $notificationData = [
                'title' => 'Appointment Canceled',
                'description' => "Appointment Update: $user->first_name $user->last_name has canceled their appointment on $appointment->appointment_date at $appointment->appointment_time. We apologize for any inconvenience and appreciate your understanding.",
                'type' => 'Appointment',
                'from_user_id' => auth()->id(),
                'to_user_id' => $professional->id,
                'is_read' => 0,
            ];        
            Notifications::create($notificationData);
            UserRefund::create(
                [
                    'user_id' => auth()->id(),
                    'appointment_id' => $appointment->id,
                    'amount' => $appointment->consultation_fees,
                    'gateway' => $request->refund_option ? $request->refund_option : null,
                ]
            );
        }
        $appointment->save();
        
        $data = [
            'status' => 200,
            'message' => 'Appointment status changed successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 200);
    }
    
    public function changeStatus(Request $request)
    {
        $appointment = Appointment::query()->where('id', $request->appointment_id)->first();
        if (!$appointment) {
            return response()->json([
                'status' => 404,
                'message' => 'Appointment not found',
            ], 404);
        }
        // change status of all appointments where user_id is the same as the user_id of the appointment
        $appointment->status = $request->status;
        $appointment->save();

        if ($appointment->status == 'completed') {
            $professional = auth()->user();
            $user = User::find($appointment->user_id);    
            Mail::to([$professional->email])
            ->send(new AppointmentCompleted($professional->name_title . " " .$professional->first_name." ".$professional->last_name,$user->first_name." ".$user->last_name));
            
            $notificationData = [
                'title' => 'Appointment Completed',
                'description' => "Great Job! Your consultation with $user->first_name $user->last_name is complete. Keep up the amazing care with follow-ups over the next 7 days. Your payment will be ready for withdrawal after that. Thank you for your dedication! 🚀",
                'type' => 'Appointment',
                'from_user_id' => auth()->id(),
                'to_user_id' => $appointment->med_id,
                'is_read' => 0,
            ];        
            Notifications::create($notificationData); 
        }

        if ($appointment->status == 'cancelled') {
            UserRefund::create(
                [
                    'user_id' => auth()->id(),
                    'appointment_id' => $appointment->id,
                    'amount' => $appointment->consultation_fees,
                    'gateway' => $request->refund_option ? $request->refund_option : null,
                ]
            );
            
            // $user = auth()->user();
            // $professional = User::find($appointment->med_id);    
            // Mail::to([$user->email])
            // ->send(new AfterBookingCancel($professional->first_name." ".$professional->last_name, $appointment->appointment_date,  $appointment->appointment_time, $appointment->appointment_type, $user->first_name." ".$user->last_name));
            
            // $notificationData = [
            //     'title' => 'Appointment Canceled',
            //     'description' => "Your appointment with $professional->first_name $professional->last_name has been successfully canceled and 100% refund issued. If you have any questions or need further assistance, please feel free to reach out to us via the app. Thanks",
            //     'type' => 'Appointment',
            //     'from_user_id' => auth()->id(),
            //     'to_user_id' => auth()->id(),
            //     'is_read' => 0,
            // ];        
            // Notifications::create($notificationData);

            // Mail::to([$professional->email])
            // ->send(new AppointmentCancelPatient($professional->first_name." ".$professional->last_name,$appointment->appointment_date,  $appointment->appointment_time, $user->first_name." ".$user->last_name));
            
            // $notificationData = [
            //     'title' => 'Appointment Canceled',
            //     'description' => "Appointment Update: $user->first_name $user->last_name has canceled their appointment on $appointment->appointment_date at $appointment->appointment_time. We apologize for any inconvenience and appreciate your understanding.",
            //     'type' => 'Appointment',
            //     'from_user_id' => auth()->id(),
            //     'to_user_id' => $professional->id,
            //     'is_read' => 0,
            // ];        
            // Notifications::create($notificationData);
        }
        $data = [
            'status' => 200,
            'message' => 'Appointment status changed successfully',
            'data' => $appointment,
        ];
        return response()->json($data, 200);
    }
    public function getMyPatientsAppointments(Request $request)
    {
        $appointments = Appointment::query()->with('user')->where('med_id', auth()->id())->where('is_paid', 1);
        if ($request->has('appointment_date')) {
            $appointments->where('appointment_date', $request->appointment_date);
        }
        if ($request->has('appointment_type')) {
            $appointments->where('appointment_type', $request->appointment_type);
        }
        if ($request->has('user_id')) {
            $appointments->where('user_id', $request->user_id);
        }
        if ($request->has('appointment_date_from') && $request->has('appointment_date_to')) {
            $appointments->whereBetween('appointment_date', [$request->appointment_date_from, $request->appointment_date_to]);
        }
        if ($request->has('appointment_date_from') && !$request->has('appointment_date_to')) {
            $appointments->where('appointment_date', '>=', $request->appointment_date_from);
        }
        if ($request->has('appointment_date_to') && !$request->has('appointment_date_from')) {
            $appointments->where('appointment_date', '<=', $request->appointment_date_to);
        }
        if ($request->has('status')) {
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
    public function getMyPatientsList(Request $request)
    {
        $appointments = Appointment::with('user')->where('med_id', auth()->user()->id)->where('is_paid', 1)
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
            if ($completed_count == $total_count) {
                if ($userAppointments->where(function ($query) {
                    $query->where('patient_status', 'in_progress')
                        ->orWhere('patient_status', 'new_patient');
                })->count() == 0) {
                    $status = 'Recovered';
                }
            } else if ($completed_count == 0) {
                $status = 'New Patient';
            }
            $latestCompletedAppointment = $userAppointments->where('status', 'completed')->first();
            if (!$latestCompletedAppointment) {
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
    public function addReview(Request $request)
    {
        $review = Review::create($request->all());
        $data = [
            'status' => 200,
            'message' => 'Review added successfully',
            'data' => $review,
        ];
        return response()->json($data, 200);
    }
    public function updateReview(Request $request)
    {
        $review = Review::where('id', $request->review_id)->first();
        if (!$review) {
            return response()->json([
                'status' => 404,
                'message' => 'Review not found',
            ], 404);
        } else {
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
    public function getReview(Request $request)
    {
        $reviews = Review::with('user');
        if (isset($request->med_id)) {
            $reviews->where('med_id', $request->med_id);
        }
        if (isset($request->user_id)) {
            $reviews->where('user_id', $request->user_id);
        }
        if (isset($request->appointment_id)) {
            $reviews->where('appointment_id', $request->appointment_id);
        }
        if (isset($request->order_by)) {
            $reviews->orderBy('rating', $request->order_by);
        }
        $reviews = $reviews->get();
        $data = [
            'status' => 200,
            'message' => 'Reviews fetched successfully',
            'data' => $reviews,
        ];
        return response()->json($data, 200);
    }
    public function markAsPaid(Request $request)
    {
        $app = Appointment::find($request->id);
        $app->is_paid = 1;
        $app->gateway = $request->gateway;
        $app->transaction_id = $request->transaction_id;
        if ($app->user_id != auth()->user()->id) {
            $app->pay_for_me = auth()->user()->id;
        }
        $app->save();
        
        $user = auth()->user();
        $patient = User::find($app->user_id);
        $professional = User::find($app->med_id);    
        if ($app->user_id != auth()->user()->id) {
            
            Mail::to([$user->email])
                ->send(new PayForMeReceiptForPayee($professional->name_title . " " .$professional->first_name." ".$professional->last_name, 
                $app->appointment_date,  
                $app->appointment_time, 
                $app->appointment_type, 
                $patient->first_name." ".$patient->last_name, 
                $user->first_name.' '.$user->last_name,
                $app->consultation_fees)
            );
            Mail::to([$patient->email])
                ->send(new PayForMeReceiptForPayeeBeneficiary($professional->name_title . " " .$professional->first_name." ".$professional->last_name, 
                $app->appointment_date,  
                $app->appointment_time, 
                $app->appointment_type, 
                $patient->first_name." ".$patient->last_name,
                $app->consultation_fees,
                $app->transaction_id,  
                date('Y-m-d'))
            );
            $notificationData = [
                'title' => 'Payment Receipt',
                'description' => "<strong>Notification:</strong> Fantastic! You've successfully paid for $user->first_name $user->last_name\'s appointment with $professional->name_title $professional->first_name $professional->last_name. Check your email for all the exciting details and confirmation!",
                'type' => 'Appointment',
                'from_user_id' => auth()->id(),
                'to_user_id' => auth()->id(),
                'is_read' => 0,
            ];        
            Notifications::create($notificationData);
            $notificationData = [
                'title' => 'Payment Receipt',
                'description' => "<strong>Notification:</strong> Awesome news! ". auth()->user()->first_name." ".auth()->user()->last_name." has paid for your appointment with $professional->name_title $professional->first_name $professional->last_name. Check your email for all the exciting details. See you soon!",
                'type' => 'Appointment',
                'from_user_id' => auth()->id(),
                'to_user_id' => auth()->id(),
                'is_read' => 0,
            ];        
            Notifications::create($notificationData);
            
        }
        else{
            Mail::to([$user->email])
                ->send(new PaymentReceipt($professional->name_title . " " .$professional->first_name." ".$professional->last_name, 
                $app->appointment_date,  
                $app->appointment_time, 
                $app->appointment_type, 
                $user->first_name." ".$user->last_name, 
                $app->consultation_fees, 
                $app->transaction_id, 
                date('Y-m-d')));
            
            $notificationData = [
                'title' => 'Payment Receipt',
                'description' => "<strong>Notification:</strong> Fantastic! Your appointment with $professional->name_title $professional->first_name $professional->last_name is confirmed and payment received! Check your email for all the exciting details. See you soon!",
                'type' => 'Appointment',
                'from_user_id' => auth()->id(),
                'to_user_id' => auth()->id(),
                'is_read' => 0,
            ];        
            Notifications::create($notificationData);
        }
        // create a chatbox between patient and professional
        $box = ChatController::createChatBox($app->user_id, $app->med_id);
        if ($box != true) {
            $data = [
                'status' => 404,
                'message' => 'Chat Box not created',
            ];
            return response()->json($data, 200);
        }
        $data = [
            'status' => 200,
            'message' => 'Appointment Marked as paid',
            'data' => $app,
        ];
        return response()->json($data, 200);
    }
    public function payForSome(Request $request)
    {
        $app = Appointment::where('appointment_code', $request->appointment_code)->first();
        if ($app) {
            $data = [
                'status' => 200,
                'message' => 'Appointment Found',
                'data' => $app,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'Appointment not Found',
            ];
            return response()->json($data, 200);
        }
    }

    public function sendPatientNotifications()
    {
        // Get future appointments that are within the next 24 hours and have not sent notifications
        $appointments = Appointment::whereDate('appointment_date', '>=', Carbon::now()->toDateString())
            ->where('status', '!=', 'cancelled')
            ->get();

        foreach ($appointments as $appointment) {
            $appointmentTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);
  
            $professional = User::find($appointment->med_id);    
            $user = User::find($appointment->user_id);    
            // Notification intervals and corresponding columns
            $p_name = $professional->name_title . " " .$professional->first_name." ".$professional->last_name;
            $u_name = $user->first_name." ".$user->last_name;
            $intervals = [
                '24_hours_before' => ['time' => $appointmentTime->copy()->subDay(), 'column' => '24_hours_email_sent', 'message' => 'Reminder: Your appointment with '.$p_name.' is in 24 hours. When time is due, please open the Deluxe Hospital app and navigate to Chat section; '.$p_name.' will be there. Thank you!', 'subject'=>'Appointment Reminder - Your Consultation with '.$p_name],
                '12_hours_before' => ['time' => $appointmentTime->copy()->subHours(12), 'column' => '12_hours_email_sent', 'message' => 'Reminder: Your appointment with '.$p_name.' is in 12 hours. When time is due, please open the Deluxe Hospital app and navigate to Chat section; '.$p_name.' will be there. Thank you!', 'subject'=>'Appointment Reminder - Your Consultation with '.$p_name],
                '1_hour_before' => ['time' => $appointmentTime->copy()->subHour(), 'column' => '1_hour_email_sent', 'message' => 'Reminder: Your appointment with '.$p_name.' is in 1 hour. When time is due, please open the Deluxe Hospital app and navigate to Chat section; '.$p_name.' will be there. Thank you!', 'subject'=>'Appointment Reminder - Your Consultation with '.$p_name],
                '15_minutes_before' => ['time' => $appointmentTime->copy()->subMinutes(15), 'column' => '15_minutes_email_sent', 'message' => 'Reminder: Your appointment with '.$p_name.' is in 15 minutes. When time is due, please open the Deluxe Hospital app and navigate to Chat section; '.$p_name.' will be there. Thank you!', 'subject'=>'Appointment Reminder - Your Consultation with '.$p_name.' is Starting Soon'],
                'appointment_due' => ['time' => $appointmentTime, 'column' => 'appointment_is_due', 'message' => 'Reminder: Your appointment with '.$p_name.' is NOW. Please open the Deluxe Hospital app and navigate to Chat section; '.$p_name.' will be there. Thank you!', 'subject'=>'Appointment Reminder - Your Consultation with '.$p_name.' is NOW'],
            ];

            foreach ($intervals as $key => $interval) {
                $time = $interval['time'];
                $column = $interval['column'];
                $message = $interval['message'];
                $subject = $interval['subject'];

                // Send notification only if the current time is past the interval time and not already sent
                if (Carbon::now()->greaterThanOrEqualTo($time) && (!$column || !$appointment->$column)) {
                    $notificationData = [
                        'title' => 'Appointment Reminder',
                        'description' => $message,
                        'type' => 'Appointment',
                        'from_user_id' => $appointment->user_id,
                        'to_user_id' => $appointment->user_id,
                        'is_read' => 0,
                    ];        
                    Notifications::create($notificationData);
                    // Send email notification
                    Mail::to([$user->email])
                        ->send(new BeforeAppointment($p_name, $appointment->appointment_date,  $appointment->appointment_time, $appointment->appointment_type, $u_name, $subject));
       

                    // Mark the email as sent
                    if ($column) {
                        $appointment->$column = true;
                        $appointment->save();
                    }
                }
            }
        }

        return response()->json(['message' => 'Notifications processed successfully.'], 200);
    }
    public function sendProfessionalNotifications()
    {
        // Get future appointments that are within the next 24 hours and have not sent notifications
        $appointments = Appointment::whereDate('appointment_date', '>=', Carbon::now()->toDateString())
            ->where('status', '!=', 'cancelled')
            ->where('patient_status', '!=', 'cancelled')
            ->get();

        foreach ($appointments as $appointment) {
            $appointmentTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);
  
            $professional = User::find($appointment->med_id);    
            $user = User::find($appointment->user_id);    
            // Notification intervals and corresponding columns
            $p_name = $professional->name_title . " " .$professional->first_name." ".$professional->last_name;
            $u_name = $user->first_name." ".$user->last_name;
            $intervals = [
                '12_hours_before' => ['time' => $appointmentTime->copy()->subHours(12), 'column' => '12_hours_email_sent_p', 'message' => 'Reminder: You have an appointment with '.$u_name.' on '.$appointment->appointment_date.' at '.$appointment->appointment_time.'. Get ready to make a difference in 12hrs! 🌟', 'subject'=>' in 12hrs!'],
                '1_hour_before' => ['time' => $appointmentTime->copy()->subHour(), 'column' => '1_hour_email_sent_p', 'message' => 'Reminder: You have an appointment with '.$u_name.' on '.$appointment->appointment_date.' at '.$appointment->appointment_time.'. Get ready to make a difference in 1hr! 🌟', 'subject'=>' 1hr!'],
                '15_minutes_before' => ['time' => $appointmentTime->copy()->subMinutes(15), 'column' => '15_minutes_email_sent_p', 'message' => 'Reminder: You have an appointment with '.$u_name.' on '.$appointment->appointment_date.' at '.$appointment->appointment_time.'. Get ready to make a difference in 15 minutes ! 🌟', 'subject'=>' in 15 minutes!'],
                'appointment_due' => ['time' => $appointmentTime, 'column' => 'appointment_is_due_p', 'message' => '🚀 Reminder: Your appointment with '.$u_name.' on Deluxe Hospital is due NOW. We\'re excited you will be providing exceptional service!🌟', 'subject'=>' is due NOW!'],
            ];

            foreach ($intervals as $key => $interval) {
                $time = $interval['time'];
                $column = $interval['column'];
                $message = $interval['message'];
                $subject = $interval['subject'];

                // Send notification only if the current time is past the interval time and not already sent
                if (Carbon::now()->greaterThanOrEqualTo($time) && (!$column || !$appointment->$column)) {
                    $notificationData = [
                        'title' => 'Appointment Reminder',
                        'description' => $message,
                        'type' => 'Appointment',
                        'from_user_id' => $appointment->med_id,
                        'to_user_id' => $appointment->med_id,
                        'is_read' => 0,
                    ];        
                    Notifications::create($notificationData);
                    // Send email notification
                    Mail::to([$professional->email])
                        ->send(new BeforeAppointmentDoctor($p_name, $appointment->appointment_date,  $appointment->appointment_time, $appointment->age, $u_name, $subject));
                    
                    // Mark the email as sent
                    if ($column) {
                        $appointment->$column = true;
                        $appointment->save();
                    }
                }
            }
        }

        return response()->json(['message' => 'Notifications processed successfully.'], 200);
    }
    public function sendPostConsultationNotifications(){
        $appointments = Appointment::whereDate('appointment_date', '=', Carbon::now()->subDays(7)->toDateString())
            ->where('status', 'completed')
            ->where('patient_status', 'completed')
            ->where('post_consultation_email_sent', '=', '0')
            ->get();

        foreach ($appointments as $appointment) {
            $professional = User::find($appointment->med_id); // The professional (doctor)
            $user = User::find($appointment->user_id); // The patient

            if (!$professional || !$user) {
                continue; 
            }

            // Compose notification and email details
            $p_name = $professional->name_title . " " . $professional->first_name . " " . $professional->last_name;
            $u_name = $user->first_name . " " . $user->last_name;            

            // Send email to the patient
            Mail::to($professional->email)
                ->send(new AfterConsultation($p_name, $appointment->appointment_date, $appointment->time, $appointment->consultation_fees, $u_name));

            // Mark the email as sent
            $appointment->post_consultation_email_sent = true;
            $appointment->save();
        }

        $appointments = Appointment::whereDate('appointment_date', '<=', Carbon::now()->toDateString()) // Appointment date is today or earlier
            ->whereTime('appointment_time', '<=', Carbon::now()->toTimeString()) // Appointment time has passed
            ->whereDate('appointment_date', '>=', Carbon::now()->subDays(7)->toDateString()) // Within 7 days post-appointment
            ->where('status', '!=', 'cancelled')
            ->where('patient_status', '!=', 'cancelled')
            ->whereNull('post_consultation_email_sent_p')
            ->get();
        
        foreach ($appointments as $appointment) {
            $professional = User::find($appointment->med_id); 
            $user = User::find($appointment->user_id);
        
            if (!$professional || !$user) {
                continue; 
            }
            $p_name = $professional->name_title . " " . $professional->first_name . " " . $professional->last_name;
            $u_name = $user->first_name . " " . $user->last_name;        
            Mail::to($user->email)
                ->send(new AfterAppointment($p_name, $u_name));
            $notificationData = [
                'title' => 'After Appointment',
                'description' => "Hi ".$u_name."! Great news - you've got a 7-day free follow-up period with ".$p_name."! Plus, you can check out a summary of your consultation in the app's Summary section. Stay well! The Team that Cares.",
                'type' => 'Appointment',
                'from_user_id' => $appointment->user_id,
                'to_user_id' => $appointment->user_id,
                'is_read' => 0,
            ];        
            Notifications::create($notificationData);
            $appointment->post_consultation_email_sent_p = true;
            $appointment->save();
        }
    
        return response()->json(['message' => 'Post-consultation notifications processed successfully.'], 200);
    }
}