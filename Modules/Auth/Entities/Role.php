<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    use LogsActivity;

    protected static $logAttributes = [
        'name',
        'slug',
        'permissions'
    ];

    protected $fillable = [
        'name',
        'slug',
        'permissions'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'role_base',
        'permissions'
    ];
}
