<?php
namespace App\Repositories;
use Auth;
use App\Repositories\CourseRepository;
use App\Course;
use App\User as Student;

class StudentRepository extends CourseRepository
{
	private $student;

	public function setStudent(Student $student)
	{
		$this->student = $student;
	}

	public function hasCourse() : bool
	{
		$student = $this->student ?? Auth::user();
		 return $student->courses->count() >= 1;		
	}

	/**
	 *  Get the current course of the user.
	 */
	public function getCourse()
	{
		$student = $this->student ?? Auth::user();
		if ($this->hasCourse()) {
			return $student->courses->last()->course;
		}
	}

	/**
	 * Get all courses of the student with previous course.
	 */
	public function getCourses()
	{
		if ($this->hasCourse()) {
			return $this->student->courses;
		}
	}


	/**
	 * Get the progress of the user to all activities to course that enrolled.
	 */
	public function getProgress() :int
	{
		if ($this->hasCourse()) {
			$course = $this->getCourse();
			$noOfACtivities = $this->getNoOfActivities($course);

			if ($noOfACtivities != 0) {
				return $this->accomplish() * (config('student_progress.max_percentage') / $this->getNoOfActivities($course));
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
		$student = $this->student;
		return $student->accomplish_files()->count() + $student->accomplish_activities->count();
	}


	public function hasBadge(BadgeRepository $badge, Student $student)
	{
		$course  = $this->getCourse();
		return $badge->getBadgeAccomplish($student, $course);
	}
}