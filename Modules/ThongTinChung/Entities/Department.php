<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

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
        return is_null($department);
    }
}
