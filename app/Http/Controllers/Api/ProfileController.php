<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalDetail;
use App\Models\ProfessionalDetails;
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
        $media = $med->getMedia();
        return response()->json([
            'status' => 200,
            'message'=> 'Details Fetched Successfully...',
            'data'   => $med,
        ], 200);
    }
    public function getProfessionalDetails(){
        $pro = ProfessionalDetails::where('user_id',Auth::id())->first();
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
}
