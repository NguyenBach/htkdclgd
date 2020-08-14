<?php

namespace Modules\TuDanhGia\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\ThongTinChung\Entities\University;

class BaoCaoTuDanhGia extends Model
{
    protected $table = 'bao_cao_tu_danh_gia';

    protected $fillable = [
        'university_id',
        'file_path',
        'filename',
        'created_by',
        'file_comment',
        'file_comment_name',
        'commented_by'
    ];

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id', 'id');
    }
}
