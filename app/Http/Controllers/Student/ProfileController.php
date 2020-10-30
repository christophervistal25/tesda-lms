<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User as Student;
use Auth;
use App\Repositories\{StudentRepository, BadgeRepository};
use Illuminate\Database\Eloquent\Collection;

class ProfileController extends Controller
{

	public function __construct(StudentRepository $studentRepo)
	{
		$this->studentRepository = $studentRepo;
	}

	public function show()
	{
    	$student = Auth::user();
        $this->studentRepository->setStudent($student);
        if ($this->studentRepository->hasCourse()) {
        	$userBadges  = $this->studentRepository->hasBadge(new BadgeRepository(), $student);
        }

        
		$progress       = $this->studentRepository->getProgress();
		$studentCourses = $this->studentRepository->getCourses() ?? new Collection();
		$currentCourse  = $this->studentRepository->getCourse();
        
    	return view('student.profile.show', compact('student', 'progress', 'studentCourses', 'currentCourse', 'userBadges'));
	}

    public function edit()
    {
    	$student = Auth::user();
    	return view('student.profile.edit', compact('student'));
    }

    public function update(Request $request)
    {
    	$student = Auth::user();

		$this->validate($request, [
			'username'  => 'required|unique:users,username,' . $student->id,
			'email'     => 'required|unique:users,email,' . $student->id,
			'firstname' => 'required',
			'surname'   => 'required',
			'city_town' => 'required',
			'password' => 'confirmed',
    	]);

    	if ($request->file('profile')) {
    		$extensions = ['jpg', 'jpe', 'jpeg', 'jfif', 'png', 'bmp', 'dib', 'gif'];
	    	$imageType = $request->file('profile')->getClientOriginalExtension();
	    	if (!in_array($imageType, $extensions)) {
	    		return back()->withErrors(['Please check the profile that you attach.']);	
	    	}

			$destination =  public_path() . '/student_image/' . $request->file('profile')->getClientOriginalName();
			move_uploaded_file($request->file('profile'), $destination);
			$image       = $request->file('profile')->getClientOriginalName();
        }

		$student->username  = $request->username;
		$student->email     = $request->email;
		$student->firstname = $request->firstname;
		$student->surname   = $request->surname;
		$student->name      = $request->firstname . ' ' . $request->surname;
		$student->city_town = $request->city_town;
		$student->password  = is_null($request->password) ? $student->password : bcrypt($request->password);
		$student->profile   = $image ?? $student->profile;
		$student->save();

		return back()->with('success', 'Successfully update your profile.');
    }
}
