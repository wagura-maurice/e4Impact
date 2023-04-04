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
        $this->call(RolesTableSeeder::class);
        // $this->call(AbilitiesTableSeeder::class);
        // $this->call(AbilityRoleTableSeeder::class);
        $this->call(CommunicationCategoriesTableSeeder::class);
        $this->call(CountiesTableSeeder::class);
        $this->call(MembershipCategoriesTableSeeder::class);
        $this->call(PartnershipCategoriesTableSeeder::class);
        $this->call(ProjectCategoriesTableSeeder::class);
        $this->call(PersonnelCategoriesTableSeeder::class);

        // create super administrator user.
        \App\Models\User::factory()->create([
            'name' => 'super_administrator',
            'email' => 'super_administrator@e4impact.devops',
        ])->assignRole('super_administrator');

        // create administrator user.
        \App\Models\User::factory()->create([
            'name' => 'administrator',
            'email' => 'administrator@e4impact.devops',
        ])->assignRole('administrator');

        // create manager user.
        \App\Models\User::factory()->create([
            'name' => 'manager',
            'email' => 'manager@e4impact.devops',
        ])->assignRole('manager');

        // create guest user.
        \App\Models\User::factory()->create([
            'name' => 'guest',
            'email' => 'guest@e4impact.devops',
        ])->assignRole('guest');

        \App\Models\Personnel::factory(100)->create();

        \App\Models\Membership::factory(50)->create()->each(function ($membership) {
            $membership->assignPersonnel(rand(1, 100));
        });

        \App\Models\Partnership::factory(200)->create()->each(function ($partnership) {
            $partnership->assignPersonnel(rand(1, 100));
        });

        \App\Models\Project::factory(300)->create()->each(function ($project) {
            $project->assignPersonnel(rand(1, 100));
        });
    }
}
