<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Module;
use App\Activity;
use App\File as ActivityFile;

class ModulesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.index');
    }


    public function create(Request $request, $course)
    {
        $course = Course::with('modules')->find($course);
        $moduleNo = $course->modules
                            ->where('is_overview', 0)
                            ->count() + 1;

        return view('admin.course.modules.create', compact('course', 'moduleNo'));
    }

    public function store(Request $request, Course $course)
    {
        $module = Module::create([
            'title'       => $request->title,
            'body'        => $request->body,
            'course_id'   => $course->id,
            'is_overview' => 0
        ]);

        $activities = [];
        if (isset($request->activity_no)) {
            foreach ($request->activity_no as $key => $no) {

                $activity = Activity::create([
                    'module_id'    => $module->id,
                    'activity_no'  => $no,
                    'title'        => $request->activity_name[$key],
                    'instructions' => $request->activity_instructions[$key],
                    'body'         => $request->activity_content[$key],
                    'downloadable' => 0,
                ]);

                $URL_INDEX   = 1;
                $TITLE_INDEX = 2;
                $BODY_INDEX  = 0;
                $url = preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->activity_content[$key], $match);
             
                $files = [];
                foreach ($match[$URL_INDEX] as $key => $file) {
                   $files[] = new ActivityFile([
                        'title' => $match[$TITLE_INDEX][$key],
                        'body'  => $match[$BODY_INDEX][$key],
                        'link'  => $file,
                        'type'  => 'page'
                    ]);
                }

                $activity->files()->saveMany($files);
            }
        }


        $activities = [];
        if (isset($request->downloadable_activity_no)) {
            foreach ($request->downloadable_activity_no as $key => $no) {

                $activity = Activity::create([
                    'module_id'    => $module->id,
                    'activity_no'  => $no,
                    'title'        => $request->downloadable_activity_name[$key],
                    'instructions' => $request->downloadable_activity_instructions[$key],
                    'body'         => $request->downloadable_activity_content[$key],
                    'downloadable' => 1,
                ]);

                $URL_INDEX   = 1;
                $TITLE_INDEX = 2;
                $BODY_INDEX  = 0;
                $url = preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->downloadable_activity_content[$key], $match);

                $files = [];
                foreach ($match[$URL_INDEX] as $key => $file) {
                   $files[] = new ActivityFile([
                        'title' => $match[$TITLE_INDEX][$key],
                        'body'  => $match[$BODY_INDEX][$key],
                        'link'  => $file,
                        'type'  => 'file',
                    ]);
                }

                $activity->files()->saveMany($files);
            }
        }


        
        return back()->with('success', 'Successfully add new module for ' . $course->name . ' course ');
    }

    public function view(Course $course)
    {
        $overview = $course->modules->where('is_overview', 1)->first();
        return view('admin.course.modules.view', compact('course', 'overview'));
    }

    public function edit($moduleId)
    {
        $module = Module::find($moduleId);
        // If there's no activity
        if (!$module->activities->last()) {
            $moduleNo = 1;
            $subCount = 0;
        } else {
            list($moduleNo, $subCount) = explode('.', $module->activities->last()->activity_no);    
        }
        
        return view('admin.course.modules.edit', compact('module', 'moduleNo', 'subCount'));
    }

    public function update(Request $request, Module $module)
    {
        $module->title = $request->title;
        $module->body = $request->body;
    

        if (isset($request->activity_no)) {
           
            foreach ($request->activity_no as $key => $no) {
                $activity = Activity::updateOrCreate(['activity_no' => $no], [
                    'module_id'    => $module->id,
                    'activity_no'  => $no,
                    'title'        => $request->activity_name[$key],
                    'instructions' => $request->activity_instructions[$key],
                    'body'         => $request->activity_content[$key],
                    'downloadable' => 0,
                ]);
                $files = [];
                $URL_INDEX   = 1;
                $TITLE_INDEX = 2;
                $BODY_INDEX  = 0;
                $url = preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->activity_content[$key], $match);
                foreach ($match[$URL_INDEX] as $key => $file) {
                   $files[] = ActivityFile::firstOrNew(
                    [
                        'title'          => $match[$TITLE_INDEX][$key],
                        'filelable_id'   => $activity->id,
                        'type'           => 'page',
                        'filelable_type' => get_class($activity)
                    ],
                    [
                        'title' => $match[$TITLE_INDEX][$key],
                        'body'  => $match[$BODY_INDEX][$key],
                        'link'  => $file,
                        'type'  => 'page',
                    ]);
                }
                
                $activity->files()->saveMany($files);
                $module->activities()->save($activity);
            }
        }

        $activity = null;

        if (isset($request->downloadable_activity_no)) {
              foreach ($request->downloadable_activity_no as $key => $no) {
                $activity = Activity::updateOrCreate(['activity_no' => $no], [
                    'module_id'    => $module->id,
                    'activity_no'  => $no,
                    'title'        => $request->downloadable_activity_name[$key],
                    'instructions' => $request->downloadable_activity_instructions[$key],
                    'body'         => $request->downloadable_activity_content[$key],
                    'downloadable' => 1,
                ]);


                    $URL_INDEX   = 1;
                    $TITLE_INDEX = 2;
                    $BODY_INDEX  = 0;
                    $url = preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->downloadable_activity_content[$key], $match);
                 
                    $files = [];
                    foreach ($match[$URL_INDEX] as $key => $file) {
                       $files[] = ActivityFile::firstOrCreate([
                            'title'          => $match[$TITLE_INDEX][$key],
                            'filelable_id'   => $activity->id,
                            'filelable_type' => get_class($activity),
                            ],
                            [
                            'title' => $match[$TITLE_INDEX][$key],
                            'body'  => $match[$BODY_INDEX][$key],
                            'link'  => $file,
                            'type'  => 'file',
                        ]);
                    }
                $activity->files()->saveMany($files);
                $module->activities()->save($activity);
            }
            
        }


        if (isset($request->completion_activity_no)) {
              foreach ($request->completion_activity_no as $key => $no) {
                $activity = Activity::updateOrCreate(['activity_no' => $no], [
                    'module_id'    => $module->id,
                    'activity_no'  => $no,
                    'title'        => $request->completion_activity_name[$key],
                    'instructions' => '',
                    'body'         => $request->completion_activity_content[$key],
                    'downloadable' => 0,
                    'completion'   => 1,
                ]);


                    $URL_INDEX   = 1;
                    $TITLE_INDEX = 2;
                    $BODY_INDEX  = 0;
                    $url = preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->completion_activity_content[$key], $match);
                    
                    $files = [];
                    foreach ($match[$URL_INDEX] as $key => $file) {
                       $files[] = ActivityFile::firstOrCreate([
                                'title'          => $match[$TITLE_INDEX][$key],
                                'filelable_id'   => $activity->id,
                                'filelable_type' => get_class($activity),
                            ],
                            [
                            'title' => $match[$TITLE_INDEX][$key],
                            'body'  => $match[$BODY_INDEX][$key],
                            'link'  => $file,
                            'type'  => 'file',
                        ]);
                    }
                $activity->files()->saveMany($files);
                $module->activities()->save($activity);
            }
            
        }

        return back()->with('success', 'Successfully update ' . $module->title . ' module.');
    }
    
}
