@extends('dashboard.layouts.app')

@section('title')
Medicals Verification
@endsection
@section('medical')
active
@endsection
@section('medical.verify')
active
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h4 class="page-title">Medical Professionals Verification</h4>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Medical Professionals</li>
                        <li class="breadcrumb-item active" aria-current="page">Verification</li>
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
                                    <th>Type</th>
                                    <th>Rank</th>
                                    <th>Verification Requested At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medicals as $medical)
                                <tr class="hover-primary">
                                    <td>#p-DH-{{ $medical->id ?? 'N/A' }}</td>
                                    <td>{{ $medical->first_name ?? 'N/A' }} {{ $medical->last_name ?? 'N/A' }}</td>
                                    <td>{{ $medical->email ?? 'N/A' }}</td>
                                    <td>{{ $medical->contact ?? 'N/A' }}</td>
                                    <td>{{ $medical->professionalDetails->professions->name ?? 'N/A' }}</td>
                                    <td>{{ $medical->professionalDetails->ranks->name ?? 'N/A' }}</td>
                                    <td>{{ $medical->verification_requested_at ? \Carbon\Carbon::parse($medical->verification_requested_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="hover-primary dropdown-toggle no-caret" data-bs-toggle="dropdown">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('medical.show', $medical->id ) }}">View Details</a>
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
            'autoWidth': false
        })
    });

    function DeleteRecord(id) {
        $.ajax({
            url: "{{ url('portal/patient') }}" + "/" + id,
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