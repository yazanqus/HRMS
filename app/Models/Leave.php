<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use LogsActivity;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    // use SoftDeletes;
    protected $fillable = [
        'start_date',
        'end_date',
        'leavetype_id',
        'reason',
    ];

    protected static $recordEvents = ['deleted','updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status','deleted_at', 'user.name']);

        // Chain fluent methods for configuration options
    }

    public function leavetype()
    {
        return $this->belongsTo(Leavetype::class);
        // test2
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
