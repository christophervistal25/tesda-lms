<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\File as ModuleFile;
use Illuminate\Support\Str;
use App\Module;


class CourseOverviewController extends Controller
{

   public function create(Course $course)
	{
		return view('admin.course.overview.create', compact('course'));
	}

 	public function store(Request $request, Course $course)
 	{
        $module = Module::create([
            'title'       => $request->title,
            'body'        => $request->body,
            'course_id'   => $course->id,
            'is_overview' => 1,
        ]);

        $URL_INDEX   = 1;
        $TITLE_INDEX = 2;
        $BODY_INDEX  = 0;
        $ICON_INDEX  = 1;

        preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->body, $match);
        preg_match_all('/<img src=(.*)|<a href="(.+)">(.+)<\/a>/', $request->body, $images);
       
        $files = [];

        foreach ($match[$URL_INDEX] as $key => $file) {
           $type = Str::contains($file, ['https', 'http']) ? 'file' : 'page';
           preg_match( '@src="([^"]+)"@' , $images[0][$key], $iconSrc);
           $icon = isset($iconSrc[$ICON_INDEX])  ? $iconSrc[$ICON_INDEX] : null;

           $files[] = new ModuleFile([
                'title' => $match[$TITLE_INDEX][$key],
                'body'  => $match[$BODY_INDEX][$key],
                'link'  => $file,
                'type' =>  $type,
                'icon' => $icon,
            ]);
        }

        $module->files()->saveMany($files);

 		return back()->with('success', 'Successfully add course overview for ' . $course->name);
 	}

    public function edit(Course $course)
    {
        $overview = $course->modules->where('is_overview', 1)->first();
        return view('admin.course.overview.edit', compact('course', 'overview'));
    }

    public function update(Request $request, $id)
    {
        $module = Module::find($id);
        $module->title = $request->title;
        $module->body = $request->body;

        $URL_INDEX   = 1;
        $TITLE_INDEX = 2;
        $BODY_INDEX  = 0;
        $ICON_INDEX  = 1;

        preg_match_all('/<a href="(.+)">(.+)<\/a>/', $request->body, $match);
        preg_match_all('/<img src=(.*)|<a href="(.+)">(.+)<\/a>/', $request->body, $images);

        $files = [];

        $module->files()->delete();
        
        foreach ($match[$URL_INDEX] as $key => $file) {
           $type = Str::contains($file, ['https', 'http']) ? 'file' : 'page';
           preg_match( '@src="([^"]+)"@' , $images[0][$key], $iconSrc);
           $icon = isset($iconSrc[$ICON_INDEX])  ? $iconSrc[$ICON_INDEX] : null;

           $files[] = new ModuleFile([
                'title' => $match[$TITLE_INDEX][$key],
                'body'  => $match[$BODY_INDEX][$key],
                'link'  => $file,
                'type'  => $type,
                'icon'  => $icon,
            ]);
        }

        $module->files()->saveMany($files);

        $module->save();

       return back()->with('success', 'Succesfully update course overview');
    }

    public function show($course, $fileId = null)
    {
       $course = Course::find($course);

       if ($fileId != null) {
            $file = OverviewFile::find($fileId);
            $previousFile = OverviewFile::find(--$fileId);
            $nextFile = OverviewFile::find($fileId + 2);
            $firstActivity = $course->modules->first()->activities->first();
       }
       
       return view('admin.course.overview.show', compact('course', 'file', 'previousFile', 'nextFile', 'firstActivity'));
    }
}
