<?php
namespace App\Repositories;
use Auth;
use App\Repositories\CourseRepository;
use App\Course;

class StudentRepository extends CourseRepository
{

	public function hasCourse() : bool
	{
		$student = Auth::user();
		return $student->courses->count() >= 1;
	}

	/**
	 *  Get the current course of the user.
	 */
	public function getCourse()
	{
		if ($this->hasCourse()) {
			return Auth::user()->courses->last()->course;
		}
	}

	/**
	 * Get all courses of the student with previous course.
	 */
	public function getCourses()
	{
		if ($this->hasCourse()) {
			return Auth::user()->courses;
		}
	}


	/**
	 * Get the progress of the user to all activities to course that enrolled.
	 */
	public function getProgress() :int
	{
		if ($this->hasCourse()) {
			$noOfACtivities = $this->getNoOfActivities($this->getCourse());

			if ($noOfACtivities != 0) {
				return $this->accomplish() * (config('student_progress.max_percentage') / $this->getNoOfActivities($this->getCourse()));
			}

			return 0;
		 	
		}
		return 0;
	}

	/**
	 * Calculate the number of the student accomplish
	 */
	private function accomplish() :int
	{
		$student = Auth::user();
		return $student->accomplish_files()->count() + $student->accomplish_activities->count();
	}


	public function hasBadge(BadgeRepository $badge)
	{
		$course       = $this->getCourse();
		$student      = Auth::user();
		return $badge->getBadgeAccomplish($student, $course);
	}
}