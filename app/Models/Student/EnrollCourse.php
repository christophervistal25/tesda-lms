<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class EnrollCourse extends Model
{

	public function student()
	{
		return $this->belongsTo('App\User');
	}

    public function course()
    {
    	return $this->belongsTo('App\Course');
    }
}
