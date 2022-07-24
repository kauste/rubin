<?php

namespace Database\Seeders;
use DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        DB::table('salons')->insert([
            'name' => 'Ruby Deep',
            'street' => 'Saulegrazu',
            'street_number' => '3',
            'flat_number' => '3',
            'city'=> 'Alytus',
            'telephone_num'=> '62333333'
        ]);
        DB::table('procedures')->insert([
            'ruby_service' => 'Bob haircut',
            'minutes' => '60',
            'price' => '80.00',
        ]);
        DB::table('procedures')->insert([
            'ruby_service' => 'Hair die with air toutch technique',
            'minutes' => '300',
            'price' => '120.00',
        ]);
        DB::table('procedures')->insert([
            'ruby_service' => 'Hair die with balayage technique',
            'minutes' => '210',
            'price' => '100.00',
        ]);
        DB::table('procedures')->insert([
            'ruby_service' => 'Hair die with ombre technique',
            'minutes' => '210',
            'price' => '90.00',
        ]);
        DB::table('procedures')->insert([
            'ruby_service' => 'Manicure',
            'minutes' => '60',
            'price' => '30.00',
        ]);
        DB::table('procedures')->insert([
            'ruby_service' => 'Pedicure',
            'minutes' => '90',
            'price' => '50.00',
        ]);
        DB::table('masters')->insert([
            'name' => 'Kamile',
            'surname' => 'Kiskyte',
            'file_path' => 'kamile.jpg',
            'salon_id' => 1,
        ]);
        DB::table('masters')->insert([
            'name' => 'Ievute',
            'surname' => 'Raja',
            'file_path' => 'ievute.jpg',
            'salon_id' => 1,
        ]);
        DB::table('masters')->insert([
            'name' => 'Evelina',
            'surname' => 'Ever',
            'file_path' => 'evelina.jpg',
            'salon_id' => 2,
        ]);
        DB::table('masters')->insert([
            'name' => 'Rugile',
            'surname' => 'Stasionyte',
            'file_path' => 'rugile.jpg',
            'salon_id' => 2,
        ]);
        DB::table('masters')->insert([
            'name' => 'Raminta',
            'surname' => 'Bebenčiūtė',
            'file_path' => 'raminta.jpg',
            'salon_id' => 3,
        ]);
        DB::table('masters')->insert([
            'name' => 'Ieva',
            'surname' => 'Čigonaitė',
            'file_path' => 'ieva.jpg',
            'salon_id' => 3,
        ]);
        DB::table('users')->insert([
            'name' => 'Rugilike',
            'email' => 'rugilike@gmail.com',
            'password' => Hash::make('123'),
            'role'=> 10,
        ]);
        


    }
}
