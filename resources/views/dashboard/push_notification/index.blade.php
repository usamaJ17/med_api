@extends('dashboard.layouts.app')

@section('title')
    Push notifications
@endsection
@section('push_notification')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Push notifications</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Push notifications</li>
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
                                    <th>Title</th>
                                    <th>To Role</th>
                                    <th>Body</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($pushNotifications as $pushNotification)
                                    <tr class="hover-primary">
                                        <td>{{ $pushNotification->title }}</td>
                                        <td>{{ $pushNotification->to_role }}</td>
                                        <td>{{ $pushNotification->body }}</td>
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

    <div class="modal fade" id="add_new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Send New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('notification.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">To Role</label>
                            <select name="to_role" class="form-control" id="">
                                <option value="patient">Patients</option>
                                <option value="professional">Professionals</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea name="body" class="form-control" id="body" placeholder="Enter Notification Body"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
                </form>
            </div>
        </div>
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
                    text: 'Send New Notification',
                    className: 'waves-effect waves-light btn btn-sm btn-success mb-5', // Add your custom classes here
                    action: function(e, dt, node, config) {
                        $('#add_new').modal('show'); // Show the modal
                    }
                }]
            })
            @if(Session::has('toast_success'))
                console.log("BEFORE POPUP ")
                $.toast({
                    heading: 'Push Notification Scheduled',
                    text: 'Push notification is scheduled and will be sent out soon.',
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif
        });
    </script>
@endsection
