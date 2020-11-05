<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'course_id', 'posted_by'];

    public function course()
    {
    	return $this->hasOne('App\Course', 'id', 'course_id');
    }

    public function postBy()
    {
    	return $this->belongsTo('App\Admin', 'posted_by', 'id');
    }

    public function comments()
    {
    	return $this->hasMany('App\Comment');
    }
}
