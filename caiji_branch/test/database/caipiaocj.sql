/*
Navicat MySQL Data Transfer

Source Server         : localhost1
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : caipiaocj

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-26 02:34:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cj_framework_count
-- ----------------------------
DROP TABLE IF EXISTS `cj_framework_count`;
CREATE TABLE `cj_framework_count` (
  `name` char(32) NOT NULL DEFAULT '',
  `count` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cj_framework_count
-- ----------------------------
INSERT INTO `cj_framework_count` VALUES ('adminlog', '93');
INSERT INTO `cj_framework_count` VALUES ('model', '10');
INSERT INTO `cj_framework_count` VALUES ('admin', '1');
INSERT INTO `cj_framework_count` VALUES ('admingroup', '0');
INSERT INTO `cj_framework_count` VALUES ('user', '5');
INSERT INTO `cj_framework_count` VALUES ('zhuihao', '17');
INSERT INTO `cj_framework_count` VALUES ('order', '95');
INSERT INTO `cj_framework_count` VALUES ('sscorderinfo', '29629');
INSERT INTO `cj_framework_count` VALUES ('tixian', '2');
INSERT INTO `cj_framework_count` VALUES ('moneylog', '3');
INSERT INTO `cj_framework_count` VALUES ('bcbm', '288');
INSERT INTO `cj_framework_count` VALUES ('game', '26');
INSERT INTO `cj_framework_count` VALUES ('gamelist', '410');
INSERT INTO `cj_framework_count` VALUES ('gamewanfa', '762');
INSERT INTO `cj_framework_count` VALUES ('kj', '4102');

-- ----------------------------
-- Table structure for cj_framework_maxid
-- ----------------------------
DROP TABLE IF EXISTS `cj_framework_maxid`;
CREATE TABLE `cj_framework_maxid` (
  `name` char(32) NOT NULL DEFAULT '',
  `maxid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cj_framework_maxid
-- ----------------------------
INSERT INTO `cj_framework_maxid` VALUES ('adminlog', '97');
INSERT INTO `cj_framework_maxid` VALUES ('model', '13');
INSERT INTO `cj_framework_maxid` VALUES ('admin', '4');
INSERT INTO `cj_framework_maxid` VALUES ('admingroup', '3');
INSERT INTO `cj_framework_maxid` VALUES ('user', '5');
INSERT INTO `cj_framework_maxid` VALUES ('zhuihao', '17');
INSERT INTO `cj_framework_maxid` VALUES ('order', '95');
INSERT INTO `cj_framework_maxid` VALUES ('sscorderinfo', '29630');
INSERT INTO `cj_framework_maxid` VALUES ('tixian', '2');
INSERT INTO `cj_framework_maxid` VALUES ('moneylog', '3');
INSERT INTO `cj_framework_maxid` VALUES ('bcbm', '288');
INSERT INTO `cj_framework_maxid` VALUES ('gamelist', '70');
INSERT INTO `cj_framework_maxid` VALUES ('kj', '4102');

-- ----------------------------
-- Table structure for cj_kj
-- ----------------------------
DROP TABLE IF EXISTS `cj_kj`;
CREATE TABLE `cj_kj` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `typeid` int(3) NOT NULL DEFAULT '0' COMMENT '类型',
  `qi` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '期号',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '增加时间',
  `code` text CHARACTER SET utf8 NOT NULL COMMENT '开奖号码',
  `post_stuat` int(1) NOT NULL DEFAULT '0' COMMENT '发送状态',
  `kj_time` int(10) NOT NULL COMMENT '开奖日期',
  `yid` int(3) NOT NULL DEFAULT '0' COMMENT '采集源ID',
  PRIMARY KEY (`id`),
  KEY `yid` (`yid`),
  KEY `qi` (`qi`) USING BTREE,
  KEY `add_time` (`add_time`) USING BTREE,
  KEY `post_stuat` (`post_stuat`) USING BTREE,
  KEY `kj_time` (`kj_time`) USING BTREE,
  KEY `typeid` (`typeid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5526 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cj_kj
-- ----------------------------
INSERT INTO `cj_kj` VALUES ('5315', '31', '2018146', '1530491233', '6,2,3', '0', '1527942600', '1');
INSERT INTO `cj_kj` VALUES ('5316', '31', '2018147', '1530491233', '0,3,8', '0', '1528029000', '1');
INSERT INTO `cj_kj` VALUES ('5317', '31', '2018148', '1530491233', '8,1,9', '0', '1528115400', '1');
INSERT INTO `cj_kj` VALUES ('5318', '31', '2018149', '1530491233', '8,7,1', '0', '1528201800', '1');
INSERT INTO `cj_kj` VALUES ('5319', '31', '2018150', '1530491233', '6,7,5', '0', '1528288200', '1');
INSERT INTO `cj_kj` VALUES ('5320', '31', '2018151', '1530491233', '6,9,4', '0', '1528374600', '1');
INSERT INTO `cj_kj` VALUES ('5321', '31', '2018152', '1530491233', '4,6,9', '0', '1528461000', '1');
INSERT INTO `cj_kj` VALUES ('5322', '31', '2018153', '1530491233', '0,8,3', '0', '1528547400', '1');
INSERT INTO `cj_kj` VALUES ('5323', '31', '2018154', '1530491233', '0,3,1', '0', '1528633800', '1');
INSERT INTO `cj_kj` VALUES ('5324', '31', '2018155', '1530491233', '1,6,0', '0', '1528720200', '1');
INSERT INTO `cj_kj` VALUES ('5325', '31', '2018156', '1530491233', '3,2,2', '0', '1528806600', '1');
INSERT INTO `cj_kj` VALUES ('5326', '31', '2018157', '1530491233', '2,0,9', '0', '1528893000', '1');
INSERT INTO `cj_kj` VALUES ('5327', '31', '2018158', '1530491233', '3,0,0', '0', '1528979400', '1');
INSERT INTO `cj_kj` VALUES ('5328', '31', '2018159', '1530491233', '2,9,4', '0', '1529065800', '1');
INSERT INTO `cj_kj` VALUES ('5329', '31', '2018160', '1530491233', '1,0,8', '0', '1529152200', '1');
INSERT INTO `cj_kj` VALUES ('5330', '31', '2018161', '1530491233', '4,7,3', '0', '1529238600', '1');
INSERT INTO `cj_kj` VALUES ('5331', '31', '2018162', '1530491233', '2,6,0', '0', '1529325000', '1');
INSERT INTO `cj_kj` VALUES ('5332', '31', '2018163', '1530491233', '5,7,0', '0', '1529411400', '1');
INSERT INTO `cj_kj` VALUES ('5333', '31', '2018164', '1530491233', '6,1,0', '0', '1529497800', '1');
INSERT INTO `cj_kj` VALUES ('5334', '31', '2018165', '1530491233', '3,0,2', '0', '1529584200', '1');
INSERT INTO `cj_kj` VALUES ('5335', '31', '2018166', '1530491233', '0,6,1', '0', '1529670600', '1');
INSERT INTO `cj_kj` VALUES ('5336', '31', '2018167', '1530491233', '1,3,2', '0', '1529757000', '1');
INSERT INTO `cj_kj` VALUES ('5337', '31', '2018168', '1530491233', '2,7,5', '0', '1529843400', '1');
INSERT INTO `cj_kj` VALUES ('5338', '31', '2018169', '1530491233', '7,1,6', '0', '1529929800', '1');
INSERT INTO `cj_kj` VALUES ('5339', '31', '2018170', '1530491233', '1,2,7', '0', '1530016200', '1');
INSERT INTO `cj_kj` VALUES ('5340', '31', '2018171', '1530491233', '2,9,7', '0', '1530102600', '1');
INSERT INTO `cj_kj` VALUES ('5341', '31', '2018172', '1530491233', '2,4,7', '0', '1530189000', '1');
INSERT INTO `cj_kj` VALUES ('5342', '31', '2018173', '1530491233', '2,4,2', '0', '1530275400', '1');
INSERT INTO `cj_kj` VALUES ('5343', '31', '2018174', '1530491233', '0,1,9', '0', '1530361800', '1');
INSERT INTO `cj_kj` VALUES ('5344', '31', '2018175', '1530491233', '6,1,2', '0', '1530448200', '1');
INSERT INTO `cj_kj` VALUES ('5345', '1', '', '1551571388', '10,8,1,3,5,4,7,2,9,6', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5346', '1', '', '1551571388', '7,5,2,10,8,1,3,6,4,9', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5347', '1', '', '1551571388', '10,5,2,6,3,4,7,8,1,9', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5348', '1', '', '1551571388', '4,7,10,1,8,3,6,5,9,2', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5349', '1', '', '1551571388', '1,4,5,10,2,3,8,6,7,9', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5350', '1', '', '1551571388', '7,1,4,2,8,6,9,10,3,5', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5351', '1', '', '1551571388', '3,6,8,1,2,5,9,10,4,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5352', '1', '', '1551571388', '3,10,2,7,5,6,9,8,4,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5353', '1', '', '1551571388', '1,7,9,2,3,8,6,4,5,10', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5354', '1', '', '1551571388', '10,9,1,8,7,3,6,2,4,5', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5355', '1', '', '1551571388', '8,10,3,6,2,1,9,5,4,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5356', '1', '', '1551571388', '1,8,3,6,10,7,4,5,9,2', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5357', '1', '', '1551571388', '2,6,4,1,10,8,7,3,9,5', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5358', '1', '', '1551571388', '10,7,5,8,1,4,9,6,3,2', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5359', '1', '', '1551571388', '5,9,6,3,8,1,10,7,4,2', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5360', '1', '', '1551571388', '3,7,6,10,9,4,1,2,8,5', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5361', '1', '', '1551571388', '5,4,10,1,2,8,9,7,3,6', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5362', '1', '', '1551571388', '8,4,9,10,7,6,2,5,3,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5363', '1', '', '1551571388', '7,6,8,4,9,3,1,2,10,5', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5364', '1', '', '1551571388', '8,3,1,9,10,4,6,2,5,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5365', '1', '', '1551572007', '5,3,6,9,2', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5366', '1', '', '1551572007', '3,4,2,6,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5367', '1', '', '1551572007', '0,0,2,6,2', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5368', '1', '', '1551572007', '8,0,6,2,9', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5369', '1', '', '1551572007', '1,2,1,6,6', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5370', '1', '', '1551572007', '4,5,7,0,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5371', '1', '', '1551572007', '3,6,2,3,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5372', '1', '', '1551572007', '2,1,0,8,4', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5373', '1', '', '1551572007', '5,7,1,2,2', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5374', '1', '', '1551572007', '1,5,7,2,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5375', '1', '', '1551572007', '9,5,1,7,8', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5376', '1', '', '1551572007', '4,1,2,7,3', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5377', '1', '', '1551572007', '4,4,5,8,0', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5378', '1', '', '1551572007', '2,3,8,4,8', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5379', '1', '', '1551572007', '5,2,1,5,9', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5380', '1', '', '1551572007', '5,1,4,3,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5381', '1', '', '1551572007', '4,4,1,1,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5382', '1', '', '1551572007', '4,6,0,2,9', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5383', '1', '', '1551572007', '7,9,9,2,3', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5384', '1', '', '1551572007', '7,7,9,2,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5385', '1', '', '1551572017', '3,6,9,9,0', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5386', '1', '20190302180', '1551572540', '10,4,9,3,8,2,6,5,7,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5387', '1', '20190302179', '1551572540', '10,1,4,3,7,6,2,9,5,8', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5388', '1', '20190302178', '1551572540', '9,8,4,5,2,3,7,6,10,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5389', '1', '20190302177', '1551572540', '1,4,9,5,2,8,6,10,7,3', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5390', '1', '20190302176', '1551572540', '6,7,1,10,2,3,5,8,9,4', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5391', '1', '20190302175', '1551572540', '3,10,5,4,2,6,9,7,8,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5392', '1', '20190302174', '1551572540', '3,10,8,9,2,1,5,6,7,4', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5393', '1', '20190302173', '1551572540', '2,9,8,3,1,6,4,7,10,5', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5394', '1', '20190302172', '1551572540', '7,5,9,6,3,4,8,2,1,10', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5395', '1', '20190302171', '1551572540', '9,10,3,8,6,2,1,7,4,5', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5396', '1', '20190302170', '1551572540', '5,1,2,6,10,7,4,9,3,8', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5397', '1', '20190302169', '1551572540', '9,6,10,8,2,7,3,5,4,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5398', '1', '20190302168', '1551572540', '4,8,5,6,10,9,1,2,3,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5399', '1', '20190302167', '1551572540', '6,5,2,9,1,4,7,8,10,3', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5400', '1', '20190302166', '1551572540', '6,2,10,8,5,9,3,7,4,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5401', '1', '20190302165', '1551572540', '5,8,2,10,7,3,4,6,1,9', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5402', '1', '20190302164', '1551572540', '4,10,5,2,1,3,6,9,8,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5403', '1', '20190302163', '1551572540', '8,7,4,6,5,1,10,9,3,2', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5404', '1', '20190302162', '1551572540', '3,4,6,7,9,8,1,5,10,2', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5405', '1', '20190302161', '1551572540', '3,7,1,8,4,5,9,6,2,10', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5406', '1', '2019024', '1551573776', '43,30,24,25,22,32,11', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5407', '1', '2019023', '1551573776', '19,12,13,9,21,46,15', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5408', '1', '2019022', '1551573776', '14,49,15,33,13,21,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5409', '1', '2019021', '1551573776', '39,36,16,49,29,42,34', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5410', '1', '2019020', '1551573776', '33,16,8,13,5,2,41', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5411', '1', '2019019', '1551573776', '3,8,17,19,7,23,12', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5412', '1', '2019018', '1551573776', '46,5,43,8,20,16,11', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5413', '1', '2019017', '1551573776', '40,9,26,17,32,31,27', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5414', '1', '2019016', '1551573776', '1,34,39,49,19,29,43', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5415', '1', '2019015', '1551573776', '15,19,4,29,2,11,1', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5416', '1', '2019014', '1551573776', '5,35,13,6,34,19,39', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5417', '1', '2019013', '1551573776', '22,26,31,33,41,18,27', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5418', '1', '2019012', '1551573776', '14,45,3,10,24,32,29', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5419', '1', '2019011', '1551573776', '46,14,45,41,27,29,21', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5420', '1', '2019010', '1551573776', '46,41,18,33,43,11,36', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5421', '1', '2019009', '1551573776', '30,33,3,19,25,48,44', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5422', '1', '2019008', '1551573776', '34,47,24,13,31,44,8', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5423', '1', '2019007', '1551573776', '16,18,28,35,41,36,37', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5424', '1', '2019006', '1551573776', '44,33,16,17,10,48,7', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5425', '1', '2019005', '1551573776', '35,48,18,37,49,10,27', '0', '0', '3');
INSERT INTO `cj_kj` VALUES ('5426', '1', '20190304-009', '1551652681', '8,6,3,4,2', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5427', '1', '20190304-008', '1551652681', '2,6,7,2,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5428', '1', '20190304-007', '1551652681', '0,5,7,9,5', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5429', '1', '20190304-006', '1551652681', '8,1,1,8,2', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5430', '1', '20190304-005', '1551652681', '9,7,7,9,8', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5431', '1', '20190304-004', '1551652681', '5,2,2,0,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5432', '1', '20190304-003', '1551652681', '3,4,2,8,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5433', '1', '20190304-002', '1551652681', '8,2,5,1,1', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5434', '1', '20190304-001', '1551652681', '8,7,5,9,3', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5435', '1', '20190303-059', '1551652681', '0,1,2,0,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5436', '1', '20190303-058', '1551652681', '3,3,0,4,8', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5437', '1', '20190303-057', '1551652681', '6,3,5,4,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5438', '1', '20190303-056', '1551652681', '4,9,2,6,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5439', '1', '20190303-055', '1551652681', '7,1,3,0,2', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5440', '1', '20190303-054', '1551652681', '0,0,4,1,5', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5441', '1', '20190303-053', '1551652681', '2,2,7,9,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5442', '1', '20190303-052', '1551652681', '2,2,9,6,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5443', '1', '20190303-051', '1551652681', '4,2,3,6,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5444', '1', '20190303-050', '1551652681', '9,2,4,8,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5445', '1', '20190303-049', '1551652681', '3,3,9,9,5', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5446', '1', '20190303-048', '1551652681', '1,9,3,5,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5447', '1', '20190303-047', '1551652681', '9,3,1,5,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5448', '1', '20190303-046', '1551652681', '8,4,4,2,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5449', '1', '20190303-045', '1551652681', '9,6,6,2,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5450', '1', '20190303-044', '1551652681', '8,7,4,0,2', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5451', '1', '20190303-043', '1551652681', '1,3,9,5,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5452', '1', '20190303-042', '1551652681', '8,5,8,0,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5453', '1', '20190303-041', '1551652681', '8,7,0,7,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5454', '1', '20190303-040', '1551652681', '6,5,5,8,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5455', '1', '20190303-039', '1551652681', '1,9,9,3,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5456', '1', '20190303-038', '1551652681', '2,8,6,1,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5457', '1', '20190303-037', '1551652681', '4,7,3,2,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5458', '1', '20190303-036', '1551652681', '7,3,6,6,3', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5459', '1', '20190303-035', '1551652681', '7,2,1,3,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5460', '1', '20190303-034', '1551652681', '9,4,0,8,5', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5461', '1', '20190303-033', '1551652681', '7,6,2,1,3', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5462', '1', '20190303-032', '1551652681', '3,8,3,8,1', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5463', '1', '20190303-031', '1551652681', '0,6,7,0,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5464', '1', '20190303-030', '1551652681', '2,7,8,9,5', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5465', '1', '20190303-029', '1551652681', '7,1,9,8,9', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5466', '1', '20190303-028', '1551652681', '5,6,5,5,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5467', '1', '20190303-027', '1551652681', '8,9,7,9,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5468', '1', '20190303-026', '1551652681', '6,1,9,5,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5469', '1', '20190303-025', '1551652681', '4,8,0,2,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5470', '1', '20190303-024', '1551652681', '6,0,8,7,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5471', '1', '20190303-023', '1551652681', '2,0,7,5,2', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5472', '1', '20190303-022', '1551652681', '6,3,0,4,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5473', '1', '20190303-021', '1551652681', '0,9,0,0,5', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5474', '1', '20190303-020', '1551652681', '5,9,8,4,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5475', '1', '20190303-019', '1551652681', '6,7,1,6,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5476', '1', '20190303-018', '1551652681', '5,0,0,5,8', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5477', '1', '20190303-017', '1551652681', '4,8,8,0,3', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5478', '1', '20190303-016', '1551652681', '2,4,8,3,5', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5479', '1', '20190303-015', '1551652681', '5,0,0,1,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5480', '1', '20190303-014', '1551652681', '8,5,9,1,9', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5481', '1', '20190303-013', '1551652681', '5,1,7,9,2', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5482', '1', '20190303-012', '1551652681', '3,6,9,9,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5483', '1', '20190303-011', '1551652681', '5,3,6,9,2', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5484', '1', '20190303-010', '1551652681', '3,4,2,6,1', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5485', '1', '20190303-009', '1551652681', '0,0,2,6,2', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5486', '1', '20190303-008', '1551652681', '8,0,6,2,9', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5487', '1', '20190303-007', '1551652681', '1,2,1,6,6', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5488', '1', '20190303-006', '1551652681', '4,5,7,0,1', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5489', '1', '20190303-005', '1551652681', '3,6,2,3,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5490', '1', '20190303-004', '1551652681', '2,1,0,8,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5491', '1', '20190303-003', '1551652681', '5,7,1,2,2', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5492', '1', '20190303-002', '1551652681', '1,5,7,2,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5493', '1', '20190303-001', '1551652681', '9,5,1,7,8', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5494', '1', '20190302-059', '1551652681', '4,1,2,7,3', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5495', '1', '20190302-058', '1551652681', '4,4,5,8,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5496', '1', '20190302-057', '1551652681', '2,3,8,4,8', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5497', '1', '20190302-056', '1551652681', '5,2,1,5,9', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5498', '1', '20190302-055', '1551652681', '5,1,4,3,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5499', '1', '20190302-054', '1551652681', '4,4,1,1,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5500', '1', '20190302-053', '1551652681', '4,6,0,2,9', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5501', '1', '20190302-052', '1551652681', '7,9,9,2,3', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5502', '1', '20190302-051', '1551652681', '7,7,9,2,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5503', '1', '20190302-050', '1551652681', '2,0,0,5,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5504', '1', '20190302-049', '1551652681', '3,9,6,0,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5505', '1', '20190302-048', '1551652681', '4,0,3,7,3', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5506', '1', '20190302-047', '1551652681', '2,8,9,1,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5507', '1', '20190302-046', '1551652681', '2,7,6,3,7', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5508', '1', '20190302-045', '1551652681', '7,9,2,8,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5509', '1', '20190302-044', '1551652681', '4,5,3,4,3', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5510', '1', '20190302-043', '1551652681', '7,5,8,0,8', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5511', '1', '20190302-042', '1551652681', '9,7,0,2,1', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5512', '1', '20190302-041', '1551652681', '8,4,0,6,3', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5513', '1', '20190302-040', '1551652681', '6,1,6,9,1', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5514', '1', '20190302-039', '1551652681', '4,8,6,3,0', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5515', '1', '20190302-038', '1551652681', '0,2,6,1,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5516', '1', '20190302-037', '1551652681', '9,1,4,5,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5517', '1', '20190302-036', '1551652681', '6,1,9,7,3', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5518', '1', '20190302-035', '1551652681', '3,0,1,7,5', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5519', '1', '20190302-034', '1551652681', '8,3,7,4,5', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5520', '1', '20190302-033', '1551652681', '7,6,6,1,8', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5521', '1', '20190302-032', '1551652681', '7,3,6,5,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5522', '1', '20190302-031', '1551652681', '6,4,6,5,4', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5523', '1', '20190302-030', '1551652681', '1,1,0,5,1', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5524', '1', '20190302-029', '1551652681', '4,1,8,4,9', '0', '0', '1');
INSERT INTO `cj_kj` VALUES ('5525', '1', '20190302-028', '1551652681', '8,0,9,1,0', '0', '0', '1');

-- ----------------------------
-- Table structure for cj_model
-- ----------------------------
DROP TABLE IF EXISTS `cj_model`;
CREATE TABLE `cj_model` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` varchar(200) CHARACTER SET utf8 NOT NULL COMMENT '模型名称',
  `stuat` int(1) NOT NULL DEFAULT '1' COMMENT '状态，0为未使用，1为使用',
  `files` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '模型目录名称',
  `system` int(1) NOT NULL DEFAULT '0' COMMENT '系统模块，如果为1则不能删除',
  `config` longtext CHARACTER SET utf8 NOT NULL COMMENT '系统配置',
  PRIMARY KEY (`id`),
  KEY `stuat` (`stuat`),
  KEY `files` (`files`),
  KEY `system` (`system`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cj_model
-- ----------------------------
INSERT INTO `cj_model` VALUES ('1', '模块管理', '1', 'model', '1', '');
INSERT INTO `cj_model` VALUES ('2', '管理员模块', '1', 'admins', '1', '');
INSERT INTO `cj_model` VALUES ('3', '会员模块', '1', 'user', '0', '{\\\"email_colse\\\":{\\\"field_name\\\":\\\"\\\\u90ae\\\\u4ef6\\\\u5f00\\\\u5173\\\",\\\"field_enname\\\":\\\"email_colse\\\",\\\"field_beizhu\\\":\\\"\\\",\\\"field_type\\\":\\\"5\\\",\\\"field_info\\\":\\\"1\\\",\\\"field_id\\\":\\\"usertab1\\\"},\\\"reg_colse\\\":{\\\"field_name\\\":\\\"\\\\u6ce8\\\\u518c\\\\u5f00\\\\u5173\\\",\\\"field_enname\\\":\\\"reg_colse\\\",\\\"field_beizhu\\\":\\\"\\\",\\\"field_type\\\":\\\"5\\\",\\\"field_info\\\":\\\"1\\\",\\\"field_id\\\":\\\"usertab2\\\"},\\\"colsereg_title\\\":{\\\"field_name\\\":\\\"\\\\u5173\\\\u95ed\\\\u6ce8\\\\u518c\\\\u63d0\\\\u793a\\\",\\\"field_enname\\\":\\\"colsereg_title\\\",\\\"field_beizhu\\\":\\\"\\\\u7cfb\\\\u7edf\\\\u8bbe\\\\u7f6e\\\\u4e3a\\\\u5173\\\\u95ed\\\\u6ce8\\\\u518c\\\\u540e\\\\u6ce8\\\\u518c\\\\u65f6\\\\u7684\\\\u63d0\\\\u793a\\\\u6587\\\\u5b57\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\\u5173\\\\u95ed\\\\u6ce8\\\\u518c\\\\u63d0\\\\u793a\\\",\\\"field_id\\\":\\\"usertab2\\\"},\\\"reg_verify\\\":{\\\"field_name\\\":\\\"\\\\u6ce8\\\\u518c\\\\u9a8c\\\\u8bc1\\\\u5f00\\\\u5173\\\",\\\"field_enname\\\":\\\"reg_verify\\\",\\\"field_beizhu\\\":\\\"\\\",\\\"field_type\\\":\\\"5\\\",\\\"field_info\\\":\\\"1\\\",\\\"field_id\\\":\\\"usertab2\\\"},\\\"reg_verify_title\\\":{\\\"field_name\\\":\\\"\\\\u672a\\\\u9a8c\\\\u8bc1\\\\u63d0\\\\u793a\\\",\\\"field_enname\\\":\\\"reg_verify_title\\\",\\\"field_beizhu\\\":\\\"\\\\u7cfb\\\\u7edf\\\\u8bbe\\\\u7f6e\\\\u4e3a\\\\u6ce8\\\\u518c\\\\u9700\\\\u9a8c\\\\u8bc1\\\\u540e\\\\u767b\\\\u5f55\\\\u65f6\\\\u7684\\\\u63d0\\\\u793a\\\\u6587\\\\u5b57\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\\u672a\\\\u9a8c\\\\u8bc1\\\\u63d0\\\\u793a\\\",\\\"field_id\\\":\\\"usertab2\\\"},\\\"reg_email\\\":{\\\"field_name\\\":\\\"\\\\u6ce8\\\\u518c\\\\u9a8c\\\\u8bc1\\\\u90ae\\\\u4ef6\\\",\\\"field_enname\\\":\\\"reg_email\\\",\\\"field_beizhu\\\":\\\"\\\\u53d1\\\\u9001\\\\u7ed9\\\\u4f1a\\\\u5458\\\\u7684\\\\u6ce8\\\\u518c\\\\u9a8c\\\\u8bc1\\\\u63d0\\\\u793a\\\\u5185\\\\u5bb9\\\\uff0c\\\\u652f\\\\u6301\\\\u6a21\\\\u677f\\\\u4ee3\\\\u7801\\\",\\\"field_type\\\":\\\"3\\\",\\\"field_info\\\":\\\"<span style=\\\\\\\"color:#333333;font-family:PTSansRegular, Arial, Helvetica, sans-serif;font-size:13px;line-height:19px;background-color:#F8F8F8;\\\\\\\">\\\\u6ce8\\\\u518c\\\\u9a8c\\\\u8bc1\\\\u90ae\\\\u4ef6<\\\\/span>\\\",\\\"field_id\\\":\\\"usertab2\\\"},\\\"regok_email\\\":{\\\"field_name\\\":\\\"\\\\u6ce8\\\\u518c\\\\u6210\\\\u529f\\\\u90ae\\\\u4ef6\\\",\\\"field_enname\\\":\\\"regok_email\\\",\\\"field_beizhu\\\":\\\"\\\\u53d1\\\\u9001\\\\u7ed9\\\\u4f1a\\\\u5458\\\\u7684\\\\u6ce8\\\\u518c\\\\u6210\\\\u529f\\\\u63d0\\\\u793a\\\\u5185\\\\u5bb9\\\\uff0c\\\\u652f\\\\u6301\\\\u6a21\\\\u677f\\\\u4ee3\\\\u7801\\\",\\\"field_type\\\":\\\"3\\\",\\\"field_info\\\":\\\"<span style=\\\\\\\"color:#333333;font-family:PTSansRegular, Arial, Helvetica, sans-serif;font-size:13.333333969116211px;line-height:18.095239639282227px;background-color:#F8F8F8;\\\\\\\">\\\\u6ce8\\\\u518c\\\\u6210\\\\u529f\\\\u90ae\\\\u4ef6<\\\\/span>\\\",\\\"field_id\\\":\\\"usertab2\\\"},\\\"getpassword_email\\\":{\\\"field_name\\\":\\\"\\\\u53d6\\\\u56de\\\\u5bc6\\\\u7801\\\\u90ae\\\\u4ef6\\\",\\\"field_enname\\\":\\\"getpassword_email\\\",\\\"field_beizhu\\\":\\\"\\\\u53d1\\\\u9001\\\\u7ed9\\\\u4f1a\\\\u5458\\\\u7684\\\\u53d6\\\\u56de\\\\u5bc6\\\\u7801\\\\u63d0\\\\u793a\\\\u5185\\\\u5bb9\\\\uff0c\\\\u652f\\\\u6301\\\\u6a21\\\\u677f\\\\u4ee3\\\\u7801\\\",\\\"field_type\\\":\\\"3\\\",\\\"field_info\\\":\\\"<span style=\\\\\\\"color:#333333;font-family:PTSansRegular, Arial, Helvetica, sans-serif;font-size:13px;line-height:19px;background-color:#F8F8F8;\\\\\\\">\\\\u53d6\\\\u56de\\\\u5bc6\\\\u7801\\\\u90ae\\\\u4ef6<\\\\/span>\\\",\\\"field_id\\\":\\\"usertab2\\\"},\\\"getpasswordok_email\\\":{\\\"field_name\\\":\\\"\\\\u53d6\\\\u56de\\\\u5bc6\\\\u7801\\\\u6210\\\\u529f\\\\u90ae\\\\u4ef6\\\",\\\"field_enname\\\":\\\"getpasswordok_email\\\",\\\"field_beizhu\\\":\\\"\\\\u53d1\\\\u9001\\\\u7ed9\\\\u4f1a\\\\u5458\\\\u7684\\\\u53d6\\\\u56de\\\\u5bc6\\\\u7801\\\\u6210\\\\u529f\\\\u63d0\\\\u793a\\\\u5185\\\\u5bb9\\\\uff0c\\\\u652f\\\\u6301\\\\u6a21\\\\u677f\\\\u4ee3\\\\u7801\\\",\\\"field_type\\\":\\\"3\\\",\\\"field_info\\\":\\\"<span style=\\\\\\\"color:#333333;font-family:PTSansRegular, Arial, Helvetica, sans-serif;font-size:13px;line-height:19px;background-color:#F8F8F8;\\\\\\\">\\\\u53d6\\\\u56de\\\\u5bc6\\\\u7801\\\\u6210\\\\u529f\\\\u90ae\\\\u4ef6<\\\\/span>\\\",\\\"field_id\\\":\\\"usertab2\\\"},\\\"login_colse\\\":{\\\"field_name\\\":\\\"\\\\u767b\\\\u5f55\\\\u5f00\\\\u5173\\\",\\\"field_enname\\\":\\\"login_colse\\\",\\\"field_beizhu\\\":\\\"\\\",\\\"field_type\\\":\\\"5\\\",\\\"field_info\\\":\\\"1\\\",\\\"field_id\\\":\\\"usertab3\\\"},\\\"colselogin_title\\\":{\\\"field_name\\\":\\\"\\\\u5173\\\\u95ed\\\\u767b\\\\u5f55\\\\u63d0\\\\u793a\\\",\\\"field_enname\\\":\\\"colselogin_title\\\",\\\"field_beizhu\\\":\\\"\\\\u7cfb\\\\u7edf\\\\u8bbe\\\\u7f6e\\\\u4e3a\\\\u5173\\\\u95ed\\\\u767b\\\\u5f55\\\\u540e\\\\u767b\\\\u5f55\\\\u65f6\\\\u7684\\\\u63d0\\\\u793a\\\\u6587\\\\u5b57\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\\u5173\\\\u95ed\\\\u767b\\\\u5f55\\\\u63d0\\\\u793a\\\",\\\"field_id\\\":\\\"usertab3\\\"},\\\"score1\\\":{\\\"field_name\\\":\\\"\\\\u79ef\\\\u5206\\\\u4e00\\\\u540d\\\\u79f0\\\",\\\"field_enname\\\":\\\"score1\\\",\\\"field_beizhu\\\":\\\"\\\\u7b2c\\\\u4e00\\\\u7c7b\\\\u79ef\\\\u5206\\\\u540d\\\\u79f0\\\\uff0c\\\\u8be5\\\\u79ef\\\\u5206\\\\u4e3a\\\\u4f1a\\\\u5458\\\\u7ec4\\\\u5347\\\\u7ea7\\\\u79ef\\\\u5206\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\\u7ecf\\\\u9a8c\\\",\\\"field_id\\\":\\\"usertab4\\\"},\\\"score1dw\\\":{\\\"field_name\\\":\\\"\\\\u79ef\\\\u5206\\\\u4e00\\\\u5355\\\\u4f4d\\\",\\\"field_enname\\\":\\\"score1dw\\\",\\\"field_beizhu\\\":\\\"\\\\u7b2c\\\\u4e00\\\\u7c7b\\\\u79ef\\\\u5206\\\\u5355\\\\u4f4d\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\\u4e2a\\\",\\\"field_id\\\":\\\"usertab4\\\"},\\\"score2\\\":{\\\"field_name\\\":\\\"\\\\u79ef\\\\u5206\\\\u4e8c\\\\u540d\\\\u79f0\\\",\\\"field_enname\\\":\\\"score2\\\",\\\"field_beizhu\\\":\\\"\\\\u7b2c\\\\u4e8c\\\\u7c7b\\\\u79ef\\\\u5206\\\\u540d\\\\u79f0\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\\u5143\\\\u5b9d\\\",\\\"field_id\\\":\\\"usertab4\\\"},\\\"score2dw\\\":{\\\"field_name\\\":\\\"\\\\u79ef\\\\u5206\\\\u4e8c\\\\u5355\\\\u4f4d\\\",\\\"field_enname\\\":\\\"score2dw\\\",\\\"field_beizhu\\\":\\\"\\\\u7b2c\\\\u4e8c\\\\u7c7b\\\\u79ef\\\\u5206\\\\u5355\\\\u4f4d\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\\u4e2a\\\",\\\"field_id\\\":\\\"usertab4\\\"},\\\"score3\\\":{\\\"field_name\\\":\\\"\\\\u79ef\\\\u5206\\\\u4e09\\\\u540d\\\\u79f0\\\",\\\"field_enname\\\":\\\"score3\\\",\\\"field_beizhu\\\":\\\"\\\\u7b2c\\\\u4e09\\\\u7c7b\\\\u79ef\\\\u5206\\\\u540d\\\\u79f0\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\",\\\"field_id\\\":\\\"usertab4\\\"},\\\"score3dw\\\":{\\\"field_name\\\":\\\"\\\\u79ef\\\\u5206\\\\u4e09\\\\u5355\\\\u4f4d\\\",\\\"field_enname\\\":\\\"score3dw\\\",\\\"field_beizhu\\\":\\\"\\\\u7b2c\\\\u4e09\\\\u7c7b\\\\u79ef\\\\u5206\\\\u5355\\\\u4f4d\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\",\\\"field_id\\\":\\\"usertab4\\\"},\\\"score4\\\":{\\\"field_name\\\":\\\"\\\\u79ef\\\\u5206\\\\u56db\\\\u540d\\\\u79f0\\\",\\\"field_enname\\\":\\\"score4\\\",\\\"field_beizhu\\\":\\\"\\\\u7b2c\\\\u56db\\\\u7c7b\\\\u79ef\\\\u5206\\\\u540d\\\\u79f0\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\",\\\"field_id\\\":\\\"usertab4\\\"},\\\"score4dw\\\":{\\\"field_name\\\":\\\"\\\\u79ef\\\\u5206\\\\u56db\\\\u5355\\\\u4f4d\\\",\\\"field_enname\\\":\\\"score4dw\\\",\\\"field_beizhu\\\":\\\"\\\\u7b2c\\\\u56db\\\\u7c7b\\\\u79ef\\\\u5206\\\\u5355\\\\u4f4d\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\",\\\"field_id\\\":\\\"usertab4\\\"},\\\"score5\\\":{\\\"field_name\\\":\\\"\\\\u79ef\\\\u5206\\\\u4e94\\\\u540d\\\\u79f0\\\",\\\"field_enname\\\":\\\"score5\\\",\\\"field_beizhu\\\":\\\"\\\\u7b2c\\\\u4e94\\\\u7c7b\\\\u79ef\\\\u5206\\\\u540d\\\\u79f0\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\",\\\"field_id\\\":\\\"usertab4\\\"},\\\"score5dw\\\":{\\\"field_name\\\":\\\"\\\\u79ef\\\\u5206\\\\u4e94\\\\u5355\\\\u4f4d\\\",\\\"field_enname\\\":\\\"score5dw\\\",\\\"field_beizhu\\\":\\\"\\\\u7b2c\\\\u4e94\\\\u7c7b\\\\u79ef\\\\u5206\\\\u5355\\\\u4f4d\\\",\\\"field_type\\\":\\\"1\\\",\\\"field_info\\\":\\\"\\\",\\\"field_id\\\":\\\"usertab4\\\"}}');
INSERT INTO `cj_model` VALUES ('4', '单页模块', '1', 'duli', '1', '');
INSERT INTO `cj_model` VALUES ('6', '时时彩管理', '1', 'ssc', '1', '');
INSERT INTO `cj_model` VALUES ('7', '11选5管理', '1', 's11x5', '1', '');
INSERT INTO `cj_model` VALUES ('8', '福彩3D管理', '1', 'fc3d', '1', '');
INSERT INTO `cj_model` VALUES ('9', '江苏快3管理', '1', 'k3', '1', '');
INSERT INTO `cj_model` VALUES ('10', '排列3管理', '1', 'pl3', '1', '');
INSERT INTO `cj_model` VALUES ('11', '北京赛车管理', '1', 'bjsc', '1', '');
INSERT INTO `cj_model` VALUES ('12', '奔驰宝马管理', '1', 'bcbm', '1', '');
INSERT INTO `cj_model` VALUES ('13', '财务管理', '1', 'moneylog', '0', '');

-- ----------------------------
-- Table structure for cj_runtime
-- ----------------------------
DROP TABLE IF EXISTS `cj_runtime`;
CREATE TABLE `cj_runtime` (
  `k` char(16) NOT NULL DEFAULT '',
  `v` char(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`k`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cj_runtime
-- ----------------------------
