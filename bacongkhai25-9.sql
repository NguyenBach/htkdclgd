-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: bacongkhai
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` tinytext,
  `fullname` tinytext,
  `email` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `admin_token` mediumtext,
  `role_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admins_role_idx` (`role_id`),
  CONSTRAINT `fk_admins_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin','$2a$10$3yrboc0r20fTMHUxoq61Zuf95elDKf40.GtyCBteOkQCCRlTzRKNe','Super Admin','admin@admin.com',0,'',1,NULL,NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bang_sang_che`
--

DROP TABLE IF EXISTS `bang_sang_che`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bang_sang_che` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bang_sang_che_universities1_idx` (`university_id`),
  CONSTRAINT `fk_bang_sang_che_universities1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bang_sang_che`
--

LOCK TABLES `bang_sang_che` WRITE;
/*!40000 ALTER TABLE `bang_sang_che` DISABLE KEYS */;
INSERT INTO `bang_sang_che` VALUES (1,2019,1,'10','2019-07-29 08:52:08','2019-07-29 08:52:08');
/*!40000 ALTER TABLE `bang_sang_che` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bao_cao_tai_hoi_thao`
--

DROP TABLE IF EXISTS `bao_cao_tai_hoi_thao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bao_cao_tai_hoi_thao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `phan_loai_hoi_thao_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sl_tap_chi_duoc_dang_universities1_idx` (`university_id`),
  KEY `fk_bao_cao_tai_hoi_thao_phan_loai_hoi_thao1_idx` (`phan_loai_hoi_thao_id`),
  CONSTRAINT `fk_bao_cao_tai_hoi_thao_phan_loai_hoi_thao1` FOREIGN KEY (`phan_loai_hoi_thao_id`) REFERENCES `phan_loai_hoi_thao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sl_tap_chi_duoc_dang_universities10` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bao_cao_tai_hoi_thao`
--

LOCK TABLES `bao_cao_tai_hoi_thao` WRITE;
/*!40000 ALTER TABLE `bao_cao_tai_hoi_thao` DISABLE KEYS */;
INSERT INTO `bao_cao_tai_hoi_thao` VALUES (1,1,2019,12,1,'2019-07-16 09:02:44','2019-07-16 09:02:44'),(2,1,2019,14,2,'2019-07-16 09:02:44','2019-07-16 09:02:44'),(3,1,2019,15,3,'2019-07-16 09:02:44','2019-07-16 09:02:44');
/*!40000 ALTER TABLE `bao_cao_tai_hoi_thao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `founded_year` int(11) NOT NULL,
  `field` tinytext NOT NULL,
  `number_researcher` int(11) NOT NULL,
  `number_officer` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  CONSTRAINT `fk_branches_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,1,'Phòng Họp','phong-hop',2019,'Ăn chơi',0,0,'2019-06-19 08:04:03','2019-06-19 08:04:03'),(2,1,'Phòng Họp 1','phong-hop-1',2019,'Ăn chơi',0,0,'2019-06-19 08:04:14','2019-06-19 08:04:14'),(3,1,'Phòng Họp 12','phong-hop-12',2019,'Ăn chơi',10,20,'2019-06-19 08:05:04','2019-06-19 08:05:04');
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cap_de_tai`
--

DROP TABLE IF EXISTS `cap_de_tai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cap_de_tai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cap_de_tai`
--

LOCK TABLES `cap_de_tai` WRITE;
/*!40000 ALTER TABLE `cap_de_tai` DISABLE KEYS */;
INSERT INTO `cap_de_tai` VALUES (1,'Cấp nhà nước',NULL,NULL),(2,'Cấp bộ',NULL,NULL),(3,'Cấp trường',NULL,NULL);
/*!40000 ALTER TABLE `cap_de_tai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cau_hoi_tot_nghiep`
--

DROP TABLE IF EXISTS `cau_hoi_tot_nghiep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cau_hoi_tot_nghiep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`group_id`),
  CONSTRAINT `cau_hoi` FOREIGN KEY (`group_id`) REFERENCES `question_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cau_hoi_tot_nghiep`
--

LOCK TABLES `cau_hoi_tot_nghiep` WRITE;
/*!40000 ALTER TABLE `cau_hoi_tot_nghiep` DISABLE KEYS */;
INSERT INTO `cau_hoi_tot_nghiep` VALUES (1,'Số lượng sinh viên tốt nghiệp',1,NULL,NULL),(2,'Tỷ lệ sinh viên tốt nghiệp so với số tuyển vào',2,NULL,NULL),(3,'Tỷ lệ sinh viên trả lời đã học được những kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp ',3,NULL,NULL),(4,'Tỷ lệ sinh viên trả lời chỉ học được một phần kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp',3,NULL,NULL),(5,'Tỷ lệ sinh viên trả lời KHÔNG học được những kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp',3,NULL,NULL),(6,'Tỷ lệ có việc làm đúng ngành đào tạo Sau 6 tháng tốt nghiệp',4,NULL,NULL),(7,'Tỷ lệ có việc làm đúng ngành đào tạo Sau 12 tháng tốt nghiệp',4,NULL,NULL),(8,'Tỷ lệ có việc làm trái ngành đào tạo ',4,NULL,NULL),(9,'Tỷ lệ tự tạo được việc làm',4,NULL,NULL),(10,'Thu nhập bình quân/tháng của sinh viên có việc làm',4,NULL,NULL),(11,'Tỷ lệ sinh viên đáp ứng yêu cầu của công việc, có thể sử dụng được ngay',5,NULL,NULL),(12,'Tỷ lệ sinh viên cơ bản đáp ứng yêu cầu của công việc, nhưng phải đào tạo thêm',5,NULL,NULL),(13,'Tỷ lệ sinh viên phải được đào tạo lại hoặc đào tạo bổ sung ít nhất 6 tháng',5,NULL,NULL);
/*!40000 ALTER TABLE `cau_hoi_tot_nghiep` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cb_tham_gia_nckh`
--

DROP TABLE IF EXISTS `cb_tham_gia_nckh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cb_tham_gia_nckh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `cap_de_tai_id` int(11) NOT NULL,
  `tu_1_3` int(11) NOT NULL DEFAULT '0',
  `tu_4_6` int(11) NOT NULL DEFAULT '0',
  `tren_6` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cb_tham_gia_nckh_universities1_idx` (`university_id`),
  KEY `fk_cb_tham_gia_nckh_cap_de_tai1_idx` (`cap_de_tai_id`),
  CONSTRAINT `fk_cb_tham_gia_nckh_cap_de_tai1` FOREIGN KEY (`cap_de_tai_id`) REFERENCES `cap_de_tai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cb_tham_gia_nckh_universities1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cb_tham_gia_nckh`
--

LOCK TABLES `cb_tham_gia_nckh` WRITE;
/*!40000 ALTER TABLE `cb_tham_gia_nckh` DISABLE KEYS */;
INSERT INTO `cb_tham_gia_nckh` VALUES (1,1,2019,1,1,10,12,'2019-07-09 08:57:59','2019-07-09 08:57:59'),(2,1,2019,2,2,10,12,'2019-07-09 08:57:59','2019-07-09 08:57:59'),(3,1,2019,3,3,10,12,'2019-07-09 08:57:59','2019-07-09 08:57:59');
/*!40000 ALTER TABLE `cb_tham_gia_nckh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cb_viet_sach`
--

DROP TABLE IF EXISTS `cb_viet_sach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cb_viet_sach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tu_1_3` int(11) NOT NULL,
  `tu_4_6` int(11) NOT NULL,
  `tren_6` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `universities_id` int(11) NOT NULL,
  `loai_sach_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cb_viet_sach_universities1_idx` (`universities_id`),
  KEY `fk_cb_viet_sach_loai_sach1_idx` (`loai_sach_id`),
  CONSTRAINT `fk_cb_viet_sach_loai_sach1` FOREIGN KEY (`loai_sach_id`) REFERENCES `loai_sach` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cb_viet_sach_universities1` FOREIGN KEY (`universities_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cb_viet_sach`
--

LOCK TABLES `cb_viet_sach` WRITE;
/*!40000 ALTER TABLE `cb_viet_sach` DISABLE KEYS */;
/*!40000 ALTER TABLE `cb_viet_sach` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `slug` tinytext NOT NULL,
  `university_id` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (2,'Phòng hành chính nhân sự','Ph-ng-h-nh-ch-nh-nh-n-s-',1,2,'2019-06-13 09:05:44','2019-08-05 08:58:09'),(3,'Phòng hành chính nhân sự','phong-hanh-chinh-nhan-su',0,NULL,'2019-06-13 09:15:43','2019-06-13 09:15:43'),(4,'Phòng hành chính nhân sự','phong-hanh-chinh-nhan-su',0,NULL,'2019-06-13 09:21:46','2019-06-13 09:21:46'),(5,'Phòng hành chính nhân sự','phong-hanh-chinh-nhan-su',0,NULL,'2019-06-13 09:21:49','2019-06-13 09:21:49'),(6,'Phòng hành chính nhân sự','phong-hanh-chinh-nhan-su',0,NULL,'2019-06-16 03:10:38','2019-06-16 03:10:38'),(7,'Phòng hành chính nhân sự','phong-hanh-chinh-nhan-su',1,2,'2019-06-16 03:11:26','2019-06-16 03:11:26');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dien_tich`
--

DROP TABLE IF EXISTS `dien_tich`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dien_tich` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `noi_dung` int(11) NOT NULL,
  `dien_tich` float NOT NULL,
  `hinh_thuc` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `YEAR` (`year`),
  CONSTRAINT `fk_dien_tichs_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dien_tich`
--

LOCK TABLES `dien_tich` WRITE;
/*!40000 ALTER TABLE `dien_tich` DISABLE KEYS */;
INSERT INTO `dien_tich` VALUES (1,1,2019,1,10010,1,'2019-07-29 09:44:17','2019-07-29 09:44:27'),(2,1,2019,2,1000,1,'2019-07-29 09:44:17','2019-07-29 09:44:17'),(3,1,2019,3,1000,1,'2019-07-29 09:44:17','2019-07-29 09:44:17'),(4,1,2019,4,1000,1,'2019-07-29 09:44:17','2019-07-29 09:44:17');
/*!40000 ALTER TABLE `dien_tich` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doanh_thu_nckh`
--

DROP TABLE IF EXISTS `doanh_thu_nckh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doanh_thu_nckh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `dt_nckh_va_cgcn` int(11) NOT NULL COMMENT 'Doanh thu từ NCKH và chuyển giao công nghệ (triệu VNĐ)',
  `ti_le_ss_vs_kinh_phi` float NOT NULL COMMENT 'Tỷ lệ doanh thu từ\nNCKH và chuyển giao\ncông nghệ so với tổng\nkinh phí đầu vào của\nnhà trường (%)',
  `ti_so_tren_cb_ch` float NOT NULL COMMENT 'Tỷ số doanh thu từ\nNCKH và chuyển\ngiao công nghệ trên\ncán bộ cơ hữu (triệu\nVNĐ/ người)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_doanh_thu_nckh_universities1_idx` (`university_id`),
  CONSTRAINT `fk_doanh_thu_nckh_universities1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doanh_thu_nckh`
--

LOCK TABLES `doanh_thu_nckh` WRITE;
/*!40000 ALTER TABLE `doanh_thu_nckh` DISABLE KEYS */;
INSERT INTO `doanh_thu_nckh` VALUES (1,1,2019,10000,20,101,'2019-07-08 08:38:01','2019-07-08 08:38:07');
/*!40000 ALTER TABLE `doanh_thu_nckh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doi_tuong_kiem_dinhs`
--

DROP TABLE IF EXISTS `doi_tuong_kiem_dinhs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doi_tuong_kiem_dinhs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doi_tuong_kiem_dinhs`
--

LOCK TABLES `doi_tuong_kiem_dinhs` WRITE;
/*!40000 ALTER TABLE `doi_tuong_kiem_dinhs` DISABLE KEYS */;
INSERT INTO `doi_tuong_kiem_dinhs` VALUES (1,1,'Cơ sở giáo dục','2019-08-20 07:09:59','2019-08-20 07:09:59'),(2,1,'Cơ sở giáo dục','2019-08-20 07:10:14','2019-08-20 07:10:14');
/*!40000 ALTER TABLE `doi_tuong_kiem_dinhs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `education_types`
--

DROP TABLE IF EXISTS `education_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `education_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `education_types`
--

LOCK TABLES `education_types` WRITE;
/*!40000 ALTER TABLE `education_types` DISABLE KEYS */;
INSERT INTO `education_types` VALUES (1,0,'Đại học','dai-hoc','2019-06-18 07:51:50','2019-06-18 07:51:50'),(2,1,'Đại học','dai-hoc','2019-06-18 09:32:56','2019-06-18 09:32:56');
/*!40000 ALTER TABLE `education_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculties`
--

DROP TABLE IF EXISTS `faculties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `slug` tinytext NOT NULL,
  `education_type_id` int(11) NOT NULL COMMENT 'đại học, cao đẳng\n',
  `number_education_program` int(11) NOT NULL COMMENT 'số chương trình đào tạo\n',
  `students` int(11) NOT NULL COMMENT 'số sinh viên\n',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `EDUCATION_TYPE` (`education_type_id`),
  CONSTRAINT `fk_falcuties_education_type` FOREIGN KEY (`education_type_id`) REFERENCES `education_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_falcuties_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculties`
--

LOCK TABLES `faculties` WRITE;
/*!40000 ALTER TABLE `faculties` DISABLE KEYS */;
INSERT INTO `faculties` VALUES (2,1,'Khoa Công nghệ thông tin','',2,0,0,'2019-06-18 10:04:52','2019-06-18 10:04:52'),(3,1,'Khoa Công nghệ thông tin','',2,0,0,'2019-06-18 10:05:08','2019-06-18 10:05:08'),(4,1,'Khoa Công nghệ thông tin','',2,0,0,'2019-06-18 10:05:09','2019-06-18 10:05:09'),(5,1,'Khoa Công nghệ thông tin','khoa-cong-nghe-thong-tin',2,0,0,'2019-06-18 10:12:28','2019-06-18 10:12:28'),(6,1,'Khoa Công nghệ thông tin 1','khoa-cong-nghe-thong-tin-1',2,0,0,'2019-06-18 10:14:03','2019-06-18 10:14:03');
/*!40000 ALTER TABLE `faculties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `key_officers`
--

DROP TABLE IF EXISTS `key_officers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `key_officers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `degree` varchar(100) NOT NULL COMMENT 'học vị',
  `position` varchar(100) NOT NULL COMMENT 'chức vụ\n',
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `fk_key_officers_departments_idx` (`department_id`),
  CONSTRAINT `fk_key_officers_departments` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_key_officers_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `key_officers`
--

LOCK TABLES `key_officers` WRITE;
/*!40000 ALTER TABLE `key_officers` DISABLE KEYS */;
/*!40000 ALTER TABLE `key_officers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kiem_dinh_chat_luongs`
--

DROP TABLE IF EXISTS `kiem_dinh_chat_luongs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiem_dinh_chat_luongs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `doi_tuong` int(11) NOT NULL,
  `bo_tieu_chuan` int(11) NOT NULL,
  `nam_hoan_thanh_1` int(11) DEFAULT NULL,
  `nam_cap_nhat` tinytext,
  `to_chuc` int(11) DEFAULT NULL,
  `nam_danh_gia` varchar(45) DEFAULT NULL,
  `ket_qua` float DEFAULT NULL,
  `ngay_cap` varchar(45) DEFAULT NULL,
  `gia_tri_den` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `fk_kiem_dinh_chat_luongs_doi_tuong_idx` (`doi_tuong`),
  KEY `fk_kiem_dinh_chat_luongs_tieu_chuan_idx` (`bo_tieu_chuan`),
  KEY `fk_kiem_dinh_chat_luongs_to_chuc_idx` (`to_chuc`),
  CONSTRAINT `fk_kiem_dinh_chat_luongs_doi_tuong` FOREIGN KEY (`doi_tuong`) REFERENCES `doi_tuong_kiem_dinhs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_kiem_dinh_chat_luongs_tieu_chuan` FOREIGN KEY (`bo_tieu_chuan`) REFERENCES `tieu_chuan_kiem_dinhs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_kiem_dinh_chat_luongs_to_chuc` FOREIGN KEY (`to_chuc`) REFERENCES `to_chuc_kiem_dinh` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_kiem_dinh_chat_luongs_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kiem_dinh_chat_luongs`
--

LOCK TABLES `kiem_dinh_chat_luongs` WRITE;
/*!40000 ALTER TABLE `kiem_dinh_chat_luongs` DISABLE KEYS */;
INSERT INTO `kiem_dinh_chat_luongs` VALUES (1,1,1,1,2018,'2019',1,'2017',90,'20/10/2018','20/10/2020','2019-08-20 07:30:40','2019-08-20 07:30:40'),(2,1,1,1,2018,'2019',1,'2017',90,'20/10/2018','20/10/2020','2019-08-20 07:30:42','2019-08-20 07:30:42'),(3,1,1,1,2018,'2019',1,'2017',90,'20/10/2018','20/10/2020','2019-08-20 07:30:44','2019-08-20 07:30:44');
/*!40000 ALTER TABLE `kiem_dinh_chat_luongs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kinh_phi`
--

DROP TABLE IF EXISTS `kinh_phi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kinh_phi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `thu_nguon_thu` double DEFAULT NULL,
  `thu_hoc_phi` double DEFAULT NULL,
  `chi_nghien_cuu` double DEFAULT NULL,
  `thu_nghien_cuu` double DEFAULT NULL,
  `chi_dao_tao` double DEFAULT NULL,
  `chi_phat_trien` double DEFAULT NULL,
  `chi_ket_noi` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `YEAR` (`year`),
  CONSTRAINT `fk_kinh_phi_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kinh_phi`
--

LOCK TABLES `kinh_phi` WRITE;
/*!40000 ALTER TABLE `kinh_phi` DISABLE KEYS */;
/*!40000 ALTER TABLE `kinh_phi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturer_by_ages`
--

DROP TABLE IF EXISTS `lecturer_by_ages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecturer_by_ages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `percent` float NOT NULL,
  `lecturer_degree` int(11) NOT NULL,
  `lecturer_man` int(11) NOT NULL,
  `lecturer_woman` int(11) NOT NULL,
  `less_30` int(11) NOT NULL,
  `less_40` int(11) NOT NULL,
  `less_50` int(11) NOT NULL,
  `less_60` int(11) NOT NULL,
  `over_60` int(11) NOT NULL,
  `avg_age` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `YEAR` (`year`),
  CONSTRAINT `fk_lecturer_by_ages_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturer_by_ages`
--

LOCK TABLES `lecturer_by_ages` WRITE;
/*!40000 ALTER TABLE `lecturer_by_ages` DISABLE KEYS */;
INSERT INTO `lecturer_by_ages` VALUES (1,1,2019,10,5,1,2,8,1,2,3,4,0,40,'2019-07-01 09:01:43','2019-07-01 09:10:35'),(2,1,2019,11,5,2,2,8,1,2,3,4,0,40,'2019-07-01 09:01:43','2019-07-01 09:10:35'),(3,1,2019,12,5,3,2,8,1,2,3,4,0,40,'2019-07-01 09:01:43','2019-07-01 09:10:35'),(4,1,2019,13,5,4,2,8,1,2,3,4,0,40,'2019-07-01 09:01:43','2019-07-01 09:10:35'),(5,1,2019,111,5,5,2,8,1,2,3,4,0,40,'2019-07-01 09:01:43','2019-07-01 09:10:35'),(6,1,2019,15,5,6,2,8,1,2,3,4,0,40,'2019-07-01 09:01:43','2019-07-01 09:10:35'),(7,1,2019,16,5,7,2,8,1,2,3,4,0,40,'2019-07-01 09:01:43','2019-07-01 09:10:35'),(8,1,2019,17,5,8,2,8,1,2,3,4,0,40,'2019-07-01 09:01:43','2019-07-01 09:10:35'),(9,1,2019,18,5,9,2,8,1,2,3,4,0,40,'2019-07-01 09:01:43','2019-07-01 09:10:35');
/*!40000 ALTER TABLE `lecturer_by_ages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturer_by_degrees`
--

DROP TABLE IF EXISTS `lecturer_by_degrees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecturer_by_degrees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `lecturer_type` int(11) NOT NULL COMMENT '1: Giangr viên trong biên chế\n2: Giảng viên dài hạn\n3: Giảng viên kiêm nhiệm quan lý\n4: thỉnh giảng trong nước\n5: thỉnh giảng quốc tế\n',
  `professor` int(11) NOT NULL,
  `associate_professor` int(11) NOT NULL,
  `science_doctor` int(11) NOT NULL,
  `doctor` int(11) NOT NULL,
  `master` int(11) NOT NULL,
  `undergraduate` int(11) NOT NULL,
  `college` int(11) NOT NULL,
  `intermediate` int(11) NOT NULL,
  `other` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `YEAR` (`year`),
  CONSTRAINT `fk_lecturer_by_degree_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturer_by_degrees`
--

LOCK TABLES `lecturer_by_degrees` WRITE;
/*!40000 ALTER TABLE `lecturer_by_degrees` DISABLE KEYS */;
INSERT INTO `lecturer_by_degrees` VALUES (18,1,2019,1,15,0,0,0,0,0,0,0,0,'2019-06-27 08:40:33','2019-06-27 08:41:03'),(19,1,2019,2,0,0,0,0,0,0,0,0,0,'2019-06-27 08:40:33','2019-06-27 08:40:33'),(20,1,2019,3,0,0,0,0,0,0,0,0,0,'2019-06-27 08:40:33','2019-06-27 08:40:33'),(21,1,2019,4,0,0,0,0,0,0,0,0,0,'2019-06-27 08:40:33','2019-06-27 08:40:33'),(22,1,2019,5,0,0,0,0,0,0,0,0,0,'2019-06-27 08:40:33','2019-06-27 08:40:33');
/*!40000 ALTER TABLE `lecturer_by_degrees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturer_by_fls`
--

DROP TABLE IF EXISTS `lecturer_by_fls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecturer_by_fls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `frequency` int(11) NOT NULL COMMENT '1: thường xuyên \n2: ...\n',
  `foreign_language` float NOT NULL COMMENT '%',
  `information_technology` float NOT NULL COMMENT '%',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `YEAR` (`year`),
  CONSTRAINT `fk_lecturer_by_fls_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturer_by_fls`
--

LOCK TABLES `lecturer_by_fls` WRITE;
/*!40000 ALTER TABLE `lecturer_by_fls` DISABLE KEYS */;
INSERT INTO `lecturer_by_fls` VALUES (1,1,2019,1,10,15,'2019-07-01 09:55:43','2019-07-01 09:55:43'),(2,1,2019,2,111,15,'2019-07-01 16:56:05','2019-07-01 09:56:05'),(3,1,2019,3,12,15,'2019-07-01 09:55:43','2019-07-01 09:55:43'),(4,1,2019,4,13,15,'2019-07-01 09:55:43','2019-07-01 09:55:43'),(5,1,2019,5,14,15,'2019-07-01 09:55:43','2019-07-01 09:55:43'),(6,1,2018,1,10,15,'2019-07-01 09:55:55','2019-07-01 09:55:55'),(7,1,2018,2,11,15,'2019-07-01 09:55:55','2019-07-01 09:55:55'),(8,1,2018,3,12,15,'2019-07-01 09:55:55','2019-07-01 09:55:55'),(9,1,2018,4,13,15,'2019-07-01 09:55:55','2019-07-01 09:55:55'),(10,1,2018,5,14,15,'2019-07-01 09:55:55','2019-07-01 09:55:55');
/*!40000 ALTER TABLE `lecturer_by_fls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturers`
--

DROP TABLE IF EXISTS `lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `lecturer_type` int(11) NOT NULL COMMENT '1: Giảng viên\n2: nghiên cứu viên\n',
  `total_1` int(11) NOT NULL COMMENT 'Cơ hữu\n',
  `percent_doctor_1` float NOT NULL,
  `total_2` int(11) NOT NULL COMMENT 'Thỉnh giảng\n',
  `percent_doctor_2` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `YEAR` (`year`),
  CONSTRAINT `fk_lecturers_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturers`
--

LOCK TABLES `lecturers` WRITE;
/*!40000 ALTER TABLE `lecturers` DISABLE KEYS */;
INSERT INTO `lecturers` VALUES (1,1,2019,1,1020,15,0,1,'2019-06-25 07:39:21','2019-06-25 08:08:18'),(2,1,2019,2,101,15,0,1,'2019-06-25 07:39:21','2019-06-25 08:08:18'),(5,1,2020,1,1020,15,0,1,'2019-06-25 07:58:21','2019-06-25 08:08:12'),(6,1,2020,2,101,15,0,1,'2019-06-25 07:58:21','2019-06-25 08:08:05');
/*!40000 ALTER TABLE `lecturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loai_sach`
--

DROP TABLE IF EXISTS `loai_sach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loai_sach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loai_sach`
--

LOCK TABLES `loai_sach` WRITE;
/*!40000 ALTER TABLE `loai_sach` DISABLE KEYS */;
INSERT INTO `loai_sach` VALUES (1,'Chuyên khảo ',NULL,NULL),(2,'Giáo trình',NULL,NULL),(3,'Tham khảo ',NULL,NULL),(4,'Hướng dẫn',NULL,NULL);
/*!40000 ALTER TABLE `loai_sach` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nguoi_hoc_tot_nghiep`
--

DROP TABLE IF EXISTS `nguoi_hoc_tot_nghiep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nguoi_hoc_tot_nghiep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `ncs_bv_luan_an_ts` int(11) NOT NULL DEFAULT '0' COMMENT 'Nghiên cứu sinh bảo vệ luận án tiền sĩ',
  `hv_tot_nghiep_ch` int(11) NOT NULL DEFAULT '0' COMMENT 'học viên tốt nghiệp cao học',
  `sv_cq_tn_dh` int(11) NOT NULL DEFAULT '0' COMMENT 'Sinh viên chính quy tốt nghiệp đại học',
  `sv_kcq_tn_dh` int(11) NOT NULL DEFAULT '0' COMMENT 'Sinh viên không chính quy tốt nghiệp đại học',
  `sv_cq_tn_cd` int(11) NOT NULL DEFAULT '0' COMMENT 'Sinh viên chính quy tốt nghiệp cao đẳng',
  `sv_kcq_tn_cd` int(11) NOT NULL DEFAULT '0' COMMENT 'sinh viên không chính quy tốt nghiệp cao đẳng',
  `sv_cq_tn_tc` int(11) NOT NULL DEFAULT '0' COMMENT 'sinh viên chính quy tốt nghiệp trung cấp',
  `sv_kcq_tn_tc` int(11) NOT NULL DEFAULT '0' COMMENT 'Sinh viên không chính quy tốt nghiệp trung cấp',
  `khac` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`university_id`),
  CONSTRAINT `fk_tot_nghiet_1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nguoi_hoc_tot_nghiep`
--

LOCK TABLES `nguoi_hoc_tot_nghiep` WRITE;
/*!40000 ALTER TABLE `nguoi_hoc_tot_nghiep` DISABLE KEYS */;
INSERT INTO `nguoi_hoc_tot_nghiep` VALUES (1,1,2019,100,100,100,123,12314,12,235,314,1234123,'2019-07-03 08:36:25','2019-07-03 08:36:33');
/*!40000 ALTER TABLE `nguoi_hoc_tot_nghiep` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nhom_nganh`
--

DROP TABLE IF EXISTS `nhom_nganh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nhom_nganh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `slug` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nhom_nganhs_university_idx` (`university_id`),
  CONSTRAINT `fk_nhom_nganhs_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nhom_nganh`
--

LOCK TABLES `nhom_nganh` WRITE;
/*!40000 ALTER TABLE `nhom_nganh` DISABLE KEYS */;
INSERT INTO `nhom_nganh` VALUES (1,1,'Nhóm ngành I','nhom-nganh-i','2019-07-30 09:15:25','2019-07-30 09:15:25');
/*!40000 ALTER TABLE `nhom_nganh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `officer_by_genders`
--

DROP TABLE IF EXISTS `officer_by_genders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `officer_by_genders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `bien_che_nam` int(11) NOT NULL DEFAULT '0',
  `bien_che_nu` int(11) NOT NULL DEFAULT '0',
  `dai_han_nam` int(11) NOT NULL DEFAULT '0',
  `dai_han_nu` int(11) NOT NULL DEFAULT '0',
  `ngan_han_nam` int(11) NOT NULL DEFAULT '0',
  `ngan_han_nu` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `YEAR` (`year`),
  CONSTRAINT `fk_officer_by_gender_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officer_by_genders`
--

LOCK TABLES `officer_by_genders` WRITE;
/*!40000 ALTER TABLE `officer_by_genders` DISABLE KEYS */;
INSERT INTO `officer_by_genders` VALUES (1,1,2019,12,12,34,1231,34,34,'2019-06-25 08:57:37','2019-06-25 08:57:43');
/*!40000 ALTER TABLE `officer_by_genders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `officers`
--

DROP TABLE IF EXISTS `officers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `officers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `quan_ly_co_huu` int(11) NOT NULL COMMENT '1: Cán bộ quản lý\n2: Nhân việ',
  `nhan_vien_co_huu` int(11) NOT NULL,
  `quan_ly_hop_dong` int(11) NOT NULL,
  `nhan_vien_hop_dong` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `YEAR` (`year`),
  CONSTRAINT `fk_officers_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officers`
--

LOCK TABLES `officers` WRITE;
/*!40000 ALTER TABLE `officers` DISABLE KEYS */;
INSERT INTO `officers` VALUES (1,1,2019,10,1231,12,112,'2019-06-25 08:35:58','2019-06-25 08:36:12');
/*!40000 ALTER TABLE `officers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `permission` varchar(255) DEFAULT NULL,
  `role_base` varchar(255) DEFAULT '[]',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Tạo User','tao-user','user:create','[1,2,3]',NULL,NULL),(2,'Tạo Admin','tao-admin','admin:create','[1,2]',NULL,NULL),(3,'Thêm trường đại học','them-truong-dai-hoc','university:create','[1,2]',NULL,NULL),(4,'Cập nhật trường đại học ','cap-nhat-truong-dai-hoc','university:update','[1,2,3,4]',NULL,NULL),(5,'List trường đại học','list-truong-dai-hoc','university:list','[1,2]',NULL,NULL),(6,'Xem trường đại học','xem-truong-dai-hoc','university:view','[1,2,3,4]',NULL,NULL),(7,'Xem danh sach nguoi dung','xem-danh-sach-nguoi-dung','user:list','[1,2,3,4]',NULL,NULL),(8,'Cán bộ chủ chốt','can-bo-chu-chot','key_officer','[1,2,3,4]',NULL,NULL),(9,'Khoa viện đào tạo','khoa-vien-dao-tao','faculty','[1,2,3,4]',NULL,NULL),(10,'Đơn vị trực thuộc','don-vi-truc-thuoc','branch','[1,2,3,4]',NULL,NULL),(11,'Giảng viên','giang-vien','lecturer','[1,2,3,4]',NULL,NULL),(12,'Cán bộ ','can-bo','officer','[1,2,3,4]',NULL,NULL),(13,'Cán bộ theo giới tính','can-bo-theo-gioi-tinh','officer_by_gender','[1,2,3,4]',NULL,NULL),(14,'Giảng viên theo trình độ','giang-vien-theo-trinh-do','lecturer_by_degree','[1,2,3,4]',NULL,NULL),(15,'Giảng viên cơ hữu theo tuổi','giang-vien-theo-tuoi','lecturer_by_age','[1,2,3,4]',NULL,NULL),(16,'Giảng viên sử dụng ngoại ngu','giang-vien-su-dung-ngoai-ngu','lecturer_by_fl','[1,2,3,4]',NULL,NULL),(17,'Sinh vien nhap hoc ','sinh_vien_nhap_hoc','sv_nhap_hoc','[1,2,3,4]',NULL,NULL),(18,'Sinh viên ở kí túc xá','sinh_vien_ki_tuc_xa','sv_ktx','[1,2,3,4]',NULL,NULL),(19,'Sinh viên tham gia nckh','sinh_vien_tham_gia_nckg','sv_tham_gia_nckh','[1,2,3,4]',NULL,NULL),(20,'Người học tốt nghiệp','nguoi_hoc_tot_nghiep','nguoi_hoc_tot_nghiep','[1,2,3,4]',NULL,NULL),(21,'Số lượng nghiên cứu khoa học','so-luong-nckh','so_luong_nckh','[1,2,3,4]',NULL,NULL),(22,'Doanh thu nghiên cứu khoa học ','doanh-thu-nckh','doanh_thu_nckh','[1,2,3,4]',NULL,NULL),(23,'Cán bộ nghiên cứu khoa học ','can-bo-nghien-cuu-khoa-hoc','can_bo_nckh','[1,2,3,4]',NULL,NULL),(24,' Số lượng sách','so-luong-sach','so_luong_sach','[1,2,3,4]',NULL,NULL),(25,'Tạp chí được đăngt','tap-chi-duoc-dang','tap_chi_duoc_dang','[1,2,3,4]',NULL,NULL),(26,'Cán bộ tạp chí','can-bo-tap-chi','can_bo_tap_chi','[1,2,3,4]',NULL,NULL),(27,'Báo cáo hội thảo','bao-cao-hoi-thao','bao_cao_hoi_thao','[1,2,3,4]',NULL,NULL),(28,'Bằng sáng chế','bang-sang-che','bang_sang_che','[1,2,3,4]',NULL,NULL),(29,'Sinh viên nghiên cusws khoa học','sinh-vien-nghien-cuu-khoa-hoc','sv_va_nckh','[1,2,3,4]',NULL,NULL),(30,'Thành tích sinh viên nckh','thanh-tich-sinh-vien-nckh','thanh_tich_nckh','[1,2,3,4]',NULL,NULL),(31,'Sách thư viện','sach-thu-vien','sach_thu_vien','[1,2,3,4]',NULL,NULL),(32,'Thiết bị ','thiet-bi','thiet_bi','[1,2,3,4]',NULL,NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phan_loai_hoi_thao`
--

DROP TABLE IF EXISTS `phan_loai_hoi_thao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phan_loai_hoi_thao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phan_loai_hoi_thao`
--

LOCK TABLES `phan_loai_hoi_thao` WRITE;
/*!40000 ALTER TABLE `phan_loai_hoi_thao` DISABLE KEYS */;
INSERT INTO `phan_loai_hoi_thao` VALUES (1,'Hội thảo quốc tế',NULL,NULL),(2,'Hội thảo trong nước',NULL,NULL),(3,'Hội thảo cấp trường',NULL,NULL);
/*!40000 ALTER TABLE `phan_loai_hoi_thao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phan_loai_tap_chi`
--

DROP TABLE IF EXISTS `phan_loai_tap_chi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phan_loai_tap_chi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phan_loai_tap_chi`
--

LOCK TABLES `phan_loai_tap_chi` WRITE;
/*!40000 ALTER TABLE `phan_loai_tap_chi` DISABLE KEYS */;
INSERT INTO `phan_loai_tap_chi` VALUES (1,'Tạp chí KH quốc tế',NULL,NULL),(2,'Tạp chí KH cấp Ngành trong nước',NULL,NULL),(3,'Tạp chí / tập san của cấp trường',NULL,NULL);
/*!40000 ALTER TABLE `phan_loai_tap_chi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_group`
--

DROP TABLE IF EXISTS `question_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descriptions` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_group`
--

LOCK TABLES `question_group` WRITE;
/*!40000 ALTER TABLE `question_group` DISABLE KEYS */;
INSERT INTO `question_group` VALUES (1,'Số lượng sinh viên tốt nghiệp',NULL,NULL),(2,'Tỷ lệ tốt nghiệp so với số tuyển vào',NULL,NULL),(3,'Đánh giá của sinh viên tốt nghiệp về chất lượng đào tạo của nhà trường',NULL,NULL),(4,'Sinh viên có việc làm trong năm đầu tiên sau khi tốt nghiệp',NULL,NULL),(5,'Đánh giá của nhà sử dụng về sinh viên tốt nghiệp có việc làm đúng ngành đào tạo',NULL,NULL);
/*!40000 ALTER TABLE `question_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `permissions` longtext NOT NULL,
  `role_base` varchar(45) NOT NULL DEFAULT '[]',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'SuperAdmin','super-admin','','[1]',NULL,NULL),(2,'Admin','admin',' ','[1,2]',NULL,NULL),(3,'University Manager','university-manager',' ','[1,2,3]',NULL,NULL),(4,'University Officer','university-officer',' ','[1,2,3,4]',NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sach_thu_vien`
--

DROP TABLE IF EXISTS `sach_thu_vien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sach_thu_vien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `nhom_nganh_id` int(11) NOT NULL,
  `dau_sach` int(11) NOT NULL,
  `ban_sach` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  KEY `YEAR` (`year`),
  KEY `fk_sach_thu_vien_nhom_nganh_idx` (`nhom_nganh_id`),
  CONSTRAINT `fk_sach_thu_vien_nhom_nganh` FOREIGN KEY (`nhom_nganh_id`) REFERENCES `nhom_nganh` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_sach_thu_vien_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sach_thu_vien`
--

LOCK TABLES `sach_thu_vien` WRITE;
/*!40000 ALTER TABLE `sach_thu_vien` DISABLE KEYS */;
INSERT INTO `sach_thu_vien` VALUES (1,1,2019,1,123456,14346,'2019-07-31 08:32:28','2019-07-31 08:32:28');
/*!40000 ALTER TABLE `sach_thu_vien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sl_bc_tren_hoi_thao`
--

DROP TABLE IF EXISTS `sl_bc_tren_hoi_thao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sl_bc_tren_hoi_thao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(45) NOT NULL,
  `university_id` int(11) NOT NULL,
  `phan_loai_hoi_thao_id` int(11) NOT NULL,
  `tu_1_5` int(11) NOT NULL DEFAULT '0',
  `tu_6_10` int(11) NOT NULL DEFAULT '0',
  `tu_11_15` int(11) NOT NULL DEFAULT '0',
  `tren_15` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sl_cb_viet_tap_chi_universities1_idx` (`university_id`),
  KEY `fk_sl_bc_tren_hoi_thao_phan_loai_hoi_thao1_idx` (`phan_loai_hoi_thao_id`),
  CONSTRAINT `fk_sl_bc_tren_hoi_thao_phan_loai_hoi_thao1` FOREIGN KEY (`phan_loai_hoi_thao_id`) REFERENCES `phan_loai_hoi_thao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sl_cb_viet_tap_chi_universities10` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sl_bc_tren_hoi_thao`
--

LOCK TABLES `sl_bc_tren_hoi_thao` WRITE;
/*!40000 ALTER TABLE `sl_bc_tren_hoi_thao` DISABLE KEYS */;
INSERT INTO `sl_bc_tren_hoi_thao` VALUES (1,'2019',1,1,1,0,3,4,'2019-07-29 08:41:25','2019-07-29 08:41:25'),(2,'2019',1,2,2,0,3,4,'2019-07-29 08:41:25','2019-07-29 08:41:25'),(3,'2019',1,3,3,0,3,4,'2019-07-29 08:41:25','2019-07-29 08:41:25');
/*!40000 ALTER TABLE `sl_bc_tren_hoi_thao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sl_cb_viet_tap_chi`
--

DROP TABLE IF EXISTS `sl_cb_viet_tap_chi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sl_cb_viet_tap_chi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(45) NOT NULL,
  `university_id` int(11) NOT NULL,
  `phan_loai_tap_chi_id` int(11) NOT NULL,
  `tu_1_5` int(11) NOT NULL DEFAULT '0',
  `tu_6_10` int(11) NOT NULL DEFAULT '0',
  `tu_11_15` int(11) NOT NULL DEFAULT '0',
  `tren_15` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sl_cb_viet_tap_chi_universities1_idx` (`university_id`),
  KEY `fk_sl_cb_viet_tap_chi_phan_loai_tap_chi1_idx` (`phan_loai_tap_chi_id`),
  CONSTRAINT `fk_sl_cb_viet_tap_chi_phan_loai_tap_chi1` FOREIGN KEY (`phan_loai_tap_chi_id`) REFERENCES `phan_loai_tap_chi` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sl_cb_viet_tap_chi_universities1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sl_cb_viet_tap_chi`
--

LOCK TABLES `sl_cb_viet_tap_chi` WRITE;
/*!40000 ALTER TABLE `sl_cb_viet_tap_chi` DISABLE KEYS */;
INSERT INTO `sl_cb_viet_tap_chi` VALUES (1,'2019',1,1,1,2,3,4,'2019-07-16 08:36:47','2019-07-16 08:36:47'),(2,'2019',1,2,2,2,3,4,'2019-07-16 08:36:47','2019-07-16 08:36:47'),(3,'2019',1,3,3,2,3,4,'2019-07-16 08:36:47','2019-07-16 08:36:47');
/*!40000 ALTER TABLE `sl_cb_viet_tap_chi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sl_sach_xuat_ban`
--

DROP TABLE IF EXISTS `sl_sach_xuat_ban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sl_sach_xuat_ban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loai_sach_id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sl_sach_xuat_ban_loai_sach1_idx` (`loai_sach_id`),
  KEY `fk_sl_sach_xuat_ban_universities1_idx` (`university_id`),
  CONSTRAINT `fk_sl_sach_xuat_ban_loai_sach1` FOREIGN KEY (`loai_sach_id`) REFERENCES `loai_sach` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sl_sach_xuat_ban_universities1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sl_sach_xuat_ban`
--

LOCK TABLES `sl_sach_xuat_ban` WRITE;
/*!40000 ALTER TABLE `sl_sach_xuat_ban` DISABLE KEYS */;
INSERT INTO `sl_sach_xuat_ban` VALUES (2,1,1,2019,10,'2019-07-10 08:49:40','2019-07-10 08:49:40'),(3,2,1,2019,12,'2019-07-10 08:49:40','2019-07-10 08:49:40'),(4,3,1,2019,13,'2019-07-10 08:49:40','2019-07-10 08:49:40'),(5,4,1,2019,124,'2019-07-10 08:49:40','2019-07-10 08:49:40');
/*!40000 ALTER TABLE `sl_sach_xuat_ban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sl_tap_chi_duoc_dang`
--

DROP TABLE IF EXISTS `sl_tap_chi_duoc_dang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sl_tap_chi_duoc_dang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `phan_loai_tap_chi_id` int(11) NOT NULL,
  `danh_muc` varchar(255) DEFAULT NULL,
  `so_luong` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sl_tap_chi_duoc_dang_universities1_idx` (`university_id`),
  KEY `fk_sl_tap_chi_duoc_dang_phan_loai_tap_chi1_idx` (`phan_loai_tap_chi_id`),
  CONSTRAINT `fk_sl_tap_chi_duoc_dang_phan_loai_tap_chi1` FOREIGN KEY (`phan_loai_tap_chi_id`) REFERENCES `phan_loai_tap_chi` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sl_tap_chi_duoc_dang_universities1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sl_tap_chi_duoc_dang`
--

LOCK TABLES `sl_tap_chi_duoc_dang` WRITE;
/*!40000 ALTER TABLE `sl_tap_chi_duoc_dang` DISABLE KEYS */;
INSERT INTO `sl_tap_chi_duoc_dang` VALUES (2,1,2019,1,'isi',12,'2019-07-15 08:43:47','2019-07-15 08:43:47'),(3,1,2019,1,'scopus',14,'2019-07-15 08:43:47','2019-07-15 08:43:47'),(4,1,2019,1,'khac',111,'2019-07-15 08:43:47','2019-07-15 08:43:47'),(5,1,2019,2,'khac',144,'2019-07-15 08:43:47','2019-07-15 08:43:47'),(6,1,2019,3,'khac',145,'2019-07-15 08:43:47','2019-07-15 08:43:47');
/*!40000 ALTER TABLE `sl_tap_chi_duoc_dang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `so_luong_nckh`
--

DROP TABLE IF EXISTS `so_luong_nckh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `so_luong_nckh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `dt_cap_nha_nuoc` int(11) NOT NULL DEFAULT '0' COMMENT 'Đề tài cấp nhà nước',
  `dt_cap_bo` int(11) NOT NULL DEFAULT '0',
  `dt_cap_truong` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`university_id`),
  CONSTRAINT `so_luon_nckh` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `so_luong_nckh`
--

LOCK TABLES `so_luong_nckh` WRITE;
/*!40000 ALTER TABLE `so_luong_nckh` DISABLE KEYS */;
INSERT INTO `so_luong_nckh` VALUES (1,1,2019,2,12,123,'2019-07-05 08:53:10','2019-07-05 08:53:10');
/*!40000 ALTER TABLE `so_luong_nckh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sv_ktx`
--

DROP TABLE IF EXISTS `sv_ktx`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sv_ktx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `tong_dien_tich` int(11) NOT NULL,
  `sl_sinh_vien` int(11) NOT NULL,
  `sl_sv_co_nhu_cau` int(11) NOT NULL,
  `sl_sv_dc_o` int(11) NOT NULL COMMENT 'Số lượng sinh viên được ở',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`university_id`),
  CONSTRAINT `fk_university_ktx` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sv_ktx`
--

LOCK TABLES `sv_ktx` WRITE;
/*!40000 ALTER TABLE `sv_ktx` DISABLE KEYS */;
INSERT INTO `sv_ktx` VALUES (1,1,2019,5000,1000,1900,901,'2019-07-03 08:12:47','2019-07-03 08:12:55');
/*!40000 ALTER TABLE `sv_ktx` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sv_nhap_hoc`
--

DROP TABLE IF EXISTS `sv_nhap_hoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sv_nhap_hoc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `type` varchar(5) NOT NULL DEFAULT 'CD' COMMENT 'NCS: nghiên cứu sinh\nHVCH: học viên cao học\nDH: sinh viên đại học\nCD: sinh viên cao đẳng\nTT: sinh viên trung cấp\nKHAC: các loại học sinh khác',
  `he_hoc` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: là hệ KHÔNG CHÍNH QUY\n1: là hệ CHÍNH QUY',
  `sl_du_tuyen` int(11) DEFAULT NULL,
  `sl_trung_tuyen` int(11) DEFAULT NULL,
  `sl_nhap_hoc` int(11) DEFAULT NULL,
  `sl_sv_quoc_te` int(11) DEFAULT NULL,
  `ty_le_canh_tranh` float DEFAULT NULL,
  `diem_dau_vao` float DEFAULT NULL,
  `diem_trung_binh` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`university_id`),
  CONSTRAINT `id` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sv_nhap_hoc`
--

LOCK TABLES `sv_nhap_hoc` WRITE;
/*!40000 ALTER TABLE `sv_nhap_hoc` DISABLE KEYS */;
INSERT INTO `sv_nhap_hoc` VALUES (1,1,2019,'NCS',1,10,12,12,1,1.5,25,20,'2019-07-02 08:24:40','2019-07-02 08:24:40'),(2,1,2019,'HVCH',1,11,12,12,1,1.5,25,20,'2019-07-02 08:24:40','2019-07-02 08:24:40'),(3,1,2019,'DH',1,12,12,12,1,1.5,25,20,'2019-07-02 08:24:40','2019-07-02 08:24:40'),(4,1,2019,'CD',1,13,12,12,1,1.5,25,20,'2019-07-02 08:24:40','2019-07-02 08:24:40'),(5,1,2019,'TC',1,14,12,12,1,1.5,25,20,'2019-07-02 08:24:40','2019-07-02 08:24:40'),(6,1,2019,'KHAC',1,25,12,12,1,1.5,25,20,'2019-07-02 08:24:40','2019-07-02 08:24:50'),(7,1,2019,'NCS',0,120,12,12,1,1.5,25,20,'2019-07-02 08:25:10','2019-07-02 08:25:19'),(8,1,2019,'HVCH',0,11,12,12,1,1.5,25,20,'2019-07-02 08:25:10','2019-07-02 08:25:10'),(9,1,2019,'DH',0,12,12,12,1,1.5,25,20,'2019-07-02 08:25:10','2019-07-02 08:25:10'),(10,1,2019,'CD',0,13,12,12,1,1.5,25,20,'2019-07-02 08:25:10','2019-07-02 08:25:10'),(11,1,2019,'TC',0,14,12,12,1,1.5,25,20,'2019-07-02 08:25:10','2019-07-02 08:25:10'),(12,1,2019,'KHAC',0,25,12,12,1,1.5,25,20,'2019-07-02 08:25:10','2019-07-02 08:25:10');
/*!40000 ALTER TABLE `sv_nhap_hoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sv_tham_gia_nckh`
--

DROP TABLE IF EXISTS `sv_tham_gia_nckh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sv_tham_gia_nckh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `sl_tham_gia` int(11) NOT NULL DEFAULT '0',
  `ti_le` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`university_id`),
  CONSTRAINT `fk_sv_nckh_1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sv_tham_gia_nckh`
--

LOCK TABLES `sv_tham_gia_nckh` WRITE;
/*!40000 ALTER TABLE `sv_tham_gia_nckh` DISABLE KEYS */;
INSERT INTO `sv_tham_gia_nckh` VALUES (1,1,2019,1000,20,'2019-07-03 08:24:29','2019-07-03 08:24:29');
/*!40000 ALTER TABLE `sv_tham_gia_nckh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sv_va_nckh`
--

DROP TABLE IF EXISTS `sv_va_nckh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sv_va_nckh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `tu_1_3` int(11) NOT NULL DEFAULT '0',
  `tu_4_6` int(11) NOT NULL DEFAULT '0',
  `tren_6` int(11) NOT NULL DEFAULT '0',
  `cap_de_tai_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_so_luong_nckh_universities1_idx` (`university_id`),
  KEY `fk_so_luong_nckh_cap_de_tai1_idx` (`cap_de_tai_id`),
  CONSTRAINT `fk_so_luong_nckh_cap_de_tai10` FOREIGN KEY (`cap_de_tai_id`) REFERENCES `cap_de_tai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_so_luong_nckh_universities10` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sv_va_nckh`
--

LOCK TABLES `sv_va_nckh` WRITE;
/*!40000 ALTER TABLE `sv_va_nckh` DISABLE KEYS */;
INSERT INTO `sv_va_nckh` VALUES (1,1,2019,1,2,4,1,'2019-07-29 09:06:34','2019-07-29 09:06:34'),(2,1,2019,1,2,5,2,'2019-07-29 09:06:34','2019-07-29 09:06:34'),(3,1,2019,1,2,6,3,'2019-07-29 09:06:34','2019-07-29 09:06:34');
/*!40000 ALTER TABLE `sv_va_nckh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thanh_tich_nckh`
--

DROP TABLE IF EXISTS `thanh_tich_nckh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thanh_tich_nckh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `giai_thuong` int(11) NOT NULL DEFAULT '0',
  `bai_bao` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_thanh_tich_nckh_universities1_idx` (`university_id`),
  CONSTRAINT `fk_thanh_tich_nckh_universities1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thanh_tich_nckh`
--

LOCK TABLES `thanh_tich_nckh` WRITE;
/*!40000 ALTER TABLE `thanh_tich_nckh` DISABLE KEYS */;
INSERT INTO `thanh_tich_nckh` VALUES (1,1,2019,111,123,'2019-07-29 09:18:34','2019-07-29 09:18:43');
/*!40000 ALTER TABLE `thanh_tich_nckh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thiet_bi`
--

DROP TABLE IF EXISTS `thiet_bi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thiet_bi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `so_luong` int(11) NOT NULL,
  `danh_muc_trang_thiet_bi` mediumtext,
  `doi_tuong` mediumtext,
  `dien_tich` float DEFAULT NULL,
  `hinh_thuc` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIVERSITY` (`university_id`),
  CONSTRAINT `fk_thiet_bi_univesity` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thiet_bi`
--

LOCK TABLES `thiet_bi` WRITE;
/*!40000 ALTER TABLE `thiet_bi` DISABLE KEYS */;
/*!40000 ALTER TABLE `thiet_bi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thu_chi`
--

DROP TABLE IF EXISTS `thu_chi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thu_chi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `tong_nguon_thu` varchar(45) DEFAULT NULL,
  `tong_hoc_phi` varchar(45) DEFAULT NULL,
  `chi_nckh` varchar(45) DEFAULT NULL,
  `thu_nckh` varchar(45) DEFAULT NULL,
  `chi_dao_tao` varchar(45) DEFAULT NULL,
  `chi_doi_ngu` varchar(45) DEFAULT NULL,
  `chi_ket_noi` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thu_chi_university` (`university_id`),
  KEY `thu_chi_year` (`year`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thu_chi`
--

LOCK TABLES `thu_chi` WRITE;
/*!40000 ALTER TABLE `thu_chi` DISABLE KEYS */;
INSERT INTO `thu_chi` VALUES (1,1,2019,'1000000000','200000000','123534534','1242345163','234251241','124466374','12351613','2019-08-16 08:52:48','2019-08-16 08:52:48'),(2,1,2018,'1000000000','200000000','123534534','1242345163','234251241','124466374','12351613','2019-08-16 08:53:05','2019-08-16 08:53:05');
/*!40000 ALTER TABLE `thu_chi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tieu_chuan_kiem_dinhs`
--

DROP TABLE IF EXISTS `tieu_chuan_kiem_dinhs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tieu_chuan_kiem_dinhs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tieu_chuan_kiem_dinhs`
--

LOCK TABLES `tieu_chuan_kiem_dinhs` WRITE;
/*!40000 ALTER TABLE `tieu_chuan_kiem_dinhs` DISABLE KEYS */;
INSERT INTO `tieu_chuan_kiem_dinhs` VALUES (1,'VBHN số 06/VBHN-BGDĐT','2019-08-20 07:17:20','2019-08-20 07:17:20');
/*!40000 ALTER TABLE `tieu_chuan_kiem_dinhs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tinh_trang_sv_tn`
--

DROP TABLE IF EXISTS `tinh_trang_sv_tn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tinh_trang_sv_tn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `tra_loi` varchar(255) NOT NULL DEFAULT '0',
  `he_hoc` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 là hệ không chính quy\n1 là hệ chính quy',
  `cau_hoi_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`university_id`),
  KEY `id_idx1` (`cau_hoi_id`),
  CONSTRAINT `tinh_trang_cau_hoi` FOREIGN KEY (`cau_hoi_id`) REFERENCES `cau_hoi_tot_nghiep` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tinhtrong_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tinh_trang_sv_tn`
--

LOCK TABLES `tinh_trang_sv_tn` WRITE;
/*!40000 ALTER TABLE `tinh_trang_sv_tn` DISABLE KEYS */;
INSERT INTO `tinh_trang_sv_tn` VALUES (1,1,2019,'1',1,1,NULL,NULL),(2,1,2019,'0',1,2,'2019-07-05 08:35:36','2019-07-05 08:35:36'),(3,1,2019,'0',1,3,'2019-07-05 08:35:36','2019-07-05 08:35:36');
/*!40000 ALTER TABLE `tinh_trang_sv_tn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `to_chuc_kiem_dinh`
--

DROP TABLE IF EXISTS `to_chuc_kiem_dinh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `to_chuc_kiem_dinh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `to_chuc_kiem_dinh`
--

LOCK TABLES `to_chuc_kiem_dinh` WRITE;
/*!40000 ALTER TABLE `to_chuc_kiem_dinh` DISABLE KEYS */;
INSERT INTO `to_chuc_kiem_dinh` VALUES (1,'VNU -CEA','2019-08-20 07:25:35','2019-08-20 07:25:35');
/*!40000 ALTER TABLE `to_chuc_kiem_dinh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trang_thiet_bi`
--

DROP TABLE IF EXISTS `trang_thiet_bi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trang_thiet_bi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `slug` tinytext,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trang_thiet_bi`
--

LOCK TABLES `trang_thiet_bi` WRITE;
/*!40000 ALTER TABLE `trang_thiet_bi` DISABLE KEYS */;
INSERT INTO `trang_thiet_bi` VALUES (1,'Máy vi tính','may-vi-tinh',2,'2019-08-12 09:10:41','2019-08-12 09:10:41');
/*!40000 ALTER TABLE `trang_thiet_bi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `universities`
--

DROP TABLE IF EXISTS `universities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `universities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_vi` tinytext,
  `name_en` tinytext,
  `short_name_vi` varchar(45) DEFAULT NULL,
  `short_name_en` varchar(45) DEFAULT NULL,
  `name_before` tinytext,
  `governing_body` varchar(45) DEFAULT NULL COMMENT 'Bộ/ cơ quan chủ quản ',
  `address` tinytext,
  `phone_number` varchar(15) DEFAULT NULL,
  `fax_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `founded_year` int(11) DEFAULT NULL COMMENT 'năm thành lập ',
  `k1_start_date` date DEFAULT NULL COMMENT 'Thời gian bắt đầu đào tạo khóa I:',
  `k1_end_date` date DEFAULT NULL COMMENT 'Thời gian cấp bằng tốt nghiệp cho khoá I',
  `institution_type` int(11) DEFAULT NULL COMMENT 'Loại hình cơ sở giáo dục\n1: công lâp\n2: bán công\n3: dân lập \n4: tư thục\n5: khac\n',
  `institution_type_other` varchar(100) DEFAULT NULL,
  `training_type` varchar(100) DEFAULT NULL COMMENT 'Các loại hình đào tạo của cơ sở giáo dục\n1: Chính quy\n2: Không chính quy\n3: Từ xa\n4:Liên kết nước ngoài\n5: Liên kết trong nước\n6: khác\n',
  `training_type_other` mediumtext COMMENT 'Các loại hình đào tạo  khác của cơ sở giáo dục lưu dưới dạng json',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `short_name_vi_UNIQUE` (`short_name_vi`),
  UNIQUE KEY `short_name_en_UNIQUE` (`short_name_en`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `universities`
--

LOCK TABLES `universities` WRITE;
/*!40000 ALTER TABLE `universities` DISABLE KEYS */;
INSERT INTO `universities` VALUES (1,'Đại học Sao đỏ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Đại học Công nghệ - Đại học quốc gia Hà Nội','University of Engineering and Technology','uet','UET','asd','asdf','asdf','asdf','asdf','bachnq@gmail.com','www.uet.vnu.edu.vn',11111,'2019-01-01','2019-01-01',1,NULL,'[1,2]',NULL,'2019-06-04 10:02:20','2019-06-16 03:17:10'),(3,'asdf','swe','asd','dfa','sdfas sadfsadf','asdfasfwe afas','qasdfa','12312667','12351666','abch@asd.dasdf','asdfs',1234,'2019-08-28','2019-08-25',1,'asdf','[\"1\"]',NULL,'2019-08-21 07:15:45','2019-08-21 07:15:45'),(4,'sadf','asdfa','asd23radf','fasdfawe','asdf','asdfasd','fsadfasd','1234153','21351','asd@asdf.dsfa','asdfa',21415,'2019-08-05','2019-07-29',0,'hello','[\"1\"]',NULL,'2019-08-21 07:22:23','2019-08-21 07:22:23'),(5,'wefasdf','asdfsdf','asdfawefwe13','awefwaef','wef','qwer','rqwerqwe','124251','231614','abac@asd.ads','asdfafwesdf',2141,'2019-08-06','2019-08-13',1,NULL,'[\"1\"]',NULL,'2019-08-21 07:54:44','2019-08-21 08:01:57');
/*!40000 ALTER TABLE `universities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT INTO `user_permissions` VALUES (1,'1',NULL,NULL),(2,'1',NULL,NULL),(2,'4','2019-06-14 07:56:35','2019-06-14 07:56:35'),(2,'6','2019-06-14 07:56:35','2019-06-14 07:56:35'),(2,'7','2019-06-14 07:56:35','2019-06-14 07:56:35'),(2,'8','2019-06-14 07:56:35','2019-06-14 07:56:35'),(8,'1','2019-06-02 09:01:31','2019-06-02 09:01:31'),(12,'4','2019-06-11 10:07:13','2019-06-11 10:07:13'),(12,'6','2019-06-11 10:07:13','2019-06-11 10:07:13'),(12,'7','2019-06-11 10:07:13','2019-06-11 10:07:13'),(12,'8','2019-06-11 10:07:13','2019-06-11 10:07:13'),(13,'4','2019-06-14 08:04:27','2019-06-14 08:04:27'),(13,'6','2019-06-14 08:04:27','2019-06-14 08:04:27'),(13,'7','2019-06-14 08:04:27','2019-06-14 08:04:27'),(13,'8','2019-06-14 08:04:27','2019-06-14 08:04:27'),(14,'1','2019-08-20 08:23:30','2019-08-20 08:23:30'),(14,'11','2019-08-20 08:23:30','2019-08-20 08:23:30'),(14,'16','2019-08-20 08:23:30','2019-08-20 08:23:30');
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(45) NOT NULL,
  `password` tinytext NOT NULL,
  `user_token` mediumtext,
  `fullname` tinytext,
  `email` varchar(100) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '0',
  `permissions` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_univerity_idx` (`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,0,'admin','$2y$12$xEr2TiXqLXsMgb1Mf.bU7eeEVf8Og.Tl66R1f37OCSNfSiAXXpd4e',NULL,'Super Admin','bachnq214@gmail.com',1,1,NULL,NULL,NULL),(2,1,'admin1','$2y$10$SksbMbNaNuq2Lu/HDaKk2embXHjOHTeS4r5rRKbjs4hWyC..R0EXm',NULL,'Nguyễn Quang Bách 1','peterbach9162@gmail.com',1,3,NULL,'2019-05-28 07:40:03','2019-06-11 10:13:42'),(4,0,'admin1231','$2y$10$8BZ8e9btyJXvMjEw2GHWQO1MuRbUuVDyVPS8jNjX75f5c0//I0/OS',NULL,'Nguyễn Quang Bách','bachnq2115@gmail.com',1,1,NULL,'2019-06-02 08:59:35','2019-06-02 08:59:35'),(14,1,'admin124','$2y$10$GEapGM0C/9YQuOQMqg3oZuo2MKUJnf6T5sjlY0yZDMGmLVBNfyWu.',NULL,'bach','bachnq214@asd.dd',1,3,NULL,'2019-08-20 08:23:30','2019-08-20 08:23:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-25 21:43:27
