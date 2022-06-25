<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Auth;

use App\Classe;


class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created class in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $i_id = Auth::user()->usr_id;//gets the id of the user
        $course_sec = $request->input('course_sec');
        $sub_id = $request->input('sub_id');

        Classe::create([
            'class_id' => str_random(5),
            'instructor_id' => $i_id,
            'course_sec' => $course_sec,
            'subject_id' => $sub_id,
            'class_active' => 1
        ]);

        return redirect('/panel');
    }

    /**
     * Displays a specified class.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $quiz_events = DB::table('quiz_events')
                        ->join('classes', 'quiz_events.class_id', '=', 'classes.class_id')
                        ->join('subjects', 'subjects.subject_id', '=', 'classes.subject_id')
                        ->where('classes.class_id', $id)
                        ->get();

        // $quiz_class = DB::table('classes')
        //             ->join('subjects', 'classes.subject_id', '=', 'subjects.subject_id')
        //             ->where('instructor_id', Auth::user()->usr_id)
        //             ->where('classes.class_id', $id)
        //             ->first();

        $quiz_class = Classe::with('subject')
                        ->where('instructor_id', Auth::user()->usr_id)
                        ->where('class_id', $id)
                        ->first();

        $students = DB::table('student_classes')
                    ->join('user_profiles', 'student_classes.student_id', '=', 'user_profiles.usr_id')
                    ->where('class_id', $id)
                    ->orderBy('family_name', 'asc')
                    ->get();
                        
        //return $quiz_class;
        return view('manage.classes', compact('students', 'quiz_class', 'quiz_events'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        Classe::destroy($id);
    }
}
