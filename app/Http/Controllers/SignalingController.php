<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SignalingController extends Controller
{
    public function __construct()
    {
        if (!Session::has('peers')) {
            Session::put('peers', []);
        }
    }

    public function handleSignaling(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->json()->all();
            if (isset($data['peer_id'])) {
                $peers = Session::get('peers');
                $peers[$data['peer_id']] = $data;
                Session::put('peers', $peers);
                return response()->json(['status' => 'ok']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'peer_id missing']);
            }
        } elseif ($request->isMethod('get')) {
            $peer_id = $request->query('peer_id');
            $peers = Session::get('peers');
            if ($peer_id && isset($peers[$peer_id])) {
                return response()->json($peers[$peer_id]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'peer not found']);
            }
        }
    }
}
