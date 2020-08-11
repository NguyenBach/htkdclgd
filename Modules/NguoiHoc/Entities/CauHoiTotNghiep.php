<?php

namespace Modules\NguoiHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class CauHoiTotNghiep extends Model
{
    protected $table = 'cau_hoi_tot_nghiep';

    protected $fillable = [
        'name',
        'group_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function group()
    {
        return $this->belongsTo(QuestionGroup::class, 'group_id');
    }
}
