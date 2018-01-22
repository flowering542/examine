/*
Navicat MySQL Data Transfer

Source Server         : my
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : ks_online

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-01-22 20:08:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ks_admin
-- ----------------------------
DROP TABLE IF EXISTS `ks_admin`;
CREATE TABLE `ks_admin` (
  `aId` int(11) NOT NULL AUTO_INCREMENT,
  `aName` varchar(32) NOT NULL,
  `aPwd` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`aId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_admin
-- ----------------------------
INSERT INTO `ks_admin` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for ks_answer
-- ----------------------------
DROP TABLE IF EXISTS `ks_answer`;
CREATE TABLE `ks_answer` (
  `sId` char(12) NOT NULL,
  `tId` int(11) NOT NULL,
  `pId` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `answer` varchar(500) DEFAULT NULL,
  `score` decimal(5,1) DEFAULT NULL,
  PRIMARY KEY (`sId`,`tId`,`pId`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_answer
-- ----------------------------
INSERT INTO `ks_answer` VALUES ('201511105065', '7', '45', '填空题', '手动阀', '0.0');
INSERT INTO `ks_answer` VALUES ('201511105065', '10', '45', '多选题', 'A,C,D', '2.0');
INSERT INTO `ks_answer` VALUES ('201511105065', '6', '45', '简答题', '山东但是发射点发顺丰', null);
INSERT INTO `ks_answer` VALUES ('201511105065', '20', '45', '单选题', 'B', '0.0');
INSERT INTO `ks_answer` VALUES ('201511105065', '7', '45', '简答题', 'fsaddf1', null);
INSERT INTO `ks_answer` VALUES ('201511105065', '8', '46', '简答题', '', null);
INSERT INTO `ks_answer` VALUES ('201511105065', '10', '45', '简答题', 'sdfasdf', null);
INSERT INTO `ks_answer` VALUES ('201511105065', '11', '45', '简答题', '多舒服啊', null);
INSERT INTO `ks_answer` VALUES ('201511105065', '10', '45', '填空题', 'sdfasf', '0.0');
INSERT INTO `ks_answer` VALUES ('201511105065', '22', '45', '单选题', 'B', '0.0');
INSERT INTO `ks_answer` VALUES ('201511105065', '12', '45', '填空题', 'sdfsadfds', '0.0');
INSERT INTO `ks_answer` VALUES ('201511105065', '20', '46', '单选题', 'A', '2.0');
INSERT INTO `ks_answer` VALUES ('201511105065', '22', '46', '单选题', 'B', '0.0');
INSERT INTO `ks_answer` VALUES ('201511105065', '43', '45', '文件上传题', '/Upload/studentUpload/2017-09-12/201511105065_1746935367.docx', null);
INSERT INTO `ks_answer` VALUES ('201511105065', '8', '45', '简答题', '', null);

-- ----------------------------
-- Table structure for ks_blank
-- ----------------------------
DROP TABLE IF EXISTS `ks_blank`;
CREATE TABLE `ks_blank` (
  `bId` int(11) NOT NULL AUTO_INCREMENT,
  `cName` varchar(50) DEFAULT NULL,
  `bTitle` varchar(1000) NOT NULL,
  `bTrue` varchar(20) DEFAULT NULL,
  `bPerson` varchar(32) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`bId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_blank
-- ----------------------------
INSERT INTO `ks_blank` VALUES ('7', 'web开发技术', '文件的三要素', '文件名，文件修改时间，文件题目', '17864159289', '5');
INSERT INTO `ks_blank` VALUES ('10', '数据库原理', '士大夫士大夫', '文件名，文件修改时间，文件题目', '17864159289', '2');
INSERT INTO `ks_blank` VALUES ('12', '数据库原理', '手动发放', '文件名，文件修改时间，文件题目', '17864159289', '2');

-- ----------------------------
-- Table structure for ks_course
-- ----------------------------
DROP TABLE IF EXISTS `ks_course`;
CREATE TABLE `ks_course` (
  `cId` int(11) NOT NULL AUTO_INCREMENT,
  `cName` varchar(50) NOT NULL,
  `cdate` date DEFAULT NULL,
  PRIMARY KEY (`cId`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_course
-- ----------------------------
INSERT INTO `ks_course` VALUES ('23', '数据库原理', '2017-08-31');
INSERT INTO `ks_course` VALUES ('2', 'web开发技术', '2017-08-10');
INSERT INTO `ks_course` VALUES ('21', '高数B', '2017-08-31');
INSERT INTO `ks_course` VALUES ('20', '高数A', '2017-08-29');

-- ----------------------------
-- Table structure for ks_file
-- ----------------------------
DROP TABLE IF EXISTS `ks_file`;
CREATE TABLE `ks_file` (
  `fId` int(11) NOT NULL AUTO_INCREMENT,
  `cName` varchar(50) DEFAULT NULL,
  `fTitle` text NOT NULL,
  `fPath` varchar(100) DEFAULT NULL,
  `fTrue` varchar(200) DEFAULT NULL,
  `fPerson` varchar(32) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`fId`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_file
-- ----------------------------
INSERT INTO `ks_file` VALUES ('44', '数据库原理', '文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题', '/Upload/questionFile/2017-09-12/开发计划.docx', null, '17864159289', '15');

-- ----------------------------
-- Table structure for ks_grade
-- ----------------------------
DROP TABLE IF EXISTS `ks_grade`;
CREATE TABLE `ks_grade` (
  `sId` char(12) NOT NULL,
  `pId` int(11) NOT NULL,
  `grade` decimal(5,1) DEFAULT NULL,
  PRIMARY KEY (`pId`,`sId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_grade
-- ----------------------------
INSERT INTO `ks_grade` VALUES ('201511105065', '45', '98.3');

-- ----------------------------
-- Table structure for ks_judge
-- ----------------------------
DROP TABLE IF EXISTS `ks_judge`;
CREATE TABLE `ks_judge` (
  `jId` int(11) NOT NULL AUTO_INCREMENT,
  `cName` varchar(50) DEFAULT NULL,
  `jTitle` varchar(1000) NOT NULL,
  `jTrue` varchar(20) DEFAULT NULL,
  `jPerson` varchar(32) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`jId`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_judge
-- ----------------------------
INSERT INTO `ks_judge` VALUES ('9', '数据库原理', '我', '1', '17864159289', '2');

-- ----------------------------
-- Table structure for ks_multi
-- ----------------------------
DROP TABLE IF EXISTS `ks_multi`;
CREATE TABLE `ks_multi` (
  `mId` int(11) NOT NULL AUTO_INCREMENT,
  `cName` varchar(50) DEFAULT NULL,
  `mTitle` varchar(1000) NOT NULL,
  `mA` varchar(500) DEFAULT NULL,
  `mB` varchar(500) DEFAULT NULL,
  `mC` varchar(500) DEFAULT NULL,
  `mD` varchar(500) DEFAULT NULL,
  `mTrue` varchar(20) DEFAULT NULL,
  `mPerson` varchar(32) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`mId`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_multi
-- ----------------------------
INSERT INTO `ks_multi` VALUES ('9', 'web开发技术', '你', 'no', 'yes', '12', '32', 'A,B,C', '17864159289', '2');
INSERT INTO `ks_multi` VALUES ('10', 'web开发技术', 'bootstrap包含什么技术？？？？', 'css样式布局', 'css样式布局', 'css样式布局', 'css样式布局', 'A,C,D', '17864159289', '2');

-- ----------------------------
-- Table structure for ks_notice
-- ----------------------------
DROP TABLE IF EXISTS `ks_notice`;
CREATE TABLE `ks_notice` (
  `nId` int(11) NOT NULL AUTO_INCREMENT,
  `nTitle` varchar(100) NOT NULL,
  `nContent` text,
  `nPerson` varchar(32) DEFAULT NULL,
  `ndate` datetime DEFAULT NULL,
  PRIMARY KEY (`nId`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_notice
-- ----------------------------
INSERT INTO `ks_notice` VALUES ('0', '今天是个好天气1', '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 今天是个好天气 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>', 'admin', '2017-08-06 00:59:08');
INSERT INTO `ks_notice` VALUES ('4', '端午节3', '<p><strong>士大夫</strong></p>', 'admin', '2017-08-05 23:53:47');
INSERT INTO `ks_notice` VALUES ('45', 'web考试公告', '', '17864159289', '2017-09-04 19:08:44');
INSERT INTO `ks_notice` VALUES ('46', '端午节', '', '17864159289', '2017-09-04 19:08:50');
INSERT INTO `ks_notice` VALUES ('36', '今天是个好天气11', '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 今天是个好天气 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>', '17864159289', '2017-08-22 14:32:55');

-- ----------------------------
-- Table structure for ks_paper
-- ----------------------------
DROP TABLE IF EXISTS `ks_paper`;
CREATE TABLE `ks_paper` (
  `pId` int(11) NOT NULL AUTO_INCREMENT,
  `pCode` char(6) DEFAULT NULL,
  `cName` varchar(50) DEFAULT NULL,
  `pName` varchar(50) NOT NULL,
  `pBtime` datetime DEFAULT NULL,
  `pEtime` datetime DEFAULT NULL,
  `pPerson` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`pId`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_paper
-- ----------------------------
INSERT INTO `ks_paper` VALUES ('45', 'bw203', 'web开发技术', 'web期末考试', '2017-09-13 12:40:13', '2017-09-14 17:41:24', '17864159289');
INSERT INTO `ks_paper` VALUES ('46', 'bw2031', '数据库原理', 'web期末考试1', '2017-09-04 21:30:19', '2017-09-11 22:48:25', '17864159289');

-- ----------------------------
-- Table structure for ks_paperdetail
-- ----------------------------
DROP TABLE IF EXISTS `ks_paperdetail`;
CREATE TABLE `ks_paperdetail` (
  `detailId` int(11) NOT NULL AUTO_INCREMENT,
  `pId` int(11) NOT NULL,
  `tId` int(11) NOT NULL,
  `type` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`detailId`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_paperdetail
-- ----------------------------
INSERT INTO `ks_paperdetail` VALUES ('40', '46', '20', '单选题');
INSERT INTO `ks_paperdetail` VALUES ('24', '45', '7', '填空题');
INSERT INTO `ks_paperdetail` VALUES ('26', '45', '10', '多选题');
INSERT INTO `ks_paperdetail` VALUES ('27', '45', '22', '单选题');
INSERT INTO `ks_paperdetail` VALUES ('28', '45', '6', '简答题');
INSERT INTO `ks_paperdetail` VALUES ('42', '45', '44', '文件上传题');
INSERT INTO `ks_paperdetail` VALUES ('39', '46', '22', '单选题');
INSERT INTO `ks_paperdetail` VALUES ('31', '45', '20', '单选题');
INSERT INTO `ks_paperdetail` VALUES ('32', '45', '7', '简答题');
INSERT INTO `ks_paperdetail` VALUES ('33', '45', '8', '简答题');
INSERT INTO `ks_paperdetail` VALUES ('34', '45', '10', '简答题');
INSERT INTO `ks_paperdetail` VALUES ('35', '45', '11', '简答题');
INSERT INTO `ks_paperdetail` VALUES ('36', '45', '12', '填空题');
INSERT INTO `ks_paperdetail` VALUES ('37', '45', '10', '填空题');

-- ----------------------------
-- Table structure for ks_question
-- ----------------------------
DROP TABLE IF EXISTS `ks_question`;
CREATE TABLE `ks_question` (
  `qId` int(11) NOT NULL AUTO_INCREMENT,
  `cName` varchar(50) DEFAULT NULL,
  `qTitle` text NOT NULL,
  `qTrue` varchar(20) DEFAULT NULL,
  `qPerson` varchar(32) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`qId`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_question
-- ----------------------------
INSERT INTO `ks_question` VALUES ('7', 'web开发技术', '在干嘛？？', '', '17864159289', '15');
INSERT INTO `ks_question` VALUES ('6', 'web开发技术', 'thinkphp怎么学？？？？？？？？', '', '17864159289', '15');
INSERT INTO `ks_question` VALUES ('8', 'web开发技术', '你今天都做啦写什么啊？？', '', '17864159289', '15');
INSERT INTO `ks_question` VALUES ('11', '数据库原理', '王者荣耀好玩不？？？', '', '17864159289', '15');
INSERT INTO `ks_question` VALUES ('10', '数据库原理', '孙大发', '', '17864159289', '15');

-- ----------------------------
-- Table structure for ks_qulist
-- ----------------------------
DROP TABLE IF EXISTS `ks_qulist`;
CREATE TABLE `ks_qulist` (
  `quId` int(11) NOT NULL AUTO_INCREMENT,
  `anId` int(11) DEFAULT NULL,
  `quTitle` text,
  `quType` varchar(50) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `quPerson` varchar(50) DEFAULT NULL,
  `quDate` datetime DEFAULT NULL,
  PRIMARY KEY (`quId`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_qulist
-- ----------------------------
INSERT INTO `ks_qulist` VALUES ('49', '20', '你喜欢我吗', '单选题', '2', null, '2017-08-30 19:56:27');
INSERT INTO `ks_qulist` VALUES ('50', '9', '你', '多选题', '2', '竹', '2017-08-31 09:37:41');
INSERT INTO `ks_qulist` VALUES ('51', '10', 'bootstrap包含什么技术？？？？', '多选题', '2', '竹', '2017-09-09 15:42:21');
INSERT INTO `ks_qulist` VALUES ('55', '22', '你喜欢什么', '单选题', '2', '竹', '2017-09-09 00:03:29');
INSERT INTO `ks_qulist` VALUES ('56', '7', '文件的三要素', '填空题', '5', '竹', '2017-09-09 16:43:26');
INSERT INTO `ks_qulist` VALUES ('58', '6', 'thinkphp怎么学？？？？？？？？', '简答题', '15', '竹', '2017-09-09 00:01:14');
INSERT INTO `ks_qulist` VALUES ('60', '7', '在干嘛？？', '简答题', '15', '竹', '2017-09-09 22:17:39');
INSERT INTO `ks_qulist` VALUES ('61', '8', '你今天都做啦写什么啊？？', '简答题', '15', '竹', '2017-09-10 18:04:21');
INSERT INTO `ks_qulist` VALUES ('63', '10', '孙大发', '简答题', '15', '竹', '2017-09-10 19:05:46');
INSERT INTO `ks_qulist` VALUES ('64', '11', '王者荣耀好玩不？？？', '简答题', '15', '竹', '2017-09-10 19:27:50');
INSERT INTO `ks_qulist` VALUES ('66', '10', '士大夫士大夫', '填空题', '2', '竹', '2017-09-10 20:00:12');
INSERT INTO `ks_qulist` VALUES ('68', '12', '手动发放', '填空题', '2', '竹', '2017-09-10 20:00:25');
INSERT INTO `ks_qulist` VALUES ('69', '44', '文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题文件题', '文件上传题', '15', '竹', '2017-09-12 22:55:20');
INSERT INTO `ks_qulist` VALUES ('70', '9', '我', '判断题', '2', '竹', '2017-09-11 23:07:57');

-- ----------------------------
-- Table structure for ks_single
-- ----------------------------
DROP TABLE IF EXISTS `ks_single`;
CREATE TABLE `ks_single` (
  `sId` int(11) NOT NULL AUTO_INCREMENT,
  `cName` varchar(50) DEFAULT NULL,
  `sTitle` varchar(1000) NOT NULL,
  `sA` varchar(500) DEFAULT NULL,
  `sB` varchar(500) DEFAULT NULL,
  `sC` varchar(500) DEFAULT NULL,
  `sD` varchar(500) DEFAULT NULL,
  `sTrue` varchar(20) DEFAULT NULL,
  `sPerson` varchar(32) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`sId`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_single
-- ----------------------------
INSERT INTO `ks_single` VALUES ('20', '数据库开发', '你喜欢我吗', '1', '2', '35', '4', 'A', null, '2');
INSERT INTO `ks_single` VALUES ('22', '数据库原理', '你喜欢什么', '运动', '唱歌', '跳舞', '玩', 'D', '17864159289', '2');

-- ----------------------------
-- Table structure for ks_student
-- ----------------------------
DROP TABLE IF EXISTS `ks_student`;
CREATE TABLE `ks_student` (
  `sId` char(12) NOT NULL,
  `sName` varchar(32) NOT NULL,
  `sSex` char(2) DEFAULT NULL,
  `sClass` varchar(32) NOT NULL,
  `sPhone` varchar(11) DEFAULT NULL,
  `sEmail` varchar(32) DEFAULT NULL,
  `sPwd` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_student
-- ----------------------------
INSERT INTO `ks_student` VALUES ('201511105065', '雪', '女', '软测152', '17864159289', '855445456@qq.com', 'dfaa27bd112fcd155240e4b365ab95e9');
INSERT INTO `ks_student` VALUES ('201511105034', '的萨芬', '男', '软测152', '17864159283', '1933622876@qq.com', '780bc94827df5175e0b4d1a7383948f6');
INSERT INTO `ks_student` VALUES ('201511105062', '的萨芬', '男', '软测152', '17864159288', '1933622876@qq.com', 'f78b6f70e6d5df3b8ddb3faa3e168112');
INSERT INTO `ks_student` VALUES ('201511105061', '的萨芬', '男', '软测152', '17864159288', '1933622876@qq.com', '4e4b87a315cb3f8bd7b639a1b1623165');
INSERT INTO `ks_student` VALUES ('201511105049', '的萨芬', '男', '软测152', '17864159288', '1933622876@qq.com', 'e1207925c8cafa6d5b302100b7356d80');
INSERT INTO `ks_student` VALUES ('201511105031', '的萨芬', '男', '软测152', '17864159288', '1933622876@qq.com', 'd7b3a05661b9c3035a5d15e3f825b9a1');
INSERT INTO `ks_student` VALUES ('201511105011', '的萨芬', '男', '软测152', '17864159288', '1933622876@qq.com', 'ae7f9150c36192aea6e40a1d804e6892');

-- ----------------------------
-- Table structure for ks_teacher
-- ----------------------------
DROP TABLE IF EXISTS `ks_teacher`;
CREATE TABLE `ks_teacher` (
  `tId` int(11) NOT NULL AUTO_INCREMENT,
  `tName` varchar(32) NOT NULL,
  `tSex` char(2) DEFAULT NULL,
  `tPhone` varchar(11) DEFAULT NULL,
  `tEmail` varchar(32) DEFAULT NULL,
  `tPwd` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tId`),
  UNIQUE KEY `tPhone` (`tPhone`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_teacher
-- ----------------------------
INSERT INTO `ks_teacher` VALUES ('4', '竹', '女', '17864159289', '1933622876@qq.com', '714f36cba7a7fc62d4f3604787385bff');
INSERT INTO `ks_teacher` VALUES ('3', '雪', '男', '17864159282', '19625454@qq.com', '482e1b522a4cffcac16b67510ee64a2f');
INSERT INTO `ks_teacher` VALUES ('8', '徐海龙', '女', '17864159280', '1933622876@qq.com', '16e3284c088279d184ae3d3b1c90d547');

-- ----------------------------
-- Table structure for ks_testinfo
-- ----------------------------
DROP TABLE IF EXISTS `ks_testinfo`;
CREATE TABLE `ks_testinfo` (
  `sId` char(12) NOT NULL,
  `pId` int(11) NOT NULL,
  `bTime` datetime DEFAULT NULL,
  `eTime` datetime DEFAULT NULL,
  `submit` varchar(10) DEFAULT NULL,
  `remainTime` int(11) DEFAULT NULL,
  PRIMARY KEY (`sId`,`pId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ks_testinfo
-- ----------------------------
INSERT INTO `ks_testinfo` VALUES ('201511105065', '45', '2017-09-14 12:43:09', '2017-09-14 17:41:24', '', '299');
INSERT INTO `ks_testinfo` VALUES ('201511105065', '46', '2017-09-11 22:48:40', '2017-09-11 22:48:25', '', '0');
