<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\QuizEvent;
use App\UserProfile;
use App\StudentScore;
use App\StudentAnswer;
use App\AssignmentEvent;

use Illuminate\Support\Facades\DB;

class TakeQuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $question_ids = $request->input('question_id');
        $answers = $request->input('answer');
        $quiz_event_id = $request->input('quiz_event_id');
        $student_id = Auth::user()->usr_id;

        $check_exisiting = StudentScore::where('student_id', $student_id)
                            ->where('quiz_event_id', $quiz_event_id)
                            ->count();
                            
        if ($check_exisiting > 0){
            abort(403, 'You already took the quiz.');
        }

        for($x = 1; $x <= count($question_ids); $x++){
            StudentAnswer::create([
                'student_id' => $student_id,
                'quiz_event_id' => $quiz_event_id,
                'question_id' => $question_ids[$x],
                'student_answer' => $answers[$x]
            ]);
        }

        $answers = StudentAnswer::with('question')
                    ->where('student_id', $student_id)
                    ->where('quiz_event_id', $quiz_event_id)
                    ->get();

        $score = 0;
        foreach($answers as $answer){
            if(($answer->student_answer == $answer->question->answer) && ($answer->quiz_event_id == $answer->question->questionnaire_id))
                $score += $answer->question->points;
        }

        StudentScore::create([
            'student_id' => $student_id,
            'quiz_event_id' => $quiz_event_id,
            'score' => $score,
            'recorded_on' => \Carbon\Carbon::now()
        ]);
     
        return redirect('/quiz/' . $quiz_event_id);
    }

    public function assignment_show($id)
    {

        $usr_id = Auth::user()->usr_id;

        $user_profile = UserProfile::find($usr_id);

        $AssignmentTaken = DB::table('assignment_student_answers')
                        ->where('student_id', $usr_id)
                        ->where('assignment_event_id', $id)
                        ->get();

        if($AssignmentTaken->count() > 0){
            return abort(403, 'Assignment already taken');
        }

        $today=date("Y-m-d");

        $verify_submission = DB::table('assignment_events')
                        ->join('student_classes', 'student_classes.class_id', '=', 'assignment_events.class_id')
                        ->where('student_id', $usr_id)
                        ->where('assignment_event_id', $id)
                        ->where('assignment_event_status', 1)
                        ->where('assignment_last_date','<',$today)
                        ->get();

        if($verify_submission->count() > 0){
                            return abort(403, 'Last Submission Date of Assignment already taken');
        }

        $verify_quiz = DB::table('assignment_events')
                        ->join('student_classes', 'student_classes.class_id', '=', 'assignment_events.class_id')
                        ->where('student_id', $usr_id)
                        ->where('assignment_event_id', $id)
                        ->where('assignment_event_status', 1)
                        ->get();

        if ($verify_quiz->count() < 1){
            return abort(403, 'Not enrolled for this class to take the quiz.');
        }elseif($verify_quiz->where('assignment_event_status', 1)->count() < 1){
            abort(403, 'Assignment not yet started or already ended.');
        }else{
                $assignment = AssignmentEvent::find($id);

            

                $content = view('quiz.take-assignment', compact('assignment', 'usr_id','user_profile'));

                return response($content)
                            ->header('Cache-Control', 'no-cache, must-revalidate')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        }





    }

    public function assignment_submit(Request $req)
    {


        $assignment_file=$req->submit_file;
        $student_id=$req->student_id;
        $assignment_event_id=$req->assignment_event_id;

        if($assignment_file != NULL)
        {

            $uploadedfile=$assignment_file;
            $newname=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('Assignment_Submission_file'),$newname);


        }
        else
        {


            $newname=NULL;


        }
        
        $post = array();

        $post['assignment_event_id']=$assignment_event_id;
        $post['student_id']=$student_id;
        $post['student_answer']=$newname;       


        $post_assignment=DB::table('assignment_student_answers')->Insert($post);


        session()->flash('success','Assignment has uploaded successfully !');

        //return back();

        return redirect('panel');

        



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $usr_id = Auth::user()->usr_id;

        $user_profile = UserProfile::find($usr_id);

        $QuizTaken = DB::table('quiz_student_score')
                        ->where('student_id', $usr_id)
                        ->where('quiz_event_id', $id)
                        ->get();

        if($QuizTaken->count() > 0){
            return abort(403, 'Quiz already taken');
            return redirect('quiz/'.$id);
        }

        $verify_quiz = DB::table('quiz_events')
                        ->join('student_classes', 'student_classes.class_id', '=', 'quiz_events.class_id')
                        ->where('student_id', $usr_id)
                        ->where('quiz_event_id', $id)
                        ->where('quiz_event_status', 1)
                        ->get();

        if ($verify_quiz->count() < 1){
            return abort(403, 'Not enrolled for this class to take the quiz.');
        }elseif($verify_quiz->where('quiz_event_status', 1)->count() < 1){
            abort(403, 'Quiz not yet started or already ended.');
        }else{
                $quiz = QuizEvent::find($id);

                $quiz_content = DB::table('questions')
                                ->select('question_id', 'question_name', 'choices', 'question_type')
                                ->join('questionnaires', 'questionnaires.questionnaire_id', '=', 'questions.questionnaire_id')
                                ->join('quiz_events', 'quiz_events.questionnaire_id', '=', 'questionnaires.questionnaire_id')
                                ->where('quiz_event_id', $id)
                                ->inRandomOrder()
                                ->get();

                $content = view('quiz.take-quiz', compact('quiz_content', 'quiz', 'user_profile'));

                return response($content)
                            ->header('Cache-Control', 'no-cache, must-revalidate')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        }
    }
}
