<?php
namespace App\Helpers;
use App\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use App\Activity;
use App\Exam;
use App\Module;
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

    private function getAllActivityNo(array $data = []) :array
    {
        $modules = $data['course']->modules->where('is_overview', 0);
        
        $activities = [];
        foreach ($modules as $module) {
          $activities[] = $module->activities->sortBy('activity_no')->toArray();
        }

        $new_activities = [];

        array_walk_recursive($activities, function ($data, $key) use (&$new_activities) {
          return $new_activities[$key][] = $data;
        });

        return $new_activities['activity_no'];
    }

    private function getModuleAndIndex(string $activity_no) : array
    {
        $activity = Activity::where('activity_no', $activity_no)->first();
        list($module, $index) = explode('.', $activity_no);
        return [$activity->module_id, $module, $index];
    }

    public function process(array $data = [])
    {
        $listOfActivityNo = $this->getAllActivityNo($data);

        list($moduleId, $module, $index) = $this->getModuleAndIndex($data['activity_no']);

        // Transform string float to float datatype.
        $moduleAndIndex =  floatval($module . '.' . $index);

        // Get the closest 
        $this->setPrevious(Activity::paginateGetPrevious($moduleAndIndex));
        $this->setNext(Activity::paginateGetNext($moduleAndIndex));

        if ($this->isPreviousEmpty()) {
            $this->setPrevious( $this->possiblePrevious(['course' => $data['course'] ]));
        }

        if ($this->isNextEmpty()) {
            $data = ['id' => $data['activity_id'] ];
            $this->setNext( $this->possibleNext($data) );
        }
    }
}
