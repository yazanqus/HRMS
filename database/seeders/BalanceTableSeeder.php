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

        DB::table('balances')->insert([
            'name' => 'Sick leave',
            'leavetype_id' => '2',
            'user_id' => '1',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Sick leave 30% deduction',
            'leavetype_id' => '3',
            'user_id' => '1',
            'value' => '90',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Sick leave 20% deduction',
            'leavetype_id' => '4',
            'user_id' => '1',
            'value' => '90',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Marriage leave',
            'leavetype_id' => '5',
            'user_id' => '1',
            'value' => '7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Compassionate - First degree relative',
            'leavetype_id' => '6',
            'user_id' => '1',
            'value' => '100',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Compassionate - Second degree relative',
            'leavetype_id' => '7',
            'user_id' => '1',
            'value' => '100',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Maternity leave',
            'leavetype_id' => '8',
            'user_id' => '1',
            'value' => '120',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Paternity leave',
            'leavetype_id' => '9',
            'user_id' => '1',
            'value' => '7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Pilgrimage Islamic leave',
            'leavetype_id' => '10',
            'user_id' => '1',
            'value' => '30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Pilgrimage Christian leave',
            'leavetype_id' => '11',
            'user_id' => '1',
            'value' => '7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Welfare leave',
            'leavetype_id' => '12',
            'user_id' => '1',
            'value' => '9',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Annual leave - First half',
            'leavetype_id' => '13',
            'user_id' => '1',
            'value' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Annual leave - Second half',
            'leavetype_id' => '14',
            'user_id' => '1',
            'value' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Unpaid leave',
            'leavetype_id' => '15',
            'user_id' => '1',
            'value' => '300',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Unpaid leave - First half',
            'leavetype_id' => '16',
            'user_id' => '1',
            'value' => '300',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Unpaid leave - Second half',
            'leavetype_id' => '17',
            'user_id' => '1',
            'value' => '300',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Compensation',
            'leavetype_id' => '18',
            'user_id' => '1',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('balances')->insert([
            'name' => 'Compensation - hours',
            'leavetype_id' => '19',
            'user_id' => '1',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('balances')->insert([
            'name' => 'Sick Leave - First half',
            'leavetype_id' => '20',
            'user_id' => '1',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Sick Leave - Second half',
            'leavetype_id' => '21',
            'user_id' => '1',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
