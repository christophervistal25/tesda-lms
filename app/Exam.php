<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['title'];
    public const PASSING_GRADE = 50;


    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function module()
    {
        return $this->belongsTo('App\Module');
    }


}
