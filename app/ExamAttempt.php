<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
	protected $fillable = ['status'];
	
    public function result()
    {
    	return $this->hasMany('App\ExamResult');
    }

    public function save_record()
    {
    	return $this->hasMany('App\ExamSave');
    }
}
