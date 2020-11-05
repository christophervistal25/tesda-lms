<?php

namespace App\Http\Controllers\Student;

use App\Course;
use App\Http\Controllers\Controller;
use App\Models\Student\EnrollCourse;
use App\StudentActivityLog;
use Auth;
use Illuminate\Http\Request;

class EnrollCourseController extends Controller
{
    public function show(int $id)
    {
    	$course = Course::find($id);
    	return view('student.course-enroll.show', compact('course'));
    }

    public function enroll(int $id)
    {
    	$enroll = new EnrollCourse();
    	$enroll->course_id = $id;
    	$user = Auth::user();
    	$user->courses()->save($enroll);

        StudentActivityLog::create([
            'user_id' => Auth::user()->id,
            'perform' => 'Enroll to service - ' . Course::find($id)->acronym,
        ]);

    	return redirect()->route('student.course.view', $id);
    }
}
