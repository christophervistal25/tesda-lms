<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public const TYPES   = ['overview', 'module'];
    protected $fillable = ['title', 'body', 'course_id', 'is_overview'];

    public function activities()
    {
    	return $this->hasMany('App\Activity');
    }

    public function course()
    {
    	return $this->belongsTo('App\Course')->withDefault();
    }

    public function files()
    {
    	return $this->morphMany('App\File', 'filelable');
    }

    public function exam()
    {
        return $this->hasOne('App\Exam');
    }

    public function badges()
    {
        return $this->morphToMany('App\Badge', 'badgeable');
    }
}
