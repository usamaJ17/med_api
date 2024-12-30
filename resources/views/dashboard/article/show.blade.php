@extends('dashboard.layouts.app')

@section('title')
    Article Details
@endsection
@section('article')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Article Details</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Article</li>
                            <li class="breadcrumb-item active" aria-current="page">Article Details</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">{{ $article->title }}</h4>
                </div>
                <div class="box-body">
                    <!-- Show Thumbnail -->
                    @if($article->getFirstMediaUrl('thumbnails'))
                        <div class="mb-3">
                            <img src="{{ $article->getFirstMediaUrl('thumbnails') }}" alt="Thumbnail" class="img-fluid" style="max-width: 100%; height: auto;">
                        </div>
                    @endif
                    
                    <!-- Article Body -->
                    {!! $article->body !!}
                    
                    <!-- Show Media Files -->
                    <div class="media-files mt-4">
                        @foreach($article->getMedia('media') as $media)
                            @if(str_contains($media->mime_type, 'image'))
                                <div class="mb-3">
                                    <img src="{{ $media->getUrl() }}" alt="Media Image" class="img-fluid" style="max-width: 100%; height: auto;">
                                </div>
                            @elseif(str_contains($media->mime_type, 'video'))
                                <div class="mb-3">
                                    <video controls style="max-width: 100%; height: auto;">
                                        <source src="{{ $media->getUrl() }}" type="{{ $media->mime_type }}">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @elseif(str_contains($media->mime_type, 'audio'))
                                <div class="mb-3">
                                    <audio controls style="width: 100%;">
                                        <source src="{{ $media->getUrl() }}" type="{{ $media->mime_type }}">
                                        Your browser does not support the audio tag.
                                    </audio>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    Author : {{ $article->user->fullName() }}
                </div>
                <!-- /.box-footer-->
            </div>
        </div>
    </div>
</section>

    <!-- /.content -->
@endsection
@section('script')
@endsection
