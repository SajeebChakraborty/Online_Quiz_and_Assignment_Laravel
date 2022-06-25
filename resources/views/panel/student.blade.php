@extends('layouts.app')
@section('title', 'Quiz - TeckQuiz')
@section('content')
<style>
    main{
        padding-top: 2.5rem;
    }
</style>
<main>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#pending" role="tab" aria-controls="v-pills-home"
                            aria-expanded="true">Pending Quiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#upcoming" role="tab" aria-controls="v-pills-profile"
                            aria-expanded="true">Upcoming Quiz</a>
                    </li>
                    <!--
                    <li class="nav-item">
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#quiz-result" role="tab" aria-controls="v-pills-profile"
                            aria-expanded="true">Quiz Result</a>
                    </li>
                    -->
                    <li class="nav-item">
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#assignment" role="tab" aria-controls="v-pills-profile"
                            aria-expanded="true">Assignment</a>
                    </li>
                  
                    <li class="nav-item">
                        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#settings" role="tab" aria-controls="v-pills-settings"
                            aria-expanded="true">Settings</a>
                    </li>
                </ul>
            </nav>

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                <div class="tab-content col" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="quiz-events">
                    <p>

<!-- for showing success message-->
@if(Session::has('success'))
<div class="alert alert-success">
{{Session::get('success')}}
</div>
@endif

<!--end for showing success message-->
<!-- for showing wrong password message-->
@if(Session::has('wrong'))
<div class="alert alert-danger">

{{Session::get('warning')}}

</div>
@endif


</p>    
                    
                    
                    <h3>Pending Quizzes</h3>
                        <div class="col container row mb-2">
                            <!-- Example of a quiz event entry -->
                            <div class="col-6 quiz-event">
                                @foreach ($pending_quiz as $pq)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $pq->quiz_event_name }}</h4>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $pq->subject_desc }}</h6>
                                        <a href="/take/{{ $pq->quiz_event_id }}" class="btn btn-outline-primary">Start</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="manage-class">
                        <h3>Upcoming Quizzes</h3>
                        <div class="col container row mb-2">
                            <!-- Example of a quiz event entry -->
                            <div class="col-6 quiz-event">
                                @foreach ($upcoming_quiz as $uq)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $uq->quiz_event_name }}</h4>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $uq->subject_desc }}</h6>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="quiz-result" role="tabpanel" aria-labelledby="manage-class">
                        <h3>Quiz Result</h3>
                        <div class="col container row mb-2">
                            <!-- Example of a quiz event entry -->
                            <div class="col-6 quiz-event">
                                @foreach ($pending_quiz as $uq)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $uq->quiz_event_name }}</h4>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $uq->subject_desc }}</h6>
                                        <a href="/quiz/{{ $pq->quiz_event_id }}" class="btn btn-outline-primary">Result</a>

                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                   

                    <div class="tab-pane fade" id="assignment" role="tabpanel" aria-labelledby="quiz-events">
                        <h3>Assignments</h3>
                        <div class="col container row mb-2">
                            <!-- Example of a quiz event entry -->
                            <div class="col-6 quiz-event">
                                @foreach ($assignment as $pq)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $pq->assignment_even_name }}</h4>
                                        <h5 class="card-subtitle mb-2 text-muted">{{ $pq->subject_desc }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Last submission date : {{ $pq->assignment_last_date }}</h6>
                                        <a href="/assignment/take/{{ $pq->assignment_event_id }}" class="btn btn-outline-primary">Turn in</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings">
                        <h3>Advanced Settings</h3>
                            <div class="card" style="width: 40rem;">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#changePassword" style="float: right">Change password</button>
                                        <strong>Change password</strong>
                                        <p>This will allow you to change your password.</p>
                                    </li>
                                    <li class="list-group-item">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#joinClass" style="float: right">Join another class</button>
                                        <strong>Join another class</strong>
                                        <p>This will allow you to join an existing class in order to take that class' quizzes.</p>
                                    </li>
                                </ul>
                            </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</main>
<!-- Change password modal -->
<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePassword" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Current password</label>
                    <input id="pwd" type="password" class="form-control">
                    <div class="invalid-feedback">
                        Input your correct password.
                    </div>
                </div>
                <div class="form-group">
                    <label for="">New password</label>
                    <input id="pwd_new" type="password" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="changePassword()">Change password</button>
            </div>
        </div>
    </div>
</div>
<!-- Change password modal -->
<div class="modal fade" id="joinClass" tabindex="-1" role="dialog" aria-labelledby="joinClass" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Join class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Class Code</label>
                    <input id="class_code" type="text" class="form-control">
                    <div class="invalid-feedback">
                        Either this is an invalid class code or you have already joined.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="joinClass()">Join Class</button>
            </div>
        </div>
    </div>
</div>
<!-- Change password Success Modal -->
<div class="modal fade" id="changePasswordSuccess" tabindex="-1" role="dialog" aria-labelledby="changePasswordSuccess"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Success!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Password changed successfully!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    function changePassword(){
        var oldPass = $('#pwd').val();
        var newPass = $('#pwd_new').val();
        var update_type = 0;

         $.ajax({
            url: '/account/' + {{Auth::id()}},
            type: 'PUT', //type is any HTTP method
            data: {
                update_type, oldPass, newPass
            }, //Data as js object
            success: function () {
                $('#changePassword').modal('hide')
                $('#changePasswordSuccess').modal('show')
                $('#pwd').removeClass('is-invalid');
            },
            error: function(data){
                $('#pwd').addClass('is-invalid');
            }
        });
    }
    function joinClass(){
        var class_code = $('#class_code').val();
         $.ajax({
            url: '/join',
            type: 'POST', //type is any HTTP method
            data: {
                class_code
            }, //Data as js object
            success: function () {
                $('#class_code').removeClass('is-invalid');
                window.location.reload(true);
            },
            error: function(){
                $('#class_code').addClass('is-invalid');
            }
        });
    }
</script>
@endsection
