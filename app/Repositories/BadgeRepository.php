<?php
namespace App\Repositories;
use DB;
use App\{Badge, Module, Activity, File, Course, User as Student};

class BadgeRepository
{
	public function collect($criterias, string $type = 'module')
    {
        $data = [];
        $types = ($type == 'module') ? Module::TYPES : Activity::TYPES;
        foreach ($criterias as $key => $criteria) {
            if (in_array($criteria->type, $types)) {
                   $data[] = $criteria;
            }
        }

        return $data;
    }


    private function isEmpty($data) :bool
    {
        return count($data) <= 0;
    }


    private function only($data, string $column = 'id') :array
    {
        $data = collect($data)->toArray();
        return array_column($data, $column);
    }

    private function childOfOverview($activity) :bool
    {
        return $activity->type === 'file';
    }

    private function childOfModule($activity) :bool
    {
        return $activity->type === 'activity';
    }

    private function processActivities(array $data = [])
    {
        foreach ($data['activities'] as $activity) {
            if ($this->childOfOverview($activity)) {
                $file = File::find($activity->id);
                $data['badge']->files()->attach($file);
            } else if ($this->childOfModule($activity)) {
                $activity = Activity::find($activity->id);
                $data['badge']->activities()->attach($activity);
            }
        }
    }

    public function insertCreterias(array $data = [])
    {
        if (!$this->isEmpty($data['modules'])) {
            $ids     = $this->only($data['modules'], 'id');
            $modules = Module::whereIn('id', $ids)->get();
            $data['badge']->modules()->attach($modules);    
        }

        if (!$this->isEmpty($data['activities'])) {
            $this->processActivities($data);
        }
    }

    public function updateCriterias(array $data = [])
    {
        DB::table('badgeables')->where('badge_id', $data['badge']->id)->delete();
        if (!$this->isEmpty($data['modules'])) {
            $ids     = $this->only($data['modules'], 'id');
            $modules = Module::whereIn('id', $ids)->get();
            $data['badge']->modules()->sync($modules);    
        }

        if (!$this->isEmpty($data['activities'])) {
            foreach ($data['activities'] as $activity) {
                if ($this->childOfOverview($activity)) {
                    $file = File::find($activity->id);
                    $data['badge']->files()->sync($file);
                } else if ($this->childOfModule($activity)) {
                    $activity = Activity::find($activity->id);
                    $data['badge']->activities()->sync($activity);
                }
            }
        }
    }


    private function has(string $type, Badge $badge)
    {
        return isset($badge->$type);
    }

    private function requirementsInModules(Badge $badge, array $requirements)
    {
        $BADGE_KEY = 'BADGE_' . $badge->id;
        
        foreach($badge->modules as $module) {
            if ($module->is_overview == 0) {
                $requirements[$BADGE_KEY]['activities'] = $module->activities->pluck('id')->toArray();
            } else {
                $requirements[$BADGE_KEY]['files']  = $module->files->pluck('id')->toArray();
            }
        }

        return $requirements;
    }

    private function requirementsIn(string $type, Badge $badge, array $requirements)
    {
        $BADGE_KEY = 'BADGE_' . $badge->id;
        
        foreach ($badge->$type as $value) {
            $requirements[$BADGE_KEY][$type][] = $value->id;
        }

        return $requirements;
    }

    public function getBadgeRequirements(Course $course) :array
    {
        $requirements = [];

    
        foreach ($course->badge as $badge) {
           
            if ($this->has('modules', $badge)) {
                $requirements = $this->requirementsInModules($badge, $requirements);
            }

            if ($this->has('files', $badge)) {
                $requirements = $this->requirementsIn('files', $badge, $requirements);    
            }

            if ($this->has('activities', $badge)) {
                $requirements = $this->requirementsIn('activities', $badge, $requirements);
            }
            
        }

        return $requirements;
    }

    private function isBadgeComplete($accomplish, $requirements) :bool
    {
        $noOfAccomplish = 0;
        foreach ($accomplish as $id) {
            if (in_array($id, $requirements)) {
                $noOfAccomplish++;
            }
        }
        return count($requirements) == $noOfAccomplish;
    }

    public function getBadgeAccomplish(Student $student, Course $course)
    {
        $accomplishBadges = [];
        $requirements     = $this->getBadgeRequirements($course);
        
        $student_accomplish = [
            'files'      => $student->accomplish_files->pluck('id')->toArray(),
            'activities' => $student->accomplish_activities->pluck('id')->toArray()
        ];

        foreach ($requirements as $badge => $requirement) {
            if (count($requirement) === 1) {

                if (isset($requirement['files'])) {
                    if ($this->isBadgeComplete($student_accomplish['files'], $requirement['files'])) {
                        $accomplishBadges[] = $badge;
                    }
                }

                if (isset($requirement['activities'])) {
                    if ($this->isBadgeComplete($student_accomplish['activities'], $requirement['activities'])) {
                        $accomplishBadges[] = $badge;
                    }
                }
                
            } else if (count($requirement) >= 2) {
                $isComplete = $this->isBadgeComplete($student_accomplish['activities'], $requirement['activities']) 
                                and $this->isBadgeComplete($student_accomplish['files'], $requirement['files']);
                if ($isComplete) {
                    $accomplishBadges[] = $badge;
                }
                
            }
        }

        return $accomplishBadges;
    }


}