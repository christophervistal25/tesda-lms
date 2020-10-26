<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Module;
use App\Badge;
use App\Activity;
use App\File;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\BadgeRepository;
use App\Http\Requests\CreateBadgeRequest;

class CourseBadgeController extends Controller
{

	public function __construct(BadgeRepository $badgeRepo)
	{
		$this->badgeRepository = $badgeRepo;
	}

    public function create(Request $request, Course $course)
    {
    	return view('admin.course.badge.create', compact('course', 'files', 'activities'));
    }

    public function store(CreateBadgeRequest $request, Course $course)
    {
    	$criterias = json_decode($request->criteria);
        if ($request->file('badge_image')) {
            // store the image in public directory
            $destination =  public_path() . '/badges/' . $request->file('badge_image')->getClientOriginalName();
            move_uploaded_file($request->file('badge_image'), $destination);
            $image       = $request->file('badge_image')->getClientOriginalName();
        }

    	$badge = Badge::create([
			'course_id'   => $course->id,
			'name'        => $request->badge_name,
			'description' => $request->badge_description,
			'image'		  => $image ?? 'default_badge.png',
    	]);

        $modules    = $this->badgeRepository->collect($criterias, 'module');
        $activities = $this->badgeRepository->collect($criterias, 'activity');

        $this->badgeRepository->insertCreterias([
            'modules'    => $modules,
            'activities' => $activities,
            'criterias'  => $criterias,
            'badge'      => $badge,
        ]);
           
    	return back()->with('success', 'Successfully add new badge for course ' . $course->name);
    }

    public function show(Course $course)
    {
    	return view('admin.course.badge.show', compact('course'));
    }

    public function edit(Course $course, Badge $badge)
    {
        $badge_modules    = $badge->modules->pluck('id')->toArray();
        $badge_activities = $badge->activities->pluck('id')->toArray();
        $badge_files      = $badge->files->pluck('id')->toArray();
        $criterias        = collect();

        foreach ($badge->modules as $module) {
            $criterias->push(json_decode(json_encode(['id' => $module->id , 'title' => $module->title, 'type' => ($module->is_overview ===1) ? 'overview' : 'module'])));
        }

        foreach ($badge->activities as $key => $activity) {
            $criterias->push(json_decode(json_encode(['id' => $activity->id , 'title' => $activity->title, 'type' => 'activity'])));
        }

        foreach ($badge->files as $key => $file) {
            $criterias->push(json_decode(json_encode(['id' => $file->id , 'title' => $file->title, 'type' => 'file'])));
        }

    	return view('admin.course.badge.edit', compact('course', 'badge', 'badge_modules', 'badge_files', 'badge_activities', 'criterias'));
    }

    public function update(CreateBadgeRequest $request, $courseId, $badgeId)
    {
        $badge = Badge::find($badgeId);

        $criterias = json_decode($request->criteria);
        if ($request->file('badge_image')) {
            // store the image in public directory
            $destination =  public_path() . '/badges/' . $request->file('badge_image')->getClientOriginalName();
            move_uploaded_file($request->file('badge_image'), $destination);
            $image       = $request->file('badge_image')->getClientOriginalName();
        }

        $badge->name = $request->badge_name;
        $badge->description = $request->badge_description;
        $badge->image = $image ?? 'default_badge.png';
        $badge->save();

        $modules    = $this->badgeRepository->collect($criterias, 'module');
        $activities = $this->badgeRepository->collect($criterias, 'activity');

        $this->badgeRepository->updateCriterias([
            'modules'    => $modules,
            'activities' => $activities,
            'criterias'  => $criterias,
            'badge'      => $badge,
        ]);

        return back()->with('success', 'Successfully update ' . $badge->name . ' badge');

    }
}
