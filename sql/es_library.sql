/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 80016
 Source Host           : 127.0.0.1:3306
 Source Schema         : es_library

 Target Server Type    : MySQL
 Target Server Version : 80016
 File Encoding         : 65001

 Date: 28/05/2019 23:58:00
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `aId` int(11) NOT NULL AUTO_INCREMENT,
  `aUsername` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aPassword` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aToken` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`aId`, `aUsername`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for appointment
-- ----------------------------
DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment`  (
  `appointId` int(11) NOT NULL AUTO_INCREMENT,
  `rId` int(11) NOT NULL,
  `bId` int(11) NOT NULL,
  `appointDate` int(11) NOT NULL,
  `available` int(11) NULL DEFAULT 0,
  `borrowed` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`appointId`) USING BTREE,
  INDEX `appointID`(`appointId`) USING BTREE,
  INDEX `reader_`(`rId`) USING BTREE,
  INDEX `book_`(`bId`) USING BTREE,
  CONSTRAINT `book_` FOREIGN KEY (`bId`) REFERENCES `book` (`bId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `reader_` FOREIGN KEY (`rId`) REFERENCES `reader` (`rId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for book
-- ----------------------------
DROP TABLE IF EXISTS `book`;
CREATE TABLE `book`  (
  `bId` int(11) NOT NULL AUTO_INCREMENT,
  `bEachId` int(11) NOT NULL,
  `bName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bAuthor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bPub` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`bId`, `bEachId`) USING BTREE,
  INDEX `bId`(`bId`) USING BTREE,
  INDEX `bEachId`(`bEachId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for borrow
-- ----------------------------
DROP TABLE IF EXISTS `borrow`;
CREATE TABLE `borrow`  (
  `borrowId` int(11) NOT NULL AUTO_INCREMENT,
  `rId` int(11) NOT NULL,
  `bId` int(11) NOT NULL,
  `bEachId` int(11) NOT NULL,
  `borrowDate` int(11) NOT NULL,
  `returnDate` int(11) NULL DEFAULT NULL,
  `renewal` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`borrowId`) USING BTREE,
  INDEX `borrowId`(`borrowId`) USING BTREE,
  INDEX `reader`(`rId`) USING BTREE,
  INDEX `book`(`bId`) USING BTREE,
  INDEX `eachbook`(`bEachId`) USING BTREE,
  CONSTRAINT `book` FOREIGN KEY (`bId`) REFERENCES `book` (`bId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `eachbook` FOREIGN KEY (`bEachId`) REFERENCES `book` (`bEachId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `reader` FOREIGN KEY (`rId`) REFERENCES `reader` (`rId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fine
-- ----------------------------
DROP TABLE IF EXISTS `fine`;
CREATE TABLE `fine`  (
  `fId` int(11) NOT NULL AUTO_INCREMENT,
  `rId` int(11) NOT NULL,
  `bId` int(11) NOT NULL,
  `bEachId` int(11) NOT NULL,
  `fAmount` float(11, 2) NOT NULL DEFAULT 0.00,
  `fType` int(11) NOT NULL,
  `fDate` int(11) NOT NULL,
  PRIMARY KEY (`fId`) USING BTREE,
  INDEX `book_fine`(`bId`) USING BTREE,
  INDEX `eachbook_fine`(`bEachId`) USING BTREE,
  INDEX `reader_fine`(`rId`) USING BTREE,
  CONSTRAINT `book_fine` FOREIGN KEY (`bId`) REFERENCES `book` (`bId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `eachbook_fine` FOREIGN KEY (`bEachId`) REFERENCES `book` (`bEachId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `reader_fine` FOREIGN KEY (`rId`) REFERENCES `reader` (`rId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reader
-- ----------------------------
DROP TABLE IF EXISTS `reader`;
CREATE TABLE `reader`  (
  `rId` int(11) NOT NULL AUTO_INCREMENT,
  `rUsername` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rPassword` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rDept` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `rIdcard` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rPhone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `rMail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `rToken` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`rId`, `rUsername`) USING BTREE,
  UNIQUE INDEX `rID`(`rId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- View structure for bookstatus
-- ----------------------------
DROP VIEW IF EXISTS `bookstatus`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `bookstatus` AS select `book`.`bId` AS `bId`,count(`book`.`bId`) AS `totalNum`,cast((((count(`book`.`bId`) - count(`borrow`.`bId`)) - count(`appointment`.`bId`)) + 0.1) as unsigned) AS `availableNum` from ((`book` join `borrow`) join `appointment`) where ((`book`.`bId` = `borrow`.`bId`) and (`book`.`bId` = `appointment`.`bId`) and isnull(`borrow`.`returnDate`) and (`appointment`.`borrowed` = 0)) group by `book`.`bId`;

-- ----------------------------
-- View structure for borrowing
-- ----------------------------
DROP VIEW IF EXISTS `borrowing`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `borrowing` AS select `reader`.`rId` AS `rId`,`borrow`.`bId` AS `bId`,`borrow`.`bEachId` AS `bEachId`,`borrow`.`borrowDate` AS `borrowDate`,(`borrow`.`borrowDate` + ((14 + (7 * `borrow`.`renewal`)) * 86400)) AS `dueDate`,`borrow`.`renewal` AS `renewal` from (`reader` join `borrow`) where ((`reader`.`rId` = `borrow`.`rId`) and isnull(`borrow`.`returnDate`));

-- ----------------------------
-- View structure for borrowstatus
-- ----------------------------
DROP VIEW IF EXISTS `borrowstatus`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `borrowstatus` AS select `reader`.`rId` AS `rId`,count(`borrowing`.`rId`) AS `borrowedNum`,count(`dued`.`rId`) AS `duedNum`,count(`upcomingdue`.`rId`) AS `upcomingDueNum`,sum(`dued`.`fine`) AS `fine` from (((`reader` join `borrowing`) join `dued`) join `upcomingdue`) where ((`reader`.`rId` = `borrowing`.`rId`) and (`reader`.`rId` = `dued`.`rId`) and (`reader`.`rId` = `upcomingdue`.`rId`)) group by `reader`.`rId`;

-- ----------------------------
-- View structure for dued
-- ----------------------------
DROP VIEW IF EXISTS `dued`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `dued` AS select `reader`.`rId` AS `rId`,`borrow`.`bId` AS `bId`,`borrow`.`bEachId` AS `bEachId`,`borrow`.`borrowDate` AS `borrowDate`,((`borrow`.`borrowDate` + (14 * 86400)) + ((`borrow`.`renewal` * 7) * 86400)) AS `dueDay`,cast(((((unix_timestamp(now()) - ((7 * `borrow`.`renewal`) * 86400)) - `borrow`.`borrowDate`) / 86400) - 14) as signed) AS `duedDays`,(cast(((((unix_timestamp(now()) - ((7 * `borrow`.`renewal`) * 86400)) - `borrow`.`borrowDate`) / 86400) - 14) as signed) * 0.2) AS `fine`,-(cast(((((unix_timestamp(now()) - (7 * 86400)) - `borrow`.`borrowDate`) / 86400) - 14) as signed)) AS `validRenewDays`,`borrow`.`renewal` AS `renewal` from (`reader` join `borrow`) where ((`reader`.`rId` = `borrow`.`rId`) and (((((unix_timestamp(now()) - ((7 * `borrow`.`renewal`) * 86400)) - `borrow`.`borrowDate`) / 86400) - 14) >= 0) and isnull(`borrow`.`returnDate`));

-- ----------------------------
-- View structure for upcomingdue
-- ----------------------------
DROP VIEW IF EXISTS `upcomingdue`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `upcomingdue` AS select `reader`.`rId` AS `rId`,`borrow`.`bId` AS `bId`,`borrow`.`bEachId` AS `bEachId`,`borrow`.`borrowDate` AS `borrowDate`,(`borrow`.`borrowDate` + (((`borrow`.`renewal` * 7) + 14) * 86400)) AS `dueDate`,((((-((`borrow`.`renewal` - 1)) * 7) * 86400) + (14 * 86400)) + `borrow`.`borrowDate`) AS `extandedDate`,`borrow`.`renewal` AS `renewal` from (`borrow` join `reader`) where ((`reader`.`rId` = `borrow`.`rId`) and isnull(`borrow`.`returnDate`) and (-(((((unix_timestamp(now()) - ((7 * `borrow`.`renewal`) * 86400)) - `borrow`.`borrowDate`) / 86400) - 14)) <= 3) and (-(((((unix_timestamp(now()) - ((7 * `borrow`.`renewal`) * 86400)) - `borrow`.`borrowDate`) / 86400) - 14)) > 0));

SET FOREIGN_KEY_CHECKS = 1;
