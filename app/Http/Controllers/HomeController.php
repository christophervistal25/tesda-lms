<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use Auth;
use App\Course;
use App\Repositories\StudentRepository;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StudentRepository $studentRepo)
    {
        $this->middleware('auth');
        $this->studentRepository = $studentRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $student = Auth::user();
        $this->studentRepository->setStudent($student);
        if (!$this->studentRepository->hasCourse()) {
            // Redirect the student to enroll page.
            return redirect(route('site.home'));
        }

        
        $progress       = $this->studentRepository->getProgress();
        $studentCourses = $this->studentRepository->getCourses();
        $currentCourse  = $this->studentRepository->getCourse();
      
        
        return view('home', compact('progress', 'studentCourses', 'student', 'currentCourse'));
    }

    public function siteHome()
    {
       $programs = Program::with('courses')->get();
       return view('student.site-home', compact('programs'));
    }
}
