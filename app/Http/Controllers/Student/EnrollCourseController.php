<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Models\Student\EnrollCourse;
use Auth;

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
    	return redirect()->route('student.course.view', $id);
    }
}
