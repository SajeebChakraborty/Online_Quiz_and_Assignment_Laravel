<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table = "student_classes";
    protected $primaryKey = null;
    public $timestamps = false;
    public $incrementing = false; 

    protected $fillable = [
        'class_id',
        'student_id'
    ];
    
    public function classe(){
        return $this->belongsTo('App\Classe', 'class_id', 'class_id');
    }

    public function student_score(){
        return $this->hasOne('App\StudentScore', 'student_id', 'student_id');
    }

    public function quiz_event(){
        return $this->belongsTo('App\QuizEvent', 'quiz_event_id', 'quiz_event_id');
    }

    public function user_profile(){
        return $this->belongsTo('App\UserProfile', 'student_id', 'usr_id');
    }
}
