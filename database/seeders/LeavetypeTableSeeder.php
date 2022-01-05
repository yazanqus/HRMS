<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeavetypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('leavetypes')->insert([
            'name' => 'Annual leave',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('leavetypes')->insert([
            'name' => 'Sick leave',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
