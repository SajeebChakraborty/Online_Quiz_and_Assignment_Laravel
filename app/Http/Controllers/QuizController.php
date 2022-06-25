<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Classe;
use App\QuizEvent;
use App\AssignmentEvent;
use App\Subject;
use App\User;
use App\StudentClass;

use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function Home(){
        return view('home');
    }

    public function RedirectToAppropriatePanel(){    
        $id = Auth::user()->usr_id;//gets the id of the user
        if (Auth::user()->permissions == 0){//The user is the administrator
            $subjects = Subject::all();
            $classes = Classe::with('subject')
                            ->where('class_active', true)
                            ->get();
                            
            $quiz_events = QuizEvent::with([
                    'classe',
                    'classe.subject'])
                    ->where('quiz_event_status', 0)
                    ->orWhere('quiz_event_status',1)
                    ->get()
                    ->where('classe', '!=', null);
            /*
            $assignment_events = DB::table('assignment_events')//Gets pending quiz (quiz_event_status = 1)
                    ->select('assignment_description', 'subject_desc', 'quiz_events.quiz_event_id')
                    ->join('classes', 'assignment_events.class_id', '=', 'classes.class_id')
                    ->join('subjects', 'subjects.subject_id', '=', 'classes.subject_id')
                    ->join('student_classes', 'student_classes.class_id', '=', 'assignment_events.class_id')
                    ->get();
            
            */
            $assignment_events = AssignmentEvent::with([
                'classe',
                'classe.subject'])
                ->where('assignment_event_status', 0)
                ->orWhere('assignment_event_status',1)
                ->get()
                ->where('classe', '!=', null);

            $finished_quiz_events = QuizEvent::with([
                    'classe',
                    'classe.subject'])
                    ->where('quiz_event_status', 2)
                    ->get()
                    ->where('classe', '!=', '');
            $teachers = User::where('permissions', 1)->count();
            $students = User::where('permissions', 2)->count();
            return view('panel.admin', compact('classes', 'quiz_events','assignment_events', 'finished_quiz_events', 'subjects', 'teachers', 'students'));
        }
        else if (Auth::user()->permissions == 1){//The user is a teacher

            $subjects = Subject::all();
            $classes = Classe::with('subject')
                            ->where('instructor_id', $id)
                            ->where('class_active', true)
                            ->get();
            //dd($classes);
            $quiz_events = QuizEvent::with([
                    'classe' => function($q) use($id){
                        $q->where('instructor_id', $id);
                    },
                    'classe.subject'])
                    ->where('quiz_event_status', 0)
                    ->orWhere('quiz_event_status',1)
                    ->get()
                    ->where('classe', '!=', null);
            
            $assignment_events = AssignmentEvent::with([
                        'classe',
                        'classe.subject'])
                        ->where('teacher_id',$id)
                        ->where('assignment_event_status', 0)
                        ->orWhere('assignment_event_status',1)
                        ->get()
                        ->where('classe', '!=', null);

            $finished_quiz_events = QuizEvent::with([
                    'classe' => function($q) use($id){
                        $q->where('instructor_id', $id);
                    },
                    'classe.subject'])
                    ->where('quiz_event_status', 2)
                    ->get()
                    ->where('classe', '!=', '');
            
            return view('panel.teacher', compact('classes', 'quiz_events', 'assignment_events','finished_quiz_events', 'subjects'));
        }
        else if (Auth::user()->permissions == 2){//The user is a student


         

            /*
            $upcoming_quiz = QuizEvent::with([
                    'classe',
                    'classe.student_class' => function ($q) use($id){
                        $q->where('student_id', $id);
                    },
                    'classe.subject'])
                   // ->where('class_id',)
                    ->where('quiz_event_status', 0)
                    ->get();
        
            */

            $upcoming_quiz = DB::table('quiz_events')//Gets pending quiz (quiz_event_status = 1)
                    ->select('quiz_event_name', 'subject_desc', 'quiz_events.quiz_event_id')
                    ->join('classes', 'quiz_events.class_id', '=', 'classes.class_id')
                    ->join('subjects', 'subjects.subject_id', '=', 'classes.subject_id')
                    ->join('student_classes', 'student_classes.class_id', '=', 'quiz_events.class_id')
                    ->where('student_classes.student_id', $id)
                    ->where('quiz_event_status', 0)
                    ->get();

           
            
            $pending_quiz = DB::table('quiz_events')//Gets pending quiz (quiz_event_status = 1)
                ->select('quiz_event_name', 'subject_desc', 'quiz_events.quiz_event_id')
                ->join('classes', 'quiz_events.class_id', '=', 'classes.class_id')
                ->join('subjects', 'subjects.subject_id', '=', 'classes.subject_id')
                ->join('student_classes', 'student_classes.class_id', '=', 'quiz_events.class_id')
                ->where('student_classes.student_id', $id)
                ->where('quiz_event_status', 1)
                ->get();


            $quiz_result = DB::table('quiz_events')//Gets pending quiz (quiz_event_status = 1)
                ->select('quiz_event_name', 'subject_desc', 'quiz_events.quiz_event_id')
                ->join('classes', 'quiz_events.class_id', '=', 'classes.class_id')
                ->join('subjects', 'subjects.subject_id', '=', 'classes.subject_id')
                ->join('student_classes', 'student_classes.class_id', '=', 'quiz_events.class_id')
                ->where('student_classes.student_id', $id)
                ->where('quiz_event_status', 1)
                ->get();


            $quiz_result_student=DB::table('quiz_student_answers')
                    ->where('student_id',$id)
                    ->get();

            
            $assignment = DB::table('assignment_events')//Gets pending quiz (quiz_event_status = 1)
                ->select('assignment_even_name','assignment_last_date', 'subject_desc', 'assignment_events.assignment_event_id')
                ->join('classes', 'assignment_events.class_id', '=', 'classes.class_id')
                ->join('subjects', 'subjects.subject_id', '=', 'classes.subject_id')
                ->join('student_classes', 'student_classes.class_id', '=', 'assignment_events.class_id')
                ->where('student_classes.student_id', $id)
                ->where('assignment_event_status', 1)
                ->get();

            

            //return $pending_quiz;

            $finished_quiz = QuizEvent::with([//Gets quiz that have been concluded.
                    'classe',
                    'classe.subject',
                    'classe.student_class' => function ($q) use($id){
                        $q->where('student_id', $id);
                    },
                    'classe.student_class.student_score'])
                    ->where('quiz_event_status', 2)
                    ->get();


                

            return view('panel.student', compact('pending_quiz', 'quiz_result_student','assignment','quiz_result','upcoming_quiz', 'finished_quiz'));
        }
    }
    
    public function JoinClass(Request $request){
        $request->validate([
            'class_code' => 'exists:classes,class_id|string',
        ]);

        $is_joined = StudentClass::where('class_id', $request->input('class_code'))
                        ->where('student_id', Auth::user()->usr_id)
                        ->count();
        if($is_joined){
            return response('Already joined!', 422);
        }else{
            StudentClass::create([
                'student_id' => Auth::user()->usr_id,
                'class_id' => $request->input('class_code'),
            ]);
        }
    }
}
