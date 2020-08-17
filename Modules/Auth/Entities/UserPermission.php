<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class UserPermission extends Model
{
    use LogsActivity;

    protected static $logAttributes = [
        'user_id',
        'permission_id'
    ];

    protected $fillable = [
        'user_id',
        'permission_id'
    ];
}
