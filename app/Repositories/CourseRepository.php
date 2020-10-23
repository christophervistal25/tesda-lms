<?php 
namespace App\Repositories;

use App\Course;
use Illuminate\Support\Str;

class CourseRepository
{
    public function getNoOfActivities(Course $course)
    {
    	$noOfActivities = 0;
    	foreach ($course->modules as $module) {
            if ($module->is_overview == 1) {
                $noOfActivities += $module->files->count();
            } else {
                $noOfActivities += $module->activities->count();
            }
        }

        return $noOfActivities;
    }

    public function getCourseModules(Course $course)
    {
    	return $course->with(['modules']);
    }

    public function isModulesReady(Course $course)
    {
        // Check if overview files and module activities has value
        if ($course->modules->where('is_overview', 1)->isEmpty() || $this->getNoOfActivities($course) === 0) {
            return false;
        }
        
        return true;
    }

    public static function sections(Course $course)
    {
        $overview = $course->modules->where('is_overview', 1);
        $sections = [];
        if ($overview) {
             foreach ($overview->first()->files->pluck('title')->toArray() as $section) {
                $sections['Course_Overview'][] = $section;
            }
        }

        $modules = $course->modules->where('is_overview', 0);
        if ($modules) {
            foreach ($modules as $module) {
                $key = str_replace(' ', '_', $module->title);
                foreach ($module->activities->where('completion', null)->toArray() as $section) {
                    $sections[$key][] = $section['activity_no'] . ' ' . $section['title'];
                }

                // check this module if has exam
                if ($module->exam) {
                    foreach ($module->exam->pluck('title')->toArray() as $section) {
                        $sections[$key][] = $section;
                    }

                    if ($module->activities->where('completion', 1)) {
                        foreach ($module->activities->where('completion', 1)->pluck('title')->toArray() as $section) {
                            $sections[$key][] = $section;    
                        }
                    }
                }
            }
        }
        return $sections;
    }
}

