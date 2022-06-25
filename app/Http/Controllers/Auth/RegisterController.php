<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserProfile;
use App\StudentClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/panel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'usr' => 'required|string|max:255|unique:users',
            //'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:1|confirmed',
            'class_code' => 'exists:classes,class_id|string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $out = User::create([
            'usr' => $data['usr'],
            'permissions' => 2,
            'password' => bcrypt($data['password']),
        ]);

        $usr = User::select('usr_id')->where('usr', $data['usr'])->first();
        
        UserProfile::create([
            'usr_id' => $usr->usr_id,
            'given_name' => $data['n_given'],
            'family_name' => $data['n_family'],
            'middle_name' => $data['n_middle'],
            'ext_name' => $data['n_ext'],
        ]);

        StudentClass::create([
            'student_id' => $usr->usr_id,
            'class_id' => $data['class_code'],
        ]);

        return $out;
    }
}
