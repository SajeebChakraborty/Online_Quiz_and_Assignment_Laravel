<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    protected $table = "quiz_student_answers";
    protected $primaryKey = null;
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'quiz_event_id',
        'question_id',
        'student_answer'
    ];

    public function question(){
        return $this->belongsTo('App\Question', 'question_id', 'question_id');
    }
}
