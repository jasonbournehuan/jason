/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50644
 Source Host           : 127.0.0.1:3306
 Source Schema         : caiji_branch

 Target Server Type    : MySQL
 Target Server Version : 50644
 File Encoding         : 65001

 Date: 24/09/2019 20:04:46
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cj_framework_count
-- ----------------------------
DROP TABLE IF EXISTS `cj_framework_count`;
CREATE TABLE `cj_framework_count`  (
  `name` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `count` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for cj_framework_maxid
-- ----------------------------
DROP TABLE IF EXISTS `cj_framework_maxid`;
CREATE TABLE `cj_framework_maxid`  (
  `name` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `maxid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for cj_kj
-- ----------------------------
DROP TABLE IF EXISTS `cj_kj`;
CREATE TABLE `cj_kj`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `typeid` int(3) NOT NULL DEFAULT 0 COMMENT '类型',
  `qi` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '期号',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '增加时间',
  `code` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '开奖号码',
  `post_stuat` int(1) NOT NULL DEFAULT 0 COMMENT '发送状态',
  `kj_time` int(10) NOT NULL COMMENT '开奖日期',
  `yid` int(3) NOT NULL DEFAULT 0 COMMENT '采集源ID',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `yid`(`yid`) USING BTREE,
  INDEX `qi`(`qi`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `post_stuat`(`post_stuat`) USING BTREE,
  INDEX `kj_time`(`kj_time`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cj_model
-- ----------------------------
DROP TABLE IF EXISTS `cj_model`;
CREATE TABLE `cj_model`  (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模型名称',
  `stuat` int(1) NOT NULL DEFAULT 1 COMMENT '状态，0为未使用，1为使用',
  `files` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模型目录名称',
  `system` int(1) NOT NULL DEFAULT 0 COMMENT '系统模块，如果为1则不能删除',
  `config` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统配置',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `stuat`(`stuat`) USING BTREE,
  INDEX `files`(`files`) USING BTREE,
  INDEX `system`(`system`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cj_runtime
-- ----------------------------
DROP TABLE IF EXISTS `cj_runtime`;
CREATE TABLE `cj_runtime`  (
  `k` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `v` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`k`) USING HASH
) ENGINE = MEMORY CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

SET FOREIGN_KEY_CHECKS = 1;
