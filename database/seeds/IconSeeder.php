<?php

use Illuminate\Database\Seeder;
use App\Icon;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        foreach (glob( public_path() . '/file_icons/*' ) as $filename) {
			Icon::create([
				'path' => \Str::after($filename, 'public'),
                'name' => str_replace('_', ' ', str_replace('.png', '', str_replace('/file_icons/', '', \Str::after($filename, 'public')))),
			]);
		}
    }
}
