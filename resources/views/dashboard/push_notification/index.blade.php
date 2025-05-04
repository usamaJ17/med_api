@extends('dashboard.layouts.app')

@section('title')
    Push notifications
@endsection
@section('push_notification')
    active
@endsection
@section('alerts.push_notification')
    active
@endsection
@section('css')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css"/>
    <style>
        .bootstrap-datetimepicker-widget {
            background-color: #1C2E4C !important; /* Light blue background */
            color: #ffffff !important; /* Black text */
            font-family: Arial, sans-serif;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 320px !important; /* Slightly wider for better layout */
            padding: 10px !important;
        }

        .bootstrap-datetimepicker-widget table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .bootstrap-datetimepicker-widget table thead tr th {
            background-color: #1C2E4C !important;
            color: #ffffff !important;
            padding: 8px !important;
            border: none !important;
        }

        .bootstrap-datetimepicker-widget table td {
            background-color: #1C2E4C !important;
            color: #ffffff !important;
            padding: 8px !important;
            text-align: center !important;
            border: none !important;
        }

        .bootstrap-datetimepicker-widget table td.day:hover {
            background-color: #36568f !important; /* Slightly darker blue on hover */
        }

        .bootstrap-datetimepicker-widget table td.active {
            background-color: #ffffff !important; /* Highlight selected day */
            color: #ffffff !important;
        }

        .bootstrap-datetimepicker-widget .timepicker {
            background-color: #1C2E4C !important;
            margin-top: 15px !important;
            padding: 10px !important;
            border-top: 1px solid #d1e8ff !important;
        }

        .bootstrap-datetimepicker-widget .timepicker-picker {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .bootstrap-datetimepicker-widget .timepicker-hour,
        .bootstrap-datetimepicker-widget .timepicker-minute,
        .bootstrap-datetimepicker-widget .timepicker-second {
            background-color: #1dbfc1 !important;
            color: #ffffff !important;
            font-size: 16px !important;
        }

        .bootstrap-datetimepicker-widget .separator {
            color: #1C2E4C !important;
        }

        .bootstrap-datetimepicker-widget a,
        .bootstrap-datetimepicker-widget a:hover {
            color: #ffffff !important;
            text-decoration: none !important;
        }

        .bootstrap-datetimepicker-widget .btn {
            background-color: #1C2E4C !important;
            color: #ffffff !important;
            border: none !important;
        }

        .bootstrap-datetimepicker-widget .btn:hover {
            background-color: #1C2E4C !important;
        }

        .bootstrap-datetimepicker-widget .picker-switch {
            background-color: #1C2E4C !important;
            color: #ffffff !important;
        }

        .bootstrap-datetimepicker-widget .picker-switch a {
            color: #ffffff !important;
        }
    </style>
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
                                    <th>Title</th>
                                    <th>To Role</th>
                                    <th>Body</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th>Scheduled At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($pushNotifications as $pushNotification)
                                    <tr class="hover-primary">
                                        <td>{{ $pushNotification->title }}</td>
                                        <td>{{ ucfirst($pushNotification->to_role) }}</td>
                                        <td>{{ $pushNotification->body }}</td>
                                        <td>
                                            @if($pushNotification->image_url)
                                                <a href="{{ $pushNotification->image_url }}" target="_blank">Open Image</a>
                                            @else
                                                No Image Uploaded
                                            @endif
                                        </td>
                                        <td>{{ $pushNotification->created_at->format('h:ia, j M Y') }}</td>
                                        <td>{{ $pushNotification->scheduled_at->format('h:ia, j M Y') }}</td>
                                        <td>
                                            @if(!$pushNotification->is_sent)
                                                <div class="btn-group">
                                                    <a class="hover-primary dropdown-toggle no-caret"
                                                       data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#" onclick="EditRecord({{ $pushNotification->id }})">Edit</a>
                                                        <a class="dropdown-item" onclick="DeleteRecord({{ $pushNotification->id }})">Delete</a>
                                                    </div>
                                                </div>
                                            @endif
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

    <!-- Add New Modal -->
    <div class="modal fade" id="add_new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Send New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('notification.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="type">To Role</label>
                            <select name="to_role" class="form-control" id="type">
                                <option value="patient">Patients</option>
                                <option value="professional">Professionals</option>
                                @foreach ($professsionalTypes as $type)
                                    <option value="{{ $type->name }}">{{ ucfirst($type->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="scheduled_at">Schedule At</label>
                            <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                <input type="text" name="scheduled_at" class="form-control datetimepicker-input" data-target="#datetimepicker" placeholder="Select Date and Time">
                                <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Notification Image (Optional)</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/jpeg,image/png,image/gif">
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
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Push Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_form" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label for="edit_type">To Role</label>
                            <select name="to_role" class="form-control" id="edit_type">
                                <option value="patient">Patients</option>
                                <option value="professional">Professionals</option>
                                @foreach ($professsionalTypes as $type)
                                    <option value="{{ $type->name }}">{{ ucfirst($type->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" name="title" class="form-control" id="edit_title" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="edit_scheduled_at">Schedule At</label>
                            <div class="input-group date" id="edit_datetimepicker" data-target-input="nearest">
                                <input type="text" name="scheduled_at" class="form-control datetimepicker-input" data-target="#edit_datetimepicker" id="edit_scheduled_at" placeholder="Select Date and Time">
                                <div class="input-group-append" data-target="#edit_datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_image">Notification Image (Upload to overwrite)</label>
                            <input type="file" name="image" class="form-control" id="edit_image" accept="image/jpeg,image/png,image/gif">
                        </div>
                        <div class="form-group">
                            <label for="edit_body">Body</label>
                            <textarea name="body" class="form-control" id="edit_body" placeholder="Enter Notification Body"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Notification</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"></script>
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
                    className: 'waves-effect waves-light btn btn-sm btn-success mb-5',
                    action: function(e, dt, node, config) {
                        $('#add_new').modal('show');
                    }
                }]
            });

            // Initialize datetimepicker for Add New modal
            $('#datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                minDate: moment(),
                sideBySide: true,
                useCurrent: false,
                widgetPositioning: {
                    horizontal: 'auto',
                    vertical: 'bottom'
                },
                buttons: {
                    showToday: false,
                    showClear: true,
                    showClose: true
                },
                icons: {
                    time: 'fa fa-clock',
                    date: 'fa fa-calendar',
                    up: 'fa fa-arrow-up',
                    down: 'fa fa-arrow-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-calendar-check',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                }
            });

            // Initialize datetimepicker for Edit modal
            $('#edit_datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                minDate: moment(),
                sideBySide: true,
                useCurrent: false,
                widgetPositioning: {
                    horizontal: 'auto',
                    vertical: 'bottom'
                },
                buttons: {
                    showToday: false,
                    showClear: true,
                    showClose: true
                },
                icons: {
                    time: 'fa fa-clock',
                    date: 'fa fa-calendar',
                    up: 'fa fa-arrow-up',
                    down: 'fa fa-arrow-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-calendar-check',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                }
            });
        });

        function EditRecord(id) {
            $.ajax({
                url: "{{ url('portal/notification') }}/" +id ,
                type: 'GET',
                success: function(response) {
                    // Populate the edit modal with the push notification data
                    $('#edit_id').val(response.id);
                    $('#edit_type').val(response.to_role);
                    $('#edit_title').val(response.title);
                    $('#edit_scheduled_at').val(moment(response.scheduled_at).format('YYYY-MM-DD HH:mm'));
                    $('#edit_body').val(response.body);
                    $('#edit_form').attr('action', "{{ url('portal/notification') }}/" + id);
                    $('#edit_modal').modal('show');
                }
            });
        }

        function DeleteRecord(id) {
            $.ajax({
                url: "{{ url('portal/notification') }}/" + id,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                }
            });
        }
    </script>
@endsection