<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        if(!$articleId) return response()->json(['message' => 'Article not found'], 404);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'article_id' => $articleId,
            'content' => $request->content,
        ]);
        $data = [
            'message' => 'Comment added successfully',
            'comment' => $comment,
        ];

        return response()->json($data, 201);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        $data = [
            'message' => 'Comment deleted successfully',
        ];

        return response()->json($data, 200);
    }
}
