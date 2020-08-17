<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'created_by',
        'university_id'
    ];

    protected static $logAttributes = ['name', 'slug'];

    protected $hidden = [
        'created_by',
        'created_at',
        'updated_at'
    ];

    public static function checkExist($slug, $universityId)
    {
        $department = self::where('slug', $slug)
            ->where('university_id', $universityId)
            ->first();
        return is_null($department);
    }

    public static function checkExistInUniversity($id, $universityId)
    {
        $department = self::where('id', $id)
            ->where('university_id', $universityId)
            ->first();
        return !is_null($department);
    }
}
