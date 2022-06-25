<?php

namespace App\Http\Controllers;

use App\Subject;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $subjects = Subject::with('classe')->get();
        //return $subjects;
        return view('manage.subjects', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $subject = new Subject;
        $subject->subject_code = $request->input('s_code');
        $subject->subject_desc = $request->input('s_des');
        $subject->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $subject = Subject::find($id);
        $subject->subject_code = $request->input('s_code');
        $subject->subject_desc = $request->input('s_des');
        $subject->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        Subject::destroy($id);
    }
}
