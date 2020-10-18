<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Activity;
use Auth;
use App\Module;
use App\Helpers\ExamRepository;
use App\Helpers\CertificateRepository;

class CourseController extends Controller
{

    public function __construct(ExamRepository $examRepo, CertificateRepository $certificateRepo)
    {
        $this->examRepository = $examRepo;
        $this->certificateRepository = $certificateRepo;
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
        $modules = null;
        $overview = null;
      
        $canDownloadCertificate = $this->certificateRepository->isUserCanDownload();

        $course = Course::with(['modules'])->find($id);
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


        return view('student.course-enroll.module.show', compact('course', 'student_id', 'overview', 'noOfOverviewFiles', 'overviewFiles', 'studentAccomplish', 'studentActivitiesAccomplish', 'noOfAccomplishActivityByModule', 'studentAccomplishExam', 'accomplishExamByModule', 'canTakeExam', 'canDownloadCertificate'));
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
