<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class JobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 0; $i < 50; $i++)
        {
            DB::table('jobs')->insert([
                'name' => str_random(10),
                'clientid' => rand(1, 10),
                'status' => rand(1, 3),
                'created_at' => '2017-01-01 00:00:00',
                'price' => (string)(mt_rand(10*10, 100000*10) / 10)
            ]);
        }
    }
}
