<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class HomePageController extends Controller
{
    public function index()
    {
    	return redirect('/login');
    	// $courses = Course::with(['program', 'program.batch'])
     //                    ->where('active', 1)
     //                    ->orderBy('created_at', 'DESC')
     //                    ->get();

    	// return view('welcome', compact('courses'));
    }
}
