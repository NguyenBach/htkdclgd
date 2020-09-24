<?php

namespace Modules\TuDanhGia\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;

class SubmitHistory extends Model
{
    protected $table = 'tu_danh_gia_submit_history';

    protected $fillable = [
        'university_id',
        'user_id',
        'submit_at',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
