<?php 
namespace App\Repositories;

use App\Contracts\StudentRegistered;
use Carbon\Carbon;
use App\User as Student;

class StudentRegisteredDailyRepository implements StudentRegistered
{
	public function from($start, $end, $periods)
	{
		$days = [];
		$data = [];
		foreach ($periods as $key => $dt) {
            $days[] = 'Day ' . $dt->format('d');
            $data[$key + 1] = Student::whereBetween('created_at', [$dt->format('Y-m-d H:i:s'), $dt->format('Y-m-d 23:59:59')])
                                     			->count();
        }

        return [$data, $days];
	}    
}
