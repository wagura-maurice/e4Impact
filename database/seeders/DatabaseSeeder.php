<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(SettingsTableSeeder::class);
        $this->call(CommunicationCategoriesTableSeeder::class);
        $this->call(CountiesTableSeeder::class);
        $this->call(MembershipCategoriesTableSeeder::class);
        $this->call(PartnershipCategoriesTableSeeder::class);
        $this->call(ProjectCategoriesTableSeeder::class);
        $this->call(PersonnelCategoriesTableSeeder::class);
    }
}
