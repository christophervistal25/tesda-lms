<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateModuleRequest;
use App\Helpers\ActivityFileHelper;
use App\Helpers\ExamRepository;
use App\File as ActivityFile;
use App\Course;
use App\Module;
use App\Exam;
use App\Activity;
use App\Icon;


class ModulesController extends Controller
{

    public function __construct(ActivityFileHelper $activityFile, ExamRepository $examRepo)
    {
        $this->activityFile = $activityFile;
        $this->examRepository = $examRepo;
    }

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
        $canAddCompletion = false;
        $course = Course::with('modules')->find($course);
        $moduleNo = $course->modules
                            ->where('is_overview', 0)
                            ->count() + 1;
        
        // Check if the admin can add completion activity.
        if (Exam::whereIn('module_id', $course->modules->where('is_overview', '!=', 1)->pluck('id'))->exists()) {
            $canAddCompletion = true;
        }

        $fileIcons = Icon::get(['path'])->pluck('path')->toArray();


        return view('admin.course.modules.create', compact('course', 'moduleNo', 'canAddCompletion', 'fileIcons'));
    }

    public function store(CreateModuleRequest $request, Course $course)
    {
        $URL_INDEX   = 1;
        $TITLE_INDEX = 2;
        $BODY_INDEX  = 0;

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
                    'icon'         => $request->activity_icon[$key],
                    'downloadable' => 0,
                ]);

               
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
                    'icon'         => $request->downloadable_activity_icon[$key],
                    'downloadable' => 1,
                ]);

              
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

        if (isset($request->completion_activity_no)) {
              foreach ($request->completion_activity_no as $key => $no) {
                $activity = Activity::updateOrCreate(['activity_no' => $no], [
                    'module_id'    => $module->id,
                    'activity_no'  => $no,
                    'title'        => $request->completion_activity_name[$key],
                    'instructions' => '',
                    'body'         => $request->completion_activity_content[$key],
                    'icon'         => $request->completion_activity_icon[$key],
                    'downloadable' => 0,
                    'completion'   => 1,
                ]);


                $url = preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->completion_activity_content[$key], $files);
                if ( !$this->activityFile->same($files[$URL_INDEX], $activity->files) ) {
                    if ( $this->activityFile->hasNew($files[$URL_INDEX], $activity->files) ) {
                        $this->activityFile->add($activity, $files);
                        $module->activities()->save($activity);
                    } else {
                        $this->activityFile->remove($activity, $files);
                    }    
                }    
            }
        }

        return back()->with('success', 'Successfully add new module for ' . $course->name . ' course ')
                        ->with('module_id', $module->id);
    }

    public function view(Course $course)
    {
        $overview = $course->modules->where('is_overview', 1)->first();
        $overview->body = str_replace('href="/student/', 'href="/admin/', $overview->body);
        return view('admin.course.modules.view', compact('course', 'overview'));
    }

    public function edit($moduleId)
    {
        $canAddCompletion = false;
        $module = Module::find($moduleId);
        // If there's no activity
        if (!$module->activities->last()) {
            $moduleNo = 1;
            $subCount = 0;
        } else {
            list($moduleNo, $subCount) = explode('.', $module->activities->last()->activity_no);    
        }
        
        // Check if the admin can add completion activity.
        if (Exam::whereIn('module_id', $module->course->modules->where('is_overview', '!=', 1)->pluck('id'))->exists()) {
            $canAddCompletion = true;
        }

        $fileIcons = Icon::get(['path'])
                          ->pluck('path')
                          ->toArray();

        $hasExam = !is_null($this->examRepository->getExam($module->course));
        

        return view('admin.course.modules.edit', compact('module', 'moduleNo', 'subCount', 'canAddCompletion', 'fileIcons', 'hasExam'));
    }

    public function update(CreateModuleRequest $request, Module $module)
    {
        $URL_INDEX   = 1;


        $module->title = $request->title;
        $module->body = $request->body;
        $module->save();

        if (isset($request->activity_no)) {
            
            foreach ($request->activity_no as $key => $no) {
                $activity = Activity::updateOrCreate(['activity_no' => $no], [
                    'module_id'    => $module->id,
                    'activity_no'  => $no,
                    'title'        => $request->activity_name[$key],
                    'instructions' => $request->activity_instructions[$key],
                    'body'         => $request->activity_content[$key],
                    'icon'         => $request->activity_icon[$key],
                    'downloadable' => 0,
                ]);

                $url = preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->activity_content[$key], $files);

                if ( !$this->activityFile->same($files[$URL_INDEX], $activity->files) ) {
                    if ( $this->activityFile->hasNew($files[$URL_INDEX], $activity->files) ) {
                        $this->activityFile->add($activity, $files);
                        $module->activities()->save($activity);
                    } else {
                        $this->activityFile->remove($activity, $files);
                    }    
                }

            }

        }


        if (isset($request->downloadable_activity_no)) {
              foreach ($request->downloadable_activity_no as $key => $no) {
                    $activity = Activity::updateOrCreate(['activity_no' => $no], [
                        'module_id'    => $module->id,
                        'activity_no'  => $no,
                        'title'        => $request->downloadable_activity_name[$key],
                        'instructions' => $request->downloadable_activity_instructions[$key],
                        'body'         => $request->downloadable_activity_content[$key],
                        'icon'         => $request->downloadable_activity_icon[$key],
                        'downloadable' => 1,
                    ]);


                    $url = preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->downloadable_activity_content[$key], $files);

                    if ( !$this->activityFile->same($files[$URL_INDEX], $activity->files) ) {
                        if ( $this->activityFile->hasNew($files[$URL_INDEX], $activity->files) ) {
                            $this->activityFile->add($activity, $files);
                            $module->activities()->save($activity);
                        } else {
                            $this->activityFile->remove($activity, $files);
                        }    
                    }
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
                    'icon'         => $request->completion_activity_icon[$key],
                    'downloadable' => 0,
                    'completion'   => 1,
                ]);


                $url = preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->completion_activity_content[$key], $files);
                if ( !$this->activityFile->same($files[$URL_INDEX], $activity->files) ) {
                    if ( $this->activityFile->hasNew($files[$URL_INDEX], $activity->files) ) {
                        $this->activityFile->add($activity, $files);
                        $module->activities()->save($activity);
                    } else {
                        $this->activityFile->remove($activity, $files);
                    }    
                }    
            }
        }

        return back()->with('success', 'Successfully update ' . $module->title . ' module');
    }
    
}
