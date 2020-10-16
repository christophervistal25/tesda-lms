<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['title', 'body', 'course_id', 'is_overview'];

    public function activities()
    {
    	return $this->hasMany('App\Activity');
    }

    public function course()
    {
    	return $this->belongsTo('App\Course');
    }

    public function files()
    {
    	return $this->morphMany('App\File', 'filelable');
    }

    public function exams()
    {
        return $this->hasMany('App\Exam');
    }
}
