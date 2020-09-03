<?php

namespace Modules\CoSoVatChat\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ThietBi extends Model
{
    use LogsActivity;

    protected $table = 'thiet_bi';

    protected $fillable = [
        'university_id',
        'year',
        'name',
        'so_luong',
        'doi_tuong',
        'dien_tich',
        'hinh_thuc',
    ];

    protected static $logAttributes = [
        'university_id',
        'year',
        'name',
        'so_luong',
        'doi_tuong',
        'dien_tich',
        'hinh_thuc',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function danh_muc_trang_thiet_bi(){
        return $this->belongsToMany(TrangThietBi::class,'danh_muc_trang_thiet_bi');
    }
}
