<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Activity;
// use App\Overview;
use App\Helpers\ActivityViewer;
use App\Helpers\ExamRepository;
use App\Helpers\CertificateRepository;

class ActivityController extends Controller
{

    public function __construct(ActivityViewer $viewer, ExamRepository $examRepo, CertificateRepository $certificateRepo)
    {
        $this->viewer = $viewer;
        $this->examRepository = $examRepo;
        $this->certificateRepository = $certificateRepo;
    }

    public function view($activity_id)
    {
        $canDownloadCertificate = $this->certificateRepository->isUserCanDownload();
        $canTakeExam = false;
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

        $canTakeExam = $this->examRepository->isUserCanTakeExam($course);

        if (!$activity->completion) {
            $next     = $this->viewer->getNext();
            $previous = $this->viewer->getPrevious();    
        } else { // This means that the user currently in the activity completion
            $next = Activity::where('module_id', $activity->module_id)->where('completion', 1)->get();
            $next = $next->filter(function ($next) use ($activity_id) {
                    return $next->id != $activity_id;
            });
            $next = $next->count() == 0 ? null : $next;
            $previous = $moduleWithExam->exam;
        }

        return view('student.activity.view', compact('activity', 'course', 'next', 'previous', 'files', 'modules', 'activity_id', 'moduleWithExam', 'canTakeExam', 'canDownloadCertificate'));
    }


}
