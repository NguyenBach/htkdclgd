<?php

namespace Modules\NguoiHoc\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class QuestionGroup extends Model
{
    use LogsActivity;

    protected $table = 'question_group';
    protected $fillable = [
        'description'
    ];

    protected static $logAttributes = [
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
