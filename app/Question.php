<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = "questions";
    protected $primaryKey = "question_id";
    public $timestamps = false;

    protected $fillable = [
        'questionnaire_id',
        'question_name',
        'question_type',
        'choices',
        'answer',
        'points'
    ];

    public function answer(){
        $this->hasOne('App\StudentAnswer', 'question_id', 'question_id');
    }

    public function questionnaire(){
        $this->belongsTo('App\Questionnaire', 'questionnaire_id', 'questionnaire_id');
    }
}
