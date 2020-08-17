<?php

namespace Modules\CoSoVatChat\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class NhomNganh extends Model
{
    use LogsActivity;

    protected $table = 'nhom_nganh';

    protected $fillable = [
        'university_id',
        'name',
        'slug'
    ];

    protected static $logAttributes = [
        'university_id',
        'name',
        'slug'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}
