<?php

namespace Modules\TuDanhGia\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;
use Spatie\Activitylog\Traits\LogsActivity;

class DanhMucMinhChung extends Model
{
    use LogsActivity;

    protected $table = 'danh_muc_minh_chung';

    protected $fillable = [
        'university_id',
        'file_url',
        'filename',
        'online_folder_url',
        'last_change',
        'updated_by'
    ];

    protected static $logAttributes = [
        'file_url',
        'filename',
        'online_folder_url',
        'last_change',
        'updated_by'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'university_id'
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
