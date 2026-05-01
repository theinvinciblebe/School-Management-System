/*
 Navicat Premium Dump SQL

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : schooligniter

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 17/01/2025 14:44:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for acd_history
-- ----------------------------
DROP TABLE IF EXISTS `acd_history`;
CREATE TABLE `acd_history`  (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `examtype` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `board` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `passing_yr` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `special_mark` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ttl_mark` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of acd_history
-- ----------------------------

-- ----------------------------
-- Table structure for acd_session
-- ----------------------------
DROP TABLE IF EXISTS `acd_session`;
CREATE TABLE `acd_session`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_dt` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `is_open` int NOT NULL,
  `strt_dt` date NULL DEFAULT NULL,
  `end_dt` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of acd_session
-- ----------------------------
INSERT INTO `acd_session` VALUES (8, '2021-26', NULL, 0, '2021-09-16', '2023-01-18');
INSERT INTO `acd_session` VALUES (9, '2025-01-02', NULL, 1, '2025-01-01', '2025-01-31');
INSERT INTO `acd_session` VALUES (11, '111111111', NULL, 1, '2025-01-01', '2025-01-06');

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`admin_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'School Admin', 'admin@mail.com', 'Password@123', '1');

-- ----------------------------
-- Table structure for attendance
-- ----------------------------
DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance`  (
  `attendance_id` int NOT NULL AUTO_INCREMENT,
  `status` int NOT NULL COMMENT '0 undefined , 1 present , 2  absent, 3 Medical, 4 Late',
  `student_class_id` int NOT NULL,
  `date` date NOT NULL,
  `attendance_by` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`attendance_id`) USING BTREE,
  INDEX `atd_student_class`(`student_class_id` ASC) USING BTREE,
  INDEX `atd_by_user`(`attendance_by` ASC) USING BTREE,
  CONSTRAINT `atd_by_user` FOREIGN KEY (`attendance_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `atd_student_class` FOREIGN KEY (`student_class_id`) REFERENCES `student_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 65 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of attendance
-- ----------------------------
INSERT INTO `attendance` VALUES (50, 4, 21, '2025-01-16', 4);
INSERT INTO `attendance` VALUES (51, 1, 22, '2025-01-16', 4);
INSERT INTO `attendance` VALUES (52, 1, 25, '2025-01-16', 4);
INSERT INTO `attendance` VALUES (53, 0, 21, '2025-01-15', 1);
INSERT INTO `attendance` VALUES (54, 0, 22, '2025-01-15', 1);
INSERT INTO `attendance` VALUES (55, 0, 25, '2025-01-15', 1);
INSERT INTO `attendance` VALUES (56, 1, 26, '2025-01-16', 1);
INSERT INTO `attendance` VALUES (63, 1, 28, '2025-01-17', 7);
INSERT INTO `attendance` VALUES (64, 4, 28, '2025-01-18', 7);

-- ----------------------------
-- Table structure for book
-- ----------------------------
DROP TABLE IF EXISTS `book`;
CREATE TABLE `book`  (
  `book_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `author` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `class_id` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`book_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of book
-- ----------------------------
INSERT INTO `book` VALUES (1, 'LBook One', 'Desc-0078', 'AuthorOne', '4', 'available', '11');
INSERT INTO `book` VALUES (2, 'LBook Two', 'Desc-0089', 'AuthorTwo', '4', 'available', '13');
INSERT INTO `book` VALUES (3, 'LBook Three', 'Desc-0118', 'AuthorThree', '5', 'available', '19');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for ci_sessions
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions`  (
  `id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ci_sessions_timestamp`(`timestamp` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ci_sessions
-- ----------------------------
INSERT INTO `ci_sessions` VALUES ('015a447db4fe344d43edf6564aae2d2593dd256a', '::1', 1647185186, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138343838363B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B666C6173685F6D6573736167657C733A31323A22446174612055706461746564223B5F5F63695F766172737C613A313A7B733A31333A22666C6173685F6D657373616765223B733A333A226F6C64223B7D);
INSERT INTO `ci_sessions` VALUES ('069e633497eee7c923270723f19db79465c067fa', '::1', 1647185342, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138353139303B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('151ab4a89340bbd00fb529eaa5d2bc389c9b0c10', '::1', 1647187510, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138373531303B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('175357b91aa5c3204100dd81a8bd6368264262de', '::1', 1647190226, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139303231383B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('23520caef99625591f10f7666b851d0ad54c3ef7', '::1', 1647192530, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139323531393B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('2c40f7068539d979e160afcdcdb00ff75d54fe14', '::1', 1647192169, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139323136393B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('38a5d9b737daa7c28de7d700ee1198f72485db04', '::1', 1647185870, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138353837303B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('4a90461d244f1154968e1b5bcc32e47ce151a99e', '::1', 1647186182, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138363138323B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('52905d700a8471a35d7895c0cd2f6b3d7308e6db', '::1', 1647188235, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138383136373B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('5cff6777d93669a43ac96d84da8890ac4a075c80', '::1', 1647185509, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138353530393B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('679d5e08bbaa49ddade499b2eeab617df29a97ac', '::1', 1647191205, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139303932393B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('718ba56c5d55fda016c965f2e9a2e9707aaab9bd', '::1', 1647187201, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138373230313B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('72e4408f94dc6f73b479366c690c2e63d81030c5', '::1', 1647186886, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138363838363B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('8eb4ab20034c4a321bc58e7f449544bac3ab5d87', '::1', 1647190212, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139303231323B);
INSERT INTO `ci_sessions` VALUES ('96f3b6c494acd5ae18899787b6ed15a4bacceb12', '::1', 1647193514, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139333233383B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('9e3709b39226d15cccb0fe48db1dcb9b7b553a37', '::1', 1647191875, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139313836343B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('b89e0ab65aec725ea8dc940e6e192763dfca6abc', '::1', 1647191294, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139313235363B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('cda5d9f2bfd783de391975c2db21753fcfa3f1c1', '::1', 1647190853, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139303536313B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('d0d5647e0b256d126adab84cb6d5ccdac26c885b', '::1', 1647188122, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138373833323B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('d52ebb202d44fa445af5213a663fe933264f4464', '::1', 1647191686, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139313536303B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('d8aeefa4c13b11b8109dfd92696c9b3f0461c1ac', '::1', 1647186567, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373138363536373B61646D696E5F6C6F67696E7C733A313A2231223B61646D696E5F69647C733A313A2231223B6C6F67696E5F757365725F69647C733A313A2231223B6E616D657C733A31323A225363686F6F6C2041646D696E223B6C6F67696E5F747970657C733A353A2261646D696E223B);
INSERT INTO `ci_sessions` VALUES ('e00b325a73b5296971ecd69beb21e6945a3af4d4', '::1', 1647194267, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139343236373B);
INSERT INTO `ci_sessions` VALUES ('e5048a7148c52caa5ab5600047a36668a660faab', '::1', 1647192926, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139323932363B);
INSERT INTO `ci_sessions` VALUES ('ec2e698310a2203b3880f86c1e008a67939ab6e2', '::1', 1647192921, 0x5F5F63695F6C6173745F726567656E65726174657C693A313634373139323932313B);

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class`  (
  `class_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `class_code` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `class_room` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `teacher_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`class_id`) USING BTREE,
  INDEX `fk_class_teacher`(`teacher_id` ASC) USING BTREE,
  CONSTRAINT `fk_class_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES (44, 'Digital Marketing', '2111354', '1A', 3);
INSERT INTO `class` VALUES (45, 'Graphic Design', '1123', 'No Room Assigned', NULL);
INSERT INTO `class` VALUES (46, 'Web Design', 'WD-01', 'staff', NULL);
INSERT INTO `class` VALUES (48, 'Database-SQL', 'DBS-01', '1B', 13);

-- ----------------------------
-- Table structure for class_routine
-- ----------------------------
DROP TABLE IF EXISTS `class_routine`;
CREATE TABLE `class_routine`  (
  `class_routine_id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `time_start` int NOT NULL,
  `time_end` int NOT NULL,
  `day` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`class_routine_id`) USING BTREE,
  INDEX `class_id`(`class_id` ASC) USING BTREE,
  INDEX `subject_routine`(`subject_id` ASC) USING BTREE,
  CONSTRAINT `class_routine` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subject_routine` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of class_routine
-- ----------------------------

-- ----------------------------
-- Table structure for document
-- ----------------------------
DROP TABLE IF EXISTS `document`;
CREATE TABLE `document`  (
  `document_id` int NOT NULL AUTO_INCREMENT,
  `title` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file_name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file_type` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `class_id` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `teacher_id` int NOT NULL,
  `timestamp` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`document_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of document
-- ----------------------------

-- ----------------------------
-- Table structure for dormitory
-- ----------------------------
DROP TABLE IF EXISTS `dormitory`;
CREATE TABLE `dormitory`  (
  `dormitory_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `number_of_room` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`dormitory_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of dormitory
-- ----------------------------
INSERT INTO `dormitory` VALUES (1, 'Boys Hostel B', '16', 'Hostel for Boys - B');
INSERT INTO `dormitory` VALUES (2, 'Boys Hostel A', '31', 'Hostel for Boys - A');
INSERT INTO `dormitory` VALUES (3, 'Girls Hostel A', '25', 'Hostel for Girls - A');

-- ----------------------------
-- Table structure for exam
-- ----------------------------
DROP TABLE IF EXISTS `exam`;
CREATE TABLE `exam`  (
  `exam_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comment` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`exam_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of exam
-- ----------------------------
INSERT INTO `exam` VALUES (1, 'First Terminal Examination', '2025-01-09', '');
INSERT INTO `exam` VALUES (2, 'Second Terminal Examination', '2025-01-09', '');
INSERT INTO `exam` VALUES (3, 'Third Terminal Examination', '2025-01-09', '');
INSERT INTO `exam` VALUES (4, 'Final Examination', '2025-01-09', NULL);

-- ----------------------------
-- Table structure for expense_category
-- ----------------------------
DROP TABLE IF EXISTS `expense_category`;
CREATE TABLE `expense_category`  (
  `expense_category_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`expense_category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of expense_category
-- ----------------------------
INSERT INTO `expense_category` VALUES (1, 'Teacher Salary');
INSERT INTO `expense_category` VALUES (2, 'Classroom Equipments');
INSERT INTO `expense_category` VALUES (3, 'Classroom Decorations');
INSERT INTO `expense_category` VALUES (4, 'Inventory Purchase');
INSERT INTO `expense_category` VALUES (5, 'Exam Accessories');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for grade
-- ----------------------------
DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade`  (
  `grade_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `grade_point` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mark_from` int NOT NULL,
  `mark_upto` int NOT NULL,
  `comment` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`grade_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of grade
-- ----------------------------
INSERT INTO `grade` VALUES (1, 'A+', '5', 91, 100, 'Excellent');
INSERT INTO `grade` VALUES (2, 'A', '4', 81, 90, 'Very Good');
INSERT INTO `grade` VALUES (3, 'A-', '3', 71, 80, 'Good');
INSERT INTO `grade` VALUES (4, 'B', '2', 61, 70, 'Okay');
INSERT INTO `grade` VALUES (5, 'C', '1', 51, 60, 'Need Improvement');
INSERT INTO `grade` VALUES (6, 'F', '0', 0, 50, 'Fail');

-- ----------------------------
-- Table structure for invoice
-- ----------------------------
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice`  (
  `invoice_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `title` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `amount_paid` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `due` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `creation_timestamp` int NOT NULL,
  `payment_timestamp` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_details` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'paid or unpaid',
  PRIMARY KEY (`invoice_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of invoice
-- ----------------------------
INSERT INTO `invoice` VALUES (1, 1, 'Monthly Fee', 'none', 850, '850', '0', 1449702000, '', '', '', 'paid');
INSERT INTO `invoice` VALUES (2, 3, 'Monthly Payment', 'Payment for the month - Feb', 990, '0', '990', 1646089200, '', '', '', 'unpaid');
INSERT INTO `invoice` VALUES (3, 10, 'Monthly Fees - Feb', 'Fees collection for the month of February', 770, '770', '0', 1646002800, '', '', '', 'paid');
INSERT INTO `invoice` VALUES (4, 5, 'Monthly Fees', 'Fees collection for the month February', 990, '990', '0', 1646002800, '', '', '', 'paid');
INSERT INTO `invoice` VALUES (5, 12, 'Monthly Fees - Feb', 'Fees Collection for the month February', 850, '0', '850', 1646002800, '', '', '', 'unpaid');
INSERT INTO `invoice` VALUES (6, 9, 'Monthly Fees', 'none', 990, '990', '0', 1646002800, '', '', '', 'paid');

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for language
-- ----------------------------
DROP TABLE IF EXISTS `language`;
CREATE TABLE `language`  (
  `phrase_id` int NOT NULL AUTO_INCREMENT,
  `phrase` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `english` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `bengali` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `spanish` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `arabic` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dutch` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `russian` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `chinese` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `turkish` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `portuguese` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hungarian` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `french` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `greek` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `german` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `italian` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `thai` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `urdu` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hindi` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `latin` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `indonesian` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `japanese` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `korean` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`phrase_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 477 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of language
-- ----------------------------
INSERT INTO `language` VALUES (1, 'login', 'login', 'লগইন', 'login', 'دخول', 'login', 'Войти', '注册', 'giriş', 'login', 'bejelentkezés', 'Connexion', 'σύνδεση', 'Login', 'login', 'เข้าสู่ระบบ', 'لاگ ان', 'लॉगिन', 'login', 'login', 'ログイン', '로그인');
INSERT INTO `language` VALUES (2, 'account_type', 'account type', 'অ্যাকাউন্ট টাইপ', 'tipo de cuenta', 'نوع الحساب', 'type account', 'тип счета', '账户类型', 'hesap türü', 'tipo de conta', 'fiók típusát', 'Type de compte', 'τον τύπο του λογαριασμού', 'Kontotyp', 'tipo di account', 'ประเภทบัญชี', 'اکاؤنٹ کی قسم', 'खाता प्रकार', 'propter speciem', 'Jenis akun', '口座の種類', '계정 유형');
INSERT INTO `language` VALUES (3, 'admin', 'admin', 'অ্যাডমিন', 'administración', 'مشرف', 'admin', 'админ', '管理', 'yönetim', 'administrador', 'admin', 'administrateur', 'το admin', 'Admin', 'Admin', 'ผู้ดูแลระบบ', 'منتظم', 'प्रशासन', 'Lorem ipsum dolor sit', 'admin', '管理者', '관리자');
INSERT INTO `language` VALUES (4, 'teacher', 'teacher', 'শিক্ষক', 'profesor', 'معلم', 'leraar', 'учитель', '老师', 'öğretmen', 'professor', 'tanár', 'professeur', 'δάσκαλος', 'Lehrer', 'insegnante', 'ครู', 'استاد', 'शिक्षक', 'Magister', 'guru', '教師', '선생');
INSERT INTO `language` VALUES (5, 'student', 'student', 'ছাত্র', 'estudiante', 'طالب', 'student', 'студент', '学生', 'öğrenci', 'estudante', 'diák', 'étudiant', 'φοιτητής', 'Schüler', 'studente', 'นักเรียน', 'طالب علم', 'छात्र', 'discipulo', 'mahasiswa', '学生', '학생');
INSERT INTO `language` VALUES (6, 'parent', 'parent', 'পিতা বা মাতা', 'padre', 'أصل', 'ouder', 'родитель', '亲', 'ebeveyn', 'parente', 'szülő', 'mère', 'μητρική εταιρεία', 'Elternteil', 'genitore', 'ผู้ปกครอง', 'والدین', 'माता - पिता', 'parente', 'induk', '親', '부모의');
INSERT INTO `language` VALUES (7, 'email', 'email', 'ইমেইল', 'email', 'البريد الإلكتروني', 'e-mail', 'по электронной почте', '电子邮件', 'E-posta', 'e-mail', 'E-mail', 'email', 'e-mail', 'E-Mail-', 'e-mail', 'อีเมล์', 'ای میل', 'ईमेल', 'email', 'email', 'メール', '이메일');
INSERT INTO `language` VALUES (8, 'password', 'password', 'পাসওয়ার্ড', 'contraseña', 'كلمة السر', 'wachtwoord', 'пароль', '密码', 'şifre', 'senha', 'jelszó', 'mot de passe', 'τον κωδικό', 'Passwort', 'password', 'รหัสผ่าน', 'پاس', 'पासवर्ड', 'Signum', 'kata sandi', 'パスワード', '암호');
INSERT INTO `language` VALUES (9, 'forgot_password ?', 'forgot password ?', 'পাসওয়ার্ড ভুলে গেছেন?', '¿Olvidó su contraseña?', 'نسيت كلمة المرور؟', 'wachtwoord vergeten?', 'забыли пароль?', '忘记密码？', 'Şifremi unuttum?', 'Esqueceu a senha?', 'Elfelejtett jelszó?', 'Mot de passe oublié?', 'Ξεχάσατε τον κωδικό;', 'Passwort vergessen?', 'dimenticato la password?', 'ลืมรหัสผ่าน', 'پاس ورڈ بھول گیا؟', 'क्या संभावनाएं हैं?', 'oblitus esne verbi?', 'lupa password?', 'パスワードを忘れた？', '비밀번호를 잊으 셨나요?');
INSERT INTO `language` VALUES (10, 'reset_password', 'reset password', 'পাসওয়ার্ড রিসেট', 'restablecer la contraseña', 'إعادة تعيين كلمة المرور', 'reset wachtwoord', 'сбросить пароль', '重设密码', 'şifrenizi sıfırlamak', 'redefinir a senha', 'Jelszó visszaállítása', 'réinitialiser le mot de passe', 'επαναφέρετε τον κωδικό πρόσβασης', 'Kennwort zurücksetzen', 'reimpostare la password', 'ตั้งค่ารหัสผ่าน', 'پاس ورڈ ری سیٹ', 'पासवर्ड रीसेट', 'Duis adipiscing', 'reset password', 'パスワードを再設定する', '암호를 재설정');
INSERT INTO `language` VALUES (11, 'reset', 'reset', 'রিসেট করুন', 'reajustar', 'إعادة تعيين', 'reset', 'сброс', '重置', 'ayarlamak', 'restabelecer', 'vissza', 'remettre', 'επαναφορά', 'rücksetzen', 'reset', 'ตั้งใหม่', 'ری سیٹ', 'रीसेट करें', 'Duis', 'ulang', 'リセット', '재설정');
INSERT INTO `language` VALUES (12, 'admin_dashboard', 'admin dashboard', 'অ্যাডমিন ড্যাশবোর্ড', 'administrador salpicadero', 'المشرف وحة القيادة', 'admin dashboard', 'админ панель', '管理面板', 'Admin paneli', 'Admin Dashboard', 'admin műszerfal', 'administrateur tableau de bord', 'πίνακα ελέγχου του διαχειριστή', 'Admin-Dashboard', 'Admin Dashboard', 'แผงควบคุมของผู้ดูแลระบบ', 'ایڈمن ڈیش بورڈ', 'व्यवस्थापक डैशबोर्ड', 'Lorem ipsum dolor sit Dashboard', 'admin dashboard', '管理ダッシュボード', '관리자 대시 보드');
INSERT INTO `language` VALUES (13, 'account', 'account', 'হিসাব', 'cuenta', 'حساب', 'rekening', 'счет', '帐户', 'hesap', 'conta', 'számla', 'compte', 'λογαριασμός', 'Konto', 'conto', 'บัญชี', 'اکاؤنٹ', 'खाता', 'propter', 'rekening', 'アカウント', '계정');
INSERT INTO `language` VALUES (14, 'profile', 'profile', 'পরিলেখ', 'perfil', 'ملف', 'profiel', 'профиль', '轮廓', 'profil', 'perfil', 'profil', 'profil', 'προφίλ', 'Profil', 'profilo', 'โปรไฟล์', 'پروفائل', 'रूपरेखा', 'profile', 'profil', 'プロフィール', '프로필');
INSERT INTO `language` VALUES (15, 'change_password', 'change password', 'পাসওয়ার্ড পরিবর্তন', 'cambiar la contraseña', 'تغيير كلمة المرور', 'wachtwoord wijzigen', 'изменить пароль', '更改密码', 'şifresini değiştirmek', 'alterar a senha', 'jelszó megváltoztatása', 'changer le mot de passe', 'αλλάξετε τον κωδικό πρόσβασης', 'Kennwort ändern', 'cambiare la password', 'เปลี่ยนรหัสผ่าน', 'پاس ورڈ تبدیل', 'पासवर्ड परिवर्तित', 'mutare password', 'mengubah password', 'パスワードを変更する', '암호를 변경');
INSERT INTO `language` VALUES (16, 'logout', 'logout', 'লগ আউট', 'logout', 'تسجيل الخروج', 'logout', 'выход', '注销', 'logout', 'Sair', 'logout', 'Déconnexion', 'αποσύνδεση', 'logout', 'Esci', 'ออกจากระบบ', 'لاگ آؤٹ کریں', 'लॉगआउट', 'logout', 'logout', 'ログアウト', '로그 아웃');
INSERT INTO `language` VALUES (17, 'panel', 'panel', 'প্যানেল', 'panel', 'لوحة', 'paneel', 'панель', '面板', 'panel', 'painel', 'bizottság', 'panneau', 'πίνακας', 'Platte', 'pannello', 'แผงหน้าปัด', 'پینل', 'पैनल', 'panel', 'panel', 'パネル', '패널');
INSERT INTO `language` VALUES (18, 'dashboard_help', 'dashboard help', 'ড্যাশবোর্ড সহায়তা', 'salpicadero ayuda', 'لوحة القيادة مساعدة', 'dashboard hulp', 'Приборная панель помощь', '仪表板帮助', 'pano yardım', 'dashboard ajuda', 'műszerfal help', 'tableau de bord aide', 'ταμπλό βοήθεια', 'Dashboard-Hilfe', 'dashboard aiuto', 'แผงควบคุมความช่วยเหลือ', 'ڈیش بورڈ مدد', 'डैशबोर्ड मदद', 'Dashboard auxilium', 'dashboard bantuan', 'ダッシュボードヘルプ', '대시 보드 도움말');
INSERT INTO `language` VALUES (19, 'dashboard', 'dashboard', 'ড্যাশবোর্ড', 'salpicadero', 'لوحة القيادة', 'dashboard', 'приборная панель', '仪表盘', 'gösterge paneli', 'painel de instrumentos', 'műszerfal', 'tableau de bord', 'ταμπλό', 'Armaturenbrett', 'cruscotto', 'หน้าปัด', 'ڈیش بورڈ', 'डैशबोर्ड', 'Dashboard', 'dasbor', 'ダッシュボード', '계기판');
INSERT INTO `language` VALUES (20, 'student_help', 'student help', 'শিক্ষার্থীর সাহায্য', 'ayuda estudiantil', 'مساعدة الطالب', 'student hulp', 'студент помощь', '学生的帮助', 'Öğrenci yardım', 'ajuda estudante', 'diák segítségével', 'aide aux étudiants', 'φοιτητής βοήθεια', 'Schüler-Hilfe', 'help studente', 'ช่วยเหลือนักเรียน', 'طالب علم کی مدد', 'छात्र मदद', 'Discipulus auxilium', 'membantu siswa', '学生のヘルプ', '학생 도움말');
INSERT INTO `language` VALUES (21, 'teacher_help', 'teacher help', 'শিক্ষক সাহায্য', 'ayuda del maestro', 'مساعدة المعلم', 'leraar hulp', 'Учитель помощь', '老师的帮助', 'öğretmen yardım', 'ajuda de professores', 'tanár segítségével', 'aide de l\'enseignant', 'βοήθεια των εκπαιδευτικών', 'Lehrer-Hilfe', 'aiuto dell\'insegnante', 'ครูช่วยเหลือ', 'استاد کی مدد', 'शिक्षक मदद', 'doctor auxilium', 'bantuan guru', '教師のヘルプ', '교사의 도움');
INSERT INTO `language` VALUES (22, 'subject_help', 'subject help', 'বিষয় সাহায্য', 'ayuda sujeto', 'مساعدة الموضوع', 'Onderwerp hulp', 'Заголовок помощь', '主题帮助', 'konusu yardım', 'ajuda assunto', 'tárgy segítségével', 'l\'objet de l\'aide', 'υπόκεινται βοήθεια', 'Thema Hilfe', 'Aiuto Subject', 'ความช่วยเหลือเรื่อง', 'موضوع مدد', 'विषय मदद', 'agitur salus', 'bantuan subjek', '件名ヘルプ', '주제 도움');
INSERT INTO `language` VALUES (23, 'subject', 'subject', 'বিষয়', 'sujeto', 'موضوع', 'onderwerp', 'тема', '主题', 'konu', 'assunto', 'tárgy', 'sujet', 'θέμα', 'Thema', 'soggetto', 'เรื่อง', 'موضوع', 'विषय', 'agitur', 'subyek', 'テーマ', '제목');
INSERT INTO `language` VALUES (24, 'class_help', 'class help', 'বর্গ সাহায্য', 'clase de ayuda', 'الطبقة مساعدة', 'klasse hulp', 'Класс помощь', '类的帮助', 'sınıf yardım', 'classe ajuda', 'osztály segítségével', 'aide de la classe', 'Κατηγορία βοήθεια', 'Klasse Hilfe', 'help classe', 'ความช่วยเหลือในชั้นเรียน', 'کلاس مدد', 'कक्षा मदद', 'genus auxilii', 'kelas bantuan', 'クラスのヘルプ', '클래스 도움');
INSERT INTO `language` VALUES (25, 'class', 'class', 'বর্গ', 'clase', 'فئة', 'klasse', 'класс', '类', 'sınıf', 'classe', 'osztály', 'classe', 'κατηγορία', 'Klasse', 'classe', 'ชั้น', 'کلاس', 'वर्ग', 'class', 'kelas', 'クラス', '클래스');
INSERT INTO `language` VALUES (26, 'exam_help', 'exam help', 'পরীক্ষায় সাহায্য', 'ayuda examen', 'امتحان مساعدة', 'examen hulp', 'Экзамен помощь', '考试帮助', 'sınav yardım', 'exame ajuda', 'vizsga help', 'aide à l\'examen', 'εξετάσεις βοήθεια', 'Prüfung Hilfe', 'esame di guida', 'การสอบความช่วยเหลือ', 'امتحان مدد', 'परीक्षा मदद', 'ipsum Auxilium', 'ujian bantuan', '試験ヘルプ', '시험에 도움');
INSERT INTO `language` VALUES (27, 'exam', 'exam', 'পরীক্ষা', 'examen', 'امتحان', 'tentamen', 'экзамен', '考试', 'sınav', 'exame', 'vizsgálat', 'exam', 'εξέταση', 'Prüfung', 'esame', 'การสอบ', 'امتحان', 'परीक्षा', 'Lorem ipsum', 'ujian', '試験', '시험');
INSERT INTO `language` VALUES (28, 'marks_help', 'marks help', 'চিহ্ন সাহায্য', 'marcas ayudan', 'علامات مساعدة', 'markeringen helpen', 'метки помогают', '标记帮助', 'işaretleri yardım', 'marcas ajudar', 'jelek segítenek', 'marques aident', 'σήματα βοηθήσει', 'Markierungen helfen', 'segni aiutano', 'เครื่องหมายช่วย', 'نمبر مدد', 'निशान मदद', 'notas auxilio', 'tanda membantu', 'マークのヘルプ', '마크는 데 도움이');
INSERT INTO `language` VALUES (29, 'marks-attendance', 'marks-attendance', 'চিহ্ন-উপস্থিতির', 'marcas-asistencia', 'علامات-الحضور', 'merken-deelname', 'знаки-посещаемости', '标记缺席', 'işaretleri-katılım', 'marcas de comparecimento', 'jelek-ellátás', 'marques-participation', 'σήματα προσέλευση', 'Marken-Teilnahme', 'marchi-presenze', 'เครื่องหมายการเข้าร่วม', 'نمبر حاضری', 'निशान उपस्थिति', 'signa eius ministrabant,', 'tanda-pertemuan', 'マーク·出席', '마크 출석');
INSERT INTO `language` VALUES (30, 'grade_help', 'grade help', 'গ্রেড সাহায্য', 'ayuda de grado', 'مساعدة الصف', 'leerjaar hulp', 'оценка помощь', '级帮助', 'sınıf yardım', 'ajuda grau', 'fokozat help', 'aide de qualité', 'βαθμού βοήθεια', 'Grade-Hilfe', 'aiuto grade', 'ช่วยเหลือเกรด', 'گریڈ مدد', 'ग्रेड मदद', 'gradus ope', 'kelas bantuan', 'グレードのヘルプ', '급 도움');
INSERT INTO `language` VALUES (31, 'exam-grade', 'exam-grade', 'পরীক্ষার শ্রেণী', 'examen de grado', 'امتحان الصف', 'examen-grade', 'экзамен класса', '考试级别', 'sınav notu', 'exame de grau', 'vizsga-grade', 'examen de qualité', 'εξετάσεις ποιότητας', 'Prüfung-Grade', 'esami-grade', 'สอบเกรด', 'امتحان گریڈ', 'परीक्षा ग्रेड', 'ipsum turpis,', 'ujian-grade', '試験グレード', '시험 등급');
INSERT INTO `language` VALUES (32, 'class_routine_help', 'class routine help', 'ক্লাসের রুটিন সাহায্য', 'clase ayuda rutina', 'الطبقة مساعدة روتينية', 'klasroutine hulp', 'класс рутина помощь', '类常规帮助', 'sınıf rutin yardım', 'classe ajuda rotina', 'osztály rutin segít', 'classe aide routine', 'κατηγορία ρουτίνας βοήθεια', 'Klasse Routine Hilfe', 'Classe aiuto di routine', 'ระดับความช่วยเหลือตามปกติ', 'کلاس معمول مدد', 'वर्ग दिनचर्या मदद', 'uno genere auxilium', 'kelas bantuan rutin', 'クラスルーチンのヘルプ', '클래스 루틴 도움');
INSERT INTO `language` VALUES (33, 'class_routine', 'class routine', 'ক্লাসের রুটিন', 'rutina de la clase', 'فئة الروتينية', 'klasroutine', 'класс подпрограмм', '常规类', 'sınıf rutin', 'rotina classe', 'osztály rutin', 'routine de classe', 'Κατηγορία ρουτίνα', 'Klasse Routine', 'classe di routine', 'ประจำชั้น', 'کلاس معمول', 'वर्ग दिनचर्या', 'in genere uno,', 'rutin kelas', 'クラス·ルーチン', '클래스 루틴');
INSERT INTO `language` VALUES (34, 'invoice_help', 'invoice help', 'চালান সাহায্য', 'ayuda factura', 'مساعدة الفاتورة', 'factuur hulp', 'счет-фактура помощь', '发票帮助', 'fatura yardım', 'ajuda factura', 'számla segítségével', 'aide facture', 'τιμολόγιο βοήθεια', 'Rechnungs Hilfe', 'help fattura', 'ช่วยเหลือใบแจ้งหนี้', 'انوائس مدد', 'चालान सहायता', 'auxilium cautionem', 'bantuan faktur', '送り状ヘルプ', '송장 도움');
INSERT INTO `language` VALUES (35, 'payment', 'payment', 'প্রদান', 'pago', 'دفع', 'betaling', 'оплата', '付款', 'ödeme', 'pagamento', 'fizetés', 'paiement', 'πληρωμή', 'Zahlung', 'pagamento', 'การชำระเงิน', 'ادائیگی', 'भुगतान', 'pecunia', 'pembayaran', '支払い', '지불');
INSERT INTO `language` VALUES (36, 'book_help', 'book help', 'বইয়ের সাহায্য', 'libro de ayuda', 'كتاب المساعدة', 'boek hulp', 'Книга помощь', '本书帮助', 'kitap yardımı', 'livro ajuda', 'könyv segít', 'livre aide', 'βοήθεια του βιβλίου', 'Buch-Hilfe', 'della guida', 'ช่วยเหลือหนังสือ', 'کتاب مدد', 'पुस्तक मदद', 'auxilium libro,', 'Buku bantuan', 'ブックのヘルプ', '책 도움말');
INSERT INTO `language` VALUES (37, 'library', 'library', 'লাইব্রেরি', 'biblioteca', 'مكتبة', 'bibliotheek', 'библиотека', '文库', 'kütüphane', 'biblioteca', 'könyvtár', 'bibliothèque', 'βιβλιοθήκη', 'Bibliothek', 'biblioteca', 'ห้องสมุด', 'لائبریری', 'पुस्तकालय', 'library', 'perpustakaan', '図書館', '도서관');
INSERT INTO `language` VALUES (38, 'transport_help', 'transport help', 'যানবাহনের সাহায্য', 'ayuda de transporte', 'مساعدة النقل', 'vervoer help', 'транспорт помощь', '运输帮助', 'ulaşım yardım', 'ajuda de transporte', 'szállítás Súgó', 'le transport de l\'aide', 'βοηθούν τη μεταφορά', 'Transport Hilfe', 'help trasporti', 'ช่วยเหลือการขนส่ง', 'نقل و حمل مدد', 'परिवहन मदद', 'auxilium onerariis', 'transportasi bantuan', '輸送のヘルプ', '전송 도움');
INSERT INTO `language` VALUES (39, 'transport', 'transport', 'পরিবহন', 'transporte', 'نقل', 'vervoer', 'транспорт', '运输', 'taşıma', 'transporte', 'szállítás', 'transport', 'μεταφορά', 'Transport', 'trasporto', 'การขนส่ง', 'نقل و حمل', 'परिवहन', 'onerariis', 'angkutan', '輸送', '수송');
INSERT INTO `language` VALUES (40, 'dormitory_help', 'dormitory help', 'আস্তানা সাহায্য', 'dormitorio de ayuda', 'عنبر المساعدة', 'slaapzaal hulp', 'общежитие помощь', '宿舍帮助', 'yatakhane yardım', 'dormitório ajuda', 'kollégiumi help', 'dortoir aide', 'κοιτώνα βοήθεια', 'Wohnheim Hilfe', 'dormitorio aiuto', 'หอพักช่วยเหลือ', 'شیناگار مدد', 'छात्रावास मदद', 'dormitorium auxilium', 'asrama bantuan', '寮のヘルプ', '기숙사 도움말');
INSERT INTO `language` VALUES (41, 'dormitory', 'dormitory', 'শ্রমিক - আস্তানা', 'dormitorio', 'المهجع', 'slaapzaal', 'спальня', '宿舍', 'yatakhane', 'dormitório', 'hálóterem', 'dortoir', 'κοιτώνα', 'Wohnheim', 'dormitorio', 'หอพัก', 'شیناگار', 'छात्रावास', 'dormitorium', 'asrama mahasiswa', '寮', '기숙사');
INSERT INTO `language` VALUES (42, 'noticeboard_help', 'noticeboard help', 'নোটিশবোর্ড সাহায্য', 'tablón de anuncios de la ayuda', 'اللافتة مساعدة', 'prikbord hulp', 'доска для объявлений помощь', '布告帮助', 'noticeboard yardım', 'avisos ajuda', 'üzenőfalán help', 'panneau d\'aide', 'ανακοινώσεων βοήθεια', 'Brett-Hilfe', 'bacheca aiuto', 'ป้ายประกาศความช่วยเหลือ', 'noticeboard مدد', 'Noticeboard मदद', 'auxilium noticeboard', 'pengumuman bantuan', '伝言板のヘルプ', '의 noticeboard 도움말');
INSERT INTO `language` VALUES (43, 'noticeboard-event', 'noticeboard-event', 'নোটিশবোর্ড-ইভেন্ট', 'tablón de anuncios de eventos', 'اللافتة الحدث', 'prikbord-event', 'доска для объявлений-событие', '布告牌事件', 'noticeboard olay', 'avisos de eventos', 'üzenőfalán esemény', 'panneau d\'événement', 'ανακοινώσεων εκδήλωση', 'Brett-Ereignis', 'bacheca-evento', 'ป้ายประกาศของเหตุการณ์', 'noticeboard ایونٹ', 'Noticeboard घटना', 'noticeboard eventus,', 'pengumuman-acara', '伝言板イベント', '의 noticeboard 이벤트');
INSERT INTO `language` VALUES (44, 'bed_ward_help', 'bed ward help', 'বিছানা ওয়ার্ড সাহায্য', 'cama ward ayuda', 'جناح سرير المساعدة', 'bed ward hulp', 'кровать подопечный помощь', '床病房的帮助', 'yatak koğuş yardım', 'ajuda cama enfermaria', 'ágy Ward help', 'lit salle de l\'aide', 'κρεβάτι πτέρυγα βοήθεια', 'Betten-Station Hilfe', 'Letto reparto aiuto', 'วอร์ดเตียงช่วยเหลือ', 'بستر وارڈ مدد', 'बिस्तर वार्ड मदद', 'lectum stans auxilium', 'tidur bangsal bantuan', 'ベッド病棟のヘルプ', '침대 병동 도움');
INSERT INTO `language` VALUES (45, 'settings', 'settings', 'সেটিংস', 'configuración', 'إعدادات', 'instellingen', 'настройки', '设置', 'ayarları', 'definições', 'beállítások', 'paramètres', 'Ρυθμίσεις', 'Einstellungen', 'Impostazioni', 'การตั้งค่า', 'ترتیبات', 'सेटिंग्स', 'occasus', 'Pengaturan', '設定', '설정');
INSERT INTO `language` VALUES (46, 'system_settings', 'system settings', 'সিস্টেম সেটিংস', 'configuración del sistema', 'إعدادات النظام', 'systeeminstellingen', 'настройки системы', '系统设置', 'sistem ayarları', 'configurações do sistema', 'rendszerbeállításokat', 'les paramètres du système', 'ρυθμίσεις του συστήματος', 'Systemeinstellungen', 'impostazioni di sistema', 'การตั้งค่าระบบ', 'نظام کی ترتیبات', 'प्रणाली सेटिंग्स', 'ratio occasus', 'pengaturan sistem', 'システム設定', '시스템 설정');
INSERT INTO `language` VALUES (47, 'manage_language', 'manage language', 'ভাষা ও পরিচালনা', 'gestionar idioma', 'إدارة اللغة', 'beheren taal', 'управлять язык', '管理语言', 'dil yönetmek', 'gerenciar língua', 'kezelni nyelv', 'gérer langue', 'διαχείριση γλώσσα', 'verwalten Sprache', 'gestire lingua', 'จัดการภาษา', 'زبان کا انتظام', 'भाषा का प्रबंधन', 'moderari linguam,', 'mengelola bahasa', '言語を管理', '언어를 관리');
INSERT INTO `language` VALUES (48, 'backup_restore', 'backup restore', 'ব্যাকআপ পুনঃস্থাপন', 'copia de seguridad a restaurar', 'استعادة النسخ الاحتياطي', 'backup terugzetten', 'восстановить резервного копирования', '备份还原', 'yedekleme geri', 'de backup restaurar', 'Backup Restore', 'restauration de sauvegarde', 'επαναφοράς αντιγράφων ασφαλείας', 'Backup wiederherstellen', 'ripristino di backup', 'การสำรองข้อมูลเรียกคืน', 'بیک اپ بحال', 'बैकअप बहाल', 'tergum restituunt', 'backup restore', 'バックアップは、リストア', '백업 복원');
INSERT INTO `language` VALUES (49, 'profile_help', 'profile help', 'সাহায্য প্রোফাইল', 'Perfil Ayuda', 'ملف المساعدة', 'profile hulp', 'анкета помощь', '简介帮助', 'yardım profile', 'Perfil ajuda', 'profile help', 'profil aide', 'προφίλ βοήθεια', 'Profil Hilfe', 'profilo di aiuto', 'โปรไฟล์ความช่วยเหลือ', 'مدد پروفائل', 'प्रोफाइल में', 'Auctor nullam opem', 'Profil bantuan', 'プロフィールヘルプ', '도움 프로필');
INSERT INTO `language` VALUES (50, 'manage_student', 'manage student', 'শিক্ষার্থী ও পরিচালনা', 'gestionar estudiante', 'إدارة الطلبة', 'beheren student', 'управлять студента', '管理学生', 'öğrenci yönetmek', 'gerenciar estudante', 'kezelni diák', 'gérer étudiant', 'διαχείριση των φοιτητών', 'Schüler verwalten', 'gestire studente', 'การจัดการศึกษา', 'طالب علم کا انتظام', 'छात्र का प्रबंधन', 'curo alumnorum', 'mengelola siswa', '生徒を管理', '학생 관리');
INSERT INTO `language` VALUES (51, 'manage_teacher', 'manage teacher', 'শিক্ষক ও পরিচালনা', 'gestionar maestro', 'إدارة المعلم', 'beheren leraar', 'управлять учителя', '管理老师', 'öğretmen yönetmek', 'gerenciar professor', 'kezelni tanár', 'gérer enseignant', 'διαχείριση των εκπαιδευτικών', 'Lehrer verwalten', 'gestire insegnante', 'จัดการครู', 'ٹیچر کا انتظام', 'शिक्षक का प्रबंधन', 'magister curo', 'mengelola guru', '教師を管理', '교사 관리');
INSERT INTO `language` VALUES (52, 'noticeboard', 'noticeboard', 'নোটিশবোর্ড', 'tablón de anuncios', 'اللافتة', 'prikbord', 'доска для объявлений', '布告', 'noticeboard', 'quadro de avisos', 'üzenőfalán', 'panneau d\'affichage', 'ανακοινώσεων', 'Brett', 'bacheca', 'ป้ายประกาศ', 'noticeboard', 'Noticeboard', 'noticeboard', 'pengumuman', '伝言板', '의 noticeboard');
INSERT INTO `language` VALUES (53, 'language', 'language', 'ভাষা', 'idioma', 'لغة', 'taal', 'язык', '语', 'dil', 'língua', 'nyelv', 'langue', 'γλώσσα', 'Sprache', 'lingua', 'ภาษา', 'زبان', 'भाषा', 'Lingua', 'bahasa', '言語', '언어');
INSERT INTO `language` VALUES (54, 'backup', 'backup', 'ব্যাকআপ', 'reserva', 'دعم', 'reservekopie', 'резервный', '备用', 'yedek', 'backup', 'mentés', 'sauvegarde', 'εφεδρικός', 'Sicherungskopie', 'di riserva', 'การสำรองข้อมูล', 'بیک اپ', 'बैकअप', 'tergum', 'backup', 'バックアップ', '지원');
INSERT INTO `language` VALUES (55, 'calendar_schedule', 'calendar schedule', 'ক্যালেন্ডার সময়সূচী', 'horario de calendario', 'الجدول الزمني', 'kalender schema', 'Календарь Расписание', '日历日程', 'takvim programı', 'agenda calendário', 'naptári ütemezés', 'calendrier calendrier', 'χρονοδιαγράμματος του ημερολογίου', 'Kalender Zeitplan', 'programma di calendario', 'ปฏิทินตารางนัดหมาย', 'کیلنڈر شیڈول', 'कैलेंडर अनुसूची', 'kalendarium ipsum', 'jadwal kalender', 'カレンダーのスケジュール', '캘린더 일정');
INSERT INTO `language` VALUES (56, 'select_a_class', 'select a class', 'একটি শ্রেণী নির্বাচন', 'seleccionar una clase', 'حدد فئة', 'selecteer een class', 'выберите класс', '选择一个类', 'bir sınıf seçin', 'selecionar uma classe', 'válasszon ki egy osztályt', 'sélectionner une classe', 'επιλέξτε μια κατηγορία', 'Wählen Sie eine Klasse', 'selezionare una classe', 'เลือกชั้น', 'ایک کلاس منتخب کریں', 'एक वर्ग का चयन करें', 'eligere genus', 'pilih kelas', 'クラスを選択', '클래스를 선택');
INSERT INTO `language` VALUES (57, 'student_list', 'student list', 'শিক্ষার্থীর তালিকা', 'lista de alumnos', 'قائمة الطلاب', 'student lijst', 'Список студент', '学生名单', 'öğrenci listesi', 'lista de alunos', 'diák lista', 'liste des étudiants', 'κατάλογο των φοιτητών', 'Schülerliste', 'elenco degli studenti', 'รายชื่อนักเรียน', 'طالب علم کی فہرست', 'छात्र सूची', 'Discipulus album', 'daftar mahasiswa', '学生のリスト', '학생 목록');
INSERT INTO `language` VALUES (58, 'add_student', 'add student', 'ছাত্র যোগ', 'añadir estudiante', 'إضافة طالب', 'voeg student', 'добавить студента', '新增学生', 'öğrenci eklemek', 'adicionar estudante', 'hozzá hallgató', 'ajouter étudiant', 'προσθέστε φοιτητής', 'Student hinzufügen', 'aggiungere studente', 'เพิ่มนักเรียน', 'طالب علم شامل', 'छात्र जोड़', 'adde elit', 'menambahkan mahasiswa', '学生を追加', '학생을 추가');
INSERT INTO `language` VALUES (59, 'roll', 'roll', 'রোল', 'rollo', 'لفة', 'broodje', 'рулон', '滚', 'rulo', 'rolo', 'tekercs', 'rouleau', 'ρολό', 'Rolle', 'rotolo', 'ม้วน', 'رول', 'रोल', 'volumen', 'gulungan', 'ロール', '롤');
INSERT INTO `language` VALUES (60, 'photo', 'photo', 'ছবি', 'foto', 'صور', 'foto', 'фото', '照片', 'fotoğraf', 'foto', 'fénykép', 'photo', 'φωτογραφία', 'Foto', 'foto', 'ภาพถ่าย', 'تصویر', 'फ़ोटो', 'Lorem ipsum', 'foto', '写真', '사진');
INSERT INTO `language` VALUES (61, 'student_name', 'student name', 'শিক্ষার্থীর নাম', 'Nombre del estudiante', 'اسم الطالب', 'naam van de leerling', 'Имя студента', '学生姓名', 'Öğrenci adı', 'nome do aluno', 'tanuló nevét', 'nom de l\'étudiant', 'το όνομα του μαθητή', 'Studentennamen', 'nome dello studente', 'ชื่อนักเรียน', 'طالب علم کے نام', 'छात्र का नाम', 'ipsum est nomen', 'nama siswa', '学生の名前', '학생의 이름');
INSERT INTO `language` VALUES (62, 'address', 'address', 'ঠিকানা', 'dirección', 'عنوان', 'adres', 'адрес', '地址', 'adres', 'endereço', 'cím', 'adresse', 'διεύθυνση', 'Adresse', 'indirizzo', 'ที่อยู่', 'ایڈریس', 'पता', 'Oratio', 'alamat', 'アドレス', '주소');
INSERT INTO `language` VALUES (63, 'options', 'options', 'অপশন', 'Opciones', 'خيارات', 'opties', 'опции', '选项', 'seçenekleri', 'opções', 'lehetőségek', 'les options', 'Επιλογές', 'Optionen', 'Opzioni', 'ตัวเลือก', 'اختیارات', 'विकल्प', 'options', 'Pilihan', 'オプション', '옵션');
INSERT INTO `language` VALUES (64, 'marksheet', 'marksheet', 'marksheet', 'marksheet', 'marksheet', 'Marksheet', 'marksheet', 'marksheet', 'Marksheet', 'marksheet', 'Marksheet', 'relevé de notes', 'Marksheet', 'marksheet', 'Marksheet', 'marksheet', 'marksheet', 'अंकपत्र', 'marksheet', 'marksheet', 'marksheet', 'marksheet');
INSERT INTO `language` VALUES (65, 'id_card', 'id card', 'আইডি কার্ড', 'carnet de identidad', 'بطاقة الهوية', 'id-kaart', 'удостоверение личности', '身份证', 'kimlik kartı', 'carteira de identidade', 'személyi igazolvány', 'carte d\'identité', 'id κάρτα', 'Ausweis', 'carta d\'identità', 'บัตรประชาชน', 'شناختی کارڈ', 'औ डी कार्ड', 'id ipsum', 'id card', 'IDカード', '신분증');
INSERT INTO `language` VALUES (66, 'edit', 'edit', 'সম্পাদন করা', 'editar', 'تحرير', 'uitgeven', 'редактировать', '编辑', 'düzenleme', 'editar', 'szerkeszt', 'modifier', 'edit', 'bearbeiten', 'modifica', 'แก้ไข', 'میں ترمیم کریں', 'संपादित करें', 'edit', 'mengedit', '編集', '편집');
INSERT INTO `language` VALUES (67, 'delete', 'delete', 'মুছে ফেলা', 'borrar', 'حذف', 'verwijderen', 'удалять', '删除', 'silmek', 'excluir', 'töröl', 'effacer', 'διαγραφή', 'löschen', 'cancellare', 'ลบ', 'خارج', 'हटाना', 'vel deleri,', 'menghapus', '削除する', '삭제');
INSERT INTO `language` VALUES (68, 'personal_profile', 'personal profile', 'ব্যক্তিগত প্রোফাইল', 'perfil personal', 'ملف شخصي', 'persoonlijk profiel', 'личный профиль', '个人简介', 'kişisel profil', 'perfil pessoal', 'személyes profil', 'profil personnel', 'προσωπικό προφίλ', 'persönliches Profil', 'profilo personale', 'รายละเอียดข้อมูลส่วนตัว', 'ذاتی پروفائل', 'व्यक्तिगत प्रोफाइल', 'personal profile', 'profil pribadi', '人物点描', '개인 프로필');
INSERT INTO `language` VALUES (69, 'academic_result', 'academic result', 'একাডেমিক ফলাফল', 'resultado académico', 'نتيجة الأكاديمية', 'academische resultaat', 'академический результат', '学术成果', 'akademik sonuç', 'resultado acadêmico', 'tudományos eredmény', 'résultat académique', 'ακαδημαϊκή αποτέλεσμα', 'Studienergebnis', 'risultato accademico', 'ผลการศึกษา', 'تعلیمی نتیجہ', 'शैक्षिक परिणाम', 'Ex academicis', 'Hasil akademik', '学術結果', '학습 결​​과');
INSERT INTO `language` VALUES (70, 'name', 'name', 'নাম', 'nombre', 'اسم', 'naam', 'название', '名称', 'isim', 'nome', 'név', 'nom', 'όνομα', 'Name', 'nome', 'ชื่อ', 'نام', 'नाम', 'nomen,', 'nama', '名前', '이름');
INSERT INTO `language` VALUES (71, 'birthday', 'birthday', 'জন্মদিন', 'cumpleaños', 'عيد ميلاد', 'verjaardag', 'день рождения', '生日', 'doğum günü', 'aniversário', 'születésnap', 'anniversaire', 'γενέθλια', 'Geburtstag', 'compleanno', 'วันเกิด', 'سالگرہ', 'जन्मदिन', 'natalis', 'ulang tahun', '誕生日', '생일');
INSERT INTO `language` VALUES (72, 'sex', 'sex', 'লিঙ্গ', 'sexo', 'جنس', 'seks', 'секс', '性别', 'seks', 'sexo', 'szex', 'sexe', 'φύλο', 'Sex', 'sesso', 'เพศ', 'جنسی', 'लिंग', 'sex', 'seks', 'セックス', '섹스');
INSERT INTO `language` VALUES (73, 'male', 'male', 'পুরুষ', 'masculino', 'ذكر', 'mannelijk', 'мужской', '男性', 'erkek', 'masculino', 'férfi', 'mâle', 'αρσενικός', 'männlich', 'maschio', 'เพศชาย', 'پروفائل', 'नर', 'masculus', 'laki-laki', '男性', '남성');
INSERT INTO `language` VALUES (74, 'female', 'female', 'মহিলা', 'femenino', 'أنثى', 'vrouw', 'женский', '女', 'kadın', 'feminino', 'női', 'femelle', 'θηλυκός', 'weiblich', 'femminile', 'เพศหญิง', 'خواتین', 'महिला', 'femina,', 'perempuan', '女性', '여성');
INSERT INTO `language` VALUES (75, 'religion', 'religion', 'ধর্ম', 'religión', 'دين', 'religie', 'религия', '宗教', 'din', 'religião', 'vallás', 'religion', 'θρησκεία', 'Religion', 'religione', 'ศาสนา', 'مذہب', 'धर्म', 'religionis,', 'agama', '宗教', '종교');
INSERT INTO `language` VALUES (76, 'blood_group', 'blood group', 'রক্তের বিভাগ', 'grupo sanguíneo', 'فصيلة الدم', 'bloedgroep', 'группа крови', '血型', 'kan grubu', 'grupo sanguíneo', 'vércsoport', 'groupe sanguin', 'ομάδα αίματος', 'Blutgruppe', 'gruppo sanguigno', 'กรุ๊ปเลือด', 'خون کے گروپ', 'रक्त वर्ग', 'sanguine coetus', 'golongan darah', '血液型', '혈액형');
INSERT INTO `language` VALUES (77, 'phone', 'phone', 'ফোন', 'teléfono', 'هاتف', 'telefoon', 'телефон', '电话', 'telefon', 'telefone', 'telefon', 'téléphone', 'τηλέφωνο', 'Telefon', 'telefono', 'โทรศัพท์', 'فون', 'फ़ोन', 'Praesent', 'telepon', '電話', '전화');
INSERT INTO `language` VALUES (78, 'father_name', 'father name', 'পিতার নাম', 'Nombre del padre', 'اسم الأب', 'naam van de vader', 'отчество', '父亲姓名', 'baba adı', 'nome pai', 'apa név', 'nom de père', 'Το όνομα του πατέρα', 'Der Name des Vaters', 'nome del padre', 'ชื่อพ่อ', 'والد کا نام', 'पिता का नाम', 'nomine Patris,', 'Nama ayah', '父親の名前', '아버지의 이름');
INSERT INTO `language` VALUES (79, 'mother_name', 'mother name', 'মায়ের নাম', 'Nombre de la madre', 'اسم الأم', 'moeder naam', 'Имя матери', '母亲的名字', 'anne adı', 'Nome mãe', 'anyja név', 'nom de la mère', 'το όνομα της μητέρας', 'Name der Mutter', 'Nome madre', 'ชื่อแม่', 'ماں کا نام', 'माता का नाम', 'matris nomen,', 'Nama ibu', '母の名前', '어머니 이름');
INSERT INTO `language` VALUES (80, 'edit_student', 'edit student', 'সম্পাদনা ছাত্র', 'edit estudiante', 'تحرير الطالب', 'bewerk student', 'редактирования студент', '编辑学生', 'edit öğrenci', 'edição aluno', 'szerkesztés diák', 'modifier étudiant', 'επεξεργασία των φοιτητών', 'Schüler bearbeiten', 'modifica dello studente', 'แก้ไขนักเรียน', 'ترمیم کے طالب علم', 'संपादित छात्र', 'edit studiosum', 'mengedit siswa', '編集学生', '편집 학생');
INSERT INTO `language` VALUES (81, 'teacher_list', 'teacher list', 'শিক্ষক তালিকা', 'lista maestra', 'قائمة المعلم', 'leraar lijst', 'Список учителей', '老师名单', 'öğretmen listesi', 'lista de professores', 'tanár lista', 'Liste des enseignants', 'Λίστα των εκπαιδευτικών', 'Lehrer-Liste', 'elenco degli insegnanti', 'รายชื่อครู', 'استاد فہرست', 'शिक्षक सूची', 'magister album', 'daftar guru', '教員リスト', '교사의 목록');
INSERT INTO `language` VALUES (82, 'add_teacher', 'add teacher', 'শিক্ষক যোগ', 'añadir profesor', 'إضافة المعلم', 'voeg leraar', 'добавить учителя', '加上老师', 'öğretmen ekle', 'adicionar professor', 'hozzá tanár', 'ajouter enseignant', 'προσθέστε δάσκαλος', 'Lehrer hinzufügen', 'aggiungere insegnante', 'เพิ่มครู', 'استاد شامل', 'शिक्षक जोड़', 'Magister addit', 'menambah guru', '先生を追加', '교사를 추가');
INSERT INTO `language` VALUES (83, 'teacher_name', 'teacher name', 'শিক্ষক নাম', 'Nombre del profesor', 'اسم المعلم', 'leraarsnaam', 'Имя учителя', '老师姓名', 'öğretmen adı', 'nome professor', 'tanár név', 'nom des enseignants', 'όνομα των εκπαιδευτικών', 'Lehrer Name', 'Nome del docente', 'ชื่อครู', 'استاد کا نام', 'शिक्षक का नाम', 'magister nomine', 'nama guru', '教員名', '교사 이름');
INSERT INTO `language` VALUES (84, 'edit_teacher', 'edit teacher', 'সম্পাদনা শিক্ষক', 'edit maestro', 'تحرير المعلم', 'leraar bewerken', 'править учитель', '编辑老师', 'edit öğretmen', 'editar professor', 'szerkesztés tanár', 'modifier enseignant', 'edit εκπαιδευτικών', 'edit Lehrer', 'modifica insegnante', 'แก้ไขครู', 'ترمیم استاد', 'संपादित करें शिक्षक', 'edit magister', 'mengedit guru', '編集の先生', '편집 교사');
INSERT INTO `language` VALUES (85, 'manage_parent', 'manage parent', 'অভিভাবক ও পরিচালনা', 'gestionar los padres', 'إدارة الأم', 'beheren ouder', 'управлять родителей', '母公司管理', 'ebeveyn yönetmek', 'gerenciar pai', 'kezelni szülő', 'gérer parent', 'διαχείριση μητρική', 'verwalten Mutter', 'gestione genitore', 'จัดการปกครอง', 'والدین کا انتظام', 'माता - पिता का प्रबंधन', 'curo parent', 'mengelola orang tua', '親を管理', '부모 관리');
INSERT INTO `language` VALUES (86, 'parent_list', 'parent list', 'মূল তালিকা', 'lista primaria', 'قائمة الوالد', 'ouder lijst', 'родительского списка', '父列表', 'ebeveyn listesi', 'lista pai', 'szülő lista', 'liste parent', 'μητρική λίστα', 'geordneten Liste', 'elenco padre', 'รายชื่อผู้ปกครอง', 'والدین کی فہرست', 'माता - पिता सूची', 'parente album', 'daftar induk', '親リスト', '상위 목록');
INSERT INTO `language` VALUES (87, 'parent_name', 'parent name', 'মূল নাম', 'Nombre del padre', 'اسم الوالد', 'oudernaam', 'родитель название', '父名', 'ebeveyn isim', 'nome do pai', 'szülő név', 'nom du parent', 'μητρικό όνομα', 'Mutternamen', 'nome del padre', 'ชื่อผู้ปกครอง', 'والدین کے نام', 'माता - पिता का नाम', 'Nomen parentis,', 'nama orang tua', '親の名前', '부모 이름');
INSERT INTO `language` VALUES (88, 'relation_with_student', 'relation with student', 'ছাত্রদের সঙ্গে সম্পর্ক', 'relación con el estudiante', 'العلاقة مع الطالب', 'relatie met student', 'отношения с учеником', '与学生关系', 'öğrenci ile ilişkisi', 'relação com o aluno', 'kapcsolatban diák', 'relation avec l\'élève', 'σχέση με τον μαθητή', 'Zusammenhang mit Studenten', 'rapporto con lo studente', 'ความสัมพันธ์กับนักเรียน', 'طالب علم کے ساتھ تعلق', 'छात्रा के साथ संबंध', 'cum inter ipsum', 'hubungan dengan siswa', '学生との関係', '학생과의 관계');
INSERT INTO `language` VALUES (89, 'parent_email', 'parent email', 'মূল ইমেইল', 'correo electrónico de los padres', 'البريد الإلكتروني الأم', 'ouder email', 'родитель письмо', '父母的电子邮件', 'ebeveyn email', 'e-mail dos pais', 'szülő e-mail', 'parent email', 'email του γονέα', 'Eltern per E-Mail', 'email genitore', 'อีเมล์ผู้ปกครอง', 'والدین کا ای میل', 'माता - पिता ईमेल', 'parente email', 'email induk', '親電子メール', '부모의 이메일');
INSERT INTO `language` VALUES (90, 'parent_phone', 'parent phone', 'ঊর্ধ্বতন ফোন', 'teléfono de los padres', 'الهاتف الوالدين', 'ouder telefoon', 'родитель телефон', '家长电话', 'ebeveyn telefon', 'telefone dos pais', 'szülő telefon', 'mère de téléphone', 'μητρική τηλέφωνο', 'Elterntelefon', 'telefono genitore', 'โทรศัพท์ของผู้ปกครอง', 'والدین فون', 'माता - पिता को फोन', 'parentis phone', 'telepon orang tua', '親の携帯電話', '부모 전화');
INSERT INTO `language` VALUES (91, 'parrent_address', 'parrent address', 'parrent ঠিকানা', 'Dirección Parrent', 'عنوان parrent', 'parrent adres', 'Parrent адрес', 'parrent地址', 'parrent adresi', 'endereço Parrent', 'parrent cím', 'adresse Parrent', 'parrent διεύθυνση', 'parrent Adresse', 'Indirizzo parrent', 'ที่อยู่ parrent', 'parrent ایڈریس', 'parrent पता', 'oratio parrent', 'alamat parrent', 'parrentアドレス', 'parrent 주소');
INSERT INTO `language` VALUES (92, 'parrent_occupation', 'parrent occupation', 'parrent বৃত্তি', 'ocupación Parrent', 'الاحتلال parrent', 'parrent bezetting', 'Parrent оккупация', 'parrent职业', 'parrent işgal', 'ocupação Parrent', 'parrent Foglalkozás', 'occupation Parrent', 'parrent επάγγελμα', 'parrent Beruf', 'occupazione parrent', 'อาชีพ parrent', 'parrent قبضے', 'parrent कब्जे', 'opus parrent', 'pendudukan parrent', 'parrent職業', 'parrent 직업');
INSERT INTO `language` VALUES (93, 'add', 'add', 'যোগ করা', 'añadir', 'إضافة', 'toevoegen', 'добавлять', '加', 'eklemek', 'adicionar', 'hozzáad', 'ajouter', 'προσθήκη', 'hinzufügen', 'aggiungere', 'เพิ่ม', 'شامل', 'जोड़ना', 'Adde', 'menambahkan', '加える', '추가');
INSERT INTO `language` VALUES (94, 'parent_of', 'parent of', 'অভিভাবক', 'matriz de', 'الأم ل', 'ouder van', 'родитель', '父', 'ebeveyn', 'pai', 'szülő', 'parent d\'', 'γονέας', 'Muttergesellschaft der', 'madre di', 'ผู้ปกครองของ', 'والدین', 'के माता - पिता', 'parentem,', 'induk dari', 'の親', '의 부모');
INSERT INTO `language` VALUES (95, 'profession', 'profession', 'পেশা', 'profesión', 'مهنة', 'beroep', 'профессия', '职业', 'meslek', 'profissão', 'szakma', 'profession', 'επάγγελμα', 'Beruf', 'professione', 'อาชีพ', 'پیشہ', 'व्यवसाय', 'professio', 'profesi', '職業', '직업');
INSERT INTO `language` VALUES (96, 'edit_parent', 'edit parent', 'সম্পাদনা ঊর্ধ্বতন', 'edit padres', 'تحرير الوالدين', 'bewerk ouder', 'править родитель', '编辑父', 'edit ebeveyn', 'edição pai', 'szerkesztés szülő', 'modifier parent', 'edit γονέα', 'edit Mutter', 'modifica genitore', 'แก้ไขผู้ปกครอง', 'میں ترمیم کریں والدین', 'संपादित जनक', 'edit parent', 'mengedit induk', '編集親', '편집 부모');
INSERT INTO `language` VALUES (97, 'add_parent', 'add parent', 'ঊর্ধ্বতন যোগ', 'añadir los padres', 'إضافة الوالد', 'Voeg een ouder', 'добавить родителя', '添加父', 'ebeveyn ekle', 'adicionar pai', 'hozzá szülő', 'ajouter parent', 'προσθέστε μητρική', 'Mutter hinzufügen', 'aggiungere genitore', 'เพิ่มผู้ปกครอง', 'والدین شامل', 'माता - पिता जोड़', 'adde parent', 'menambahkan orang tua', '親を追加', '부모를 추가');
INSERT INTO `language` VALUES (98, 'manage_subject', 'manage subject', 'বিষয় ও পরিচালনা', 'gestionar sujeto', 'إدارة الموضوع', 'beheren onderwerp', 'управлять тему', '管理主题', 'konuyu yönetmek', 'gerenciar assunto', 'kezelni tárgy', 'gérer sujet', 'διαχείριση υπόκειται', 'Thema verwalten', 'gestire i soggetti', 'การจัดการเรื่อง', 'موضوع کا انتظام', 'विषय का प्रबंधन', 'subiectum disponat', 'mengelola subjek', '対象を管理', '대상 관리');
INSERT INTO `language` VALUES (99, 'subject_list', 'subject list', 'বিষয় তালিকা', 'lista por materia', 'قائمة الموضوع', 'Onderwerp lijst', 'Список подлежит', '主题列表', 'konu listesi', 'lista por assunto', 'téma lista', 'liste de sujets', 'υπόκεινται λίστα', 'Themenliste', 'lista soggetto', 'รายการเรื่อง', 'موضوع کی فہرست', 'विषय सूची', 'subiectum album', 'daftar subjek', 'サブジェクトリスト', '주제 목록');
INSERT INTO `language` VALUES (100, 'add_subject', 'add subject', 'বিষয় যোগ', 'Añadir asunto', 'إضافة الموضوع', 'Onderwerp toevoegen', 'добавить тему', '新增主题', 'konu ekle', 'adicionar assunto', 'Tárgy hozzáadása', 'ajouter l\'objet', 'Προσθήκη θέματος', 'Thema hinzufügen', 'aggiungere soggetto', 'เพิ่มเรื่อง', 'موضوع', 'जोड़ें विषय', 're addere', 'menambahkan subjek', '件名を追加', '제목을 추가');
INSERT INTO `language` VALUES (101, 'subject_name', 'subject name', 'বিষয় নাম', 'nombre del sujeto', 'اسم الموضوع', 'Onderwerp naam', 'имя субъекта', '主题名称', 'konu adı', 'nome do assunto', 'tárgy megnevezése', 'nom du sujet', 'υπόκεινται όνομα', 'Thema Namen', 'nome del soggetto', 'ชื่อเรื่อง', 'موضوع کے نام', 'विषय का नाम', 'agitur nomine', 'nama subjek', 'サブジェクト名', '주체 이름');
INSERT INTO `language` VALUES (102, 'edit_subject', 'edit subject', 'সম্পাদনা বিষয়', 'Editar asunto', 'تحرير الموضوع', 'Onderwerp bewerken', 'Изменить тему', '编辑主题', 'düzenleme konusu', 'Editar assunto', 'Tárgy szerkesztése', 'modifier l\'objet', 'edit θέμα', 'Betreff bearbeiten', 'Modifica oggetto', 'แก้ไขเรื่อง', 'موضوع میں ترمیم کریں', 'विषय संपादित करें', 'edit subiecto', 'mengedit subjek', '編集対象', '제목 수정');
INSERT INTO `language` VALUES (103, 'manage_class', 'manage class', 'ক্লাস ও পরিচালনা', 'gestionar clase', 'إدارة الصف', 'beheren klasse', 'управлять класс', '管理类', 'sınıf yönetmek', 'gerenciar classe', 'kezelni osztály', 'gérer classe', 'διαχείριση τάξης', 'Klasse verwalten', 'gestione della classe', 'การจัดการชั้นเรียน', 'کلاس کا انتظام', 'वर्ग का प्रबंधन', 'genus regendi', 'mengelola kelas', 'クラスを管理', '클래스에게 관리');
INSERT INTO `language` VALUES (104, 'class_list', 'class list', 'বর্গ তালিকা', 'lista de la clase', 'قائمة فئة', 'klasse lijst', 'Список класс', '类列表', 'sınıf listesi', 'lista de classe', 'class lista', 'liste de classe', 'πίνακας αποτελεσμάτων', 'Klassenliste', 'elenco di classe', 'รายการชั้น', 'کلاس فہرست', 'कक्षा सूची', 'genus album', 'daftar kelas', 'クラスリスト', '클래스 목록');
INSERT INTO `language` VALUES (105, 'add_class', 'add class', 'ক্লাসে যোগ', 'agregar la clase', 'إضافة فئة', 'voeg klasse', 'добавить класс', '添加类', 'sınıf eklemek', 'adicionar classe', 'hozzá osztály', 'ajouter la classe', 'προσθέσετε τάξη', 'Klasse hinzufügen', 'aggiungere classe', 'เพิ่มระดับ', 'کلاس شامل کریں', 'वर्ग जोड़', 'adde genus', 'menambahkan kelas', 'クラスを追加', '클래스를 추가');
INSERT INTO `language` VALUES (106, 'class_name', 'class name', 'শ্রেণীর নাম', 'nombre de la clase', 'اسم الفئة', 'class naam', 'Имя класса', '类名', 'sınıf adı', 'nome da classe', 'osztály neve', 'nom de la classe', 'όνομα της κλάσης', 'Klassennamen', 'nome della classe', 'ชื่อชั้น', 'کلاس نام', 'वर्ग के नाम', 'Classis nomine', 'nama kelas', 'クラス名', '클래스 이름');
INSERT INTO `language` VALUES (107, 'numeric_name', 'numeric name', 'সাংখ্যিক নাম', 'nombre numérico', 'اسم رقمية', 'numerieke naam', 'числовое имя', '数字名称', 'Sayısal isim', 'nome numérico', 'numerikus név', 'nom numérique', 'αριθμητικό όνομα', 'numerischen Namen', 'nome numerico', 'ชื่อตัวเลข', 'عددی نام', 'सांख्यिक नाम', 'secundum numerum est secundum nomen,', 'Nama numerik', '数値の名前', '숫자 이름');
INSERT INTO `language` VALUES (108, 'name_numeric', 'name numeric', 'সাংখ্যিক নাম দিন', 'nombre numérico', 'تسمية رقمية', 'naam numerieke', 'назвать числовой', '数字命名', 'sayısal isim', 'nome numérico', 'név numerikus', 'nommer numérique', 'όνομα αριθμητικό', 'nennen numerischen', 'nome numerico', 'ชื่อตัวเลข', 'عددی نام', 'सांख्यिक का नाम', 'secundum numerum est secundum nomen,', 'nama numerik', '数値に名前を付ける', '숫자 이름을');
INSERT INTO `language` VALUES (109, 'edit_class', 'edit class', 'সম্পাদনা বর্গ', 'clase de edición', 'الطبقة تحرير', 'bewerken klasse', 'править класс', '编辑类', 'sınıf düzenle', 'edição classe', 'szerkesztés osztály', 'modifier la classe', 'edit κατηγορία', 'Klasse bearbeiten', 'modifica della classe', 'แก้ไขระดับ', 'ترمیم کلاس', 'संपादित वर्ग', 'edit genere', 'mengedit kelas', '編集クラス', '편집 클래스');
INSERT INTO `language` VALUES (110, 'manage_exam', 'manage exam', 'পরীক্ষা পরিচালনা', 'gestionar examen', 'إدارة الامتحان', 'beheren examen', 'управлять экзамен', '考试管理', 'sınavı yönetmek', 'gerenciar exame', 'kezelni vizsga', 'gérer examen', 'διαχείριση εξετάσεις', 'Prüfung verwalten', 'gestire esame', 'การจัดการสอบ', 'امتحان کا انتظام', 'परीक्षा का प्रबंधन', 'curo ipsum', 'mengelola ujian', '試験を管理', '시험 관리');
INSERT INTO `language` VALUES (111, 'exam_list', 'exam list', 'পরীক্ষার তালিকা', 'lista de exámenes', 'قائمة الامتحان', 'examen lijst', 'Список экзамен', '考试名单', 'sınav listesi', 'lista de exames', 'vizsga lista', 'liste d\'examen', 'Λίστα εξετάσεις', 'Prüfungsliste', 'elenco esami', 'รายการสอบ', 'امتحان فہرست', 'परीक्षा सूची', 'Lorem ipsum album', 'daftar ujian', '試験のリスト', '시험 목록');
INSERT INTO `language` VALUES (112, 'add_exam', 'add exam', 'পরীক্ষার যোগ', 'agregar examen', 'إضافة امتحان', 'voeg examen', 'добавить экзамен', '新增考试', 'sınav eklemek', 'adicionar exame', 'hozzá vizsga', 'ajouter examen', 'προσθέσετε εξετάσεις', 'Prüfung hinzufügen', 'aggiungere esame', 'เพิ่มการสอบ', 'امتحان میں شامل کریں', 'परीक्षा जोड़', 'adde ipsum', 'menambahkan ujian', '試験を追加', '시험에 추가');
INSERT INTO `language` VALUES (113, 'exam_name', 'exam name', 'পরীক্ষার নাম', 'nombre del examen', 'اسم الامتحان', 'examen naam', 'Название экзамен', '考试名称', 'sınav adı', 'nome do exame', 'Vizsga neve', 'nom de l\'examen', 'Το όνομά εξετάσεις', 'Prüfungsnamen', 'nome dell\'esame', 'ชื่อสอบ', 'امتحان کے نام', 'परीक्षा का नाम', 'ipsum nomen,', 'Nama ujian', '試験名', '시험 이름');
INSERT INTO `language` VALUES (114, 'date', 'date', 'তারিখ', 'fecha', 'تاريخ', 'datum', 'дата', '日期', 'tarih', 'data', 'dátum', 'date', 'ημερομηνία', 'Datum', 'data', 'วันที่', 'تاریخ', 'तारीख', 'date', 'tanggal', '日付', '날짜');
INSERT INTO `language` VALUES (115, 'comment', 'comment', 'মন্তব্য', 'comentario', 'تعليق', 'commentaar', 'комментарий', '评论', 'yorum', 'comentário', 'megjegyzés', 'commentaire', 'σχόλιο', 'Kommentar', 'commento', 'ความเห็น', 'تبصرہ', 'टिप्पणी', 'comment', 'komentar', 'コメント', '논평');
INSERT INTO `language` VALUES (116, 'edit_exam', 'edit exam', 'সম্পাদনা পরীক্ষা', 'examen de edición', 'امتحان تحرير', 'bewerk examen', 'править экзамен', '编辑考试', 'edit sınavı', 'edição do exame', 'szerkesztés vizsga', 'modifier examen', 'edit εξετάσεις', 'edit Prüfung', 'modifica esame', 'แก้ไขการสอบ', 'ترمیم امتحان', 'संपादित परीक्षा', 'edit ipsum', 'mengedit ujian', '編集試験', '편집 시험');
INSERT INTO `language` VALUES (117, 'manage_exam_marks', 'manage exam marks', 'পরীক্ষা চিহ্ন ও পরিচালনা', 'gestionar marcas de examen', 'إدارة علامات الامتحان', 'beheren examencijfers', 'управлять экзаменационные отметки', '管理考试痕', 'sınav işaretleri yönetmek', 'gerenciar marcas exame', 'kezelni vizsga jelek', 'gérer les marques d\'examen', 'διαχείριση των σημάτων εξετάσεις', 'Prüfungsnoten verwalten', 'gestire i voti degli esami', 'จัดการสอบเครื่องหมาย', 'امتحان کے نشانات کا انتظام', 'परीक्षा के निशान का प्रबंधन', 'ipsum curo indicia', 'mengelola nilai ujian', '試験マークを管理', '시험 점수를 관리');
INSERT INTO `language` VALUES (118, 'manage_marks', 'manage marks', 'চিহ্ন ও পরিচালনা', 'gestionar marcas', 'إدارة علامات', 'beheren merken', 'управлять знаки', '商标管理', 'işaretleri yönetmek', 'gerenciar marcas', 'kezelni jelek', 'gérer les marques', 'διαχείριση των σημάτων', 'Markierungen verwalten', 'gestire i marchi', 'จัดการเครื่องหมาย', 'نمبروں کا انتظام', 'निशान का प्रबंधन', 'curo indicia', 'mengelola tanda', 'マークを管理', '마크를 관리');
INSERT INTO `language` VALUES (119, 'select_exam', 'select exam', 'পরীক্ষার নির্বাচন', 'seleccione examen', 'حدد الامتحان', 'selecteer examen', 'выбрать экзамен', '选择考试', 'sınavı seçin', 'selecionar exame', 'válassza ki a vizsga', 'sélectionnez examen', 'επιλέξτε εξετάσεις', 'Prüfung wählen', 'seleziona esame', 'เลือกสอบ', 'امتحان منتخب کریں', 'परीक्षा का चयन', 'velit ipsum', 'pilih ujian', '受験を選択', '시험을 선택');
INSERT INTO `language` VALUES (120, 'select_class', 'select class', 'বর্গ নির্বাচন', 'seleccione clase', 'حدد فئة', 'selecteren klasse', 'выбрать класс', '选择产品类别', 'sınıf seçin', 'selecionar classe', 'válassza osztály', 'sélectionnez classe', 'Επιλέξτε κατηγορία', 'Klasse wählen', 'seleziona classe', 'เลือกชั้น', 'کلاس منتخب کریں', 'वर्ग का चयन करें', 'genus eligere,', 'pilih kelas', 'クラスを選択', '클래스를 선택');
INSERT INTO `language` VALUES (121, 'select_subject', 'select subject', 'বিষয় নির্বাচন করুন', 'seleccione tema', 'حدد الموضوع', 'Selecteer onderwerp', 'выберите тему', '选择主题', 'konu seçin', 'selecionar assunto', 'Válassza a Tárgy', 'sélectionner le sujet', 'επιλέξτε θέμα', 'Thema wählen', 'seleziona argomento', 'เลือกเรื่อง', 'موضوع منتخب کریں', 'विषय का चयन', 'eligere subditos', 'pilih subjek', '件名を選択', '주제를 선택');
INSERT INTO `language` VALUES (122, 'select_an_exam', 'select an exam', 'একটি পরীক্ষা নির্বাচন', 'seleccione un examen', 'حدد الامتحان', 'selecteer een examen', 'выбрать экзамен', '选择考试', 'Bir sınav seçin', 'selecionar um exame', 'válasszon ki egy vizsga', 'sélectionner un examen', 'επιλέξτε μια εξέταση', 'Wählen Sie eine Prüfung', 'selezionare un esame', 'เลือกสอบ', 'امتحان منتخب کریں', 'एक परीक्षा का चयन', 'Eligebatur autem ipsum', 'pilih ujian', '受験を選択', '시험을 선택');
INSERT INTO `language` VALUES (123, 'mark_obtained', 'mark obtained', 'চিহ্নিত প্রাপ্ত', 'calificación obtenida', 'بمناسبة الحصول على', 'markeren verkregen', 'отметить получены', '获得标', 'işaretlemek elde', 'marca obtida', 'jelölje kapott', 'marquer obtenu', 'σήμα που λαμβάνεται', 'Markieren Sie erhalten', 'contrassegnare ottenuto', 'ทำเครื่องหมายที่ได้รับ', 'نشان زد حاصل', 'अंक प्राप्त', 'attende obtinuit', 'menandai diperoleh', 'マークが得', '마크 획득');
INSERT INTO `language` VALUES (124, 'attendance', 'attendance', 'উপস্থিতি', 'asistencia', 'الحضور', 'opkomst', 'посещаемость', '护理', 'katılım', 'comparecimento', 'részvétel', 'présence', 'παρουσία', 'Teilnahme', 'partecipazione', 'การดูแลรักษา', 'حاضری', 'उपस्थिति', 'auscultant', 'kehadiran', '出席', '출석');
INSERT INTO `language` VALUES (125, 'manage_grade', 'manage grade', 'গ্রেড পরিচালনা', 'gestión de calidad', 'إدارة الصف', 'beheren leerjaar', 'управлять класс', '管理级', 'notu yönetmek', 'gerenciar grau', 'kezelni fokozat', 'gérer de qualité', 'διαχείριση ποιότητας', 'Klasse verwalten', 'gestione grade', 'จัดการเกรด', 'گریڈ کا انتظام', 'ग्रेड का प्रबंधन', 'moderari gradu', 'mengelola kelas', 'グレードを管理', '등급 관리');
INSERT INTO `language` VALUES (126, 'grade_list', 'grade list', 'গ্রেড তালিকা', 'Lista de grado', 'قائمة الصف', 'cijferlijst', 'Список класса', '等级列表', 'sınıf listesi', 'lista grau', 'fokozat lista', 'liste de qualité', 'Λίστα βαθμού', 'Notenliste', 'elenco grade', 'รายการเกรด', 'گریڈ فہرست', 'ग्रेड की सूची', 'gradus album', 'daftar kelas', 'グレード一覧', '등급 목록');
INSERT INTO `language` VALUES (127, 'add_grade', 'add grade', 'গ্রেড যোগ করুন', 'añadir grado', 'إضافة الصف', 'voeg leerjaar', 'добавить класс', '添加级', 'not eklemek', 'adicionar grau', 'hozzá fokozat', 'ajouter note', 'προσθήκη βαθμού', 'Klasse hinzufügen', 'aggiungere grade', 'เพิ่มเกรด', 'گریڈ میں شامل کریں', 'ग्रेड जोड़', 'adde gradum,', 'menambahkan kelas', 'グレードを追加', '등급을 추가');
INSERT INTO `language` VALUES (128, 'grade_name', 'grade name', 'গ্রেড নাম', 'Nombre de grado', 'اسم الصف', 'rangnaam', 'Название сорта', '等级名称', 'sınıf adı', 'nome da classe', 'fokozat név', 'nom de la catégorie', 'Όνομα βαθμού', 'Klasse Name', 'nome del grado', 'ชื่อชั้น', 'گریڈ نام', 'ग्रेड का नाम', 'nomen, gradus,', 'nama kelas', 'グレード名', '등급 이름');
INSERT INTO `language` VALUES (129, 'grade_point', 'grade point', 'গ্রেড পয়েন্ট', 'de calificaciones', 'تراكمي', 'rangpunt', 'балл', '成绩', 'not', 'ponto de classe', 'fokozatú pont', 'cumulative', 'βαθμών', 'Noten', 'punto di grado', 'จุดเกรด', 'گریڈ پوائنٹ', 'ग्रेड बिंदु', 'gradus punctum', 'indeks prestasi', '成績評価点', '학점');
INSERT INTO `language` VALUES (130, 'mark_from', 'mark from', 'চিহ্ন থেকে', 'marca de', 'علامة من', 'mark uit', 'знак от', '从商标', 'mark dan', 'marca de', 'jelölést', 'marque de', 'σήμα από', 'Marke aus', 'segno da', 'เครื่องหมายจาก', 'نشان سے', 'मार्क से', 'marcam', 'mark dari', 'マークから', '표에서');
INSERT INTO `language` VALUES (131, 'mark_upto', 'mark upto', 'পর্যন্ত চিহ্নিত', 'marcar hasta', 'بمناسبة تصل', 'mark tot', 'отметить ДО', '高达标记', 'kadar işaretlemek', 'marcar até', 'jelölje upto', 'marquer jusqu\'à', 'σήμα μέχρι', 'Markieren Sie bis zu', 'contrassegnare fino a', 'ทำเครื่องหมายเกิน', 'تک کے موقع', 'तक चिह्नित', 'Genitus est notare', 'menandai upto', '点で最大マーク', '표까지');
INSERT INTO `language` VALUES (132, 'edit_grade', 'edit grade', 'সম্পাদনা গ্রেড', 'edit grado', 'تحرير الصف', 'Cijfer bewerken', 'править класса', '编辑等级', 'edit notu', 'edição grau', 'szerkesztés fokozat', 'edit qualité', 'edit βαθμού', 'edit Grad', 'modifica grade', 'แก้ไขเกรด', 'ترمیم گریڈ', 'संपादित ग्रेड', 'edit gradu', 'mengedit kelas', '編集グレード', '편집 등급');
INSERT INTO `language` VALUES (133, 'manage_class_routine', 'manage class routine', 'ক্লাসের রুটিন পরিচালনা', 'gestionar rutina de la clase', 'إدارة الطبقة الروتينية', 'beheren klasroutine', 'управлять рутину класса', '管理类常规', 'sınıf rutin yönetmek', 'gerenciar rotina classe', 'kezelni class rutin', 'gérer la routine de classe', 'διαχειρίζονται τάξη ρουτίνα', 'verwalten Klasse Routine', 'gestione classe di routine', 'การจัดการชั้นเรียนตามปกติ', 'کلاس معمول کا انتظام', 'वर्ग दिनचर्या का प्रबंधन', 'uno in genere tractare', 'mengelola rutinitas kelas', 'クラスルーチンを管理', '수준의 일상적인 관리');
INSERT INTO `language` VALUES (134, 'class_routine_list', 'class routine list', 'ক্লাসের রুটিন তালিকা', 'clase de lista de rutina', 'قائمة الروتينية الطبقة', 'klasroutine lijst', 'класс рутина список', '班级常规列表', 'sınıf rutin listesi', 'classe de lista de rotina', 'osztály rutin lista', 'classe liste routine', 'κλάση list ρουτίνας', 'Klasse Routine Liste', 'classe lista di routine', 'รายการประจำชั้น', 'کلاس معمول کے مطابق فہرست', 'वर्ग दिनचर्या सूची', 'uno genere album', 'Daftar rutin kelas', 'クラスルーチン一覧', '클래스 루틴 목록');
INSERT INTO `language` VALUES (135, 'add_class_routine', 'add class routine', 'ক্লাসের রুটিন যুক্ত', 'añadir rutina de la clase', 'إضافة فئة الروتينية', 'voeg klasroutine', 'добавить подпрограмму класса', '添加类常规', 'sınıf rutin eklemek', 'adicionar rotina classe', 'hozzá class rutin', 'ajouter routine de classe', 'προσθέσετε τάξη ρουτίνα', 'Klasse hinzufügen Routine', 'aggiungere classe di routine', 'เพิ่มระดับตามปกติ', 'کلاس معمول میں شامل کریں', 'वर्ग दिनचर्या जोड़', 'adde genus moris', 'menambahkan rutin kelas', 'クラス·ルーチンを追加', '클래스 루틴을 추가');
INSERT INTO `language` VALUES (136, 'day', 'day', 'দিন', 'día', 'يوم', 'dag', 'день', '日', 'gün', 'dia', 'nap', 'jour', 'ημέρα', 'Tag', 'giorno', 'วัน', 'دن', 'दिन', 'die,', 'hari', '日', '일');
INSERT INTO `language` VALUES (137, 'starting_time', 'starting time', 'সময়ের শুরু', 'tiempo de inicio', 'بدءا الوقت', 'starttijd', 'время начала', '开始时间', 'başlangıç ​​zamanı', 'tempo começando', 'indítási idő', 'temps de démarrage', 'ώρα έναρξης', 'Startzeit', 'tempo di avviamento', 'เวลาเริ่มต้น', 'وقت شروع ہونے', 'समय की शुरुआत के', 'tum satus', 'waktu mulai', '起動時間', '시작 시간');
INSERT INTO `language` VALUES (138, 'ending_time', 'ending time', 'সময় শেষ', 'hora de finalización', 'تنتهي الساعة', 'eindtijd', 'время окончания', '结束时间', 'bitiş zamanını', 'tempo final', 'befejezési időpont', 'heure de fin', 'ώρα λήξης', 'Endzeit', 'ora finale', 'สิ้นสุดเวลา', 'وقت ختم', 'समय समाप्त होने के', 'et finis temporis,', 'akhir waktu', '終了時刻', '종료 시간');
INSERT INTO `language` VALUES (139, 'edit_class_routine', 'edit class routine', 'সম্পাদনা ক্লাস রুটিন', 'rutina de la clase de edición', 'الطبقة تحرير الروتينية', 'bewerk klasroutine', 'Процедура редактирования класс', '编辑类常规', 'sınıf düzenle rutin', 'rotina de edição de classe', 'szerkesztés osztály rutin', 'routine modifier de classe', 'edit τάξη ρουτίνα', 'edit Klasse Routine', 'modifica della classe di routine', 'แก้ไขชั้นเรียนตามปกติ', 'ترمیم کلاس معمول', 'संपादित वर्ग दिनचर्या', 'edit uno genere', 'rutin mengedit kelas', '編集クラスのルーチン', '편집 클래스 루틴');
INSERT INTO `language` VALUES (140, 'manage_invoice/payment', 'manage invoice/payment', 'চালান / পেমেন্ট পরিচালনা', 'gestionar factura / pago', 'إدارة فاتورة / دفع', 'beheren factuur / betaling', 'управлять счета / оплата', '管理发票/付款', 'fatura / ödeme yönetmek', 'gerenciar fatura / pagamento', 'kezelni számla / fizetési', 'gérer facture / paiement', 'διαχείριση τιμολογίου / πληρωμής', 'Verwaltung Rechnung / Zahlung', 'gestione fattura / pagamento', 'จัดการใบแจ้งหนี้ / การชำระเงิน', 'انوائس / ادائیگی کا انتظام', 'चालान / भुगतान का प्रबंधन', 'curo cautionem / solutionem', 'mengelola tagihan / pembayaran', '請求書/支払管理', '인보이스 / 결제 관리');
INSERT INTO `language` VALUES (141, 'invoice/payment_list', 'invoice/payment list', 'চালান / পেমেন্ট তালিকা', 'lista de facturas / pagos', 'قائمة فاتورة / دفع', 'factuur / betaling lijst', 'Список счета / оплата', '发票/付款清单', 'fatura / ödeme listesi', 'lista de fatura / pagamento', 'számla / fizetési lista', 'liste facture / paiement', 'Λίστα τιμολογίου / πληρωμής', 'Rechnung / Zahlungsliste', 'elenco fattura / pagamento', 'รายการใบแจ้งหนี้ / การชำระเงิน', 'انوائس / ادائیگی کی فہرست', 'चालान / भुगतान सूची', 'cautionem / list pretium', 'daftar tagihan / pembayaran', '請求書/支払一覧', '인보이스 / 결제리스트');
INSERT INTO `language` VALUES (142, 'add_invoice/payment', 'add invoice/payment', 'চালান / পেমেন্ট যোগ', 'añadir factura / pago', 'إضافة فاتورة / دفع', 'voeg factuur / betaling', 'добавить счета / оплата', '添加发票/付款', 'fatura / ödeme eklemek', 'adicionar factura / pagamento', 'hozzá számla / fizetési', 'ajouter facture / paiement', 'προσθήκη τιμολογίου / πληρωμής', 'hinzufügen Rechnung / Zahlung', 'aggiungere fatturazione / pagamento', 'เพิ่มใบแจ้งหนี้ / การชำระเงิน', 'انوائس / ادائیگی شامل', 'चालान / भुगतान जोड़ें', 'add cautionem / solutionem', 'menambahkan tagihan / pembayaran', '請求書/支払を追加', '송장 / 지불을 추가');
INSERT INTO `language` VALUES (143, 'title', 'title', 'খেতাব', 'título', 'لقب', 'titel', 'название', '标题', 'başlık', 'título', 'cím', 'titre', 'τίτλος', 'Titel', 'titolo', 'ชื่อเรื่อง', 'عنوان', 'शीर्षक', 'title', 'judul', 'タイトル', '표제');
INSERT INTO `language` VALUES (144, 'description', 'description', 'বিবরণ', 'descripción', 'وصف', 'beschrijving', 'описание', '描述', 'tanım', 'descrição', 'leírás', 'description', 'περιγραφή', 'Beschreibung', 'descrizione', 'ลักษณะ', 'تفصیل', 'विवरण', 'description', 'deskripsi', '説明', '기술');
INSERT INTO `language` VALUES (145, 'amount', 'amount', 'পরিমাণ', 'cantidad', 'مبلغ', 'bedrag', 'количество', '量', 'miktar', 'quantidade', 'mennyiség', 'montant', 'ποσό', 'Menge', 'importo', 'จำนวน', 'رقم', 'राशि', 'tantum', 'jumlah', '額', '양');
INSERT INTO `language` VALUES (146, 'status', 'status', 'অবস্থা', 'estado', 'حالة', 'toestand', 'статус', '状态', 'durum', 'estado', 'állapot', 'statut', 'κατάσταση', 'Status', 'stato', 'สถานะ', 'درجہ', 'हैसियत', 'status', 'status', 'ステータス', '지위');
INSERT INTO `language` VALUES (147, 'view_invoice', 'view invoice', 'দেখুন চালান', 'vista de la factura', 'عرض الفاتورة', 'view factuur', 'вид счета-фактуры', '查看发票', 'view fatura', 'vista da fatura', 'view számla', 'vue facture', 'προβολή τιμολόγιο', 'Ansicht Rechnung', 'vista fattura', 'ดูใบแจ้งหนี้', 'دیکھیں انوائس', 'देखें चालान', 'propter cautionem', 'lihat faktur', 'ビュー請求書', '보기 송장');
INSERT INTO `language` VALUES (148, 'paid', 'paid', 'পরিশোধ', 'pagado', 'مدفوع', 'betaald', 'оплаченный', '支付', 'ücretli', 'pago', 'fizetett', 'payé', 'καταβληθεί', 'bezahlt', 'pagato', 'ต้องจ่าย', 'ادا کیا', 'प्रदत्त', 'solutis', 'dibayar', '支払われた', '지급');
INSERT INTO `language` VALUES (149, 'unpaid', 'unpaid', 'অবৈতনিক', 'no pagado', 'غير مدفوع', 'onbetaald', 'неоплаченный', '未付', 'ödenmemiş', 'não remunerado', 'kifizetetlen', 'non rémunéré', 'απλήρωτη', 'unbezahlt', 'non pagato', 'ยังไม่ได้ชำระ', 'بلا معاوضہ', 'अवैतनिक', 'non est constitutus,', 'dibayar', '未払い', '지불하지 않은');
INSERT INTO `language` VALUES (150, 'add_invoice', 'add invoice', 'চালান যোগ', 'añadir factura', 'إضافة الفاتورة', 'voeg factuur', 'добавить счет', '添加发票', 'faturayı eklemek', 'adicionar fatura', 'hozzá számla', 'ajouter facture', 'προσθέστε τιμολόγιο', 'Rechnung hinzufügen', 'aggiungere fattura', 'เพิ่มใบแจ้งหนี้', 'انوائس میں شامل', 'चालान जोड़', 'add cautionem', 'menambahkan faktur', '請求書を追加', '송장을 추가');
INSERT INTO `language` VALUES (151, 'payment_to', 'payment to', 'পেমেন্ট', 'pago a', 'دفع ل', 'betaling aan', 'оплата', '支付', 'için ödeme', 'pagamento', 'fizetés', 'paiement', 'πληρωμή', 'Zahlung an', 'pagamento', 'ชำระเงินให้กับ', 'ادائیگی', 'को भुगतान', 'pecunia', 'pembayaran kepada', 'への支払い', '에 지불');
INSERT INTO `language` VALUES (152, 'bill_to', 'bill to', 'বিল', 'proyecto de ley para', 'مشروع قانون ل', 'wetsvoorstel om', 'Законопроект о', '法案', 'bill', 'projeto de lei para', 'törvényjavaslat', 'projet de loi', 'νομοσχέδιο για την', 'Gesetzentwurf zur', 'disegno di legge per', 'บิล', 'بل', 'बिल के लिए', 'latumque', 'RUU untuk', '請求する', '법안');
INSERT INTO `language` VALUES (153, 'invoice_title', 'invoice title', 'চালান শিরোনাম', 'Título de la factura', 'عنوان الفاتورة', 'factuur titel', 'Название счета', '发票抬头', 'fatura başlık', 'título fatura', 'számla cím', 'titre de la facture', 'Τίτλος τιμολόγιο', 'Rechnungs Titel', 'title fattura', 'ชื่อใบแจ้งหนี้', 'انوائس عنوان', 'चालान शीर्षक', 'title cautionem', 'judul faktur', '請求書のタイトル', '송장 제목');
INSERT INTO `language` VALUES (154, 'invoice_id', 'invoice id', 'চালান আইডি', 'Identificación de la factura', 'فاتورة معرف', 'factuur id', 'счет-фактура ID', '发票编号', 'fatura id', 'id fatura', 'számla id', 'Identifiant facture', 'id τιμολόγιο', 'Rechnung-ID', 'fattura id', 'ใบแจ้งหนี้หมายเลข', 'انوائس ID', 'चालान आईडी', 'id cautionem', 'faktur id', '請求書ID', '송장 ID');
INSERT INTO `language` VALUES (155, 'edit_invoice', 'edit invoice', 'সম্পাদনা চালান', 'edit factura', 'تحرير الفاتورة', 'bewerk factuur', 'редактирования счета-фактуры', '编辑发票', 'edit fatura', 'edição fatura', 'szerkesztés számla', 'modifier la facture', 'edit τιμολόγιο', 'edit Rechnung', 'modifica fattura', 'แก้ไขใบแจ้งหนี้', 'ترمیم انوائس', 'संपादित चालान', 'edit cautionem', 'mengedit faktur', '編集送り状', '편집 송장');
INSERT INTO `language` VALUES (156, 'manage_library_books', 'manage library books', 'লাইব্রেরির বই ও পরিচালনা', 'gestionar libros de la biblioteca', 'إدارة مكتبة الكتب', 'beheren bibliotheekboeken', 'управлять библиотечные книги', '管理图书', 'kitapları kütüphane yönetmek', 'gerenciar os livros da biblioteca', 'kezelni könyvtári könyvek', 'gérer des livres de bibliothèque', 'διαχειριστείτε τα βιβλία της βιβλιοθήκης', 'Bücher aus der Bibliothek verwalten', 'gestire i libri della biblioteca', 'จัดการหนั​​งสือห้องสมุด', 'کتب خانے کی کتابیں منظم', 'पुस्तकालय की पुस्तकों का प्रबंधन', 'curo bibliotheca librorum,', 'mengelola buku perpustakaan', '図書館の本を管理', '도서관 책 관리');
INSERT INTO `language` VALUES (157, 'book_list', 'book list', 'পাঠ্যতালিকা', 'lista de libros', 'قائمة الكتب', 'boekenlijst', 'Список книг', '书单', 'kitap listesi', 'lista de livros', 'book lista', 'liste de livres', 'λίστα βιβλίων', 'Buchliste', 'elenco libri', 'รายการหนั​​งสือ', 'کتاب کی فہرست', 'पुस्तक सूची', 'album', 'daftar buku', 'ブックリスト', '도서 목록');
INSERT INTO `language` VALUES (158, 'add_book', 'add book', 'বই যোগ', 'Añadir libro', 'إضافة كتاب', 'boek toevoegen', 'добавить книгу', '加入书', 'kitap eklemek', 'adicionar livro', 'Könyv hozzáadása', 'ajouter livre', 'προσθέστε το βιβλίο', 'Buch hinzufügen', 'aggiungere il libro', 'เพิ่มหนังสือ', 'کتاب شامل', 'पुस्तक जोड़', 'adde libri', 'menambahkan buku', '本を追加', '책을 추가');
INSERT INTO `language` VALUES (159, 'book_name', 'book name', 'বইয়ের নাম', 'Nombre del libro', 'اسم الكتاب', 'boeknaam', 'Название книги', '书名', 'kitap adı', 'nome livro', 'book név', 'nom de livre', 'το όνομα του βιβλίου', 'Buchnamen', 'nome del libro', 'ชื่อหนังสือ', 'کتاب کا نام', 'किताब का नाम', 'librum nomine', 'nama buku', 'ブック名', '책 이름');
INSERT INTO `language` VALUES (160, 'author', 'author', 'লেখক', 'autor', 'الكاتب', 'auteur', 'автор', '作者', 'yazar', 'autor', 'szerző', 'auteur', 'συγγραφέας', 'Autor', 'autore', 'ผู้เขียน', 'مصنف', 'लेखक', 'auctor', 'penulis', '著者', '저자');
INSERT INTO `language` VALUES (161, 'price', 'price', 'দাম', 'precio', 'السعر', 'prijs', 'цена', '价格', 'fiyat', 'preço', 'ár', 'prix', 'τιμή', 'Preis', 'prezzo', 'ราคา', 'قیمت', 'कीमत', 'price', 'harga', '価格', '가격');
INSERT INTO `language` VALUES (162, 'available', 'available', 'উপলব্ধ', 'disponible', 'متاح', 'beschikbaar', 'доступный', '可用的', 'mevcut', 'disponível', 'rendelkezésre álló', 'disponible', 'διαθέσιμος', 'verfügbar', 'disponibile', 'สามารถใช้ได้', 'دستیاب', 'उपलब्ध', 'available', 'tersedia', '利用できる', '유효한');
INSERT INTO `language` VALUES (163, 'unavailable', 'unavailable', 'অপ্রাপ্য', 'indisponible', 'غير متاح', 'niet beschikbaar', 'недоступен', '不可用', 'yok', 'indisponível', 'érhető el', 'indisponible', 'διαθέσιμο', 'nicht verfügbar', 'non disponibile', 'ไม่มี', 'دستیاب نہیں', 'अनुपलब्ध', 'unavailable', 'tidak tersedia', '利用できない', '없는');
INSERT INTO `language` VALUES (164, 'edit_book', 'edit book', 'সম্পাদনা বই', 'libro de edición', 'كتاب تحرير', 'bewerk boek', 'править книга', '编辑本书', 'edit kitap', 'edição do livro', 'edit könyv', 'edit livre', 'επεξεργαστείτε το βιβλίο', 'edit Buch', 'modifica book', 'แก้ไขหนังสือ', 'ترمیم کتاب', 'संपादित पुस्तक', 'edit Liber', 'mengedit buku', '編集の本', '편집 책');
INSERT INTO `language` VALUES (165, 'manage_transport', 'manage transport', 'পরিবহন ও পরিচালনা', 'gestionar el transporte', 'إدارة النقل', 'beheren van vervoerssystemen', 'управлять транспортом', '运输管理', 'ulaşım yönetmek', 'gerenciar o transporte', 'kezelni a közlekedés', 'la gestion du transport', 'διαχείριση των μεταφορών', 'Transport verwalten', 'gestire i trasporti', 'การจัดการการขนส่ง', 'نقل و حمل کے انتظام', 'परिवहन का प्रबंधन', 'curo onerariis', 'mengelola transportasi', '輸送を管理', '교통 관리');
INSERT INTO `language` VALUES (166, 'transport_list', 'transport list', 'পরিবহন তালিকা', 'Lista de transportes', 'قائمة النقل', 'lijst vervoer', 'лист транспорт', '运输名单', 'taşıma listesi', 'Lista de transportes', 'szállítás lista', 'liste de transport', 'Λίστα των μεταφορών', 'Transportliste', 'elenco trasporti', 'รายการการขนส่ง', 'نقل و حمل کی فہرست', 'परिवहन सूची', 'turpis album', 'daftar transport', '輸送一覧', '전송 목록');
INSERT INTO `language` VALUES (167, 'add_transport', 'add transport', 'পরিবহন যোগ করুন', 'añadir el transporte', 'إضافة النقل', 'voeg vervoer', 'добавить транспорт', '加上运输', 'taşıma ekle', 'adicionar transporte', 'hozzá a közlekedés', 'ajouter transports', 'προσθέστε μεταφορών', 'add-Transport', 'aggiungere il trasporto', 'เพิ่มการขนส่ง', 'نقل و حمل شامل', 'परिवहन जोड़', 'adde onerariis', 'tambahkan transportasi', 'トランスポートを追加', '전송을 추가');
INSERT INTO `language` VALUES (168, 'route_name', 'route name', 'রুট নাম', 'nombre de la ruta', 'اسم توجيه', 'naam van de route', 'Имя маршрут', '路由名称', 'rota ismi', 'nome da rota', 'útvonal nevét', 'nom de la route', 'Όνομα διαδρομής', 'Routennamen', 'nome del percorso', 'ชื่อเส้นทาง', 'راستے نام', 'मार्ग का नाम', 'iter nomine', 'Nama rute', 'ルートの名前', '경로 이름');
INSERT INTO `language` VALUES (169, 'number_of_vehicle', 'number of vehicle', 'গাড়ীর সংখ্যা', 'número de vehículo', 'عدد من المركبات', 'aantal voertuigkilometers', 'количество автомобиля', '车辆的数量', 'Aracın sayısı', 'número de veículo', 'számú gépjármű', 'nombre de véhicules', 'αριθμός των οχημάτων', 'Anzahl der Fahrzeug', 'numero di veicolo', 'จำนวนของยานพาหนะ', 'گاڑی کی تعداد', 'वाहन की संख्या', 'de numero scilicet vehiculum', 'jumlah kendaraan', '車両の数', '차량의 수');
INSERT INTO `language` VALUES (170, 'route_fare', 'route fare', 'রুট করবেন', 'ruta hacer', 'المسار تفعل', 'route doen', 'маршрут делать', '路线做', 'yol yapmak', 'rota fazer', 'útvonal do', 'itinéraire faire', 'διαδρομή κάνει', 'Route zu tun', 'r', 'เส้นทางทำ', 'راستے کرتے', 'मार्ग करना', 'iter faciunt,', 'rute lakukan', 'ルートか', '경로는 할');
INSERT INTO `language` VALUES (171, 'edit_transport', 'edit transport', 'সম্পাদনা পরিবহন', 'transporte de edición', 'النقل تحرير', 'vervoer bewerken', 'править транспорт', '编辑运输', 'edit ulaşım', 'edição transporte', 'szerkesztés szállítás', 'transport modifier', 'edit μεταφορών', 'edit Transport', 'modifica dei trasporti', 'แก้ไขการขนส่ง', 'ترمیم نقل و حمل', 'संपादित परिवहन', 'edit onerariis', 'mengedit transportasi', '編集輸送', '편집 전송');
INSERT INTO `language` VALUES (172, 'manage_dormitory', 'manage dormitory', 'আস্তানা ও পরিচালনা', 'gestionar dormitorio', 'إدارة مهجع', 'beheren slaapzaal', 'управлять общежитие', '宿舍管理', 'yurt yönetmek', 'gerenciar dormitório', 'kezelni kollégiumi', 'gérer dortoir', 'διαχείριση κοιτώνα', 'Schlafsaal verwalten', 'gestione dormitorio', 'จัดการหอพัก', 'شیناگار کا انتظام', 'छात्रावास का प्रबंधन', 'curo dormitorio', 'mengelola asrama', '寮を管理', '기숙사를 관리');
INSERT INTO `language` VALUES (173, 'dormitory_list', 'dormitory list', 'আস্তানা তালিকা', 'lista dormitorio', 'قائمة مهجع', 'slaapzaal lijst', 'Список общежитие', '宿舍名单', 'yurt listesi', 'lista dormitório', 'kollégiumi lista', 'liste de dortoir', 'Λίστα κοιτώνα', 'Schlafsaal Liste', 'elenco dormitorio', 'รายชื่อหอพัก', 'شیناگار فہرست', 'छात्रावास सूची', 'dormitorium album', 'daftar asrama', '寮のリスト', '기숙사 목록');
INSERT INTO `language` VALUES (174, 'add_dormitory', 'add dormitory', 'আস্তানা যোগ', 'añadir dormitorio', 'إضافة مهجع', 'voeg slaapzaal', 'добавить общежитие', '添加宿舍', 'yurt ekle', 'adicionar dormitório', 'hozzá kollégiumi', 'ajouter dortoir', 'προσθήκη κοιτώνα', 'Schlaf hinzufügen', 'aggiungere dormitorio', 'เพิ่มหอพัก', 'شیناگار شامل', 'छात्रावास जोड़', 'adde dormitorio', 'menambahkan asrama', '寮を追加', '기숙사를 추가');
INSERT INTO `language` VALUES (175, 'dormitory_name', 'dormitory name', 'আস্তানা নাম', 'Nombre del dormitorio', 'اسم المهجع', 'slaapzaal naam', 'Имя общежитие', '宿舍名', 'yurt adı', 'nome dormitório', 'kollégiumi név', 'nom de dortoir', 'Όνομα κοιτώνα', 'Schlaf Namen', 'Nome dormitorio', 'ชื่อหอพัก', 'شیناگار نام', 'छात्रावास नाम', 'dormitorium nomine', 'Nama asrama', '寮名', '기숙사 이름');
INSERT INTO `language` VALUES (176, 'number_of_room', 'number of room', 'ঘরের সংখ্যা', 'número de habitación', 'عدد الغرف', 'aantal kamer', 'число комнате', '房间数量', 'oda sayısı', 'número de quarto', 'száma szobában', 'nombre de salle', 'τον αριθμό των δωματίων', 'Anzahl der Zimmer', 'numero delle camera', 'จำนวนห้องพัก', 'کمرے کی تعداد', 'कमरे की संख्या', 'numerus locus', 'Jumlah kamar', 'お部屋数', '객실 수');
INSERT INTO `language` VALUES (177, 'manage_noticeboard', 'manage noticeboard', 'নোটিশবোর্ড পরিচালনা', 'gestionar tablón de anuncios', 'إدارة اللافتة', 'beheren prikbord', 'управлять доске объявлений', '管理布告', 'Noticeboard yönetmek', 'gerenciar avisos', 'kezelni üzenőfalán', 'gérer panneau d\'affichage', 'διαχείριση ανακοινώσεων', 'Brett verwalten', 'gestione bacheca', 'จัดการป้ายประกาศ', 'noticeboard کا انتظام', 'Noticeboard का प्रबंधन', 'curo noticeboard', 'mengelola pengumuman', '伝言板を管理', '의 noticeboard 관리');
INSERT INTO `language` VALUES (178, 'noticeboard_list', 'noticeboard list', 'নোটিশবোর্ড তালিকা', 'tablón de anuncios de la lista', 'قائمة اللافتة', 'prikbord lijst', 'Список доска для объявлений', '布告名单', 'noticeboard listesi', 'lista de avisos', 'üzenőfalán lista', 'liste de panneau d\'affichage', 'λίστα ανακοινώσεων', 'Brett-Liste', 'elenco bacheca', 'รายการป้ายประกาศ', 'noticeboard فہرست', 'Noticeboard सूची', 'noticeboard album', 'daftar pengumuman', '伝言板一覧', '의 noticeboard 목록');
INSERT INTO `language` VALUES (179, 'add_noticeboard', 'add noticeboard', 'নোটিশবোর্ড যোগ', 'añadir tablón de anuncios', 'إضافة اللافتة', 'voeg prikbord', 'добавить доске объявлений', '添加布告', 'Noticeboard ekle', 'adicionar avisos', 'hozzá üzenőfalán', 'ajouter panneau d\'affichage', 'προσθήκη ανακοινώσεων', 'Brett hinzufügen', 'aggiungere bacheca', 'เพิ่มป้ายประกาศ', 'noticeboard شامل', 'Noticeboard जोड़', 'adde noticeboard', 'menambahkan pengumuman', '伝言板を追加', '의 noticeboard 추가');
INSERT INTO `language` VALUES (180, 'notice', 'notice', 'বিজ্ঞপ্তি', 'aviso', 'إشعار', 'kennisgeving', 'уведомление', '通知', 'uyarı', 'aviso', 'értesítés', 'délai', 'ειδοποίηση', 'Bekanntmachung', 'avviso', 'แจ้งให้ทราบ', 'نوٹس', 'नोटिस', 'Observa', 'pemberitahuan', '予告', '통지');
INSERT INTO `language` VALUES (181, 'add_notice', 'add notice', 'নোটিশ যোগ করুন', 'añadir aviso', 'إضافة إشعار', 'voeg bericht', 'добавить уведомление', '添加通知', 'haber ekle', 'adicionar aviso', 'hozzá értesítés', 'ajouter un avis', 'προσθέστε ανακοίνωση', 'Hinweis hinzufügen', 'aggiungere preavviso', 'เพิ่มแจ้งให้ทราบล่วงหน้า', 'نوٹس کا اضافہ کریں', 'नोटिस जोड़', 'addunt et titulum', 'tambahkan pemberitahuan', '通知を追加', '통지를 추가');
INSERT INTO `language` VALUES (182, 'edit_noticeboard', 'edit noticeboard', 'সম্পাদনা নোটিশবোর্ড', 'edit tablón de anuncios', 'تحرير اللافتة', 'bewerk prikbord', 'править доска для объявлений', '编辑布告', 'edit noticeboard', 'edição de avisos', 'szerkesztés üzenőfalán', 'modifier panneau d\'affichage', 'edit ανακοινώσεων', 'Brett bearbeiten', 'modifica bacheca', 'แก้ไขป้ายประกาศ', 'میں ترمیم کریں noticeboard', 'संपादित Noticeboard', 'edit noticeboard', 'mengedit pengumuman', '編集伝言板', '편집의 noticeboard');
INSERT INTO `language` VALUES (183, 'system_name', 'system name', 'সিস্টেমের নাম', 'Nombre del sistema', 'اسم النظام', 'Name System', 'Имя системы', '系统名称', 'sistemi adı', 'nome do sistema', 'rendszer neve', 'nom du système', 'όνομα του συστήματος', 'Systemnamen', 'nome del sistema', 'ชื่อระบบ', 'نظام کا نام', 'सिस्टम नाम', 'ratio nominis', 'Nama sistem', 'システム名', '시스템 이름');
INSERT INTO `language` VALUES (184, 'save', 'save', 'রক্ষা', 'guardar', 'حفظ', 'besparen', 'экономить', '节省', 'kurtarmak', 'salvar', 'kivéve', 'sauver', 'εκτός', 'sparen', 'salvare', 'ประหยัด', 'کو بچانے کے', 'बचाना', 'salvum', 'menyimpan', '保存', '저장');
INSERT INTO `language` VALUES (185, 'system_title', 'system title', 'সিস্টেম শিরোনাম', 'Título de sistema', 'عنوان النظام', 'systeem titel', 'Название системы', '系统标题', 'Sistem başlık', 'título sistema', 'rendszer cím', 'titre du système', 'Τίτλος του συστήματος', 'System-Titel', 'titolo di sistema', 'ชื่อระบบ', 'نظام عنوان', 'सिस्टम शीर्षक', 'ratio title', 'title sistem', 'システムのタイトル', '시스템 제목');
INSERT INTO `language` VALUES (186, 'paypal_email', 'paypal email', 'PayPal ইমেইল', 'paypal email', 'باي بال البريد الإلكتروني', 'paypal e-mail', 'PayPal по электронной почте', 'PayPal电子邮件', 'paypal e-posta', 'paypal e-mail', 'paypal email', 'paypal email', 'paypal ηλεκτρονικό ταχυδρομείο', 'paypal E-Mail', 'paypal-mail', 'paypal อีเมล์', 'پے پال ای میل', 'पेपैल ईमेल', 'Paypal email', 'email paypal', 'Paypalのメール', '페이팔 이메일');
INSERT INTO `language` VALUES (187, 'currency', 'currency', 'মুদ্রা', 'moneda', 'عملة', 'valuta', 'валюта', '货币', 'para', 'moeda', 'valuta', 'monnaie', 'νόμισμα', 'Währung', 'valuta', 'เงินตรา', 'کرنسی', 'मुद्रा', 'currency', 'mata uang', '通貨', '통화');
INSERT INTO `language` VALUES (188, 'phrase_list', 'phrase list', 'ফ্রেজ তালিকা', 'lista de frases', 'قائمة جملة', 'zinnenlijst', 'Список фраза', '短语列表', 'ifade listesi', 'lista de frases', 'kifejezés lista', 'liste de phrase', 'Λίστα φράση', 'Phrasenliste', 'elenco frasi', 'รายการวลี', 'جملہ فہرست', 'वाक्यांश सूची', 'dicitur album', 'Daftar frase', 'フレーズリスト', '문구 목록');
INSERT INTO `language` VALUES (189, 'add_phrase', 'add phrase', 'শব্দগুচ্ছ যুক্ত', 'añadir la frase', 'إضافة عبارة', 'voeg zin', 'добавить фразу', '添加词组', 'ifade eklemek', 'adicionar frase', 'adjunk kifejezést', 'ajouter la phrase', 'προσθέστε φράση', 'Begriff hinzufügen', 'aggiungere la frase', 'เพิ่มวลี', 'جملہ شامل', 'वाक्यांश जोड़ना', 'addere phrase', 'menambahkan frase', 'フレーズを追加', '문구를 추가');
INSERT INTO `language` VALUES (190, 'add_language', 'add language', 'ভাষা যুক্ত', 'añadir idioma', 'إضافة لغة', 'add taal', 'добавить язык', '新增语言', 'dil ekle', 'adicionar língua', 'nyelv hozzáadása', 'ajouter la langue', 'προσθέστε γλώσσα', 'Sprache hinzufügen', 'aggiungere la lingua', 'เพิ่มภาษา', 'زبان کو شامل', 'भाषा जोड़ना', 'addere verbis', 'menambahkan bahasa', '言語を追加', '언어를 추가');
INSERT INTO `language` VALUES (191, 'phrase', 'phrase', 'বাক্য', 'frase', 'العبارة', 'frase', 'фраза', '短语', 'ifade', 'frase', 'kifejezés', 'phrase', 'φράση', 'Ausdruck', 'frase', 'วลี', 'جملہ', 'वाक्यांश', 'phrase', 'frasa', 'フレーズ', '구');
INSERT INTO `language` VALUES (192, 'manage_backup_restore', 'manage backup restore', 'ব্যাকআপ পুনঃস্থাপন ও পরিচালনা', 'gestionar copias de seguridad a restaurar', 'إدارة استعادة النسخ الاحتياطي', 'beheer van back-up herstellen', 'управлять восстановить резервного копирования', '管理备份恢复', 'yedekleme geri yönetmek', 'gerenciar o backup de restauração', 'kezelni a biztonsági mentés visszaállítása', 'gérer de restauration de sauvegarde', 'διαχείριση επαναφοράς αντιγράφων ασφαλείας', 'verwalten Backup wiederherstellen', 'gestire il ripristino di backup', 'จัดการการสำรองข้อมูลเรียกคืน', 'بیک اپ بحال انتظام', 'बैकअप बहाल का प्रबंधन', 'curo tergum restituunt', 'mengelola backup restore', 'バックアップ、リストアを管理', '백업 복원 관리');
INSERT INTO `language` VALUES (193, 'restore', 'restore', 'প্রত্যর্পণ করা', 'restaurar', 'استعادة', 'herstellen', 'восстановление', '恢复', 'geri', 'restaurar', 'visszaad', 'restaurer', 'επαναφέρετε', 'wiederherstellen', 'ripristinare', 'ฟื้นฟู', 'بحال', 'बहाल', 'reddite', 'mengembalikan', '復元する', '복원');
INSERT INTO `language` VALUES (194, 'mark', 'mark', 'ছাপ', 'marca', 'علامة', 'mark', 'знак', '标志', 'işaret', 'marca', 'jel', 'marque', 'σημάδι', 'Marke', 'marchio', 'เครื่องหมาย', 'نشان', 'निशान', 'Marcus', 'tanda', 'マーク', '표');
INSERT INTO `language` VALUES (195, 'grade', 'grade', 'গ্রেড', 'grado', 'درجة', 'graad', 'класс', '等级', 'sınıf', 'grau', 'fokozat', 'grade', 'βαθμός', 'Klasse', 'grado', 'เกรด', 'گریڈ', 'ग्रेड', 'gradus,', 'kelas', 'グレード', '학년');
INSERT INTO `language` VALUES (196, 'invoice', 'invoice', 'চালান', 'factura', 'فاتورة', 'factuur', 'счет-фактура', '发票', 'fatura', 'fatura', 'számla', 'facture', 'τιμολόγιο', 'Rechnung', 'fattura', 'ใบกำกับสินค้า', 'انوائس', 'बीजक', 'cautionem', 'faktur', 'インボイス', '송장');
INSERT INTO `language` VALUES (197, 'book', 'book', 'বই', 'libro', 'كتاب', 'boek', 'книга', '书', 'kitap', 'livro', 'könyv', 'livre', 'βιβλίο', 'Buch', 'libro', 'หนังสือ', 'کتاب', 'किताब', 'Liber', 'buku', '本', '책');
INSERT INTO `language` VALUES (198, 'all', 'all', 'সব', 'todo', 'كل', 'alle', 'все', '所有', 'tüm', 'tudo', 'minden', 'tout', 'όλα', 'alle', 'tutto', 'ทั้งหมด', 'تمام', 'सब', 'omnes', 'semua', 'すべて', '모든');
INSERT INTO `language` VALUES (199, 'upload_&_restore_from_backup', 'upload & restore from backup', 'আপলোড &amp; ব্যাকআপ থেকে পুনঃস্থাপন', 'cargar y restaurar copia de seguridad', 'تحميل واستعادة من النسخة الاحتياطية', 'uploaden en terugzetten van een backup', 'загрузить и восстановить из резервной копии', '上传及从备份中恢复', 'yükleyebilir ve yedekten geri yükleme', 'fazer upload e restauração de backup', 'feltölteni és visszaállítani backup', 'télécharger et restauration de la sauvegarde', 'ανεβάσετε και επαναφορά από backup', 'Upload &amp; Wiederherstellung von Backups', 'caricare e ripristinare dal backup', 'อัปโหลดและเรียกคืนจากการสำรองข้อมูล', 'اپ لوڈ کریں اور بیک اپ سے بحال', 'अपलोड और बैकअप से बहाल', 'restituo ex tergum upload,', 'meng-upload &amp; restore dari backup', 'アップロード＆バックアップから復元', '업로드 및 백업에서 복원');
INSERT INTO `language` VALUES (200, 'manage_profile', 'manage profile', 'প্রফাইলটি পরিচালনা', 'gestionar el perfil', 'إدارة الملف الشخصي', 'te beheren!', 'управлять профилем', '管理配置文件', 'profilini yönetmek', 'gerenciar o perfil', 'Profil kezelése', 'gérer le profil', 'διαχειριστείτε το προφίλ', 'Profil verwalten', 'gestire il profilo', 'จัดการรายละเอียด', 'پروفائل کا نظم کریں', 'प्रोफाइल का प्रबंधन', 'curo profile', 'mengelola profil', 'プロファイル（個人情報）の管理', '프로필 (내 정보) 관리');
INSERT INTO `language` VALUES (201, 'update_profile', 'update profile', 'প্রোফাইল আপডেট', 'actualizar el perfil', 'تحديث الملف الشخصي', 'Profiel bijwerken', 'обновить профиль', '更新个人资料', 'profilinizi güncelleyin', 'atualizar o perfil', 'frissíteni profil', 'mettre à jour le profil', 'ενημερώσετε το προφίλ', 'Profil aktualisieren', 'aggiornare il profilo', 'อัปเดตโปรไฟล์', 'پروفائل کو اپ ڈیٹ', 'प्रोफ़ाइल अपडेट', 'magna eget ipsum', 'memperbarui profil', 'プロファイルを更新', '프로필을 업데이트');
INSERT INTO `language` VALUES (202, 'new_password', 'new password', 'নতুন পাসওয়ার্ড', 'nueva contraseña', 'كلمة مرور جديدة', 'nieuw wachtwoord', 'новый пароль', '新密码', 'Yeni şifre', 'nova senha', 'Új jelszó', 'nouveau mot de passe', 'νέο κωδικό', 'Neues Passwort', 'nuova password', 'รหัสผ่านใหม่', 'نیا پاس ورڈ', 'नया पासवर्ड', 'novum password', 'kata sandi baru', '新しいパスワード', '새 암호');
INSERT INTO `language` VALUES (203, 'confirm_new_password', 'confirm new password', 'নতুন পাসওয়ার্ড নিশ্চিত করুন', 'confirmar nueva contraseña', 'تأكيد كلمة المرور الجديدة', 'Bevestig nieuw wachtwoord', 'подтвердить новый пароль', '确认新密码', 'yeni parolayı onaylayın', 'confirmar nova senha', 'erősítse meg az új jelszót', 'confirmer le nouveau mot de passe', 'επιβεβαιώσετε το νέο κωδικό', 'Bestätigen eines neuen Kennwortes', 'conferma la nuova password', 'ยืนยันรหัสผ่านใหม่', 'نئے پاس ورڈ کی توثیق', 'नए पासवर्ड की पुष्टि', 'confirma novum password', 'konfirmasi password baru', '新しいパスワードを確認', '새 암호를 확인합니다');
INSERT INTO `language` VALUES (204, 'update_password', 'update password', 'পাসওয়ার্ড আপডেট', 'actualizar la contraseña', 'تحديث كلمة السر', 'updaten wachtwoord', 'обновить пароль', '更新密码', 'Parolanızı güncellemek', 'atualizar senha', 'frissíti jelszó', 'mettre à jour le mot de passe', 'ενημερώσετε τον κωδικό πρόσβασης', 'Kennwort aktualisieren', 'aggiornare la password', 'ปรับปรุงรหัสผ่าน', 'پاس اپ ڈیٹ', 'पासवर्ड अद्यतन', 'scelerisque eget', 'memperbarui sandi', 'パスワードを更新', '암호를 업데이트');
INSERT INTO `language` VALUES (205, 'teacher_dashboard', 'teacher dashboard', 'শিক্ষক ড্যাশবোর্ড', 'tablero maestro', 'لوحة أجهزة القياس المعلم', 'leraar dashboard', 'учитель приборной панели', '老师仪表板', 'öğretmen pano', 'dashboard professor', 'tanár műszerfal', 'enseignant tableau de bord', 'ταμπλό των εκπαιδευτικών', 'Lehrer-Dashboard', 'dashboard insegnante', 'กระดานครู', 'استاد ڈیش بورڈ', 'शिक्षक डैशबोर्ड', 'magister Dashboard', 'dashboard guru', '教師のダッシュボード', '교사 대시 보드');
INSERT INTO `language` VALUES (206, 'backup_restore_help', 'backup restore help', 'ব্যাকআপ পুনঃস্থাপন সাহায্য', 'copia de seguridad restaurar ayuda', 'استعادة النسخ الاحتياطي المساعدة', 'backup helpen herstellen', 'восстановить резервную копию помощь', '备份恢复的帮助', 'yedekleme yardım geri', 'de backup restaurar ajuda', 'Backup Restore segítségével', 'restauration de sauvegarde de l\'aide', 'επαναφοράς αντιγράφων ασφαλείας βοήθεια', 'Backup wiederherstellen Hilfe', 'Backup Restore aiuto', 'การสำรองข้อมูลเรียกคืนความช่วยเหลือ', 'بیک اپ کی مدد بحال', 'बैकअप मदद बहाल', 'auxilium tergum restituunt', 'backup restore bantuan', 'バックアップヘルプを復元', '백업 도움을 복원');
INSERT INTO `language` VALUES (207, 'student_dashboard', 'student dashboard', 'ছাত্র ড্যাশবোর্ড', 'salpicadero estudiante', 'لوحة القيادة الطلابية', 'student dashboard', 'студент приборной панели', '学生的仪表板', 'Öğrenci paneli', 'dashboard estudante', 'tanuló műszerfal', 'tableau de bord de l\'élève', 'ταμπλό των φοιτητών', 'Schüler Armaturenbrett', 'studente dashboard', 'แผงควบคุมนักเรียน', 'طالب علم کے ڈیش بورڈ', 'छात्र डैशबोर्ड', 'Discipulus Dashboard', 'dashboard mahasiswa', '学生のダッシュボード', '학생 대시 보드');
INSERT INTO `language` VALUES (208, 'parent_dashboard', 'parent dashboard', 'অভিভাবক ড্যাশবোর্ড', 'salpicadero padres', 'لوحة أجهزة القياس الأم', 'ouder dashboard', 'родитель приборной панели', '家长仪表板', 'ebeveyn kontrol paneli', 'dashboard pai', 'szülő műszerfal', 'parent tableau de bord', 'μητρική ταμπλό', 'Mutter Armaturenbrett', 'dashboard genitore', 'แผงควบคุมของผู้ปกครอง', 'والدین کے ڈیش بورڈ', 'माता - पिता डैशबोर्ड', 'Dashboard parent', 'orangtua dashboard', '親ダッシュ', '부모 대시 보드');
INSERT INTO `language` VALUES (209, 'view_marks', 'view marks', 'দেখুন চিহ্ন', 'Vista marcas', 'علامات رأي', 'view merken', 'вид знаки', '鉴于商标', 'görünümü işaretleri', 'vista marcas', 'view jelek', 'Vue marques', 'σήματα άποψη', 'Ansicht Marken', 'Vista marchi', 'เครื่องหมายมุมมอง', 'دیکھیں نشانات', 'देखने के निशान', 'propter signa', 'lihat tanda', 'ビューマーク', '보기 마크');
INSERT INTO `language` VALUES (210, 'delete_language', 'delete language', 'ভাষা মুছতে', 'eliminar el lenguaje', 'حذف اللغة', 'verwijderen taal', 'удалить язык', '删除语言', 'dili silme', 'excluir língua', 'törlése nyelv', 'supprimer la langue', 'διαγραφή γλώσσα', 'Sprache löschen', 'eliminare lingua', 'ลบภาษา', 'زبان کو خارج کر دیں', 'भाषा को हटाना', 'linguam turpis', 'menghapus bahasa', '言語を削除する', '언어를 삭제');
INSERT INTO `language` VALUES (211, 'settings_updated', 'settings updated', 'সেটিংস আপডেট', 'configuración actualizado', 'الإعدادات المحدثة', 'instellingen bijgewerkt', 'Настройки обновлены', '设置更新', 'ayarları güncellendi', 'definições atualizadas', 'beállítások frissítve', 'paramètres mis à jour', 'Ρυθμίσεις ενημέρωση', 'Einstellungen aktualisiert', 'impostazioni aggiornate', 'การตั้งค่าการปรับปรุง', 'ترتیبات کی تازہ کاری', 'सेटिंग्स अद्यतन', 'venenatis eu', 'pengaturan diperbarui', '設定が更新', '설정이 업데이트');
INSERT INTO `language` VALUES (212, 'update_phrase', 'update phrase', 'আপডেট ফ্রেজ', 'actualización de la frase', 'تحديث العبارة', 'Update zin', 'обновление фраза', '更新短语', 'güncelleme ifade', 'atualização frase', 'frissítést kifejezés', 'mise à jour phrase', 'ενημέρωση φράση', 'Update Begriff', 'aggiornamento frase', 'ปรับปรุงวลี', 'اپ ڈیٹ جملہ', 'अद्यतन वाक्यांश', 'eget dictum', 'frase pembaruan', '更新フレーズ', '업데이트 구문');
INSERT INTO `language` VALUES (213, 'login_failed', 'login failed', 'লগইন ব্যর্থ হয়েছে', 'Error de acceso', 'فشل تسجيل الدخول', 'inloggen is mislukt', 'Ошибка входа', '登录失败', 'giriş başarısız oldu', 'Falha no login', 'bejelentkezés sikertelen', 'Échec de la connexion', 'Είσοδος απέτυχε', 'Fehler bei der Anmeldung', 'Accesso non riuscito', 'เข้าสู่ระบบล้มเหลว', 'لاگ ان ناکام', 'लॉगिन विफल', 'tincidunt defecit', 'Login gagal', 'ログインに失敗しました', '로그인 실패');
INSERT INTO `language` VALUES (214, 'live_chat', 'live chat', 'লাইভ চ্যাট', 'chat en vivo', 'الدردشة الحية', 'live chat', 'Онлайн-чат', '即时聊天', 'canlı sohbet', 'chat ao vivo', 'élő chat', 'chat en direct', 'live chat', 'Live-Chat', 'live chat', 'อยู่สนทนา', 'لائیو چیٹ', 'लाइव चैट', 'Vivamus nibh', 'live chat', 'ライブチャット', '라이브 채팅');
INSERT INTO `language` VALUES (215, 'client 1', 'client 1', 'ক্লায়েন্টের 1', 'cliente 1', 'العميل 1', 'client 1', 'Клиент 1', '客户端1', 'istemcisi 1', 'cliente 1', 'ügyfél 1', 'client 1', 'πελάτη 1', 'Client 1', 'client 1', 'ลูกค้า 1', 'کلائنٹ 1', 'ग्राहक 1', 'I huius', 'client 1', 'クライアント1', '클라이언트 1');
INSERT INTO `language` VALUES (216, 'buyer', 'buyer', 'ক্রেতা', 'comprador', 'مشتر', 'koper', 'покупатель', '买方', 'alıcı', 'comprador', 'vevő', 'acheteur', 'αγοραστής', 'Käufer', 'compratore', 'ผู้ซื้อ', 'خریدار', 'खरीददार', 'qui emit,', 'pembeli', 'バイヤー', '구매자');
INSERT INTO `language` VALUES (217, 'purchase_code', 'purchase code', 'ক্রয় কোড', 'código de compra', 'كود الشراء', 'aankoop code', 'покупка код', '申购代码', 'satın alma kodu', 'código de compra', 'vásárlási kódot', 'code d\'achat', 'Κωδικός αγορά', 'Kauf-Code', 'codice di acquisto', 'รหัสการสั่งซื้อ', 'خریداری کے کوڈ', 'खरीद कोड', 'Mauris euismod', 'kode pembelian', '購入コード', '구매 코드');
INSERT INTO `language` VALUES (218, 'system_email', 'system email', 'সিস্টেম ইমেইল', 'correo electrónico del sistema', 'نظام البريد الإلكتروني', 'systeem e-mail', 'система электронной почты', '邮件系统', 'sistem e-posta', 'e-mail do sistema', 'a rendszer az e-mail', 'email de système', 'e-mail συστήματος', 'E-Mail-System', 'email sistema', 'อีเมล์ระบบ', 'نظام کی ای میل', 'प्रणाली ईमेल', 'Praesent sit amet', 'email sistem', 'システムの電子メール', '시스템 전자 메일');
INSERT INTO `language` VALUES (219, 'option', 'option', 'বিকল্প', 'opción', 'خيار', 'optie', 'вариант', '选项', 'seçenek', 'opção', 'opció', 'option', 'επιλογή', 'Option', 'opzione', 'ตัวเลือกที่', 'آپشن', 'विकल्प', 'optio', 'pilihan', 'オプション', '선택권');
INSERT INTO `language` VALUES (220, 'edit_phrase', 'edit phrase', 'সম্পাদনা ফ্রেজ', 'edit frase', 'تحرير العبارة', 'bewerk zin', 'править фраза', '编辑语', 'edit ifade', 'edição frase', 'szerkesztés kifejezés', 'modifier phrase', 'edit φράση', 'edit Begriff', 'modifica frase', 'แก้ไขวลี', 'ترمیم کے جملہ', 'संपादित वाक्यांश', 'edit phrase', 'mengedit frase', '編集フレーズ', '편집 구');
INSERT INTO `language` VALUES (221, 'forgot_your_password', 'Forgot Your Password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (222, 'forgot_password', 'Forgot Password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (223, 'back_to_login', 'Back To Login', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (224, 'return_to_login_page', 'Return to Login Page', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (225, 'admit_student', 'Admit Student', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (226, 'admit_bulk_student', 'Admit Bulk Student', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (227, 'student_information', 'Student Information', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (228, 'student_marksheet', 'Student Mark Sheet', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (229, 'daily_attendance', 'Daily Attendance', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (230, 'exam_grades', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (231, 'message', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (232, 'general_settings', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (233, 'language_settings', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (234, 'edit_profile', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (235, 'event_schedule', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (236, 'cancel', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (237, 'addmission_form', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (238, 'value_required', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (239, 'select', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (240, 'gender', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (241, 'add_bulk_student', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (242, 'student_bulk_add_form', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (243, 'select_excel_file', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (244, 'upload_and_import', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (245, 'manage_classes', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (246, 'manage_sections', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (247, 'add_new_teacher', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (248, 'section_name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (249, 'nick_name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (250, 'add_new_section', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (251, 'add_section', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (252, 'update', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (253, 'section', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (254, 'select_class_first', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (255, 'parent_information', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (256, 'relation', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (257, 'add_form', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (258, 'all_parents', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (259, 'parents', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (260, 'add_new_parent', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (261, 'add_new_student', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (262, 'all_students', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (263, 'view_marksheet', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (264, 'text_align', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (265, 'clickatell_username', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (266, 'clickatell_password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (267, 'clickatell_api_id', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (268, 'sms_settings', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (269, 'data_updated', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (270, 'data_added_successfully', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (271, 'edit_notice', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (272, 'private_messaging', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (273, 'messages', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (274, 'new_message', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (275, 'write_new_message', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (276, 'recipient', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (277, 'select_a_user', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (278, 'write_your_message', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (279, 'send', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (280, 'current_password', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (281, 'exam_marks', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (282, 'marks_obtained', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (283, 'total_marks', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (284, 'comments', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (285, 'theme_settings', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (286, 'select_theme', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (287, 'theme_selected', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (288, 'language_list', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (289, 'payment_cancelled', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (290, 'study_material', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (291, 'download', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (292, 'select_a_theme_to_make_changes', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (293, 'manage_daily_attendance', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (294, 'select_date', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (295, 'select_month', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (296, 'select_year', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (297, 'manage_attendance', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (298, 'twilio_account', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (299, 'authentication_token', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (300, 'registered_phone_number', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (301, 'select_a_service', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (302, 'active', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (303, 'disable_sms_service', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (304, 'not_selected', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (305, 'disabled', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (306, 'present', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (307, 'absent', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (308, 'accounting', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (309, 'income', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (310, 'expense', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (311, 'incomes', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (312, 'invoice_informations', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (313, 'payment_informations', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (314, 'total', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (315, 'enter_total_amount', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (316, 'enter_payment_amount', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (317, 'payment_status', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (318, 'method', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (319, 'cash', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (320, 'check', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (321, 'card', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (322, 'data_deleted', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (323, 'total_amount', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (324, 'take_payment', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (325, 'payment_history', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (326, 'amount_paid', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (327, 'due', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (328, 'payment_successfull', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (329, 'creation_date', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (330, 'invoice_entries', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (331, 'paid_amount', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (332, 'send_sms_to_all', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (333, 'yes', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (334, 'no', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (335, 'activated', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (336, 'sms_service_not_activated', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (337, 'add_study_material', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (338, 'file', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (339, 'file_type', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (340, 'select_file_type', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (341, 'image', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (342, 'doc', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (343, 'pdf', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (344, 'excel', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (345, 'other', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (346, 'expenses', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (347, 'add_new_expense', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (348, 'add_expense', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (349, 'edit_expense', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (350, 'total_mark', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (351, 'send_marks_by_sms', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (352, 'send_marks', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (353, 'select_receiver', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (354, 'students', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (355, 'marks_of', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (356, 'for', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (357, 'message_sent', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (358, 'expense_category', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (359, 'add_new_expense_category', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (360, 'add_expense_category', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (361, 'category', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (362, 'select_expense_category', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (363, 'message_sent!', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (364, 'reply_message', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (365, 'account_updated', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (366, 'upload_logo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (367, 'upload', 'Upload', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (368, 'study_material_info_saved_successfuly', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (369, 'edit_study_material', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (370, 'default_theme', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (371, 'default', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (372, 'acd_session', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (373, 'academic_session', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (374, 'online_admission', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (375, 'session_list', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (376, 'add_session', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (377, 'is_open', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (378, 'active_date', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (379, 'edit_session', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (380, 'student_application_list', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (381, 'add_student_application', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (382, 'pay_status', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (383, 'from_date', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (384, 'to_date', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (385, 'start_date', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (386, 'end_date', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (387, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (388, 'name_bangla', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (389, 'name_english', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (390, 'fridom_fighter_son', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (391, 'gardian_name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (392, 'upojati', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (393, 'FFS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (394, 'fridom_fighter', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (395, 'Nationality', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (396, 'islam', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (397, 'hindu', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (398, 'present_address', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (399, 'Parmanent_address', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (400, 'Current_address', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (401, 'technology', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (402, 'textile', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (403, 'electrical', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (404, 'Academic_details', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (405, 'SSC(General)', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (406, 'SSC(Vocational)', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (407, 'Trade(Two-Years)', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (408, 'Dakhil(Vocational)', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (409, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (410, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (411, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (412, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (413, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (414, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (415, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (416, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (417, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (418, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (419, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (420, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (421, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (422, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (423, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (424, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (425, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (426, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (427, 'Actions', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (428, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (429, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (430, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (431, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (432, 'Apply_Date', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (433, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (434, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (435, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (436, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (437, 'Cell_No', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (438, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (439, 'Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (440, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (441, 'Full_Name', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (442, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (443, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (444, 'Report', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (445, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (446, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (447, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (448, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (449, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (450, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (451, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (452, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (453, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (454, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (455, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (456, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (457, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (458, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (459, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (460, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (461, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (462, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (463, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (464, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (465, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (466, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (467, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (468, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (469, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (470, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (471, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (472, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (473, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (474, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (475, 'Photo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `language` VALUES (476, 'on', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for mark
-- ----------------------------
DROP TABLE IF EXISTS `mark`;
CREATE TABLE `mark`  (
  `mark_id` int NOT NULL AUTO_INCREMENT,
  `student_class_id` int NULL DEFAULT NULL,
  `subject_id` int NULL DEFAULT NULL,
  `exam_id` int NULL DEFAULT NULL,
  `mark_obtained` int NOT NULL DEFAULT 0,
  `mark_total` int NOT NULL DEFAULT 100,
  `comment` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`mark_id`) USING BTREE,
  INDEX `fk_exam`(`exam_id` ASC) USING BTREE,
  INDEX `fk_student_classes`(`student_class_id` ASC) USING BTREE,
  INDEX `fk_subject`(`subject_id` ASC) USING BTREE,
  CONSTRAINT `fk_exam` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_student_classes` FOREIGN KEY (`student_class_id`) REFERENCES `student_classes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_subject` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 70 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of mark
-- ----------------------------
INSERT INTO `mark` VALUES (66, 21, 15, 1, 70, 100, 'h');
INSERT INTO `mark` VALUES (67, 22, 15, 1, 80, 100, 'h');
INSERT INTO `mark` VALUES (68, 25, 15, 1, 90, 100, 'h');
INSERT INTO `mark` VALUES (69, 26, 15, 1, 100, 100, 'h');

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message`  (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `message_thread_code` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `message` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sender` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `timestamp` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `read_status` int NOT NULL DEFAULT 0 COMMENT '0 unread 1 read',
  PRIMARY KEY (`message_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES (3, 'eb7157e52314645', 'This is a test message', 'admin-1', '1647099867', 1);
INSERT INTO `message` VALUES (2, '771e4077025c3f1', 'Hi There', 'admin-1', '1449767732', 0);
INSERT INTO `message` VALUES (4, 'eb7157e52314645', 'This is a test reply from Eleanor.', 'student-2', '1647099931', 1);
INSERT INTO `message` VALUES (5, '7053f3d0570a2d9', 'Dear student, this is to inform you that this is just a demo text message from the admin.', 'admin-1', '1647193784', 1);
INSERT INTO `message` VALUES (6, '7053f3d0570a2d9', 'demo reply', 'student-3', '1647193990', 0);

-- ----------------------------
-- Table structure for message_thread
-- ----------------------------
DROP TABLE IF EXISTS `message_thread`;
CREATE TABLE `message_thread`  (
  `message_thread_id` int NOT NULL AUTO_INCREMENT,
  `message_thread_code` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sender` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reciever` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_message_timestamp` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`message_thread_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of message_thread
-- ----------------------------
INSERT INTO `message_thread` VALUES (2, '771e4077025c3f1', 'admin-1', 'student-1', '');
INSERT INTO `message_thread` VALUES (3, 'eb7157e52314645', 'admin-1', 'student-2', '');
INSERT INTO `message_thread` VALUES (4, '7053f3d0570a2d9', 'admin-1', 'student-3', '');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2025_01_13_071805_create_permission_tables', 2);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------

-- ----------------------------
-- Table structure for noticeboard
-- ----------------------------
DROP TABLE IF EXISTS `noticeboard`;
CREATE TABLE `noticeboard`  (
  `notice_id` int NOT NULL AUTO_INCREMENT,
  `notice_title` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `notice` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `create_timestamp` int NOT NULL,
  PRIMARY KEY (`notice_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of noticeboard
-- ----------------------------
INSERT INTO `noticeboard` VALUES (1, 'Test Notice One', 'This is a demo notice from the school administration to inform you that this is just a simple test message. Thank you!', 1637103600);

-- ----------------------------
-- Table structure for osad_acd_history
-- ----------------------------
DROP TABLE IF EXISTS `osad_acd_history`;
CREATE TABLE `osad_acd_history`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `osad_student_id` int NOT NULL,
  `examtype` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `board` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `passing_yr` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `special_mark` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ttl_mark` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of osad_acd_history
-- ----------------------------
INSERT INTO `osad_acd_history` VALUES (1, 1, 'SSC-GENERAL', '3', 'asd', '2222', '2', '2', '2022-03-13');

-- ----------------------------
-- Table structure for osad_student
-- ----------------------------
DROP TABLE IF EXISTS `osad_student`;
CREATE TABLE `osad_student`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `acd_session_id` int NOT NULL,
  `app_sno` int NOT NULL,
  `name_en` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name_bn` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `father_name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mother_name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gardian_name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nationality` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `technology` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ff_son` int NOT NULL,
  `upjati` int NOT NULL,
  `birthday` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sex` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `religion` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `blood_group` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pr_address` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `class_id` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `section_id` int NOT NULL,
  `parent_id` int NOT NULL,
  `roll` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `transport_id` int NOT NULL,
  `dormitory_id` int NOT NULL,
  `dormitory_room_number` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pay_no` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pay_date` date NOT NULL,
  `app_date` date NOT NULL,
  `photo` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `pay_status` int NULL DEFAULT NULL,
  `cur_address` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `acd_session_id`(`acd_session_id` ASC) USING BTREE,
  CONSTRAINT `osad_student_ibfk_1` FOREIGN KEY (`acd_session_id`) REFERENCES `acd_session` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of osad_student
-- ----------------------------
INSERT INTO `osad_student` VALUES (1, 8, 0, 'asdas', 'asdas', 'asdas', 'asdas', 'asdas', 'asdas', 'Textile', 0, 0, '07/15/2021', 'male', 'Buddhist', '', 'asdas', '2222222222', 'asdas@asd.com', '', '', 0, 0, '', 0, 0, '', '', '0000-00-00', '2022-03-13', NULL, NULL, 'asdasd');

-- ----------------------------
-- Table structure for parent
-- ----------------------------
DROP TABLE IF EXISTS `parent`;
CREATE TABLE `parent`  (
  `parent_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `password` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `phone` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `profession` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of parent
-- ----------------------------
INSERT INTO `parent` VALUES (14, 'Theng Sothea', 'admin@mail.com', NULL, '012345', 'PP', 'Web Developer');
INSERT INTO `parent` VALUES (17, 'Jonh Cina', 'parent@mail.com', NULL, '0123456789', 'Phnom Penh', 'Doctor');
INSERT INTO `parent` VALUES (18, 'Bale', 'passup231@gmail.com', NULL, '0123456789', 'Phnom Penh', 'Teacher');
INSERT INTO `parent` VALUES (19, 'Jea Taker', NULL, NULL, '021344111', NULL, NULL);
INSERT INTO `parent` VALUES (20, 'Kan Ma', NULL, NULL, '099123456', NULL, NULL);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment`  (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `expense_category_id` int NOT NULL,
  `title` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_type` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invoice_id` int NOT NULL,
  `student_id` int NOT NULL,
  `method` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `amount` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`payment_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payment
-- ----------------------------
INSERT INTO `payment` VALUES (1, 0, 'Monthly Fee', 'income', 1, 1, '1', 'asd', '100', '1449702000');
INSERT INTO `payment` VALUES (2, 0, 'Monthly Payment', 'income', 2, 3, '1', 'Payment for the month - Feb', '0', '1646089200');
INSERT INTO `payment` VALUES (3, 0, 'Monthly Fees - Feb', 'income', 3, 10, '3', 'Fees collection for the month of February', '770', '1646002800');
INSERT INTO `payment` VALUES (4, 0, 'Monthly Fees', 'income', 4, 5, '1', 'Fees collection for the month February', '990', '1646002800');
INSERT INTO `payment` VALUES (5, 0, 'Monthly Fees - Feb', 'income', 5, 12, '1', 'Fees Collection for the month February', '0', '1646002800');
INSERT INTO `payment` VALUES (6, 0, 'Monthly Fees', 'income', 6, 9, '2', 'none', '990', '1646002800');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------

-- ----------------------------
-- Table structure for section
-- ----------------------------
DROP TABLE IF EXISTS `section`;
CREATE TABLE `section`  (
  `section_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nick_name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int NULL DEFAULT NULL,
  `teacher_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`section_id`) USING BTREE,
  INDEX `classid`(`class_id` ASC) USING BTREE,
  INDEX `teacherid`(`teacher_id` ASC) USING BTREE,
  CONSTRAINT `classid` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `teacherid` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of section
-- ----------------------------
INSERT INTO `section` VALUES (13, 'Section B', 'B', NULL, NULL);
INSERT INTO `section` VALUES (14, 'Section B', 'B', NULL, NULL);
INSERT INTO `section` VALUES (15, 'Section A', 'A', NULL, NULL);
INSERT INTO `section` VALUES (17, 'Section B', 'B', NULL, NULL);
INSERT INTO `section` VALUES (26, 'EVENING', '5-7', NULL, 3);
INSERT INTO `section` VALUES (27, 'Section Evening', '5-7', 44, 3);
INSERT INTO `section` VALUES (32, 'Morning', 'M1', 48, 13);

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('Df5b8JKsgPwKGCH49AidPu3ec7BdzjN8dap67TT8', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZzVWMnZxcXNxUTNNQkRrVTk5UDI0TTk1SGMyWU5FMFpyMm5ZcTNETSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9nZXQtc3R1ZGVudHMvMzI/ZGF0ZT0yMDI1LTAxLTE3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMjoiaW50ZW5kZWRfdXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1737099659);

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `settings_id` int NOT NULL AUTO_INCREMENT,
  `type` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`settings_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 21 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'system_name', 'School Management System');
INSERT INTO `settings` VALUES (2, 'system_title', 'School Management System');
INSERT INTO `settings` VALUES (3, 'address', '93 Elm Drive, Westbury');
INSERT INTO `settings` VALUES (4, 'phone', '7410000010');
INSERT INTO `settings` VALUES (5, 'paypal_email', 'demomail@school.com');
INSERT INTO `settings` VALUES (6, 'currency', '$');
INSERT INTO `settings` VALUES (7, 'system_email', 'smsys@mail.com');
INSERT INTO `settings` VALUES (20, 'active_sms_service', 'clickatell');
INSERT INTO `settings` VALUES (11, 'language', 'english');
INSERT INTO `settings` VALUES (12, 'text_align', 'left-to-right');
INSERT INTO `settings` VALUES (13, 'clickatell_user', '');
INSERT INTO `settings` VALUES (14, 'clickatell_password', '');
INSERT INTO `settings` VALUES (15, 'clickatell_api_id', '');
INSERT INTO `settings` VALUES (16, 'skin_colour', 'purple');
INSERT INTO `settings` VALUES (17, 'twilio_account_sid', '');
INSERT INTO `settings` VALUES (18, 'twilio_auth_token', '');
INSERT INTO `settings` VALUES (19, 'twilio_sender_phone_number', '');

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`  (
  `student_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `sex` int NOT NULL,
  `religion` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `blood_group` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `address` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `parent_id` int NULL DEFAULT NULL,
  `transport_id` int NULL DEFAULT NULL,
  `dormitory_id` int NULL DEFAULT NULL,
  `dormitory_room_number` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`student_id`) USING BTREE,
  INDEX `studentParent`(`parent_id` ASC) USING BTREE,
  INDEX `student_user`(`user_id` ASC) USING BTREE,
  CONSTRAINT `studentParent` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`parent_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `student_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES (21, 'Paulene D. Spain', '2025-01-08', 0, NULL, NULL, 'KPC', '0123456789', 'student@mail.com', NULL, 17, NULL, NULL, NULL);
INSERT INTO `student` VALUES (23, 'Kim JungUnn', '2025-01-09', 0, NULL, NULL, 'North Koreaa', '01234555', 'studentaaa@mail.com', NULL, 17, NULL, NULL, NULL);
INSERT INTO `student` VALUES (24, 'Jea Takwan', '2025-01-08', 1, NULL, NULL, 'Phnom Penh', '012345', 'student@mail.com', NULL, 17, NULL, NULL, NULL);
INSERT INTO `student` VALUES (28, 'dALIS', '1998-02-07', 1, NULL, NULL, 'Phnom Penh', '0123456789', 'DALIS@GMAIL.COM', NULL, 14, NULL, NULL, NULL);
INSERT INTO `student` VALUES (29, 'Jea Takwan', '2025-01-15', 1, NULL, NULL, 'Phnom Penh', '0123456789', 'student@mail.com', NULL, 19, NULL, NULL, NULL);
INSERT INTO `student` VALUES (30, 'Kan Mo', '2024-12-30', 1, NULL, NULL, 'Phnom Penh', '0123456789', 'kanmo99@mail.com', 8, 20, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for student_classes
-- ----------------------------
DROP TABLE IF EXISTS `student_classes`;
CREATE TABLE `student_classes`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NULL DEFAULT NULL,
  `class_id` int NULL DEFAULT NULL,
  `roll` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `section_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `student_class_fk1`(`student_id` ASC) USING BTREE,
  INDEX `student_class_fk2`(`class_id` ASC) USING BTREE,
  INDEX `student_class_fk3`(`section_id` ASC) USING BTREE,
  CONSTRAINT `student_class_fk1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `student_class_fk2` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `student_class_fk3` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of student_classes
-- ----------------------------
INSERT INTO `student_classes` VALUES (21, 21, 44, '1', 27);
INSERT INTO `student_classes` VALUES (22, 23, 48, '2', 26);
INSERT INTO `student_classes` VALUES (25, 28, 45, '5', 26);
INSERT INTO `student_classes` VALUES (26, 29, 45, '123', NULL);
INSERT INTO `student_classes` VALUES (28, 30, 48, '1234', 32);
INSERT INTO `student_classes` VALUES (29, 23, 44, '999', 27);

-- ----------------------------
-- Table structure for subject
-- ----------------------------
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject`  (
  `subject_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int NULL DEFAULT NULL,
  `teacher_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`subject_id`) USING BTREE,
  INDEX `subject_teacher`(`teacher_id` ASC) USING BTREE,
  INDEX `subject_class`(`class_id` ASC) USING BTREE,
  CONSTRAINT `subject_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `subject_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subject
-- ----------------------------
INSERT INTO `subject` VALUES (13, 'Science', NULL, NULL);
INSERT INTO `subject` VALUES (14, 'Mathematics', NULL, 3);
INSERT INTO `subject` VALUES (15, 'Health', NULL, NULL);
INSERT INTO `subject` VALUES (16, 'Programming', NULL, NULL);
INSERT INTO `subject` VALUES (17, 'Graphic Desgin', NULL, NULL);
INSERT INTO `subject` VALUES (19, 'WBD', NULL, NULL);
INSERT INTO `subject` VALUES (22, 'Math', NULL, NULL);

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher`  (
  `teacher_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sex` int NOT NULL,
  `religion` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `blood_group` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `address` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`teacher_id`) USING BTREE,
  INDEX `teacher_user`(`user_id` ASC) USING BTREE,
  CONSTRAINT `teacher_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES (3, 'Arsalan Rao', '1989-07-20', 1, '', '', '460 Davis Avenue', '0147965454', 'teacher1@mail.com', 4);
INSERT INTO `teacher` VALUES (13, 'Theng Sothea', '2025-01-17', 1, NULL, NULL, 'Phnom Penh', '0123456789', 'thea123@mail.com', 7);

-- ----------------------------
-- Table structure for transport
-- ----------------------------
DROP TABLE IF EXISTS `transport`;
CREATE TABLE `transport`  (
  `transport_id` int NOT NULL AUTO_INCREMENT,
  `route_name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `number_of_vehicle` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `route_fare` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`transport_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of transport
-- ----------------------------
INSERT INTO `transport` VALUES (1, 'Miami to Orlando', '27', '$27 per person', '27');
INSERT INTO `transport` VALUES (2, 'Orlando to Miami	', '19', '$29 per person', '29');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int NOT NULL COMMENT '0=admin,1=teacher, 2=user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Administrator', 'admin@mail.com', 0, NULL, '$2y$12$mkNUvAPQVcgnVvEwTJbINuzH2274FUzWvITXXp/ejdDMsnKQXeK8y', NULL, NULL, '2025-01-15 05:25:22');
INSERT INTO `users` VALUES (2, 'Theng Sothea', 'admin12@mail.com', 0, NULL, '$2y$12$/FX40Kc1Jj/gVz8A6ffjxevGzjog7g4kvdXo/T832zxrOsYbbkTt2', NULL, '2025-01-13 04:22:02', '2025-01-13 04:22:02');
INSERT INTO `users` VALUES (3, 'Student1', 'student1@mail.com', 2, NULL, '$2y$12$dCvPVOMP03zJQBlMzgL3Ee2Jeg7jqUszrBB8dzQp1Usft/oUP5Bsu', NULL, '2025-01-13 04:36:27', '2025-01-13 04:36:27');
INSERT INTO `users` VALUES (4, 'Teacher1', 'teacher1@mail.com', 1, NULL, '$2y$12$4b.//zAFoL0Mx6lUPGA0Zesys7Qh3W0v9yNUglr3LoKO2w4dt.R36', NULL, '2025-01-13 04:37:01', '2025-01-13 04:37:01');
INSERT INTO `users` VALUES (7, 'Theng Sothea', 'thea123@mail.com', 1, NULL, '$2y$12$jRRX18SeBEypnfZ.eLJTYu43SSMGPK7PYZzHQV6HgWJP3cG64LqEi', NULL, '2025-01-17 04:26:29', '2025-01-17 05:21:36');
INSERT INTO `users` VALUES (8, 'Kan Mo', 'kanmo99@mail.com', 2, NULL, '$2y$12$6mxgdRTppWHiv9zOq0.fZusCMcGmLA7ncVx9GZvb8NAVsiUlh5dv2', NULL, '2025-01-17 04:44:06', '2025-01-17 07:01:15');

SET FOREIGN_KEY_CHECKS = 1;
