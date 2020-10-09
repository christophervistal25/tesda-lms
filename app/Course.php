<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'acronym', 'description', 'design', 'image', 'active', 'duration'];


    public function enroll()
    {
        return $this->hasOne('App\Models\Student\EnrollCourse');
    }

    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function modules()
    {
        return $this->hasMany('App\Module');
    }

    public function prerequisites()
    {
    	return $this->belongsToMany('App\Prerequisite')->withTimestamps();
    }

    public function instructors()
    {
    	return $this->belongsToMany('App\Instructor')->withTimestamps();
    }

    public function overview()
    {
        return $this->hasOne('App\Overview');
    }

    public function discussions()
    {
        return $this->hasMany('App\Post');
    }
}
