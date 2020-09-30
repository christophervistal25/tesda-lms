<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $fillable = ['module_id', 'activity_no', 'title', 'body', 'instructions', 'downloadable'];

    public function files()
    {
    	return $this->hasMany('App\File');
    }

    public function modules()
    {
    	return $this->hasMany('App\Module' , 'id', 'module_id');
    }
}
