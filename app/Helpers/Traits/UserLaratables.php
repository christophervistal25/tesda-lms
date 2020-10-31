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
		return $student->courses->last()->course->acronym ?? '';
	}

	public static function laratablesProfile($student)
    {
    	$src = (\Str::contains($student->profile , ['http', 'https'])) ? $student->profile : asset('student_image/' . $student->profile);
        return "<img src='$src' width='24px' />";
    }
}