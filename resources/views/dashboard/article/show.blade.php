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
                      {!! $article->body !!}
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
