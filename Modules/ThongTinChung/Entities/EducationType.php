<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EducationType extends Model
{
    use LogsActivity;

    protected $fillable = [
        'university_id',
        'name',
        'slug',
        'order',
        'year'
    ];

    protected static $logAttributes = [
        'name', 'year', 'order'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'university_id'
    ];

    public static function checkExist($slug, $universityId, $year)
    {
        $department = self::where('slug', $slug)
            ->where('university_id', $universityId)
            ->where('year', $year)
            ->first();
        return is_null($department);
    }

    public static function checkExistId($id, $universityId)
    {
        $department = self::where('id', $id)
            ->where('university_id', $universityId)
            ->first();
        return is_null($department);
    }
}
