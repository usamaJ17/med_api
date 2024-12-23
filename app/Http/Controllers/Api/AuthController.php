<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Mail\ProfessionalOtpMail;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
	{
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
    	    if(isset($request->parent_id) && $request->parent_id != null){
                $user->parent_id = $request->parent_id;
                $user->email_verified_at = now();
            }else{
                $otp = random_int(111111, 999999);
                $user->otp = $otp;
            }
            $user->temp_role = $request->role;
            if($request->role == 'medical'){
                $user->professional_type_id = $request->professional_type_id;
            }
            $user->save();
            if(isset($request->parent_id) && $request->parent_id != null){
                $user->assignRole($user->temp_role);
                return response()->json([
                    'status'  => 202,
                    'message' => 'Sub Account Added Successfully...',
                    'data'    => $user,
                ], 200);
            }
            $name = $user->first_name . ' ' . $user->last_name;
            Mail::to([$user->email])->send(new OtpMail($otp,$name, true));
            $data = [
                'email'   => $request->email,
            ];
            return response()->json([
                'status'  => 202,
                'message' => 'OTP Sent Successfully...',
                'data'    => $data,
            ], 200);
	    }else{
            $user = User::where('email', $request->email)->first();
            if($user->email_verified_at == false){
                $otp = random_int(111111, 999999);
                $user->otp = $otp;
                $user->save();
                if($request->role == 'medical'){
                    Mail::to([$user->email])->send(new ProfessionalOtpMail($otp,$user->name, true));
                }
                else{
                    Mail::to([$user->email])->send(new OtpMail($otp,$user->name, true));
                }
                return response()->json([
                    'status'  => 401,
                    'message'=> 'Please verify to register, OTP email has been sent...',
                ], 401);
            }
	    	return response()->json([
	    	   'status' => 401,
	    	   'message'=> 'Email already taken, Please use another email...'
	    	],401);
	    }
	}
	   
    public function login(Request $request): JsonResponse
    {
    	$user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
        	return response()->json([
	    	   'status' => 401,
	    	   'message'=> 'Invalid Email OR Password...',
	    	], 401);
        }else if($user->email_verified_at == false){
            return response()->json([
                'status'  => 401,
                'message'=> 'Please verify your email first...',
             ], 401);
        }else{
            Auth::login($user);
            $user = User::with('professionalDetails','medicalDetails')->find(Auth::user()->id);
            $user_details = [];
            if($user->role == 'patient'){
                $user_details = [
                    'personal_details' => $user->prepareUserData(),
                    'medical_details'  => $user->medicalDetails,
                ];
            }else if($user->role == 'medical'){
                $user_details = [
                    'personal_details' => $user->prepareUserData(),
                    'professional_details'  => $user->professionalDetails,
                ];
            }
            $data = [
                'otp_sent'  => false,
                'user'    => $user_details,
                'token'   => $user->createToken('Med')->plainTextToken,
            ];
            // add role in user
            return response()->json([
                'status'  => 202,
                'message' => 'Login Successfully...',
                'data'    => $data,
            ], 200);
        }
    }
    public function fingerprintLogin(Request $request): JsonResponse
    {
        $user = User::find($request->id);
        Auth::login($user);
        $user = User::with('professionalDetails','medicalDetails')->find(Auth::user()->id);
        $user_details = [];
        if($user->role == 'patient'){
            $user_details = [
                'personal_details' => $user->prepareUserData(),
                'medical_details'  => $user->medicalDetails,
            ];
        }else if($user->role == 'medical'){
            $user_details = [
                'personal_details' => $user->prepareUserData(),
                'professional_details'  => $user->professionalDetails,
            ];
        }
        $data = [
            'otp_sent'  => false,
            'user'    => $user_details,
            'token'   => $user->createToken('Med')->plainTextToken,
        ];
        return response()->json([
            'status'  => 202,
            'message' => 'Login Successfully...',
            'data'    => $data,
        ], 200);
    }
    public function adminLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return redirect()->back()->with('error','Invalid Email OR Password...');
        }else if($user->role != 'admin' && $user->role != 'manager' && $user->role != 'editor'){
            return redirect()->back()->with('error','Invalid Email OR Password...');
        }else{
            Auth::login($user);
            return redirect()->route('dashboard');
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
            $name = $user->first_name . ' ' . $user->last_name;
            Mail::to([$user->email])->send(new ForgotPassword($name, $otp));
            return response()->json([
                'status'  => 200,
                'message' => 'Reset password email sent...',
            ], 200);   
        }
    }
    public function CheckOtpForgotPassword(Request $request){
            $user = User::where('email',$request->email)->first();
            if(!$user){
            	return response()->json([
            	   'status' => 401,
            	   'message'=> 'Invalid Request...',
            	], 401);
            }else{
                if($request->otp == $user->forgot_password){
                    return response()->json([
                        'status' => 200,
                        'message'=> 'OTP correct...',
                        'data' => true
                     ], 200);
                }else{
                    return response()->json([
                        'status' => 401,
                        'message'=> 'OTP wrong...',
                        'data' => false
                     ], 401);
                }
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
                'status'  => 200,
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
            $user->assignRole($user->temp_role);
            Auth::login($user);
            $data = [
                'user'    => $user->prepareUserData(),
                'token'   => $user->createToken('Med')->plainTextToken,
            ];
            // add role in user
            return response()->json([
                'status'  => 200,
                'message' => 'Regestrered successfully,',
                'data'    => $data,
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
    public function AdminLogout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
    public function savePersonalDetails(Request $request){
        $user = User::find(Auth::user()->id);
        // if(null !== $request->file('profile_image')){
        //     $user->clearMediaCollection();
        //     $user->addMedia($request->file('profile_image'))->toMediaCollection();
        // }

        $fileFields = array_keys($request->files->all());

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $user->clearMediaCollection($field);
                $user->addMedia($request->file($field))->toMediaCollection($field);
            }
        } 

        
        // remove email and password from request if present
        unset($request['email']);
        unset($request['password']);
        
        $user->update($request->all());
        $data = [
            'user' => $user->prepareUserData(),
        ];
        return response()->json([
            'status' => 200,
            'message'=> 'Details Saved Successfully...',
            'data'   => $data,
        ], 200);
    }
    public function saveLanguage(Request $request){
        $user = User::find(Auth::user()->id);
        $user->update($request->all());
        $data = [
            'user' => $user->prepareUserData(),
        ];
        return response()->json([
            'status' => 200,
            'message'=> 'Language Updated Successfully...',
            'data'   => $data,
        ], 200);

    }
    public function getSubAccounts(){
        // get only last_name, first_name and id of users
        $users = User::where('parent_id', Auth::user()->id)->get(['id','first_name','last_name','email']);
        return response()->json([
            'status' => 200,
            'message'=> 'Sub Accounts fetched successfully...',
            'data'   => $users,
        ], 200);
    }
    public function loginToSubAccount(Request $request){
        $user = User::where('id', $request->sub_account_id)->first();
        if($user){
            if($user->parent_id == Auth::user()->id){
                $user = User::with('professionalDetails','medicalDetails')->find(Auth::user()->id);
                $user_details = [];
                if($user->role == 'patient'){
                    $user_details = [
                        'personal_details' => $user->prepareUserData(),
                        'medical_details'  => $user->medicalDetails,
                    ];
                }
                $data = [
                    'sub_user'    => $user_details,
                    'token'   => $user->createToken('Med')->plainTextToken,
                ];
                // add role in user
                return response()->json([
                    'status'  => 202,
                    'message' => 'Login To Sub Account Successfully...',
                    'data'    => $data,
                ], 200);
            }else{
                return response()->json([
                    'status'  => 401,
                    'message' => 'You can not login to this sub account...',
                ], 401);
            }
        }else{
            return response()->json([
                'status'  => 401,
                'message' => 'Error...',
            ], 401);
        }
    }
    public function saveDeviceToken(Request $request){
        $user = User::find(Auth::user()->id);
        $user->device_token = $request->device_token;
        $user->save();
        return response()->json([
            'status' => 200,
            'message'=> 'Device Token Saved Successfully...',
        ], 200);
    }
}
