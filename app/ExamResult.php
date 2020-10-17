<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = ['question_id', 'user_id', 'exam_attempt_id', 'answer', 'status'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function attempt()
    {
    	return $this->belongsTo('App\ExamAttempt');
    }

    public function exam()
    {
    	return $this->belongsTo('App\Exam');
    }

}
