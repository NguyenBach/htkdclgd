<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;

class KeyOfficer extends Model
{
    protected $fillable = [
        'university_id',
        'department_id',
        'fullname',
        'degree',
        'position',
        'phone_number',
        'email'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
