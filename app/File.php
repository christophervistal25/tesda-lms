<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['title', 'link', 'overview_id'];
    // protected $fillable = ['name', 'link', 'type', 'size'];
}
