@extends('dashboard.layouts.app')

@section('title')
Patients
@endsection
@section('patient')
active
@endsection
@section('patient.all')
active
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h4 class="page-title">Patients</h4>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Patients</li>
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
                                    <th>Patient ID</th>
                                    <th>Patient Name</th>
                                    <th>Patient Email</th>
                                    <th>Patient Contact</th>
                                    <th>State</th>
                                    <th>Last Appointment Date</th>
                                    <th>Last Appointment Doctor</th>
                                    <th>Status</th>
                                    <th>Balance</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $patient)
                                <tr class="hover-primary">
                                    <td><a href="{{ route('patient.show', $patient->id ) }}">#p-DH-{{ $patient->id ?? 'N/A' }} </a></td>
                                    <td><a href="{{ route('patient.show', $patient->id ) }}">
                                            {{ $patient->first_name ?? 'N/A' }} {{ $patient->last_name ?? 'N/A' }}
                                        </a></td>
                                    <td>{{ $patient->email ?? 'N/A' }}</td>
                                    <td>{{ $patient->contact ?? 'N/A' }}</td>
                                    <td>{{ $patient->state ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($patient->created_at)->format('d/m/Y') ?? 'N/A' }}</td>
                                    <td>{{ $patient->first_name ?? 'N/A' }} {{ $patient->last_name ?? 'N/A' }}</td>
                                    <td><span class="badge badge-danger-light">New Patient</span></td>
                                    <td>{{ $patient->wallet->balance ?? '0.00' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="hover-primary dropdown-toggle no-caret" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addBalanceModal"
                                                    onclick="document.getElementById('patient_id').value = {{ $patient->id ?? '' }}">Add Balance</a>
                                                <a class="dropdown-item" href="{{ route('patient.show', $patient->id ) }}">View Details</a>
                                                @if(auth()->user()->hasRole('admin'))
                                                <a class="dropdown-item" onclick="DeleteRecord({{ $patient->id ?? '' }})">Delete</a>
                                                @endif
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
<div class="modal fade" id="addBalanceModal" tabindex="-1" aria-labelledby="addBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <form method="POST" action="{{ route('patient.addBalance') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBalanceModalLabel">Add Balance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Standard Form Submission -->
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="patient_id" name="patient_id">
                    <div class="mb-3">
                        <label for="balance" class="form-label">Balance Amount</label>
                        <input type="number" class="form-control" id="balance" name="balance" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Balance</button>
                </div>
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
            'autoWidth': false
        })
    });

    function DeleteRecord(id) {
        console.log(id);
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