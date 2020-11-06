<?php

namespace App\Http\Controllers\Student;

use App\Course;
use App\Http\Controllers\Controller;
use App\Models\Student\EnrollCourse;
use App\Repositories\StudentRepository;
use App\StudentActivityLog;
use Auth;
use Illuminate\Http\Request;

class EnrollCourseController extends Controller
{
    public function __construct(StudentRepository $studentRepo)
    {
        $this->studentRepository = $studentRepo;
    }

    public function show(int $id)
    {
    	$course = Course::find($id);
        $this->studentRepository->setStudent(Auth::user());
        // Check if user already enrolled this course.
        if (!is_null($this->studentRepository->getCourses())) {
            
            $studentEnrollCourse = $this->studentRepository->getCourses()
                                        ->where('status', 'in_progress')
                                        ->pluck('course_id')
                                        ->toArray();
                                        
            if (in_array($id, $studentEnrollCourse)) {
                return redirect()->route('student.course.view', $id);
            }
        }
    	return view('student.course-enroll.show', compact('course'));
    }

    public function enroll(int $id)
    {
        $user = Auth::user();
        $this->studentRepository->setStudent(Auth::user());
        // Check if user already enrolled this course.
        if (!is_null($this->studentRepository->getCourses())) {
            
            $studentEnrollCourse = $this->studentRepository->getCourses()
                                        ->where('status', 'in_progress')
                                        ->pluck('course_id')
                                        ->toArray();
                                        
            if (in_array($id, $studentEnrollCourse)) {
                return redirect()->route('student.course.view', $id);
            }
        }
    	$enroll = new EnrollCourse();
    	$enroll->course_id = $id;
    	$user->courses()->save($enroll);

        StudentActivityLog::create([
            'user_id' => Auth::user()->id,
            'perform' => 'Enroll to service - ' . Course::find($id)->acronym,
        ]);

    	return redirect()->route('student.course.view', $id);
    }
}
