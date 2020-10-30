<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use App\User as Student;

class StudentController extends Controller
{

    public function list()
    {
        return Laratables::recordsOf(Student::class, function ($query) {
            return $query->with('courses');
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('courses')->get();
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::find($id);
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        
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

        return back()->with('success', 'Successfully update ' . $request->name . ' profile.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
