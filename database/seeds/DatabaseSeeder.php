<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	AdminSeeder::class,
        	BatchSeeder::class,
        	ProgramSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            IconSeeder::class,
            // EventSeeder::class,
        ]);
    }
}
