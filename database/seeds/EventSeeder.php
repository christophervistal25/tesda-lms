<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = Carbon::now();

    	foreach (range(1, 3) as $value) {
			$start = new Carbon($now->addDays(1));
			$end   = new Carbon($now->addDays(2));
    		Event::create([
                'title'       => 'Lorem Ipsum - ' . $value,
                'location'    => 'Test',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod - ' . $value,
                'start'       => $start,
                'end'         => $end,
        	]);
    	}

    }
}
