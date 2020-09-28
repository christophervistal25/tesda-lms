<?php

use Illuminate\Database\Seeder;
use App\Batch;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Batch::create([
			'name'     => 'e Learning Course',
			'batch_no' => 1,
        ]);
    }
}
