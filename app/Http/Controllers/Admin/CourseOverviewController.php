<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\File as ModuleFile;
use Illuminate\Support\Str;
use App\Module;
use App\File as OverviewFile;
use App\Helpers\OverviewViewer;
use App\Helpers\ExamRepository;
use Illuminate\Support\Collection;


class CourseOverviewController extends Controller
{

  public function __construct(ExamRepository $examRepo, OverviewViewer $viewer)
  {
    $this->examRepository = $examRepo;
    $this->viewer = $viewer;
  }

  public function create(Course $course)
	{
    $overview = $course->modules->where('is_overview', 1)->first();
		return view('admin.course.overview.create', compact('course', 'overview'));
	}

 	public function store(Request $request, Course $course)
 	{
        $this->validate($request, [
          'title' => 'required',
          'body'  => 'required',
        ]);

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
          $type = Str::contains($file, ['.doc', '.docx', '.txt', '.ppt', '.pptx', '.pdf']) ? 'file' : 'page';
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
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required',
        ]);


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
        
        foreach ($match[$URL_INDEX] as $key => $file) {
           $type = Str::contains($file, ['.doc', '.docx', '.txt', '.ppt', '.pptx', '.pdf']) ? 'file' : 'page';
           preg_match( '@src="([^"]+)"@' , $images[0][$key], $iconSrc);
           $icon = isset($iconSrc[$ICON_INDEX])  ? $iconSrc[$ICON_INDEX] : null;

           $files[] = ModuleFile::updateOrCreate([
                  'link'           => $file,
                  'filelable_id'   => $module->id,
                  'filelable_type' => get_class($module),
                ], [
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

       $course = Course::with('modules')->find($course);
       $this->viewer->process([
          'course'  => $course,
          'file_id' => $fileId,
       ]);

       $file = OverviewFile::find($fileId);
       
       $next     = $this->viewer->getNext();
       $previous = $this->viewer->getPrevious();


       $files = $course->modules->where('is_overview', 1)->first()->files ?? null;
 
       $modules = $course->modules->where('is_overview', 0);
       
       $moduleWithExam = $this->examRepository->getExam($course);
       
       return view('admin.course.overview.show', compact('course', 'next', 'previous', 'file', 'files', 'modules', 'fileId', 'moduleWithExam'));
    }
}
