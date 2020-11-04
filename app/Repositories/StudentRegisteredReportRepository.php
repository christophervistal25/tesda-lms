<?php 
namespace App\Repositories;

use App\Contracts\StudentRegistered;
use App\User as Student;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class StudentRegisteredReportRepository
{

	private function periods($start, $end, $addBy = '1 month')
	{
		return CarbonPeriod::create($start->format('Y-m-d H:i:s'), $addBy, $end->format('Y-m-d H:i:s'));
	}

	private function attributeFor(string $type)
	{
		$data = [
			'monthly' => [
				'period_increment' => '1 month',
				'start' => Carbon::now()->firstOfYear(),
				'end'   => Carbon::now()->endOfYear()	
			],

			'daily' => [
				'period_increment' => '1 day',
				'start' => Carbon::now()->firstOfMonth(),
				'end'   => Carbon::now()->endOfMonth()	
			],

			'weekly' => [
				'period_increment' => '1 week',
				'start' => Carbon::now()->firstOfMonth(),
				'end'   => Carbon::now()->endOfMonth()	
			],
		];
		
		return $data[$type];
	}

	public function get(string $type = 'monthly', StudentRegistered $report)
	{
		$attributes       = $this->attributeFor($type);
		$period_increment = $attributes['period_increment'];
		$start            = $attributes['start'];
		$end              = $attributes['end'];
		$periods          = $this->periods($start, $end, $period_increment);
		
		return $report->from($start, $end, $periods);
	}
}