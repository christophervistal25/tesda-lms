<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $fillable = ['module_id', 'activity_no', 'title', 'body', 'instructions', 'icon', 'downloadable', 'completion'];

 	
 	public function files()
    {
    	return $this->morphMany('App\File', 'filelable');
    }  

    public function modules()
    {
    	return $this->hasMany('App\Module' , 'id', 'module_id');
    }

    public function accomplish()
    {
        return $this->morphToMany('App\User', 'userable');
    }
}
