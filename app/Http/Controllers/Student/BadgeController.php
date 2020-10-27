<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\{StudentRepository, BadgeRepository};

class BadgeController extends Controller
{
	public function __construct(StudentRepository $studentRepo)
	{
		$this->studentRepository = $studentRepo;

	}

    public function index()
    {
    	$userBadges = $this->studentRepository->hasBadge(new BadgeRepository());
    	$course = $this->studentRepository->getCourse();
    	return view('student.badge.index', compact('course', 'userBadges'));
    }
}
