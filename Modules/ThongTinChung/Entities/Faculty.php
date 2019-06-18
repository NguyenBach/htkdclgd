<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = [
        'university_id',
        'name',
        'education_type_id',
        'number_education_program',
        'students',
        'slug'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'slug'
    ];

    public function educationType()
    {
        return $this->belongsTo(EducationType::class, 'education_type_id');
    }

    public static function checkExist($slug, $universityId, $educationType)
    {
        $faculty = self::where('slug', $slug)
            ->where('university_id', $universityId)
            ->where('education_type_id', $educationType)
            ->first();
        return !is_null($faculty);
    }
}
