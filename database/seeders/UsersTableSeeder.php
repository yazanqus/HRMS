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
            'name' => 'Danial Janboura',
            'birth_date' => '2022-01-03',
            'employee_number' => '1001',
            'position' => 'CEO',
            'unit' => 'Management',
            'grade' => '10',
            'joined_date' => '2022-01-03',
            'email' => 'danial.janboura@nrc.no',
            'email_verified_at' => now(),
            'password' => Hash::make('Password1'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
