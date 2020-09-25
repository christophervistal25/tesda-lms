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
        	'name' => 'Christopher Administrator',
        	'email' => 'christophervistal25@gmail.com',
        	'password' => bcrypt('christopher'),
        ]);
    }
}
