<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareableLink extends Model
{
    protected $fillable = ['id_link', 'from', 'to', 'expiration'];
    protected $dates = [
    	'expiration'
    ];
}
