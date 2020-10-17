<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'email', 'password', 'firstname', 'surname', 'city_town', 'country',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->hasMany('App\Models\Student\EnrollCourse');
    }

     
    public function accomplish_files()
    {
        return $this->morphedByMany('App\File', 'userable')->withTimestamps();
    }

    
    public function accomplish_activities()
    {
        return $this->morphedByMany('App\Activity', 'userable')->withTimestamps();
    }

    public function accomplish_exam()
    {
        return $this->morphedByMany('App\Exam', 'userable')->withTimestamps();
    }

    public function exam_attempt()
    {
        return $this->hasMany('App\ExamAttempt');
    }

    public function exam_results()
    {
        return $this->hasMany('App\ExamResult');
    }
}
