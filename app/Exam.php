<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['question_no', 'question', 'answer', 'type'];

    /**
     * This is for multiple choice type of question.
     */
    public function choices()
    {
    	return $this->hasMany('App\MultipleChoice');
    }

    public function result()
    {
    	return $this->hasOne('App\ExamResult');
    }

}
