<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overview extends Model
{
	protected $fillable = ['body', 'course_id'];

    public function files()
    {
    	return $this->hasMany('App\File');
    }
}
