<?php
namespace App\Helpers;
use App\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use App\Activity;
use App\Exam;
use App\Contracts\ModuleActivityFinder;

class ActivityViewer implements ModuleActivityFinder
{
    private $next;
    private $previous;

     public function setNext($next)
    {
        $this->next = $next;
    }

    public function setPrevious($previous)
    {
      $this->previous = $previous;
    }

    public function getPrevious()
    {
      return $this->previous;
    }

    public function getNext()
    {
      return $this->next;
    }

    public function has($data) :bool
    {
      return !empty($data);
    }

    public function isPreviousEmpty() :bool
    {
      return is_null($this->previous);
    }

    public function isNextEmpty() :bool
    {
        return is_null($this->next);
    }

    public function possiblePrevious(array $data = [])
    {
      return $data['course']->modules
                    ->where('is_overview', 1)
                    ->first()
                    ->files
                    ->last() ?? null;
    }

    public function possibleNext(array $data = []) 
    {
        // Get only the module_id 
        $activity = Activity::find($data['id'], ['module_id']);

        return Exam::where('module_id', $activity->module_id)->first() ?? null;
    }

    private function getActivityIds(array $data = []) :array
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
        $activityIds = $this->getActivityIds($data);
        $key = array_search($data['activity_id'], $activityIds);
        $this->setPrevious(Activity::find(@$activityIds[$key - 1]));
        $this->setNext(Activity::find(@$activityIds[$key + 1]));

        if ($this->isPreviousEmpty()) {
            $this->setPrevious( $this->possiblePrevious(['course' => $data['course'] ]));
        }

        if ($this->isNextEmpty()) {
            // Get the first value in activities_ids
            $id = reset($activityIds);
            $this->setNext($this->possibleNext(['id' => $id]));
        }
    }
}
