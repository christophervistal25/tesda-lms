<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'description', 'active'];


    public function program()
    {
        return $this->belongsTo('App\Program');
    }

    public function instructors()
    {
    	return $this->belongsToMany('App\Instructor')->withTimestamps();
    }
}
