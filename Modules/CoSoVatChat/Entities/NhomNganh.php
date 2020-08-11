<?php

namespace Modules\CoSoVatChat\Entities;

use Illuminate\Database\Eloquent\Model;

class NhomNganh extends Model
{
    protected $table = 'nhom_nganh';

    protected $fillable = [
        'university_id',
        'name',
        'slug'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}
