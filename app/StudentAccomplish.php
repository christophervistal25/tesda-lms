<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAccomplish extends Model
{
    protected $fillable = ['user_id', 'course_id', 'data'];

    public function student()
    {
    	return $this->hasOne('App\User');
    }

    public function course()
    {
    	return $this->hasOne('App\Course');
    }
}
