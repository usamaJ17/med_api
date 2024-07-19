<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SignalingController extends Controller
{
    public function __construct()
    {
        if (!Session::has('sessions')) {
            Session::put('sessions', []);
        }
    }

    public function handleSignaling(Request $request, $sessionId)
    {
        $sessions = Session::get('sessions');

        if (!isset($sessions[$sessionId])) {
            $sessions[$sessionId] = ['peers' => []];
        }

        if ($request->isMethod('post')) {
            $data = $request->json()->all();
            if (isset($data['peer_id'])) {
                $sessions[$sessionId]['peers'][$data['peer_id']] = $data;
                Session::put('sessions', $sessions);
                return response()->json(['status' => 'ok']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'peer_id missing']);
            }
        } elseif ($request->isMethod('get')) {
            $peer_id = $request->query('peer_id');
            if ($peer_id && isset($sessions[$sessionId]['peers'][$peer_id])) {
                return response()->json($sessions[$sessionId]['peers'][$peer_id]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'peer not found']);
            }
        }
    }
}
