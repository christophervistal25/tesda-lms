<?php

namespace App;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['name', 'batch_no', 'active'];

    public function courses()
    {
        return $this->hasMany('App\Course');
    }

    public function programs()
    {
        return $this->hasMany('App\Program');
    }


    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
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
