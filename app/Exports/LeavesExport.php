<?php

namespace App\Exports;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeavesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Leave ID',
            'Requester',
            'Office',
            'Leave Type',
            'Start Date',
            'End Date',
            'Days',
            'Leave Status',
            'Line Manager',
            'Date Requested',
        ];
    }
    public function collection()
    {
        $hruser = Auth::user();
        if ($hruser->office == "AO2")
        {
            return Leave::all();

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
                return Leave::wherein('user_id', $hrsubsets)->get(); 
    
    }
    }
    public function map($leave): array
    {
        return [
            $leave->id,
            $leave->user->name,
            $leave->user->office,
            $leave->leavetype->name,
            $leave->start_date,
            $leave->end_date,
            $leave->days,
            $leave->status,
            $leave->lmapprover,
            $leave->created_at,

        ];
    }

}
