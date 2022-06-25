<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = "subjects";
    protected $primaryKey = "subject_id";
    public $timestamps = false;

    protected $fillable = [
        'subject_code',
        'subject_desc'
    ];

    public function classe(){
        return $this->hasMany('App\Classe', 'subject_id', 'subject_id');
    }
}
