@extends('dashboard.layouts.app')

@section('title')
Article Categories
@endsection
@section('dynamic')
    active
@endsection
@section('dynamic.article_category')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Article Categories</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i>Dynamic Data</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Article Categories</li>
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
                                        @if(auth()->user()->hasRole('admin'))
                                        <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($article_categories as $item)
                                        <tr class="hover-primary">
                                            <td>{{ $item->name }}</td>
                                            @if(auth()->user()->hasRole('admin'))
                                            <td>
                                                <div class="btn-group">
                                                    <a class="hover-primary dropdown-toggle no-caret"
                                                        data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">
                                                    <a class="dropdown-item" onclick="editRecord({{ $item->id }}, '{{$item->name}}')">Edit</a> 
                                                    <a class="dropdown-item" onclick="DeleteRecord({{ $item->id }})">Delete</a> 
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
                    <form action="{{ route('dynamic.article_category.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
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
                    <h5 class="modal-title" id="editModalLabel">Edit Consultation Summary</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" action="{{ route('dynamic.article_category.update') }}"  method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editId">
                        <div class="form-group">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
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
            function editRecord(id, name) {
                document.getElementById('editId').value = id;
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
                        text: 'Add New Category',
                        className: 'waves-effect waves-light btn btn-sm btn-success mb-5', // Add your custom classes here
                        action: function(e, dt, node, config) {
                            $('#add_new').modal('show'); // Show the modal
                        }
                    }]
                })
            });

            function DeleteRecord(id) {
                $.ajax({
                    url : "{{ url('portal/dynamic/article_category/delete') }}"+"/"+id,
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
