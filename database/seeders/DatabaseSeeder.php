<?php

namespace Database\Seeders;
use DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        DB::table('salons')->insert([
            'name' => 'Ruby Black',
            'street' => 'Vienos',
            'street_number' => '9',
            'city'=> 'Vilnius',
            'telephone_num'=> '62311111'
        ]);
        DB::table('salons')->insert([
            'name' => 'Ruby Red',
            'street' => 'Oslo',
            'street_number' => '3',
            'flat_number' => '3',
            'city'=> 'Vilnius',
            'telephone_num'=> '62322222'
        ]);

    }
}
