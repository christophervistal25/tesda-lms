<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\StudentRegisteredReportRepository;
use App\ShareableLink;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportController extends Controller
{

    public function __construct(StudentRegisteredReportRepository $studentReportRepo)
    {
        $this->studentReportRepo = $studentReportRepo;
    }

    public function generateLink(Request $request)
    {
        $id_link = (string) Str::uuid();

        $this->validate($request, [
            'from'       => 'required|date|before:to',
            'to'         => 'required|date|after:from',
            'expiration' => 'required|date'
        ]);

        $share = ShareableLink::updateOrCreate([
                'from'    => $request->from,
                'to'      => $request->to,
            ], [
                'id_link' => $id_link,
                'from'    => $request->from,
                'to'      => $request->to,
                'expiration' => $request->expiration,
        ]);

        return response()->json(['success' => true, 'id_link' => $share->id_link]);


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
