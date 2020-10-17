<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;
use Auth;
use App\ExamAttempt;
use App\ExamResult;
use App\Exam;
use App\Activity;
use App\Helpers\ExamRepository;

class FinalExamController extends Controller
{

    public function __construct(ExamRepository $examRepo)
    {
        $this->examRepository = $examRepo;
    }

    private function calculateHighestGrade($attempts)
    {
        $grades = [];
        
        if (!is_null($attempts->last()) && $attempts->last()->result->count() != 0) {
            foreach ($attempts as $e) {
                $grades[] = (100 / $e->result->count() ) *  $e->result->where('status', 'correct')->count();
            }
            rsort($grades);
            $highest = array_shift($grades);
            return $highest;
        } 
        
        return null;
    }

    private function checkUserIfPassedOrFail(int $no_of_questions, int $corrects) : bool
    {
        return ( ( 100 / $no_of_questions ) *  $corrects ) >= Exam::PASSING_GRADE;
    }

    private function checkAnswer(string $user_answer, string $question_answer) :bool
    {
        // Clean data
        $question_answer = preg_replace('/\s+/', '', strtolower($question_answer));
        $user_answer = preg_replace('/\s+/', '', strtolower($user_answer));
        return $question_answer === $user_answer;
    }

    public function view(Module $module)
    {
        $canTakeExam = false;
    	$course = $module->course;
        $student = Auth::user();
    	$exam = Module::with(['exam', 'exam.questions', 'exam.questions.choices'])->find($module->id);
        $highestGrade = $this->calculateHighestGrade($student->exam_attempt);

        $canTakeExam = $this->examRepository->isUserCanTakeExam($course);

        return view('student.examination.view', compact('exam', 'course', 'module', 'student', 'highestGrade', 'canTakeExam'));
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
        $module = Module::with(['exam', 'exam.questions', 'exam.questions.choices'])->find($module->id);
        $exam   = $module->exam;

        $questions   = collect($exam->questions)->sortBy('question_no');

        $attempt_id = Auth::user()->exam_attempt->last()->id;

    	return view('student.examination.answer', compact('questions', 'course', 'module', 'attempt_id'));
    }

    public function submit(Request $request, Module $module)
    {
        // Check each answer of the student
        $questions = collect($module->exam->questions)->sortBy('question_no');

        $student = Auth::user();
        $studentAnswers = $request->except('_token');
        $correct = 0;
        $wrong   = 0;
        $results = [];
       foreach ($questions as $question) {
            foreach ($studentAnswers as $questionNo => $answer) {
                    if ('question_'. $question->question_no === $questionNo) {
                        $status = $this->checkAnswer($answer, $question->answer) ? 'correct' : 'wrong';
                        ExamResult::create([
                            'user_id'         => $student->id,
                            'question_id'     => $question->id,
                            'exam_attempt_id' => $request->attempt_id,
                            'answer'          => $answer,
                            'status'          => $status,
                        ]);

                        if ($status === 'correct') {
                            $correct++;
                        } else {
                            $wrong++;
                        }
                    }
            }
            
        }

        $examAttempt = ExamAttempt::find($request->attempt_id);
        if ($this->checkUserIfPassedOrFail($questions->count(), $correct) == 'passed') {
            $examAttempt->status = 'passed';
            $student->accomplish_exam()->attach($module->exam);
        } else {
            $examAttempt->status = 'failed';
        }
        $examAttempt->save(); 
        
        return redirect()->route('answer.final.exam.result', [$module, $request->attempt_id]);
    }

    public function result(Module $module, $attempt)
    {
        $studentId = Auth::user()->id;
        $course    = $module->course;

        $module = Module::with(['exam', 'exam.questions','exam.questions.choices', 'exam.questions.result' => function ($query) use($studentId, $attempt) {
            $query->where('user_id', $studentId)->where('exam_attempt_id', $attempt);
        }])->find($module->id);

        $questions = collect($module->exam->questions)->sortBy('question_no');

        $marks = 0;

        $questions->each(function ($question) use(&$mark) {
            if ($question->result->status === 'correct') {
                $mark++;
            }
        });

        return view('student.examination.result', compact('course', 'questions', 'module', 'marks'));
    }
}
