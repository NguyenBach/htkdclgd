<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BieuMau extends Model
{
    use LogsActivity;

    protected $table = 'bieu_mau';
    protected $fillable = [
        'name',
        'file_path',
        'file_name',
        'created_by'
    ];

    protected static $logAttributes = [
        'name',
        'file_path',
        'file_name',
        'created_by'
    ];
}
