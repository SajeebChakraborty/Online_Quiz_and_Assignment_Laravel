<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classe;
use App\Questionnaire;
use App\Question;
use App\QuizEvent;
use App\AssignmentEvent;
use App\StudentScore;
use DB;

use Auth;

class QuizEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the form for creating a new quiz event.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $classes = Classe::all();
        return view('create.quiz-event', compact('classes'));
    }
    public function assignment_create_form(){



        $id = Auth::user()->usr_id;


        $classes = Classe::all();
        $assignment_event_count=DB::table('assignment_events')
                    ->where('teacher_id',$id)
                    ->count();

        return view('create.assignment-event', compact('classes','assignment_event_count'));


    }
    /**
     * Store a newly created quiz event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $quiz_name = $request->input('q_name');
        $class_code = $request->input('class_id');

        $questions = $request->input('question'); //Question
        $types = $request->input('qt'); //Question types

        $i = $request->input('i'); //Correct answer for identification
        $mc = $request->input('mc'); //Choices for multiple choice
        $c_mc = $request->input('c-mc'); //Correct choice
        $tf = $request->input('tf'); //Correct answer for true or false

        $p = $request->input('points'); //Question point

        Questionnaire::create([
            'questionnaire_name' => $quiz_name,
        ]);

        $q_id = Questionnaire::count(); //Questionnaire id.

        for($x = 0; $x < count($questions); $x++){
            $question = $questions[$x];
            $choices = ""; //For multiple choice use.
            $answer = null; //Obviously.
            $points = $p[$x];

            if($types[$x] == 0){
                //ERROR
            }else if ($types[$x] == 1){//Identification
                $answer = $i[$x];
            }else if($types[$x] == 2){//Multiple choice
                $choices = $mc[$x][0] . ";" . $mc[$x][1] . ";" . $mc[$x][2] . ";" . $mc[$x][3];
                $answer = $c_mc[$x];
            }else if($types[$x] == 3){//True or False
                $answer = $tf[$x];
            }

            if(trim($question) == "" || is_null($question))
                continue;

            Question::create([
                'questionnaire_id' => $q_id,
                'question_name' => $question,
                'question_type' => $types[$x],
                'choices' => $choices,
                'answer' => $answer,
                'points' => $points
            ]);
        }

        QuizEvent::create([
            'quiz_event_name' => $quiz_name,
            'questionnaire_id' => $q_id,
            'class_id' => $class_code,
            'quiz_event_status' => 0,
        ]);

        return redirect('/panel');
    }

    public function assignment_post(Request $req)
    {

        $id = Auth::user()->usr_id;
        $assignment_name=$req->q_name;
        $assignment_file=$req->assignment_file;
        $assignment_description=$req->description;
        $class_id=$req->class_id;
        $assignment_event_status=1;
        $last_submission_date=$req->date;


        if($assignment_file != NULL)
        {

            $uploadedfile=$assignment_file;
            $newname=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('Assignment_Question_file'),$newname);


        }
        else
        {


            $newname=NULL;


        }



        $post = array();

        $post['assignment_even_name']=$assignment_name;
        $post['teacher_id']=$id;
        $post['assignment_description']=$assignment_description;
        $post['class_id']=$class_id;
        $post['assignment_event_status']=$assignment_event_status;
        $post['assignment_last_date']=$last_submission_date;
        $post['assignment_file']=$newname;        


        $post_assignment=DB::table('assignment_events')->Insert($post);


        return redirect('/panel');


    }

    /**
     * Displays the specified quiz event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        if(Auth::user()->permissions < 2){
            $usr_id = Auth::user()->usr_id;
        
            $quiz_details = QuizEvent::with([
                        'classe',
                        'classe.subject',
                        'questionnaire'])
                        ->where('quiz_event_id', $id)
                        ->first();

            $results = QuizEvent::with([
                    'classe.student_class.student_score' => function ($q) use($id){
                        $q->where('quiz_event_id', $id);
                    },
                    'classe.student_class.user_profile'])
                    ->where('quiz_event_id', $id)
                    ->first();

            $qtn_id = QuizEvent::find($id)->questionnaire_id;
            $sum = Question::where('questionnaire_id', $qtn_id)->sum('points');

            return view('manage.quiz', compact('quiz_details', 'results', 'sum'));
        }else{
            $qtn_id = QuizEvent::find($id)->questionnaire_id;
            $results = StudentScore::with('quiz_event', 'user_profile')
                        ->where('student_id', Auth::user()->usr_id)
                        ->where('quiz_event_id', $qtn_id)
                        ->first();

            $qtn_id = QuizEvent::find($id)->questionnaire_id;
            $sum = Question::where('questionnaire_id', $qtn_id)->sum('points');

            return view('quiz.results', compact('results', 'sum'));
        }
        
    }
    public function assignment_show($id)
    {

        if(Auth::user()->permissions < 2){
            $usr_id = Auth::user()->usr_id;


            $assignment_count=DB::table('assignment_events')
                    ->where('teacher_id',$usr_id)
                    ->where('assignment_event_id', $id)
                    ->count();
        
            $assignment_details = AssignmentEvent::with([
                        'classe',
                        'classe.subject',
                        ])
                        ->where('assignment_event_id', $id)
                        ->first();

            $results = DB::table('assignment_student_answers')
                        ->where('assignment_event_id', $id)
                        ->get();

         

            return view('manage.assignment', compact('assignment_details', 'results','assignment_count'));
        }




    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $quiz = QuizEvent::find($id);
        $quiz->quiz_event_status = $request->input('quiz_status');
        $quiz->save();
        //return "ID: $id" . "\n" . $request->input('quiz_status');
    }
}
