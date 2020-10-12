<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use Auth;
use App\Course;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $progress       = 0;
        $noOfActivities = 0;
        $student        = Auth::user();
        $userCourse     = $student->courses->last()->course;
        $studentCourse  = Course::with(['modules'])->find($userCourse->id);

        foreach ($studentCourse->modules as $module) {
            if ($module->is_overview == 1) {
                $noOfActivities += $module->files->count();
            } else {
                $noOfActivities += $module->activities->count();
            }
        }


        $accomplish_activities = $student->accomplish_files->count() + $student->accomplish_activities->count();

        $progress = $accomplish_activities * (100 / $noOfActivities);

        $studentCourses = $student->courses;

        return view('home', compact('progress', 'studentCourses'));
    }

    public function siteHome()
    {
       $programs = Program::with('courses')->get();
       return view('student.site-home', compact('programs'));
    }
}
