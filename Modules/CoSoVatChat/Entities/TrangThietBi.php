<?php

namespace Modules\CoSoVatChat\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TrangThietBi extends Model
{
    use LogsActivity;

    protected $table = 'trang_thiet_bi';

    protected $fillable = [
        'name',
        'slug',
        'created_by'
    ];

    protected static $logAttributes = [
        'name',
        'slug',
        'created_by'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
