<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        if(!$articleId) return response()->json(['status'=>404 , 'message' => 'Article not found'], 404);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'article_id' => $articleId,
            'content' => $request->content,
        ]);
        $likes = Like::where('article_id', $articleId)->get();
        foreach ($likes as $like) {
            $notificationData = [
                'title' => 'Article Comment',
                'description' => "<strong>Notification:</strong> A new comment has been added to an article you liked. Tap here to join the discussion in the Articles section.",
                'type' => 'Article',
                'from_user_id' => Auth::id(),
                'to_user_id' => $like->user_id,
                'is_read' => 0,
            ];        
            Notifications::create($notificationData);
        }
        $data = [
            'status' => 201, // add this line
            'message' => 'Comment added successfully',
            'data' => ['comment'=>$comment],
        ];

        return response()->json($data, 201);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        $data = [
            'message' => 'Comment deleted successfully',
            'status' => 200, // add this line
        ];

        return response()->json($data, 200);
    }
    public function getComments($article_id){
        $comments = Comment::with('user')->where('article_id',$article_id)->get();
        $data = [
            'status' => 200,
            'message' => 'All comments fetched successfully',
            'data' => ['comments'=>$comments],
        ];
        return response()->json($data, 200);
    }
}
