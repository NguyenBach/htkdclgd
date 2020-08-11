<?php

namespace Modules\NghienCuuKhoaHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class BangSangChe extends Model
{
    protected $table = 'bang_sang_che';

    protected $fillable = [
        'year',
        'university_id',
        'content'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
