<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;

class BaoCaoBaCongKhai extends Model
{
    protected $table = 'bao_cao_ba_cong_khai';

    protected $fillable = [
        'university_id',
        'user_id',
        'filename',
        'submitted_at'
    ];
}
