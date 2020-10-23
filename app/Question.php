<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
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

    public function save_question()
    {
        return $this->hasOne('App\ExamSave');
    }
}
