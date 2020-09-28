<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prerequisite extends Model
{
    protected $fillable = ['course_id'];

    public function courses()
    {
    	return $this->belongsToMany('App\Course')->withTimestamps();
    }

    public function course_info()
    {
		return $this->hasOne('App\Course');    	
    }
}
