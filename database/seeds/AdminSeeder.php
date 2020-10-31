<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
        	'name' => 'LMS Administrator',
        	'email' => 'admin@yahoo.com',
        	'password' => bcrypt('1234'),
        ]);
    }
}
