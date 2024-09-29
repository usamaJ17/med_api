<?php

namespace App\Http\Controllers\Api;

use App\Custom\GraphFactory;
use App\Http\Controllers\Controller;
use App\Models\DynamicFiled;
use App\Models\Professions;
use App\Models\Ranks;
use App\Models\Tweek;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelperController extends Controller
{
    public function getRanks()
    {
        $ranks = Ranks::all();
        $data = [
            'status' => 200,
            'message' => 'All Ranks fetched successfully',
            'data' => $ranks,
        ];
        return response()->json($data, 200);
    }
    public function getProfessions()
    {
        $ranks = Professions::pluck('name', 'id')->toArray();
        $data = [
            'status' => 200,
            'message' => 'All Professions fetched successfully',
            'data' => ['professions' => $ranks],
        ];
        return response()->json($data, 200);
    }
    public function deleteAccount($id)
    {
        $user = null;
        if (!isset($id) || $id == null || $id == '') {
            $user = User::find(Auth::id());
        } else {
            $user = User::find($id);
        }
        $user->delete();
        $data = [
            'status' => 200,
            'message' => 'Account deleted successfully',
        ];
        return response()->json($data, 200);
    }
    public function changeActivation(Request $request)
    {
        $user = User::find($request->med_id);
        if ($request->is_live == true || $request->is_live == 'true') {
            $user->is_live = true;
        } elseif ($request->is_live == false || $request->is_live == 'false') {
            $user->is_live = false;
        }
        $user->save();
        $data = [
            'status' => 200,
            'message' => 'Account status changed successfully',
        ];
        return response()->json($data, 200);
    }
    public function getDeviceToken(Request $request){
        $user = User::find($request->user_id);
        return response()->json([
            'status' => 200,
            'message' => 'Device Token fetched successfully',
            'data' => $user->device_token,
        ], 200);
    }
    public function getProfessionalTitles()
    {
        $titles = DynamicFiled::where('name', 'professional_title')->first();
        if ($titles) {
            $title_array = json_decode($titles->data);
            $data = [
                'status' => 200,
                'message' => 'Professional Titles fetched successfully',
                'data' => $title_array,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 200,
                'message' => 'No Professional Titles found',
            ];
            return response()->json($data, 200);
        }
    }
    public function saveProfessionalTitles(Request $request)
    {
        $titles = DynamicFiled::where('name', 'professional_title')->first();
        if ($titles) {
            $tit_array = json_decode($titles->data);
            $tit_array[] = $request->title;
            $titles->data = json_encode($tit_array);
            $titles->save();
            $data = [
                'status' => 200,
                'message' => 'Professional Titles Added successfully',
            ];
            return response()->json($data, 200);
        } else {
            $tit_array = [];
            $tit_array[] = $request->title;
            $titles = new DynamicFiled();
            $titles->name = 'professional_title';
            $titles->data = json_encode($tit_array);
            $titles->save();
            $data = [
                'status' => 200,
                'message' => 'Professional Titles Added successfully',
            ];
            return response()->json($data, 200);
        }
    }
    public function sendSms(Request $request)
    {
        $curl = curl_init();
        $text = "Reminder: Your appointment with Dr. Bilawal rasheed is almost due. In 15 minutes, please open the Deluxe Hospital app and navigate to Chat section. See you soon";
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://sms.arkesel.com/api/v2/sms/send',
            CURLOPT_HTTPHEADER => ['api-key: ' . env('SMS_API_KEY')],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query([
                'sender' => 'Deluxe Hosp',
                'message' => $text,
                'recipients' => ['233249097605'],
                'sandbox' => true
            ]),
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        dd($response);
        echo $response;
    }
    public function getSdkKey()
    {
        return response()->json([
            'status' => 200,
            'message' => 'SDK Key fetched successfully',
            'data' => env('SDK_KEY')
        ], 200);
    }
    public function RequestVerification(Request $request)
    {
        $user = User::find(Auth::id());
        $user->verification_requested_at = now();
        $user->save();
        return response()->json([
            'status' => 200,
            'message' => 'Verification Request sent successfully',
        ], 200);
    }
    public function follow(Request $request)
    {
        $user = User::find(Auth::id());
        $follow = User::find($request->follow_id);
        $user->following()->attach($follow->id);
        return response()->json([
            'status' => 200,
            'message' => 'Followed successfully',
        ], 200);
    }
    public function unfollow(Request $request)
    {
        $user = User::find(Auth::id());
        $follow = User::find($request->follow_id);
        $user->following()->detach($follow->id);
        return response()->json([
            'status' => 200,
            'message' => 'Unfollowed successfully',
        ], 200);
    }
    public function getFollowers()
    {
        $user = User::find(Auth::id());
        $followers = $user->followers;
        return response()->json([
            'status' => 200,
            'message' => 'Followers fetched successfully',
            'data' => $followers,
        ], 200);
    }
    public function getFollowing()
    {
        $user = User::find(Auth::id());
        $following = $user->following;
        return response()->json([
            'status' => 200,
            'message' => 'Following fetched successfully',
            'data' => $following,
        ], 200);
    }
    public function checkFollow(Request $request)
    {
        $user = User::find(Auth::id());
        $follow = User::find($request->follow_id);
        $is_following = $user->following->contains($follow->id);
        return response()->json([
            'status' => 200,
            'message' => 'Follow status checked successfully',
            'data' => ['is_following' => $is_following],
        ], 200);
    }
    public function getTimeZone()
    {
        $timezones = DateTimeZone::listIdentifiers();
        $timezoneOffsets = [];

        foreach ($timezones as $timezone) {
            $datetime = new DateTime('now', new DateTimeZone($timezone));
            $offset = $datetime->getOffset();
            $hours = intdiv($offset, 3600);
            $minutes = abs($offset % 3600 / 60);
            $gmtOffset = 'GMT' . ($hours >= 0 ? '+' : '-') . sprintf('%02d:%02d', abs($hours), $minutes);
            $timezoneOffsets[$timezone] = "($gmtOffset) $timezone";
        }
        return response()->json([
            'status' => 200,
            'message' => 'Timezones fetched successfully',
            'data' => $timezoneOffsets,
        ], 200);
    }

    public function graphs(Request $request){
        $graphType = $request->input('type');
        $graphFactory = new GraphFactory();
        $graphData = $graphFactory->getGraphData($graphType);
        dd($graphData);
    
        return view('dashboard.index')->with(compact('patients','medicals','age','appointments','patientSignups','dailyPatientCountCat', 'total_revenue','total_monthly_revenue','medicalSignups','appointmentData','cancelAppointmentData','formattedDates','pro_cat_appointment'));
    }
    public function shareMessage(){
        // if role is patient
        if(Auth::user()->hasRole('patient')){
            $tweak = Tweek::where('type', 'patient_share_message')->first();
            return response()->json([
                'status' => 200,
                'message' => 'Share Message fetched successfully',
                'data' => $tweak->data,
                'media' => $tweak->getAllMedia()
            ]);
        }elseif(Auth::user()->hasRole('medical')){
            $tweak = Tweek::where('type', 'medical_share_message')->first();
            return response()->json([
                'status' => 200,
                'message' => 'Share Message fetched successfully',
                'data' => $tweak->data,
                'media' => $tweak->getAllMedia()
            ]);
        }
    }
}
