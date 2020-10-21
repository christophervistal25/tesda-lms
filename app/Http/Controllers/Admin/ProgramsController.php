<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use App\Program;
use App\Batch;

class ProgramsController extends Controller
{
    public function list()
    {
        return Laratables::recordsOf(Program::class, function($query) {
            return $query->where('active', 1);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batchs = Batch::orderBy('batch_no', 'ASC')->where('active', 1)->get();
        return view('admin.programs.index', compact('batchs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $batchs = Batch::get(['id'])->pluck('id')->toArray();
            $this->validate($request, [
                'program_name' => 'required',
                'batch'        => 'in:' . implode(',', $batchs)
            ]);

            $batch   = Batch::find($request->batch_no);
            $program = new Program();

            $program->name = $request->program_name;
            $program->batch()->associate($batch);

            $program->save();


            return response()->json(['success' => true]);
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
    public function update(Request $request, Program $program)
    {
        if ($request->ajax()) {
            $batchs = Batch::get(['id'])->pluck('id')->toArray();

            $this->validate($request, [
                'name'  => 'required',
                'batch' => 'in:' . implode(',', $batchs)
            ]);


            $batch   = Batch::find($request->batch_no);

            $program->name = $request->name;
            $program->batch()->associate($batch);
            
            $program->save();

            return response()->json(['success' => true]);
        }
    }

    public function hide(int $id)
    {
        if (request()->ajax()) {
            $program = Program::find($id);
            $program->active = 0;
            $program->save();
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
        //
    }
}
