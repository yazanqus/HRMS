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
            'usertype_id' => '2',
            'position' => 'HR Manager',
            'office' => 'AO2',
            'department' => 'HR',
            'grade' => '9',
            'hradmin' => 'yes',
            'joined_date' => '2021-01-03',
            'email' => 'Hr.test@nrc.no',
            'email_verified_at' => now(),
            'password' => Hash::make('hrtest123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // DB::table('users')->insert([
        //     'name' => 'Hassan Janboura',
        //     'birth_date' => '2022-01-03',
        //     'employee_number' => '1002',
        //     'position' => 'CIO',
        //     'unit' => 'IT',
        //     'grade' => '9',
        //     'joined_date' => '2021-01-03',
        //     'email' => 'Hassan.janboura@nrc.no',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('Password2'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Sami Omar',
        //     'birth_date' => '2021-04-03',
        //     'employee_number' => '1003',
        //     'position' => 'Admin Techcnial assistant',
        //     'unit' => 'Admin',
        //     'grade' => '4',
        //     'joined_date' => '2019-01-01',
        //     'email' => 'sami.omar@nrc.no',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('Password3'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Rami nour',
        //     'birth_date' => '2018-07-03',
        //     'employee_number' => '1004',
        //     'position' => 'HR Officer',
        //     'unit' => 'HR',
        //     'grade' => '5',
        //     'joined_date' => '2018-01-03',
        //     'email' => 'Rami.nour@nrc.no',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('Password4'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Lama Fadi',
        //     'birth_date' => '2017-11-03',
        //     'employee_number' => '1005',
        //     'position' => 'Comliance Coordinato',
        //     'unit' => 'Comliance',
        //     'grade' => '8',
        //     'joined_date' => '2017-01-15',
        //     'email' => 'Lama.fadi@nrc.no',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('Password5'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Rana Kheder',
        //     'birth_date' => '2022-01-03',
        //     'employee_number' => '1006',
        //     'position' => 'CEO',
        //     'unit' => 'Management',
        //     'grade' => '10',
        //     'joined_date' => '2022-01-03',
        //     'email' => 'rana.khder@nrc.no',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('Password6'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Nada saeed',
        //     'birth_date' => '2016-01-03',
        //     'employee_number' => '1007',
        //     'position' => 'Capacity building manager',
        //     'unit' => 'CB',
        //     'grade' => '9',
        //     'joined_date' => '2020-01-03',
        //     'email' => 'nada.saeed@nrc.no',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('Password7'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'rami Janboura',
        //     'birth_date' => '2022-01-03',
        //     'employee_number' => '1008',
        //     'position' => 'CEO',
        //     'unit' => 'Management',
        //     'grade' => '10',
        //     'joined_date' => '2022-01-03',
        //     'email' => 'rami.janboura@nrc.no',
        //     'hradmin' => 'yes',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('Password8'),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}
