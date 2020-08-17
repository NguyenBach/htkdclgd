<?php

namespace Modules\GiangVien\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class OfficerByGender extends Model
{

    use LogsActivity;


    protected static $logAttributes = [
        'university_id',
        'year',
        'bien_che_nam',
        'bien_che_nu',
        'dai_han_nam',
        'dai_han_nu',
        'ngan_han_nam',
        'ngan_han_nu',
    ];

    protected $fillable = [
        'university_id',
        'year',
        'bien_che_nam',
        'bien_che_nu',
        'dai_han_nam',
        'dai_han_nu',
        'ngan_han_nam',
        'ngan_han_nu',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
