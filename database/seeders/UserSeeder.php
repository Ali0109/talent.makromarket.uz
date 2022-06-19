<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        $arr = [
            [
                'name' => 'Ali',
                'profession' => 'Developer',
                'number' => '998977059576',
                'user_id' => $i++,
            ],
            [
                'name' => 'Test',
                'profession' => 'Test',
                'number' => '998971111111',
                'user_id' => $i++,
            ],
            [
                'name' => 'Test2',
                'profession' => 'Test2',
                'number' => '998972222222',
                'user_id' => $i++,
            ],
        ];

        foreach ($arr as $row) {
            DB::table('users')->insert([
                'name' => $row['name'],
                'profession' => $row['profession'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            DB::table('phones')->insert([
                'number' => $row['number'],
                'user_id' => $row['user_id'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }

    }
}
