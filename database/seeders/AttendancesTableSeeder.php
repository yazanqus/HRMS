<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendances')->insert([
            'month' => 'January',
            'year' => '2022',
        ]);

        DB::table('attendances')->insert([
            'month' => 'February',
            'year' => '2022',
        ]);
        DB::table('attendances')->insert([
            'month' => 'March',
            'year' => '2022',
        ]);

        DB::table('attendances')->insert([
            'month' => 'April',
            'year' => '2022',
        ]);
        DB::table('attendances')->insert([
            'month' => 'May',
            'year' => '2022',
        ]);
        DB::table('attendances')->insert([
            'month' => 'June',
            'year' => '2022',
        ]);
        DB::table('attendances')->insert([
            'month' => 'July',
            'year' => '2022',
        ]);
        DB::table('attendances')->insert([
            'month' => 'August',
            'year' => '2022',
        ]);
        DB::table('attendances')->insert([
            'month' => 'September',
            'year' => '2022',
        ]);
        DB::table('attendances')->insert([
            'month' => 'October',
            'year' => '2022',
        ]);
        DB::table('attendances')->insert([
            'month' => 'November',
            'year' => '2022',
        ]);
        DB::table('attendances')->insert([
            'month' => 'December',
            'year' => '2022',
        ]);
    }
}
