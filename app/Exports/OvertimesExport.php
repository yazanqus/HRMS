<?php

namespace App\Exports;

use App\Models\Overtime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OvertimesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $hruser = Auth::user();
        if ($hruser->office == "AO2")
        {
            return Overtime::all();

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
                return Overtime::wherein('user_id', $hrsubsets)->get(); 
    
    }
    }

    public function headings(): array
    {
        return [
            'Overtime ID',
            'Requester',
            'People ID',
            'Office',
            'Overtime Type',
            'Date',
            'Start Hour',
            'End Hour',
            'Overtime Hours',
            'Overtime Hours (value)',
            'Status',
            'Line Manager',
            'Date Requested',
        ];
    }

    public function map($overtime): array
    {
        return [
            $overtime->id,
            $overtime->user->name,
            $overtime->user->employee_number,
            $overtime->user->office,
            $overtime->type,
            $overtime->date,
            $overtime->start_hour,
            $overtime->end_hour,
            $overtime->hours,
            $overtime->value,
            $overtime->status,
            $overtime->lmapprover,
            $overtime->created_at,

        ];
    }
}
