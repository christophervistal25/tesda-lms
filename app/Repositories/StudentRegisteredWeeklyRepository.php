<?php 
namespace App\Repositories;

use App\Contracts\StudentRegistered;
use Carbon\Carbon;
use App\User as Student;

class StudentRegisteredWeeklyRepository implements StudentRegistered
{
	private function isLastRecord($noOfElements, $key)
	{
		return $noOfElements == $key;
	}

	private function rangeDateIsOneWeek($to, $end)
	{
		return $to->diffInDays($end) >= 7;
	}

	public function from($start, $end, $periods)
	{
		$data    = [];
		$index   = 0;

        foreach ($periods as $key => $dt) {
            $index++;
            $from = $dt;
            $to   = $dt->copy()->addWeek(1);

            // Ceheck if the current date is last record
            if ( $this->isLastRecord((count($periods) - 1) , $key) ) {
            	// Is 1 week?
                if ($this->rangeDateIsOneWeek($to, $end)) {
                    $weeks[] = 'Week' . $index;
                    $from = $from->format('Y-m-d H:i:s');
                    $to =  $end->format('Y-m-d H:i:s');
                }
            } else {
                $weeks[] = 'Week ' .  $index;
				$from = $from->format('Y-m-d H:i:s');
				$to   = $to->format('Y-m-d H:i:s');
            }

            $data[$key] = Student::whereBetween('created_at', [$from, $to])->count();
        }
        return [$data, $weeks];
	}    
}
