<?php
namespace App\Helpers;
use App\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use App\File;
use App\Activity;
use App\Post;
use App\Exam;

class ActivityViewer
{
    private $next;
    private $previous;

    private function processOverview(array $data)
    {
    	$overview = $data['course']->modules->where('is_overview', 1)->first();
    	return $overview->files;
    }

    private function processActivity(array $data)
    {
        $modules = $data['course']->modules->where('is_overview', 0);
        
        $activities = [];
        foreach ($modules as $module) {
          $activities[] = $module->activities->toArray();
        }

        $new_activities = [];

        array_walk_recursive($activities, function ($data, $key) use (&$new_activities) {
          return $new_activities[$key][] = $data;
        });

        return $new_activities['id'];
    }

    public function process(array $data = [])
    {
    	if ($data['state'] === 'overview') {
      		$files = $this->processOverview($data);
      		if (!empty($files)) {
  				$key            = array_search($data['file_id'], array_column($files->toArray(), 'id'));
  				$ids            = array_column($files->toArray(), 'id');

  				$this->previous = File::find(@$ids[$key - 1]);
  				$this->next     = File::find(@$ids[$key + 1]);

  				if (is_null($this->next)) {
      				$this->next = $data['course']->modules
  			    						->where('is_overview', 0)
  			    						->first()
  			    						->activities
  			    						->where('activity_no', '1.1')
  			    						->first() ?? null;
  				}

    			if (is_null($this->previous)) {
    				$this->previous = Post::find($data['course']->id) ?? null;
    			}
    		}

    	} else if ($data['state'] === 'activity') {
         $activitiesIds = $this->processActivity($data);
         $key = array_search($data['activity_id'], $activitiesIds);
         $this->previous = Activity::find(@$activitiesIds[$key - 1]);
         $this->next = Activity::find(@$activitiesIds[$key + 1]);

         if (is_null($this->previous)) {
            $this->previous = $data['course']->modules
                                      ->where('is_overview', 1)
                                      ->first()
                                      ->files
                                      ->last() ?? null;
         }

         if (is_null($this->next)) {
            // Get the first value in activities_ids
            $id = reset($activitiesIds);
            $activity = Activity::find($id, ['module_id']);

            if (!is_null(Exam::where('module_id', $activity->module_id)->first())) {
                $this->next = Exam::where('module_id', $activity->module_id)->first();
            } 
            
         }
      }

    }

   public function getPrevious()
   {
   		return $this->previous;
   }

   public function getNext()
   {
   		return $this->next;
   }
}
