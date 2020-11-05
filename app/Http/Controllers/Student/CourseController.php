<?php

namespace App\Http\Controllers\Student;

use App\Activity;
use App\Course;
use App\Helpers\CertificateRepository;
use App\Helpers\ExamRepository;
use App\Http\Controllers\Controller;
use App\Module;
use App\Repositories\CourseRepository;
use App\StudentActivityLog;
use Auth;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function __construct(ExamRepository $examRepo, CertificateRepository $certificateRepo)
    {
        $this->examRepository = $examRepo;
        $this->certificateRepository = $certificateRepo;
        $this->courseRepository = new CourseRepository();
    }

    public function design(Course $course)
    {
        $courseDesign = $course->modules->where('is_overview', 1)
                               ->first()
                               ->files
                               ->where('title', 'like' , 'Course Design')
                               ->first();
        
        return redirect()->route('student.course.overview.show.file', [$course, $courseDesign->id]);

        // $variables = ['course', 'forceview'];
        
       // $courseModuleFirstActivity = $course->modules->first()->activities->where('activity_no', '1.1')->first();
        
        // return view('student.course.design', compact('course', 'firstFile', 'courseModuleFirstActivity'));
    }

    public function getCourseDesign($id)
    {
        return Course::find($id)->modules
                        ->where('is_overview', 1)
                        ->first()
                        ->files
                        ->where('title', 'Course Design')
                        ->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        // Checker if the course complete the it's modules.
        $course = Course::with(['modules'])->find($id);
        if (!$this->courseRepository->isModulesReady($course)) {
            return view('layouts.student.getting-ready');
        }

        StudentActivityLog::view(Auth::user()->id, 'view module of service - ' . $course->acronym);
        
        $modules = null;
        $overview = null;
      
        $canDownloadCertificate = $this->certificateRepository->isUserCanDownload();
        
        $overview = $course->modules->where('is_overview', 1)
                            ->first();


        $student_id = Auth::user()->id;


        $noOfOverviewFiles = $overview->files->count();
        
        $overviewFiles     = $overview->files->toJson();
        
        $studentAccomplish = Auth::user()->accomplish_files
                                    ->pluck('id')->toJson();

        $studentActivitiesAccomplish = Auth::user()->accomplish_activities
                                            ->pluck('id')
                                            ->toArray();

        $canTakeExam = $this->examRepository->isUserCanTakeExam($course);


        $studentAccomplishExam = Auth::user()->accomplish_exam->pluck('id');


        $noOfAccomplishActivityByModule = Auth::user()->accomplish_activities->groupBy(function ($data) {
            return  $data->module_id;
        })->toJson();


        $accomplishExamByModule = Auth::user()->accomplish_exam->groupBy(function ($data) {
            return  $data->module_id;
        })->toJson();

        $modules = $course->modules->where('is_overview', 0);


        return view('student.course-enroll.module.show', compact('course', 'student_id', 'overview', 'noOfOverviewFiles', 'overviewFiles', 'studentAccomplish', 'studentActivitiesAccomplish', 'noOfAccomplishActivityByModule', 'studentAccomplishExam', 'accomplishExamByModule', 'canTakeExam', 'canDownloadCertificate', 'modules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
