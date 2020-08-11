<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
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
