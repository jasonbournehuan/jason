/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : center

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-11-21 15:30:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for center_site_total_data
-- ----------------------------
DROP TABLE IF EXISTS `center_site_total_data`;
CREATE TABLE `center_site_total_data` (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '日期+site_id组合ID',
  `site_id` int(5) NOT NULL DEFAULT '0' COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '增加记录时间',
  `data` text COMMENT '汇总数据内容',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `site_id` (`site_id`) USING BTREE,
  KEY `add_time` (`add_time`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of center_site_total_data
-- ----------------------------
