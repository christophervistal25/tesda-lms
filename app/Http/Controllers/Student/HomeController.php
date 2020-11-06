<?php

namespace App\Http\Controllers\Student;

use App\Course;
use App\Http\Controllers\Controller;
use App\Program;
use App\Repositories\StudentRepository;
use Auth;
use Illuminate\Http\Request;


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

        $this->studentRepository->hasFinishEnrolledCourse();

        
        $progress       = $this->studentRepository->getProgress();
        $studentCourses = $this->studentRepository->getCourses();
        $currentCourse  = $this->studentRepository->getCourse();
      
        
        return view('home', compact('progress', 'studentCourses', 'student', 'currentCourse'));
    }

    public function siteHome()
    {
       $this->studentRepository->setStudent(Auth::user());
       $finishedCourse = $this->studentRepository->finishedCourse();
       $programs = Program::with('courses')->get();
       return view('student.site-home', compact('programs', 'finishedCourse'));
    }
}
