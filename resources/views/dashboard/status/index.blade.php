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
                                        {{-- Show success message --}}
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                                        {{-- Show success message --}}
                    @if(session('error'))
                    <div class="alert alert-warning">
                        {{ session('error') }}
                    </div>
                    @endif
                    {{-- Status Table --}}
                    <div class="row">
                        <div class="col">
                            <h2>Statuses</h2>
                        </div>
                        <div class="col text-end">
                            <a href="{{route('status.create')}}" class="btn btn-primary">Create Status</a>
                        </div>
                    </div>

                    @if($statuses->isEmpty())
                    <div class="alert alert-info">No statuses uploaded</div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Preview</th>
                                    <th>Caption</th>
                                    <th>Uploaded At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statuses as $index => $status)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @php
                                        $extension = pathinfo($status->file_path, PATHINFO_EXTENSION);
                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                        $videoExtensions = ['mp4', 'mov', 'avi', 'webm', 'mkv'];
                                        @endphp

                                        @if(in_array(strtolower($extension), $imageExtensions))
                                        <img src="{{ asset('files/' . $status->file_path) }}" alt="Image" width="120">
                                        @elseif(in_array(strtolower($extension), $videoExtensions))
                                        <video width="200" controls>
                                            <source src="{{ asset('files/' . $status->file_path) }}" type="video/{{ $extension }}">
                                            Your browser does not support the video tag.
                                        </video>
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>{{ $status->caption }}</td>
                                    <td>{{ $status->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="d-flex">
                                        <a href="{{route('status.edit', $status->id)}}" class="btn btn-sm btn-warning"><i data-feather="edit"></i></a>
                                        <form action="{{ route('status.destroy', $status->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this status?');">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-sm btn-danger ms-2"><i data-feather="trash-2"></i></button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    @endif

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