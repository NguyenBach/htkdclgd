<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class KeyOfficer extends Model
{
    use LogsActivity;

    protected $fillable = [
        'year',
        'university_id',
        'department_id',
        'fullname',
        'degree',
        'position',
        'phone_number',
        'email'
    ];

    protected static $logAttributes = [
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
