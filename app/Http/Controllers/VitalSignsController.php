<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateAppointmentSummaryPDF;
use App\Models\ClinicalNotes;
use App\Models\ClinicalNotesCustomField;
use App\Models\ClinicalNotesField;
use App\Models\DynamicFiled;
use App\Models\NotesComment;
use App\Models\VitalSigns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $clinicalNote = ClinicalNotes::with('creator' , 'creator.professionalDetails.professions' ,'user', 'comments.addedBy')->where('user_id', $request->user_id)->get();       

        return response()->json([
            'status' => 200,
            'message'=> 'Notes Fetched Successfully...',
            'data'   => $clinicalNote,
        ], 200);
    }


    public function saveNotes(Request $request){
        $summaryJson = json_decode(str_replace("'", '"', $request->note));
        $request->merge([
            'created_by' => auth()->user()->id,
            'note' => json_encode($summaryJson)
        ]);
        $clinicalNote = ClinicalNotes::create($request->all());
        $data = [
            'clinical_note' => $clinicalNote,
        ];
        GenerateAppointmentSummaryPDF::dispatch($clinicalNote->id , $summaryJson , $request->user_id , auth()->user()->id);
        return response()->json([
            'status' => 200,
            'message'=> 'Notes Created Successfully, PDF will be available in a while',
            'data'   => $data,
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
    public function getClinicalNotesFields(){
        $required_fields = ClinicalNotesField::where('is_required', 'Yes')->pluck('name')->toArray();
        $optional_fields = ClinicalNotesField::where('is_required', 'No')->pluck('name')->toArray();
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
