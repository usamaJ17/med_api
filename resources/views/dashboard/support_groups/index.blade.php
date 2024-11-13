@extends('dashboard.layouts.app')

@section('title')
    Support Groups
@endsection
@section('support_groups')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Support Groups</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Support Groups</li>
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
                                        <th>Group ID</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Url</th>
                                        @if(auth()->user()->hasRole('admin'))
                                            <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groups as $group)
                                        <tr class="hover-primary">
                                            <td>GID-{{ $group->id }}</td>
                                            <td>{{ ucfirst($group->type) }}</td>
                                            <td>{{ $group->name }}</td>
                                            <td>{{ $group->description }}</td>
                                            <td>{{ $group->url }}</td>
                                            @if(auth()->user()->hasRole('admin'))
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="hover-primary dropdown-toggle no-caret"
                                                            data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                        <div class="dropdown-menu">
                                                            {{-- <a class="dropdown-item" href="{{ route('support_groups.edit',$patient->id ) }}">View Details</a> --}}
                                                            <a class="dropdown-item" onclick="DeleteRecord({{ $group->id }})">Delete</a>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('support_groups.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Type</label>
                            <select name="type" class="form-control" id="">
                                <option value="patient">Patients</option>
                                <option value="professional">Professionals</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="name">Description</label>
                            <input type="text" name="description" class="form-control" id="description" placeholder="Enter Description">
                        </div>
                        <div class="form-group">
                            <label for="name">Link</label>
                            <input type="text" name="url" class="form-control" id="url" placeholder="Enter URL">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Group </button>
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

            function DeleteRecord(id) {
                $.ajax({
                    url : "{{ url('portal/support_groups') }}"+"/"+id,
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
