<?php


namespace Modules\ThongTinChung\Helpers;

use Illuminate\Support\Facades\Storage;
use Modules\CoSoVatChat\Entities\DienTich;
use Modules\CoSoVatChat\Entities\NhomNganh;
use Modules\CoSoVatChat\Entities\SachThuVien;
use Modules\CoSoVatChat\Entities\ThietBi;
use Modules\CoSoVatChat\Entities\ThuChi;
use Modules\GiangVien\Entities\Lecturer;
use Modules\GiangVien\Entities\LecturerByAge;
use Modules\GiangVien\Entities\LecturerByDegree;
use Modules\GiangVien\Entities\LecturerByFl;
use Modules\GiangVien\Entities\Officer;
use Modules\GiangVien\Entities\OfficerByGender;
use Modules\KiemDinhChatLuong\Entities\KiemDinhChatLuong;
use Modules\NghienCuuKhoaHoc\Entities\BangSangChe;
use Modules\NghienCuuKhoaHoc\Entities\BaoCaoHoiThao;
use Modules\NghienCuuKhoaHoc\Entities\CanBoHoiThao;
use Modules\NghienCuuKhoaHoc\Entities\CanBoNCKH;
use Modules\NghienCuuKhoaHoc\Entities\CanBoSach;
use Modules\NghienCuuKhoaHoc\Entities\CanBoTapChi;
use Modules\NghienCuuKhoaHoc\Entities\DoanhThuNCKH;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongNCKH;
use Modules\NghienCuuKhoaHoc\Entities\SoLuongSach;
use Modules\NghienCuuKhoaHoc\Entities\SvNCKH;
use Modules\NghienCuuKhoaHoc\Entities\TapChiDuocDang;
use Modules\NghienCuuKhoaHoc\Entities\ThanhTich;
use Modules\NguoiHoc\Entities\NguoiHocTotNghiep;
use Modules\NguoiHoc\Entities\SvKtx;
use Modules\NguoiHoc\Entities\SvNhapHoc;
use Modules\NguoiHoc\Entities\SvThamGiaNCKH;
use Modules\NguoiHoc\Entities\TinhTrangSvTotNghiep;
use Modules\ThongTinChung\Entities\Branch;
use Modules\ThongTinChung\Entities\EducationType;
use Modules\ThongTinChung\Entities\Faculty;
use Modules\ThongTinChung\Entities\KeyOfficer;
use Modules\ThongTinChung\Entities\TomTatChiSo;
use Modules\ThongTinChung\Entities\University;
use Modules\ThongTinChung\Entities\UniversityData;
use NumberFormatter;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\TextAlignment;

class ExportHelper
{
    /**
     * @var PhpWord $phpWord
     */
    private $phpWord;

    /**
     * @var Section $section
     */
    private $section;

