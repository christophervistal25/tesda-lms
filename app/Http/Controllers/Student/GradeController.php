<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use Auth;
use App\Repositories\StudentRepository;
use App\Helpers\ExamRepository;

class GradeController extends Controller
{
	public function __construct(StudentRepository $studentRepo, ExamRepository $examRepo)
	{
		$this->studentRepository = $studentRepo;
		$this->examRepository = $examRepo;
	}

    public function show(Course $course)
    {
   		$currentCourse = $this->studentRepository->getCourse();

    	$examGrades = [];
    	
    	$noOfQuestions = 0;
    	$results = $currentCourse->enroll
    							->student
    							->exam_results
    							->groupBy('exam_attempt_id')
    							->each(function ($result, $attempt_id) use(&$examGrades, &$noOfQuestions) {
    								$noOfQuestions = $result->count();
    								$examGrades[$attempt_id] = (int) $result->where('status', 'correct')->count();
    							});

    	// Get only the max exam result of the student.
    	if (count($examGrades) != 0) {
    		asort($examGrades);
    		$highestGrade = last($examGrades);
    	} 

    	$module = $this->examRepository->getExam($currentCourse);
    	
    	return view('student.grade.report.show', compact('course', 'currentCourse', 'highestGrade', 'noOfQuestions', 'module'));
    }
}
