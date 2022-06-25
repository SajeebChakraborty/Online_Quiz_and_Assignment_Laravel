<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $assignment->assignment_even_name }} - TeckAssignment</title>

    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/teckquiz.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<style>
    .sidebar{
        position: fixed;
        top: 0px;
    }
</style>

<body>
    <div id="app">
        @php $questionNum = 1; @endphp
        <div class="container-fluid">
            <div class="row">
                <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item disabled"><a class="nav-link disabled" style="font-size: 2rem; text-align: center">Assignment</a></li>
                        <li class="nav-item">
                            <a class="nav-link active" id="v-pills-welcome-tab" data-toggle="pill" href="#welcome" role="tab" aria-controls="v-pills-welcome"
                                aria-expanded="true">Welcome</a>
                        </li>
                       
                    </ul>
                    @php $questionNum = 1; @endphp
                </nav>
             
                <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                    <form class="tab-content col" id="v-pills-tabContent" action="/submit/assignment" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="tab-pane fade show active" id="welcome" role="tabpanel" aria-labelledby="welcome">
                            <h1>Welcome!</h1>
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
                            <p>Assignment Name: <b>{{ $assignment->assignment_even_name }}</b></p>
                            <p>Assignment Description: <br> <b>{{ $assignment->assignment_description }}</b></p>
                            <p>Last Submission Date: <b>{{ $assignment->assignment_last_date }}</b></p>
                            <p>Assignment Question File : 
                            <a href="{{ asset('Assignment_Question_file/'.$assignment->assignment_file) }}" class="" target="_blank"><i class="fas fa-file-pdf" style="color:red; font-size:40px;"> </i></a>
                            </p>
                            <p>Name: <b>{{ $user_profile->family_name }}, {{ $user_profile->given_name }} {{ $user_profile->ext_name }} {{ $user_profile->middle_name }}</b></p>
                            <p>Course and Section: <b>{{ $assignment->classe->course_sec }}</b></p>

                            <label class="form-label" for="customFile">Upload File</label>
                            <input type="file" name="submit_file" class="form-control" id="customFile" required/>
                            <br>
                            <input type="submit" class="btn btn-primary" value="Submit">

                        </div>
                     
                        <input type="hidden" name="student_id" value="{{ $usr_id }}">
                        <input type="hidden" name="assignment_event_id" value="{{ $assignment->assignment_event_id }}">
                    </form>
                </main>
            </div>
        </div>
    </div>
    
    

    <script src="{{ asset('assets/js/jquery-3.2.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/teckquiz.js') }}"></script>
</body>


</html>