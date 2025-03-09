<?php

namespace App\Http\Controllers\Api;

use App\Helper\RtcTokenBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgoraCalling
{
    public function token(Request $request)
    {
        $appID = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $channelName = $request->channelName;
        $user = 0;
        $role = RtcTokenBuilder::RolePublisher;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = now()->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $data = [
              "rtcToken" => RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $user, $role, $privilegeExpiredTs),
              "channelName" => $channelName,
              "uid" => $user,
              "expireTime" => 3600
        ];
        return  response()->json($data);
    }
}