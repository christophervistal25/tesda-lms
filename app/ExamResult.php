<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = ['exam_id', 'user_id', 'answer', 'status'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
