<?php

namespace App\Http\Controllers\Student;

use App\Activity;
use App\File;
use App\Http\Controllers\Controller;
use App\StudentAccomplish;
use App\StudentActivityLog;
use Auth;
use Illuminate\Http\Request;

class AccomplishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {
            $student = Auth::user();
            $file = File::find($request->file_id);
            $student->accomplish_files()->attach($file);
            StudentActivityLog::create([
                'user_id'      => $student->id,
                'perform' => 'accomplish the  ' . $file->title,
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
        }
    }


    public function activity(Request $request)
    {
        try {
            $student = Auth::user();
            $file = Activity::find($request->activity_id);
             StudentActivityLog::firstOrCreate([
                'user_id'      => $student->id,
                'perform' => 'accomplish the  ' . $file->title,
            ]);
            $student->accomplish_activities()->attach($file);    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
        }   
        
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Auth::user();
        $student->accomplish_files()->detach($id);
        return response()->json(['success' => true]);
    }
}
