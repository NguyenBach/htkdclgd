<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
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
}
