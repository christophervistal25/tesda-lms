<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamSave extends Model
{
    protected $fillable = ['exam_attempt_id', 'question_id', 'answer'];

    public function attempt()
    {
    	return $this->belongsTo('App\ExamAttempt');
    }

    public function question()
    {
    	return $this->belongsTo('App\Question');
    }

}
