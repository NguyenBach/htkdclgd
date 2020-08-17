<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['name', 'permission'];

    protected $fillable = [
        'name',
        'slug',
        'permission'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'role_base'
    ];


}
