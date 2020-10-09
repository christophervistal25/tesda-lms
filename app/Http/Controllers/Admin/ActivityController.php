<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Activity;


class ActivityController extends Controller
{
    public function view($activity_id)
    {
        $activity = Activity::with('modules', 'modules.course')->find($activity_id);
        $course = $activity->modules->first()->course;

        $nextActivity             = $this->getActivityNext($activity->activity_no);
        $previousActivity         = $this->getActivityPrevious($activity->activity_no);
        $lastPageOfCourseOverview = $course->overview->files->last();
        

        return view('admin.activity.view', compact('activity', 'course', 'nextActivity', 'previousActivity', 'lastPageOfCourseOverview'));
    }

    private function getActivityNext($activity_no)
    {
            $next =  Activity::where('activity_no',
                $this->activityDeterminer($activity_no, 'next')
            )->first();

        if (is_null($next)) {
            // proceed to next module.
            list($moduleNo, $subCount) = explode('.', $activity_no);
            $moduleNo++;
            $next = Activity::where('activity_no', 'like', $moduleNo . '%')->get()->first();
            return $next;
        } 
        return $next;
    }


    private function getActivityPrevious($activity_no)
    {
        $prev =  Activity::where('activity_no', 
            $this->activityDeterminer($activity_no, 'prev')
        )->first();

        if (is_null($prev)) {
            // proceed to previous module.
            list($moduleNo, $subCount) = explode('.', $activity_no);
            $moduleNo--;
            $prev =  Activity::where('activity_no', 'like', $moduleNo . '%')->get()->last();
            return $prev;
        }

        return $prev;
    }

    private function activityDeterminer($activity_no, string $type)
    {
        list($moduleNo, $subCount) = explode('.', $activity_no);
        ($type  == 'prev') ? $subCount-- : $subCount++;
        return $moduleNo . '.' . $subCount;
    }
}
