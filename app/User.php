<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Helpers\Traits\UserLaratables;
use App\Course;

class User extends Authenticatable
{
    use Notifiable, UserLaratables;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'email', 'password', 'firstname', 'surname', 'city_town',
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

    public function noOfActivities(Course $course)
    {
        $noOfActivities = 0;
        foreach ($course->modules as $module) {
            if ($module->is_overview == 1) {
                $noOfActivities += $module->files->count();
            } else {
                $noOfActivities += $module->activities->count();
            }
        }

        return $noOfActivities;
    }
    
    public function progress()
    {
        $accomplish = $this->accomplish_files()->count() + $this->accomplish_activities->count();
        if ($this->courses->last() != null) {
            if ($accomplish != 0) {
                return $accomplish * (config('student_progress.max_percentage') / $this->noOfActivities($this->courses->last()->course));
            }
        }
        
        return $accomplish;
    }
    
}
