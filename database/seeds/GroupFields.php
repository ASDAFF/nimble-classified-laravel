<?php

use Illuminate\Database\Seeder;

class GroupFields extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('group_fields')->get()->count() == 0) {
            $data = array(
                array( 'group_id' => 1,  'title' => 'ABS', 'icon' => '', 'image' => '1526990338.png', 'status' => 1),
                array( 'group_id' => 1,  'title' => 'AM/FM Radio', 'icon' => '', 'image' => '1527049222.png', 'status' => 1),
                array( 'group_id' => 1,  'title' => 'Sun Roof', 'icon' => '', 'image' => '1527049266.png', 'status' => 1),
                array( 'group_id' => 1,  'title' => 'Air Conditioning', 'icon' => '', 'image' => '1527049303.png', 'status' => 1),
                array( 'group_id' => 1,  'title' => 'Power Windows', 'icon' => '', 'image' => '1527049350.png', 'status' => 1),
                array( 'group_id' => 1,  'title' => 'Air Bags', 'icon' => '', 'image' => '1527049399.png', 'status' => 1),
                array( 'group_id' => 1,  'title' => 'DVD Player', 'icon' => '', 'image' => '1527049433.png', 'status' => 1),
                array( 'group_id' => 1,  'title' => 'Power Steering', 'icon' => '', 'image' => '1527049458.png', 'status' => 1),
                array( 'group_id' => 1,  'title' => 'Power Locks', 'icon' => '', 'image' => '1527049493.png', 'status' => 1),
                array( 'group_id' =>  1, 'title' =>  'Alloy Rims', 'icon' => '', 'image' => '1527049536.png', 'status' => 1),
                array( 'group_id' =>  1, 'title' =>  'Navigation System', 'icon' => '', 'image' => '1527049561.png', 'status' => 1),
                array( 'group_id' =>  1, 'title' =>  'Power Mirrors', 'icon' => '', 'image' => '1527049715.png', 'status' => 1)

            );

            DB::table('group_fields')->insert($data);
        }
    }
}
