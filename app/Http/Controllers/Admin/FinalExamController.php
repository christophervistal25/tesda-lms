<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use App\MultipleChoice;
use App\Exam;
use App\Question;
use App\Helpers\ExamRepository;
use App\Activity;
use Illuminate\Support\Arr;


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
        
        $course = $module->course;
        $moduleIds = $course->modules->where('is_overview', 0)
                          ->pluck('id')
                          ->toArray();
                          
        $activities = Activity::whereIn('module_id', $moduleIds)->count();
        
        if ($activities != 0) {
            return view('admin.examination.create', compact('module'));    
        } else {
            return redirect(route('course.edit.module', $module))->with('no_activity', 'Please add activity first before making a final exam.');
        }
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
    public function edit($exam)
    {
        $exam = Exam::find($exam);
        $questions = $exam->questions->sortBy('question_no');
        return view('admin.examination.edit', compact('exam', 'questions'));
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
        if ($request->ajax()) {
            $exam = Exam::find($id);
            if (isset($request->multipleChoice)) {
                foreach ($request->multipleChoice as $key => $q) {
                    $question = Question::firstOrNew([ 'question_no' => $q['question_no'] ], [
                        'exam_id'  => $id,
                        'question' => $q['question'],
                        'answer'   => $q['correct_answer'],
                        'type'     => 'MULTIPLE',
                    ]);
                    $exam->questions()->save($question);

                    foreach ($q['choices'] as $choice) {
                        $question->choices()->updateOrCreate(
                            [
                                'question_id' => $question->id,
                                'choice'      => $choice,
                            ],
                            [
                                'question_id' => $question->id,
                                'choice'      => $choice,
                            ]
                        );
                    }
                }
            }


            if (isset($request->fillIntheBlank)) {
                foreach ($request->fillIntheBlank as $key => $q) {
                    $question = Question::firstOrNew(
                        [ 
                            'question_no' => $q['question_no'] 
                        ],
                        [
                            'exam_id'  => $id,
                            'question' => $q['question'],
                            'answer'   => $q['correct_answer'],
                            'type'     => 'FITB',
                        ]
                );
                    $exam->questions()->save($question);
                }
            }

            if (isset($request->trueOrFalse)) {
                foreach ($request->trueOrFalse as $key => $q) {
                    $question = Question::firstOrNew(
                        [ 
                            'question_no' => $q['question_no'] 
                        ],
                        [
                            'exam_id'  => $id,
                            'question' => $q['question'],
                            'answer'   => $q['correct_answer'],
                            'type'     => 'TORF',
                        ]
                     );
                    $exam->questions()->save($question);
                }
            }
            return response()->json(['success' => true]);
        }
        
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
