<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppointmentSummary;
use App\Models\DynamicFiled;
use App\Models\SummaryDynamicField;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\PatientUploadsTestResult;

class AppointmentSummaryController extends Controller
{
    public function addSummaryField(Request $request)
    {
        $fields = $request->fields;
        $var = str_replace("'", '"', $fields);
        $summary_fields = json_decode($var, true);
        $fields = SummaryDynamicField::where('user_id', auth()->user()->id)->first();
        if ($fields) {
            $fields->update([
                'fields' => json_encode($summary_fields)
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Summary fields updated successfully...',
            ], 200);
        } else {
            SummaryDynamicField::create([
                'user_id' => auth()->user()->id,
                'fields' => json_encode($summary_fields)
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Summary fields added successfully...',
        ], 200);
    }
    public function getSummaryField()
    {
        $fields = SummaryDynamicField::where('user_id', auth()->user()->id)->first();
        if ($fields) {
            $user_fields = json_decode($fields->fields);
        } else {
            $user_fields = [];
        }
        // $required = DynamicFiled::where('name', 'summary_required')->first();
        // $optional = DynamicFiled::where('name', 'summary_optional')->first();
        // if ($required) {
        //     $required_fields = json_decode($required->data);
        // } else {
        //     $required_fields = [];
        // }
        // if ($optional) {
        //     $optional_fields = json_decode($optional->data);
        // } else {
        //     $optional_fields = [];
        // }
        $required_fields = ConsultationSummaryField::where('is_required', 'Yes')
            ->get(['name', 'type'])
            ->toArray();

        $optional_fields = ConsultationSummaryField::where('is_required', 'No')
            ->get(['name', 'type'])
            ->toArray();
        $fieldsData = [
            'required' => $required_fields,
            'optional' => $optional_fields,
            'user' => $user_fields
        ];
        $res = [
            'status' => 200,
            'message' => 'Summary fields fetched successfully...',
            'data' => $fieldsData
        ];
        return response()->json($res, 200);
    }
    public function store(Request $request)
    {
        $summary = $request->summary;

        // Convert single quotes to double quotes
        $summary = str_replace("'", '"', $summary);

        // Decode the string into a valid JSON object (associative array)
        $summaryJson = json_decode($summary);
        $fields = AppointmentSummary::where('appointment_id', $request->appointment_id)->first();
        if ($fields) {
            $fields->update([
                'summary' => json_encode($summaryJson)
            ]);
            $data = [
                'status' => 200,
                'message' => 'Summary updated successfully',
            ];
        } else {
            AppointmentSummary::create([
                'appointment_id' => $request->appointment_id,
                'summary' => json_encode($summaryJson)
            ]);
            $data = [
                'status' => 200,
                'message' => 'Summary added successfully',
            ];
        }
        return response()->json($data, 200);
    }
    public function uploadDocument(Request $request)
    {
        foreach ($request->all()['files'] as $file) {
            $media = auth()->user()->addMedia($file)->toMediaCollection('profile_uploads');
            if ($request->has("comment")) {
                $media->setCustomProperty('comment', $request->comment)->save();
            }
        }        
        // $professional = User::find($request->med_id);  
        // Mail::to([$professional->email])
        // ->send(new PatientUploadsTestResult($professional->first_name." ".$professional->last_name, $request->appointment_date,  $request->appointment_time, $request->age, $user->first_name." ".$user->last_name));
        // $notificationData = [
        //     'title' => 'Appointment Created',
        //     'description' => "Exciting news, $professional->first_name $professional->last_name! A new patient, $user->first_name $user->last_name, has booked an appointment with you on $request->appointment_date at $request->appointment_time. Your money is safe in our escrow account 🤗",
        //     'type' => 'Appointment',
        //     'from_user_id' => auth()->id(),
        //     'to_user_id' => $professional->id,
        //     'is_read' => 0,
        // ];        
        // Notifications::create($notificationData);
        $data = [
            'status' => 200,
            'message' => 'Documents uploaded successfully',
        ];
        return response()->json($data, 200);
    }
    public function getPdf(Request $request)
    {
        $url = 'https://portal.deluxehospital.com/storage/58/sample.pdf';
        $data = [
            'status' => 200,
            'message' => 'PDF generated successfully',
            'data' => $url
        ];
        return response()->json($data, 200);
    }
    public function getDocument(Request $request)
    {
        if (isset($request->patient_id)) {
            $user = User::find($request->patient_id);
        } else {
            $user = auth()->user();
        }
        if (!$user) {
            $data = [
                'status' => 404,
                'message' => 'User not found',
                'data' => null
            ];
            return response()->json($data, 404);
        }
        $data = [
            'status' => 200,
            'message' => 'Documents fetched successfully',
            'data' => $user->GetProfileUploads()
        ];
        return response()->json($data, 200);
    }
    public function view(Request $request)
    {
        $fields = AppointmentSummary::where('appointment_id', $request->appointment_id)->first();
        $res = [
            'summary' => json_decode($fields->summary)
        ];
        if ($fields) {
            $data = [
                'status' => 200,
                'message' => 'Summary fetched successfully',
                'data' => $res
            ];
        } else {
            $data = [
                'status' => 404,
                'message' => 'Summary not found',
                'data' => null
            ];
        }
        return response()->json($data, 200);
    }
}
