<?php

use Illuminate\Database\Seeder;
use App\Program;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Program::create([
        	'name' => 'Agricultural Crops Production NC II',
        	'batch_id' => 1,
        ]);
    }
}
