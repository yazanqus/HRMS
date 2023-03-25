<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'HR Test',
            'birth_date' => '2022-01-01',
            'employee_number' => '1001',
            'contract' => 'Regular',
            'usertype_id' => '2',
            'position' => 'HR Manager',
            'office' => 'AO2',
            'department' => 'HR',
            'grade' => '4',
            'hradmin' => 'yes',
            'superadmin' => 'yes',
            'joined_date' => '2021-01-03',
            'email' => 'Hr.test@nrc.no',
            'email_verified_at' => now(),
            'password' => Hash::make('hrtest123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


    }
}
