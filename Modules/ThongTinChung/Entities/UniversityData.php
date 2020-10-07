<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Entities\User;
use Modules\TuDanhGia\Entities\DanhGiaNgoai;
use Modules\TuDanhGia\Entities\TuDanhGia;
use Spatie\Activitylog\Traits\LogsActivity;

class UniversityData extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected static $logAttributes = [
        "name_vi",
        "name_en",
        "short_name_vi",
        "short_name_en",
        "name_before",
        "governing_body",
        "address",
        "phone_number",
        "fax_number",
        "email",
        "website",
        "founded_year",
        "k1_start_date",
        "k1_end_date",
        "institution_type",
        "institution_type_other",
        "training_type",
        "training_type_other"
    ];
    protected $fillable = [
        'university_id',
        'year',
        "name_vi",
        "name_en",
        "short_name_vi",
        "short_name_en",
        "name_before",
        "governing_body",
        "address",
        "phone_number",
        "fax_number",
        "email",
        "website",
        "founded_year",
        "k1_start_date",
        "k1_end_date",
        "institution_type",
        "institution_type_other",
        "training_type",
        "training_type_other"
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $appends = [
        'loai_hinh'
    ];

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

}
