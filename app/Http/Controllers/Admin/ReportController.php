<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class ReportController extends Controller
{
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

    private function getRegisteredStudentsFrom(Carbon $from, Carbon $to)
    {
        return User::whereBetween('created_at', [$from->format('Y-m-d')." 00:00:00", $to->format('Y-m-d')." 23:59:59"])
                                ->get();
    }

    private function getRegisteredStudentWithCourse(Carbon $from, Carbon $to)
    {
        return User::has('courses')->whereBetween('created_at', [$from->format('Y-m-d')." 00:00:00", $to->format('Y-m-d')." 23:59:59"])
                                          ->get();
    }

    public function getRegisteredStudentWithFinishExam(Carbon $from, Carbon $to)
    {
        return User::has('accomplish_exam')->whereBetween('created_at', [$from->format('Y-m-d')." 00:00:00", $to->format('Y-m-d')." 23:59:59"])
                                             ->get();
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
        $registeredStudents               =  $this->getRegisteredStudentsFrom($from, $to);
        $registeredWithCourse     =  $this->getRegisteredStudentWithCourse($from, $to);
        $registeredWithFinalExam =  $this->getRegisteredStudentWithFinishExam($from, $to);

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
