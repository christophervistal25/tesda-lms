<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use Auth;
use App\ExamAttempt;
use App\ExamResult;

class FinalExamController extends Controller
{
    public function view(Module $module)
    {
    	$course = $module->course;
    	$exam = Module::with(['exams', 'exams.choices'])->find($module->id);
    	return view('student.examination.view', compact('exam', 'course', 'module'));
    }

    public function userAddAttempt($module)
    {
        $user = Auth::user();
        $user->exam_attempt()->save(new ExamAttempt());
        return redirect()->route('answer.final.exam', $module);
    }

    public function answer(Module $module)
    {
    	$course = $module->course;
    	$exam = Module::with(['exams', 'exams.choices'])->find($module->id)->exams;
    	$exam = collect($exam)->sortBy('question_no');

        if($exam->first()->result != null) {
            // Redirect to the result page.
            return redirect()->route('answer.final.exam.result', $module);
        }     

    	return view('student.examination.answer', compact('exam', 'course', 'module'));
    }

    public function submit(Request $request, Module $module)
    {
        // Check each answer of the student
        $questions = collect($module->exams)->sortBy('question_no');

        $studentAnswers = $request->except('_token');
        $correct = 0;
        $wrong   = 0;
        $results = [];
        foreach ($questions as $question) {
            foreach ($studentAnswers as $questionNo => $answer) {
                    if ('question_'. $question->question_no === $questionNo) {
                        $status = ($answer === $question->answer) ? 'correct' : 'wrong';
                            ExamResult::create([
                                'user_id' => Auth::user()->id,
                                'exam_id' => $question->id,
                                'answer'  => $answer,
                                'status'  => $status,
                            ]);
                    }
            }
        }

        return back();
    }

    public function result(Module $module)
    {
        $studentId = Auth::user()->id;
        $course    = $module->course;

        $exam = Module::with(['exams', 'exams.choices', 'exams.result' => function ($query) use($studentId) {
            $query->where('user_id', $studentId);
        }])->find($module->id)->exams;

        $exam = collect($exam)->sortBy('question_no');

        $marks = 0;

        $exam->each(function ($exam) use(&$marks) {
            if ($exam->result->status == 'correct') {
                $marks++;
            }
        });

        return view('student.examination.result', compact('course', 'exam', 'module', 'marks'));
    }
}
