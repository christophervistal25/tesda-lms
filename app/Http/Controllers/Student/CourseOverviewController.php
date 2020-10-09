<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\File as OverviewFile;
use Illuminate\Support\Str;
use App\Helpers\ActivityViewer;

class CourseOverviewController extends Controller
{
    public function __construct(ActivityViewer $viewer)
    {
      $this->viewer = $viewer;
    }
    

    public function show($course, $fileId = null)
    {
       $course = Course::find($course);

       $this->viewer->process([
          'state'   => 'overview',
          'course'  => $course,
          'file_id' => $fileId,
       ]);

       $file = OverviewFile::find($fileId);
       
       $next = $this->viewer->getNext();
       $previous = $this->viewer->getPrevious();

       $files = $course->modules->where('is_overview', 1)->first()->files;
       $modules = $course->modules->where('is_overview', 0);

       
       return view('student.course.overview.show', compact('course', 'next', 'previous', 'file', 'files', 'modules', 'fileId'));
    }
}
