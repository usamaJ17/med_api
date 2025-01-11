<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\ArticleCategory;
use App\Models\Notifications;
use App\Models\Followers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function upload_file(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'uploads/' . $filename;

            // Move the file to the public/uploads directory
            $file->move(public_path('uploads'), $filename);
    
            $url = asset($filePath);


            return response()->json([
                'uploaded' => true,
                'url' => $url,
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'No file uploaded.',
            ],
        ]);
    }
    
    
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
    public function all_articles_for_web(Request $request)
    {
        $perPage = $request->input('per_page', 6); 
        $categoryId = $request->input('category_id');
        $orderBy = $request->input('order_by', 'desc');


        $query = Article::with('category')->where('published' , 1);
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        $query->orderBy('created_at', $orderBy);
        $articles = $query->paginate($perPage);
        // use for each $articles and update the profile url
        foreach ($articles as $article) {

        }
        $data = [
            'status' => 200,
            'message' => 'All Articles fetched successfully',
            'data' => [
                'articles' => $articles->items(),
                'pagination' => [
                    'total' => $articles->total(),
                    'count' => $articles->count(),
                    'per_page' => $articles->perPage(),
                    'current_page' => $articles->currentPage(),
                    'total_pages' => $articles->lastPage(),
                ],
            ],
        ];
        return response()->json($data, 200);
    }

    // public function all_articles_for_web(Request $request)
    // {

    //     $query = Article::with('category'); 
    //     $query->orderBy('created_at', 'DESC');
    //     $query->take(6);
    //     $articles = $query->get();
    //     $data = [
    //         'status' => 200,
    //         'message' => 'All Article fetched successfully',
    //         'data' => ['article' => $articles],
    //     ];
    //     return response()->json($data, 200);
    // }
    public function show_comments(Request $request, $id){
        $comments = Comment::with(['user'])->where('article_id', $id)->get();
        if ($comments->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No comments found for this article'
            ], 200);
        }
        $data = [
            'status' => 200,
            'message' => 'Article comments fetched successfully',
            'data' => ['comments' => $comments],
        ];

        return response()->json($data, 200);
    }

    public function index_web(Request $request)
    {

        $articles = Article::with('user')->get();
        $categories = ArticleCategory::all();
        // print_r($articles);
        return view('dashboard.article.index', compact(['articles', 'categories']));
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

    public function show_web(Request $request,  $category,  $slug)
    {
        $formattedCategory = strtolower(str_replace('-', ' ', $category));
        $categories = ArticleCategory::whereRaw('LOWER(name) = ?', [$formattedCategory])->first();
        if (!$categories) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found'
            ], 404);
        }

        $article = Article::with(['comments.user', 'likes'])
        ->whereRaw('slug = ?', [$slug])
        ->where('category_id', $categories->id)->first();

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
    public function store_web(Request $request){
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
            'slug' => $request->slug,
            'published' => 1,
        ]);
        if ($request->hasFile('thumbnail')) {
            $article->addMedia($request->file('thumbnail'))->toMediaCollection('thumbnails');
        }
        if ($request->hasFile('media')) {
            $article->addMedia($request->file('media'))->toMediaCollection('media');
        }
        return redirect()->route('articles.admin.index')->with('success', 'Article created successfully');
    }
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }
    public function update_web(Request $request, $id){
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required',
        ]);

        $article = Article::findOrFail($id);
        $article->update($request->all());

        // Handle file uploads
        if ($request->hasFile('thumbnail')) {
            $article->clearMediaCollection('thumbnails');
            $article->addMedia($request->file('thumbnail'))->toMediaCollection('thumbnails');
        }

        if ($request->hasFile('media')) {
            $article->clearMediaCollection('media');
            $article->addMedia($request->file('media'))->toMediaCollection('media');
        }

        return redirect()->route('articles.admin.index')->with('success', 'Article updated successfully.');
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
        $followers = Followers::where('user_id', Auth::user()->id)->get();

        $sender = User::find(Auth::user()->id); 
        foreach ($followers as $follower) {
            $notificationData = [
                'title' => 'Article Created',
                'description' => "<strong>Notification:</strong> Stay updated! $sender->first_name $sender->last_name has just posted a new article. Tap to read more in the Articles section.",
                'type' => 'Article',
                'from_user_id' => Auth::user()->id,
                'to_user_id' => $follower->follower_id,
                'is_read' => 0,
            ];        
            Notifications::create($notificationData);
        }
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
        $article->share_count = $article->share_count + 1;
        $article->save();
        $data = [
            'status' => 200,
            'message' => 'Article share count updated successfully',
        ];
        return response()->json($data, 200);
    }
}