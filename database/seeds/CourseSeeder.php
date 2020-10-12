<?php

use Illuminate\Database\Seeder;
use App\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::create([
			'name'        => 'AGRICULTURAL CROP PRODUCTION NC I',
			'acronym'     => 'ACPNC 1',
			'description' => 'AGRICULTURAL CROP PRODUCTION NC I',
			'design'      => '<p>AGRICULTURAL CROP PRODUCTION NC I</p>',
			'duration'    => 32,
			'program_id'  => 1,
        ]);
    }
}
