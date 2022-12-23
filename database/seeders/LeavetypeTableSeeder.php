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
        // id=1
        DB::table('leavetypes')->insert([
            'name' => 'Annual leave',
            'value' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=2
        DB::table('leavetypes')->insert([
            'name' => 'Sick leave',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // id=3
        DB::table('leavetypes')->insert([
            'name' => 'Sick leave 30% deduction',
            'value' => '90',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // id=4
        DB::table('leavetypes')->insert([
            'name' => 'Sick leave 20% deduction',
            'value' => '90',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // id=5
        DB::table('leavetypes')->insert([
            'name' => 'Marriage leave',
            'value' => '7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=6
        DB::table('leavetypes')->insert([
            'name' => 'Compassionate - First degree relative',
            'value' => '100',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=7
        DB::table('leavetypes')->insert([
            'name' => 'Compassionate - Second degree relative',
            'value' => '100',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=8
        DB::table('leavetypes')->insert([
            'name' => 'Maternity leave',
            'value' => '120',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=9
        DB::table('leavetypes')->insert([
            'name' => 'Paternity leave',
            'value' => '7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=10
        DB::table('leavetypes')->insert([
            'name' => 'Pilgrimage Islamic leave',
            'value' => '30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=11
        DB::table('leavetypes')->insert([
            'name' => 'Pilgrimage Christian leave',
            'value' => '7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=12
        DB::table('leavetypes')->insert([
            'name' => 'Welfare leave',
            'value' => '9',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=13
        DB::table('leavetypes')->insert([
            'name' => 'Annual leave - First half',
            'value' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=14
        DB::table('leavetypes')->insert([
            'name' => 'Annual leave - Second half',
            'value' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=15
        DB::table('leavetypes')->insert([
            'name' => 'Unpaid leave',
            'value' => '360',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=16
        DB::table('leavetypes')->insert([
            'name' => 'Unpaid leave - First half',
            'value' => '360',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=17
        DB::table('leavetypes')->insert([
            'name' => 'Unpaid leave - Second half',
            'value' => '360',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=18
        DB::table('leavetypes')->insert([
            'name' => 'Compensation',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=19 just for having it as an option when submitting leaves, the balance is irreveleant as it should be from id18
        DB::table('leavetypes')->insert([
            'name' => 'Compensation - hours',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=20
        DB::table('leavetypes')->insert([
            'name' => 'Sick Leave - First half',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=21
        DB::table('leavetypes')->insert([
            'name' => 'Sick Leave - Second half',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
