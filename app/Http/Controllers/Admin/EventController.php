<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function events()
    {
        return Event::orderBy('start', 'ASC')->get(['id', 'title', 'description', 'start', 'end']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.event.index');
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
        $this->validate($request, [
            'title'       => 'required',
            'description' => 'required',
            'location'    => 'required',
            'start'       => 'required|before:end',
            'end'         => 'required|after:start'
        ]);

        $start =  Carbon::parse($request->date . ' ' . $request->start);
        $end   =  Carbon::parse($request->date . ' ' . $request->end);
        
        Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'start'       => $start,
            'end'         => $end
        ]);

        return response()->json(['success' => true]);
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
        if (request()->ajax()) {
            return Event::find($id);
        }
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
        $this->validate($request, [
            'title'       => 'required',
            'description' => 'required',
            'location'    => 'required',
            'start'       => 'required|before:end',
            'end'         => 'required|after:start'
        ]);

        $start =  Carbon::parse($request->date . ' ' . $request->start);
        $end   =  Carbon::parse($request->date . ' ' . $request->end);

        $event = Event::find($id);
        $event->title       = $request->title;
        $event->description = $request->description;
        $event->location    = $request->location;
        $event->start       = $start;
        $event->end         = $end;
        $event->save();

        return response()->json(['success' => true]);
    }

    public function reschedule(Request $request, $id)
    {
        $event   = Event::find($id);
        $event->start       = Carbon::parse($request->start);
        $event->end         = Carbon::parse($request->end);
        $event->save();
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
