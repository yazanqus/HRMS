<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BalanceExport implements FromCollection, WithHeadings, WithMapping
{

    use Exportable;
    protected $users;


    public function __construct($users) {

        $this->users = $users;
       
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return $this->users;


    //     $hruser = Auth::user();
    //     if ($hruser->office == "AO2")
    //     {
    //         return User::all()->except(1);

    //     }
    //     else
    //     $staffwithsameoffice = User::where('office',$hruser->office)->get();
    //         if (count($staffwithsameoffice))
    //         {
    //             $hrsubsets = $staffwithsameoffice->map(function ($staffwithsameoffice) {
    //                 return collect($staffwithsameoffice->toArray())
    //                     ->only(['id'])
    //                     ->all();
    //             });
    //             return User::wherein('id', $hrsubsets)->get(); 
    // }
}

    public function map($user): array
    {

        if ($user->contract !== "Service")
        {
            return [

                $user->employee_number,
                $user->name,
                $user->balances->first()->value,
                $user->balances->get(1)->value,
                $user->balances->get(2)->value,
                $user->balances->get(3)->value,
                $user->balances->get(4)->value,
                $user->balances->get(11)->value,
                $user->balances->get(7)->value,
                $user->balances->get(8)->value,
                $user->balances->get(17)->value,
            
    
            ];
        }

        else{
            return [

                $user->employee_number,
                $user->name,
                $user->balances->first()->value,
            
    
            ];

        }
      
    }

    public function headings(): array
    {
        return [

            'Employee Number',
            'Name',
            'Annual',
            'Sick',
            'Sick 30%',
            'Sick 20%',
            'Marriage',
            'Welfare',
            'Maternity',
            'Paternity',
            'Compensation',
           

        ];
    }
}
