@extends('dashboard.layouts.app')

@section('title')
    Medicals
@endsection
@section('medical')
    active
@endsection
@section('medical.all')
    active
@endsection
@section('content')
      <!-- Content Header (Page header) -->	  
      <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Medical Professionals</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Medical Professionals</li>
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
                                        <th>Professional ID</th>
                                        <th>Professionals Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>State</th>
                                        <th>Type</th>
                                        <th>Rank</th>
                                        <th>Last Appointment Date</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medicals as $medical)
                                        <tr class="hover-primary">
                                            <td><a href="{{ route('medical.show',$medical->id ) }}"> #p-DH-{{ $medical->id }} </a></td>
                                            <td><a href="{{ route('medical.show',$medical->id ) }}">{{ $medical->first_name . $medical->last_name }} </a></td>
                                            <td>{{ $medical->email }}</td>
                                            <td>{{ $medical->contact }}</td>
                                            <td>{{ $medical->state }}</td>
                                            <td>{{ $medical->professionalDetails->professions->name }}</td>
                                            <td>{{ $medical->professionalDetails->ranks->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($medical->created_at)->format('d/m/Y')}}</td>
                                            <td><span class="badge @if($medical->is_verified) badge-success-light @else badge-danger-light @endif">@if($medical->is_verified) Verified @else Un-Verified @endif</span></td>
                                            <td>												
                                                <div class="btn-group">
                                                <a class="hover-primary dropdown-toggle no-caret" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('medical.show',$medical->id ) }}">View Details</a>
                                                    <a class="dropdown-item" onclick="DeleteRecord({{ $medical->id }})">Delete</a>
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
    <div class="modal fade" id="add_new"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Export Option</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('medical.export') }}" method="GET">
                        @csrf
                        <div class="form-group">
                            <label for="name">Fields</label>
                            <select class="form-control select2" multiple="" name="fields[]" data-placeholder="Select Columns" style="width: 100%;" aria-hidden="true">
                                @foreach ($fields as $key => $field)
                                    <option value="{{ $key }}">{{ $field }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Download Excel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.content -->
@endsection
@section('script')
    <script>
        $(function () {
            'use strict';
            $('#example1').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                'dom': 'Bfrtip',
                'buttons': [
                    {
                        text: 'Export Data',
                        className: 'waves-effect waves-light btn btn-sm btn-success mb-5', // Add your custom classes here
                        action: function(e, dt, node, config) {
                            $('#add_new').modal('show'); // Show the modal
                        }
                    }
                ]
            })
        });
        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $("#add_new")
            });
        });
        function DeleteRecord(id){
            console.log(id);
            $.ajax({
                url : "{{ url('portal/patient') }}"+"/"+id,
                type : 'DELETE',
                data : {
                    _token : "{{ csrf_token() }}"
                },
                success : function(response){
                    // reload page
                    location.reload();
                }
            });
        }
    </script>
@endsection