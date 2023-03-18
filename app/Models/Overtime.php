<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Overtime extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    protected static $recordEvents = ['updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'user.name']);

        // Chain fluent methods for configuration options
    }

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

    public function comlists()
    {
        return $this->hasMany(Comlist::class);
    }

}
