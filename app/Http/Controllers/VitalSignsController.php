<?php

namespace App\Http\Controllers;

use App\Models\ClinicalNotes;
use App\Models\ClinicalNotesCustomField;
use App\Models\DynamicFiled;
use App\Models\NotesComment;
use App\Models\SummaryDynamicField;
use App\Models\VitalSigns;
use App\Models\ProfessionalDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use PDF;

class VitalSignsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vs = VitalSigns::where('user_id',$request->user_id)->get();
        return response()->json([
            'status' => 200,
            'message'=> 'Vitals Fetched Successfully...',
            'data'   => $vs,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        VitalSigns::create($request->all());
        return response()->json([
            'status' => 200,
            'message'=> 'Vitals Stored Successfully...',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getNotes(Request $request){
        $clinicalNote = ClinicalNotes::with('creator' , 'user', 'comments.addedBy')->where('user_id', $request->user_id)->get();       

        return response()->json([
            'status' => 200,
            'message'=> 'Notes Fetched Successfully...',
            'data'   => $clinicalNote,
        ], 200);
    }


    public function saveNotes(Request $request){
        $summary = $request->note;
        $summary = str_replace("'", '"', $summary);
        $summaryJson = json_decode($summary);
        $professionDetail = User::with('professionalDetails')->where('id', auth()->user()->id)->first();
        $patientDetail = User::with('medicalDetails')->where('id', $request->user_id)->first();
        $pdfs_list = array();
        foreach ($summaryJson as $key => $value) { 
            $weight = isset($patientDetail['medical_details']['weight']) ? $patientDetail['medical_details']['weight'] . ' kg' : 'N/A';    
            $registrationNumber = $professionDetail['professional_details']['regestraion_number'] ?? 'N/A';
            if ($registrationNumber !== 'N/A') {
                $maskedRegistrationNumber = '****' . substr($registrationNumber, -2);
            } else {
                $maskedRegistrationNumber = 'N/A';
            }       
            
            if ($key === 'Prescription' || $key === 'prescription') {
                $background = public_path('pdfs/background.png');
            }
            else{
                $background = public_path('pdfs/background2.png');
            }
            $data = [
                'background' => $background,
                'date' => date('d/m/Y'),
                'patient_id' => $patientDetail['id'] ?? 'N/A',
                'patient_name' => $patientDetail['first_name'] . ' ' . $patientDetail['last_name'],
                'patient_address' => $patientDetail['city'] . ', ' . $patientDetail['state'] . ', ' . $patientDetail['country'],
                'patient_phone' => $patientDetail['contact'] ?? 'N/A',
                'patient_age' => isset($patientDetail['dob']) ? date_diff(date_create($patientDetail['dob']), date_create('today'))->y . ' years' : 'N/A',
                'patient_weight' => $weight,
                'patient_gender' => $patientDetail['gender'] ?? 'N/A',
                'doctor_name' => $professionDetail['first_name'] . ' ' . $professionDetail['last_name'],
                'doctor_license' => $maskedRegistrationNumber,
                'doctor_signature' => $professionDetail['professional_details']['signature'] ?? 'N/A',
                'note_key' => $key,
                'note_value' => $value,
            ];
            if ($key === 'Prescription' || $key === 'prescription') {
                $prefix = 'prescription_';
                $pdf = Pdf::loadView('pdf.prescription', $data)->setPaper('legal', 'portrait');
            } else {
                $prefix = 'none_prescription_';
                $pdf = Pdf::loadView('pdf.consultation_summary', $data)->setPaper('legal', 'portrait');
            }
            $file_name = 'prescriptions/'. $prefix . time() . '.pdf';
            if (!is_dir(public_path('prescriptions'))) {
                mkdir(public_path('prescriptions'), 0777, true);
            }
            $filePath = public_path($file_name);
            $pdf->save($filePath);
            $pdfs_list[$value] =  $file_name;
        }

        $request->merge([
            'created_by' => auth()->user()->id,
            'note' => json_encode($summaryJson),
            'pdfs_list' => json_encode($pdfs_list)
        ]);
        $clinicalNote = ClinicalNotes::create($request->all());
        return response()->json([
            'status' => 200,
            'message'=> 'Notes Created Successfully...',
        ], 200);
    }
    public function saveComment(Request $request){
        $request->merge([
            'added_by' => auth()->user()->id
        ]);
        $clinicalNote = NotesComment::create($request->all());
        return response()->json([
            'status' => 200,
            'message'=> 'Comment Added Successfully...',
            'data'   => $clinicalNote,
        ], 200);
    }
    public function getFields(){
        $required = DynamicFiled::where('name','notes_required')->first();
        $optional = DynamicFiled::where('name','notes_optional')->first();
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
        ];
        $res = [
            'status' => 200,
            'message'=> 'Clinical Notes fields fetched successfully...',
            'data' => $fieldsData
        ];
        return response()->json($res, 200);
    }
    public function addCustomField(Request $request)
    {
        $request->merge([
           'user_id' => Auth::id(), 
        ]);

        // Create a new custom field
        ClinicalNotesCustomField::create($request->all());

        return response()->json([
            'status' => 201,
            'message' => 'Custom field added successfully',
        ], 201);
    }
}
