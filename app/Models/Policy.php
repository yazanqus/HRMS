<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{

    protected $fillable = [
        'name',
        'desc',
        'created_date',
        'lastupdate_date',
    ];

    use HasFactory;
}
