<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{

    protected $fillable = [
        'name',
        'desc',
        'start_date',
        'end_date',
    ];

    use HasFactory;
}
