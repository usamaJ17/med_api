@extends('dashboard.layouts.app')

@section('title')
    Statuses
@endsection
@section('status')
    active
@endsection
@section('status.index')
    active
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h2 class="h4">Active Statuses</h2>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table border-no" id="index_table">
                    <thead>
                    <tr>
                        <th>Posted By</th>
                        <th>Caption</th>
                        <th>Created At</th>
                        <th>Media</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($statuses as $status)
                        <tr>
                            <td>{{ $status->user->fullName() }}</td>
                            <td>{{ $status->caption }}</td>
                            <td>{{ $status->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                        onclick="showStatusMedia('{{ $status->getFirstMediaUrl('status_media') }}', '{{ Str::endsWith($status->getFirstMediaUrl('status_media'), '.mp4') ? 'video' : 'image' }}')">
                                    View Status
                                </button>
                            </td>
                            <td>
                                <form action="{{ route('status.admin.destroy', $status->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="mediaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Status Media</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" id="mediaContainer">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function showStatusMedia(url, type) {
            const container = document.getElementById('mediaContainer');
            container.innerHTML = ''; // Clear existing content

            if (type === 'video') {
                container.innerHTML = `
                <video width="100%" controls>
                    <source src="${url}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>`;
            } else {
                container.innerHTML = `<img src="${url}" class="img-fluid" />`;
            }

            $('#mediaModal').modal('show');
        }

        $(function() {
            'use strict';
            $('#index_table').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        });
    </script>
@endsection
