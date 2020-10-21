<?php
namespace App\Helpers;
use App\Exam;
use App\Question;
use App\Module;
use App\MultipleChoice;
use App\Activity;
use App\Course;
use Auth;

class ExamRepository
{

	private function createQuestions(array $questions = [], string $type = 'MULTIPLE')
	{
		$newQuestions = [];
		foreach ($questions as $q) {
			$newQuestions[] = new Question([
                'question_no' => $q['question_no'],
                'question'    => $q['question'],
                'answer'      => $q['correct_answer'],
                'type'        => $type,
            ]);
		}
		return $newQuestions;
	}

	/**
	 * This must be in the MultipleChoiceRepository
	 * Create when you refactor 
	 */
	private function createMultipleChoice(array $choices = [], array $questions = [])
	{
		foreach ($choices as $key => $choice) {
                $choice = preg_replace('/^\w-/', '', $choice);
                foreach ($questions as $question) {
                    $question->choices()->save(new MultipleChoice(['choice' => $choice]));    
                }
            }
	}
    
    private function pushToExam(array $questions = [], Exam $exam)
    {
    	return $exam->questions()->saveMany($questions);
    }

	public function insertMultipleChoice(array $questions = [], Exam $exam)
	{
		$createdQuestions = $this->createQuestions($questions, 'MULTIPLE');
		$this->pushToExam($createdQuestions, $exam);
		foreach ($questions as $question) {
			$this->createMultipleChoice($question['choices'], $createdQuestions);
		}
	}

	public function insertFillIn(array $questions = [], Exam $exam)
	{
		$createdQuestions = $this->createQuestions($questions, 'FITB');
		$this->pushToExam($createdQuestions, $exam);
	}

	public function insertTrueOrFalse(array $questions = [], Exam $exam)
	{
		 $createdQuestions = $this->createQuestions($questions, 'TORF');
		 $this->pushToExam($createdQuestions, $exam);
	}

	public function isUserCanTakeExam(Course $course) : bool
	{
		$overview = $course->modules->where('is_overview', 1)
                            ->first();

        $noOfOverviewFiles = $overview->files->count();
        $moduleIds = $course->modules->where('is_overview', 0)
                            ->pluck('id')
                            ->toArray();
        $noOfActivities = Activity::whereIn('module_id', $moduleIds)->where('completion', null)->count();


        $studentAccomplish = Auth::user()->accomplish_files->count();

        $studentActivitiesAccomplish = Auth::user()->accomplish_activities
                                            ->pluck('id')->count();
        $needToAccomplishForExam = $noOfOverviewFiles + $noOfActivities;
        $studentOverallAccomplish = $studentAccomplish + $studentActivitiesAccomplish;

        return $studentOverallAccomplish >= $needToAccomplishForExam;
	}


	public function getExam(Course $course)
	{
		foreach ($course->modules as $module) {
			if ($module->exam != null) {
				return $module;
			}
		}
		return null;
	}


}
