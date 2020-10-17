<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use App\MultipleChoice;
use App\Exam;
use App\Question;
use App\Helpers\ExamRepository;

class FinalExamController extends Controller
{
    public function __construct(ExamRepository $e)
    {
        $this->examRepository = $e;
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
    public function create(Module $module)
    {
        return view('admin.examination.create', compact('module'));
    }

    private function insertMultipleChoiceQuestion(array $questions = [], Exam $exam)
    {
         
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Module $module)
    {
        if (request()->ajax()) {
            $exam = new Exam([ 'title' => 'Final Exam' ]);
            $exam = $module->exam()->save($exam);

            if (isset($request->multipleChoice)) {
                $this->examRepository->insertMultipleChoice($request->multipleChoice, $exam);
            }

            if (isset($request->fillIntheBlank)) {
                $this->examRepository->insertFillIn($request->fillIntheBlank, $exam);   
            }

            if (isset($request->trueOrFalse)) {
                $this->examRepository->insertTrueOrFalse($request->trueOrFalse, $exam);      
            }

        }

        return response()->json(['success' => true]);
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
