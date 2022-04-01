<?php

namespace App\Exports;

use App\Models\Overtime;
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
        return Overtime::all();
    }

    public function headings(): array
    {
        return [
            'Overtime ID',
            'Requester',
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
            $overtime->type,
            $overtime->date,
            $overtime->start_hour,
            $overtime->end_hour,
            $overtime->hours,
            $overtime->value,
            $overtime->status,
            $overtime->user->linemanager,
            $overtime->created_at,

        ];
    }
}
