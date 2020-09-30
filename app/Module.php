<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['title', 'body', 'course_id'];

    public function activities()
    {
    	return $this->hasMany('App\Activity');
    }

    public function course()
    {
    	return $this->belongsTo('App\Course');
    }
}
