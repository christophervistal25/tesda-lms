<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\File as OverviewFile;
use Illuminate\Support\Str;
use App\Helpers\OverviewViewer;
use App\Helpers\ExamRepository;

class CourseOverviewController extends Controller
{
    public function __construct(OverviewViewer $viewer, ExamRepository $examRepo)
    {
      $this->viewer = $viewer;
      $this->examRepository = $examRepo;
    }
    

    public function show($course, $fileId = null)
    {
       $canTakeExam = false;
       $course = Course::with('modules')->find($course);

       $this->viewer->process([
          'course'  => $course,
          'file_id' => $fileId,
       ]);

       $file = OverviewFile::find($fileId);
       
       $next     = $this->viewer->getNext();
       $previous = $this->viewer->getPrevious();


       $files = $course->modules->where('is_overview', 1)->first()->files;
       $modules = $course->modules->where('is_overview', 0);
       
       
       $moduleWithExam = $this->examRepository->getExam($course);
       $canTakeExam = $this->examRepository->isUserCanTakeExam($course);

       return view('student.course.overview.show', compact('course', 'next', 'previous', 'file', 'files', 'modules', 'fileId', 'canTakeExam', 'moduleWithExam'));
    }
}
