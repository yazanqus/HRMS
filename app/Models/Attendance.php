<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'start_hour',
        'end_hour',
        'sign',
        'remarks',
        'leave_overtime_id',
        'month',
        'year',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
