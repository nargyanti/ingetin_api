<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {     
        $users = [
            [
                'name' => 'Nabilah Argyanti',
                'email' => 'nabilah@gmail.com',
                'password' => Hash::make('12345678'),
            ], 
            [
                'name' => 'Radithya Iqbal',
                'email' => 'radith@gmail.com',
                'password' => Hash::make('12345678'),
            ]
        ];        
        
        DB::table('users')->insert($users);
    }
}
