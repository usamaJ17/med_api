<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Professions;
use App\Models\Ranks;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function getRanks(){
        $ranks = Ranks::pluck('name','id')->toArray();
        return response()->json($ranks,200);
    }
    public function getProfessions(){
        $ranks = Professions::pluck('name','id')->toArray();
        return response()->json($ranks,200);
    }
}
