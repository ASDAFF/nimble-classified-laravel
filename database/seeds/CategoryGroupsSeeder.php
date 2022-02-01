<?php

use Illuminate\Database\Seeder;

class CategoryGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('category_groups')->get()->count() == 0) {
            $data = array(
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
                array( 'category_id' => 39, 'group_id' => 1),
            );
            DB::table('category_groups')->insert($data);
        }
    }
}
