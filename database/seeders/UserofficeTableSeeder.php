<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserofficeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_offices')->insert([
            'name' => 'AO2',
        ]);

        DB::table('user_offices')->insert([
            'name' => 'AO3',
        ]);
        DB::table('user_offices')->insert([
            'name' => 'AO4',
        ]);

        DB::table('user_offices')->insert([
            'name' => 'AO6',
        ]);
        DB::table('user_offices')->insert([
            'name' => 'AO7',
        ]);

    }
}
