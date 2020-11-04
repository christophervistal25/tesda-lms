<?php 
namespace App\Repositories;

use App\Contracts\StudentRegistered;
use Carbon\Carbon;
use App\User as Student;

class StudentRegisteredMonthlyRepository implements StudentRegistered
{
	
	public function from($start, $end, $periods)
	{
        $data = [];
        foreach ($periods as $dt) {
            $start = Carbon::parse($dt->format("Y-m-d"))->format('Y-m-d H:i:s');
            $end   = Carbon::parse($start)->endOfMonth()->format('Y-m-d H:i:s');
            $data[Carbon::parse($dt)->month] = Student::whereBetween('created_at', [$start, $end])
                                                       ->count();
        }
        return $data;
    }    
}
