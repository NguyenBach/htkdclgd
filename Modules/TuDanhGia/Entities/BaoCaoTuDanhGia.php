<?php

namespace Modules\TuDanhGia\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\ThongTinChung\Entities\University;
use Spatie\Activitylog\Traits\LogsActivity;

class BaoCaoTuDanhGia extends Model
{
    use LogsActivity;

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

    protected static $logAttributes = [
        'file_path',
        'filename',
        'file_comment',
        'file_comment_name',
    ];


    public function university()
    {
        return $this->belongsTo(University::class, 'university_id', 'id');
    }
}
