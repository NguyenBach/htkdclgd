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
        'number',
        'year'
    ];

    protected static $logAttributes = [
        'name',
        'number',
        'year'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'slug'
    ];

    protected $casts = [
        'number' => "array"
    ];


    public static function checkExist($slug, $universityId, $year)
    {
        $faculty = self::where('slug', $slug)
            ->where('year', $year)
            ->where('university_id', $universityId)
            ->first();
        return !is_null($faculty);
    }
}
