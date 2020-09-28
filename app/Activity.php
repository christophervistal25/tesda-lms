<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $fillable = ['activity_no', 'title', 'body', 'instructions'];
    public function files()
    {
    	return $this->hasMany('App\File');
    }
}
