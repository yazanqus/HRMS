<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_hour',
        'end_hour',
        'reason',
        // 'leavetype_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
