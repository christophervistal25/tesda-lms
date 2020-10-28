<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class AboutCourseController extends Controller
{
    public function show($course)
    {
    	$course = Course::with('program')->find($course);
    	return view('about-course', compact('course'));
    }
}
