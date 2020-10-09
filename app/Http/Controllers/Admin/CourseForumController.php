<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;

class CourseForumController extends Controller
{
    public function show($course)
    {
    	$discussions = Course::with('discussions')->find($course);
    }
}
