<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentScore extends Model
{
    protected $table = "quiz_student_score";
    protected $primaryKey = null;
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'quiz_event_id',
        'score',
        'recorded_on'
    ];

    public function quiz_event(){
        return $this->belongsTo('App\QuizEvent', 'quiz_event_id', 'quiz_event_id');
    }

    public function user_profile(){
        return $this->belongsTo('App\UserProfile', 'student_id', 'usr_id');
    }
}
