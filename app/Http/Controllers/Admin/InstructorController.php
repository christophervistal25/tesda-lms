<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use App\Instructor;
use App\Course;

class InstructorController extends Controller
{

    public function list()
    {
        return Laratables::recordsOf(Instructor::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instructors = Instructor::with('courses')->get();
        $courses = Course::with(['program', 'program.batch'])->get();
        return view('admin.instructor.index', compact('instructors', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::with(['program', 'program.batch'])->get();
        return view('admin.instructor.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname'  => 'required|string',
            'middlename' => 'required|string',
            'lastname'   => 'required|string',
            'contact_no' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $image_name = $request->file('image')->getRealPath();
            \Cloudder::upload($image_name, null);
            $image = \Cloudder::show(\Cloudder::getPublicId());
        }

        $instructor = Instructor::create([
            'firstname'  => $request->firstname,
            'middlename' => $request->middlename,
            'lastname'   => $request->lastname,
            'contact_no' => $request->contact_no,
            'image'      => $image ?? '',
        ]);

        if ($request->course != null) {
            $course = Course::find($request->course);
            $course->instructors()->attach($instructor);
        }

        return back()->with('success', 'Successfully add new instructor.');
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
        $instructor = Instructor::with('courses')->find($id);
        return view('admin.instructor.edit', compact('instructor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instructor $instructor)
    {
        $this->validate($request, [
            'firstname'  => 'required|string',
            'middlename' => 'required|string',
            'lastname'   => 'required|string',
            'contact_no' => 'required',
        ]);
        
        if ($request->hasFile('image')) {
            $image_name = $request->file('image')->getRealPath();
            \Cloudder::upload($image_name, null);
            $image = \Cloudder::show(\Cloudder::getPublicId());
        }

        $instructor->firstname  = ucfirst($request->firstname);
        $instructor->middlename = ucfirst($request->middlename);
        $instructor->lastname   = ucfirst($request->lastname);
        $instructor->contact_no = $request->contact_no;
        $instructor->image      = $image ?? $instructor->image;
        $instructor->save();

        return back()->with('success', 'Successfully update information of ' . $instructor->lastname . ', ' . $instructor->firstname . ' ' . $instructor->middlename);

    }

    public function assignCourse(Request $request, Instructor $instructor)
    {
        $instructor->courses()->attach($request->course);
        return response()->json(['success' => true]);
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
