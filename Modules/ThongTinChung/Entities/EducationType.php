<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;

class EducationType extends Model
{
    protected $fillable = [
        'university_id',
        'name',
        'slug'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'university_id'
    ];

    public static function checkExist($slug, $universityId)
    {
        $department = self::where('slug', $slug)
            ->where('university_id', $universityId)
            ->first();
        return is_null($department);
    }
}
