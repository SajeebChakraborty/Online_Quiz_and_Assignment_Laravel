<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\UserProfile;

use Auth;
use Hash;

class AccountController extends Controller
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
        if (Auth::user()->permissions == 0){//Only the admin can store teachers
            $out = User::create([
                'usr' => $request->input('usr'),
                'permissions' => $request->input('permission'),
                'password' => bcrypt($request->input('password')),
            ]);

            $usr = User::select('usr_id')->where('usr', $request->input('usr'))->first();
            
            UserProfile::create([
                'usr_id' => $usr->usr_id,
                'given_name' => $request->input('n_given'),
                'family_name' => $request->input('n_family'),
                'middle_name' => $request->input('n_middle'),
                'ext_name' => $request->input('n_ext'),
            ]);

            return redirect('/teachers');
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
        if($request->input('update_type') == 0){
            $user = User::find(Auth::id());
            $hashedPassword = $user->password;
    
            if (Hash::check($request->oldPass, $hashedPassword)) {
                $user->fill([
                    'password' => Hash::make($request->newPass)
                ])->save();
    
    
                return response('Password changed', 200);
            }
            return response('Invalid password', 400);
        }else if($request->input('update_type') == 1){
            $user = User::find($id);
            $hashedPassword = $user->password;
            $user->fill([
                    'password' => Hash::make("password")
                ])->save();
    
            
            return response('Password resetted', 200);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if (Auth::user()->permissions == 0){
            User::destroy($id);
        }else{
            abort(503);
        }
        
    }
}
