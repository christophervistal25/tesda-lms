<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use App\MultipleChoice;
use App\Exam;

class FinalExamController extends Controller
{
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Module $module)
    {
        if (request()->ajax()) {
          

            // check if there's multiple choice questions.
            if (isset(request()->multipleChoice)) {
               $exams = [];
                foreach (request()->multipleChoice as $q) {
                    $exams[] = new Exam([
                        'question_no' => $q['question_no'],
                        'question'    => $q['question'],
                        'answer'      => $q['correct_answer'],
                        'type'        => 'MULTIPLE',
                    ]);

                    $module->exams()->saveMany($exams);

                    foreach ($q['choices'] as $key => $choice) {
                        $choice = preg_replace('/^\w-/', '', $choice);
                        foreach ($exams as $exam) {
                            $exam->choices()->save(new MultipleChoice(['choice' => $choice]));    
                        }
                    }

                }
            }

            // check if there's fill in the blank questions.

            if (isset(request()->fillIntheBlank)) {
                $exams = [];
                foreach (request()->fillIntheBlank as $q) {
                    $exams[] = new Exam([
                        'question_no' => $q['question_no'],
                        'question'    => $q['question'],
                        'answer'      => $q['correct_answer'],
                        'type'        => 'FITB',
                    ]);
                }

                $module->exams()->saveMany($exams);
            }

            // check if there's true or false questions.
            if (isset(request()->trueOrFalse)) {
                $exams = [];
                foreach (request()->trueOrFalse as $q) {
                    $exams[] = new Exam([
                        'question_no' => $q['question_no'],
                        'question'    => $q['question'],
                        'answer'      => $q['correct_answer'],
                        'type'        => 'TORF',
                    ]);
                }

                $module->exams()->saveMany($exams);
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
