<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class EnrollCourse extends Model
{
	protected $primaryKey = null;

	public $incrementing = false;
	
	public function student()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

    public function course()
    {
    	return $this->belongsTo('App\Course')->withDefault();
    }
}
