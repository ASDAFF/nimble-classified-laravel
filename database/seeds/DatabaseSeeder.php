<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         $this->call(
             [
                 CategoryTableSeeder::class,
                 CategoryCustomfields::class,
                 CategoryGroupsSeeder::class,
                 CustomFieldsSeeder::class,
                 GroupSeeder::class,
                 GroupFields::class,
                 SettingsSeeder::class,
                 EmailSettingsSeeder::class
             ]
         );
    }
}
