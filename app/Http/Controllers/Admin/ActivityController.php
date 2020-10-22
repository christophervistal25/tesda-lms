<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Activity;
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
       /* $activity = Activity::with('modules', 'modules.course')->find($activity_id);
        $course = $activity->modules->first()->course;

        $nextActivity             = $this->getActivityNext($activity->activity_no);
        $previousActivity         = $this->getActivityPrevious($activity->activity_no);
        $lastPageOfCourseOverview = $course->overview->files->last();*/


        
        $activity = Activity::with('modules', 'modules.course')->find($activity_id);
        $course = $activity->modules->first()->course;
        $overview = $course->modules->where('is_overview', 1)->first();

        $this->viewer->process([
          'course'      => $course,
          'activity_no' => $activity->activity_no,
          'activity_id' => $activity_id,
       ]);


        $files = $course->modules->where('is_overview', 1)->first()->files;
        $modules = $course->modules->where('is_overview', 0);
        
        $moduleWithExam = $this->examRepository->getExam($course);

        if (!$activity->completion) {
            $next     = $this->viewer->getNext();
            $previous = $this->viewer->getPrevious();    
        } else { 
            $next = Activity::where('module_id', $activity->module_id)->where('completion', 1)->get();
            $next = $next->filter(function ($next) use ($activity_id) {
                    return $next->id != $activity_id;
            });
            $next = $next->count() == 0 ? null : $next;
            $previous = $moduleWithExam->exam;
        }

        return view('admin.activity.view', compact('activity', 'course', 'next', 'previous', 'files', 'modules', 'activity_id', 'moduleWithExam', 'canTakeExam', 'canDownloadCertificate'));
    }

}
