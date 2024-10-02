<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppointmentSummary;
use App\Models\DynamicFiled;
use App\Models\SummaryDynamicField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentSummaryController extends Controller
{
    public function addSummaryField(Request $request){
        $fields = $request->fields;
        $var = str_replace("'", '"', $fields);
        $summary_fields = json_decode($var, true);
        $fields = SummaryDynamicField::where('user_id',auth()->user()->id)->first();
        if($fields){
            $fields->update([
                'fields' => json_encode($summary_fields)
            ]);
            return response()->json([
                'status' => 200,
                'message'=> 'Summary fields updated successfully...',
            ], 200);
        }else{
            SummaryDynamicField::create([
                'user_id' => auth()->user()->id,
                'fields' => json_encode($summary_fields)
            ]);
        }
        return response()->json([
            'status' => 200,
            'message'=> 'Summary fields added successfully...',
        ], 200);
    }
    public function getSummaryField(){
        $fields = SummaryDynamicField::where('user_id',auth()->user()->id)->first();
        if($fields){
            $user_fields = json_decode($fields->fields); 
        }else{
            $user_fields = [];
        }
        $required = DynamicFiled::where('name','summary_required')->first();
        $optional = DynamicFiled::where('name','summary_optional')->first();
        if($required){
            $required_fields = json_decode($required->data);
        }else{
            $required_fields = [];
        }
        if($optional){
            $optional_fields = json_decode($optional->data);
        }else{
            $optional_fields = [];
        }
        $fieldsData = [
            'required' => $required_fields,
            'optional' => $optional_fields,
            'user' => $user_fields
        ];
        $res = [
            'status' => 200,
            'message'=> 'Summary fields fetched successfully...',
            'data' => $fieldsData
        ];
        return response()->json($res, 200);
    }
    public function store(Request $request){
        $summary = $request->summary;

        // Convert single quotes to double quotes
        $summary = str_replace("'", '"', $summary);

        // Decode the string into a valid JSON object (associative array)
        $summaryJson = json_decode($summary);
        $fields = AppointmentSummary::where('appointment_id',$request->appointment_id)->first();
        if($fields){
            $fields->update([
                'summary' => json_encode($summaryJson)
            ]);
            $data = [
                'status' => 200,
                'message' => 'Summary updated successfully',
            ];
        }else{
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
    public function view(Request $request){
        $fields = AppointmentSummary::where('appointment_id',$request->appointment_id)->first();
        $res = [
            'summary' => json_decode($fields->summary)
        ];
        if($fields){
            $data = [
                'status' => 200,
                'message' => 'Summary fetched successfully',
                'data' => $res
            ];
        }else{
            $data = [
                'status' => 404,
                'message' => 'Summary not found',
                'data' => null
            ];
        }
        return response()->json($data, 200);
    }
}