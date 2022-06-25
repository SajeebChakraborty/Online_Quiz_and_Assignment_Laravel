<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = "user_profiles";
    protected $primaryKey = "usr_id";
    public $timestamps = false;

    protected $fillable = [
        'usr_id',
        'given_name',
        'family_name',
        'middle_name',
        'ext_name'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'usr_id', 'usr_id');
    }
}
