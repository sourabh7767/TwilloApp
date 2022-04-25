<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$titles = ["Manage Users", "Manage Items", "Manage Workorders"];

        $count = Db::table('permissions')->count();

        if(!$count){

            foreach ($titles as $key => $title) {
                
                DB::table('permissions')->insert([
                    'title' => $title,
                    'type' => $key + 1
                ]);

            }
        }
         
    }
}
