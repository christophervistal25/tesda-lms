<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public const TYPES = ['activity', 'file'];
	protected $fillable = ['module_id', 'activity_no', 'title', 'body', 'instructions', 'icon', 'downloadable', 'completion'];
    
    public static function paginateGetPrevious($moduleAndIndex)
    {
        return self::where('activity_no', '<', $moduleAndIndex)
                    ->where('completion', null)
                    ->get()
                    ->sortBy('activity_no')
                    ->last();
    }

    public static function paginateGetNext($moduleAndIndex)
    {
        return self::where('activity_no', '>', $moduleAndIndex)
                    ->where('completion', null)
                    ->get()
                    ->sortBy('activity_no')
                    ->first();
    }

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

    public function badges()
    {
        return $this->morphToMany('App\Badge', 'badgeable');
    }
}
