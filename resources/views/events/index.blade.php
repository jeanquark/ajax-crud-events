<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.jpg') }}">

    <!-- CSFR token for ajax call -->
    <meta name="_token" content="{{ csrf_token() }}"/>

    <title>Manage Posts</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    {{-- <link rel="styleeheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}

    <!-- icheck checkboxes -->
    <link rel="stylesheet" href="{{ asset('icheck/square/yellow.css') }}">
    {{-- <link rel="stylesheet" href="https://raw.githubusercontent.com/fronteed/icheck/1.x/skins/square/yellow.css"> --}}

    <!-- toastr notifications -->
    {{-- <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}"> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .panel-heading {
            padding: 0;
        }
        .panel-heading ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .panel-heading li {
            float: left;
            border-right:1px solid #bbb;
            display: block;
            padding: 14px 16px;
            text-align: center;
        }
        .panel-heading li:last-child:hover {
            background-color: #ccc;
        }
        .panel-heading li:last-child {
            border-right: none;
        }
        .panel-heading li a:hover {
            text-decoration: none;
        }

        .table.table-bordered tbody td {
            vertical-align: baseline;
        }
    </style>

</head>

<body>
    <div class="col-md-12 ">
        <h2 class="text-center">Manage Events</h2>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul>
                    <li><i class="fa fa-file-text-o"></i> All the current Events</li>
                    <a href="#" class="add-modal"><li>Add Event</li></a>
                </ul>
            </div>
        
            <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="eventTable" style="visibility: hidden;">
                        <thead>
                            <tr>
                                <th valign="middle">#</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Audience</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Is Published</th>
                                <th>Actions</th>
                            </tr>
                            {{ csrf_field() }}
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr class="item{{$event->id}} @if($event->is_published) warning @endif">
                                    <td class="col1">{{ $event->id }}</td>
                                    <td>{{ $event->name }}</td>
                                    <td>{{ $event->date }}</td>
                                    <td>{{ $event->type }}</td>
                                    <td>{{ $event->audience }}</td>
                                    <td>{{ $event->start_time }}</td>
                                    <td>{{ $event->end_time }}</td>
                                    <td class="text-center"><input type="checkbox" class="published" id="" data-id="{{$event->id}}" @if ($event->is_published) checked @endif></td>    
                                    <td>
                                        <button class="show-modal btn btn-success" data-id="{{$event->id}}" data-event="{{ $event }}">
                                            <span class="glyphicon glyphicon-eye-open"></span> Show
                                        </button>
                                        <button class="edit-modal btn btn-info" data-id="{{$event->id}}" data-event="{{ $event }}">
                                            <span class="glyphicon glyphicon-edit"></span> Edit
                                        </button>
                                        <button class="delete-modal btn btn-danger" data-id="{{$event->id}}" data-name="{{$event->name}}">
                                            <span class="glyphicon glyphicon-trash"></span> Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div><!-- /.panel-body -->
        </div><!-- /.panel panel-default -->
        <div class="text-center">
            <a href="/" class="btn btn-default">&larr; Back home</a>
        </div>

    </div><!-- /.col-md-12 -->

    <!-- Modal form to add an event -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="eventName">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name_add" autofocus>
                                <small>Min: 2, Max: 32, only text</small>
                                <p class="errorName text-center alert alert-default hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="eventType">Type:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="type_add" autofocus>
                                <small>Min: 2, Max: 32, only text</small>
                                <p class="errorType text-center alert alert-default hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="eventDate">Date:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_add" autofocus>
                                <small>Min: 2, Max: 32, only text</small>
                                <p class="errorDate text-center alert alert-default hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="eventStartTime">Start Time:</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" id="start_time_add" autofocus>
                                <small>Min: 2, Max: 32, only text</small>
                                <p class="errorStartTime text-center alert alert-default hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="eventEndTime">End Time:</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" id="end_time_add" autofocus>
                                <small>Min: 2, Max: 32, only text</small>
                                <p class="errorEndTime text-center alert alert-default hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="eventAudience">Audience:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="audience_add" autofocus>
                                <small>Min: 2, Max: 32, only text</small>
                                <p class="errorAudience text-center alert alert-default hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success add" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Add
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to show an event -->
    <div id="showModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="event_id_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="event_name_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="date">Date:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="event_date_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="type">Type:</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="event_type_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="audience">Audience:</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="event_audience_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="startTime">Start time:</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" id="event_start_time_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="endTime">End time:</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" id="event_end_time_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="isPublished">Is published?:</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="event_is_published_show" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to edit an event -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="event_id_edit" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="event_name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="event_name_edit" autofocus>
                                <p class="errorNameEdit text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="event_type">Type:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="event_type_edit">
                                <p class="errorTypeEdit text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="event_date">Date:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="event_date_edit" autofocus>
                                <p class="errorDateEdit text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="event_start_time">Start time:</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" id="event_start_time_edit">
                                <p class="errorStartTimeEdit text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="event_end_time">End time:</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" id="event_end_time_edit">
                                <p class="errorEndTimeEdit text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="event_audience">Audience:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="event_audience_edit">
                                <p class="errorAudienceEdit text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Edit
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to delete an event -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Are you sure you want to delete the following event?</h3>
                    <br />
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="event_id_delete" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="event_name_delete" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-trash'></span> Delete
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    {{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

    <!-- Bootstrap JavaScript -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/bootstrap.min.js"></script>

    <!-- toastr notifications -->
    {{-- <script type="text/javascript" src="{{ asset('toastr/toastr.min.js') }}"></script> --}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- icheck checkboxes -->
    <script type="text/javascript" src="{{ asset('icheck/icheck.min.js') }}"></script>

    <!-- Delay table load until everything else is loaded -->
   <!-- Delay table load until everything else is loaded -->
    <script>
        $(window).load(function(){
            $('#eventTable').removeAttr('style');
        })
    </script>

    <script>
        $(document).ready(function(){
            $('.published').iCheck({
                checkboxClass: 'icheckbox_square-yellow',
                radioClass: 'iradio_square-yellow',
                increaseArea: '20%'
            });
            $('.published').on('ifClicked', function(event){
                id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: "{{ URL::route('changeEventStatus') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': id
                    },
                    success: function(data) {
                        toastr.success('Event status successfully changed!', 'Success', {timeOut: 5000});
                    },
                });
            });
            $('.published').on('ifToggled', function(event) {
                $(this).closest('tr').toggleClass('warning');
            });
        });

    </script>

    <!-- AJAX CRUD operations -->
    <script type="text/javascript">
        // Add a new event
        $(document).on('click', '.add-modal', function() {
            $('.modal-title').text('Add');
            $('#addModal').modal('show');
        });
        $('.modal-footer').on('click', '.add', function() {
            $.ajax({
                type: 'POST',
                url: 'events',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'name': $('#name_add').val(),
                    'type': $('#type_add').val(),
                    'date': $('#date_add').val(),
                    'start_time': $('#start_time_add').val(),
                    'end_time': $('#end_time_add').val(),
                    'audience': $('#audience_add').val()
                },
                success: function(data) {
                    $('.errorName').addClass('hidden');
                    $('.errorType').addClass('hidden');
                    $('.errorDate').addClass('hidden');
                    $('.errorStartTime').addClass('hidden');
                    $('.errorEndTime').addClass('hidden');
                    $('.errorAudience').addClass('hidden');

                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#addModal').modal('show');
                            toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                        }, 500);

                        if (data.errors.name) {
                            $('.errorName').removeClass('hidden');
                            $('.errorName').text(data.errors.name);
                        }
                        if (data.errors.type) {
                            $('.errorType').removeClass('hidden');
                            $('.errorType').text(data.errors.type);
                        }
                        if (data.errors.date) {
                            $('.errorDate').removeClass('hidden');
                            $('.errorDate').text(data.errors.date);
                        }
                        if (data.errors.start_time) {
                            $('.errorStartTime').removeClass('hidden');
                            $('.errorStartTime').text(data.errors.start_time);
                        }
                        if (data.errors.end_time) {
                            $('.errorEndTime').removeClass('hidden');
                            $('.errorEndTime').text(data.errors.end_time);
                        }
                        if (data.errors.audience) {
                            $('.errorAudience').removeClass('hidden');
                            $('.errorAudience').text(data.errors.audience);
                        }
                    } else {
                        toastr.success('Successfully added Event!', 'Success Alert', {timeOut: 5000});
                        $('#eventTable').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td>" + data.date + "</td><td>" + data.type + "</td><td>" + data.audience + "</td><td>" + data.start_time + "</td><td>" + data.end_time + "</td><td class='text-center'><input type='checkbox' class='new_published' data-id='" + data.id + " '></td><td><button class='show-modal btn btn-success' data-id='" + data.id + "' data-event='" + JSON.stringify(data) + "'><span class='glyphicon glyphicon-eye-open'></span> Show</button> <button class='edit-modal btn btn-info' data-id='" + data.id + "' data-event='" + JSON.stringify(data) + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                        $('.new_published').iCheck({
                            checkboxClass: 'icheckbox_square-yellow',
                            radioClass: 'iradio_square-yellow',
                            increaseArea: '20%'
                        });
                        $('.new_published').on('ifToggled', function(event){
                            $(this).closest('tr').toggleClass('warning');
                        });
                        $('.new_published').on('ifChanged', function(event){
                            id = $(this).data('id');
                            $.ajax({
                                type: 'POST',
                                url: "{{ URL::route('changeStatus') }}",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'id': id
                                },
                                success: function(data) {
                                    // empty
                                },
                            });
                        });
                    }
                },
            });
        });

        // Show an event
        $(document).on('click', '.show-modal', function() {
            var event = $(this).data('event');
            $('.modal-title').text('Show');
            $('#event_id_show').val(event.id);
            $('#event_name_show').val(event.name);
            $('#event_type_show').val(event.type);
            $('#event_date_show').val(event.date);
            $('#event_start_time_show').val(event.start_time);
            // $('#event_start_time_show').val('10:00');
            $('#event_end_time_show').val(event.end_time);
            $('#event_audience_show').val(event.audience);
            $('#event_is_published_show').val(event.is_published);
            $('#showModal').modal('show');
        });


        // Edit an event
        $(document).on('click', '.edit-modal', function() {
            var event = $(this).data('event');
            $('.modal-title').text('Edit');
            $('#event_id_edit').val(event.id);
            $('#event_name_edit').val(event.name);
            $('#event_type_edit').val(event.type);
            $('#event_date_edit').val(event.date);
            $('#event_start_time_edit').val(event.start_time);
            $('#event_end_time_edit').val(event.end_time);
            $('#event_audience_edit').val(event.audience);
            id = $('#event_id_edit').val();
            $('#editModal').modal('show');
        });
        $('.modal-footer').on('click', '.edit', function() {
            var ename= $('#event_edit').val();
            $.ajax({
                type: 'PUT',
                url: 'events/' + id,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $("#event_id_edit").val(),
                    'name': $("#event_name_edit").val(),
                    'type': $("#event_type_edit").val(),
                    'date': $("#event_date_edit").val(),
                    'start_time': $("#event_start_time_edit").val(),
                    'end_time': $("#event_end_time_edit").val(),
                    'audience': $("#event_audience_edit").val(),

                },
                success: function(data) {
                    $('.errorNameEdit').addClass('hidden');
                    $('.errorDateEdit').addClass('hidden');
                    $('.errorTypeEdit').addClass('hidden');
                    $('.errorStartTimeEdit').addClass('hidden');
                    $('.errorEndTimeEdit').addClass('hidden');
                    $('.errorAudienceEdit').addClass('hidden');
                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#editModal').modal('show');
                            toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                        }, 500);

                        if (data.errors.name) {
                            $('.errorNameEdit').removeClass('hidden');
                            $('.errorNameEdit').text(data.errors.name);
                        }
                        if (data.errors.date) {
                            $('.errorDateEdit').removeClass('hidden');
                            $('.errorDateEdit').text(data.errors.date);
                        }
                        if (data.errors.type) {
                            $('.errorTypeEdit').removeClass('hidden');
                            $('.errorTypeEdit').text(data.errors.type);
                        }
                        if (data.errors.audience) {
                            $('.errorAudienceEdit').removeClass('hidden');
                            $('.errorAudienceEdit').text(data.errors.audience);
                        }
                        if (data.errors.start_time) {
                            $('.errorStartTimeEdit').removeClass('hidden');
                            $('.errorStartTimeEdut').text(data.errors.start_time);
                        }
                        if (data.errors.end_time) {
                            $('.errorEndTimeEdit').removeClass('hidden');
                            $('.errorEndTimeEdit').text(data.errors.end_time);
                        }                        
                    } else {
                        toastr.success('Successfully updated Event ' + data.name, 'Success Alert', {timeOut: 5000});
                        $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td>" + data.date + "</td><td>" + data.type + "</td><td>" + data.audience + "</td><td>" + data.start_time + "</td><td>" + data.end_time + "</td><td class='text-center'><input type='checkbox' class='edit_published' data-id='" + data.id + "'></td><td><button class='show-modal btn btn-success' data-id='" + data.id + "' data-event='" + JSON.stringify(data) + "'><span class='glyphicon glyphicon-eye-open'></span> Show</button> <button class='edit-modal btn btn-info' data-id='" + data.id + "' data-event='" + JSON.stringify(data) + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                        if (data.is_published) {
                            $('.edit_published').prop('checked', true);
                            $('.edit_published').closest('tr').addClass('warning');
                        }
                        $('.edit_published').iCheck({
                            checkboxClass: 'icheckbox_square-yellow',
                            radioClass: 'iradio_square-yellow',
                            increaseArea: '20%'
                        });
                    }
                }
            });
        });

        // Delete an event
        $(document).on('click', '.delete-modal', function() {
            $('.modal-title').text('Delete');
            $('#event_id_delete').val($(this).data('id'));
            $('#event_name_delete').val($(this).data('name'));
            $('#deleteModal').modal('show');
            id = $('#event_id_delete').val();
        });
        $('.modal-footer').on('click', '.delete', function() {
            $.ajax({
                type: 'DELETE',
                url: 'events/' + id,
                data: {
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data) {
                    toastr.success('Successfully deleted Event!', 'Success Alert', {timeOut: 5000});
                    $('.item' + data['id']).remove();
                }
            });
        });
    </script>

</body>
</html>