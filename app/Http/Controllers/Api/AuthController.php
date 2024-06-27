<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Mail\OtpMail;
use App\Models\MedicalDetail;
use App\Models\ProfessionalDetails;
use App\Models\Professions;
use App\Models\Ranks;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
	{
        // make a validatior and validate request and send json response in case of validation error
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 401,
                'message' => $validator->errors()->first(),
            ], 401);
        }
	    $check = User::where('email', $request->email)->count();
	    if ($check < 1) {
    		$user = New User();
    	    $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->contact = $request->contact;
    	    $user->email = $request->email;
    	    $user->password = Hash::make($request->password);
    	    $otp = random_int(111111, 999999);
            $user->otp = $otp;
            $user->save();
            $user->assignRole($request->role);
            Mail::to([$user->email])->send(new OtpMail($otp,$user->name, true));
            return response()->json([
                'status'  => 202,
                'message' => 'OTP Sent Successfully...',
                'email'    => $request->email,
            ], 200);
	    }else{
	    	return response()->json([
	    	   'status' => 401,
	    	   'message'=> 'Email already taken, Please use another email...'
	    	],401);
	    }
	}
	   
    public function login(Request $request): JsonResponse
    {
    	$user = User::where('email',$request->email)->first();

        if($user->email_verified_at == false){
            return response()->json([
                'status'  => 401,
                'message'=> 'Please verify your email first...',
             ], 401);
        }
        else  if(!$user || !Hash::check($request->password,$user->password)){
        	return response()->json([
	    	   'status' => 401,
	    	   'message'=> 'Invalid Email OR Password...',
	    	], 401);
        }else{
            Auth::login($user);
            $user = Auth::user();
            // add role in user
            return response()->json([
                'otp_sent'  => false,
                'status'  => 202,
                'message' => 'Login Successfully...',
                'user'    => $user,
                'token'   => Auth::user()->createToken('Med')->plainTextToken,
            ], 200);
        }
    }
    public function SendForgotPassword(Request $request): JsonResponse
    {
    	$user = User::where('email',$request->email)->first();
        if(!$user){
        	return response()->json([
	    	   'status' => 401,
	    	   'message'=> 'Invalid Email...',
	    	], 401);
        }else{
            // generate randon string of length 10 and save it in forgot_password field
            $otp = random_int(111111, 999999);
            $user->forgot_password = $otp;
            $user->save();
            Mail::to([$user->email])->send(new ForgotPassword($otp));
            return response()->json([
                'status'  => 202,
                'message' => 'Reset password email sent...',
            ], 200);   
        }
    }
    public function UpdateForgotPassword(Request $request): JsonResponse
    {
    	$user = User::where('forgot_password',$request->otp)->first();
        if(!$user){
        	return response()->json([
        	   'status' => 401,
        	   'message'=> 'Invalid Request...',
        	], 401);
        }else{
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:8',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => 401,
                    'message' => $validator->errors()->first(),
                ], 401);
            }
            $user->password = Hash::make($request->password);
            $user->forgot_password = null;
            $user->save();
            return response()->json([
                'status'  => 202,
                'message' => 'Password Reset Successfully...',
            ], 200);   
        }
    }
    public function otp(Request $request): JsonResponse
    {
    	$user = User::where('email',$request->email)->first();

        if(!$user || $user->otp != $request->otp){
        	return response()->json([
	    	   'status' => 401,
	    	   'message'=> 'Invalid OTP',
	    	], 401);
        }else{
            $user->email_verified_at = now();
            $user->save();
            Auth::login($user);
            // add role in user
            return response()->json([
                'status'  => 202,
                'message' => 'Regestrered successfully,',
                'user'    => $user,
                'token'   => Auth::user()->createToken('Med')->plainTextToken,
            ], 200);
        }
    }
    public function logout(Request $request): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json([
           'status' => 200,
           'message'=> 'Logout Successfully...',
        ], 200);
    }
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
        //$media = $med->getMedia();
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
    public function savePersonalDetails(Request $request){
        $user = Auth::user();
        $user->update($request->all());
        return response()->json([
            'status' => 200,
            'message'=> 'Details Saved Successfully...',
            'data'   => $user,
        ], 200);
    }
}
