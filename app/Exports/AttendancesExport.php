<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendancesExport implements FromCollection, WithHeadings, WithMapping
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
        return Attendance::all();
    }

    public function map($attendnace): array
    {
        return [
            $attendnace->id,
            isset($attendnace->user->name) ? $attendnace->user->name : $attendnace->user_id,
            $attendnace->day,
            $attendnace->start_hour,
            $attendnace->end_hour,
            $attendnace->sign,
            $attendnace->status,
            $attendnace->remarks,
            $attendnace->leave_overtime_id,
            $attendnace->month,
            $attendnace->year,
            isset($attendnace->user->linemanager) ? $attendnace->user->linemanager : $attendnace->user_id,

        ];
    }

}
