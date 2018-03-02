<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
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
            DB::table('clients')->insert([
                'companyid' => rand(1, 10),
                'name' => str_random(10),
                'surname' => str_random(10)
            ]);
        }
    }
}
