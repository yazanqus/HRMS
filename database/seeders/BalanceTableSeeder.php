<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BalanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('balances')->insert([
            'name' => 'Annual leave',
            'leavetype_id' => '1',
            'user_id' => '1',
            'value' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
