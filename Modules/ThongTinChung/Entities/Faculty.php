<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Faculty extends Model
{
    use LogsActivity;

    protected $fillable = [
        'university_id',
        'name',
        'slug',
        'number'
    ];

    protected static $logAttributes = [
        'name',
        'number'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'slug'
    ];

    protected $casts = [
        'number' => "array"
    ];


    public static function checkExist($slug, $universityId)
    {
        $faculty = self::where('slug', $slug)
            ->where('university_id', $universityId)
            ->first();
        return !is_null($faculty);
    }
}
