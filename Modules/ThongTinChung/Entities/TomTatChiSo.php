<?php

namespace Modules\ThongTinChung\Entities;

use Illuminate\Database\Eloquent\Model;

class TomTatChiSo extends Model
{
    protected $table = 'tom_tat_chi_so';

    protected $fillable = [
        'university_id',
        'year',
        'tong_gv_co_huu',
        'tong_cb_co_huu',
        'ti_le_gv_cb',
        'ti_le_gv_ts',
        'ti_le_gv_ths',
        'tong_sv',
        'ti_le_sv_gv',
        'ti_le_tot_nghiep',
        'ti_le_tra_loi_duoc',
        'ti_le_tra_loi_1_phan',
        'ti_le_dung_nganh',
        'ti_le_trai_nganh',
        'ti_le_tu_tao',
        'thu_nhap_binh_quan',
        'ti_le_dap_ung_ngay',
        'ti_le_dao_tao_them',
        'ti_so_doanh_thu',
        'ti_le_de_tai_cb',
        'ti_so_sach_cb',
        'ti_so_tap_chi_cb',
        'ti_so_bai_bao_cb',
        'ti_so_dien_tich_sv',
        'ti_so_ktx_sv',
        'cap_co_so',
        'cap_ctdt',
        'do_tuoi_tb'
    ];

}
