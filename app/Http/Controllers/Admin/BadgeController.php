<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Module;
use App\Badge;
use App\Activity;
use App\File;

class BadgeController extends Controller
{
    public function create(Request $request, Course $course)
    {
    	return view('admin.course.badge.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
    	$criterias = json_decode($request->criteria);

    	$badge = Badge::create([
			'course_id'   => $course->id,
			'name'        => $request->badge_name,
			'description' => $request->badge_description,
			'image'		  => 'test.jpg',
    	]);

    	foreach ($criterias as $criteria) {
    		if ($criteria->type === 'activity') {
    			 $activity = Activity::find($criteria->id);
    			 $activity->badges()->save($badge);
    		} else if ($criteria->type === 'file') {
    			$file = File::find($criteria->id);
    			$file->badges()->save($badge);
    		}
    	}

    	return back()->with('success', 'Successfully add new badge for course ' . $course->name);

    }
}
