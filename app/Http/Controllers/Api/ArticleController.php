<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::get();
        $data = [
            'status' => 200, // add this line
            'message' => 'All Article fetched successfully',
            'article' => $article,
        ];
        return response()->json(['article'=>$data],200);
    }

    public function show($id)
    {
        $article = Article::with(['comments.user', 'likes'])->find($id);
        if(!$article) return response()->json([
            'status' => 404, // add this line
            'message'=>'Article not found'],404);
        $data = [
            'status' => 200, // add this line
            'message' => 'Article fetched successfully',
            'article' => $article,
        ];
        return response()->json(['article'=>$data],200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'thumbnail' => 'required|image',
        ]);

        $article = Article::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'body' => $request->body,
        ]);

        if ($request->hasFile('thumbnail')) {
            $article->addMedia($request->file('thumbnail'))->toMediaCollection('thumbnails');
        }
        $data = [
            'status' => 200, // add this line
            'message' => 'Article created successfully',
            'article' => $article,
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
            'thumbnail' => 'sometimes|image',
        ]);

        $article->update($request->only('title', 'body'));

        if ($request->hasFile('thumbnail')) {
            $article->clearMediaCollection('thumbnails');
            $article->addMedia($request->file('thumbnail'))->toMediaCollection('thumbnails');
        }
        $data = [
            'status' => 200, // add this line
            'message' => 'Article updated successfully',
            'article' => $article,
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        $data = [
            'status' => 200, // add this line
            'message' => 'Article deleted successfully',
        ];
        return response()->json($data, 200);
    }
}
