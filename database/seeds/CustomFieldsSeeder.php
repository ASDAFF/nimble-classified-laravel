<?php

use Illuminate\Database\Seeder;

class CustomFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('customfields')->get()->count() == 0) {
                DB::table('customfields')->insert(['id' => 1, 'name' => 'Condition', 'type' => 'dropdown', 'options' => 'New,Used', 'is_shown' => 1, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 2, 'name' => 'Warranty', 'type' => 'dropdown', 'options' => 'Yes,No', 'is_shown' => 1, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 3, 'name' => 'Model', 'type' => 'text', 'is_shown' => 0, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 4, 'name' => 'Transaction Type', 'type' => 'dropdown', 'options' => 'Cash,Installment/Leasing', 'is_shown' => 1, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 5, 'name' => 'Model Year', 'type' => 'date', 'is_shown' => 0, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 6, 'name' => 'Engine Capacity', 'type' => 'text', 'is_shown' => 0]);
                DB::table('customfields')->insert(['id' => 7, 'name' => 'Fuel Type', 'type' => 'dropdown', 'options' => 'Diesel,Petrol,CNG,Petrol & Cng,LPG,Other Fuel Type', 'is_shown' => 1]);
                DB::table('customfields')->insert(['id' => 9, 'name' => 'Doors', 'type' => 'dropdown','options' => '2 Door,3 Door,4 Door, 5+ Door', 'is_shown' => 0]);
                DB::table('customfields')->insert(['id' => 10, 'name' => 'Color', 'type' => 'dropdown','options' => 'Black,Blue,Brown,Burgundy,Gold,Grey,Green,Purple,Red,Silver,Tan,Teal,White,Other', 'is_shown' => 0 ]);
                DB::table('customfields')->insert(['id' => 11, 'name' => "KM's driven", 'type' => 'text','data_type' =>  'numeric', 'inscription' => 'Km', 'is_shown' => 0, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 12, 'name' => 'Furnished', 'type' => 'dropdown', 'options' => 'Yes,No', 'is_shown' => 0, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 13, 'name' => 'Bedrooms', 'type' => 'dropdown', 'options' => '1,2,3,4,5,6+', 'is_shown' => 0, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 14, 'name' => 'Bathrooms', 'type' => 'dropdown', 'options' => '1,2,3,4,5,6,7+', 'is_shown' => 0, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 15, 'name' => 'Floor Level', 'type' => 'dropdown', 'options' => 'Ground,1,2,3,4,5,6,7+', 'is_shown' => 0, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 16, 'name' => 'Area unit', 'type' => 'dropdown', 'options' => 'sqfeet,sqyards,sqmeter', 'is_shown' => 0, 'required_field' => 1]);
                DB::table('customfields')->insert(['id' => 17, 'name' => 'Area', 'type' => 'text',  'is_shown' => 0, 'required_field' => 1 ]);
        }
    }
}