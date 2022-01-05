<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'leavetype_id',
    ];

    public function leavetype()
    {
        return $this->belongsTo(Leavetype::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
