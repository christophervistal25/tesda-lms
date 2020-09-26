<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = ['firstname', 'middlename', 'lastname', 'contact_no', 'image'];

    public function courses()
    {
    	return $this->belongsToMany('App\Course')->withTimestamps();
    }

    public static function laratablesFirstname($instructor)
    {
    	return $instructor->lastname . ', ' . $instructor->firstname . ' ' . $instructor->middlename;
    }

    public static function laratablesCustomAction($batch)
    {
    	return view('admin.batch.includes.index_action', compact('batch'))->render();
    }
}
