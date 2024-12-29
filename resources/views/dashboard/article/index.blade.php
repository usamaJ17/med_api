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
                        <div class="table-responsive rounded card-table">
                            <table class="table border-no" id="example1">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $article)
                                        <tr class="hover-primary">
                                            <td>{{ $article->title }}</td>
                                            <td> 
                                                @if ($article->user)
                                                    {{ $article->user->fullName() }}
                                                @else
                                                    N/A
                                                @endif
                                            <td>
                                                @if ($article->published == 1)
                                                    <span style="color: green;">Approved</span>
                                                @else
                                                    <span style="color: red;">Rejected</span>
                                                @endif
                                            </td>
                                            <td><a href="{{ route('articles.admin.show', $article->id) }}" class="btn btn-sm btn-success">View</a></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="hover-primary dropdown-toggle no-caret"
                                                        data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            onclick="ChangeStatus({{ $article->id }},'approve')">Approve</a>
                                                        <a class="dropdown-item"
                                                            onclick="ChangeStatus({{ $article->id }},'reject')">Reject</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
            // Open modal to edit an existing reminder
            function editReminder(id, title, note, role) {
                $('#edit_title').val(title); // Set the title
                $('#edit_note').val(note); // Set the note
                $('#edit_role').val(role); // Set the role
                $('#editForm').attr('action', '/portal/reminder/' + id); // Set form action for update
                $('#form_method').val('PUT'); // Set form method for updating the reminder
                $('#edit_modal').modal('show'); // Show the modal
            }

            function ChangeStatus(id, status) {
                $.ajax({
                    url: "{{ url('portal/articles/status') }}",
                    type: 'POSt',
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        id: id
                    },
                    success: function(response) {
                        // reload page
                        location.reload();
                    }
                });
            }
        </script>
    @endsection
