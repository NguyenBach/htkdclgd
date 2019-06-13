<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    protected $hidden = [
        'created_by',
        'created_at',
        'updated_at'
    ];
}
