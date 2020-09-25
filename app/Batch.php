<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['name', 'batch_no', 'active'];

    public function courses()
    {
        return $this->hasMany('App\Course');
    }

    public static function laratablesCustomAction($batch)
    {
    	return view('admin.batch.includes.index_action', compact('batch'))->render();
    }

	public static function laratablesCreatedAt($batch)
	{
	    return $batch->created_at->diffForHumans();
	}

	public static function laratablesOrderName()
	{
	    return 'created_at';
	}
}
