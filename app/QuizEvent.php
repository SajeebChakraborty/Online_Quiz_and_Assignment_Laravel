<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizEvent extends Model
{
    protected $table = "quiz_events";
    protected $primaryKey = "quiz_event_id";
    // public $timestamps = false;

    protected $fillable = [
        'quiz_event_name',
        'questionnaire_id',
        'class_id',
        'quiz_event_status'
    ];

    public function classe(){
        return $this->hasOne('App\Classe', 'class_id', 'class_id');
    }

    public function subject(){
        return $this->hasOne('App\Subject', 'subject_id', 'subject_id');
    }

    public function user(){
        return $this->hasOne('App\User', 'usr_id', 'instructor_id');
    }

    public function questionnaire(){
        return $this->hasOne('App\Questionnaire', 'questionnaire_id', 'questionnaire_id');
    }
    public function student_class(){
        return $this->hasOne('App\StudentClass', 'class_id', 'class_id');
    }
}
