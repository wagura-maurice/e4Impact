<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'super administrator',
                'slug' => 'super_administrator',
                'description' => NULL,
                'configuration' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-26 10:39:15',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'administrator',
                'slug' => 'administrator',
                'description' => NULL,
                'configuration' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-26 10:39:15',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'manager',
                'slug' => 'manager',
                'description' => NULL,
                'configuration' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-26 10:39:15',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'guest',
                'slug' => 'guest',
                'description' => NULL,
                'configuration' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-26 10:39:15',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}