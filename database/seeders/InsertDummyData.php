<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use DB;



class InsertDummyData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         for ($i = 0; $i < 100000; $i ++) {

                $faker = Factory::create();

                DB::table('users')->insert([
                    'full_name' => $faker->name,
                    'email' => $faker->email,
                    'role'=>2,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
            }

    }
}
