<?php

namespace App\Http\Controllers;

use App\Exports\ProfessionalsExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicals = User::whereHas("roles", function($q){ $q->where("name", "medical"); })->with('professionalDetails.professions','professionalDetails.ranks')->get();
        $fields = [];
        if($medicals->count() > 0){
            $fields = $medicals[0]->getAllProfessionalFields();
        }
        return view('dashboard.medicals.index', compact('medicals','fields'));
    }
    /**
     * Display a listing of the resource.
     */
    public function verification_requests()
    {
        $medicals = User::whereHas("roles", function($q){ $q->where("name", "medical"); })->where('verification_requested_at','!=',null)->with('professionalDetails.professions','professionalDetails.ranks')->get();
        return view('dashboard.medicals.verification_request', compact('medicals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medical = User::whereHas("roles", function($q){ $q->where("name", "medical"); })->with('professionalDetails.professions','professionalDetails.ranks')->find($id);
        if($medical){
            $docs = $medical->GetAllMedia() ?? [];
            return view('dashboard.medicals.show', compact('medical','docs'));
        }else{
            return redirect()->back()->with('error', 'Medical not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

    /**
     * Export in excel
     */
    public function export(Request $request)
    {
        return Excel::download(new ProfessionalsExport($request->all()), 'Professional.xlsx');
    }
}
