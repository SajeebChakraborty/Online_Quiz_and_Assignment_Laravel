<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\UserProfile;
use App\Classe;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of teachers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $teachers = User::with('user_profile', 'classe')
            ->where('permissions', 1)
            ->get();
        // return $teachers;
        return view('manage.teachers', compact('teachers'));
    }

}
