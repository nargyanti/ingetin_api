<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $todos = [
            [
                'name' => 'Quiz 2 Cloud',
                'description' => 'Lorem ipsum dolor sit amet',
                'due_date' => '2021-12-30',
                'due_time' => '08:59',
                'category_id' => 1,
                'user_id' => 1
            ],            
        ];
        DB::table('todos')->insert($todos);
    }
}
