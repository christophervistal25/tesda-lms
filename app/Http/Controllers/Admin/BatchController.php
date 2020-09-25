<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use App\Batch;

class BatchController extends Controller
{
    public function list()
    {
        return Laratables::recordsOf(Batch::class, function($query) {
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
        $batchs = Batch::orderBy('batch_no', 'ASC')
                        ->get();
        return view('admin.batch.index', compact('batchs'));
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
        if ($request->ajax()) {
            // Add validation.
            $this->validate($request, [
                'name' => 'required',
                'batch_number' => 'required|integer',
            ]);

            Batch::create([
                'name' => $request->name,
                'batch_no' => $request->batch_number,
            ]);
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
        if ($request->ajax()) {
            $batch = Batch::find($id);
            $batch->name = $request->name;
            $batch->batch_no = $request->batch_number;
            $batch->save();

            return response()->json(['success' => true]);
        }
    }

    public function hide(int $id)
    {
        if (request()->ajax()) {
            $batch = Batch::find($id);
            $batch->active = 0;
            $batch->save();
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
