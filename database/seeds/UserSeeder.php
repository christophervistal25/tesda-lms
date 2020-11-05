<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'tooshort06' ,
                'name'      => 'Christopher User' ,
                'email'     => 'christophervistal25@gmail.com',
                'password'  => bcrypt('christopher'),
                'firstname' => 'Christopher',
                'surname'   => 'Vistal',
                'city_town' => 'Tandag City',
                'country'   => 'PH',
            ]);
        User::create([
            'username' => 'tooshort07' ,
                'name'      => 'Christopher User' ,
                'email'     => 'christophervistal26@gmail.com',
                'password'  => bcrypt('christopher'),
                'firstname' => 'Christopher',
                'surname'   => 'Vistal',
                'city_town' => 'Tandag City',
                'country'   => 'PH',
            ]);
        // factory(User::class, 30)->create();
    }
}
