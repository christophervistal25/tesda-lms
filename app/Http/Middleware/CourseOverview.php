<?php

namespace App\Http\Middleware;

use Closure;
use App\Course;

class CourseOverview
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->course instanceof Course) {
            $course = $request->course;
        } else {
            $course = Course::find($request->course);    
        }

        ;
        if (is_null($course->modules->where('is_overview', 1)->first())) {
          return  redirect()->route('create.course.overview', $course->id)->with('nocourse', true);
        } 
        return $next($request);
    }
}
