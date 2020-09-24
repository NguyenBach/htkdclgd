<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Entities\User;

class BaoCaoBaCongKhai extends Model
{
    protected $table = 'bao_cao_ba_cong_khai';

    protected $fillable = [
        'university_id',
        'user_id',
        'filename',
        'submitted_at'
    ];

    protected $appends = [
        'file_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getFileUrlAttribute()
    {
        return Storage::disk('public')->url($this->filename);
    }
}
