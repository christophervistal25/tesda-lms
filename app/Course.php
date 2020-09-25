<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'description', 'batch_id', 'program_id', 'active'];

    public function batch()
    {
        return $this->belongsTo('App\Batch');
    }

    public function program()
    {
        return $this->belongsTo('App\Program');
    }
}
