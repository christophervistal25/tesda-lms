<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Activity;
use App\Overview;

class ActivityController extends Controller
{
    public function addFile(Request $request)
    {
    	$destination =  public_path() . '/' .$request->file('file')->getClientOriginalName();
        move_uploaded_file($request->file('file'), $destination);

    	$result = \Cloudinary::config(array( 
              'cloud_name' => config('cloudder.cloudName'), 
              'api_key'    => config('cloudder.apiKey'), 
              'api_secret' => config('cloudder.apiSecret'), 
              'secure'     => true
        ));

        $uploaded = \Cloudinary\Uploader::upload($destination, [
            'use_filename'    => true,
            'unique_filename' => false,
            'resource_type'   => 'auto'
        ]);

        \File::delete($destination);
        
        $path = $request->file('file')->getClientOriginalName();
		    $ext = pathinfo($path, PATHINFO_EXTENSION);

        return response()->json([ 'link' => $uploaded['url'] , 'extension' => $ext]);
    }

    public function view($activity_id)
    {
        $activity = Activity::with('modules', 'modules.course')->find($activity_id);
        $course = $activity->modules->first()->course;

        $nextActivity = $this->getActivityNext($activity->activity_no);
        $previousActivity = $this->getActivityPrevious($activity->activity_no);
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
