@extends('layouts.app') @section('title', 'Manage Quiz - TeckQuiz') @section('content')
<style>
    body {
        padding-top: 90px;
    }
</style>
<section class="container">
    <h1>Manage Quiz</h1>
    <hr>
    <div class="row">
        <div class="col-lg-9">
            <h3>{{ $quiz_details->quiz_event_name }}</h3>
            <p>This is some basic information about the quiz.</p>
            <p>Class:
                <b>
                    <a href="/manage/class/view{{ $quiz_details->class_id }}"></a>{{ $quiz_details->classe->course_sec }}</b>
            </p>
            <p>Subject:
                <b>{{ $quiz_details->classe->subject->subject_desc }}</b>
            </p>
            <p>Questionnaire:
                <b>
                    <a href="/questionnaire/{{ $quiz_details->questionnaire->questionnaire_id }}">{{ $quiz_details->questionnaire->questionnaire_name }}</a>
                </b>
            </p>
        </div>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function ChangeQuizStatus(quiz_event_id, quiz_status) {
                $.ajax({
                    url: '/quiz/' + quiz_event_id, //Your api url
                    type: 'PUT', //type is any HTTP method
                    data: {quiz_status}, //Data as js object
                    success: function () {
                        window.location.reload(true);
                    }
                });
            }
        </script>
        <div class="col-lg-3" id="quiz_actions">
            <!-- Use PUT method to update -->
            @if($quiz_details->quiz_event_status == 0)
            <button href="" onclick="javascript:ChangeQuizStatus({{ $quiz_details->quiz_event_id }}, 1)" class="btn btn-primary">Enable Quiz</button>
            @elseif($quiz_details->quiz_event_status == 1)
            <button href="" onclick="javascript:ChangeQuizStatus({{ $quiz_details->quiz_event_id }}, 0)" class="btn btn-primary">Disable Quiz</button>
            <button href="" onclick="javascript:ChangeQuizStatus({{ $quiz_details->quiz_event_id }}, 2)" class="btn btn-primary btn-danger">End Quiz</button>
            @endif
        </div>
        <div class="col-lg-9 pt-4">
            <h3>Quiz Results</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Score</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results->classe->student_class as $result)
                    <tr>
                        <td>{{ $result->user_profile->family_name }}, {{ $result->user_profile->given_name }} {{ $result->user_profile->ext_name
                            }} {{ $result->user_profile->middle_name }}</td>
                        <td>
                            @if(is_null($result->student_score))
                            <i>not taken</i>
                            @else {{ $result->student_score->score }} / {{$sum}}@endif
                        </td>
                        <td>
                        @php
                            try{$ave = $result->student_score->score / $sum;}catch(Exception $e){$ave = 0;}
                                        
                            echo (number_format($ave, 2) * 100) . "%";
                        @endphp
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        
    </div>


</section>

@endsection