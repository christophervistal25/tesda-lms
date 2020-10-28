<?php
namespace App\Helpers\Traits;
use App\Repositories\StudentRepository;

trait UserLaratables
{
	public static function laratablesSearchName($query, $searchValue)
	{
	    return $query->orWhere('name', 'like', '%'. $searchValue. '%')
	    		->orWhere('username', 'like', '%'. $searchValue. '%')
	    		->orWhere('email', 'like', '%'. $searchValue. '%')
	    		->orWhere('country', 'like', '%'. $searchValue. '%')
	    		->orWhere('city_town', 'like', '%'. $searchValue. '%');
	}

	public static function laratablesCustomProgress($student)
	{
		return view('admin.students.includes.actions', compact('student'))->render();
	}

	public static function laratablesCustomModule($student)
	{
		return view('admin.students.includes.view', compact('student'))->render();
	}

	public static function laratablesCustomCourse($student)
	{
		return $student->courses->last()->course->acronym ?? null;
	}

	public static function laratablesProfile($student)
    {
        return "<img src='$student->profile' width='24px' />";
    }
}