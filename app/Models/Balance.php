<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{

    protected $fillable = [
        'leavetype_id',
        'name',
        'value',
    ];
    use HasFactory;

    public function leavetype()
    {
        return $this->belongsTo(Leavetype::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
