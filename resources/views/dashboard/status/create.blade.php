@extends('dashboard.layouts.app')

@section('title')
Status
@endsection
@section('statuses')
active
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h4 class="page-title">Status</h4>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Status</li>
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
                <div class="box-body">
                    <h2>Upload File</h2>

                    {{-- Show success message --}}
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-warning">
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('status.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- File Input --}}
                        <div class="mb-3">
                            <label for="file_path" class="form-label">Choose File</label>
                            <input type="file" class="form-control @error('file_path') is-invalid @enderror" id="file_path" name="file_path">
                            @error('file_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Caption --}}
                        <div class="mb-3">
                            <label for="caption" class="form-label">Caption</label>
                            <input type="text" class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" value="{{ old('caption') }}">
                            @error('caption')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    $(function() {
        'use strict';
        $('#example1').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
        })
    });
</script>
@endsection