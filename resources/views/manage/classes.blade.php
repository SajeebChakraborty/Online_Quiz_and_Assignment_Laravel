@extends('layouts.app')
@section('title', 'Manage class - TeckQuiz')
@section('content')
<style>
    body {
        padding-top: 70px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link active" id="v-pills-class" data-toggle="pill" href="#class-tab" role="tab" aria-controls="v-pills-class"
                        aria-expanded="true">Class</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="v-pills-class" data-toggle="pill" href="#quiz-tab" role="tab" aria-controls="v-pills-quizzes" aria-expanded="true">Quizzes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="v-pills-students" data-toggle="pill" href="#students-tab" role="tab" aria-controls="v-pills-students"
                        aria-expanded="true">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="v-pills-settings" data-toggle="pill" href="#settings-tab" role="tab" aria-controls="v-pills-settings"
                        aria-expanded="true">Settings</a>
                </li>
            </ul>
        </nav>

        <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
            <h3>{{ $quiz_class->subject->subject_code }}: {{ $quiz_class->subject->subject_desc }}</h3>
            <h5>
                <span class="badge badge-primary">{{ $quiz_class->course_sec }}</span>
            </h5>
            <hr>

            <div class="tab-content col" id="v-pills-tabContent">
                <div class="tab-pane fade show active row" id="class-tab" role="tabpanel" aria-labelledby="class-tab">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 pb-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h1 class="align-left display-1">{{ $quiz_class->class_id }}</h1>
                                    <p class="lead align-left">Class Code</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12 pb-3">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <p class="align-left display-1">{{ $quiz_events->count() }}</p>
                                    <p class="lead align-left"> Quiz{{ $quiz_events->count()
                                        <=1 ? '' : 'zes' }}</p>
                                </div>
                                <a class="card-footer text-white clearfix small z-1 text-center" href="">View quiz</a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12 pb-3">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <p class="align-left display-1">{{ $students->count() }}</p>
                                    <p class="lead align-left"> Student{{ $quiz_events->count()
                                        < 1 ? '' : 's' }}</p>
                                </div>
                                <a class="card-footer text-white clearfix small z-1 text-center" href="">View student list</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="quiz-tab" role="tabpanel" aria-lavelledby="quiz-tab">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th>Subject</th>
                                <th>Class</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quiz_events as $qe)
                            <tr id="quiz_entry{{ $qe->quiz_event_id }}">
                                <td>
                                    <a href="/quiz/{{ $qe->quiz_event_id }}">{{ $qe->quiz_event_name }}</a>
                                </td>
                                <td>{{ $qe->subject_desc }}</td>
                
                                @if($qe->quiz_event_status == 0)
                                <td id="status{{ $qe->quiz_event_id }}">Disabled</td>
                                @elseif($qe->quiz_event_status == 1)
                                <td id="status{{ $qe->quiz_event_id }}">Started</td>
                                @else
                                <td id="status{{ $qe->quiz_event_id }}">Ended</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="tab-pane fade" id="students-tab" role="tabpanel" aria-labelledby="students-tab">
                    <table class="table table-hover">
                        <thead class="thead">
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $s)
                            <tr>
                                <td>{{ $s->family_name }}, {{ $s->given_name }} {{ $s->ext_name }} {{ $s->middle_name }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#StudentProfileModal" data-usrid="{{ $s->usr_id }}"
                                        data-gname="{{ $s->given_name }}" data-fname="{{ $s->family_name }}" data-miname="{{ $s->middle_name }}"
                                        data-nename="{{ $s->ext_name }}">
                                        Edit
                                    </button>
                                    <button class="btn btn-primary btn-sm btn-danger" href="#">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                    <button class="btn btn-primary" data-toggle="modal" data-target="#AddNewStudentModal" disabled>
                        Add new student
                    </button>
                </div>
                
                <div class="tab-pane fade" id="settings-tab" role="tabpanel" aria-labelledby="settings-tab">
                    <h4>Advanced Settings</h4>
                    <div class="card" style="width: 40rem;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteClass" style="float: right">Delete this class</button>
                                <strong>Delete this class</strong>
                                <p>Once you delete this class, all quiz events that refers to this class will also be deleted.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<!-- Reset Student password Success Modal -->
<div class="modal fade" id="resetStudentPasswordSuccess" tabindex="-1" role="dialog" aria-labelledby="resetStudentPasswordSuccess"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Successful reset of password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Success! The password is resetted to:
                <b>password</b>
                <input type="hidden" id="t_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Reset Student password Confirmation Modal -->
<div class="modal fade" id="resetStudentPassword" tabindex="-1" role="dialog" aria-labelledby="resetStudentPassword" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm reset of password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to reset this teacher's password?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="ResetStudentPassword()">Reset password</button>
            </div>
        </div>
    </div>
</div>

<!-- Student Profile Modal -->
<div class="modal fade" id="StudentProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Student Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form">
                    <input type="hidden" id="usrid" value="-1">
                    <div class="form-group">
                        <label>Name:</label>
                        <div class="form-inline">
                            <input type="text" class="form-control m-1" placeholder="Family Name" id="f-name" style="width:12rem" disabled>
                            <input type="text" class="form-control m-1" placeholder="Given Name" id="g-name" style="width:12rem" disabled>
                            <input type="text" class="form-control m-1" placeholder="M.I." id="mi-name" style="width:4rem" disabled>
                            <input type="text" class="form-control m-1" placeholder="Extension Name" id="ne-name" style="width:12rem" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#resetStudentPassword">Reset password of this user</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="UpdateProfile">Update Profile</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Class Modal -->
<div class="modal fade" id="deleteClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this class? Any references to this class will also be deleted. This is
                <b>irreversible</b>.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deleteClass('{{ $quiz_class->class_id }}')">Delete class</button>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#StudentProfileModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var sid = button.data('usrid')
        var gname = button.data('gname')
        var fname = button.data('fname')
        var miname = button.data('miname')
        var nename = button.data('nename')
        var act = button.data('act')

        var modal = $(this)
        modal.find('#g-name').val(gname)
        modal.find('#f-name').val(fname)
        modal.find('#mi-name').val(miname)
        modal.find('#ne-name').val(nename)
        modal.find('#usrid').val(sid)
    });

    /*$('#UpdateProfile').click(function (){
        var modal = $(this)
        var g = $('#g-name').val()
        var f = $('#f-name').val()
        var mi = $('#mi-name').val()
        var ne = $('#ne-name').val()
        var sid = $('#usrid').val()
        var act = $('#act').val()
        
        $.ajax({
            url: '/student/update',
            type: 'POST',
            data: {g, f, mi, ne, sid, act},
            success: function(result) {
                location.reload(true);
            }
        });
    });*/

    function deleteClass(id) {
        $.ajax({
            url: '/class/' + id,
            type: 'DELETE', //type is any HTTP method
            success: function () {
                window.location = "/panel"
            }
        });
    }

    function ResetStudentPassword() {
        var s_id = $('#usrid').val();
        var password = "password";
        var update_type = 1;

        $.ajax({
            url: '/account/' + s_id,
            type: 'PUT', //type is any HTTP method
            data: {
                update_type, password
            }, //Data as js object
            success: function () {
                $('#resetStudentPassword').modal('hide')
                $('#resetStudentPasswordSuccess').modal('show')
            }
        });
    }

</script>
@endsection