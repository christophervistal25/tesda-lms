<?php

namespace App\Http\Middleware;

use App\Models\Student\EnrollCourse;
use App\Repositories\StudentRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class StudentCourseStatusMiddleware
{
    public function __construct(StudentRepository $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->studentRepo->setStudent(Auth::user());
        if ($this->studentRepo->hasFinishEnrolledCourse()) {
            // Get the student ID and course ID
            $courseId = $this->studentRepo->getCourse()->id;
            $studentId = Auth::user()->id;
            $enrollCourse = 
            EnrollCourse::where(['user_id' => $studentId, 'course_id' => $courseId])->update([
                'status' => 'completed'
            ]);
        }

        return $next($request);
    }
}