    public function __construct()
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(13);
        $phpWord->addParagraphStyle('center', ['alignment' => Jc::CENTER]);
        $phpWord = $this->setupTableStyle($phpWord);
        $this->phpWord = $phpWord;
        $this->section = $this->phpWord->addSection();
    }

    public function setupTableStyle($phpWord)
    {
        $whiteTableBorder = [
            'borderColor' => 'ffffff',
            'borderSize' => 0,
            'cellMargin' => 50,
            'valign' => 'center'
        ];
        $phpWord->addTableStyle('whiteTableBorder', $whiteTableBorder);

        $defaultTable = [
            'borderColor' => '000000',
            'borderSize' => 5,
            'cellMargin' => 50,
            'valign' => 'center',
            'alignment' => Jc::CENTER
        ];
        $defaultTableFirstRow = [
            'borderBottomSize' => 18,
            'borderBottomColor' => '000000',
            'bgColor' => '000000',
            'alignment' => Jc::CENTER,
            'textAlignment' => TextAlignment::CENTER
        ];
        $phpWord->addTableStyle('defaultTable', $defaultTable, $defaultTableFirstRow);
        return $phpWord;
    }

    public function export($universityId, $year)
    {
        $this->header();
        $this->paragraphTitle('I', 'Thông tin chung về cơ sở giáo dục');
        $university = University::find($universityId);
        $fillable = (new UniversityData)->getFillable();
        $data = $university->data()->where('year', $year)->first();
        foreach ($fillable as $key) {
            if (in_array($key, $university->getFillable())) {
                continue;
            }

            if (isset($data->{$key})) {
                $university->{$key} = $data->{$key};
            } else {
                $university->{$key} = '';
            }
        }
        $this->report1($university->name_vi, $university->name_en);
        $this->report2($university->short_name_vi, $university->short_name_en);
        $this->report3();
        $this->report4($university->governing_body);
        $this->report5($university->address);
        $this->report6($university->phone_number, $university->fax_number, $university->email, $university->website);
        $this->report7($university->founded_year);
        $this->report8($university->k1_start_date);
        $this->report9($university->k1_end_date);
        $this->report10($university->institution_type, $university->institution_type_other);
        $this->report11(json_decode($university->training_type, true), $university->training_type_other);

        $keyOfficers = KeyOfficer::where('university_id', $universityId)->get();
        $this->report12($keyOfficers);

        $faculties = Faculty::where('university_id', $universityId)->get();
        $educationType = EducationType::where('university_id', $universityId)->get();
        $this->report13($faculties, $educationType);

        $branches = Branch::where('university_id', $universityId)->get();
        $this->report14($branches);

        $additionText = "CSGD cần có cơ sở dữ liệu về cán bộ, giảng viên1, nhân viên của mình, bao gồm cả cơ hữu và hợp đồng ngắn hạn. Từ cơ sở dữ liệu lấy ra các thông tin dưới đây
        (Thống kê mỗi loại gồm 5 bảng tương ứng với 5 năm của giai đoạn đánh giá):";
        $this->paragraphTitle('II', 'Cán bộ, giảng viên, nhân viên', $additionText);

        $giangVien = Lecturer::where('university_id', $universityId)->whereBetween('year', [$year - 5, $year])->get();
        $this->report15($giangVien, $year);

        $officers = Officer::where('university_id', $universityId)->whereBetween('year', [$year - 5, $year])->get();
        $this->report16($officers, $year);

        $officerGenders = OfficerByGender::where('university_id', $universityId)->whereBetween('year', [$year - 5, $year])->get();
        $this->report17($officerGenders, $year);

        $lectureByDegree = LecturerByDegree::where('university_id', $universityId)->whereBetween('year', [$year - 5, $year])->get();
        $this->report18($lectureByDegree, $year, $universityId);

        $lecturerByAge = LecturerByAge::where('university_id', $universityId)->whereBetween('year', [$year - 5, $year])->get();
        $this->report19($lecturerByAge, $year, $universityId);

        $lecturerByFl = LecturerByFl::where('university_id', $universityId)->whereBetween('year', [$year - 5, $year])->get();
        $this->report20($lecturerByFl, $year);

        $additionText = "Người học bao gồm sinh viên, học sinh, học viên cao học và nghiên cứu sinh:";
        $this->paragraphTitle('III', 'Người học', $additionText);

        $svNhapHocChinhQuy = SvNhapHoc::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])->where('he_hoc', 1)
            ->get();
        $this->report21($svNhapHocChinhQuy, $year, $universityId);

        $svNhapHocKoChinhQuy = SvNhapHoc::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])->where('he_hoc', 0)
            ->get();
        $this->report22($svNhapHocKoChinhQuy, $year);

        $svKyTuc = SvKtx::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])->get();
        $this->report23($svKyTuc, $year);

        $svNckh = SvThamGiaNCKH::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])->get();
        $this->report24($svNckh, $year);

        $svTotNghiep = NguoiHocTotNghiep::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])->get();
        $this->report25($svTotNghiep, $year);

        $tinhTrangTotNghiepDaiHoc = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('he_hoc', 1)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report26($tinhTrangTotNghiepDaiHoc, $year);

        $tinhTrangTotNghiepCaoDang = TinhTrangSvTotNghiep::where('university_id', $universityId)
            ->where('he_hoc', 0)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report27($tinhTrangTotNghiepCaoDang, $year);

        $this->paragraphTitle('IV', 'Nghiên cứu khoa học và chuyển giao công nghệ');

        $slNckh = SoLuongNCKH::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report28($slNckh, $year, $universityId);

        $doanhThu = DoanhThuNCKH::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report29($doanhThu, $year);

        $canBoNCKH = CanBoNCKH::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report30($canBoNCKH, $year);

        $slSachXuatBan = SoLuongSach::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report31($slSachXuatBan, $year);

        $canBoSach = CanBoSach::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report32($canBoSach, $year);

        $tapChi = TapChiDuocDang::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report33($tapChi, $year);

        $canBoTapChi = CanBoTapChi::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report34($canBoTapChi, $year);

        $baoCaoHoiThao = BaoCaoHoiThao::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report35($baoCaoHoiThao, $year, $universityId);

        $canBoHoiThao = CanBoHoiThao::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report36($canBoHoiThao, $year);

        $sangChe = BangSangChe::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report37($sangChe, $year);

        $svNCKH = SvNCKH::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report351($svNCKH, $year);

        $thanhTich = ThanhTich::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report352($thanhTich, $year);

        $this->paragraphTitle('V', 'Cơ sở vật chất, thư viện, tài chính');

        $dienTich = DienTich::where('year', $year)
            ->where('university_id', $universityId)
            ->get();
        $this->report38($dienTich);

        $nhomNganh = NhomNganh::get();
        $thuVien = SachThuVien::where('university_id', $universityId)
            ->where('year', $year)->get();
        $this->report39($thuVien, $nhomNganh);

        $thietBi = ThietBi::where('university_id', $universityId)
            ->with('danh_muc_trang_thiet_bi')
            ->get();
        $this->report40($thietBi);

        $thuChi = ThuChi::where('university_id', $universityId)
            ->whereBetween('year', [$year - 5, $year])
            ->get();
        $this->report41($thuChi, $year);
        $this->report42($thuChi, $year);
        $this->report43($thuChi, $year);
        $this->report44($thuChi, $year);
        $this->report45($thuChi, $year);
        $this->report46($thuChi, $year);
        $this->report47($thuChi, $year);

        $this->paragraphTitle('VI', 'Kết quả kiểm định chất lượng giáo dục');

        $kiemDinh = KiemDinhChatLuong::where('university_id', $universityId)->get();
        $this->report48($kiemDinh);

        $this->paragraphTitle('VII', "VII. Tóm tắt một số chỉ số quan trọng");
        $tomTat = TomTatChiSo::where('university_id', $universityId)->where('year', $year)->first();
        $this->tomTatChiSo($tomTat);

        $filename = 'csdl_' . $university->short_name_vi . '_' . date('Y_m_d') . "_" . time() . '.docx';
        $path = 'export_csdl';
        $filePath = Storage::disk('public')->path($path);
        if (!file_exists($filePath)) {
            mkdir($filePath);
        }
        $objWriter = IOFactory::createWriter($this->phpWord, 'Word2007');
        $objWriter->save($filePath . DIRECTORY_SEPARATOR . $filename);
        return $path . DIRECTORY_SEPARATOR . $filename;
    }

    public function header($reportDate = '')
    {
        if (!$reportDate) {
            $reportDate = date('d/m/Y');
        }

        $line1 = 'CƠ SỞ DỮ LIỆU ';
        $line2 = 'KIỂM ĐỊNH CHẤT LƯỢNG CƠ SỞ GIÁO DỤC';
        $line3 = 'Thời điểm báo cáo: Tính đến ngày ' . $reportDate;
        $fontStyle = [
            'allCaps' => true,
            'bold' => true,
        ];
        $paragraphStyle = [
            'alignment' => Jc::CENTER
        ];
        $this->section->addText($line1, $fontStyle, $paragraphStyle);
        $this->section->addText($line2, $fontStyle, $paragraphStyle);
        $this->section->addText($line3, [], $paragraphStyle);
        return $this->section;
    }

    public function paragraphTitle($order, $title, $additionText = '')
    {
        $text = $order . '. ' . $title;
        $fontStyle = [
            'bold' => true,
        ];
        $this->section->addText($text, $fontStyle, ['keepNext' => true]);
        if ($additionText) {
            $this->section->addText($additionText, [], ['indentation' => ['firstLine' => 1000]]);
        }
        return $this->section;
    }

    public function report1($vietnameseName, $englishName)
    {
        $line1 = '1. Tên cơ sở giáo dục (theo quyết định thành lập):';
        $line2 = 'Tiếng Việt: ' . $vietnameseName;
        $line3 = 'Tiếng Anh: ' . $englishName;
        $this->section->addText($line1);
        $this->section->addText($line2, [], ["indent" => true]);
        $this->section->addText($line3, [], ["indent" => true]);
        return $this->section;
    }

    public function report2($vietnameseShortName, $englishShortName)
    {
        $line1 = '2. Tên viết tắt của cơ sở giáo dục:';
        $line2 = 'Tiếng Việt: ' . $vietnameseShortName;
        $line3 = 'Tiếng Anh: ' . $englishShortName;
        $this->section->addText($line1);
        $this->section->addText($line2, [], ["indent" => true]);
        $this->section->addText($line3, [], ["indent" => true]);
        return $this->section;
    }

    public function report3($nameBefore = '')
    {
        if (!$nameBefore) {
            $nameBefore = '................';
        }
        $line1 = '3. Tên trước đây (nếu có): ' . $nameBefore;
        $this->section->addText($line1);
        return $this->section;
    }

    public function report4($governingBody)
    {
        $line1 = '4. Cơ quan/Bộ chủ quản: ' . $governingBody;
        $this->section->addText($line1);
        return $this->section;
    }

    public function report5($address)
    {
        $line1 = '5. Địa chỉ: ' . $address;
        $this->section->addText($line1);
        return $this->section;
    }

    public function report6($phoneNumber, $faxNumber, $email, $website)
    {
        $line1 = '6. Thông tin liên hệ: Điện thoại ' . $phoneNumber . '        Số fax ' . $faxNumber;
        $line2 = 'E-mail ' . $email . '           Website ' . $website;
        $this->section->addText($line1);
        $this->section->addText($line2, [], ['indent' => true]);
        return $this->section;
    }

    public function report7($foundedYear)
    {
        $line1 = '7. Năm thành lập (theo quyết định thành lập): ' . $foundedYear;
        $this->section->addText($line1);
        return $this->section;
    }

    public function report8($startDate)
    {
        $line1 = '8. Thời gian bắt đầu đào tạo khóa I: ' . date('Y', strtotime($startDate));
        $this->section->addText($line1);
        return $this->section;
    }

    public function report9($endDate)
    {
        $line1 = '9. Thời gian cấp bằng tốt nghiệp cho khoá I: ' . date('Y', strtotime($endDate));
        $this->section->addText($line1);
        return $this->section;
    }

    public function report10($institutionType, $other = '')
    {
        if (!$other) {
            $other = '..............';
        }
        $congLap = $institutionType == 1 ? 1 : 0;
        $banCong = $institutionType == 2 ? 1 : 0;
        $danLap = $institutionType == 3 ? 1 : 0;
        $tuThuc = $institutionType == 4 ? 1 : 0;

        $line1 = '10. Loại hình cơ sở giáo dục: ';
        $this->section->addText($line1);
        $textRun = $this->section->addTextRun();
        $textRun->addText('Công lập ', [], ['indent' => true]);
        $textRun->addFormField('checkbox')->setDefault($congLap);
        $textRun->addText('Bán công ');
        $textRun->addFormField('checkbox')->setDefault($banCong);
        $textRun->addText('Dân lập ');
        $textRun->addFormField('checkbox')->setDefault($danLap);
        $textRun->addText('Tư thục ');
        $textRun->addFormField('checkbox')->setDefault($tuThuc);
        $line2 = 'Loại hình khác: ' . $other;
        $this->section->addText($line2, [], ['indent' => true]);
        return $this->section;
    }

    public function report11($trainingType, $other = '')
    {
        if (!$trainingType) {
            $trainingType = [];
        }
        $chinhQuy = in_array(1, $trainingType) ? 1 : 0;
        $khongChinhQuy = in_array(2, $trainingType) ? 1 : 0;
        $tuXa = in_array(3, $trainingType) ? 1 : 0;
        $nuocNgoai = in_array(4, $trainingType) ? 1 : 0;
        $trongNuoc = in_array(5, $trainingType) ? 1 : 0;
        if (!$other) {
            $other = '.............';
        }
        $line1 = '11. Các loại hình đào tạo của cơ sở giáo dục: ';
        $this->section->addText($line1);
        $table = $this->section->addTable('whiteTableBorder');
        $table->addRow(500);
        $table->addCell(4000)->addText('');
        $table->addCell(2000)->addText('Có');
        $table->addCell(2000)->addText("Không");

        $table->addRow(500);
        $table->addCell(4000)->addText('Chính quy');
        $table->addCell(2000)->addFormField('checkbox')->setDefault($chinhQuy);
        $table->addCell(2000)->addFormField('checkbox')->setDefault(!$chinhQuy);

        $table->addRow(500);
        $table->addCell(4000)->addText('Không chính quy ');
        $table->addCell(2000)->addFormField('checkbox')->setDefault($khongChinhQuy);
        $table->addCell(2000)->addFormField('checkbox')->setDefault(!$khongChinhQuy);

        $table->addRow(500);
        $table->addCell(4000)->addText('Từ xa ');
        $table->addCell(2000)->addFormField('checkbox')->setDefault($tuXa);
        $table->addCell(2000)->addFormField('checkbox')->setDefault(!$tuXa);

        $table->addRow(500);
        $table->addCell(4000)->addText('Liên kết đào tạo với nước ngoài ');
        $table->addCell(2000)->addFormField('checkbox')->setDefault($nuocNgoai);
        $table->addCell(2000)->addFormField('checkbox')->setDefault(!$nuocNgoai);

        $table->addRow(500);
        $table->addCell(4000)->addText('Liên kết đào tạo trong nước  ');
        $table->addCell(2000)->addFormField('checkbox')->setDefault($trongNuoc);
        $table->addCell(2000)->addFormField('checkbox')->setDefault(!$trongNuoc);

        $line2 = 'Các loại hình đào tạo khác: ' . implode(", ", json_decode($other));
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report12($canBo = [])
    {
        $line1 = '12. Danh sách cán bộ lãnh đạo chủ chốt của CSGD: ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');
        $center = ['textAlignment' => Jc::CENTER];

        $table->addRow(500);
        $table->addCell(2000)->addText("Các đơn vị \n\r (bộ phận)", ['bold' => true], 'center');
        $table->addCell(2000)->addText('Họ và tên', ['bold' => true], "center");
        $table->addCell(2000)->addText('Chức danh, học vị, chức vụ', ['bold' => true], "center");
        $table->addCell(2000)->addText('Điện thoại', ['bold' => true], "center");
        $table->addCell(2000)->addText('E-mail', ['bold' => true], "center");

        foreach ($canBo as $item) {
            $table->addRow(500);
            $table->addCell(2000)->addText($item->department->name);
            $table->addCell(2000)->addText($item->fullname);
            $table->addCell(2000)->addText($item->degree . ', ' . $item->position);
            $table->addCell(2000)->addText($item->phone_number);
            $table->addCell(2000)->addText($item->email);
        }
    }

    public function report13($khoa = [], $educationType = [])
    {
        $line1 = '13. Các khoa/viện đào tạo của CSGD: ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');
        $bold = ['bold' => true];
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');

        $table->addRow();
        $table->addCell(2500, $cellRowSpan)->addText('Khoa/viện đào tạo', $bold, 'center');
        foreach ($educationType as $type) {
            $table->addCell(2500, $cellColSpan)->addText($type->name, $bold, 'center');
        }

        $table->addRow();
        $table->addCell(2500, $cellRowContinue);
        foreach ($educationType as $type) {
            $table->addCell(1250)->addText('Số CTĐT', $bold, 'center');
            $table->addCell(1250)->addText('Số sinh viên', $bold, 'center');
        }

        foreach ($khoa as $item) {
            $table->addRow();
            $table->addCell(2500)->addText($item->name);
            $number = collect($item->number);
            foreach ($educationType as $type) {
                $sl = $number->where('education_type_id', $type->id)->first();
                if (!$sl) {
                    $sl = [];
                    $sl['number_education_program'] = 0;
                    $sl['student'] = 0;
                }
                $table->addCell(1250)->addText($sl['number_education_program']);
                $table->addCell(1250)->addText($sl['student']);
            }
        }
    }

    public function report14($donVi = [])
    {
        $line1 = '14. Danh sách đơn vị trực thuộc (bao gồm các trung tâm nghiên cứu, chi nhánh/cơ sở của các đơn vị): ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(550)->addText('TT', ['bold' => true], 'center');
        $table->addCell(3000)->addText('Tên đơn vị', ['bold' => true], 'center');
        $table->addCell(1000)->addText('Năm thành lập ', ['bold' => true], 'center');
        $table->addCell(3000)->addText('Lĩnh vực  hoạt động', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Số lượng nghiên cứu viên', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Số lượng cán bộ/nhân viên', ['bold' => true], 'center');

        foreach ($donVi as $key => $item) {
            $table->addRow(500);
            $table->addCell(500)->addText($key + 1);
            $table->addCell(3000)->addText($item->name);
            $table->addCell(1000)->addText($item->founded_year);
            $table->addCell(3000)->addText($item->field);
            $table->addCell(1250)->addText($item->number_researcher);
            $table->addCell(1250)->addText($item->number_officer);
        }
    }

    public function report15($giangVien = [], $year = 0)
    {
        $line1 = '15. Thống kê số lượng giảng viên và nghiên cứu viên: ';
        $this->section->addText($line1);

        $bold = ['bold' => true, 'alignment' => Jc::CENTER, 'textAlignment' => TextAlignment::CENTER];
        $paragraph = ['alignment' => Jc::CENTER, 'textAlignment' => TextAlignment::CENTER];
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $currentData = $giangVien->where('year', $currentYear);

            $table = $this->section->addTable('defaultTable');
            $table->addRow();
            $table->addCell(4000, $cellRowSpan)->addText('Phân cấp giảng viên và nghiên cứu viên', $bold, $paragraph);
            $table->addCell(3000, $cellColSpan)->addText('Cơ hữu/toàn thời gian', $bold, $paragraph);
            $table->addCell(3000, $cellColSpan)->addText('Hợp đồng/ thỉnh giảng', $bold, $paragraph);

            $table->addRow();
            $table->addCell(4000, $cellRowContinue);
            $table->addCell(1500)->addText('Số lượng ', $bold);
            $table->addCell(1500)->addText('Tiến sĩ (%)', $bold);
            $table->addCell(1500)->addText('Số lượng ', $bold);
            $table->addCell(1500)->addText('Tiến sĩ (%)', $bold);

            $table->addRow();
            $gv = $currentData->where('lecturer_type', 1)->first();
            if (!$gv) {
                $gv = new \stdClass();
                $gv->total_1 = 0;
                $gv->percent_doctor_1 = 0;
                $gv->total_2 = 0;
                $gv->percent_doctor_2 = 0;
            }
            $table->addCell(4000)->addText('Giảng viên');
            $table->addCell(1500)->addText($gv->total_1);
            $table->addCell(1500)->addText($gv->percent_doctor_1);
            $table->addCell(1500)->addText($gv->total_2);
            $table->addCell(1500)->addText($gv->percent_doctor_2);

            $table->addRow();
            $tg = $currentData->where('lecturer_type', 2)->first();
            if (!$tg) {
                $tg = new \stdClass();
                $tg->total_1 = 0;
                $tg->percent_doctor_1 = 0;
                $tg->total_2 = 0;
                $tg->percent_doctor_2 = 0;
            }
            $table->addCell(4000)->addText('Nghiên cứu viên');
            $table->addCell(1500)->addText($tg->total_1);
            $table->addCell(1500)->addText($tg->percent_doctor_1);
            $table->addCell(1500)->addText($tg->total_2);
            $table->addCell(1500)->addText($tg->percent_doctor_2);

            $table->addRow(500, $bold);
            $table->addCell(4000)->addText('Tổng', $bold);
            $table->addCell(1500)->addText($gv->total_1 + $tg->total_1, $bold);
            $table->addCell(1500)->addText('0', $bold);
            $table->addCell(1500)->addText($gv->total_2 + $tg->total_2, $bold);
            $table->addCell(1500)->addText('0', $bold);
            $this->section->addTextBreak(1);
        }


    }

    public function report16($canBo, $year)
    {
        $line1 = '16. Thống kê số lượng cán bộ quản lý, nhân viên: ';
        $this->section->addText($line1);

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $currentData = $canBo->where('year', $currentYear)->first();
            if (!$currentData) {
                $currentData = new \stdClass();
                $currentData->quan_ly_co_huu = 0;
                $currentData->nhan_vien_co_huu = 0;
                $currentData->quan_ly_hop_dong = 0;
                $currentData->nhan_vien_hop_dong = 0;
            }

            $table = $this->section->addTable('defaultTable');
            $bold = ['bold' => true];
            $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
            $cellRowContinue = array('vMerge' => 'continue');
            $cellColSpan = array('gridSpan' => 3, 'valign' => 'center');

            $table->addRow();
            $table->addCell(4000, $cellRowSpan)->addText('Phân cấp cán bộ, nhân viên', $bold, 'center');
            $table->addCell(6000, $cellColSpan)->addText('Số lượng ', $bold, 'center');

            $table->addRow();
            $table->addCell(4000, $cellRowContinue);
            $table->addCell(2000)->addText('Cơ hữu/toàn thời gian', $bold, 'center');
            $table->addCell(2000)->addText('Hợp đồng bán thời gian', $bold, 'center');
            $table->addCell(2000)->addText('Tổng số', $bold, 'center');

            $table->addRow();
            $table->addCell(4000)->addText('Cán bộ quản lý');
            $table->addCell(1500)->addText($currentData->quan_ly_co_huu);
            $table->addCell(1500)->addText($currentData->quan_ly_hop_dong);
            $table->addCell(1500)->addText($currentData->quan_ly_hop_dong + $currentData->quan_ly_co_huu);

            $table->addRow();
            $table->addCell(4000)->addText('Nhân viên');
            $table->addCell(1500)->addText($currentData->nhan_vien_co_huu);
            $table->addCell(1500)->addText($currentData->nhan_vien_hop_dong);
            $table->addCell(1500)->addText($currentData->nhan_vien_hop_dong + $currentData->nhan_vien_co_huu);

            $table->addRow();
            $table->addCell(4000)->addText('Tổng', $bold);
            $table->addCell(1500)->addText($currentData->nhan_vien_co_huu + $currentData->quan_ly_co_huu, $bold);
            $table->addCell(1500)->addText($currentData->nhan_vien_hop_dong + $currentData->quan_ly_hop_dong, $bold);
            $table->addCell(1500)->addText($currentData->nhan_vien_co_huu + $currentData->quan_ly_co_huu +
                $currentData->nhan_vien_hop_dong + $currentData->quan_ly_hop_dong, $bold);
            $this->section->addTextBreak(1);
        }
    }

    public function report17($canBoGioiTinh, $year)
    {
        $line1 = '17. Thống kê số lượng cán bộ, giảng viên và nhân viên (gọi chung là cán bộ) của CSGD theo giới tính: ';
        $this->section->addText($line1);
        $bold = ['bold' => true];

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $currentData = $canBoGioiTinh->where('year', $currentYear)->first();

            if (!$currentData) {
                $currentData = new \stdClass();
                $currentData->bien_che_nam = 0;
                $currentData->bien_che_nu = 0;
                $currentData->dai_han_nam = 0;
                $currentData->dai_han_nu = 0;
                $currentData->ngan_han_nam = 0;
                $currentData->ngan_han_nu = 0;
            }

            $table = $this->section->addTable('defaultTable');
            $table->addRow(500);
            $table->addCell(500)->addText('TT', $bold, 'center');
            $table->addCell(5000)->addText('Phân loại', $bold, 'center');
            $table->addCell(1500)->addText('Nam ', $bold, 'center');
            $table->addCell(1500)->addText('Nữ', $bold, 'center');
            $table->addCell(1500)->addText('Tổng số', $bold, 'center');

            $table->addRow(500);
            $table->addCell(500)->addText('I');
            $cell = $table->addCell(5000);
            $cell->addText('Cán bộ cơ hữu', $bold);
            $cell->addText('Trong đó:');
            $table->addCell(1500)->addText('');
            $table->addCell(1500)->addText('');
            $table->addCell(1500)->addText('');

            $table->addRow(500);
            $table->addCell(500)->addText('I.1');
            $table->addCell(5000)->addText('Cán bộ được tuyển dụng, sử dụng và quản lý theo các quy định của pháp luật về viên chức (trong biên chế)');
            $table->addCell(1500)->addText($currentData->bien_che_nam);
            $table->addCell(1500)->addText($currentData->bien_che_nu);
            $table->addCell(1500)->addText($currentData->bien_che_nam + $currentData->bien_che_nu);

            $table->addRow(500);
            $table->addCell(500)->addText('I.2');
            $table->addCell(5000)->addText('Cán bộ hợp đồng có thời hạn 3 năm và hợp đồng không xác định thời hạn (hợp đồng dài hạn)');
            $table->addCell(1500)->addText($currentData->dai_han_nam);
            $table->addCell(1500)->addText($currentData->dai_han_nu);
            $table->addCell(1500)->addText($currentData->dai_han_nam + $currentData->dai_han_nu);

            $table->addRow(500);
            $table->addCell(500)->addText('II');
            $cell = $table->addCell(5000);
            $cell->addText('Các cán bộ khác ', $bold);
            $cell->addText('Cán bộ hợp đồng ngắn hạn, bao gồm cả giảng viên thỉnh giảng ');
            $table->addCell(1500)->addText($currentData->ngan_han_nam);
            $table->addCell(1500)->addText($currentData->ngan_han_nu);
            $table->addCell(1500)->addText($currentData->ngan_han_nam + $currentData->ngan_han_nu);

            $table->addRow(500);
            $tong1 = $currentData->ngan_han_nam + $currentData->dai_han_nam + $currentData->bien_che_nam;
            $tong2 = $currentData->ngan_han_nu + $currentData->dai_han_nu + $currentData->bien_che_nu;
            $table->addCell(500)->addText('');
            $table->addCell(5000)->addText("Tổng cộng", $bold);
            $table->addCell(1500)->addText($tong1, $bold);
            $table->addCell(1500)->addText($tong2, $bold);
            $table->addCell(1500)->addText(intval($tong1 + $tong2), $bold);
            $this->section->addTextBreak(1);
        }


    }

    public function report18($giangVienTrinhDo, $year, $universityId = 0)
    {
        $line1 = '18. Thống kê, phân loại giảng viên theo trình độ: ';
        $this->section->addText($line1);
        $trinhDo = [
            'professor' => 'Giáo sư, Viện sĩ',
            'associate_professor' => 'Phó Giáo sư',
            'science_doctor' => 'Tiến sĩ khoa học',
            'doctor' => 'Tiến sĩ',
            'master' => 'Thạc sĩ',
            'undergraduate' => 'Đại học',
            'college' => 'Cao đẳng',
            'intermediate' => 'Trung cấp',
            'other' => 'Trình độ khác'
        ];

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $currentData = $giangVienTrinhDo->where('year', $currentYear);
            if (!$currentData) {
                $currentData = collect([]);
            }

            $table = $this->section->addTable('defaultTable');
            $table->addRow(500);
            $table->addCell(500)->addText('TT', ['bold' => true], 'center');
            $table->addCell(2000)->addText('Trình độ, học vị, chức danh', ['bold' => true], 'center');
            $table->addCell(1250)->addText('GV trong biên chế trực tiếp giảng dạy ', ['bold' => true], 'center');
            $table->addCell(1250)->addText('GV hợp đồng dài hạn trực tiếp giảng dạy', ['bold' => true], 'center');
            $table->addCell(1250)->addText('Giảng viên kiêm nhiệm là cán bộ quản lý', ['bold' => true], 'center');
            $table->addCell(1250)->addText('Giảng viên thỉnh giảng trong nước', ['bold' => true], 'center');
            $table->addCell(1250)->addText('Giảng viên thỉnh giảng quốc tế', ['bold' => true], 'center');
            $table->addCell(1250)->addText('Tổng số', ['bold' => true], 'center');

            $index = 1;
            $tong = [0, 0, 0, 0, 0, 0, 0];
            foreach ($trinhDo as $key => $value) {
                $table->addRow(500);
                $table->addCell(500)->addText($index);
                $table->addCell(2000)->addText($value);
                $sum = 0;
                for ($j = 1; $j < 6; $j++) {
                    $rowData = $currentData->where('lecturer_type', $j)->first();
                    if (!$rowData) {
                        $rowData = new \stdClass();
                        $rowData->$key = 0;
                    }
                    $table->addCell(1250)->addText($rowData->$key);
                    $sum += $rowData->$key;
                    $tong[$j] += $rowData->$key;
                }
                $index++;
                $table->addCell(1250)->addText($sum);
            }
            $table->addRow(500);
            $table->addCell(500)->addText('');
            $table->addCell(2000)->addText('Tổng cộng', ['bold' => true]);
            $table->addCell(1250)->addText($tong[1], ['bold' => true]);
            $table->addCell(1250)->addText($tong[2], ['bold' => true]);
            $table->addCell(1250)->addText($tong[3], ['bold' => true]);
            $table->addCell(1250)->addText($tong[4], ['bold' => true]);
            $table->addCell(1250)->addText($tong[5], ['bold' => true]);
            $table->addCell(1250)->addText(array_sum($tong), ['bold' => true]);

            $tongCoHuu = TomTat::tongGiangVienCoHuu($universityId, $currentYear);
            if (!$tongCoHuu) {
                $tongCoHuu = 0;
            }
            $line2 = "Tổng số giảng viên cơ hữu: {$tongCoHuu} người";
            $this->section->addText($line2, [], ['indent' => true]);
            $tile = TomTat::tongGianVienTrenTongCanBo($universityId, $year);
            $line3 = "Tỷ lệ giảng viên cơ hữu trên tổng số cán bộ cơ hữu: {$tile}";
            $this->section->addText($line3, [], ['indent' => true]);
        }


    }

    public function report19($giangVienDoTuoi, $year, $universityId = 0)
    {
        $line1 = '19. Thống kê, phân loại giảng viên cơ hữu theo độ tuổi (số người): ';
        $this->section->addText($line1);

        $trinhDo = [
            '1' => 'Giáo sư, Viện sĩ',
            '2' => 'Phó Giáo sư',
            '3' => 'Tiến sĩ khoa học',
            '4' => 'Tiến sĩ',
            '5' => 'Thạc sĩ',
            '6' => 'Đại học',
            '7' => 'Cao đẳng',
            '8' => 'Trung cấp',
            '9' => 'Trình độ khác'
        ];

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $giangVien = $giangVienDoTuoi->where('year', $currentYear);

            $table = $this->section->addTable('defaultTable');
            $bold = ['bold' => true];
            $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
            $cellRowContinue = array('vMerge' => 'continue');
            $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center');
            $cellColSpan5 = array('gridSpan' => 5, 'valign' => 'center');

            $table->addRow();
            $table->addCell(500, $cellRowSpan)->addText('TT', $bold, 'center');
            $table->addCell(2000, $cellRowSpan)->addText('Trình độ / học vị', $bold, 'center');
            $table->addCell(900, $cellRowSpan)->addText('Số lượng', $bold, 'center');
            $table->addCell(900, $cellRowSpan)->addText('Tỷ lệ (%)', $bold, 'center');
            $table->addCell(1300, $cellColSpan2)->addText('Phân loại theo giới tính', $bold, 'center');
            $table->addCell(4450, $cellColSpan5)->addText('Phân loại theo tuổi (người) ', $bold, 'center');

            $table->addRow();
            $table->addCell(500, $cellRowContinue);
            $table->addCell(2000, $cellRowContinue);
            $table->addCell(900, $cellRowContinue);
            $table->addCell(900, $cellRowContinue);
            $table->addCell(650)->addText('Nam', $bold, 'center');
            $table->addCell(650)->addText('Nữ', $bold, 'center');
            $table->addCell(900)->addText("dưới 30", $bold, 'center');
            $table->addCell(900)->addText('30-40', $bold, 'center');
            $table->addCell(900)->addText('41-50', $bold, 'center');
            $table->addCell(900)->addText('51-60', $bold, 'center');
            $table->addCell(850)->addText('trên 60', $bold, 'center');

            $tong['total'] = 0;
            $tong['percent'] = 0;
            $tong['lecturer_man'] = 0;
            $tong['lecturer_woman'] = 0;
            $tong['less_30'] = 0;
            $tong['less_40'] = 0;
            $tong['less_50'] = 0;
            $tong['less_60'] = 0;
            $tong['over_60'] = 0;

            foreach ($trinhDo as $key => $value) {
                $rowData = $giangVien->where('lecturer_degree', $key)->first();
                if (!$rowData) {
                    $rowData = new \stdClass();
                    $rowData->total = 0;
                    $rowData->percent = 0;
                    $rowData->lecturer_man = 0;
                    $rowData->lecturer_woman = 0;
                    $rowData->less_30 = 0;
                    $rowData->less_40 = 0;
                    $rowData->less_50 = 0;
                    $rowData->less_60 = 0;
                    $rowData->over_60 = 0;
                }
                $table->addRow();
                $table->addCell(500)->addText($key);
                $table->addCell(2000)->addText($value);
                $table->addCell(900)->addText($rowData->total);
                $table->addCell(900)->addText($rowData->percent);
                $table->addCell(650)->addText($rowData->lecturer_man);
                $table->addCell(650)->addText($rowData->lecturer_woman);
                $table->addCell(900)->addText($rowData->less_30);
                $table->addCell(900)->addText($rowData->less_40);
                $table->addCell(900)->addText($rowData->less_50);
                $table->addCell(900)->addText($rowData->less_60);
                $table->addCell(850)->addText($rowData->over_60);

                $tong['total'] += $rowData->total;
                $tong['percent'] += $rowData->percent;
                $tong['lecturer_man'] += $rowData->lecturer_man;
                $tong['lecturer_woman'] += $rowData->lecturer_woman;
                $tong['less_30'] += $rowData->less_30;
                $tong['less_40'] += $rowData->less_40;
                $tong['less_50'] += $rowData->less_50;
                $tong['less_60'] += $rowData->less_60;
                $tong['over_60'] += $rowData->over_60;
            }
            $table->addRow();
            $table->addCell(500)->addText('');
            $table->addCell(2000)->addText("Tổng cộng", $bold);
            $table->addCell(900)->addText($tong['total'], $bold);
            $table->addCell(900)->addText($tong['percent'], $bold);
            $table->addCell(650)->addText($tong['lecturer_man'], $bold);
            $table->addCell(650)->addText($tong['lecturer_woman'], $bold);
            $table->addCell(900)->addText($tong['less_30'], $bold);
            $table->addCell(900)->addText($tong['less_40'], $bold);
            $table->addCell(900)->addText($tong['less_50'], $bold);
            $table->addCell(900)->addText($tong['less_60'], $bold);
            $table->addCell(850)->addText($tong['over_60'], $bold);

            $doTuoi = TomTat::get($universityId, $year, 'do_tuoi_tb', 0);
            $line2 = "Độ tuổi trung bình của giảng viên cơ hữu: {$doTuoi} tuổi ";
            $this->section->addText($line2, [], ['indent' => true]);
            $tiLe = TomTat::tiLeGiangVienTienSi($universityId, $currentYear);
            $tiLe = $tiLe > 0 ? $tiLe : 0;
            $line2 = "Tỷ lệ giảng viên cơ hữu có trình độ tiến sĩ trở lên trên tổng số giảng viên cơ hữu của CSGD: {$tiLe} ";
            $this->section->addText($line2, [], ['indent' => true]);
            $tiLe = TomTat::tiLeGiangVienThacSi($universityId, $currentYear);
            $tiLe = $tiLe > 0 ? $tiLe : 0;
            $line2 = "Tỷ lệ giảng viên cơ hữu có trình độ thạc sĩ trên tổng số giảng viên cơ hữu của CSGD: {$tiLe}";
            $this->section->addText($line2, [], ['indent' => true]);
            $this->section->addTextBreak(1);
        }


    }

    public function report20($data, $year)
    {
        $line1 = '20. Thống kê, phân loại giảng viên cơ hữu theo mức độ thường xuyên sử dụng ngoại ngữ và tin học cho công tác giảng dạy và nghiên cứu: ';
        $this->section->addText($line1);
        $frequency = [
            1 => 'Luôn sử dụng (trên 80% thời gian của công việc)',
            2 => 'Thường sử dụng (trên 60-80% thời gian của công việc)',
            3 => 'Đôi khi sử dụng (trên 40-60% thời gian của công việc)',
            4 => 'Ít khi sử dụng (trên 20-40% thời gian của công việc)',
            5 => 'Hiếm khi sử dụng hoặc không sử dụng (0-20% thời gian của công việc)'
        ];

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $currentData = $data->where('year', $currentYear);

            $table = $this->section->addTable('defaultTable');
            $bold = ['bold' => true];
            $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
            $cellRowContinue = array('vMerge' => 'continue');
            $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center');

            $table->addRow();
            $table->addCell(500, $cellRowSpan)->addText('TT', $bold, 'center');
            $table->addCell(5500, $cellRowSpan)->addText('Tần suất sử dụng', $bold, 'center');
            $table->addCell(4000, $cellColSpan2)->addText('Tỷ lệ (%) giảng viên cơ hữu sử dụng ngoại ngữ và tin học', $bold, 'center');

            $table->addRow();
            $table->addCell(500, $cellRowContinue);
            $table->addCell(5500, $cellRowContinue);
            $table->addCell(2000)->addText('Ngoại ngữ', $bold, 'center');
            $table->addCell(2000)->addText('Tin học', $bold, 'center');

            foreach ($frequency as $key => $item) {
                $rowData = $currentData->where('frequency', $key)->first();
                if (!$rowData) {
                    $rowData = new \stdClass();
                    $rowData->foreign_language = 0;
                    $rowData->infomation_technology = 0;
                }
                $table->addRow();
                $table->addCell(500)->addText($key);
                $table->addCell(5500)->addText($item);
                $table->addCell(2000)->addText($rowData->foreign_language ?? 0);
                $table->addCell(2000)->addText($rowData->infomation_technology ?? 0);
            }
            $this->section->addTextBreak(1);
        }
    }

    public function report21($svNhapHoc, $year, $universityId = 0)
    {
        $line1 = '21. Tổng số người học đăng ký dự thi vào CSGD, trúng tuyển và nhập học trong 5 năm gần đây hệ chính quy ';
        $this->section->addText($line1);

        $table = $this->section->addTable('defaultTable');
        $table->addRow(500);
        $table->addCell(1250)->addText('Đối tượng, thời gian (năm)', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Số thí sinh dự tuyển(người) ', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Số trúng tuyển (người)', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Tỷ lệ cạnh tranh', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Số nhập học thực tế (người)', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Điểm tuyển đầu vào (thang điểm 30)', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Điểm trung bình của người học được tuyển', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Số lượng sinh viên quốc tế nhập học (người)', ['bold' => true], 'center');

        $type = [
            'NCS' => 'Nghiên cứu sinh',
            'HVCH' => 'Học viên cao học',
            'DH' => 'Đại học',
            'CD' => 'Cao đẳng',
            'TC' => 'Trung cấp',
            'KHAC' => 'Khác'
        ];

        $index = 1;
        foreach ($type as $key => $item) {
            $text = $index . '. ' . $item;
            $table->addRow(500);
            $table->addCell(1250)->addText($text, ['bold' => true]);
            $table->addCell(1250)->addText('');
            $table->addCell(1250)->addText(' ');
            $table->addCell(1250)->addText('');
            $table->addCell(1250)->addText('');
            $table->addCell(1250)->addText('');
            $table->addCell(1250)->addText('');
            $table->addCell(1250)->addText(' ');
            $index++;
            for ($i = 4; $i >= 0; $i--) {
                $currentYear = $year - $i;
                $currentData = $svNhapHoc->where('year', $currentYear)->where('type', $key)->first();
                if (!$currentData) {
                    $currentData = new \stdClass();
                    $currentData->sl_du_tuyen = 0;
                    $currentData->sl_trung_tuyen = 0;
                    $currentData->sl_nhap_hoc = 0;
                    $currentData->sl_sv_quoc_te = 0;
                    $currentData->ti_le_canh_tranh = 0;
                    $currentData->diem_dau_vao = 0;
                    $currentData->diem_trung_binh = 0;
                }
                $table->addRow(500);
                $table->addCell(1250)->addText($currentYear);
                $table->addCell(1250)->addText($currentData->sl_du_tuyen);
                $table->addCell(1250)->addText($currentData->sl_trung_tuyen);
                $table->addCell(1250)->addText($currentData->ti_le_canh_tranh);
                $table->addCell(1250)->addText($currentData->sl_nhap_hoc);
                $table->addCell(1250)->addText($currentData->diem_dau_vao);
                $table->addCell(1250)->addText($currentData->diem_trung_binh);
                $table->addCell(1250)->addText($currentData->sl_sv_quoc_te);
            }
        }
        $sv = TomTat::tongSoSinhVienChinhQuy($universityId, $year);
        $line2 = 'Số lượng người học hệ chính quy đang học tập tại CSGD: ' . $sv . ' người.';
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report22($svNhapHoc, $year)
    {
        $line1 = '22. Tổng số người học đăng ký dự thi vào CSGD, trúng tuyển và nhập học trong 5 năm gần đây hệ không chính quy ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(1250)->addText('Đối tượng, thời gian (năm)', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Số thí sinh dự tuyển(người) ', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Số trúng tuyển (người)', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Tỷ lệ cạnh tranh', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Số nhập học thực tế (người)', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Điểm tuyển đầu vào (thang điểm 30)', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Điểm trung bình của người học được tuyển', ['bold' => true], 'center');
        $table->addCell(1250)->addText('Số lượng sinh viên quốc tế nhập học (người)', ['bold' => true], 'center');

        $type = [
            'NCS' => 'Nghiên cứu sinh',
            'HVCH' => 'Học viên cao học',
            'DH' => 'Đại học',
            'CD' => 'Cao đẳng',
            'TC' => 'Trung cấp',
            'KHAC' => 'Khác'
        ];

        $index = 1;
        foreach ($type as $key => $item) {
            $text = $index . '. ' . $item;
            $table->addRow(500);
            $table->addCell(1250)->addText($text, ['bold' => true]);
            $table->addCell(1250)->addText('');
            $table->addCell(1250)->addText(' ');
            $table->addCell(1250)->addText('');
            $table->addCell(1250)->addText('');
            $table->addCell(1250)->addText('');
            $table->addCell(1250)->addText('');
            $table->addCell(1250)->addText(' ');
            $index++;
            for ($i = 4; $i >= 0; $i--) {
                $currentYear = $year - $i;
                $currentData = $svNhapHoc->where('year', $currentYear)->where('type', $key)->first();
                if (!$currentData) {
                    $currentData = new \stdClass();
                    $currentData->sl_du_tuyen = 0;
                    $currentData->sl_trung_tuyen = 0;
                    $currentData->sl_nhap_hoc = 0;
                    $currentData->sl_sv_quoc_te = 0;
                    $currentData->ti_le_canh_tranh = 0;
                    $currentData->diem_dau_vao = 0;
                    $currentData->diem_trung_binh = 0;
                }
                $table->addRow(500);
                $table->addCell(1250)->addText($currentYear);
                $table->addCell(1250)->addText($currentData->sl_du_tuyen);
                $table->addCell(1250)->addText($currentData->sl_trung_tuyen);
                $table->addCell(1250)->addText($currentData->ti_le_canh_tranh);
                $table->addCell(1250)->addText($currentData->sl_nhap_hoc);
                $table->addCell(1250)->addText($currentData->diem_dau_vao);
                $table->addCell(1250)->addText($currentData->diem_trung_binh);
                $table->addCell(1250)->addText($currentData->sl_sv_quoc_te);
            }
        }
    }

    public function report23($svKyTuc, $year)
    {
        $line1 = '23. Ký túc xá cho sinh viên:';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000)->addText('Các tiêu chí', ['bold' => true], 'center');
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1250)->addText($year - $i, ['bold' => true], 'center');
        }

        $tieuChi = [
            'tong_dien_tich' => '1. Tổng diện tích phòng ở (m2)',
            'sl_sinh_vien' => '2. Số lượng sinh viên',
            'sl_sv_co_nhu_cau' => '3. Số sinh viên có nhu cầu ở ký túc xá',
            'sl_sv_dc_o' => '4. Số lượng sinh viên được ở ký túc xá',
        ];
        $tyLe = [];
        foreach ($tieuChi as $key => $item) {
            $table->addRow(500);
            $table->addCell(3000)->addText($item);
            for ($i = 4; $i >= 0; $i--) {
                $currentYear = $year - $i;
                $currentData = $svKyTuc->where('year', $currentYear)->first();
                if (!$currentData) {
                    $currentData = new \stdClass();
                    $currentData->$key = 0;
                }
                $table->addCell(1250)->addText($currentData->$key);
            }
        }
        $table->addRow(500);
        $table->addCell(3000)->addText('5. Tỷ số diện tích trên đầu sinh viên ở trong ký túc xá, m2/người');
        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $currentData = $svKyTuc->where('year', $currentYear)->first();
            if (!$currentData) {
                $currentData = new \stdClass();
                $currentData->ty_le = 0;
                $currentData->sl_sv_dc_o = 0;
            }
            if ($currentData->sl_sv_dc_o) {
                $currentData->ty_le = round($currentData->tong_dien_tich / $currentData->sl_sv_dc_o, 2);
            } else {
                $currentData->ty_le = '0';
            }

            $table->addCell(1250)->addText($currentData->ty_le);
        }


    }

    public function report24($svNckh, $year)
    {
        $line1 = '24. Sinh viên tham gia nghiên cứu khoa học:';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000)->addText('', ['bold' => true], 'center');
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1250)->addText($year - 1, ['bold' => true], 'center');
        }

        $table->addRow(500);
        $table->addCell(3000)->addText('Số lượng (người)');
        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $data = $svNckh->where('year', $currentYear)->first();
            if (!$data) {
                $data = new \stdClass();
                $data->sl_tham_gia = 0;
            }
            $table->addCell(1250)->addText($data->sl_tham_gia);
        }

        $table->addRow(500);
        $table->addCell(3000)->addText('Tỷ lệ (%) trên tổng số sinh viên ');
        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $data = $svNckh->where('year', $currentYear)->first();
            if (!$data) {
                $data = new \stdClass();
                $data->ti_le = 0;
            }
            $table->addCell(1250)->addText($data->ti_le);
        }

    }

    public function report25($svTotNghiep, $year)
    {
        $line1 = '25. Thống kê số lượng người học tốt nghiệp trong 5 năm gần đây:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 5, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000, $cellRowSpan)->addText('Các tiêu chí', ['bold' => true], 'center');
        $table->addCell(6250, $cellColSpan)->addText('Năm tốt nghiệp', ['bold' => true], 'center');

        $table->addRow(500);
        $table->addCell(3000, $cellRowContinue);
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1250)->addText($year - $i, ['bold' => true], 'center');
        }
        $tieuChi = [
            'ncs_bv_luan_an_ts' => '1. Nghiên cứu sinh bảo vệ thành công luận án tiến sĩ',
            'hv_tot_nghiep_ch' => '2. Học viên tốt nghiệp cao học',
            'trong_1' => '3. Sinh viên tốt nghiệp đại học',
            'sv_cq_tn_dh' => 'Hệ chính quy',
            'sv_kcq_tn_dh' => 'Hệ không chính quy',
            'trong_2' => '4. Sinh viên tốt nghiệp cao đẳng',
            'sv_cq_tn_cd' => 'Hệ chính quy',
            'sv_kcq_tn_cd' => 'Hệ không chính quy',
            'trong_3' => '5. Học sinh tốt nghiệp trung cấp',
            'sv_cq_tn_tc' => 'Hệ chính quy',
            'sv_kcq_tn_tc' => 'Hệ không chính quy',
            'khac' => '6. Khác',
        ];

        foreach ($tieuChi as $key => $item) {
            $table->addRow(500);
            $cell = $table->addCell(3000);
            $cell->addText($item);
            if (strpos($key, 'trong') !== false) {
                $cell->addText('Trong đó:');
                continue;
            }
            for ($i = 4; $i >= 0; $i--) {
                $data = $svTotNghiep->where('year', $year - $i)->first();
                if (!$data) {
                    $data = new \stdClass();
                    $data->$key = 0;
                }
                $table->addCell(1250)->addText($data->$key);
            }

        }
    }

    public function report26($tinhTrang, $year)
    {
        $line1 = '26. Tình trạng tốt nghiệp của sinh viên đại học hệ chính quy:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 5, 'valign' => 'center');
        $border = ['borderBottomColor' => 'aaaaaa', 'borderBottomSize' => 9];
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000, $cellRowSpan)->addText('Các tiêu chí', ['bold' => true], 'center');
        $table->addCell(6250, $cellColSpan)->addText('Năm tốt nghiệp', ['bold' => true], 'center');

        $table->addRow(500);
        $table->addCell(3000, $cellRowContinue);
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1250)->addText($year - $i, ['bold' => true], 'center');
        }

        $this->rowReport26($table, $tinhTrang, $year, 1, '1. Số lượng sinh viên tốt nghiệp (người)');
        $this->rowReport26($table, $tinhTrang, $year, 2, '2. Tỷ lệ sinh viên tốt nghiệp so với số tuyển vào (%)');

        $table->addRow(500);
        $cell = $table->addCell(3000);
        $cell->addText('3. Đánh giá của sinh viên tốt nghiệp về chất lượng đào tạo của nhà trường:');
        $cell->addText('A. Nhà trường không điều tra về vấn đề này chuyển xuống câu 4');
        $cell->addText('B. Nhà trường có điều tra về vấn đề này điền các thông tin dưới đây');

        $this->rowReport26($table, $tinhTrang, $year, 3, '3.1 Tỷ lệ sinh viên trả lời đã học được những kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp (%)');
        $this->rowReport26($table, $tinhTrang, $year, 4, '3.2 Tỷ lệ sinh viên trả lời chỉ học được một phần kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp (%)');
        $this->rowReport26($table, $tinhTrang, $year, 5, '3.3 Tỷ lệ sinh viên trả lời KHÔNG học được những kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp');

        $table->addRow(500);
        $cell = $table->addCell(3000);
        $cell->addText('4. Sinh viên có việc làm trong năm đầu tiên sau khi tốt nghiệp:');
        $cell->addText('A. Nhà trường không điều tra về vấn đề này chuyển xuống câu 5');
        $cell->addText('B. Nhà trường có điều tra về vấn đề này điền các thông tin dưới đây');

        $table->addRow(500);
        $table->addCell(3000, $border)->addText('4.1 Tỷ lệ có việc làm đúng ngành đào tạo (%)');
        $table->addCell(1250, $border)->addText('');
        $table->addCell(1250, $border)->addText('');
        $table->addCell(1250, $border)->addText('');
        $table->addCell(1250, $border)->addText('');
        $table->addCell(1250, $border)->addText('');

        $this->rowReport26($table, $tinhTrang, $year, 6, '-  Sau 6 tháng tốt nghiệp', $border);
        $this->rowReport26($table, $tinhTrang, $year, 7, '-  Sau 12 tháng tốt nghiệp');
        $this->rowReport26($table, $tinhTrang, $year, 8, '4.2 Tỷ lệ có việc làm trái ngành đào tạo (%)');
        $this->rowReport26($table, $tinhTrang, $year, 9, '4.3 Tỷ lệ tự tạo được việc làm (%)');
        $this->rowReport26($table, $tinhTrang, $year, 10, '4.4 Thu nhập bình quân/tháng của sinh viên có việc làm');

        $table->addRow(500);
        $cell = $table->addCell(3000);
        $cell->addText('5. Đánh giá của nhà sử dụng về sinh viên tốt nghiệp có việc làm đúng ngành đào tạo:');
        $cell->addText('A. Nhà trường không điều tra về vấn đề này  chuyển xuống kết thúc bảng này');
        $cell->addText('B. Nhà trường có điều tra về vấn đề này  điền các thông tin dưới đây');

        $this->rowReport26($table, $tinhTrang, $year, 11, '5.1 Tỷ lệ sinh viên đáp ứng yêu cầu của công việc, có thể sử dụng được ngay (%)');
        $this->rowReport26($table, $tinhTrang, $year, 12, '5.2 Tỷ lệ sinh viên cơ bản đáp ứng yêu cầu của công việc, nhưng phải đào tạo thêm (%)');
        $this->rowReport26($table, $tinhTrang, $year, 13, '5.3 Tỷ lệ sinh viên phải được đào tạo lại hoặc đào tạo bổ sung ít nhất 6 tháng (%)');
    }

    private function rowReport26($table, $tinhTrang, $year, $cauHoiId, $text, $border = null)
    {
        $table->addRow(500);
        $table->addCell(3000, $border)->addText($text);
        for ($i = 4; $i >= 0; $i--) {
            $currentData = $tinhTrang->where('cau_hoi_id', $cauHoiId)->where('year', $year - $i)->first();
            if (!$currentData) {
                $currentData = new \stdClass();
                $currentData->tra_loi = '0';
            }
            $table->addCell(1250, $border)->addText($currentData->tra_loi);
        }
    }

    public function report27($tinhTrang, $year)
    {
        $line1 = '27. Tình trạng tốt nghiệp của sinh viên cao đẳng hệ chính quy:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 5, 'valign' => 'center');
        $border = ['borderBottomColor' => 'aaaaaa', 'borderBottomSize' => 9];
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000, $cellRowSpan)->addText('Các tiêu chí', ['bold' => true], 'center');
        $table->addCell(6250, $cellColSpan)->addText('Năm tốt nghiệp', ['bold' => true], 'center');

        $table->addRow(500);
        $table->addCell(3000, $cellRowContinue);
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1250)->addText($year - $i, ['bold' => true], 'center');
        }

        $this->rowReport26($table, $tinhTrang, $year, 1, '1. Số lượng sinh viên tốt nghiệp (người)');
        $this->rowReport26($table, $tinhTrang, $year, 2, '2. Tỷ lệ sinh viên tốt nghiệp so với số tuyển vào (%)');

        $table->addRow(500);
        $cell = $table->addCell(3000);
        $cell->addText('3. Đánh giá của sinh viên tốt nghiệp về chất lượng đào tạo của nhà trường:');
        $cell->addText('A. Nhà trường không điều tra về vấn đề này chuyển xuống câu 4');
        $cell->addText('B. Nhà trường có điều tra về vấn đề này điền các thông tin dưới đây');

        $this->rowReport26($table, $tinhTrang, $year, 3, '3.1 Tỷ lệ sinh viên trả lời đã học được những kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp (%)');
        $this->rowReport26($table, $tinhTrang, $year, 4, '3.2 Tỷ lệ sinh viên trả lời chỉ học được một phần kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp (%)');
        $this->rowReport26($table, $tinhTrang, $year, 5, '3.3 Tỷ lệ sinh viên trả lời KHÔNG học được những kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp');

        $table->addRow(500);
        $cell = $table->addCell(3000);
        $cell->addText('4. Sinh viên có việc làm trong năm đầu tiên sau khi tốt nghiệp:');
        $cell->addText('A. Nhà trường không điều tra về vấn đề này chuyển xuống câu 5');
        $cell->addText('B. Nhà trường có điều tra về vấn đề này điền các thông tin dưới đây');

        $table->addRow(500);
        $table->addCell(3000, $border)->addText('4.1 Tỷ lệ có việc làm đúng ngành đào tạo (%)');
        $table->addCell(1250, $border)->addText('');
        $table->addCell(1250, $border)->addText('');
        $table->addCell(1250, $border)->addText('');
        $table->addCell(1250, $border)->addText('');
        $table->addCell(1250, $border)->addText('');

        $this->rowReport26($table, $tinhTrang, $year, 6, '-  Sau 6 tháng tốt nghiệp', $border);
        $this->rowReport26($table, $tinhTrang, $year, 7, '-  Sau 12 tháng tốt nghiệp');
        $this->rowReport26($table, $tinhTrang, $year, 8, '4.2 Tỷ lệ có việc làm trái ngành đào tạo (%)');
        $this->rowReport26($table, $tinhTrang, $year, 9, '4.3 Tỷ lệ tự tạo được việc làm (%)');
        $this->rowReport26($table, $tinhTrang, $year, 10, '4.4 Thu nhập bình quân/tháng của sinh viên có việc làm');

        $table->addRow(500);
        $cell = $table->addCell(3000);
        $cell->addText('5. Đánh giá của nhà sử dụng về sinh viên tốt nghiệp có việc làm đúng ngành đào tạo:');
        $cell->addText('A. Nhà trường không điều tra về vấn đề này  chuyển xuống kết thúc bảng này');
        $cell->addText('B. Nhà trường có điều tra về vấn đề này  điền các thông tin dưới đây');

        $this->rowReport26($table, $tinhTrang, $year, 11, '5.1 Tỷ lệ sinh viên đáp ứng yêu cầu của công việc, có thể sử dụng được ngay (%)');
        $this->rowReport26($table, $tinhTrang, $year, 12, '5.2 Tỷ lệ sinh viên cơ bản đáp ứng yêu cầu của công việc, nhưng phải đào tạo thêm (%)');
        $this->rowReport26($table, $tinhTrang, $year, 13, '5.3 Tỷ lệ sinh viên phải được đào tạo lại hoặc đào tạo bổ sung ít nhất 6 tháng (%)');
    }

    public function report28($deTai, $year, $universityId = 0)
    {
        $line1 = '28. Số lượng đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ của
        nhà trường được nghiệm thu trong 5 năm gần đây:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 6, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $row = $table->addRow(500);
        $row->addCell(500, $cellRowSpan)->addText('TT', ['bold' => true], 'center');
        $row->addCell(2500, $cellRowSpan)->addText('Các tiêu chí', ['bold' => true], 'center');
        $row->addCell(6250, $cellColSpan)->addText('Năm tốt nghiệp', ['bold' => true], 'center');

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(2500, $cellRowContinue);
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1250)->addText($year - $i, ['bold' => true], 'center');
        }
        $table->addCell(1250)->addText('Tổng số', ['bold' => true]);

        $rowNhaNuoc = $table->addRow(500);
        $rowNhaNuoc->addCell(500)->addText(1);
        $rowNhaNuoc->addCell(2500)->addText('Đề tài cấp Nhà nước');

        $rowCapBo = $table->addRow(500);
        $rowCapBo->addCell(500)->addText(2);
        $rowCapBo->addCell(2500)->addText('Đề tài cấp Bộ*');

        $rowCapTruong = $table->addRow(500);
        $rowCapTruong->addCell(500)->addText(3);
        $rowCapTruong->addCell(2500)->addText('Đề tài cấp trường');

        $rowTong = $table->addRow(500);
        $rowTong->addCell(500)->addText('');
        $rowTong->addCell(2500)->addText('Tổng cộng', ['bold' => true]);

        $tongNhaNuoc = 0;
        $tongCapBo = 0;
        $tongCapTruong = 0;

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $currentData = $deTai->where('year', $currentYear)->first();
            if (!$currentData) {
                $currentData = new \stdClass();
                $currentData->dt_cap_nha_nuoc = 0;
                $currentData->dt_cap_bo = 0;
                $currentData->dt_cap_truong = 0;
            }
            $sum = $currentData->dt_cap_nha_nuoc + $currentData->dt_cap_bo + $currentData->dt_cap_truong;
            $tongNhaNuoc += $currentData->dt_cap_nha_nuoc;
            $tongCapBo += $currentData->dt_cap_bo;
            $tongCapTruong += $currentData->dt_cap_truong;

            $rowNhaNuoc->addCell(1250)->addText($currentData->dt_cap_nha_nuoc);
            $rowCapBo->addCell(1250)->addText($currentData->dt_cap_bo);
            $rowCapTruong->addCell(1250)->addText($currentData->dt_cap_truong);
            $rowTong->addCell(1250)->addText($sum);
        }

        $rowNhaNuoc->addCell(1250)->addText($tongNhaNuoc);
        $rowCapBo->addCell(1250)->addText($tongCapBo);
        $rowCapTruong->addCell(1250)->addText($tongCapTruong);
        $rowTong->addCell(1250)->addText($tongCapTruong + $tongCapBo + $tongNhaNuoc);

        $line2 = '* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước';
        $this->section->addText($line2, [], ['indent' => true]);
        $tiSo = TomTat::tiLeDeTaiCanBo($universityId, $year);
        $tiSo = $tiSo > 0 ? $tiSo : 0;
        $line2 = 'Tỷ số đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ trên cán bộ cơ hữu: ' . $tiSo;
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report29($doanhThu, $year)
    {
        $line1 = '29. Doanh thu từ nghiên cứu khoa học và chuyển giao công nghệ của CSGD trong 5 năm gần đây:';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500)->addText('TT', ['bold' => true], 'center');
        $table->addCell(1500)->addText('Năm', ['bold' => true], 'center');
        $table->addCell(2500)->addText('Doanh thu từ NCKH và chuyển giao công nghệ (triệu VNĐ)', ['bold' => true], 'center');
        $table->addCell(2500)->addText('Tỷ lệ doanh thu từ NCKH và chuyển giao công nghệ so với tổng kinh phí đầu vào của CSGD (%)', ['bold' => true], 'center');
        $table->addCell(2500)->addText('Tỷ số doanh thu từ NCKH và chuyển giao công nghệ trên cán bộ cơ hữu(triệu VNĐ/ người)', ['bold' => true], 'center');

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $currentData = $doanhThu->where('year', $currentYear)->first();
            if (!$currentData) {
                $currentData = new \stdClass();
                $currentData->dt_nckh_va_cgcn = 0;
                $currentData->ti_le_ss_vs_kinh_phi = 0;
                $currentData->ti_so_tren_cb_ch = 0;
            }
            $table->addRow(500);
            $table->addCell(500)->addText($i + 1);
            $table->addCell(1500)->addText($currentYear);
            $table->addCell(2500)->addText($currentData->dt_nckh_va_cgcn);
            $table->addCell(2500)->addText($currentData->ti_le_ss_vs_kinh_phi);
            $table->addCell(2500)->addText($currentData->ti_so_tren_cb_ch);
        }
    }

    public function report30($canBoNCKH, $year)
    {
        $line1 = '30. Số lượng cán bộ cơ hữu của CSGD tham gia thực hiện đề tài khoa học trong 5 năm gần đây:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center');

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $table = $this->section->addTable('defaultTable');

            $table->addRow(500);
            $table->addCell(3000, $cellRowSpan)->addText('Số lượng đề tài', ['bold' => true], 'center');
            $table->addCell(4500, $cellColSpan)->addText('Số lượng cán bộ tham gia', ['bold' => true], 'center');
            $table->addCell(2500, $cellRowSpan)->addText('Ghi chú', ['bold' => true], 'center');

            $table->addRow(500);
            $table->addCell(3000, $cellRowContinue);
            $table->addCell(1500)->addText('Đề tài cấp Nhà nước', ['bold' => true], 'center');
            $table->addCell(1500)->addText('Đề tài cấp Bộ*', ['bold' => true], 'center');
            $table->addCell(1500)->addText('Đề tài cấp trường', ['bold' => true], 'center');
            $table->addCell(2500, $cellRowContinue);

            $currentData = $canBoNCKH->where('year', $currentYear);
            $dataNhaNuoc = $currentData->where('cap_de_tai_id', 1)->first();
            if (!$dataNhaNuoc) {
                $dataNhaNuoc = new \stdClass();
                $dataNhaNuoc->tu_1_3 = 0;
                $dataNhaNuoc->tu_4_6 = 0;
                $dataNhaNuoc->tren_6 = 0;
            }

            $dataCapBo = $currentData->where('cap_de_tai_id', 2)->first();
            if (!$dataCapBo) {
                $dataCapBo = new \stdClass();
                $dataCapBo->tu_1_3 = 0;
                $dataCapBo->tu_4_6 = 0;
                $dataCapBo->tren_6 = 0;
            }

            $dataCapTruong = $currentData->where('cap_de_tai_id', 3)->first();
            if (!$dataCapTruong) {
                $dataCapTruong = new \stdClass();
                $dataCapTruong->tu_1_3 = 0;
                $dataCapTruong->tu_4_6 = 0;
                $dataCapTruong->tren_6 = 0;
            }

            $table->addRow(500);
            $table->addCell(3000)->addText('Từ 1 đến 3 đề tài');
            $table->addCell(1500)->addText($dataNhaNuoc->tu_1_3);
            $table->addCell(1500)->addText($dataCapBo->tu_1_3);
            $table->addCell(1500)->addText($dataCapTruong->tu_1_3);
            $table->addCell(2500)->addText('');

            $table->addRow(500);
            $table->addCell(3000)->addText('Từ 4 đến 6 đề tài ');
            $table->addCell(1500)->addText($dataNhaNuoc->tu_4_6);
            $table->addCell(1500)->addText($dataCapBo->tu_4_6);
            $table->addCell(1500)->addText($dataCapTruong->tu_4_6);
            $table->addCell(2500)->addText('');

            $table->addRow(500);
            $table->addCell(3000)->addText('Trên 6 đề tài ');
            $table->addCell(1500)->addText($dataNhaNuoc->tren_6);
            $table->addCell(1500)->addText($dataCapBo->tren_6);
            $table->addCell(1500)->addText($dataCapTruong->tren_6);
            $table->addCell(2500)->addText('');

            $table->addRow(500);
            $table->addCell(3000)->addText('Tổng số cán bộ tham gia', ['bold' => true]);
            $table->addCell(1500)->addText($dataNhaNuoc->tu_1_3 + $dataNhaNuoc->tu_4_6 + $dataNhaNuoc->tren_6, ['bold' => true]);
            $table->addCell(1500)->addText($dataCapBo->tu_4_6 + $dataCapBo->tu_1_3 + $dataCapBo->tren_6, ['bold' => true]);
            $table->addCell(1500)->addText($dataCapTruong->tu_4_6 + $dataCapTruong->tu_1_3 + $dataCapTruong->tren_6, ['bold' => true]);
            $table->addCell(2500)->addText('', ['bold' => true]);
            $this->section->addTextBreak(1);
        }

        $line2 = '* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước';
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report31($sach, $year, $universityId = 0)
    {
        $line1 = '31. Số lượng sách của CSGD được xuất bản trong 5 năm gần đây:';
        $this->section->addText($line1);

        $phanLoaiSach = [
            1 => 'Sách chuyên khảo',
            2 => 'Sách giáo trình',
            3 => 'Sách tham khảo',
            4 => 'Sách hướng dẫn'
        ];
        $tongNam = [];

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 6, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500, $cellRowSpan)->addText('TT', ['bold' => true], 'center');
        $table->addCell(3000, $cellRowSpan)->addText('Phân loại sách', ['bold' => true], 'center');
        $table->addCell(6000, $cellColSpan)->addText('Số lượng', ['bold' => true], 'center');

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(3000, $cellRowContinue);
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1000)->addText($year - $i, ['bold' => true], 'center');
            $tongNam[$year - $i] = 0;
        }
        $table->addCell(1000)->addText('Tổng số', ['bold' => true]);

        foreach ($phanLoaiSach as $key => $item) {
            $table->addRow(500);
            $table->addCell(500)->addText($key);
            $table->addCell(3000)->addText($item);
            $tong = 0;
            for ($i = 4; $i >= 0; $i--) {
                $currentYear = $year - $i;
                $data = $sach->where('year', $currentYear)->where('loai_sach_id', $key)->first();
                if (!$data) {
                    $data = new \stdClass();
                    $data->so_luong = 0;
                }
                $tong += $data->so_luong;
                $tongNam[$currentYear] += $data->so_luong;
                $table->addCell(1000)->addText($data->so_luong);
            }
            $table->addCell(1000)->addText($tong);
        }
        $table->addRow(500);
        $table->addCell(500)->addText('');
        $table->addCell(3000)->addText('Tổng cộng', ['bold' => true]);
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1000)->addText($tongNam[$year - $i], ['bold' => true]);
        }
        $table->addCell(1000)->addText('', ['bold' => true]);

        $tiSo = TomTat::tiSoSachCanBo($universityId, $year);
        $tiSo = $tiSo > 0 ? $tiSo : 1;
        $line2 = 'Tỷ số sách đã được xuất bản trên cán bộ cơ hữu: ' . $tiSo;
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report32($canBoSach, $year)
    {
        $line1 = '32. Số lượng cán bộ cơ hữu của CSGD tham gia viết sách trong 5 năm gần đây:';
        $this->section->addText($line1);

        $phanLoaiSach = [
            1 => 'Sách chuyên khảo',
            2 => 'Sách giáo trình',
            3 => 'Sách tham khảo',
            4 => 'Sách hướng dẫn'
        ];

        $soLuongSach = [
            'tu_1_3' => 'Từ 1 đến 3 cuốn sách ',
            'tu_4_6' => 'Từ 4 đến 6 cuốn sách ',
            'tren_6' => 'Trên 6 cuốn sách '
        ];

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 4, 'valign' => 'center');

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $currentData = $canBoSach->where('year', $currentYear);

            $table = $this->section->addTable('defaultTable');
            $table->addRow(500);
            $table->addCell(3000, $cellRowSpan)->addText('Số lượng sách', ['bold' => true], 'center');
            $table->addCell(6000, $cellColSpan)->addText('Số lượng cán bộ cơ hữu tham gia viết sách', ['bold' => true], 'center');
            $table->addRow(500);
            $table->addCell(3000, $cellRowContinue);
            $table->addCell(150)->addText('Sách chuyên khảo', ['bold' => true], 'center');
            $table->addCell(1500)->addText('Sách giáo trình', ['bold' => true], 'center');
            $table->addCell(1500)->addText('Sách tham khảo', ['bold' => true], 'center');
            $table->addCell(1500)->addText('Sách hướng dẫn', ['bold' => true], 'center');
            $tong = [];
            foreach ($soLuongSach as $key => $item) {
                $table->addRow(500);
                $table->addCell(3000)->addText($item);
                foreach ($phanLoaiSach as $k => $v) {
                    $data = $currentData->where('loai_sach_id', $k)->first();

                    if (!$data) {
                        $data = new \stdClass();
                        $data->$key = 0;
                    }
                    if (isset($tong[$k])) {
                        $tong[$k] += $data->$key;
                    } else {
                        $tong[$k] = $data->$key;
                    }
                    $table->addCell(1250)->addText($data->$key);
                }
            }
            $table->addRow(500);
            $table->addCell(3000)->addText('Tổng số cán bộ tham gia', ['bold' => true], 'center');
            $table->addCell(1250)->addText($tong[1], ['bold' => true]);
            $table->addCell(1250)->addText($tong[2], ['bold' => true]);
            $table->addCell(1250)->addText($tong[3], ['bold' => true]);
            $table->addCell(1250)->addText($tong[4], ['bold' => true]);
            $this->section->addTextBreak(1);
        }

    }

    public function report33($canBoTapChi, $year, $universityId = 0)
    {
        $line1 = '33. Số lượng bài của các cán bộ cơ hữu của CSGD được đăng tạp chí trong 5 năm gần đây:';
        $this->section->addText($line1);

        $phanLoaiTapChi = [
            1 => 'Tạp chí KH quốc tế',
            2 => 'Tạp chí KH cấp Ngành trong nước',
            3 => 'Tạp chí / tập san của cấp trường',
        ];
        $danhMuc = [
            'isi' => 'Danh mục ISI',
            'scopus' => 'Danh mục Scopus',
            'khac' => 'Khác'
        ];
        $tongNam = [];

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 6, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500, $cellRowSpan)->addText('TT', ['bold' => true], 'center');
        $table->addCell(3000, $cellRowSpan)->addText('Phân loại sách', ['bold' => true], 'center');
        $table->addCell(6000, $cellColSpan)->addText('Số lượng', ['bold' => true], 'center');

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(3000, $cellRowContinue);
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1000)->addText($year - $i, ['bold' => true], 'center');
            $tongNam[$year - $i] = 0;
        }
        $table->addCell(1000)->addText('Tổng số', ['bold' => true]);

        foreach ($phanLoaiTapChi as $key => $item) {
            if ($key != 1) {
                $table->addRow(500);
                $table->addCell(500)->addText($key);
                $table->addCell(3000)->addText($item);
                $tong = 0;
                for ($i = 4; $i >= 0; $i--) {
                    $currentYear = $year - $i;
                    $data = $canBoTapChi->where('year', $currentYear)->where('phan_loai_tap_chi_id', $key)->first();
                    if (!$data) {
                        $data = new \stdClass();
                        $data->so_luong = 0;
                    }
                    $tong += $data->so_luong;
                    $tongNam[$currentYear] += $data->so_luong;
                    $table->addCell(1000)->addText($data->so_luong);
                }
                $table->addCell(1000)->addText($tong);
                continue;
            }
            $table->addRow(500);
            $table->addCell(500)->addText($key);
            $cell = $table->addCell(3000);
            $cell->addText($item);
            $cell->addText('Trong đó:');
            for ($i = 4; $i >= 0; $i--) {
                $table->addCell(1000)->addText('');
            }
            $table->addCell(1000)->addText('');
            foreach ($danhMuc as $k => $v) {
                $table->addRow(500);
                $table->addCell(500)->addText('');
                $table->addCell(3000)->addText($v);
                $tong = 0;
                for ($i = 4; $i >= 0; $i--) {
                    $currentYear = $year - $i;
                    $data = $canBoTapChi->where('year', $currentYear)
                        ->where('danh_muc', $k)
                        ->where('phan_loai_tap_chi_id', $key)
                        ->first();
                    if (!$data) {
                        $data = new \stdClass();
                        $data->so_luong = 0;
                    }
                    $tong += $data->so_luong;
                    $tongNam[$currentYear] += $data->so_luong;
                    $table->addCell(1000)->addText($data->so_luong);
                }
                $table->addCell(1000)->addText($tong);
            }

        }
        $table->addRow(500);
        $table->addCell(500)->addText('');
        $table->addCell(3000)->addText('Tổng cộng', ['bold' => true]);
        $sum = 0;
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1000)->addText($tongNam[$year - $i], ['bold' => true]);
            $sum += $tongNam[$year - $i];
        }
        $table->addCell(1000)->addText($sum, ['bold' => true]);

        $tiSo = TomTat::tiSoBaiDangTapChi($universityId, $year);
        $tiSo = $tiSo > 0 ? $tiSo : 1;
        $line2 = 'Tỷ số bài đăng tạp chí (quy đổi) trên cán bộ cơ hữu: ' . $tiSo;
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report34($canBoTapChi, $year)
    {
        $line1 = '34. Số lượng cán bộ cơ hữu của CSGD tham gia viết bài đăng tạp chí trong 5 năm gần đây:';
        $this->section->addText($line1);

        $phanLoaiTapChi = [
            1 => 'Tạp chí KH quốc tế',
            2 => 'Tạp chí KH cấp Ngành trong nước',
            3 => 'Tạp chí / tập san của cấp trường',
        ];

        $soLuongBaiBao = [
            'tu_1_5' => 'Từ 1 đến 5 bài báo ',
            'tu_6_10' => 'Từ 6 đến 10 bài báo ',
            'tu_11_15' => 'Từ 11 đến 15 bài báo ',
            'tren_15' => 'Trên 15 bài báo '
        ];

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center');

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $currentData = $canBoTapChi->where('year', $currentYear);

            $table = $this->section->addTable('defaultTable');
            $table->addRow(500);
            $table->addCell(3000, $cellRowSpan)->addText('Số lượng cán bộ cơ hữu có bài báo đăng trên tạp chí', ['bold' => true], 'center');
            $table->addCell(6000, $cellColSpan)->addText('Nơi đăng', ['bold' => true], 'center');
            $table->addRow(500);
            $table->addCell(3000, $cellRowContinue);
            $table->addCell(2000)->addText('Tạp chí KH quốc tế', ['bold' => true], 'center');
            $table->addCell(2000)->addText('Tạp chí KH cấp Ngành trong nước', ['bold' => true], 'center');
            $table->addCell(2000)->addText('Tạp chí / tập san của cấp trường', ['bold' => true], 'center');
            $tong = [];
            foreach ($soLuongBaiBao as $key => $item) {
                $table->addRow(500);
                $table->addCell(3000)->addText($item);
                foreach ($phanLoaiTapChi as $k => $v) {
                    $data = $currentData->where('phan_loai_tap_chi', $k)->first();
                    if (!$data) {
                        $data = new \stdClass();
                        $data->$key = 0;
                    }
                    if (isset($tong[$k])) {
                        $tong[$k] += $data->$key;
                    } else {
                        $tong[$k] = $data->$key;
                    }
                    $table->addCell(2000)->addText($data->$key);
                }
            }
            $table->addRow(500);
            $table->addCell(3000)->addText('Tổng số cán bộ tham gia', ['bold' => true]);
            $table->addCell(2000)->addText($tong[1], ['bold' => true]);
            $table->addCell(2000)->addText($tong[2], ['bold' => true]);
            $table->addCell(2000)->addText($tong[3], ['bold' => true]);
            $this->section->addTextBreak(1);
        }

    }

    public function report35($hoiThao, $year, $universityId = 0)
    {
        $line1 = '35. Số lượng sách của CSGD được xuất bản trong 5 năm gần đây:';
        $this->section->addText($line1);

        $phanLoaiHoiThao = [
            1 => 'Hội thảo quốc tế',
            2 => 'Hội thảo trong nước',
            3 => 'Hội thảo của trường',
        ];
        $tongNam = [];

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 6, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500, $cellRowSpan)->addText('TT', ['bold' => true], 'center');
        $table->addCell(3000, $cellRowSpan)->addText('Phân loại hội thảo', ['bold' => true], 'center');
        $table->addCell(6000, $cellColSpan)->addText('Số lượng', ['bold' => true], 'center');

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(3000, $cellRowContinue);
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1000)->addText($year - $i, ['bold' => true], 'center');
            $tongNam[$year - $i] = 0;
        }
        $table->addCell(1000)->addText('Tổng số', ['bold' => true]);

        foreach ($phanLoaiHoiThao as $key => $item) {
            $table->addRow(500);
            $table->addCell(500)->addText($key);
            $table->addCell(3000)->addText($item);
            $tong = 0;
            for ($i = 4; $i >= 0; $i--) {
                $currentYear = $year - $i;
                $data = $hoiThao->where('year', $currentYear)->where('phan_loai_hoi_thao_id', $key)->first();
                if (!$data) {
                    $data = new \stdClass();
                    $data->so_luong = 0;
                }
                $tong += $data->so_luong;
                $tongNam[$currentYear] += $data->so_luong;
                $table->addCell(1000)->addText($data->so_luong);
            }
            $table->addCell(1000)->addText($tong);
        }
        $table->addRow(500);
        $table->addCell(500)->addText('');
        $table->addCell(3000)->addText('Tổng cộng', ['bold' => true]);
        $sum = 0;
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1000)->addText($tongNam[$year - $i], ['bold' => true]);
            $sum += $tongNam[$year - $i];
        }
        $table->addCell(1000)->addText($sum, ['bold' => true]);

        $tiSo = TomTat::tiSoBaoCaoHoiThao($universityId, $year);
        $tiSo = $tiSo > 0 ? $tiSo : 1;
        $line2 = 'Tỷ số bài báo cáo trên cán bộ cơ hữu: ' . $tiSo;
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report36($canBoHoiThao, $year)
    {
        $line1 = '36. Số lượng cán bộ cơ hữu của CSGD có báo cáo khoa học tại các hội nghị, hội thảo được đăng toàn văn trong tuyển tập công trình hay kỷ yếu trong 5 năm gần đây:';
        $this->section->addText($line1);

        $phanLoaiHoiThao = [
            1 => 'Hội thảo quốc tế',
            2 => 'Hội thảo trong nước',
            3 => 'Hội thảo của trường',
        ];

        $soLuongBaiBao = [
            'tu_1_5' => 'Từ 1 đến 5 báo cáo ',
            'tu_6_10' => 'Từ 6 đến 10 báo cáo ',
            'tu_11_15' => 'Từ 11 đến 15 báo cáo ',
            'tren_15' => 'Trên 15 báo cáo '
        ];

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $currentData = $canBoHoiThao->where('year', $currentYear);

            $table = $this->section->addTable('defaultTable');

            $table->addRow(500);
            $table->addCell(3000)->addText('Số lượng cán bộ cơ hữu có báo cáo khoa học tại các hội nghị, hội thảo', ['bold' => true], 'center');
            $table->addCell(2000)->addText('Hội thảo quốc tế', ['bold' => true], 'center');
            $table->addCell(2000)->addText('Hội thảo trong nước', ['bold' => true], 'center');
            $table->addCell(2000)->addText('Hội thảo của trường', ['bold' => true], 'center');
            $tong = [];
            foreach ($soLuongBaiBao as $key => $item) {
                $table->addRow(500);
                $table->addCell(3000)->addText($item);
                foreach ($phanLoaiHoiThao as $k => $v) {
                    $data = $currentData->where('phan_loai_hoi_thao_id', $k)->first();
                    if (!$data) {
                        $data = new \stdClass();
                        $data->$key = 0;
                    }
                    if (isset($tong[$k])) {
                        $tong[$k] += $data->$key;
                    } else {
                        $tong[$k] = $data->$key;
                    }
                    $table->addCell(2000)->addText($data->$key);
                }
            }
            $table->addRow(500);
            $table->addCell(3000)->addText('Tổng số cán bộ tham gia', ['bold' => true]);
            $table->addCell(2000)->addText($tong[1], ['bold' => true]);
            $table->addCell(2000)->addText($tong[2], ['bold' => true]);
            $table->addCell(2000)->addText($tong[3], ['bold' => true]);
            $this->section->addTextBreak(1);
        }

    }

    public function report37($sangChe, $year)
    {
        $line1 = '37.  Số bằng phát minh, sáng chế được cấp trong 5 năm gần đây:';
        $this->section->addText($line1);

        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(2000)->addText('Năm', ['bold' => true], 'center');
        $cell = $table->addCell(8000);
        $cell->addText('Số bằng phát minh, sáng chế được cấp', ['bold' => true], 'center');
        $cell->addText('(ghi rõ nơi cấp, thời gian cấp, người được cấp)', ['bold' => true], 'center');

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $data = $sangChe->where('year', $currentYear)->first();
            if (!$data) {
                $data = new \stdClass();
                $data->content = '';
            }
            $table->addRow(500);
            $table->addCell(2000)->addText($currentYear);
            $table->addCell(8000)->addText($data->content);
        }
    }

    public function report351($svNCKH, $year)
    {
        $line1 = '35.1. Số lượng sinh viên của nhà trường tham gia thực hiện đề tài khoa học trong 5 năm gần đây:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center');

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $table = $this->section->addTable('defaultTable');

            $table->addRow(500);
            $table->addCell(3000, $cellRowSpan)->addText('Số lượng đề tài', ['bold' => true], 'center');
            $table->addCell(4500, $cellColSpan)->addText('Số lượng sinh viên tham gia', ['bold' => true], 'center');
            $table->addCell(2500, $cellRowSpan)->addText('Ghi chú', ['bold' => true], 'center');

            $table->addRow(500);
            $table->addCell(3000, $cellRowContinue);
            $table->addCell(1500)->addText('Đề tài cấp Nhà nước', ['bold' => true], 'center');
            $table->addCell(1500)->addText('Đề tài cấp Bộ*', ['bold' => true], 'center');
            $table->addCell(1500)->addText('Đề tài cấp trường', ['bold' => true], 'center');
            $table->addCell(2500, $cellRowContinue);

            $currentData = $svNCKH->where('year', $currentYear);
            $dataNhaNuoc = $currentData->where('cap_de_tai_id', 1)->first();
            if (!$dataNhaNuoc) {
                $dataNhaNuoc = new \stdClass();
                $dataNhaNuoc->tu_1_3 = 0;
                $dataNhaNuoc->tu_4_6 = 0;
                $dataNhaNuoc->tren_6 = 0;
            }

            $dataCapBo = $currentData->where('cap_de_tai_id', 2)->first();
            if (!$dataCapBo) {
                $dataCapBo = new \stdClass();
                $dataCapBo->tu_1_3 = 0;
                $dataCapBo->tu_4_6 = 0;
                $dataCapBo->tren_6 = 0;
            }

            $dataCapTruong = $currentData->where('cap_de_tai_id', 3)->first();
            if (!$dataCapTruong) {
                $dataCapTruong = new \stdClass();
                $dataCapTruong->tu_1_3 = 0;
                $dataCapTruong->tu_4_6 = 0;
                $dataCapTruong->tren_6 = 0;
            }

            $table->addRow(500);
            $table->addCell(3000)->addText('Từ 1 đến 3 đề tài');
            $table->addCell(1500)->addText($dataNhaNuoc->tu_1_3);
            $table->addCell(1500)->addText($dataCapBo->tu_1_3);
            $table->addCell(1500)->addText($dataCapTruong->tu_1_3);
            $table->addCell(2500)->addText('');

            $table->addRow(500);
            $table->addCell(3000)->addText('Từ 4 đến 6 đề tài ');
            $table->addCell(1500)->addText($dataNhaNuoc->tu_4_6);
            $table->addCell(1500)->addText($dataCapBo->tu_4_6);
            $table->addCell(1500)->addText($dataCapTruong->tu_4_6);
            $table->addCell(2500)->addText('');

            $table->addRow(500);
            $table->addCell(3000)->addText('Trên 6 đề tài ');
            $table->addCell(1500)->addText($dataNhaNuoc->tren_6);
            $table->addCell(1500)->addText($dataCapBo->tren_6);
            $table->addCell(1500)->addText($dataCapTruong->tren_6);
            $table->addCell(2500)->addText('');

            $table->addRow(500);
            $table->addCell(3000)->addText('Tổng số sinh viên tham gia', ['bold' => true]);
            $table->addCell(1500)->addText($dataNhaNuoc->tu_1_3 + $dataNhaNuoc->tu_4_6 + $dataNhaNuoc->tren_6, ['bold' => true]);
            $table->addCell(1500)->addText($dataCapBo->tu_4_6 + $dataCapBo->tu_1_3 + $dataCapBo->tren_6, ['bold' => true]);
            $table->addCell(1500)->addText($dataCapTruong->tu_4_6 + $dataCapTruong->tu_1_3 + $dataCapTruong->tren_6, ['bold' => true]);
            $table->addCell(2500)->addText('');
            $this->section->addTextBreak(1);
        }

        $line2 = '* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước';
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report352($thanhTich, $year)
    {
        $line1 = '35.2.Thành tích nghiên cứu khoa học của sinh viên: ';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 5, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $row = $table->addRow(500);
        $row->addCell(500, $cellRowSpan)->addText('TT', ['bold' => true], 'center');
        $row->addCell(2500, $cellRowSpan)->addText('Thành tích nghiên cứu khoa học', ['bold' => true], 'center');
        $row->addCell(6250, $cellColSpan)->addText('Số lượng', ['bold' => true], 'center');

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(2500, $cellRowContinue);
        for ($i = 4; $i >= 0; $i--) {
            $table->addCell(1400)->addText($year - $i, ['bold' => true], 'center');
        }

        $rowGiaiThuong = $table->addRow(500);
        $rowGiaiThuong->addCell(500)->addText(1);
        $rowGiaiThuong->addCell(2500)->addText('Số giải thưởng nghiên cứu khoa học, sáng tạo');

        $rowBaiBao = $table->addRow(500);
        $rowBaiBao->addCell(500)->addText(2);
        $rowBaiBao->addCell(2500)->addText('Số bài báo được đăng, công trình được công bố');

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $currentData = $thanhTich->where('year', $currentYear)->first();
            if (!$currentData) {
                $currentData = new \stdClass();
                $currentData->giai_thuong = 0;
                $currentData->bai_bao = 0;
            }
            $rowGiaiThuong->addCell(1400)->addText($currentData->giai_thuong);
            $rowBaiBao->addCell(1400)->addText($currentData->bai_bao);

        }
    }

    public function report38($dienTich)
    {
        $line1 = '38. Diện tích đất, diện tích sàn xây dựng ';
        $this->section->addText($line1);
        $bold = ['bold' => true];
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500, $cellRowSpan)->addText('TT', $bold, 'center');
        $table->addCell(4500, $cellRowSpan)->addText('Nội dung', $bold, 'center');
        $table->addCell(2000, $cellRowSpan)->addText('Diện tích (m2)', $bold, 'center');
        $table->addCell(3000, $cellColSpan)->addText('Hình thức sử dụng', $bold, 'center');

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(4500, $cellRowContinue);
        $table->addCell(2000, $cellRowContinue);
        $table->addCell(1000)->addText('Sở hữu', $bold, 'center');
        $table->addCell(1000)->addText('Liên kết', $bold, 'center');
        $table->addCell(1000)->addText('Thuê', $bold, 'center');

        $data = $dienTich->where('noi_dung', 1)->first();
        if (!$data) {
            $data = new \stdClass();
            $data->dien_tich = '0';
            $data->so_huu = 0;
            $data->lien_ket = 0;
            $data->thue = 0;
        }
        $table->addRow(500);
        $table->addCell(500)->addText(1);
        $table->addCell(4500)->addText('Tổng diện tích đất của trường');
        $table->addCell(2000)->addText($data->dien_tich);
        $table->addCell(1000)->addText($data->so_huu);
        $table->addCell(1000)->addText($data->lien_ket);
        $table->addCell(1000)->addText($data->thue);

        $table->addRow(500);
        $table->addCell(500)->addText(1);
        $cell = $table->addCell(4500);
        $cell->addText('Tổng diện tích sàn xây dựng phục vụ đào tạo, nghiên cứu khoa học của trường');
        $cell->addText('Trong đó');
        $table->addCell(2000)->addText('');
        $table->addCell(1000)->addText('');
        $table->addCell(1000)->addText('');
        $table->addCell(1000)->addText('');

        $data = $dienTich->where('noi_dung', 2)->first();
        if (!$data) {
            $data = new \stdClass();
            $data->dien_tich = 0;
            $data->so_huu = 0;
            $data->lien_ket = 0;
            $data->thue = 0;
        }
        $table->addRow(500);
        $table->addCell(500)->addText(2.1);
        $table->addCell(4500)->addText('Hội trường, giảng đường, phòng học các loại, phòng đa năng,
        phòng làm việc của giáo sư, phó giáo sư, giảng viên cơ hữu');
        $table->addCell(2000)->addText($data->dien_tich);
        $table->addCell(1000)->addText($data->so_huu);
        $table->addCell(1000)->addText($data->lien_ket);
        $table->addCell(1000)->addText($data->thue);

        $data = $dienTich->where('noi_dung', 3)->first();
        if (!$data) {
            $data = new \stdClass();
            $data->dien_tich = 0;
            $data->so_huu = 0;
            $data->lien_ket = 0;
            $data->thue = 0;
        }
        $table->addRow(500);
        $table->addCell(500)->addText(2.2);
        $table->addCell(4500)->addText('Thư viện, trung tâm học liệu');
        $table->addCell(2000)->addText($data->dien_tich);
        $table->addCell(1000)->addText($data->so_huu);
        $table->addCell(1000)->addText($data->lien_ket);
        $table->addCell(1000)->addText($data->thue);

        $data = $dienTich->where('noi_dung', 4)->first();
        if (!$data) {
            $data = new \stdClass();
            $data->dien_tich = '0';
            $data->hinh_thuc = 0;
        }
        $table->addRow(500);
        $table->addCell(500)->addText(2.5);
        $table->addCell(4500)->addText('Trung tâm nghiên cứu, phòng thí nghiệm, thực nghiệm, cơ sở thực hành, thực tập, luyện tập');
        $table->addCell(2000)->addText($data->dien_tich);
        $table->addCell(1000)->addText($data->so_huu);
        $table->addCell(1000)->addText($data->lien_ket);
        $table->addCell(1000)->addText($data->thue);
    }

    public function report39($thuVien, $nhomNganh)
    {
        $line1 = '39. Tổng số đầu sách trong thư viện của nhà trường (bao gồm giáo trình, học liệu, tài liệu, sách tham khảo… sách, tạp chí, kể cả e-book, cơ sở dữ liệu điện tử):';
        $this->section->addText($line1);

        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(4000)->addText('Khối ngành/ Nhóm ngành', ['bold' => true], 'center');
        $table->addCell(3000)->addText('Đầu sách', ['bold' => true], 'center');
        $table->addCell(3000)->addText('Bản sách', ['bold' => true], 'center');

        foreach ($nhomNganh as $item) {
            $table->addRow(500);
            $table->addCell(4000)->addText($item->name);
            $sach = $thuVien->where('nhom_nganh_id', $item->id)->first();
            if (!$sach) {
                $sach = new \stdClass();
                $sach->dau_sach = 0;
                $sach->ban_sach = 0;
            }
            $table->addCell(3000)->addText($sach->dau_sach);
            $table->addCell(3000)->addText($sach->ban_sach);
        }
    }

    public function report40($thietBi)
    {
        $line1 = '40. Tổng số thiết bị chính của trường:';
        $this->section->addText($line1);

        $bold = ['bold' => true];
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500, $cellRowSpan)->addText('STT', $bold, 'center');
        $table->addCell(2250, $cellRowSpan)->addText('Tên phòng/giảng đường/lab', $bold, 'center');
        $table->addCell(500, $cellRowSpan)->addText('Số lượng', $bold, 'center');
        $table->addCell(2250, $cellRowSpan)->addText('Danh mục trang thiết bị chính', $bold, 'center');
        $table->addCell(1500, $cellRowSpan)->addText('Đối tượng sử dụng', $bold, 'center');
        $table->addCell(1500, $cellRowSpan)->addText('Diện tích sàn xây dựng (m2)', $bold, 'center');
        $table->addCell(1500, $cellColSpan)->addText('Hình thức sử dụng', $bold, 'center');

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(2250, $cellRowContinue);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(2250, $cellRowContinue);
        $table->addCell(1500, $cellRowContinue);
        $table->addCell(1500, $cellRowContinue);
        $table->addCell(500)->addText('Sở hữu', $bold, 'center');
        $table->addCell(500)->addText('Liên kết', $bold, 'center');
        $table->addCell(500)->addText('Thuê', $bold, 'center');

        $index = 1;
        foreach ($thietBi as $item) {
            $table->addRow(500);
            $table->addCell(500)->addText($index);
            $table->addCell(2250)->addText($item->name);
            $table->addCell(500)->addText($item->so_luong);
            if ($item->danh_muc_trang_thiet_bi) {
                $text = array_reduce($item->danh_muc_trang_thiet_bi->toArray(), function ($carry, $value) {
                    $carry .= $value['name'] . ',';
                    return $carry;
                });
            } else {
                $text = '';
            }

            $table->addCell(2250)->addText($text);
            $table->addCell(1500)->addText($item->doi_tuong);
            $table->addCell(1500)->addText($item->dien_tich);
            $table->addCell(500)->addText($item->hinh_thuc == 1 ? 'x' : '');
            $table->addCell(500)->addText($item->hinh_thuc == 2 ? 'x' : '');
            $table->addCell(500)->addText($item->hinh_thuc == 3 ? 'x' : '');
            $index++;
        }

    }

    public function report41($kinhPhi, $year)
    {
        $line1 = '41. Tổng kinh phí từ các nguồn thu của trường trong 5 năm gần đây:';
        $this->section->addText($line1);

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $data = $kinhPhi->where('year', $currentYear)->first();
            if (!$data) {
                $data = new \stdClass();
                $data->tong_nguon_thu = 0;
            }
            $number = new NumberFormatter('vi_VI', NumberFormatter::CURRENCY);
            $text = "Năm {$currentYear}: {$number->formatCurrency($data->tong_nguon_thu,'VND')}";
            $this->section->addListItem($text);
        }
    }

    public function report42($kinhPhi, $year)
    {
        $line1 = '42. Tổng thu học phí (chỉ tính hệ chính quy) trong 5 năm gần đây:';
        $this->section->addText($line1);

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $data = $kinhPhi->where('year', $currentYear)->first();
            if (!$data) {
                $data = new \stdClass();
                $data->tong_hoc_phi = 0;
            }
            $number = new NumberFormatter('vi_VI', NumberFormatter::CURRENCY);
            $text = "Năm {$currentYear}: {$number->formatCurrency($data->tong_hoc_phi,'VND')}";
            $this->section->addListItem($text);
        }
    }

    public function report43($kinhPhi, $year)
    {
        $line1 = '43. Tổng chi cho hoạt động nghiên cứu khoa học, chuyển giao công nghệ và phục vụ cộng đồng:';
        $this->section->addText($line1);

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $data = $kinhPhi->where('year', $currentYear)->first();
            if (!$data) {
                $data = new \stdClass();
                $data->chi_nckh = 0;
            }
            $number = new NumberFormatter('vi_VI', NumberFormatter::CURRENCY);
            $text = "Năm {$currentYear}: {$number->formatCurrency($data->chi_nckh,'VND')}";
            $this->section->addListItem($text);
        }
    }

    public function report44($kinhPhi, $year)
    {
        $line1 = '44. Tổng thu từ hoạt động nghiên cứu khoa học, chuyển giao công nghệ và phục vụ cộng đồng';
        $this->section->addText($line1);

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $data = $kinhPhi->where('year', $currentYear)->first();
            if (!$data) {
                $data = new \stdClass();
                $data->thu_nckh = 0;
            }
            $number = new NumberFormatter('vi_VI', NumberFormatter::CURRENCY);
            $text = "Năm {$currentYear}: {$number->formatCurrency($data->thu_nckh,'VND')}";
            $this->section->addListItem($text);
        }
    }

    public function report45($kinhPhi, $year)
    {
        $line1 = '45. Tổng chi cho hoạt động đào tạo';
        $this->section->addText($line1);

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $data = $kinhPhi->where('year', $currentYear)->first();
            if (!$data) {
                $data = new \stdClass();
                $data->chi_dao_tao = 0;
            }
            $number = new NumberFormatter('vi_VI', NumberFormatter::CURRENCY);
            $text = "Năm {$currentYear}: {$number->formatCurrency($data->chi_dao_tao,'VND')}";
            $this->section->addListItem($text);
        }
    }

    public function report46($kinhPhi, $year)
    {
        $line1 = '46. Tổng chi cho phát triển đội ngũ';
        $this->section->addText($line1);

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $data = $kinhPhi->where('year', $currentYear)->first();
            if (!$data) {
                $data = new \stdClass();
                $data->chi_doi_ngu = 0;
            }
            $number = new NumberFormatter('vi_VI', NumberFormatter::CURRENCY);
            $text = "Năm {$currentYear}: {$number->formatCurrency($data->chi_doi_ngu,'VND')}";
            $this->section->addListItem($text);
        }
    }

    public function report47($kinhPhi, $year)
    {
        $line1 = '47. Tổng chi cho hoạt động kết nối doanh nghiệp, tư vấn và hỗ trợ việc làm';
        $this->section->addText($line1);

        for ($i = 4; $i >= 0; $i--) {
            $currentYear = $year - $i;
            $data = $kinhPhi->where('year', $currentYear)->first();
            if (!$data) {
                $data = new \stdClass();
                $data->chi_ket_noi = 0;
            }
            $number = new NumberFormatter('vi_VI', NumberFormatter::CURRENCY);
            $text = "Năm {$currentYear}: {$number->formatCurrency($data->chi_ket_noi,'VND')}";
            $this->section->addListItem($text);
        }
    }

    public function report48($kiemDinh)
    {
        $bold = ['bold' => true];
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
        $cellColSpan3 = array('gridSpan' => 3, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500, $cellRowSpan)->addText('TT', $bold);
        $table->addCell(1000, $cellRowSpan)->addText('Đối tượng', $bold);
        $table->addCell(1000, $cellRowSpan)->addText('Bộ tiêu chuẩn đánh giá', $bold);
        $table->addCell(2000, $cellColSpan)->addText('Tự đánh giá', $bold);
        $table->addCell(2000, $cellColSpan)->addText('Đánh giá ngoài', $bold);
        $table->addCell(3000, $cellColSpan3)->addText('Thẩm định và công nhận', $bold);

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(1000, $cellRowContinue);
        $table->addCell(1000, $cellRowContinue);
        $table->addCell(1000, $cellRowSpan)->addText('Năm hoàn thành báo cáo TĐG lần 1', $bold);
        $table->addCell(1000, $cellRowSpan)->addText('Năm cập nhật báo cáo TĐG', $bold);
        $table->addCell(1000, $cellRowSpan)->addText('Tên tổ chức đánh giá', $bold);
        $table->addCell(1000, $cellRowSpan)->addText('Tháng/năm đánh giá ngoài', $bold);
        $table->addCell(1000, $cellRowSpan)->addText('Kết quả đánh giá của Hội đồng KĐCLGD', $bold);
        $table->addCell(2000, $cellColSpan)->addText('Giấy chứng nhận', $bold);

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(1000, $cellRowContinue);
        $table->addCell(1000, $cellRowContinue);
        $table->addCell(1000, $cellRowContinue);
        $table->addCell(1000, $cellRowContinue);
        $table->addCell(1000, $cellRowContinue);
        $table->addCell(1000, $cellRowContinue);
        $table->addCell(1000, $cellRowContinue);
        $table->addCell(1000)->addText('Ngày cấp ', $bold);
        $table->addCell(1000)->addText('Giá trị đến ', $bold);

        $index = 1;
        foreach ($kiemDinh as $item) {
            $table->addRow(500);
            $table->addCell(500)->addText($index);
            $table->addCell(1000)->addText($item->doi_tuong);
            $table->addCell(1000)->addText($item->bo_tieu_chuan);
            $table->addCell(1000)->addText($item->nam_hoan_thanh_1);
            $table->addCell(1000)->addText($item->nam_cap_nhat);
            $table->addCell(1000)->addText($item->to_chuc);
            $table->addCell(1000)->addText($item->nam_danh_gia);
            $table->addCell(1000)->addText($item->ket_qua);
            $table->addCell(500)->addText($item->ngay_cap);
            $table->addCell(500)->addText($item->gia_tri_den);
            $index++;
        }
    }

    public function tomTatChiSo($tomTat)
    {
        $indent = ['indent' => true];
        $line1 = 'Từ kết quả khảo sát ở trên, tổng hợp thành một số chỉ số quan trọng dưới đây (số liệu năm cuối kỳ đánh giá):';
        $this->section->addText($line1, [], $indent);
        $this->section->addText("1. Giảng viên:");
        $value = $tomTat->tong_gv_co_huu ?? 0;
        $this->section->addText("Tổng số giảng viên cơ hữu(người): {$value}", [], $indent);
        $value = $tomTat->ti_le_gv_cb ?? 0;
        $this->section->addText("Tỷ lệ giảng viên cơ hữu trên tổng số cán bộ cơ hữu(%): {$value}", [], $indent);
        $value = $tomTat->ti_le_gv_ts ?? 0;
        $this->section->addText("Tỷ lệ giảng viên cơ hữu có trình độ tiến sĩ trở lên trên tổng số giảng viên cơ hữu(%): {$value}", [], $indent);
        $value = $tomTat->ti_le_gv_ths ?? 0;
        $this->section->addText("Tỷ lệ giảng viên cơ hữu có trình độ thạc sĩ trên tổng số giảng viên cơ hữu(%): {$value}", [], $indent);

        $this->section->addText("2. Sinh viên:");
        $value = $tomTat->tong_sv ?? 0;
        $this->section->addText("Tổng số sinh viên chính quy(người): {$value}", [], $indent);
        $value = $tomTat->ti_le_sv_gv ?? 0;
        $this->section->addText("Tỷ số sinh viên trên giảng viên(sau khi quy đổi): {$value}", [], $indent);
        $value = $tomTat->ti_le_tot_nghiep ?? 0;
        $this->section->addText("Tỷ lệ sinh viên tốt nghiệp so với số tuyển vào(%): {$value}", [], $indent);

        $this->section->addText("3. Đánh giá của sinh viên tốt nghiệp về chất lượng đào tạo của nhà trường:");
        $value = $tomTat->ti_le_tra_loi_duoc ?? 0;
        $this->section->addText("Tỷ lệ sinh viên trả lời đã học được những kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp(%): {$value}", [], $indent);
        $value = $tomTat->ti_le_tra_loi_1_phan ?? 0;
        $this->section->addText("Tỷ lệ sinh viên trả lời chỉ học được một phần kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp(%): {$value}", [], $indent);

        $this->section->addText("4. Sinh viên có việc làm trong năm đầu tiên sau khi tốt nghiệp:");
        $value = $tomTat->ti_le_dung_nganh ?? 0;
        $this->section->addText("Tỷ lệ sinh viên có việc làm đúng ngành đào tạo, trong đó bao gồm cả sinh viên chưa có việc làm học tập nâng cao(%): {$value}", [], $indent);
        $value = $tomTat->ti_le_trai_nganh ?? 0;
        $this->section->addText("Tỷ lệ sinh viên có việc làm trái ngành đào tạo(%): {$value}", [], $indent);
        $value = $tomTat->ti_le_tu_tao ?? 0;
        $this->section->addText("Tỷ lệ tự tạo được việc làm trong số sinh viên có việc làm(%): {$value}", [], $indent);
        $value = $tomTat->thu_nhap_binh_quan ?? 0;
        $this->section->addText("Thu nhập bình quân / tháng của sinh viên có việc làm(triệu VNĐ): {$value}", [], $indent);

        $this->section->addText("5. Đánh giá của nhà sử dụng về sinh viên tốt nghiệp có việc làm đúng ngành đào tạo:");
        $value = $tomTat->ti_le_dap_ung_ngay ?? 0;
        $this->section->addText("Tỷ lệ sinh viên đáp ứng yêu cầu của công việc, có thể sử dụng được ngay(%): {$value}", [], $indent);
        $value = $tomTat->ti_le_dao_tao_them ?? 0;
        $this->section->addText("Tỷ lệ sinh viên cơ bản đáp ứng yêu cầu của công việc, nhưng phải đào tạo thêm(%): {$value}", [], $indent);

        $this->section->addText("6. Nghiên cứu khoa học, chuyển giao công nghệ và phục vụ cộng đồng:");
        $value = $tomTat->ti_le_de_tai_cb ?? 0;
        $this->section->addText("Tỷ số đề tài nghiên cứu khoa học, chuyển giao khoa học công nghệ và phục vụ cộng đồng trên cán bộ cơ hữu: {$value}", [], $indent);
        $value = $tomTat->ti_so_doanh_thu ?? 0;
        $this->section->addText("Tỷ số doanh thu từ nghiên cứu khoa học, chuyển giao công nghệ và phục vụ cộng đồng trên cán bộ cơ hữu: {$value}", [], $indent);
        $value = $tomTat->ti_so_sach_cb ?? 0;
        $this->section->addText(" Tỷ số sách đã được xuất bản trên cán bộ cơ hữu: {$value}", [], $indent);
        $value = $tomTat->ti_so_tap_chi_cb ?? 0;
        $this->section->addText(" Tỷ số bài đăng tạp chí trên cán bộ cơ hữu: {$value}", [], $indent);
        $value = $tomTat->ti_so_bai_bao_cb ?? 0;
        $this->section->addText(" Tỷ số bài báo cáo trên cán bộ cơ hữu: {$value}", [], $indent);

        $this->section->addText("7. Cơ sở vật chất(số liệu năm cuối kỳ đánh giá):");
        $value = $tomTat->ti_so_dien_tich_sv ?? 0;
        $this->section->addText("Tỷ số diện tích sàn xây dựng trên sinh viên chính quy: {$value}", [], $indent);
        $value = $tomTat->ti_so_ktx_sv ?? 0;
        $this->section->addText("Tỷ số chỗ ở ký túc xá trên sinh viên chính quy: {$value}", [], $indent);

        $this->section->addText("8. Kết quả kiểm định chất lượng giáo dục");
        $value = $tomTat->cap_co_so ?? '[]';
        $value = json_decode($value, true);
        $this->section->addText("Cấp cơ sở giáo dục:", [], $indent);
        foreach ($value as $item) {
            $this->section->addText('+ ' . $item, [], $indent);
        }
        $value = $tomTat->cap_ctdt ?? '[]';
        $value = json_decode($value, true);
        $this->section->addText("Cấp chương trình đào tạo:", [], $indent);
        foreach ($value as $item) {
            $this->section->addText('+ ' . $item, [], $indent);
        }

    }
}
