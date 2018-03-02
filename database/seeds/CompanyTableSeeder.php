<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 0; $i < 15; $i++)
        {
            DB::table('companies')->insert([
                'name' => str_random(10)
            ]);
        }
    }
}
