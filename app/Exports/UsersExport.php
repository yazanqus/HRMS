<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return User::all();
    }

    public function map($user): array
    {
        return [

            $user->name,
            $user->birth_date,
            $user->employee_number,
            $user->position,
            $user->department,
            $user->grade,
            $user->joined_date,
            $user->status,
            $user->linemanager,
            $user->hradmin,
            $user->created_at,

        ];
    }

    public function headings(): array
    {
        return [

            'Name',
            'Birth Date',
            'Employee Number',
            'Position',
            'Department',
            'Grade',
            'Joined Date',
            'Account Status',
            'Line Manager',
            'HR Admin',
            'Account Created Date',

        ];
    }
}
