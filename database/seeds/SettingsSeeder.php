<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('setting')->get()->count() == 0) {
                $data =[
                    'title' => 'NimbleAds',
                    'logo' => '1527489290.png',
                    'nav_bg' => '#e8e8e8',
                    'body_bg' => '#ffffff',
                    'footer_bg' => '#ebebeb',
                    'copy_right_text' => '© 2018 Nimble Ads All  rights reserved',
                    'footer_head_color' => '#000',
                    'footer_link_color' => '#000',
                    'version' => '1.18',
                    'currency' => '$',
                    'currency_place' => 'left',
                    'map_listings' => 1
                ];
            DB::table('setting')->insert($data);
        }
    }
}
