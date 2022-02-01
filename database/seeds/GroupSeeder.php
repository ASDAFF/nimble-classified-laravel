<?php

use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('groups')->get()->count() == 0) {
            $data = array(
                'category_id' => 39,
                'title' => 'FEATURES',
                'icon' => '',
                'image' => ''
            );
            DB::table('groups')->insert($data);
        }
    }
}