<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = "classes";
    protected $primaryKey = "class_id";
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'class_id',
        'instructor_id',
        'course_sec',
        'subject_id',
        'class_active'
    ];

    public function subject(){
        return $this->belongsTo('App\Subject', 'subject_id', 'subject_id');
    }

    public function student_class(){
        return $this->hasMany('App\StudentClass', 'class_id', 'class_id');
    }

    public function quiz_event(){
        return $this->belongsTo('App\QuizEvent', 'class_id', 'class_id');
    }
}
