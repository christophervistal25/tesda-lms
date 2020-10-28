<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User as Student, Course, Module, Activity, File};

class AdminController extends Controller
{
    public function index()
    {
		$students   = Student::count();
		$course     = Course::count();
		$modules    = Module::count();
		$activities = Activity::count();
        return view('admin', compact('students', 'course', 'modules', 'activities'));
    }

    public function logout()
    {
    	auth('admin')->logout();
    	return redirect(route('admin.dashboard'));
    }
}
