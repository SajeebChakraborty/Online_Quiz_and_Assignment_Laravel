@extends('layouts.app') @section('title', 'Manage Quiz - TeckQuiz') @section('content')
<style>
    body {
        padding-top: 90px;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

<section class="container">
    <h1>Manage Assignment</h1>
    <hr>
    <div class="row">

        @if($assignment_count>0)
        <div class="col-lg-9">
            
            <h3>{{ $assignment_details->assignment_even_name }}</h3>
            <p>This is some basic information about the assignment.</p>
            <p>Class:
                <b>
                    <a href="/manage/class/view{{ $assignment_details->class_id }}"></a>{{ $assignment_details->classe->course_sec }}</b>
            </p>
            <p>Subject:
                <b>{{ $assignment_details->classe->subject->subject_desc }}</b>
            </p>
       
        </div>
        @endif
        @foreach($results as $result)
        <div class="col-lg-9 pt-4">
            <h3>Assignment Submissions</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>File</th>
                   
                    </tr>
                </thead>

                <?php



                    $student_name=DB::table('user_profiles')->where('usr_id',$result->student_id)->value('given_name');



                ?>
                <tbody>
                
                    <th>

                        {{  $student_name  }}

                    </th>

                    <th><a href="{{ asset('Assignment_Submission_file/'.$result->student_answer) }}" class="" target="_blank"><i class="fas fa-file-pdf" style="color:red; font-size:40px;"> </i></a>
</th>

       
                </tbody>
            </table>

            @endforeach
       
        </div>
        
    </div>


</section>

@endsection