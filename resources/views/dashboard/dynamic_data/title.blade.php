@extends('dashboard.layouts.app')

@section('title')
    Professionals Titles
@endsection
@section('dynamic')
    active
@endsection
@section('dynamic.title')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Professionals Titles</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i>Dynamic Data</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Professionals Titles</li>
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
                        <div class="table-responsive rounded card-table">
                            <table class="table border-no" id="example1">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($title_array as $item)
                                        <tr class="hover-primary">
                                            <td>{{ $item }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="hover-primary dropdown-toggle no-caret"
                                                        data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="DeleteRecord(`{{ $item }}`)">Delete</a> 
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
    <!-- Modal -->
    <div class="modal fade" id="add_new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dynamic.title.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" name="title" class="form-control" id="name" placeholder="Enter Name">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            </div>
        </div>
        <!-- /.content -->
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
                    'dom': 'Bfrtip',
                    'buttons': [{
                        text: 'Add New Group',
                        className: 'waves-effect waves-light btn btn-sm btn-success mb-5', // Add your custom classes here
                        action: function(e, dt, node, config) {
                            $('#add_new').modal('show'); // Show the modal
                        }
                    }]
                })
            });

            function DeleteRecord(name) {
                $.ajax({
                    url : "{{ url('portal/dynamic/title/delete') }}"+"/"+name,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // reload page
                        location.reload();
                    }
                });
            }
            function SaveRecord(name) {
                $.ajax({
                    url : "{{ url('portal/dynamic/title/delete') }}"+"/"+name,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // reload page
                        location.reload();
                    }
                });
            }
        </script>
    @endsection