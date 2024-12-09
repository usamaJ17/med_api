@extends('dashboard.layouts.app')

@section('title')
    Professionals Docs
@endsection
@section('dynamic')
    active
@endsection
@section('dynamic.professional_docs')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Additional Professionals Docs</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i>Dynamic Data</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Additional Professionals Docs</li>
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
                                        {{-- <th>Required</th> --}}
                                        @if(auth()->user()->hasRole('admin'))
                                        <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($professional_docs_array as $item)
                                        <tr class="hover-primary">
                                            <td>{{ $item }}</td>
                                            @if(auth()->user()->hasRole('admin'))
                                            <td>
                                                <div class="btn-group">
                                                    <a class="hover-primary dropdown-toggle no-caret"
                                                        data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">
                                                    <a class="dropdown-item" onclick="editRecord('{{$item}}')">Edit</a> 
                                                    <a class="dropdown-item" onclick="DeleteRecord(`{{ $item }}`)">Delete</a> 
                                                    </div>
                                                </div>
                                            </td>
                                            @endif
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dynamic.professional_docs.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Document Title</label>
                            <input type="text" name="title" class="form-control" id="name" placeholder="Enter Document Name">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" action="{{ route('dynamic.professional_docs.update') }}"  method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="oldTitle" id="editOldName">
                        <div class="form-group">
                            <label for="editName" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editName" name="newTitle" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <!-- /.content -->
    @endsection
    @section('script')
        <script>
            function editRecord(name) {
                document.getElementById('editOldName').value = name;
                document.getElementById('editName').value = name;
                $('#editModal').modal('show')
            }
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
                        text: 'Add New Document',
                        className: 'waves-effect waves-light btn btn-sm btn-success mb-5', // Add your custom classes here
                        action: function(e, dt, node, config) {
                            $('#add_new').modal('show'); // Show the modal
                        }
                    }]
                })
            });

            function DeleteRecord(name) {
                $.ajax({
                    url : "{{ url('portal/dynamic/professional_docs/delete') }}"+"/"+name,
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
                    url : "{{ url('portal/dynamic/professional_docs/delete') }}"+"/"+name,
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
