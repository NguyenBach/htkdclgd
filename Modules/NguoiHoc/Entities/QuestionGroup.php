<?php

namespace Modules\NguoiHoc\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionGroup extends Model
{
    protected $table = 'question_group';
    protected $fillable = [
        'description'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function questions()
    {
        return $this->hasMany(CauHoiTotNghiep::class, 'group_id', 'id');
    }
}
