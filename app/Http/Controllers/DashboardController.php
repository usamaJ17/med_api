<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function login(){
        return view('dashboard.auth.login');
    }
    public function index(){
        return view('dashboard.index');
    }
}