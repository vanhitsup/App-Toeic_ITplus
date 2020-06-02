/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : toeicapp

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-05-27 13:01:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for newwords
-- ----------------------------
DROP TABLE IF EXISTS `newwords`;
CREATE TABLE `newwords` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `newword` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mean` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of newwords
-- ----------------------------
INSERT INTO `newwords` VALUES ('1', 'abide by', 'tuân thủ', 'động từ');
INSERT INTO `newwords` VALUES ('2', 'agreement ', 'hợp đồng giao kèo', 'danh  từ');

-- ----------------------------
-- Table structure for sentences
-- ----------------------------
DROP TABLE IF EXISTS `sentences`;
CREATE TABLE `sentences` (
  `sentence_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `newword_id` int(11) DEFAULT NULL,
  `sentence_example` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sentence_translate` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sentence_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sentences
-- ----------------------------
INSERT INTO `sentences` VALUES ('1', '1', 'The two parties agreed to abide by the judge\'s decision', 'Hai đối tác đồng ý');
INSERT INTO `sentences` VALUES ('2', '2', 'We are in agreement or partial agreement on many of the most significant issues, but we shall have to remain at odds on a few', 'Chúng tôi');
