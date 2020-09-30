<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Overview;
use App\File as OverviewFile;
use Illuminate\Support\Str;

class CourseOverviewController extends Controller
{
        public function create(Course $course)
	{
		return view('admin.course.overview.create', compact('course'));
	}

 	public function store(Request $request, Course $course)
 	{

        	$overview = Overview::create([
        		'body' => $request->body,
        		'course_id' => $course->id
        	]);


                $URL_INDEX = 1;
                $url = preg_match_all('/<a href="(.+)">/', $request->body, $match);
                foreach ($match[$URL_INDEX] as $url) {
                    $urlChunks = explode('/', $url);
                	if (Str::contains($url, 'cloudinary')) {
                		OverviewFile::create([
                            'title' => end($urlChunks),
        	                'link' => $url,
        	                'overview_id' => $overview->id,
        	            ]);	
                	}
                    
                }


 		     return back()->with('success', 'Successfully add course overview for ' . $course->name);
 	    }

        public function edit(Course $course)
        {
                return view('admin.course.overview.edit', compact('course'));
        }

        public function update(Request $request, Course $course)
        {
           

            $overview = $course->overview;
            $overview->body = $request->body;
            $overview->save();
        
            // Remove all files of the overview
            $course->overview->files()->delete();
            $URL_INDEX = 1;
            $url = preg_match_all('/<a href="(.+)">/', $request->body, $match);

            foreach ($match[$URL_INDEX] as $url) {
                $urlChunks = explode('/', $url);
                    if (Str::contains($url, 'cloudinary')) {
                        OverviewFile::create([
                            'title' => end($urlChunks),
                            'link' => $url,
                            'overview_id' => $overview->id,
                    ]); 
                }
            }
           
           return back()->with('success', 'Succesfully update course overview of ' . $course->name);
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
