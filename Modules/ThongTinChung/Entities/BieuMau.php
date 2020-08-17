<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;

class BieuMau extends Model
{
    protected $table = 'bieu_mau';
    protected $fillable = [
        'name',
        'file_path',
        'file_name',
        'created_by'
    ];
}
