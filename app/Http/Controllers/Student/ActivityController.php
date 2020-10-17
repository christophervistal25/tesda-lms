<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Activity;
// use App\Overview;
use App\Helpers\ActivityViewer;
use App\Helpers\ExamRepository;

class ActivityController extends Controller
{

    public function __construct(ActivityViewer $viewer, ExamRepository $examRepo)
    {
        $this->viewer = $viewer;
        $this->examRepository = $examRepo;
    }

    public function view($activity_id)
    {
        $canTakeExam = false;
        $activity = Activity::with('modules', 'modules.course')->find($activity_id);
        $course = $activity->modules->first()->course;
        $overview = $course->modules->where('is_overview', 1)->first();

        $this->viewer->process([
          'state'   => 'activity',
          'course'  => $course,
          'activity_id' => $activity_id,
       ]);

        $next = $this->viewer->getNext();
        $previous = $this->viewer->getPrevious();
       

        $files = $course->modules->where('is_overview', 1)->first()->files;
        $modules = $course->modules->where('is_overview', 0);
        
        $moduleWithExam = $this->examRepository->getExam($course);

        $canTakeExam = $this->examRepository->isUserCanTakeExam($course);

        return view('student.activity.view', compact('activity', 'course', 'next', 'previous', 'files', 'modules', 'activity_id', 'moduleWithExam', 'canTakeExam'));
    }


}
