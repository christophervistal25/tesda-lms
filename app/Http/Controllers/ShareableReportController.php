<?php

namespace App\Http\Controllers;

use App\Repositories\StudentRegisteredReportRepository;
use App\ShareableLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ShareableReportController extends Controller
{
	public function __construct(StudentRegisteredReportRepository $studentReportRepo)
	{
		$this->studentReportRepo = $studentReportRepo;
	}

    public function show($id)
    {
		$link = ShareableLink::where('id_link', $id)->first();
		
    	if (!is_null($link) && Carbon::now()->diffInDays($link->expiration) <= 0) {
    		$from = Carbon::parse($link->from);
			$to   = Carbon::parse($link->to);
	    	$registeredStudents      =  $this->studentReportRepo->getRegisteredStudentsFrom($from, $to);
	        $registeredWithCourse    =  $this->studentReportRepo->getRegisteredStudentWithCourse($from, $to);
	        $registeredWithFinalExam =  $this->studentReportRepo->getRegisteredStudentWithFinishExam($from, $to);
	    	return view('shareable.report', compact('registeredStudents', 'registeredWithCourse', 'registeredWithFinalExam'));	
    	} else {
    		abort(404);
    	}
		
    }
}
