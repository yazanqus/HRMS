<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use CausesActivity;
    use HasApiTokens, HasFactory, Notifiable;
    use Sortable;
    use SoftDeletes;
    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected static $recordEvents = ['created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name',
                'birth_date',
                'unit',
                'position',
                'employee_number',
                'joined_date',
                'grade',
                'department',
                'email',
                'linemanager',
                'usertype_id',
                'hradmin'])->logOnlyDirty();

        // Chain fluent methods for configuration options
    }

    protected $fillable = [
        'name',
        'birth_date',
        'department',
        'grade',
        'position',
        'employee_number',
        'contract',
        'joined_date',
        'email',
        'office',
        'password',
        'linemanager',
        'usertype_id',
        'hradmin',
        'token',

    ];
    public $sortable = ['name', 'position', 'created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    public function balances()
    {
        return $this->hasMany(Balance::class);
    }

    public function Usertype()
    {
        return $this->belongsTo(Usertype::class);
    }

    public function comlists()
    {
        return $this->hasMany(Comlist::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

}
