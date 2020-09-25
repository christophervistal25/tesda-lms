<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
	protected $fillable = ['name', 'active'];

    public function courses()
    {
        return $this->hasMany('App\Course');
    }

    public static function laratablesCustomAction($program)
    {
    	return view('admin.programs.includes.index_action', compact('program'))->render();
    }

	public static function laratablesCreatedAt($program)
	{
	    return $program->created_at->diffForHumans();
	}

	public static function laratablesOrderName()
	{
	    return 'created_at';
	}
}
