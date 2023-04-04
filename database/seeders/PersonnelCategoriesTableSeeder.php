<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PersonnelCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('personnel_categories')->delete();
        
        \DB::table('personnel_categories')->insert(array (
            0 => 
            array (
                'configuration' => NULL,
                'created_at' => '2023-04-04 14:27:50',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 1,
                'name' => 'defualt',
                'slug' => 'defualt',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'configuration' => NULL,
                'created_at' => '2023-04-04 14:29:57',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 2,
                'name' => 'custom',
                'slug' => 'custom',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}