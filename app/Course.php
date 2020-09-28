<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'description', 'design', 'active', 'duration'];


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
}
