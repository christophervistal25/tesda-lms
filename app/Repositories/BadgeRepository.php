<?php
namespace App\Repositories;
use App\Module;
use App\Activity;
use App\File;
use DB;

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


}