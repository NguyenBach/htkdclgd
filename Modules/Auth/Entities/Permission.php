<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
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
