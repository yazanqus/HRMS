<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        $hruser = Auth::user();
        if ($hruser->office == "AO2")
        {
            return User::all()->except(1);

        }
        else
        $staffwithsameoffice = User::where('office',$hruser->office)->get();
            if (count($staffwithsameoffice))
            {
                $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
                    return collect($staffwithsameoffice->toArray())
                        ->only(['id'])
                        ->all();
                });
                return User::wherein('id', $hrsubsets)->get(); 
    }
}

    public function map($user): array
    {
        return [

            $user->name,
            $user->birth_date,
            $user->employee_number,
            $user->office,
            $user->position,
            $user->department,
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
            'office',
            'Position',
            'Department',
            'Joined Date',
            'Account Status',
            'Line Manager',
            'HR Admin',
            'Account Created Date',

        ];
    }
}
