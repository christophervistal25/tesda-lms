<?php 
namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;
use App\Activity;
use App\File as ActivityFile;

class ActivityFileHelper
{

	private $files = [];
    private const URL_INDEX   = 1;
    private const TITLE_INDEX = 2;
    private const BODY_INDEX  = 0;

	public function same(array $files = [], Collection $activityFiles) :bool
	{
		return count($files) === count($activityFiles);
	}

	/**
	* This will check if we perform a add or delete for activity files.
	*/
    public function hasNew(array $files = [], Collection $activityFiles) :bool
    {
    	return count($files) > count($activityFiles);
    }

    public function add(Activity $activity, array $files = [])
    {
    	$createdFiles = [];
    	foreach ($files[self::URL_INDEX] as $key => $file) {
               $createdFiles[] = ActivityFile::firstOrNew(
                [
                    'title'          => $files[self::TITLE_INDEX][$key],
                    'filelable_id'   => $activity->id,
                    'type'           => 'page',
                    'filelable_type' => get_class($activity)
                ],
                [
                    'title' => $files[self::TITLE_INDEX][$key],
                    'body'  => $files[self::BODY_INDEX][$key],
                    'link'  => $file,
                    'type'  => 'page',
                ]);
    	}

    	return $this->pushFileToActivity($activity, $createdFiles);
    }

    public function remove(Activity $activity, array $files = [])
    {
    	foreach ($files[self::URL_INDEX] as $key => $link) {
            foreach ($activity->files as $activityFile) {
                if ($activityFile->link != $link) {
                    $activityFile->delete();
                }
            }
        }
    }

    public function pushFileToActivity(Activity $activity, array $files = [])
    {
    	return $activity->files()->saveMany($files);
    }
}
