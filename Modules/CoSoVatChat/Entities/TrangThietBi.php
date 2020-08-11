<?php

namespace Modules\CoSoVatChat\Entities;

use Illuminate\Database\Eloquent\Model;

class TrangThietBi extends Model
{
    protected $table = 'trang_thiet_bi';

    protected $fillable = [
        'name',
        'slug',
        'created_by'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
