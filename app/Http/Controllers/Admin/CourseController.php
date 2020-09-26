<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Batch;
use App\Program;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with(['program', 'program.batch', 'instructors'])
                        ->where('active', 1)
                        ->orderBy('created_at', 'DESC')
                        ->get();

        return view('admin.course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $batchs = Batch::orderBy('batch_no', 'ASC')->get();
        $programs = Program::where('active', 1)->get();
        return view('admin.course.create', compact('batchs', 'programs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $batch_ids = Batch::get(['id'])
                    ->pluck(['id'])
                    ->toArray();

        $this->validate($request, [
            'name'        => 'required',
            'description' => 'required',
            'program'     => 'required'
        ]);

        $program = Program::find($request->program);
        $course = new Course;
        $course->name = $request->name;
        $course->description = $request->description;
        $course->program()->associate($program);
        $course->save();

        return back()->with('success', 'Successfully create new course with name ' . $request->name );

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
    public function edit(Course $course)
    {
        $batchs = Batch::orderBy('batch_no', 'ASC')->get();
        $programs = Program::where('active', 1)->get();
        return view('admin.course.edit', compact('course', 'batchs', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
       $batch_ids = Batch::get(['id'])
                    ->pluck(['id'])
                    ->toArray();

        $this->validate($request, [
            'name'        => 'required',
            'description' => 'required',
            'program'     => 'required',
        ]);

        $program             = Program::find($request->program);
        $course->name        = $request->name;
        $course->description = $request->description;
        $course->program()->associate($program);
        $course->save();

        return back()->with('success', 'Successfully update record');
    }

    public function hide(Request $request, int $id)
    {
        if ($request->ajax()) {
            // Hide the record
            $course = Course::find($id);
            $course->active = 0;
            $course->save();

            return response()->json(['success' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
