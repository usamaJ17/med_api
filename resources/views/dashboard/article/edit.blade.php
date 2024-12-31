@extends('dashboard.layouts.app')

@section('title')
    Article
@endsection
@section('article')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Article</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Article</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-body">                        
                        <form id="editArticleForm" action="{{ route('articles.admin.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                                @method('PUT')
                                <!-- Title Field -->
                                <div class="form-group">
                                    <label for="edit_title">Title</label>
                                    <input type="text" name="title" class="form-control" id="edit_title" value="{{ old('title', $article->title) }}" required>
                                </div>

                                <!-- Body Field -->
                                <div class="form-group">
                                    <label for="editor2">Body</label>
                                    <textarea id="editor1" name="body" rows="10" cols="80">{{ old('body', $article->body) }}</textarea>
                                </div>

                                <!-- Category Field -->
                                <div class="form-group">
                                    <label for="edit_category_id">Category</label>
                                    <select name="category_id" class="form-control" id="edit_category_id" required>
                                        <option value="" disabled>Select a Category</option>
                                        @foreach ($categories as $category)
                                        <option 
                                            value="{{ $category->id }}" 
                                            {{ $article->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Thumbnail Upload -->
                                <div class="form-group">
                                    <label for="edit_thumbnail" class="form-label">Thumbnail</label>
                                    <div class="input-group">
                                        <input type="file" name="thumbnail" class="form-control" id="edit_thumbnail" accept="image/*">
                                    </div>
                                </div>

                                <!-- Media Upload -->
                                <div class="form-group">
                                    <label for="edit_media" class="form-label">Upload Media</label>
                                    <div class="input-group">
                                        <input type="file" name="media" class="form-control" id="edit_media" accept="audio/*,video/*,image/*">
                                    </div>
                                    <small class="form-text text-muted">Supported formats: audio, video, images.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('articles.admin.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection