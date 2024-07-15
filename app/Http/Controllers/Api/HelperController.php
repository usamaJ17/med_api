<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DynamicFiled;
use App\Models\Professions;
use App\Models\Ranks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelperController extends Controller
{
    public function getRanks(){
        $ranks = Ranks::all();
        $data =[
            'status' => 200,
            'message' => 'All Ranks fetched successfully',
            'data' => $ranks,
        ];
        return response()->json($data,200);
    }
    public function getProfessions(){
        $ranks = Professions::pluck('name','id')->toArray();
        $data =[
            'status' => 200,
            'message' => 'All Professions fetched successfully',
            'data' => ['professions' => $ranks],
        ];
        return response()->json($data,200);
    }
    public function deleteAccount($id){
        $user = null;
        if(!isset($id) || $id == null || $id == ''){
            $user = User::find(Auth::id());
        }else{
            $user = User::find($id);
        }
        $user->delete();
        $data = [
            'status' => 200,
            'message' => 'Account deleted successfully',
        ];
        return response()->json($data, 200);
    }
    public function changeActivation(Request $request){
        $user = User::find($request->med_id);
        if($request->is_live == true || $request->is_live == 'true'){
            $user->is_live = true;
        }
        elseif($request->is_live == false || $request->is_live == 'false'){
            $user->is_live = false;
        }
        $user->save();
        $data = [
            'status' => 200,
            'message' => 'Account status changed successfully',
        ];
        return response()->json($data, 200);
    }
    public function getProfessionalTitles(){
        $titles = DynamicFiled::where('name','professional_title')->first();
        if($titles){
            $title_array = json_decode($titles->data);
            $data = [
                'status' => 200,
                'message' => 'Professional Titles fetched successfully',
                'data' => $title_array,
            ];
            return response()->json($data, 200);
        }else{
            $data = [
                'status' => 200,
                'message' => 'No Professional Titles found',
            ];
            return response()->json($data, 200);
        }
    }
    public function saveProfessionalTitles(Request $request){
        $titles = DynamicFiled::where('name','professional_title')->first();
        if($titles){
            $tit_array = json_decode($titles->data);
            $tit_array[] = request()->all();
            $titles->data = json_encode($tit_array);
            $titles->save();
            $data = [
                'status' => 200,
                'message' => 'Professional Titles Added successfully',
            ];
            return response()->json($data, 200);
        }
    }
}
