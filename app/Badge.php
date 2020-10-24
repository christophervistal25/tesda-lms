<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable  = ['course_id', 'name', 'description', 'image'];

    public function course()
    {
    	return $this->belongsTo('App\Course');
    }

    public static function criteriasOf(int $id)
    {
    	return self::with(['files', 'activities'])->find($id);
    }

    public function activities()
    {
        return $this->morphedByMany('App\Activity', 'badgeable')->withTimestamps();
    }

    public function files()
    {
        return $this->morphedByMany('App\File', 'badgeable')->withTimestamps();
    }
   
}
