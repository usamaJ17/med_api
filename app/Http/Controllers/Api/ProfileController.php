<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalDetail;
use App\Models\ProfessionalDetails;
use App\Models\ProfessionalType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function saveProfessionalDetails(Request $request){
        $pro = ProfessionalDetails::updateOrCreate(['user_id'=>Auth::id()],$request->all());
        if(null !== $request->file('id_card')){
            $pro->clearMediaCollection('id_card');
            $pro->addMedia($request->file('id_card'))->toMediaCollection('id_card');
        }
        if(null !== $request->file('signature')){
            $pro->clearMediaCollection('signature');
            $pro->addMedia($request->file('signature'))->toMediaCollection('signature');
        }
        if(null !== $request->file('degree_file')){
            $pro->clearMediaCollection('degree_file');
            $pro->addMedia($request->file('degree_file'))->toMediaCollection('degree_file');
        }
        $pro->id_card = $pro->getFirstMediaUrl('id_card');
        $pro->signature = $pro->getFirstMediaUrl('signature');
        $pro->degree_file = $pro->getFirstMediaUrl('degree_file');
        return response()->json([
            'status' => 200,
            'message'=> 'Details Saved Successfully...',
            'data'   => $pro,
        ], 200);
    }
    public function saveMedicalDetails(Request $request){
        $med = MedicalDetail::updateOrCreate(['user_id'=>Auth::id()],$request->all());
        foreach ($request->allFiles() as $key => $file) {
            if (strpos($key, 'file_type_') === 0) {
                $med->clearMediaCollection($key);
                $med->addMedia($file)->toMediaCollection($key);
            }
        }
        // get all file_type media urls
        $media = $med->getMedia();
        return response()->json([
            'status' => 200,
            'message'=> 'Details Saved Successfully...',
            'data'   => $med,
        ], 200);
    }
    public function getMedicalDetails(){
        $med = MedicalDetail::where('user_id',Auth::id())->first();
        if(!$med) return response()->json([
            'status' => 404,
            'message'=> 'Details Not Found...',
        ], 404);
        $media = $med->getMedia();
        return response()->json([
            'status' => 200,
            'message'=> 'Details Fetched Successfully...',
            'data'   => $med,
        ], 200);
    }
    public function getProfessionalDetails(){
        $pro = ProfessionalDetails::where('user_id',Auth::id())->first();
        if(!$pro) return response()->json([
            'status' => 404,
            'message'=> 'Details Not Found...',
        ], 404);
        // add media url in response
        $pro->id_card = $pro->getFirstMediaUrl('id_card');
        $pro->signature = $pro->getFirstMediaUrl('signature');
        $pro->degree_file = $pro->getFirstMediaUrl('degree_file');
        return response()->json([
            'status' => 200,
            'message'=> 'Details Fetched Successfully...',
            'data'   => $pro,
        ], 200);
    }
    public function getMedicalProfessionals(){
        // get all user with medical role using spite role and permissions
        $pro = User::query()->role('medical');
        if(request()->has('professional_type_id')){
            $pro->where('professional_type_id',request('professional_type_id'));
        }
        if(request()->has('search')){
            $pro->where('first_name','like','%'.request('search').'%')->orWhere('last_name','like','%'.request('search').'%');
        }
        $pro = $pro->get();
        $pro->map(function($user){
            return $user->prepareUserData();
        });
        $data = [
            'medical_professionals' => $pro,
        ];        
        return response()->json([
            'status' => 200,
            'message'=> 'Details Fetched Successfully...',
            'data'   => $data,
        ], 200);
    }
    public function storeProfessionalType(Request $request){
        $request->validate([
            'name' => 'required|string',
        ]);
        // upload icon and save path in db
        if(null !== $request->file('icon')){
            $icon = $request->file('icon')->store('icons');
            $request->merge(['icon' => $icon]);
        }
        $pro = ProfessionalType::create($request->all());
        return response()->json([
            'status' => 200,
            'message'=> 'Professional Type Created Successfully...',
            'data'   => $pro,
        ], 200);
    }
    public function getProfessionalType(){
        $pro = ProfessionalType::all();
        return response()->json([
            'status' => 200,
            'message'=> 'Professional Type Fetched Successfully...',
            'data'   => ['professional_types' => $pro,'total' => $pro->count() ?? 0],
        ], 200);
    }
    public function updateProfessionalType(Request $request , $id){
        $request->validate([
            'name' => 'required|string',
        ]);
        $pro = ProfessionalType::find($id);
        if(!$pro) return response()->json([
            'status' => 404,
            'message'=> 'Professional Type Not Found...',
        ], 404);
        // upload icon and save path in db
        if(null !== $request->file('icon')){
            $icon = $request->file('icon')->store('icons');
            $request->merge(['icon' => $icon]);
        }
        $pro->update($request->all());
        return response()->json([
            'status' => 200,
            'message'=> 'Professional Type Updated Successfully...',
            'data'   => $pro,
        ], 200);
    }
    public function deleteProfessionalType($id){
        $pro = ProfessionalType::find($id);
        if(!$pro) return response()->json([
            'status' => 404,
            'message'=> 'Professional Type Not Found...',
        ], 404);
        $pro->delete();
        return response()->json([
            'status' => 200,
            'message'=> 'Professional Type Deleted Successfully...',
        ], 200);
    }
}
