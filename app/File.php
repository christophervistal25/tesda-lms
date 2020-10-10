<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $fillable = ['title', 'body', 'icon', 'link', 'type', 'filelable_id', 'filelable_type'];

	public function filelble()
	{
		return $this->morphTo();
	}

	
    public function accomplish()
    {
        return $this->morphToMany('App\User', 'userable');
    }

}
