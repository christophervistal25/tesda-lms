<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\StudentRegisteredReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReportPrintController extends Controller
{
	public function __construct(StudentRegisteredReportRepository $studentReportRepo)
	{
		$this->studentReportRepo = $studentReportRepo;
	}

    public function show($from, $to)
    {
		$from = Carbon::parse($from);
		$to   = Carbon::parse($to);

		$data['registeredStudents']      =  $this->studentReportRepo->getRegisteredStudentsFrom($from, $to);
		$data['registeredWithCourse']    = $this->studentReportRepo->getRegisteredStudentWithCourse($from, $to);
		$data['registeredWithFinalExam'] = $this->studentReportRepo->getRegisteredStudentWithFinishExam($from, $to);
        

    	$pdf = \App::make('dompdf.wrapper');
		$pdf->loadView('admin.report.print', compact('data'))->setPaper('a4');
		return $pdf->stream();
    }
}
