<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountController extends Controller
{
    public function getCount(Request $request)
    {
        $data = [
            'status' => 400,
            'message' => 'No type sent in request',
            'data' => []
        ];
        $user = auth()->user();

        if ($request->has("type") && $request->type == "articles") {

            $count = DB::table("articles")
                ->leftJoin("artcle_read_users", function ($join) use ($user) {
                    $join->on("artcle_read_users.article_id", "=", "articles.id")
                        ->where("artcle_read_users.user_id", "=", $user->id);
                })
                ->whereNull("artcle_read_users.id")
                ->count();
            $data["status"] = 200;
            $data["message"] = "Unread article count fetched successfully";
            $data["data"] = ["total_count" => $count];
        } else if ($request->has("type") && $request->type == "chat") {

            $count = DB::table("chat_box_messages")
                ->where(["to_user_id" => $user->id])
                ->where(["user_read" => 0])
                ->count();


            $data["status"] = 200;
            $data["message"] = "Unread messages count fetched successfully";
            $data["data"] = ["total_count" => $count];
        }

        return response()->json($data);
    }
}
