<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $like = Like::firstOrCreate([
            'user_id' => Auth::id(),
            'article_id' => $articleId,
        ]);
        $data = [
            'status' => 201, // add this line
            'message' => 'Like added successfully',
        ];

        return response()->json($data, 201);
    }

    public function destroy($articleId)
    {
        $like = Like::where([
            'user_id' => Auth::id(),
            'article_id' => $articleId,
        ])->firstOrFail();

        $like->delete();
        $data = [
            'status' => 204, // add this line
            'message' => 'Like deleted successfully',
        ];

        return response()->json($data, 200);
    }
}
