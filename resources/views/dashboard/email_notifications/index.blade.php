@extends('dashboard.layouts.app')

@section('title')
Email notifications
@endsection
@section('alerts')
active
@endsection
@section('alerts.email_notification')
active
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h4 class="page-title">Email notifications</h4>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Email notifications</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive rounded card-table">
                        <table class="table border-no" id="example1">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Email</th>
                                    <th>Scheduled At</th>
                                    <th>Status</th>
                                    <th>Sent At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emailNotifications as $emailNotification)
                                <tr class="hover-primary">
                                    <td>
                                        @if ($emailNotification->type == 'patient')
                                        Patient Email Verification
                                        @elseif ($emailNotification->type == 'medical')
                                        Medical Email Verification
                                        @elseif ($emailNotification->type == 'incomplete_user')
                                        Incomplete Profile
                                        @else
                                        Unknown Type
                                        @endif
                                    </td>
                                    <td>{{ $emailNotification->email }}</td>
                                    <td>{{ $emailNotification->scheduled_at->format('j F, h:i A')  }}</td>
                                    <td>
                                        @if ($emailNotification->status == 'sent')
                                        <span class="badge bg-success">Sent</span>
                                        @else
                                        <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($emailNotification->sent_at &&  $emailNotification->sent_at !=  null)
                                        {{ $emailNotification->sent_at->format('j F, h:i A') }}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="hover-primary dropdown-toggle no-caret"
                                                data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    onclick="DeleteRecord({{ $emailNotification->id }})">Delete</a>
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
            'autoWidth': false
        });
    });
    function DeleteRecord(id) {
        $.ajax({
            url: "{{ url('portal/email_notifications') }}",
            type: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}",
                id : id
            },
            success: function(response) {
                location.reload();
            }
        });
    }

</script>
@endsection