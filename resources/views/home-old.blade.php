@extends('layouts.app')

@section('title', 'TeckQuiz - An Online Quiz Management System')
@section('content')
    <style>
            /* Add the below transitions to allow a smooth color change similar to lyft */
            .navbar {
                -webkit-transition: all 0.6s ease-out;
                -moz-transition: all 0.6s ease-out;
                -o-transition: all 0.6s ease-out;
                -ms-transition: all 0.6s ease-out;
                transition: all 0.6s ease-out;
            }
            body {
                padding-top: 0px;
            }
            .app-title-container {
                background: url('./assets/img/study-map.jpg') center center no-repeat;
                background-attachment: fixed;
                background-position: cover;
                height: 100vh;
                width: 100%;
            }

            .app-title {
                background: rgba(255, 255, 255, 0.5);
                position: relative;
                top: 50%;
                transform: translateY(-50%);
            }

            .center-features {
                background-color: rgba(255, 255, 255, 0.5);
                height: 100vh;
                padding: 10rem 0;
            }

            .app-feature-1 {
                background: url('./assets/img/crumpled-paper.jpg') center center no-repeat;
                background-attachment: fixed;
                background-position: cover;
                color: #212121;
            }

            .app-feature-2 {
                background-color: rgba(255, 255, 255, 0.5);
                background: url('./assets/img/work-enviroment.jpg') center center no-repeat;
                background-attachment: fixed;
                background-position: cover;
                color: #C5CAE9;
            }
    </style>
    <div class="container-fluid app-title-container">
        <div class="jumbotron app-title" style="border-radius: 0">
            <h1 class="text-center">TeckQuiz</h1>
            <p class="text-center">An Online Quiz Management System</p>
        </div>
    </div>
    <div class="container-fluid center-features app-feature-1">
        <h2 class="text-center"><strong>Forget the paper, just test.</strong></h2>
        <p class="text-center">Quiz without paper. Quiz without hassle.</p>
    </div>
    <div class="container-fluid center-features app-feature-2">
        <h2 class="text-center"><strong>Serve quiz with ease.</strong></h2>
        <p class="text-center">No more confusion, just do it.</p>
    </div>
    <script>
        function authenticateUser() {
            console.log("inside!");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var usr = $("#usr").val();
            var pwd = $("#password").val();
            $.post("/authenticate", { usr, pwd }, function (data) {
                console.log(data);
            });
            console.log("outside!");
        }
    </script>
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('usr') ? ' has-error' : '' }}">
                            <label for="usr" class="col-md-4 control-label">Username</label>
                            <input id="usr" type="text" class="form-control" name="usr" value="{{ old('usr') }}" required autofocus>                        @if ($errors->has('usr'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('usr') }}</strong>
                                        </span> @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <input id="password" type="password" class="form-control" name="password" required> @if ($errors->has('password'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span> @endif
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                            <!-- <button type="button" onclick="authenticate()" class="btn btn-primary">
                                        Login
                                    </button> -->

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/jquery-3.2.0.min.js"></script>
    <script>
        /**
        * Listen to scroll to change header opacity class
        */
        function checkScroll(){
            var startY = $('.navbar').height() * 2; //The point where the navbar changes in px

            if($(window).scrollTop() > startY){
                $('.navbar').removeClass("bg-dark");
            }else{
                $('.navbar').addClass("bg-dark");
            }
        }

        if($('.navbar').length > 0){
            $(window).on("scroll load resize", function(){
                checkScroll();
            });
        }
    </script>
@endsection
