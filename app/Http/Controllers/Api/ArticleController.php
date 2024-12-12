<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function getArticleCategories(Request $request)
    {
        $categories = ArticleCategory::all();
        $data = [
            'status' => 200, // add this line
            'message' => 'All Article Categories fetched successfully',
            'data' => ['categories' => $categories],
        ];
        return response()->json($data, 200);
    }
    public function index(Request $request)
    {

        $query = Article::query(); 
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('order_by')) {
            if ($request->order_by === 'newest') {
                $query->orderBy('created_at', 'DESC');
            } elseif ($request->order_by === 'oldest') {
                $query->orderBy('created_at', 'ASC');
            }
        }
        $articles = $query->get();
        $data = [
            'status' => 200,
            'message' => 'All Article fetched successfully',
            'data' => ['article' => $articles],
        ];
        return response()->json($data, 200);
    }
    public function status(Request $request)
    {
        $article = Article::find($request->id);
        if ($request->status == 'approve') {
            $article->published = 1;
        } elseif ($request->status == 'reject') {
            $article->published = 0;
        }
        $article->save();
        return redirect()->back()->with('success', 'Article status updated successfully');
    }

    public function show(Request $request,  $id)
    {
        $article = Article::with(['comments.user', 'likes'])->find($id);
        if (!$article) return response()->json([
            'status' => 404,
            'message' => 'Article not found'
        ], 404);
        $data = [
            'status' => 200, 
            'message' => 'Article fetched successfully',
            'data' => ['article' => $article],
        ];
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($data, 200);
        }
        return view('dashboard.article.show', compact('article'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|string',
        ]);

        $article = Article::create([
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'body' => $request->body,
        ]);

        if ($request->hasFile('thumbnail')) {
            $article->addMedia($request->file('thumbnail'))->toMediaCollection('thumbnails');
        }
        if ($request->hasFile('video')) {
            $article->addMedia($request->file('video'))->toMediaCollection('video');
        }
        $data = [
            'status' => 200, // add this line
            'message' => 'Article created successfully',
            'data' => ['article' => $article],
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|string',
            'body' => 'sometimes|required|string',
            'thumbnail' => 'sometimes|image',
        ]);

        $article->update($request->only('title', 'body', 'category_id'));

        if ($request->hasFile('thumbnail')) {
            $article->clearMediaCollection('thumbnails');
            $article->addMedia($request->file('thumbnail'))->toMediaCollection('thumbnails');
        }
        if ($request->hasFile('video')) {
            $article->clearMediaCollection('video');
            $article->addMedia($request->file('video'))->toMediaCollection('video');
        }
        $data = [
            'status' => 200, // add this line
            'message' => 'Article updated successfully',
            'data' => ['article' => $article],
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
    public function addShare($article_id)
    {
        $article = Article::find($article_id);
        $article->shares = $article->shares + 1;
        $article->save();
        $data = [
            'status' => 200,
            'message' => 'Article share count updated successfully',
        ];
        return response()->json($data, 200);
    }
}