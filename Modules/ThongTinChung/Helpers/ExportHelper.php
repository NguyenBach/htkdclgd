<?php


namespace Modules\ThongTinChung\Helpers;

use Modules\GiangVien\Entities\Lecturer;
use Modules\ThongTinChung\Entities\Branch;
use Modules\ThongTinChung\Entities\Department;
use Modules\ThongTinChung\Entities\EducationType;
use Modules\ThongTinChung\Entities\Faculty;
use Modules\ThongTinChung\Entities\KeyOfficer;
use Modules\ThongTinChung\Entities\University;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

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
            'borderBottomColor' => '0000FF',
            'bgColor' => '66BBFF'
        ];
        $phpWord->addTableStyle('defaultTable', $defaultTable, $defaultTableFirstRow);
        return $phpWord;
    }

    public function export($universityId, $year)
    {
        $this->header();
        $this->paragraphTitle('I', 'Thông tin chung về cơ sở giáo dục');
        $university = University::find($universityId);
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
        $this->report16();
        $this->report17();
        $this->report18();
        $this->report19();
        $this->report20();

        $additionText = "Người học bao gồm sinh viên, học sinh, học viên cao học và nghiên cứu sinh:";
        $this->paragraphTitle('III', 'Người học', $additionText);

        $this->report21();
        $this->report22();
        $this->report23();
        $this->report24();
        $this->report25();
        $this->report26();
        $this->report27();

        $this->paragraphTitle('IV', 'Nghiên cứu khoa học và chuyển giao công nghệ');

        try {
            $objWriter = IOFactory::createWriter($this->phpWord, 'Word2007');
            $objWriter->save('helloWorld.docx');
        } catch (Exception $e) {
        }

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
        $line1 = '8. Thời gian bắt đầu đào tạo khóa I: ' . $startDate;
        $this->section->addText($line1);
        return $this->section;
    }

    public function report9($endDate)
    {
        $line1 = '9. Thời gian cấp bằng tốt nghiệp cho khoá I: ' . $endDate;
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

        $line2 = 'Các loại hình đào tạo khác: ' . $other;
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report12($canBo = [])
    {
        $line1 = '12. Danh sách cán bộ lãnh đạo chủ chốt của CSGD: ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(2000)->addText('Các đơn vị (bộ phận)', ['bold' => true]);
        $table->addCell(2000)->addText('Họ và tên', ['bold' => true]);
        $table->addCell(2000)->addText('Chức danh, học vị, chức vụ', ['bold' => true]);
        $table->addCell(2000)->addText('Điện thoại', ['bold' => true]);
        $table->addCell(2000)->addText('E-mail', ['bold' => true]);

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
        $table->addCell(2500, $cellRowSpan)->addText('Khoa/viện đào tạo', $bold);
        foreach ($educationType as $type) {
            $table->addCell(2500, $cellColSpan)->addText($type->name, $bold);
        }

        $table->addRow();
        $table->addCell(2500, $cellRowContinue);
        foreach ($educationType as $type) {
            $table->addCell(1250)->addText('Số CTĐT', $bold);
            $table->addCell(1250)->addText('Số sinh viên', $bold);
        }

        foreach ($khoa as $item) {
            $table->addRow();
            $table->addCell(2500)->addText($item->name);
            $number = collect($item->number);
            foreach ($educationType as $type) {
                $sl = $number->where('education_type_id', $type->id)->first();
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
        $table->addCell(500)->addText('TT', ['bold' => true]);
        $table->addCell(3000)->addText('Tên đơn vị', ['bold' => true]);
        $table->addCell(1000)->addText('Năm thành lập ', ['bold' => true]);
        $table->addCell(3000)->addText('Lĩnh vực  hoạt động', ['bold' => true]);
        $table->addCell(1250)->addText('Số lượng nghiên cứu viên', ['bold' => true]);
        $table->addCell(1250)->addText('Số lượng cán bộ/nhân viên', ['bold' => true]);

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

        $bold = ['bold' => true];
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
        for ($i = 0; $i < 5; $i++) {
            $currentYear = $year - $i;
            $line1 = 'Năm ' . $currentYear;
            $this->section->addText($line1);

            $currentData = $giangVien->where('year', $currentYear);

            $table = $this->section->addTable('defaultTable');
            $table->addRow();
            $table->addCell(4000, $cellRowSpan)->addText('Phân cấp giảng viên và nghiên cứu viên', $bold);
            $table->addCell(3000, $cellColSpan)->addText('Cơ hữu/toàn thời gian', $bold);
            $table->addCell(3000, $cellColSpan)->addText('Hợp đồng/ thỉnh giảng', $bold);

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

            $table->addRow();
            $table->addCell(4000)->addText('Tổng', $bold);
            $table->addCell(1500)->addText($gv->total_1 + $tg->total_1);
            $table->addCell(1500)->addText('Tiến sĩ (%)');
            $table->addCell(1500)->addText($gv->total_2 + $tg->total_2);
            $table->addCell(1500)->addText('Tiến sĩ (%)');
            $this->section->addTextBreak(1);
        }


    }

    public function report16($canBo = [])
    {
        $line1 = '16. Thống kê số lượng cán bộ quản lý, nhân viên: ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');
        $bold = ['bold' => true];
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center');

        $table->addRow();
        $table->addCell(4000, $cellRowSpan)->addText('Phân cấp cán bộ, nhân viên', $bold);
        $table->addCell(6000, $cellColSpan)->addText('Số lượng ', $bold);

        $table->addRow();
        $table->addCell(4000, $cellRowContinue);
        $table->addCell(2000)->addText('Cơ hữu/toàn thời gian', $bold);
        $table->addCell(2000)->addText('Hợp đồng bán thời gian', $bold);
        $table->addCell(2000)->addText('Tổng số', $bold);

        $table->addRow();
        $table->addCell(4000)->addText('Cán bộ quản lý');
        $table->addCell(1500)->addText('100 ');
        $table->addCell(1500)->addText('100');
        $table->addCell(1500)->addText('100');

        $table->addRow();
        $table->addCell(4000)->addText('Nhân viên');
        $table->addCell(1500)->addText('200 ');
        $table->addCell(1500)->addText('2000');
        $table->addCell(1500)->addText('200');

        $table->addRow();
        $table->addCell(4000)->addText('Tổng', $bold);
        $table->addCell(1500)->addText('1000');
        $table->addCell(1500)->addText('1000');
        $table->addCell(1500)->addText('1000');
    }

    public function report17($canBoGioiTinh = [])
    {
        $line1 = '17. Thống kê số lượng cán bộ, giảng viên và nhân viên (gọi chung là cán bộ) của CSGD theo giới tính: ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500)->addText('TT', ['bold' => true]);
        $table->addCell(5000)->addText('Phân loại', ['bold' => true]);
        $table->addCell(1500)->addText('Nam ', ['bold' => true]);
        $table->addCell(1500)->addText('Nữ', ['bold' => true]);
        $table->addCell(1500)->addText('Tổng số', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(500)->addText('TT');
        $table->addCell(5000)->addText('Tên đơn vị');
        $table->addCell(1500)->addText('Năm thành lập ');
        $table->addCell(1500)->addText('Lĩnh vực  hoạt động');
        $table->addCell(1500)->addText('Số lượng nghiên cứu viên');
//        }
    }

    public function report18($giangVienTrinhDo = [])
    {
        $line1 = '18. Thống kê, phân loại giảng viên theo trình độ: ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500)->addText('TT', ['bold' => true]);
        $table->addCell(2000)->addText('Trình độ, học vị, chức danh', ['bold' => true]);
        $table->addCell(1250)->addText('GV trong biên chế trực tiếp giảng dạy ', ['bold' => true]);
        $table->addCell(1250)->addText('GV hợp đồng dài hạn trực tiếp giảng dạy', ['bold' => true]);
        $table->addCell(1250)->addText('Giảng viên kiêm nhiệm là cán bộ quản lý', ['bold' => true]);
        $table->addCell(1250)->addText('Giảng viên thỉnh giảng trong nước', ['bold' => true]);
        $table->addCell(1250)->addText('Giảng viên thỉnh giảng quốc tế', ['bold' => true]);
        $table->addCell(1250)->addText('Tổng số', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(500)->addText('1');
        $table->addCell(2000)->addText('Tên đơn vị');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
//        }

        $line2 = 'Tổng số giảng viên cơ hữu1:………………………. người';
        $this->section->addText($line2, [], ['indent' => true]);
        $line3 = 'Tỷ lệ giảng viên cơ hữu trên tổng số cán bộ cơ hữu: ....';
        $this->section->addText($line3, [], ['indent' => true]);
    }

    public function report19($giangVienDoTuoi = [])
    {
        $line1 = '19. Thống kê, phân loại giảng viên cơ hữu theo độ tuổi (số người): ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');
        $bold = ['bold' => true];
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center');
        $cellColSpan5 = array('gridSpan' => 5, 'valign' => 'center');

        $table->addRow();
        $table->addCell(500, $cellRowSpan)->addText('TT', $bold);
        $table->addCell(2000, $cellRowSpan)->addText('Trình độ / học vị', $bold);
        $table->addCell(900, $cellRowSpan)->addText('Số lượng', $bold);
        $table->addCell(900, $cellRowSpan)->addText('Tỷ lệ (%)', $bold);
        $table->addCell(1300, $cellColSpan2)->addText('Phân loại theo giới tính', $bold);
        $table->addCell(4450, $cellColSpan5)->addText('Phân loại theo tuổi (người) ', $bold);

        $table->addRow();
        $table->addCell(500, $cellRowContinue);
        $table->addCell(2000, $cellRowContinue);
        $table->addCell(900, $cellRowContinue);
        $table->addCell(900, $cellRowContinue);
        $table->addCell(650)->addText('Nam', $bold);
        $table->addCell(650)->addText('Nữ', $bold);
        $table->addCell(900)->addText("dưới 30", $bold);
        $table->addCell(900)->addText('30-40', $bold);
        $table->addCell(900)->addText('41-50', $bold);
        $table->addCell(900)->addText('51-60', $bold);
        $table->addCell(850)->addText('trên 60', $bold);

//        foreach ($giangVienDoTuoi as $item){
        $table->addRow();
        $table->addCell(500)->addText(1);
        $table->addCell(2000)->addText(1);
        $table->addCell(900)->addText(1);
        $table->addCell(900)->addText(1);
        $table->addCell(650)->addText('1');
        $table->addCell(650)->addText('1');
        $table->addCell(900)->addText("1");
        $table->addCell(900)->addText('1');
        $table->addCell(900)->addText('1');
        $table->addCell(900)->addText('1');
        $table->addCell(850)->addText('1');
//        }
        $line2 = 'Độ tuổi trung bình của giảng viên cơ hữu:..........................tuổi ';
        $this->section->addText($line2, [], ['indent' => true]);
        $line2 = 'Tỷ lệ giảng viên cơ hữu có trình độ tiến sĩ trở lên trên tổng số giảng viên cơ hữu của CSGD: ................. ';
        $this->section->addText($line2, [], ['indent' => true]);
        $line2 = 'Tỷ lệ giảng viên cơ hữu có trình độ thạc sĩ trên tổng số giảng viên cơ hữu của CSGD: ....................... ';
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report20()
    {
        $line1 = '20. Thống kê, phân loại giảng viên cơ hữu theo mức độ thường xuyên sử dụng ngoại ngữ và tin học cho công tác giảng dạy và nghiên cứu: ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');
        $bold = ['bold' => true];
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center');

        $table->addRow();
        $table->addCell(500, $cellRowSpan)->addText('TT', $bold);
        $table->addCell(5500, $cellRowSpan)->addText('Tần suất sử dụng', $bold);
        $table->addCell(4000, $cellColSpan2)->addText('Tỷ lệ (%) giảng viên cơ hữu sử dụng ngoại ngữ và tin học', $bold);

        $table->addRow();
        $table->addCell(500, $cellRowContinue);
        $table->addCell(5500, $cellRowContinue);
        $table->addCell(2000)->addText('Ngoại ngữ', $bold);
        $table->addCell(2000)->addText('Tin học', $bold);

//        foreach ($giangVienDoTuoi as $item){
        $table->addRow();
        $table->addCell(500)->addText(1);
        $table->addCell(5500)->addText('Luôn sử dụng (trên 80% thời gian của công việc)');
        $table->addCell(2000)->addText('1');
        $table->addCell(2000)->addText('1');
//        }

    }

    public function report21($svNhapHoc = [])
    {
        $line1 = '21. Tổng số người học đăng ký dự thi vào CSGD, trúng tuyển và nhập học trong 5 năm gần đây hệ chính quy ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(1250)->addText('Đối tượng, thời gian (năm)', ['bold' => true]);
        $table->addCell(1250)->addText('Số thí sinh dự tuyển(người) ', ['bold' => true]);
        $table->addCell(1250)->addText('Số trúng tuyển (người)', ['bold' => true]);
        $table->addCell(1250)->addText('Tỷ lệ cạnh tranh', ['bold' => true]);
        $table->addCell(1250)->addText('Số nhập học thực tế (người)', ['bold' => true]);
        $table->addCell(1250)->addText('Điểm tuyển đầu vào (thang điểm 30)', ['bold' => true]);
        $table->addCell(1250)->addText('Điểm trung bình của người học được tuyển', ['bold' => true]);
        $table->addCell(1250)->addText('Số lượng sinh viên quốc tế nhập học (người)', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('Tên đơn vị');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
//        }

        $line2 = 'Số lượng người học hệ chính quy đang học tập tại CSGD: .......................... người.';
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report22($svNhapHoc = [])
    {
        $line1 = '22. Tổng số người học đăng ký dự thi vào CSGD, trúng tuyển và nhập học trong 5 năm gần đây hệ không chính quy ';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(1250)->addText('Đối tượng, thời gian (năm)', ['bold' => true]);
        $table->addCell(1250)->addText('Số thí sinh dự tuyển(người) ', ['bold' => true]);
        $table->addCell(1250)->addText('Số trúng tuyển (người)', ['bold' => true]);
        $table->addCell(1250)->addText('Tỷ lệ cạnh tranh', ['bold' => true]);
        $table->addCell(1250)->addText('Số nhập học thực tế (người)', ['bold' => true]);
        $table->addCell(1250)->addText('Điểm tuyển đầu vào (thang điểm 30)', ['bold' => true]);
        $table->addCell(1250)->addText('Điểm trung bình của người học được tuyển', ['bold' => true]);
        $table->addCell(1250)->addText('Số lượng sinh viên quốc tế nhập học (người)', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('Tên đơn vị');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
//        }
    }

    public function report23($svNhapHoc = [])
    {
        $line1 = '23. Ký túc xá cho sinh viên:';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000)->addText('Các tiêu chí', ['bold' => true]);
        $table->addCell(1250)->addText('2016', ['bold' => true]);
        $table->addCell(1250)->addText('2017', ['bold' => true]);
        $table->addCell(1250)->addText('2018', ['bold' => true]);
        $table->addCell(1250)->addText('2019', ['bold' => true]);
        $table->addCell(1250)->addText('2020', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(3000)->addText('1');
        $table->addCell(1250)->addText('Tên đơn vị');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
//        }
    }

    public function report24($svNhapHoc = [])
    {
        $line1 = '24. Sinh viên tham gia nghiên cứu khoa học:';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000)->addText('', ['bold' => true]);
        $table->addCell(1250)->addText('2016', ['bold' => true]);
        $table->addCell(1250)->addText('2017', ['bold' => true]);
        $table->addCell(1250)->addText('2018', ['bold' => true]);
        $table->addCell(1250)->addText('2019', ['bold' => true]);
        $table->addCell(1250)->addText('2020', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(3000)->addText('Số lượng (người)');
        $table->addCell(1250)->addText('Tên đơn vị');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');

        $table->addRow(500);
        $table->addCell(3000)->addText('Tỷ lệ (%) trên tổng số sinh viên ');
        $table->addCell(1250)->addText('Tên đơn vị');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
//        }
    }

    public function report25($svNhapHoc = [])
    {
        $line1 = '25. Thống kê số lượng người học tốt nghiệp trong 5 năm gần đây:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 5, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000, $cellRowSpan)->addText('Các tiêu chí', ['bold' => true]);
        $table->addCell(6250, $cellColSpan)->addText('Năm tốt nghiệp', ['bold' => true]);

        $table->addRow(500);
        $table->addCell(3000, $cellRowContinue);
        $table->addCell(1250)->addText('2016', ['bold' => true]);
        $table->addCell(1250)->addText('2017', ['bold' => true]);
        $table->addCell(1250)->addText('2018', ['bold' => true]);
        $table->addCell(1250)->addText('2019', ['bold' => true]);
        $table->addCell(1250)->addText('2020', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(3000)->addText('Số lượng (người)');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');

//        }
    }

    public function report26($svNhapHoc = [])
    {
        $line1 = '26. Tình trạng tốt nghiệp của sinh viên đại học hệ chính quy:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 5, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000, $cellRowSpan)->addText('Các tiêu chí', ['bold' => true]);
        $table->addCell(6250, $cellColSpan)->addText('Năm tốt nghiệp', ['bold' => true]);

        $table->addRow(500);
        $table->addCell(3000, $cellRowContinue);
        $table->addCell(1250)->addText('2016', ['bold' => true]);
        $table->addCell(1250)->addText('2017', ['bold' => true]);
        $table->addCell(1250)->addText('2018', ['bold' => true]);
        $table->addCell(1250)->addText('2019', ['bold' => true]);
        $table->addCell(1250)->addText('2020', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(3000)->addText('Số lượng (người)');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');

//        }
    }

    public function report27($svNhapHoc = [])
    {
        $line1 = '27. Tình trạng tốt nghiệp của sinh viên cao đẳng hệ chính quy:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 5, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000, $cellRowSpan)->addText('Các tiêu chí', ['bold' => true]);
        $table->addCell(6250, $cellColSpan)->addText('Năm tốt nghiệp', ['bold' => true]);

        $table->addRow(500);
        $table->addCell(3000, $cellRowContinue);
        $table->addCell(1250)->addText('2016', ['bold' => true]);
        $table->addCell(1250)->addText('2017', ['bold' => true]);
        $table->addCell(1250)->addText('2018', ['bold' => true]);
        $table->addCell(1250)->addText('2019', ['bold' => true]);
        $table->addCell(1250)->addText('2020', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(3000)->addText('Số lượng (người)');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');

//        }
    }

    public function report28($svNhapHoc = [])
    {
        $line1 = '28. Số lượng đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ của
        nhà trường được nghiệm thu trong 5 năm gần đây:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 5, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500, $cellRowSpan)->addText('TT', ['bold' => true]);
        $table->addCell(2500, $cellRowSpan)->addText('Các tiêu chí', ['bold' => true]);
        $table->addCell(6250, $cellColSpan)->addText('Năm tốt nghiệp', ['bold' => true]);

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(2500, $cellRowContinue);
        $table->addCell(1250)->addText('2016', ['bold' => true]);
        $table->addCell(1250)->addText('2017', ['bold' => true]);
        $table->addCell(1250)->addText('2018', ['bold' => true]);
        $table->addCell(1250)->addText('2019', ['bold' => true]);
        $table->addCell(1250)->addText('2020', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(500)->addText('1');
        $table->addCell(3000)->addText('Số lượng (người)');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');

//        }

        $line2 = '* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước';
        $this->section->addText($line2, [], ['indent' => true]);
        $line2 = 'Tỷ số đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ trên cán bộ cơ hữu: ........';
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report29($svNhapHoc = [])
    {
        $line1 = '29. Doanh thu từ nghiên cứu khoa học và chuyển giao công nghệ của CSGD trong 5 năm gần đây:';
        $this->section->addText($line1);
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500)->addText('TT', ['bold' => true]);
        $table->addCell(1500)->addText('Năm', ['bold' => true]);
        $table->addCell(2500)->addText('Doanh thu từ NCKH và chuyển giao công nghệ (triệu VNĐ)', ['bold' => true]);
        $table->addCell(2500)->addText('Tỷ lệ doanh thu từ NCKH và chuyển giao công nghệ so với tổng kinh phí đầu vào của CSGD (%)', ['bold' => true]);
        $table->addCell(2500)->addText('Tỷ số doanh thu từ NCKH và chuyển giao công nghệ trên cán bộ cơ hữu(triệu VNĐ/ người)', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(500)->addText('1');
        $table->addCell(1500)->addText('2019');
        $table->addCell(2500)->addText('1 ');
        $table->addCell(2500)->addText('1');
        $table->addCell(2500)->addText('1');
//        }
    }

    public function report30($svNhapHoc = [])
    {
        $line1 = '30. Số lượng cán bộ cơ hữu của CSGD tham gia thực hiện đề tài khoa học trong 5 năm gần đây:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000, $cellRowSpan)->addText('Số lượng đề tài', ['bold' => true]);
        $table->addCell(4000, $cellColSpan)->addText('Số lượng cán bộ tham gia', ['bold' => true]);
        $table->addCell(3000, $cellColSpan)->addText('Ghi chú', ['bold' => true]);

        $table->addRow(500);
        $table->addCell(3000, $cellRowContinue);
        $table->addCell(1250)->addText('Đề tài cấp Nhà nước', ['bold' => true]);
        $table->addCell(1250)->addText('Đề tài cấp Bộ*', ['bold' => true]);
        $table->addCell(1250)->addText('Đề tài cấp trường', ['bold' => true]);
        $table->addCell(3000, $cellRowContinue);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(500)->addText('1');
        $table->addCell(3000)->addText('Số lượng (người)');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1 ');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');
        $table->addCell(1250)->addText('1');

//        }

        $line2 = '* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước';
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report31($svNhapHoc = [])
    {
        $line1 = '31. Số lượng sách của CSGD được xuất bản trong 5 năm gần đây:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 6, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(500, $cellRowSpan)->addText('TT', ['bold' => true]);
        $table->addCell(3000, $cellRowSpan)->addText('Phân loại sách', ['bold' => true]);
        $table->addCell(6000, $cellColSpan)->addText('Số lượng', ['bold' => true]);

        $table->addRow(500);
        $table->addCell(500, $cellRowContinue);
        $table->addCell(3000, $cellRowContinue);
        $table->addCell(1000)->addText('2016', ['bold' => true]);
        $table->addCell(1000)->addText('2017', ['bold' => true]);
        $table->addCell(1000)->addText('2018', ['bold' => true]);
        $table->addCell(1000)->addText('2019', ['bold' => true]);
        $table->addCell(1000)->addText('2020', ['bold' => true]);
        $table->addCell(1000)->addText('Tổng số', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(500)->addText('1');
        $table->addCell(3000)->addText('Sách chuyên khảo');
        $table->addCell(1000)->addText(1);
        $table->addCell(1000)->addText(1);
        $table->addCell(1000)->addText(1);
        $table->addCell(1000)->addText(1);
        $table->addCell(1000)->addText(1);
        $table->addCell(1000)->addText(1);

//        }

        $line2 = 'Tỷ số sách đã được xuất bản trên cán bộ cơ hữu: ........................';
        $this->section->addText($line2, [], ['indent' => true]);
    }

    public function report32($svNhapHoc = [])
    {
        $line1 = '32. Số lượng cán bộ cơ hữu của CSGD tham gia viết sách trong 5 năm gần đây:';
        $this->section->addText($line1);

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 6, 'valign' => 'center');
        $table = $this->section->addTable('defaultTable');

        $table->addRow(500);
        $table->addCell(3000, $cellRowSpan)->addText('Số lượng sách', ['bold' => true]);
        $table->addCell(6000, $cellColSpan)->addText('Số lượng cán bộ cơ hữu tham gia viết sách', ['bold' => true]);

        $table->addRow(500);
        $table->addCell(3000, $cellRowContinue);
        $table->addCell(1250)->addText('Sách chuyên khảo', ['bold' => true]);
        $table->addCell(1250)->addText('Sách giáo trình', ['bold' => true]);
        $table->addCell(1250)->addText('Sách tham khảo', ['bold' => true]);
        $table->addCell(1250)->addText('Sách hướng dẫn', ['bold' => true]);

//        foreach ($canBoGioiTinh as $item) {
        $table->addRow(500);
        $table->addCell(3000)->addText('Sách chuyên khảo');
        $table->addCell(1250)->addText(1);
        $table->addCell(1250)->addText(1);
        $table->addCell(1250)->addText(1);
        $table->addCell(1250)->addText(1);

//        }

    }


}
