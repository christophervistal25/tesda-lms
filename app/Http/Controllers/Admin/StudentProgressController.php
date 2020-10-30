<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User as Student;
use App\Course;

use App\Repositories\StudentRepository;
class StudentProgressController extends Controller
{
	public function __construct(StudentRepository $studentRepo)
	{
		$this->studentRepository = $studentRepo;
	}

    public function show($student)
    {
    	$student = Student::find($student);

    	$this->studentRepository->setStudent($student);
        // Checker if the course complete the it's modules.
        $course = Course::with(['modules'])->find(
        	$this->studentRepository->getCourse()->id
        );


        $modules = null;
        $overview = null;
      
        
        $overview = $course->modules->where('is_overview', 1)
                            ->first();



        $noOfOverviewFiles = $overview->files->count();
        
        $overviewFiles     = $overview->files->toJson();
        
        $studentAccomplish = $student->accomplish_files
                                    ->pluck('id')->toJson();

        $studentActivitiesAccomplish = $student->accomplish_activities
                                            ->pluck('id')
                                            ->toArray();



        $studentAccomplishExam = $student->accomplish_exam->pluck('id');


        $noOfAccomplishActivityByModule = $student->accomplish_activities->groupBy(function ($data) {
            return  $data->module_id;
        })->toJson();


        $accomplishExamByModule = $student->accomplish_exam->groupBy(function ($data) {
            return  $data->module_id;
        })->toJson();


        return view('admin.students.progress.show', compact('student', 'course', 'overview', 'noOfOverviewFiles', 'overviewFiles', 'studentAccomplish', 'studentActivitiesAccomplish', 'noOfAccomplishActivityByModule', 'studentAccomplishExam', 'accomplishExamByModule'));
    }
}
