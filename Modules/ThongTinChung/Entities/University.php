<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Entities\User;
use Modules\TuDanhGia\Entities\DanhGiaNgoai;
use Modules\TuDanhGia\Entities\TuDanhGia;
use Spatie\Activitylog\Traits\LogsActivity;

class University extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        "name_vi",
        "governing_body",
        "institution_type",
        "institution_type_other"
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static $logAttributes = [
        "name_vi",
        "governing_body",
        "institution_type",
    ];
    protected $appends = [
        'loai_hinh'
    ];

    public function tuDanhgia()
    {
        return $this->hasMany(TuDanhGia::class, 'university_id');
    }

    public function danhGiaNgoai()
    {
        return $this->hasMany(DanhGiaNgoai::class, 'university_id');
    }

    public function getLoaiHinhAttribute()
    {
        switch ($this->institution_type) {
            case 1:
                return "Công lập";
            case 2:
                return "Bán công";
            case 3:
                return "Dân lập";
            case 4:
                return "Tư thục";
            case 5:
                return $this->institution_type_other;
            default:
                return '';
        }
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function data()
    {
        return $this->hasMany(UniversityData::class);
    }

}
