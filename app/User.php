<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = "usr_id";
    
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usr',
        'permissions',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_profile(){
        return $this->hasOne('App\UserProfile', 'usr_id', 'usr_id');
    }
    public function classe(){
        return $this->hasMany('App\Classe', 'instructor_id', 'usr_id');
    }
}
