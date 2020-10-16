<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultipleChoice extends Model
{
	protected $fillable = ['choice'];
    public function question()
    {
    	return $this->belongsTo('App\Exam');
    }
}
