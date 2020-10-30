<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\{StudentRepository, BadgeRepository};
use Auth;

class BadgeController extends Controller
{
	public function __construct(StudentRepository $studentRepo)
	{
		$this->studentRepository = $studentRepo;

	}

    public function index()
    {
        $student    = Auth::user();
        $userBadges = $this->studentRepository->hasBadge(new BadgeRepository(), $student);
        $course     = $this->studentRepository->getCourse();
    	return view('student.badge.index', compact('course', 'userBadges'));
    }
}
