<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'university_id',
        'name',
        'founded_year',
        'field',
        'number_researcher',
        'number_officer',
        'slug'
    ];
    protected $hidden = [
        'created_at',
        'slug',
        'updated_at'
    ];
}
