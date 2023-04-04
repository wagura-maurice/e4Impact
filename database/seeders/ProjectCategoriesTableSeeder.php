<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('project_categories')->delete();
        
        \DB::table('project_categories')->insert(array (
            0 => 
            array (
                'configuration' => NULL,
                'created_at' => '2023-04-04 14:27:40',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 1,
                'name' => 'default',
                'slug' => 'default',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'configuration' => NULL,
                'created_at' => '2023-04-04 14:30:11',
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