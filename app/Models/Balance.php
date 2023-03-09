<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
class Balance extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected static $recordEvents = ['created','updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name',
                'leavetype_id',
            'user_id',
                'value']);

        // Chain fluent methods for configuration options
    }

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
