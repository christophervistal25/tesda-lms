<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Batch;
use App\Program;
use App\Instructor;
use App\Prerequisite;




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
        $batchs      = Batch::orderBy('batch_no', 'ASC')->get();
        $programs    = Program::where('active', 1)->get();
        $courses     = Course::get();
        $instructors = Instructor::get();
        return view('admin.course.create', compact('batchs', 'programs', 'instructors', 'courses'));
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

        if ($request->hasFile('image')) {
            $image_name = $request->file('image')->getRealPath();
            \Cloudder::upload($image_name, null);
            $image = \Cloudder::show(\Cloudder::getPublicId());
        }

        $program = Program::find($request->program);
        $course = new Course;
        $course->name = $request->name;
        $course->acronym = $request->acronym;
        $course->design = $request->design;
        $course->description = $request->description;
        $course->duration = $request->duration;
        $course->image =  $image ?? '';
        $course->program()->associate($program);
        $course->save();

        if ($request->instructor != null) {
            $course->instructors()->attach($request->instructor);
        }

        if ($request->pre_requisites != null) {
            foreach (array_filter($request->pre_requisites) as $id) {
                Prerequisite::create(['course_id' => $id]);
            }

           $course->prerequisites()->attach(array_filter($request->pre_requisites));
        }
        
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
        $batchs      = Batch::orderBy('batch_no', 'ASC')->get();
        $programs    = Program::where('active', 1)->get();
        $courses     = Course::get()->except($course->id);
        $instructors = Instructor::get();

        return view('admin.course.edit', compact('course', 'batchs', 'programs', 'courses', 'instructors'));
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

        if ($request->hasFile('image')) {
            $image_name = $request->file('image')->getRealPath();
            \Cloudder::upload($image_name, null);
            $image = \Cloudder::show(\Cloudder::getPublicId());
        }

        $program             = Program::find($request->program);
        $course->name        = $request->name;
        $course->acronym     = $request->acronym;
        $course->description = $request->description;
        $course->design      = $request->design;
        $course->duration    = $request->duration;
        $course->image       = $image ?? $course->image;
        $course->program()->associate($program);
        $course->save();

        if ($request->instructor != null) {
            // Remove all the relation instructors first then add the new.
            $course->instructors()->detach();
            $course->instructors()->attach($request->instructor);
        }

        if ($request->pre_requisites != null) {
            // Remove all the relation pre-requisites first then add the new.
            $course->prerequisites()->detach();

            foreach (array_filter($request->pre_requisites) as $id) {
                Prerequisite::create(['course_id' => $id]);
            }

           $course->prerequisites()->attach(array_filter($request->pre_requisites));
        }

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

   
    public function design(Course $course, bool $forceview = false)
    {
        $variables = ['course', 'forceview'];

        $courseModuleFirstActivity = $course->modules->first()->activities->where('activity_no', '1.1')->first();
        
        if ($forceview) {
            $firstFile = $course->overview->files->first();
            $variables[] = 'firstFile';
        }

        
        return view('admin.course.design', compact($variables, 'courseModuleFirstActivity'));
    }
}
