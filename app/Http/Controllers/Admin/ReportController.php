<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\StudentRegisteredReportRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function __construct(StudentRegisteredReportRepository $studentReportRepo)
    {
        $this->studentReportRepo = $studentReportRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.report.index');
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
        $this->validate($request, [
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $from = Carbon::parse($request->start_date);
        $to   = Carbon::parse($request->end_date);
        $registeredStudents      =  $this->studentReportRepo->getRegisteredStudentsFrom($from, $to);
        $registeredWithCourse    =  $this->studentReportRepo->getRegisteredStudentWithCourse($from, $to);
        $registeredWithFinalExam =  $this->studentReportRepo->getRegisteredStudentWithFinishExam($from, $to);

        $generated = true;

        return view('admin.report.index', compact('registeredStudents', 'registeredWithCourse', 'registeredWithFinalExam', 'generated', 'from', 'to'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
