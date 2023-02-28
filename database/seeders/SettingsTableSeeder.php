<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'item' => 'CUSTOMER_CARE_CALLER_ID',
                'default_value' => '+254 712 526 952',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-02-20 14:19:26',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}