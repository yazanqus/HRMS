<?php

namespace App\Exports;

use App\Models\Leave;
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
        return Leave::all();
    }

    public function map($leave): array
    {
        return [
            $leave->id,
            $leave->user->name,
            $leave->leavetype->name,
            $leave->start_date,
            $leave->end_date,
            $leave->days,
            $leave->status,
            $leave->user->linemanager,
            $leave->created_at,

        ];
    }

}
