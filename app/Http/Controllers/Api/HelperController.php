<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Professions;
use App\Models\Ranks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelperController extends Controller
{
    public function getRanks(){
        $ranks = Ranks::pluck('name','id')->toArray();
        $data =[
            'status' => 200,
            'message' => 'All Ranks fetched successfully',
            'data' => ['ranks' => $ranks],
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
}
