<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ArticleReadUser;
use App\Models\ChatBoxMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountController extends Controller
{
    public function markAsRead(Request $request)
    {
        $user = auth()->user();
        $data = [
            'status' => 400,
            'message' => 'No type sent in request',
            'data' => []
        ];
        if ($request->has("type") && $request->type == "articles") {
            $articleIds = DB::table('articles')
                ->whereNotIn('articles.id', function ($query) use ($user) {
                    $query->select('artcle_read_users.article_id')
                        ->from('artcle_read_users')
                        ->where('artcle_read_users.user_id', '=', $user->id);
                })
                ->pluck("articles.id");

            $articleIds = $articleIds->toArray();
            foreach ($articleIds as $id) {
                ArticleReadUser::create([
                    "user_id" => $user->id,
                    "article_id" => $id
                ]);
            }
            $data["status"] = 200;
            $data["message"] = "All Articles Mark as read successfully";
            $data["data"] = [];
        } else if ($request->has("type") && $request->type == "chat") {
            $messages = ChatBoxMessage::where(["to_user_id" => $user->id])->get();
            foreach ($messages as $message) {
                $message->user_read = 1;
                $message->save();
            }
            $data["status"] = 200;
            $data["message"] = "All Chat Messages marked as read successfully";
            $data["data"] = [];
        }

        return response()->json($data, $data["status"]);
    }


    public function getCount(Request $request)
    {
        $data = [
            'status' => 400,
            'message' => 'No type sent in request',
            'data' => []
        ];
        $user = auth()->user();

        if ($request->has("type") && $request->type == "articles") {

            $count = DB::table('articles')
                ->whereNotIn('articles.id', function ($query) use ($user) {
                    $query->select('artcle_read_users.article_id')
                        ->from('artcle_read_users')
                        ->where('artcle_read_users.user_id', '=', $user->id);
                })
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
