/*
 Navicat Premium Data Transfer

 Source Server         : amazon
 Source Server Type    : MySQL
 Source Server Version : 50641
 Source Host           : test-database-compose.cvj4tj0or9um.ap-northeast-1.rds.amazonaws.com:3306
 Source Schema         : center

 Target Server Type    : MySQL
 Target Server Version : 50641
 File Encoding         : 65001

 Date: 14/11/2019 17:39:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for center_0_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_0_error_data`;
CREATE TABLE `center_0_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_0_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_0_loginlog`;
CREATE TABLE `center_0_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_0_order
-- ----------------------------
DROP TABLE IF EXISTS `center_0_order`;
CREATE TABLE `center_0_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_0_user
-- ----------------------------
DROP TABLE IF EXISTS `center_0_user`;
CREATE TABLE `center_0_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_1_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_1_error_data`;
CREATE TABLE `center_1_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for center_1_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_1_loginlog`;
CREATE TABLE `center_1_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of center_1_loginlog
-- ----------------------------
INSERT INTO `center_1_loginlog` VALUES (1, 100015497456, 1, 1571573911, 0, 1.0000, '1571573912431uhe5il5jv', '{\"status\":1,\"msg\":\"http:\\/\\/test.bw-gaming.com\\/handler\\/fastlogin?key=4695ea20d79b4e38a42214eac8f8f6b4&UserName=uhe5il5jv\",\"money\":\"1\",\"orders_number\":\"1571573912431uhe5il5jv\"}', 1, 4, 180, '0');

-- ----------------------------
-- Table structure for center_1_order
-- ----------------------------
DROP TABLE IF EXISTS `center_1_order`;
CREATE TABLE `center_1_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利金额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器，由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_1_user
-- ----------------------------
DROP TABLE IF EXISTS `center_1_user`;
CREATE TABLE `center_1_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户ID的15位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` int(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for center_2_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_2_error_data`;
CREATE TABLE `center_2_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_2_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_2_loginlog`;
CREATE TABLE `center_2_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_2_order
-- ----------------------------
DROP TABLE IF EXISTS `center_2_order`;
CREATE TABLE `center_2_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_2_user
-- ----------------------------
DROP TABLE IF EXISTS `center_2_user`;
CREATE TABLE `center_2_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_3_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_3_error_data`;
CREATE TABLE `center_3_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_3_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_3_loginlog`;
CREATE TABLE `center_3_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_3_order
-- ----------------------------
DROP TABLE IF EXISTS `center_3_order`;
CREATE TABLE `center_3_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_3_user
-- ----------------------------
DROP TABLE IF EXISTS `center_3_user`;
CREATE TABLE `center_3_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_4_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_4_error_data`;
CREATE TABLE `center_4_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_4_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_4_loginlog`;
CREATE TABLE `center_4_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_4_order
-- ----------------------------
DROP TABLE IF EXISTS `center_4_order`;
CREATE TABLE `center_4_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_4_user
-- ----------------------------
DROP TABLE IF EXISTS `center_4_user`;
CREATE TABLE `center_4_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_5_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_5_error_data`;
CREATE TABLE `center_5_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_5_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_5_loginlog`;
CREATE TABLE `center_5_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_5_order
-- ----------------------------
DROP TABLE IF EXISTS `center_5_order`;
CREATE TABLE `center_5_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_5_user
-- ----------------------------
DROP TABLE IF EXISTS `center_5_user`;
CREATE TABLE `center_5_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_6_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_6_error_data`;
CREATE TABLE `center_6_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_6_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_6_loginlog`;
CREATE TABLE `center_6_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_6_order
-- ----------------------------
DROP TABLE IF EXISTS `center_6_order`;
CREATE TABLE `center_6_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_6_user
-- ----------------------------
DROP TABLE IF EXISTS `center_6_user`;
CREATE TABLE `center_6_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_7_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_7_error_data`;
CREATE TABLE `center_7_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_7_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_7_loginlog`;
CREATE TABLE `center_7_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_7_order
-- ----------------------------
DROP TABLE IF EXISTS `center_7_order`;
CREATE TABLE `center_7_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_7_user
-- ----------------------------
DROP TABLE IF EXISTS `center_7_user`;
CREATE TABLE `center_7_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_8_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_8_error_data`;
CREATE TABLE `center_8_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_8_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_8_loginlog`;
CREATE TABLE `center_8_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_8_order
-- ----------------------------
DROP TABLE IF EXISTS `center_8_order`;
CREATE TABLE `center_8_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_8_user
-- ----------------------------
DROP TABLE IF EXISTS `center_8_user`;
CREATE TABLE `center_8_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_9_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_9_error_data`;
CREATE TABLE `center_9_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_9_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_9_loginlog`;
CREATE TABLE `center_9_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_9_order
-- ----------------------------
DROP TABLE IF EXISTS `center_9_order`;
CREATE TABLE `center_9_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_9_user
-- ----------------------------
DROP TABLE IF EXISTS `center_9_user`;
CREATE TABLE `center_9_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_10_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_10_error_data`;
CREATE TABLE `center_10_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_10_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_10_loginlog`;
CREATE TABLE `center_10_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_10_order
-- ----------------------------
DROP TABLE IF EXISTS `center_10_order`;
CREATE TABLE `center_10_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_10_user
-- ----------------------------
DROP TABLE IF EXISTS `center_10_user`;
CREATE TABLE `center_10_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_11_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_11_error_data`;
CREATE TABLE `center_11_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_11_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_11_loginlog`;
CREATE TABLE `center_11_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_11_order
-- ----------------------------
DROP TABLE IF EXISTS `center_11_order`;
CREATE TABLE `center_11_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_11_user
-- ----------------------------
DROP TABLE IF EXISTS `center_11_user`;
CREATE TABLE `center_11_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_12_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_12_error_data`;
CREATE TABLE `center_12_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_12_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_12_loginlog`;
CREATE TABLE `center_12_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_12_order
-- ----------------------------
DROP TABLE IF EXISTS `center_12_order`;
CREATE TABLE `center_12_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_12_user
-- ----------------------------
DROP TABLE IF EXISTS `center_12_user`;
CREATE TABLE `center_12_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_13_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_13_error_data`;
CREATE TABLE `center_13_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_13_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_13_loginlog`;
CREATE TABLE `center_13_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_13_order
-- ----------------------------
DROP TABLE IF EXISTS `center_13_order`;
CREATE TABLE `center_13_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_13_user
-- ----------------------------
DROP TABLE IF EXISTS `center_13_user`;
CREATE TABLE `center_13_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_14_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_14_error_data`;
CREATE TABLE `center_14_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_14_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_14_loginlog`;
CREATE TABLE `center_14_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_14_order
-- ----------------------------
DROP TABLE IF EXISTS `center_14_order`;
CREATE TABLE `center_14_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_14_user
-- ----------------------------
DROP TABLE IF EXISTS `center_14_user`;
CREATE TABLE `center_14_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_15_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_15_error_data`;
CREATE TABLE `center_15_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_15_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_15_loginlog`;
CREATE TABLE `center_15_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_15_order
-- ----------------------------
DROP TABLE IF EXISTS `center_15_order`;
CREATE TABLE `center_15_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_15_user
-- ----------------------------
DROP TABLE IF EXISTS `center_15_user`;
CREATE TABLE `center_15_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_16_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_16_error_data`;
CREATE TABLE `center_16_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_16_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_16_loginlog`;
CREATE TABLE `center_16_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_16_order
-- ----------------------------
DROP TABLE IF EXISTS `center_16_order`;
CREATE TABLE `center_16_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_16_user
-- ----------------------------
DROP TABLE IF EXISTS `center_16_user`;
CREATE TABLE `center_16_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_17_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_17_error_data`;
CREATE TABLE `center_17_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_17_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_17_loginlog`;
CREATE TABLE `center_17_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_17_order
-- ----------------------------
DROP TABLE IF EXISTS `center_17_order`;
CREATE TABLE `center_17_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_17_user
-- ----------------------------
DROP TABLE IF EXISTS `center_17_user`;
CREATE TABLE `center_17_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_18_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_18_error_data`;
CREATE TABLE `center_18_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_18_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_18_loginlog`;
CREATE TABLE `center_18_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_18_order
-- ----------------------------
DROP TABLE IF EXISTS `center_18_order`;
CREATE TABLE `center_18_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_18_user
-- ----------------------------
DROP TABLE IF EXISTS `center_18_user`;
CREATE TABLE `center_18_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_19_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_19_error_data`;
CREATE TABLE `center_19_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_19_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_19_loginlog`;
CREATE TABLE `center_19_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_19_order
-- ----------------------------
DROP TABLE IF EXISTS `center_19_order`;
CREATE TABLE `center_19_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_19_user
-- ----------------------------
DROP TABLE IF EXISTS `center_19_user`;
CREATE TABLE `center_19_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_20_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_20_error_data`;
CREATE TABLE `center_20_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_20_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_20_loginlog`;
CREATE TABLE `center_20_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_20_order
-- ----------------------------
DROP TABLE IF EXISTS `center_20_order`;
CREATE TABLE `center_20_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_20_user
-- ----------------------------
DROP TABLE IF EXISTS `center_20_user`;
CREATE TABLE `center_20_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_21_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_21_error_data`;
CREATE TABLE `center_21_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_21_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_21_loginlog`;
CREATE TABLE `center_21_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_21_order
-- ----------------------------
DROP TABLE IF EXISTS `center_21_order`;
CREATE TABLE `center_21_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_21_user
-- ----------------------------
DROP TABLE IF EXISTS `center_21_user`;
CREATE TABLE `center_21_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_22_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_22_error_data`;
CREATE TABLE `center_22_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_22_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_22_loginlog`;
CREATE TABLE `center_22_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_22_order
-- ----------------------------
DROP TABLE IF EXISTS `center_22_order`;
CREATE TABLE `center_22_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_22_user
-- ----------------------------
DROP TABLE IF EXISTS `center_22_user`;
CREATE TABLE `center_22_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_23_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_23_error_data`;
CREATE TABLE `center_23_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_23_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_23_loginlog`;
CREATE TABLE `center_23_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_23_order
-- ----------------------------
DROP TABLE IF EXISTS `center_23_order`;
CREATE TABLE `center_23_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_23_user
-- ----------------------------
DROP TABLE IF EXISTS `center_23_user`;
CREATE TABLE `center_23_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_24_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_24_error_data`;
CREATE TABLE `center_24_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_24_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_24_loginlog`;
CREATE TABLE `center_24_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_24_order
-- ----------------------------
DROP TABLE IF EXISTS `center_24_order`;
CREATE TABLE `center_24_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_24_user
-- ----------------------------
DROP TABLE IF EXISTS `center_24_user`;
CREATE TABLE `center_24_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_25_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_25_error_data`;
CREATE TABLE `center_25_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_25_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_25_loginlog`;
CREATE TABLE `center_25_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_25_order
-- ----------------------------
DROP TABLE IF EXISTS `center_25_order`;
CREATE TABLE `center_25_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_25_user
-- ----------------------------
DROP TABLE IF EXISTS `center_25_user`;
CREATE TABLE `center_25_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_26_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_26_error_data`;
CREATE TABLE `center_26_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_26_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_26_loginlog`;
CREATE TABLE `center_26_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_26_order
-- ----------------------------
DROP TABLE IF EXISTS `center_26_order`;
CREATE TABLE `center_26_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_26_user
-- ----------------------------
DROP TABLE IF EXISTS `center_26_user`;
CREATE TABLE `center_26_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_27_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_27_error_data`;
CREATE TABLE `center_27_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_27_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_27_loginlog`;
CREATE TABLE `center_27_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_27_order
-- ----------------------------
DROP TABLE IF EXISTS `center_27_order`;
CREATE TABLE `center_27_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_27_user
-- ----------------------------
DROP TABLE IF EXISTS `center_27_user`;
CREATE TABLE `center_27_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_28_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_28_error_data`;
CREATE TABLE `center_28_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_28_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_28_loginlog`;
CREATE TABLE `center_28_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_28_order
-- ----------------------------
DROP TABLE IF EXISTS `center_28_order`;
CREATE TABLE `center_28_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_28_user
-- ----------------------------
DROP TABLE IF EXISTS `center_28_user`;
CREATE TABLE `center_28_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_29_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_29_error_data`;
CREATE TABLE `center_29_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_29_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_29_loginlog`;
CREATE TABLE `center_29_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_29_order
-- ----------------------------
DROP TABLE IF EXISTS `center_29_order`;
CREATE TABLE `center_29_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_29_user
-- ----------------------------
DROP TABLE IF EXISTS `center_29_user`;
CREATE TABLE `center_29_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_30_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_30_error_data`;
CREATE TABLE `center_30_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_30_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_30_loginlog`;
CREATE TABLE `center_30_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_30_order
-- ----------------------------
DROP TABLE IF EXISTS `center_30_order`;
CREATE TABLE `center_30_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_30_user
-- ----------------------------
DROP TABLE IF EXISTS `center_30_user`;
CREATE TABLE `center_30_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_31_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_31_error_data`;
CREATE TABLE `center_31_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_31_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_31_loginlog`;
CREATE TABLE `center_31_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_31_order
-- ----------------------------
DROP TABLE IF EXISTS `center_31_order`;
CREATE TABLE `center_31_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_31_user
-- ----------------------------
DROP TABLE IF EXISTS `center_31_user`;
CREATE TABLE `center_31_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_32_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_32_error_data`;
CREATE TABLE `center_32_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_32_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_32_loginlog`;
CREATE TABLE `center_32_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_32_order
-- ----------------------------
DROP TABLE IF EXISTS `center_32_order`;
CREATE TABLE `center_32_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_32_user
-- ----------------------------
DROP TABLE IF EXISTS `center_32_user`;
CREATE TABLE `center_32_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_33_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_33_error_data`;
CREATE TABLE `center_33_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_33_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_33_loginlog`;
CREATE TABLE `center_33_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_33_order
-- ----------------------------
DROP TABLE IF EXISTS `center_33_order`;
CREATE TABLE `center_33_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_33_user
-- ----------------------------
DROP TABLE IF EXISTS `center_33_user`;
CREATE TABLE `center_33_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_34_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_34_error_data`;
CREATE TABLE `center_34_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_34_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_34_loginlog`;
CREATE TABLE `center_34_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_34_order
-- ----------------------------
DROP TABLE IF EXISTS `center_34_order`;
CREATE TABLE `center_34_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_34_user
-- ----------------------------
DROP TABLE IF EXISTS `center_34_user`;
CREATE TABLE `center_34_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_35_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_35_error_data`;
CREATE TABLE `center_35_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_35_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_35_loginlog`;
CREATE TABLE `center_35_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_35_order
-- ----------------------------
DROP TABLE IF EXISTS `center_35_order`;
CREATE TABLE `center_35_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_35_user
-- ----------------------------
DROP TABLE IF EXISTS `center_35_user`;
CREATE TABLE `center_35_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_36_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_36_error_data`;
CREATE TABLE `center_36_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_36_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_36_loginlog`;
CREATE TABLE `center_36_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_36_order
-- ----------------------------
DROP TABLE IF EXISTS `center_36_order`;
CREATE TABLE `center_36_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_36_user
-- ----------------------------
DROP TABLE IF EXISTS `center_36_user`;
CREATE TABLE `center_36_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_37_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_37_error_data`;
CREATE TABLE `center_37_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_37_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_37_loginlog`;
CREATE TABLE `center_37_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_37_order
-- ----------------------------
DROP TABLE IF EXISTS `center_37_order`;
CREATE TABLE `center_37_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_37_user
-- ----------------------------
DROP TABLE IF EXISTS `center_37_user`;
CREATE TABLE `center_37_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_38_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_38_error_data`;
CREATE TABLE `center_38_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_38_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_38_loginlog`;
CREATE TABLE `center_38_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_38_order
-- ----------------------------
DROP TABLE IF EXISTS `center_38_order`;
CREATE TABLE `center_38_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_38_user
-- ----------------------------
DROP TABLE IF EXISTS `center_38_user`;
CREATE TABLE `center_38_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_39_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_39_error_data`;
CREATE TABLE `center_39_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_39_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_39_loginlog`;
CREATE TABLE `center_39_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_39_order
-- ----------------------------
DROP TABLE IF EXISTS `center_39_order`;
CREATE TABLE `center_39_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_39_user
-- ----------------------------
DROP TABLE IF EXISTS `center_39_user`;
CREATE TABLE `center_39_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_40_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_40_error_data`;
CREATE TABLE `center_40_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_40_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_40_loginlog`;
CREATE TABLE `center_40_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_40_order
-- ----------------------------
DROP TABLE IF EXISTS `center_40_order`;
CREATE TABLE `center_40_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_40_user
-- ----------------------------
DROP TABLE IF EXISTS `center_40_user`;
CREATE TABLE `center_40_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_41_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_41_error_data`;
CREATE TABLE `center_41_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_41_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_41_loginlog`;
CREATE TABLE `center_41_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_41_order
-- ----------------------------
DROP TABLE IF EXISTS `center_41_order`;
CREATE TABLE `center_41_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_41_user
-- ----------------------------
DROP TABLE IF EXISTS `center_41_user`;
CREATE TABLE `center_41_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_42_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_42_error_data`;
CREATE TABLE `center_42_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_42_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_42_loginlog`;
CREATE TABLE `center_42_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_42_order
-- ----------------------------
DROP TABLE IF EXISTS `center_42_order`;
CREATE TABLE `center_42_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_42_user
-- ----------------------------
DROP TABLE IF EXISTS `center_42_user`;
CREATE TABLE `center_42_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_43_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_43_error_data`;
CREATE TABLE `center_43_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_43_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_43_loginlog`;
CREATE TABLE `center_43_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_43_order
-- ----------------------------
DROP TABLE IF EXISTS `center_43_order`;
CREATE TABLE `center_43_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_43_user
-- ----------------------------
DROP TABLE IF EXISTS `center_43_user`;
CREATE TABLE `center_43_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_44_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_44_error_data`;
CREATE TABLE `center_44_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_44_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_44_loginlog`;
CREATE TABLE `center_44_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_44_order
-- ----------------------------
DROP TABLE IF EXISTS `center_44_order`;
CREATE TABLE `center_44_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_44_user
-- ----------------------------
DROP TABLE IF EXISTS `center_44_user`;
CREATE TABLE `center_44_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_45_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_45_error_data`;
CREATE TABLE `center_45_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_45_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_45_loginlog`;
CREATE TABLE `center_45_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_45_order
-- ----------------------------
DROP TABLE IF EXISTS `center_45_order`;
CREATE TABLE `center_45_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_45_user
-- ----------------------------
DROP TABLE IF EXISTS `center_45_user`;
CREATE TABLE `center_45_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_46_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_46_error_data`;
CREATE TABLE `center_46_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_46_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_46_loginlog`;
CREATE TABLE `center_46_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_46_order
-- ----------------------------
DROP TABLE IF EXISTS `center_46_order`;
CREATE TABLE `center_46_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_46_user
-- ----------------------------
DROP TABLE IF EXISTS `center_46_user`;
CREATE TABLE `center_46_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_47_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_47_error_data`;
CREATE TABLE `center_47_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_47_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_47_loginlog`;
CREATE TABLE `center_47_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_47_order
-- ----------------------------
DROP TABLE IF EXISTS `center_47_order`;
CREATE TABLE `center_47_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_47_user
-- ----------------------------
DROP TABLE IF EXISTS `center_47_user`;
CREATE TABLE `center_47_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_48_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_48_error_data`;
CREATE TABLE `center_48_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_48_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_48_loginlog`;
CREATE TABLE `center_48_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_48_order
-- ----------------------------
DROP TABLE IF EXISTS `center_48_order`;
CREATE TABLE `center_48_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_48_user
-- ----------------------------
DROP TABLE IF EXISTS `center_48_user`;
CREATE TABLE `center_48_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_49_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_49_error_data`;
CREATE TABLE `center_49_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_49_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_49_loginlog`;
CREATE TABLE `center_49_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_49_order
-- ----------------------------
DROP TABLE IF EXISTS `center_49_order`;
CREATE TABLE `center_49_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_49_user
-- ----------------------------
DROP TABLE IF EXISTS `center_49_user`;
CREATE TABLE `center_49_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_50_error_data
-- ----------------------------
DROP TABLE IF EXISTS `center_50_error_data`;
CREATE TABLE `center_50_error_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT 'end表的id',
  `created_at` int(10) NOT NULL DEFAULT 0 COMMENT 'add time',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1：未处理，2：已处理。',
  `error_id` int(2) NOT NULL DEFAULT 0 COMMENT '1：网站id不存在，2：游戏不存在，3：用户不存在。',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `error_id`(`error_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_50_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `center_50_loginlog`;
CREATE TABLE `center_50_loginlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '登陆、退出时间',
  `ip` bigint(15) NOT NULL COMMENT '操作IP',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `orders_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始返回数据',
  `typeid` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型，1为登陆，2为退出',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `game_id` int(10) NOT NULL DEFAULT 0 COMMENT '游戏ID',
  `order_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商户订单号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_50_order
-- ----------------------------
DROP TABLE IF EXISTS `center_50_order`;
CREATE TABLE `center_50_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(15) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `site_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属网站ID',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '归属平台ID',
  `game_id` int(8) NOT NULL DEFAULT 0 COMMENT '归属游戏ID',
  `money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '投注金额',
  `win_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '盈利余额',
  `bet_money` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '有效投注金额',
  `detailed` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏详细信息',
  `infos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '原始数据',
  `oid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '平台注单ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '记录时间',
  `service_id` int(10) NOT NULL DEFAULT 0 COMMENT '数据归属服务器,由服务器拉取时使用',
  `now_uid` bigint(15) NULL DEFAULT NULL,
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT 'games类型id',
  `platform_and_type` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台ID和games的类型',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `win_money`(`win_money`) USING BTREE,
  INDEX `bet_money`(`bet_money`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `now_uid`(`now_uid`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `platform_and_type`(`platform_and_type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_50_user
-- ----------------------------
DROP TABLE IF EXISTS `center_50_user`;
CREATE TABLE `center_50_user`  (
  `id` bigint(15) NOT NULL AUTO_INCREMENT COMMENT '站点ID+用户IDD 11位UID',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '游戏中的用户名',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站ID',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `ip` bigint(15) NOT NULL COMMENT 'IP地址',
  `old_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原始网站的用户名',
  `end_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次操作时间',
  `uid` bigint(11) NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `balance` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '用户余额',
  PRIMARY KEY (`id`, `uid`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `balance`(`balance`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for center_api
-- ----------------------------
DROP TABLE IF EXISTS `center_api`;
CREATE TABLE `center_api`  (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `api_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '接口KEY',
  `api_secret` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '接口码',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '状态，1为正常，2为关闭',
  `ip` bigint(15) NOT NULL COMMENT '支持IP',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '增加时间',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '归属的网站ID',
  `service_id` int(5) NOT NULL DEFAULT 0 COMMENT '接口归属服务器，0为外部网站，如果是内部网站，则批量获得数据',
  `service_data_status` int(1) NOT NULL DEFAULT 0 COMMENT '是否允许按服务器抓取注单数据，1为允许，其他为不允许',
  `wallet` decimal(14, 4) NOT NULL DEFAULT 0.0000 COMMENT '钱包',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `service_data_status`(`service_data_status`) USING BTREE,
  INDEX `ap_ikey`(`api_key`) USING BTREE,
  INDEX `wallet`(`wallet`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of center_api
-- ----------------------------
INSERT INTO `center_api` VALUES (1, 'UmRFskfrT7kA', 'tDht5acbLYj52WLGY7QELGaJw7Kjy64W', 1, 313554826, 0, 1, 1, 1, 50000.0000);

-- ----------------------------
-- Table structure for center_api_log
-- ----------------------------
DROP TABLE IF EXISTS `center_api_log`;
CREATE TABLE `center_api_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `add_time` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '添加时间',
  `api_id` int(2) NOT NULL COMMENT 'api id',
  `platform_id` int(3) NOT NULL DEFAULT 0 COMMENT '平台id',
  `game_id` int(3) NOT NULL DEFAULT 0 COMMENT '游戏id',
  `site_id` int(5) NOT NULL DEFAULT 0 COMMENT '网站id',
  `service_id` int(5) NOT NULL DEFAULT 0 COMMENT '服务器id',
  `money` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '操作金额',
  `type_id` int(1) NULL DEFAULT NULL COMMENT '1：增加。2：减少',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `api_id`(`api_id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `game_id`(`game_id`) USING BTREE,
  INDEX `site_id`(`site_id`) USING BTREE,
  INDEX `service_id`(`service_id`) USING BTREE,
  INDEX `money`(`money`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1375 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for center_endlog
-- ----------------------------
DROP TABLE IF EXISTS `center_endlog`;
CREATE TABLE `center_endlog`  (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '平台ID或者自定ID',
  `up_time` int(10) NOT NULL DEFAULT 0 COMMENT '最后一次数据更新时间',
  `log_end_info` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '自定义记录信息',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `up_time`(`up_time`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11002 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of center_endlog
-- ----------------------------
INSERT INTO `center_endlog` VALUES (2001, 1573724341, NULL);
INSERT INTO `center_endlog` VALUES (3005, 1573724447, NULL);
INSERT INTO `center_endlog` VALUES (3006, 1573724239, NULL);
INSERT INTO `center_endlog` VALUES (6001, 1573724362, NULL);
INSERT INTO `center_endlog` VALUES (7005, 1573724548, '');
INSERT INTO `center_endlog` VALUES (11001, 1573582301, NULL);
INSERT INTO `center_endlog` VALUES (6005, 1573724364, NULL);
INSERT INTO `center_endlog` VALUES (4001, 1573724340, NULL);
INSERT INTO `center_endlog` VALUES (1001, 1573724523, 'g2gCbgcAq16zEDmXBW0AAAAIMjc3NTYzODA|27756380');
INSERT INTO `center_endlog` VALUES (1002, 1573724522, 'g2gCbgcAMHKEaTyXBW0AAAAJNjMwMTI1OTc2|630125976');
INSERT INTO `center_endlog` VALUES (1003, 1573724521, 'g2gCbgcA5VO-wjSXBW0AAAARMzYxMzIxNzgxMzc5NjQyNDM|36132178137964243');
INSERT INTO `center_endlog` VALUES (1004, 1573724523, 'g2gCbgcA2tUZRCOXBW0AAAAIMjc2OTAzMTQ|27690314');
INSERT INTO `center_endlog` VALUES (5001, 1573724344, NULL);
INSERT INTO `center_endlog` VALUES (8006, 1573724543, '50142793');
INSERT INTO `center_endlog` VALUES (10001, 1573724245, NULL);
INSERT INTO `center_endlog` VALUES (3012, 1573724439, NULL);
INSERT INTO `center_endlog` VALUES (3013, 1573724443, NULL);
INSERT INTO `center_endlog` VALUES (3015, 1573724445, NULL);
INSERT INTO `center_endlog` VALUES (3011, 1573724437, NULL);
INSERT INTO `center_endlog` VALUES (3030, 1573723812, NULL);
INSERT INTO `center_endlog` VALUES (3038, 1573724239, NULL);
INSERT INTO `center_endlog` VALUES (3631, 1567405095, NULL);
INSERT INTO `center_endlog` VALUES (6030, 1573724362, NULL);
INSERT INTO `center_endlog` VALUES (6031, 1573724362, NULL);
INSERT INTO `center_endlog` VALUES (9001, 1573724364, NULL);

-- ----------------------------
-- Table structure for center_framework_count
-- ----------------------------
DROP TABLE IF EXISTS `center_framework_count`;
CREATE TABLE `center_framework_count`  (
  `name` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `count` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of center_framework_count
-- ----------------------------
INSERT INTO `center_framework_count` VALUES ('adminlog', 371);
INSERT INTO `center_framework_count` VALUES ('model', 2);
INSERT INTO `center_framework_count` VALUES ('admin', 0);
INSERT INTO `center_framework_count` VALUES ('admingroup', 0);
INSERT INTO `center_framework_count` VALUES ('user', 4659);
INSERT INTO `center_framework_count` VALUES ('ad_position', 2);
INSERT INTO `center_framework_count` VALUES ('touzhu', 1);
INSERT INTO `center_framework_count` VALUES ('ad', 6);
INSERT INTO `center_framework_count` VALUES ('usergroup', 1);
INSERT INTO `center_framework_count` VALUES ('agentgroup', 1);
INSERT INTO `center_framework_count` VALUES ('catid', 189);
INSERT INTO `center_framework_count` VALUES ('notice', 8);
INSERT INTO `center_framework_count` VALUES ('code', 3577);
INSERT INTO `center_framework_count` VALUES ('goods', 1);
INSERT INTO `center_framework_count` VALUES ('click', 8147);
INSERT INTO `center_framework_count` VALUES ('fenhong', 33);
INSERT INTO `center_framework_count` VALUES ('money', 131);
INSERT INTO `center_framework_count` VALUES ('weixinmenu', 3);
INSERT INTO `center_framework_count` VALUES ('zhuanpan_log', 10);
INSERT INTO `center_framework_count` VALUES ('zt', 1);
INSERT INTO `center_framework_count` VALUES ('qianggou', 1);
INSERT INTO `center_framework_count` VALUES ('msg', 19);
INSERT INTO `center_framework_count` VALUES ('moneylog', 218);
INSERT INTO `center_framework_count` VALUES ('center', 4);
INSERT INTO `center_framework_count` VALUES ('task', 6);
INSERT INTO `center_framework_count` VALUES ('gonggao', 0);
INSERT INTO `center_framework_count` VALUES ('tasklog', 45);
INSERT INTO `center_framework_count` VALUES ('bank', 6);
INSERT INTO `center_framework_count` VALUES ('lock', 112);
INSERT INTO `center_framework_count` VALUES ('desk', 13);
INSERT INTO `center_framework_count` VALUES ('order', 193);
INSERT INTO `center_framework_count` VALUES ('pushmoney', 2);
INSERT INTO `center_framework_count` VALUES ('wanfa', 109);
INSERT INTO `center_framework_count` VALUES ('wanfa_type', 53);
INSERT INTO `center_framework_count` VALUES ('game', 7);
INSERT INTO `center_framework_count` VALUES ('0_adminlog', 4);
INSERT INTO `center_framework_count` VALUES ('games', 16);

-- ----------------------------
-- Table structure for center_framework_maxid
-- ----------------------------
DROP TABLE IF EXISTS `center_framework_maxid`;
CREATE TABLE `center_framework_maxid`  (
  `name` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `maxid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of center_framework_maxid
-- ----------------------------
INSERT INTO `center_framework_maxid` VALUES ('adminlog', 376);
INSERT INTO `center_framework_maxid` VALUES ('model', 5);
INSERT INTO `center_framework_maxid` VALUES ('admin', 6);
INSERT INTO `center_framework_maxid` VALUES ('admingroup', 9);
INSERT INTO `center_framework_maxid` VALUES ('user', 4660);
INSERT INTO `center_framework_maxid` VALUES ('baijiale', 55);
INSERT INTO `center_framework_maxid` VALUES ('touzhu', 1);
INSERT INTO `center_framework_maxid` VALUES ('ad_position', 4);
INSERT INTO `center_framework_maxid` VALUES ('ad', 10);
INSERT INTO `center_framework_maxid` VALUES ('usergroup', 1);
INSERT INTO `center_framework_maxid` VALUES ('agentgroup', 2);
INSERT INTO `center_framework_maxid` VALUES ('catid', 221);
INSERT INTO `center_framework_maxid` VALUES ('notice', 12);
INSERT INTO `center_framework_maxid` VALUES ('code', 3889);
INSERT INTO `center_framework_maxid` VALUES ('click', 8260);
INSERT INTO `center_framework_maxid` VALUES ('fenhong', 33);
INSERT INTO `center_framework_maxid` VALUES ('money', 131);
INSERT INTO `center_framework_maxid` VALUES ('weixinmenu', 3);
INSERT INTO `center_framework_maxid` VALUES ('zhuanpan_log', 11);
INSERT INTO `center_framework_maxid` VALUES ('zt', 2);
INSERT INTO `center_framework_maxid` VALUES ('qianggou', 1);
INSERT INTO `center_framework_maxid` VALUES ('msg', 24);
INSERT INTO `center_framework_maxid` VALUES ('moneylog', 219);
INSERT INTO `center_framework_maxid` VALUES ('center', 30);
INSERT INTO `center_framework_maxid` VALUES ('task', 6);
INSERT INTO `center_framework_maxid` VALUES ('tasklog', 61);
INSERT INTO `center_framework_maxid` VALUES ('bank', 117);
INSERT INTO `center_framework_maxid` VALUES ('lock', 312637);
INSERT INTO `center_framework_maxid` VALUES ('desk', 14);
INSERT INTO `center_framework_maxid` VALUES ('order', 193);
INSERT INTO `center_framework_maxid` VALUES ('pushmoney', 2);
INSERT INTO `center_framework_maxid` VALUES ('wanfa', 2014);
INSERT INTO `center_framework_maxid` VALUES ('wanfa_type', 992);
INSERT INTO `center_framework_maxid` VALUES ('game', 48);
INSERT INTO `center_framework_maxid` VALUES ('0_adminlog', 4);
INSERT INTO `center_framework_maxid` VALUES ('games', 16);

-- ----------------------------
-- Table structure for center_games
-- ----------------------------
DROP TABLE IF EXISTS `center_games`;
CREATE TABLE `center_games`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `platform_id` int(5) NOT NULL DEFAULT 0 COMMENT '平台ID',
  `category_id` int(5) NULL DEFAULT NULL COMMENT '分类id',
  `game_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '游戏代码，进入游戏使用',
  `game_name_cn` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '简体中文游戏名',
  `game_name_en` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '英文游戏名',
  `game_name_tw` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '繁体中文游戏名',
  `pic` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '游戏图片地址',
  `module_id` int(10) NOT NULL DEFAULT 0 COMMENT '数字产品ID',
  `type_id` int(5) NOT NULL DEFAULT 0 COMMENT '类型ID，1为老虎机，2为棋牌，3为捕鱼，4为街机，5为真人，6为体育，7为电竞，8为彩票',
  `line_type` int(5) NOT NULL DEFAULT 0 COMMENT '线数，一般是3-5之间',
  `line` int(5) NOT NULL DEFAULT 0 COMMENT '中奖线数，老虎机使用',
  `min_money` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '最小投注金额',
  `max_money` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '最大投注金额',
  `rtp` decimal(5, 2) NOT NULL DEFAULT 0.00 COMMENT '回报率',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态，1为正常，2为维护，3为关闭',
  `hot` int(1) NOT NULL DEFAULT 0 COMMENT '热门状态，1为热门游戏',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '上线时间，3个月内的都是最新',
  `query_info` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '预设参数，按需使用',
  `screen` int(1) NOT NULL DEFAULT 2 COMMENT '横竖屏，1为竖屏，2为横屏',
  `pc` int(1) NOT NULL DEFAULT 1 COMMENT '支持PC电脑，1为支持，0为不支持',
  `wap` int(1) NOT NULL DEFAULT 1 COMMENT '支持手机WAP版，1为支持',
  `paixu` int(8) NULL DEFAULT NULL COMMENT '顯示顺序',
  `remarks` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `platform_id`(`platform_id`) USING BTREE,
  INDEX `module_id`(`module_id`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `line_type`(`line_type`) USING BTREE,
  INDEX `line`(`line`) USING BTREE,
  INDEX `min_money`(`min_money`) USING BTREE,
  INDEX `max_money`(`max_money`) USING BTREE,
  INDEX `rtp`(`rtp`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `hot`(`hot`) USING BTREE,
  INDEX `add_time`(`add_time`) USING BTREE,
  INDEX `screen`(`screen`) USING BTREE,
  INDEX `pc`(`pc`) USING BTREE,
  INDEX `wap`(`wap`) USING BTREE,
  INDEX `paixu`(`paixu`) USING BTREE,
  INDEX `category_id`(`category_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 831 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of center_games
-- ----------------------------
INSERT INTO `center_games` VALUES (1, 1, 26, 'bxjg', '变形金刚', 'Transformers', '變形金剛', '', 2001, 1, 5, 9, 0.10, 900.00, 96.10, 1, 0, 20173, '', 2, 1, 1, 1, '');
INSERT INTO `center_games` VALUES (2, 1, 26, 'mjxw', '摸金校尉', 'Grave Robbers', '摸金校尉', '', 2002, 1, 5, 9, 0.10, 900.00, 95.61, 1, 0, 20173, '', 2, 1, 1, 2, '');
INSERT INTO `center_games` VALUES (3, 1, 26, 'jg', '金刚', 'King Kong', '金剛', '', 2003, 1, 5, 9, 0.10, 900.00, 95.67, 1, 0, 20173, '', 2, 1, 1, 3, '');
INSERT INTO `center_games` VALUES (4, 1, 26, 'tjr', '淘金热', 'Gold Rush', '淘金熱', '', 2004, 1, 5, 9, 0.10, 900.00, 95.89, 1, 0, 20173, '', 2, 1, 1, 4, '');
INSERT INTO `center_games` VALUES (5, 1, 26, 'Route66', '66路', 'Route 66', '66路', '', 2005, 1, 5, 9, 0.10, 900.00, 96.17, 1, 0, 20173, '', 2, 1, 1, 5, '');
INSERT INTO `center_games` VALUES (6, 1, 26, 'azteke', '阿兹特克', 'Azteke', '阿茲特克', '', 2006, 1, 5, 9, 0.10, 900.00, 95.64, 1, 0, 20173, '', 2, 1, 1, 6, '');
INSERT INTO `center_games` VALUES (7, 1, 26, 'Egypt', '埃及', 'Egypt', '埃及', '', 2007, 1, 5, 9, 0.10, 900.00, 95.54, 1, 0, 20173, '', 2, 1, 1, 7, '');
INSERT INTO `center_games` VALUES (8, 1, 26, 'kh', '狂欢', 'Carnival', '狂歡', '', 2008, 1, 5, 9, 0.10, 900.00, 95.58, 1, 0, 20173, '', 2, 1, 1, 8, '');
INSERT INTO `center_games` VALUES (9, 1, 26, 'zsjtq', '中世纪特权', 'Medieval Thrones', '中世紀特權', '', 2009, 1, 5, 9, 0.10, 900.00, 95.77, 1, 0, 20173, '', 2, 1, 1, 9, '');
INSERT INTO `center_games` VALUES (10, 1, 26, 'dqdg', '大秦帝国', 'The Qin Empire', '大秦帝國', '', 2010, 1, 5, 9, 0.10, 900.00, 95.76, 1, 0, 20173, '', 2, 1, 1, 10, '');
INSERT INTO `center_games` VALUES (11, 1, 26, 'hyrz', '火影忍者', 'Naruto', '火影忍者', '', 2251, 1, 5, 25, 0.01, 250.00, 96.60, 1, 0, 20173, '', 2, 1, 1, 11, '');
INSERT INTO `center_games` VALUES (12, 1, 26, 'sg', '欢乐水果', 'Joyful Fruit', '歡樂水果', '', 2252, 1, 5, 9, 0.01, 90.00, 96.60, 1, 0, 20173, '', 2, 1, 1, 12, '');
INSERT INTO `center_games` VALUES (13, 1, 26, 'jtbw', '街头霸王', 'Street Fighter', '街頭霸王', '', 2253, 1, 5, 25, 0.01, 250.00, 96.60, 1, 0, 20173, '', 2, 1, 1, 13, '');
INSERT INTO `center_games` VALUES (14, 1, 26, 'zjsn', '战舰少女', 'Warship Maiden', '戰艦少女', '', 2254, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20173, '', 2, 1, 1, 14, '');
INSERT INTO `center_games` VALUES (15, 1, 26, 'zgf', '东方国度', 'Eastern Countries', '東方國度', '', 2255, 1, 5, 9, 0.01, 90.00, 96.68, 1, 0, 20173, '', 2, 1, 1, 15, '');
INSERT INTO `center_games` VALUES (16, 1, 26, 'nz', '西部牛仔', 'Western Cowboy', '西部牛仔', '', 2256, 1, 5, 9, 0.01, 90.00, 96.68, 1, 0, 20173, '', 2, 1, 1, 16, '');
INSERT INTO `center_games` VALUES (17, 1, 26, 'hxdl', '幻想大陆', 'Fantasy Earth', '幻想大陸', '', 2257, 1, 5, 25, 0.01, 250.00, 96.60, 1, 0, 20173, '', 2, 1, 1, 17, '');
INSERT INTO `center_games` VALUES (18, 1, 26, 'wjs', '拉斯维加斯', 'Las Vegas', '拉斯維加斯', '', 2258, 1, 5, 25, 0.01, 250.00, 96.60, 1, 0, 20173, '', 2, 1, 1, 18, '');
INSERT INTO `center_games` VALUES (19, 1, 26, 'nz2', '荒野大镖客', 'Wilderness Escort', '荒野大鏢客', '', 2259, 1, 5, 25, 0.01, 250.00, 96.60, 1, 0, 20173, '', 2, 1, 1, 19, '');
INSERT INTO `center_games` VALUES (20, 1, 26, 'mny', '埃及艳后', 'Cleopatra', '埃及豔後', '', 2260, 1, 5, 25, 0.01, 250.00, 96.60, 1, 0, 20173, '', 2, 1, 1, 20, '');
INSERT INTO `center_games` VALUES (21, 1, 26, 'xj', '仙剑', 'Xian Jian', '仙劍', '', 2501, 1, 5, 9, 0.01, 90.00, 97.11, 1, 0, 20173, '', 2, 1, 1, 21, '');
INSERT INTO `center_games` VALUES (22, 1, 26, 'myxj', '梦游仙境', 'Alice', '夢遊仙境', '', 2502, 1, 5, 9, 0.01, 90.00, 95.16, 1, 0, 20173, '', 2, 1, 1, 22, '');
INSERT INTO `center_games` VALUES (23, 1, 26, '80tlx', '80天旅行', '80 Days Travel', '80天旅行', '', 2503, 1, 5, 9, 0.01, 90.00, 97.11, 1, 0, 20173, '', 2, 1, 1, 23, '');
INSERT INTO `center_games` VALUES (24, 1, 26, 'hdcf', '海盗财富', 'Pirates Fortune', '海盜財富', '', 2504, 1, 5, 9, 0.01, 90.00, 97.02, 1, 0, 20173, '', 2, 1, 1, 24, '');
INSERT INTO `center_games` VALUES (25, 1, 26, 'xy', '西游', 'Xi You', '西遊', '', 2505, 1, 5, 20, 0.01, 200.00, 97.02, 1, 0, 20173, '', 2, 1, 1, 25, '');
INSERT INTO `center_games` VALUES (26, 1, 26, 'bsz', '白蛇传', 'Bai She Zhuan', '白蛇傳', '', 2506, 1, 5, 20, 0.01, 200.00, 97.02, 1, 0, 20173, '', 2, 1, 1, 26, '');
INSERT INTO `center_games` VALUES (27, 1, 26, 'zhw', '指环王', 'Lord Of The Ring', '指環王', '', 2507, 1, 5, 20, 0.01, 200.00, 97.02, 1, 0, 20173, '', 2, 1, 1, 27, '');
INSERT INTO `center_games` VALUES (28, 1, 26, 'fsb', '封神榜', 'Feng Shen Bang', '封神榜', '', 2508, 1, 5, 25, 0.01, 250.00, 96.63, 1, 0, 20173, '', 2, 1, 1, 28, '');
INSERT INTO `center_games` VALUES (29, 1, 26, 'rywz', '荣耀王者', 'King Of Glory', '榮耀王者', '', 2509, 1, 5, 25, 0.01, 250.00, 97.02, 1, 0, 20173, '', 2, 1, 1, 29, '');
INSERT INTO `center_games` VALUES (30, 1, 26, 'gwmy', '怪物命运', 'Freaks Fortune', '怪物命運', '', 2510, 1, 5, 9, 0.01, 90.00, 95.16, 1, 0, 20173, '', 2, 1, 1, 30, '');
INSERT INTO `center_games` VALUES (31, 1, 26, 'Eiffel', '埃菲尔', 'Eiffel', '埃菲爾', '', 2011, 1, 5, 9, 0.10, 900.00, 95.88, 1, 0, 20174, '', 2, 1, 1, 31, '');
INSERT INTO `center_games` VALUES (32, 1, 26, 'Nysymbols', '新年符号', 'Ny Symbols', '新年符號', '', 2012, 1, 5, 9, 0.10, 900.00, 95.38, 1, 0, 20174, '', 2, 1, 1, 32, '');
INSERT INTO `center_games` VALUES (33, 1, 26, 'Pinup', '性感女神', 'Marilyn Monroe', '性感女神', '', 2013, 1, 5, 25, 0.10, 2500.00, 95.44, 1, 0, 20174, '', 2, 1, 1, 33, '');
INSERT INTO `center_games` VALUES (34, 1, 26, 'Doomsday', '世界末日', 'Doomsday', '世界末日', '', 2014, 1, 5, 9, 0.10, 900.00, 95.80, 1, 0, 20174, '', 2, 1, 1, 34, '');
INSERT INTO `center_games` VALUES (35, 1, 26, 'Mowf', '现代战争', 'Modern War', '現代戰爭', '', 2015, 1, 5, 9, 0.10, 900.00, 95.89, 1, 0, 20174, '', 2, 1, 1, 35, '');
INSERT INTO `center_games` VALUES (36, 1, 26, 'Lushwater', '甜水绿洲', 'Sweet Water Oasis', '甜水綠洲', '', 2016, 1, 5, 9, 0.10, 900.00, 95.54, 1, 0, 20174, '', 2, 1, 1, 36, '');
INSERT INTO `center_games` VALUES (37, 1, 26, 'Pirates', '加勒比海盗', 'Caribbean Pirates', '加勒比海盜', '', 2017, 1, 5, 9, 0.10, 900.00, 95.82, 1, 0, 20174, '', 2, 1, 1, 37, '');
INSERT INTO `center_games` VALUES (38, 1, 26, 'Panda', '功夫熊猫', 'Kung Fu Panda', '功夫熊貓', '', 2018, 1, 5, 25, 0.10, 2500.00, 95.75, 1, 0, 20174, '', 2, 1, 1, 38, '');
INSERT INTO `center_games` VALUES (39, 1, 26, 'Jurassic', '侏罗纪', 'Jurassic', '侏羅紀', '', 2019, 1, 5, 25, 0.10, 2500.00, 95.43, 1, 0, 20174, '', 2, 1, 1, 39, '');
INSERT INTO `center_games` VALUES (40, 1, 26, 'PVZ', '植物大战僵尸', 'PVZ', '植物大戰僵屍', '', 2020, 1, 5, 25, 0.10, 2500.00, 95.65, 1, 0, 20174, '', 2, 1, 1, 40, '');
INSERT INTO `center_games` VALUES (41, 1, 26, 'Watch', '守望英雄', 'Overwatch', '守望英雄', '', 2021, 1, 5, 25, 0.10, 2500.00, 95.56, 1, 0, 20174, '', 2, 1, 1, 41, '');
INSERT INTO `center_games` VALUES (42, 1, 26, 'Avatar', '阿凡达', 'Avatar', '阿凡達', '', 2022, 1, 5, 25, 0.10, 2500.00, 95.87, 1, 0, 20174, '', 2, 1, 1, 42, '');
INSERT INTO `center_games` VALUES (43, 1, 26, 'xlcs', '希腊传说', 'Greek Legend', '希臘傳說', '', 2261, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20174, '', 2, 1, 1, 43, '');
INSERT INTO `center_games` VALUES (44, 1, 26, 'xxgpklr', '吸血鬼PK狼人', 'Bloodz VS Wolvez', '吸血鬼PK狼人', '', 2262, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20174, '', 2, 1, 1, 44, '');
INSERT INTO `center_games` VALUES (45, 1, 26, 'mhxy', '梦幻西游', 'Dream Journey', '夢幻西遊', '', 2263, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20174, '', 2, 1, 1, 45, '');
INSERT INTO `center_games` VALUES (46, 1, 26, 'nxzqd', '女校足球队', 'Girls Football', '女校足球隊', '', 2264, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20174, '', 2, 1, 1, 46, '');
INSERT INTO `center_games` VALUES (47, 1, 26, 'nxglq', '女校橄榄球', 'Girls Rugby', '女校橄欖球', '', 2265, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20174, '', 2, 1, 1, 47, '');
INSERT INTO `center_games` VALUES (48, 1, 26, 'nxjdb', '女校剑道部', 'Girls Kendo Club', '女校劍道部', '', 2266, 1, 5, 25, 0.01, 250.00, 96.60, 1, 0, 20174, '', 2, 1, 1, 48, '');
INSERT INTO `center_games` VALUES (49, 1, 26, 'wsgyc', '武圣关云长', 'Guan Yun Chang', '武聖關雲長', '', 2267, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20174, '', 2, 1, 1, 49, '');
INSERT INTO `center_games` VALUES (50, 1, 26, 'ckxt', '刺客信条', 'Assassins Creed', '刺客信條', '', 2268, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20174, '', 2, 1, 1, 50, '');
INSERT INTO `center_games` VALUES (51, 1, 26, 'gmly', '古墓丽影', 'Tomb Raider', '古墓麗影', '', 2269, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20174, '', 2, 1, 1, 51, '');
INSERT INTO `center_games` VALUES (52, 1, 26, 'lyxz', '绿野仙踪', 'The Wizard Of Oz', '綠野仙蹤', '', 2270, 1, 5, 25, 0.01, 250.00, 96.60, 1, 0, 20174, '', 2, 1, 1, 52, '');
INSERT INTO `center_games` VALUES (53, 1, 26, 'jxqy', '剑侠情缘', 'Sword Heroes', '劍俠情緣', '', 2271, 1, 5, 25, 0.01, 250.00, 96.60, 1, 0, 20174, '', 2, 1, 1, 53, '');
INSERT INTO `center_games` VALUES (54, 1, 26, 'gdzw', '格斗之王', 'King Of Fighters', '格鬥之王', '', 2272, 1, 5, 25, 0.01, 250.00, 96.60, 1, 0, 20174, '', 2, 1, 1, 54, '');
INSERT INTO `center_games` VALUES (55, 1, 26, 'hzzh', '黑珍珠号', 'Black Pearl', '黑珍珠號', '', 2511, 1, 5, 25, 0.01, 250.00, 96.63, 1, 0, 20174, '', 2, 1, 1, 55, '');
INSERT INTO `center_games` VALUES (56, 1, 26, 'frnc', '富饶农场', 'Rich Farm', '富饒農場', '', 2512, 1, 5, 25, 0.01, 250.00, 96.62, 1, 0, 20174, '', 2, 1, 1, 56, '');
INSERT INTO `center_games` VALUES (57, 1, 26, 'my', '玛雅', 'Maya', '瑪雅', '', 2513, 1, 5, 25, 0.01, 250.00, 96.19, 1, 0, 20174, '', 2, 1, 1, 57, '');
INSERT INTO `center_games` VALUES (58, 1, 26, 'yda', '印第安', 'India Dreams', '印第安', '', 2514, 1, 5, 25, 0.01, 250.00, 96.30, 1, 0, 20174, '', 2, 1, 1, 58, '');
INSERT INTO `center_games` VALUES (59, 1, 26, 'smdf', '神秘东方', 'Mysterious East', '神秘東方', '', 2515, 1, 5, 25, 0.01, 250.00, 96.19, 1, 0, 20174, '', 2, 1, 1, 59, '');
INSERT INTO `center_games` VALUES (60, 1, 26, 'zz', '战争', 'Tanks', '戰爭', '', 2516, 1, 5, 9, 0.01, 90.00, 96.10, 1, 0, 20174, '', 2, 1, 1, 60, '');
INSERT INTO `center_games` VALUES (61, 1, 26, 'nznh', '哪吒闹海', 'Ne Zha Nao Hai', '哪吒鬧海', '', 2517, 1, 5, 30, 0.01, 300.00, 96.30, 1, 0, 20174, '', 2, 1, 1, 61, '');
INSERT INTO `center_games` VALUES (62, 1, 26, 'qxqy', '七夕情缘', 'Tanabata Love', '七夕情緣', '', 2518, 1, 5, 9, 0.01, 90.00, 96.30, 1, 0, 20174, '', 2, 1, 1, 62, '');
INSERT INTO `center_games` VALUES (63, 1, 26, 'sdmn', '四大美女', 'Four Beauties', '四大美女', '', 2519, 1, 5, 30, 0.01, 300.00, 96.39, 1, 0, 20174, '', 2, 1, 1, 63, '');
INSERT INTO `center_games` VALUES (64, 1, 26, 'jpm', '金瓶梅', 'Jin Ping Mei', '金瓶梅', '', 2520, 1, 5, 40, 0.01, 400.00, 96.30, 1, 0, 20174, '', 2, 1, 1, 64, '');
INSERT INTO `center_games` VALUES (65, 1, 26, 'hlm', '红楼梦', 'Hong Lou Meng', '紅樓夢', '', 2521, 1, 5, 9, 0.01, 90.00, 96.30, 1, 0, 20174, '', 2, 1, 1, 65, '');
INSERT INTO `center_games` VALUES (66, 1, 26, 'wsdf', '武松打虎', 'Wu Song Da Hu', '武松打虎', '', 2522, 1, 5, 25, 0.01, 250.00, 96.30, 1, 0, 20174, '', 2, 1, 1, 66, '');
INSERT INTO `center_games` VALUES (67, 1, 26, 'sst', '女校游泳队', 'Girls Swim Team', '女校游泳隊', '', 3101, 1, 5, 15, 0.01, 150.00, 97.06, 1, 0, 20174, '', 2, 1, 1, 67, '');
INSERT INTO `center_games` VALUES (68, 1, 26, 'scs', '女校啦啦队', 'Cheerleaders', '女校啦啦隊', '', 3102, 1, 5, 15, 0.01, 150.00, 97.06, 1, 0, 20174, '', 2, 1, 1, 68, '');
INSERT INTO `center_games` VALUES (69, 1, 26, 'sgt', '女校体操队', 'Girls Gymnastics', '女校體操隊', '', 3103, 1, 5, 25, 0.01, 250.00, 97.06, 1, 0, 20174, '', 2, 1, 1, 69, '');
INSERT INTO `center_games` VALUES (70, 1, 26, 'wtlbb', '天龙八部', 'Tian Long Ba Bu', '天龍八部', '', 3201, 1, 5, 9, 0.01, 90.00, 96.36, 1, 0, 20174, '', 2, 1, 1, 70, '');
INSERT INTO `center_games` VALUES (71, 1, 26, 'wldj', '鹿鼎记', 'Lu Ding Ji', '鹿鼎記', '', 3202, 1, 5, 15, 0.01, 150.00, 96.36, 1, 0, 20174, '', 2, 1, 1, 71, '');
INSERT INTO `center_games` VALUES (72, 1, 26, 'wxajh', '笑傲江湖', 'Swordsman', '笑傲江湖', '', 3203, 1, 5, 25, 0.01, 250.00, 96.88, 1, 0, 20174, '', 2, 1, 1, 72, '');
INSERT INTO `center_games` VALUES (73, 1, 26, 'wsdxl', '神雕侠侣', 'Shen Diao Xia Lv', '神雕俠侶', '', 3204, 1, 5, 243, 0.50, 500.00, 96.83, 1, 0, 20174, '', 2, 1, 1, 73, '');
INSERT INTO `center_games` VALUES (74, 1, 26, 'mlfm', '幸运水果机', 'Lucky Fruit', '幸運水果機', '', 3301, 1, 3, 1, 0.50, 50.00, 97.08, 1, 0, 20174, '', 2, 1, 1, 74, '');
INSERT INTO `center_games` VALUES (75, 1, 26, 'mdl', '钻石之恋', 'Diamond Love', '鑽石之戀', '', 3302, 1, 5, 9, 0.01, 90.00, 96.33, 1, 0, 20174, '', 2, 1, 1, 75, '');
INSERT INTO `center_games` VALUES (76, 1, 26, 'mmm', '众神之王', 'Zeus', '眾神之王', '', 3303, 1, 5, 243, 0.50, 500.00, 96.83, 1, 0, 20174, '', 2, 1, 1, 76, '');
INSERT INTO `center_games` VALUES (77, 1, 26, 'mpg', '粉红女郎', 'Pink Lady', '粉紅女郎', '', 3304, 1, 5, 243, 0.50, 500.00, 96.93, 1, 0, 20174, '', 2, 1, 1, 77, '');
INSERT INTO `center_games` VALUES (78, 1, 26, 'mpjs', '鸟叔', 'PSY', '鳥叔', '', 3305, 1, 5, 243, 0.50, 500.00, 96.93, 1, 0, 20174, '', 2, 1, 1, 78, '');
INSERT INTO `center_games` VALUES (79, 1, 26, 'Constellation', '十二星座', 'Constellation', '十二星座', '', 2023, 1, 5, 25, 0.10, 2500.00, 95.86, 1, 0, 20181, '', 2, 1, 1, 79, '');
INSERT INTO `center_games` VALUES (80, 1, 26, 'Zodiac', '十二生肖', 'Chinese Zodiac', '十二生肖', '', 2024, 1, 5, 243, 5.00, 5000.00, 95.93, 1, 0, 20181, '', 2, 1, 1, 80, '');
INSERT INTO `center_games` VALUES (81, 1, 26, 'Angrybirds', '愤怒的小鸟', 'Angry Birds', '憤怒的小鳥', '', 2025, 1, 5, 25, 0.10, 2500.00, 95.87, 1, 0, 20181, '', 2, 1, 1, 81, '');
INSERT INTO `center_games` VALUES (82, 1, 26, 'Fishing', '捕鱼达人', 'Fishing Joy', '捕魚達人', '', 2026, 1, 5, 25, 0.10, 2500.00, 95.91, 1, 0, 20181, '', 2, 1, 1, 82, '');
INSERT INTO `center_games` VALUES (83, 1, 26, 'rgyc', '瑞狗迎春', 'Lucky Dog', '瑞狗迎春', '', 2273, 1, 5, 243, 0.50, 500.00, 96.60, 1, 0, 20181, '', 2, 1, 1, 83, '');
INSERT INTO `center_games` VALUES (84, 1, 26, 'gtmymn', '哥谭魅影猫女', 'Catwoman', '哥譚魅影貓女', '', 2274, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20181, '', 2, 1, 1, 84, '');
INSERT INTO `center_games` VALUES (85, 1, 26, 'zcjb', '招财进宝', 'Zhao Cai Jin Bao', '招財進寶', '', 2275, 1, 5, 9, 0.01, 90.00, 96.68, 1, 0, 20181, '', 2, 1, 1, 85, '');
INSERT INTO `center_games` VALUES (86, 1, 26, 'xsjr', '湛蓝深海', 'Great Blue', '湛藍深海', '', 2276, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20181, '', 2, 1, 1, 86, '');
INSERT INTO `center_games` VALUES (87, 1, 26, 'jgwc', '金狗旺财', 'Jin Gou Wang Cai', '金狗旺財', '', 2523, 1, 5, 25, 0.01, 250.00, 96.19, 1, 0, 20181, '', 2, 1, 1, 87, '');
INSERT INTO `center_games` VALUES (88, 1, 26, 'ghxc', '恭贺新春', 'Gong He Xin Chun', '恭賀新春', '', 2525, 1, 5, 60, 0.01, 600.00, 96.19, 1, 0, 20181, '', 2, 1, 1, 88, '');
INSERT INTO `center_games` VALUES (89, 1, 26, 'jiaods', '角斗士', 'Gladiatus', '角鬥士', '', 2526, 1, 5, 40, 0.01, 400.00, 96.16, 1, 0, 20181, '', 2, 1, 1, 89, '');
INSERT INTO `center_games` VALUES (90, 1, 26, 'aijinw', '埃及女王', 'Egypt Queen', '埃及女王', '', 2527, 1, 5, 25, 0.01, 250.00, 96.16, 1, 0, 20181, '', 2, 1, 1, 90, '');
INSERT INTO `center_games` VALUES (91, 1, 26, 'msd', '灌篮高手', 'Slamdunk', '灌籃高手', '', 3306, 1, 5, 243, 0.50, 500.00, 97.11, 1, 0, 20181, '', 2, 1, 1, 91, '');
INSERT INTO `center_games` VALUES (92, 1, 26, 'mqhb', '抢红包', 'Qiang Hong Bao', '搶紅包', '', 3307, 1, 5, 100, 1.00, 1000.00, 96.88, 1, 1, 20181, '', 2, 1, 1, 92, '');
INSERT INTO `center_games` VALUES (93, 1, 26, 'mnys', '闹元宵', 'Lantern Festival', '鬧元宵', '', 3308, 1, 5, 9, 0.01, 90.00, 96.88, 1, 1, 20181, '', 2, 1, 1, 93, '');
INSERT INTO `center_games` VALUES (94, 1, 26, 'mslwh', '森林舞会', 'Forest Dance', '森林舞會', '', 3309, 1, 5, 40, 0.01, 400.00, 96.33, 1, 0, 20181, '', 2, 1, 1, 94, '');
INSERT INTO `center_games` VALUES (95, 1, 26, 'jqzb', '金球争霸', 'Golden Globe', '金球爭霸', '', 2277, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20182, '', 2, 1, 1, 95, '');
INSERT INTO `center_games` VALUES (96, 1, 26, 'hjyj', '黄金右脚', 'Golden Foot', '黃金右腳', '', 2278, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20182, '', 2, 1, 1, 96, '');
INSERT INTO `center_games` VALUES (97, 1, 26, 'sjbjxw', '世界杯吉祥物', 'Fifa World', '世界盃吉祥物', '', 2279, 1, 5, 25, 0.01, 250.00, 95.88, 1, 0, 20182, '', 2, 1, 1, 97, '');
INSERT INTO `center_games` VALUES (98, 1, 26, 'panpasixiongying', '潘帕斯雄鹰', 'Argentina', '潘帕斯雄鷹', '', 2528, 1, 5, 15, 0.10, 1500.00, 96.30, 1, 0, 20182, '', 2, 1, 1, 98, '');
INSERT INTO `center_games` VALUES (99, 1, 26, 'qunxshanyao', '群星闪耀', 'Stars Shine', '群星閃耀', '', 2529, 1, 5, 576, 5.00, 5000.00, 95.51, 1, 0, 20182, '', 2, 1, 1, 99, '');
INSERT INTO `center_games` VALUES (100, 1, 26, 'mjxzb', '金靴争霸', 'The Golden Boot', '金靴爭霸', '', 3310, 1, 5, 25, 0.01, 250.00, 96.68, 1, 0, 20182, '', 2, 1, 1, 100, '');
INSERT INTO `center_games` VALUES (101, 1, 26, 'mjqqm', '激情球迷', 'Passion Fans', '激情球迷', '', 3311, 1, 5, 25, 0.01, 250.00, 96.88, 1, 0, 20182, '', 2, 1, 1, 101, '');
INSERT INTO `center_games` VALUES (102, 1, 26, 'mjqsjb', '激情世界杯', 'World Cup', '激情世界盃', '', 3312, 1, 5, 25, 0.01, 250.00, 95.98, 1, 0, 20182, '', 2, 1, 1, 102, '');
INSERT INTO `center_games` VALUES (103, 1, 26, 'ryts', '人猿泰山', 'Tarzan', '人猿泰山', '', 2280, 1, 3, 1, 0.10, 100.00, 96.30, 1, 0, 20182, '', 2, 1, 1, 103, '');
INSERT INTO `center_games` VALUES (104, 1, 26, 'mczbz', '船长宝藏', 'Captain\'s Treasure', '船長寶藏', '', 3316, 1, 5, 9, 0.01, 90.00, 96.88, 1, 0, 20182, '', 2, 1, 1, 104, '');
INSERT INTO `center_games` VALUES (105, 1, 26, 'mcrazy7', '疯狂七', 'Crazy7', '疯狂七', '', 3313, 1, 3, 1, 0.10, 100.00, 97.36, 1, 0, 20183, '', 2, 1, 1, 105, '');
INSERT INTO `center_games` VALUES (106, 1, 26, 'qqh', '鹊桥会', 'Magpie Bridge', '鵲橋會', '', 2532, 1, 5, 25, 0.10, 2500.00, 96.66, 1, 0, 20183, '', 2, 1, 1, 106, '');
INSERT INTO `center_games` VALUES (107, 1, 26, 'mtitanic', '泰坦尼克号', 'Titanic', '泰坦尼克號', '', 3315, 1, 5, 243, 0.50, 500.00, 96.66, 1, 0, 20183, '', 2, 1, 1, 107, '');
INSERT INTO `center_games` VALUES (108, 1, 26, 'zzx', '蜘蛛侠', 'Spider Man', '蜘蛛俠', '', 2282, 1, 5, 25, 0.10, 2500.00, 96.66, 1, 0, 20183, '', 2, 1, 1, 108, '');
INSERT INTO `center_games` VALUES (109, 1, 26, 'fastf', '速度与激情', 'Fast & Furious', '速度與激情', '', 2281, 1, 5, 25, 0.10, 2500.00, 96.30, 1, 0, 20183, '', 2, 1, 1, 109, '');
INSERT INTO `center_games` VALUES (110, 1, 26, 'gghz', '古怪猴子', 'Funky Monkey', '古怪猴子', '', 2530, 1, 3, 1, 0.50, 50.00, 96.30, 1, 0, 20183, '', 2, 1, 1, 110, '');
INSERT INTO `center_games` VALUES (111, 1, 26, 'mboombeach', '海岛奇兵', 'BoomBeach', '海島奇兵', '', 3314, 1, 5, 9, 0.01, 90.00, 95.62, 1, 0, 0, '', 2, 1, 1, 111, '');
INSERT INTO `center_games` VALUES (112, 1, 26, 'party', '水果派对', 'Fruit_Party', '水果派對', '', 2531, 1, 5, 25, 0.10, 2500.00, 93.99, 1, 0, 20184, '', 2, 1, 1, 112, '');
INSERT INTO `center_games` VALUES (113, 1, 26, 'mcm', '百变猴子', 'WILDMonkey', '百變猴子', '', 3317, 1, 3, 5, 0.05, 500.00, 96.25, 1, 0, 20184, '', 2, 1, 1, 113, '');
INSERT INTO `center_games` VALUES (114, 1, 26, 'ny', '新年', 'New Year', '新年', '', 2283, 1, 5, 40, 0.01, 400.00, 94.94, 1, 0, 20191, '', 2, 1, 1, 114, '');
INSERT INTO `center_games` VALUES (115, 1, 26, 'dfdc', '多福多财', 'Bless&Wealth', '多福多財', '', 2284, 1, 5, 243, 0.50, 1000.00, 96.63, 1, 0, 20191, '', 2, 1, 1, 115, '');
INSERT INTO `center_games` VALUES (116, 1, 34, 'fish_mm', '美人捕鱼', 'Beauty Fishing', '美人捕魚', '', 5001, 3, 0, 0, 0.10, 990.00, 97.30, 1, 1, 20172, '', 2, 1, 1, 116, '');
INSERT INTO `center_games` VALUES (117, 1, 34, 'fish_zj', '雷霆战警', 'X-Men', '雷霆戰警', '', 5002, 3, 0, 0, 0.10, 990.00, 97.30, 1, 0, 20173, '', 2, 1, 1, 117, '');
INSERT INTO `center_games` VALUES (118, 1, 34, 'fish_bn', '捕鸟达人', 'Birds Hunter', '捕鳥達人', '', 5003, 3, 0, 0, 0.10, 990.00, 97.30, 1, 0, 20173, '', 2, 1, 1, 118, '');
INSERT INTO `center_games` VALUES (119, 1, 34, 'fish_hl', '欢乐捕鱼', 'Fish Reef', '歡樂捕魚', '', 5004, 3, 0, 0, 0.50, 500.00, 97.30, 1, 0, 20173, '', 2, 1, 1, 119, '');
INSERT INTO `center_games` VALUES (120, 1, 34, 'fish_tt', '天天捕鱼', 'Daily Fishing', '天天捕魚', '', 5005, 3, 0, 0, 0.10, 990.00, 97.30, 1, 0, 20173, '', 2, 1, 1, 120, '');
INSERT INTO `center_games` VALUES (121, 1, 34, 'fish_3D', '捕鱼嘉年华3D', 'Fishing Carnival 3D', '捕魚嘉年華3D', '', 5006, 3, 0, 0, 0.10, 990.00, 97.30, 1, 0, 20172, '', 2, 1, 1, 121, '');
INSERT INTO `center_games` VALUES (122, 1, 9, 'HB', '百人牛牛', 'Hundreds Of Bull', '百人牛牛', '', 6003, 2, 0, 0, 1.00, 50000.00, 95.00, 1, 0, 20173, '', 2, 1, 1, 122, '');
INSERT INTO `center_games` VALUES (123, 1, 9, 'rt', '皇家德州', 'Royal Texas', '皇家德州', '', 6004, 2, 0, 0, 5.00, 500.00, 95.00, 1, 0, 20174, '', 2, 1, 1, 123, '');
INSERT INTO `center_games` VALUES (124, 1, 9, 'tz', '骰宝', 'Sic Bo', '骰寶', '', 6005, 2, 0, 0, 5.00, 500.00, 95.00, 1, 1, 20174, '', 2, 1, 1, 124, '');
INSERT INTO `center_games` VALUES (125, 1, 9, 'bjl', '百家乐', 'Baccarat', '百家樂', '', 6006, 2, 0, 0, 5.00, 500.00, 95.00, 1, 1, 20174, '', 2, 1, 1, 125, '');
INSERT INTO `center_games` VALUES (126, 1, 9, 'RC', '皇家宫殿', 'Royal Palace', '皇家宮殿', '', 6002, 2, 0, 0, 5.00, 500.00, 95.00, 1, 0, 20174, '', 2, 1, 1, 126, '');
INSERT INTO `center_games` VALUES (127, 1, 9, 'jgf', '红黑大战', 'Redandblackwar', '紅黑大戰', '', 6008, 2, 0, 0, 5.00, 2000.00, 95.00, 1, 1, 20181, '', 2, 1, 1, 127, '');
INSERT INTO `center_games` VALUES (128, 1, 9, 'TexasCb', '德州牛仔', 'Texas Cowboy', '德州牛仔', '', 6009, 2, 0, 0, 5.00, 2000.00, 95.00, 1, 0, 20181, '', 2, 1, 1, 128, '');
INSERT INTO `center_games` VALUES (129, 1, 9, 'mj', '二人麻将', 'Two People Mahjong', '二人麻將', '', 6007, 2, 0, 0, 1.00, 10.00, 95.00, 1, 1, 20182, '', 2, 1, 1, 129, '');
INSERT INTO `center_games` VALUES (130, 1, 9, 'cqznn', '抢庄牛牛', 'Rob Banker Of Bull', '搶莊牛牛', '', 6501, 2, 0, 0, 1.00, 50.00, 95.00, 1, 1, 20182, '', 2, 1, 1, 130, '');
INSERT INTO `center_games` VALUES (131, 1, 9, 'csg', '三公', 'San_Gong', '三公', '', 6502, 2, 0, 0, 1.00, 50.00, 95.00, 1, 1, 20182, '', 2, 1, 1, 131, '');
INSERT INTO `center_games` VALUES (132, 1, 9, 'ddz', '斗地主', 'Landlords', '鬥地主', '', 6301, 2, 0, 0, 0.10, 48.00, 95.00, 1, 1, 20183, '', 2, 1, 1, 132, '');
INSERT INTO `center_games` VALUES (133, 1, 9, 'zjhdr', '经典炸金花', 'Classical Win Three Cards', '經典炸金花', '', 6302, 2, 0, 0, 1.00, 50.00, 95.00, 1, 1, 20183, '', 2, 1, 1, 133, '');
INSERT INTO `center_games` VALUES (134, 1, 9, 'ShowHand', '梭哈', 'Five-Card Poker', '梭哈', '', 6303, 2, 0, 0, 1.00, 50.00, 95.00, 1, 1, 20183, '', 2, 1, 1, 134, '');
INSERT INTO `center_games` VALUES (135, 1, 9, 'LuckyHand', '幸运手', 'Fortune Hand', '幸运手', '', 6503, 2, 0, 0, 1.00, 100.00, 95.00, 2, 0, 20183, '', 2, 1, 1, 135, '');
INSERT INTO `center_games` VALUES (136, 1, 9, 'tbnn', '通比牛牛', 'Tongbi Cattle', '通比牛牛', '', 6504, 2, 0, 0, 1.00, 100.00, 95.00, 1, 0, 20183, '', 2, 1, 1, 136, '');
INSERT INTO `center_games` VALUES (137, 1, 9, 'sss', '十三水', 'Open-face Chinese Poker', '十三水', '', 6011, 2, 0, 0, 2.00, 1620.00, 95.00, 1, 1, 20183, '', 2, 1, 1, 137, '');
INSERT INTO `center_games` VALUES (138, 1, 9, 'ebg', '二八杠', 'Mahjong', '二八杠', '', 6012, 2, 0, 0, 1.00, 9900.00, 95.00, 1, 0, 20183, '', 2, 1, 1, 138, '');
INSERT INTO `center_games` VALUES (139, 1, 9, 'qzpj', '抢庄牌九', 'Pai Gow', '搶莊牌九', '', 6013, 2, 0, 0, 1.00, 360.00, 95.00, 1, 0, 20183, '', 2, 1, 1, 139, '');
INSERT INTO `center_games` VALUES (140, 1, 9, 'jszjh', '极速炸金花', 'Topspeed Win Three Cards', '極速炸金花', '', 6014, 2, 0, 0, 2.00, 200.00, 95.00, 1, 0, 20183, '', 2, 1, 1, 140, '');
INSERT INTO `center_games` VALUES (141, 1, 9, 'iPoker', '欢乐德州', 'Fun Poker', '歡樂德州', '', 6666, 2, 0, 0, 0.00, 4.00, 95.00, 1, 0, 20183, '', 2, 1, 1, 141, '');
INSERT INTO `center_games` VALUES (142, 1, 9, 'hlhb', '欢乐红包', 'Happyredenvelopes', '歡樂紅包', '', 6506, 2, 0, 0, 20.00, 200.00, 95.00, 1, 1, 20191, '', 2, 1, 1, 142, '');
INSERT INTO `center_games` VALUES (143, 1, 26, 'frt', '水果机', 'Fruit', '水果機', '', 7000, 1, 0, 0, 1.00, 1000.00, 95.72, 1, 0, 20173, '', 2, 1, 1, 143, '');
INSERT INTO `center_games` VALUES (144, 1, 26, 'bbs', '飞禽走兽', 'Birds And Beasts', '飛禽走獸', '', 7001, 1, 0, 0, 10.00, 200.00, 94.71, 1, 0, 20173, '', 2, 1, 1, 144, '');
INSERT INTO `center_games` VALUES (145, 1, 26, 'bzb', '奔驰宝马', 'Benz And BMW', '奔驰寶馬', '', 7002, 1, 0, 0, 1.00, 1000.00, 95.72, 1, 1, 20173, '', 2, 1, 1, 145, '');
INSERT INTO `center_games` VALUES (146, 1, 26, 'fod', '森林舞会', 'Forest Dance', '森林舞會', '', 7003, 1, 0, 0, 10.00, 100.00, 96.45, 1, 0, 20173, '', 2, 1, 1, 146, '');
INSERT INTO `center_games` VALUES (147, 1, 26, 'con', '十二星座', 'Constellation', '十二星座', '', 7004, 1, 0, 0, 1.00, 500.00, 95.57, 1, 0, 20173, '', 2, 1, 1, 147, '');
INSERT INTO `center_games` VALUES (148, 1, 26, 'chz', '十二生肖', 'Chinese Zodiac', '十二生肖', '', 7005, 1, 0, 0, 1.00, 500.00, 95.57, 1, 0, 20173, '', 2, 1, 1, 148, '');
INSERT INTO `center_games` VALUES (149, 1, 26, 'bif', '燃烧吧，足球', 'Burn It Football', '燃燒吧，足球', '', 7006, 1, 0, 0, 1.00, 500.00, 92.71, 1, 0, 20173, '', 2, 1, 1, 149, '');
INSERT INTO `center_games` VALUES (150, 1, 26, 'pbb', '巅峰篮球', 'Peak Basketball', '巔峰籃球', '', 7007, 1, 0, 0, 1.00, 500.00, 92.71, 1, 0, 20173, '', 2, 1, 1, 150, '');
INSERT INTO `center_games` VALUES (151, 1, 26, 'gw', '黄金大转轮', 'Golden Whell', '黃金大轉輪', '', 7008, 1, 0, 0, 1.00, 1000.00, 92.88, 1, 0, 20174, '', 2, 1, 1, 151, '');
INSERT INTO `center_games` VALUES (152, 1, 26, 'fw', '水果转盘', 'Fruit Turntable', '水果轉盤', '', 7009, 1, 0, 0, 1.00, 1000.00, 96.68, 1, 0, 20174, '', 2, 1, 1, 152, '');
INSERT INTO `center_games` VALUES (153, 1, 26, 'hr', '赛马', 'Horse Race', '賽馬', '', 7010, 1, 0, 0, 1.00, 1000.00, 88.88, 1, 0, 20174, '', 2, 1, 1, 153, '');
INSERT INTO `center_games` VALUES (154, 1, 26, 'si', '连环夺宝', 'Serial Indiana', '連環奪寶', '', 7011, 1, 0, 0, 1.00, 100.00, 97.28, 1, 1, 20174, '', 2, 1, 1, 154, '');
INSERT INTO `center_games` VALUES (155, 1, 26, 'lucky', '幸运5', 'Lucky 5', '幸運5', '', 7012, 1, 0, 0, 1.00, 100.00, 97.28, 1, 0, 20174, '', 2, 1, 1, 155, '');
INSERT INTO `center_games` VALUES (156, 1, 26, 'gls', '好运射击', 'Luck Shooting', '好運射擊', '', 7014, 1, 0, 0, 0.10, 10.00, 97.28, 1, 0, 20174, '', 2, 1, 1, 156, '');
INSERT INTO `center_games` VALUES (157, 1, 26, 'mr', '猴子爬树', 'Monkey Race', '猴子爬樹', '', 7015, 1, 0, 0, 1.00, 1000.00, 96.25, 1, 0, 20181, '', 2, 1, 1, 157, '');
INSERT INTO `center_games` VALUES (158, 1, 26, 'fia', '浮岛历险记', 'Adventures', '浮島歷險記', '', 7016, 1, 0, 0, 15.00, 150.00, 96.28, 1, 0, 20181, '', 2, 1, 1, 158, '');
INSERT INTO `center_games` VALUES (159, 1, 26, 'fl', '水果传奇', 'Fruit Legend', '水果傳奇', '', 7017, 1, 0, 0, 5.00, 500.00, 95.67, 1, 0, 20181, '', 2, 1, 1, 159, '');
INSERT INTO `center_games` VALUES (160, 1, 26, 'api', '萌宠夺宝', 'Adorable Pet Indiana', '萌寵奪寶', '', 7018, 1, 0, 0, 1.00, 100.00, 95.67, 1, 0, 20181, '', 2, 1, 1, 160, '');
INSERT INTO `center_games` VALUES (161, 1, 26, 'tkof', '王者足球', 'The King Of Football', '王者足球', '', 7019, 1, 0, 0, 1.00, 100.00, 95.67, 1, 0, 20182, '', 2, 1, 1, 161, '');
INSERT INTO `center_games` VALUES (162, 5, 10, '620', '德州扑克', NULL, NULL, '', 620, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 162, '');
INSERT INTO `center_games` VALUES (163, 5, 10, '720', '二八杠', NULL, NULL, '', 720, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 163, '');
INSERT INTO `center_games` VALUES (164, 5, 10, '830', '抢庄牛牛', NULL, NULL, '', 830, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 164, '');
INSERT INTO `center_games` VALUES (165, 5, 10, '220', '炸金花', NULL, NULL, '', 220, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 165, '');
INSERT INTO `center_games` VALUES (166, 5, 10, '860', '三公', NULL, NULL, '', 860, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 166, '');
INSERT INTO `center_games` VALUES (167, 5, 10, '900', '押庄龙虎', NULL, NULL, '', 900, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 167, '');
INSERT INTO `center_games` VALUES (168, 5, 10, '600', '21点', NULL, NULL, '', 600, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 168, '');
INSERT INTO `center_games` VALUES (169, 5, 10, '870', '通比牛牛', NULL, NULL, '', 870, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 169, '');
INSERT INTO `center_games` VALUES (170, 5, 10, '230', '极速炸金花', NULL, NULL, '', 230, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 170, '');
INSERT INTO `center_games` VALUES (171, 5, 10, '730', '抢庄牌九', NULL, NULL, '', 730, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 171, '');
INSERT INTO `center_games` VALUES (172, 5, 10, '630', '十三水', NULL, NULL, '', 630, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 172, '');
INSERT INTO `center_games` VALUES (173, 5, 10, '380', '幸运五张', NULL, NULL, '', 380, 2, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, NULL, 2, 1, 1, 173, '');
INSERT INTO `center_games` VALUES (174, 5, 10, '610', '斗地主', NULL, NULL, '', 610, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 174, '');
INSERT INTO `center_games` VALUES (175, 5, 10, '390', '射龙门', NULL, NULL, '', 390, 2, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, NULL, 2, 1, 1, 175, '');
INSERT INTO `center_games` VALUES (176, 5, 10, '910', '百家乐', NULL, NULL, '', 910, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 176, '');
INSERT INTO `center_games` VALUES (177, 5, 10, '920', '森林舞会', NULL, NULL, '', 920, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 177, '');
INSERT INTO `center_games` VALUES (178, 5, 10, '930', '百人牛牛', NULL, NULL, '', 930, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 178, '');
INSERT INTO `center_games` VALUES (179, 5, 10, '1950', '万人炸金花', NULL, NULL, '', 1950, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 179, '');
INSERT INTO `center_games` VALUES (180, 4, 38, '0', '泛亚大厅', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 1, 1, 1, 180, '');
INSERT INTO `center_games` VALUES (362, 1, 9, 'wxhh', '五星宏辉', 'Only One', '五星宏輝', '', 6507, 2, 0, 0, 1.00, 500.00, 95.00, 1, 0, 20192, NULL, 2, 1, 1, 362, '');
INSERT INTO `center_games` VALUES (363, 1, 9, 'slhb', '扫雷红包', 'Mine sweeper Red Packet', '掃雷紅包', '', 6508, 2, 0, 0, 10.00, 300.00, 95.00, 2, 0, 20192, NULL, 2, 1, 1, 363, '');
INSERT INTO `center_games` VALUES (364, 1, 9, 'qznn3d', '抢庄牛牛3D', 'Rob Banker Of Bull 3D', '搶莊牛牛3D', '', 6701, 2, 0, 0, 1.00, 30.00, 95.00, 1, 0, 20192, NULL, 2, 1, 1, 364, '');
INSERT INTO `center_games` VALUES (365, 1, 9, 'hlmj3D', '欢乐麻将3D', 'Happy mahjong 3D', '歡樂麻將3D', '', 6702, 2, 0, 0, 0.50, 10.00, 95.00, 1, 0, 20192, NULL, 2, 1, 1, 365, '');
INSERT INTO `center_games` VALUES (190, 3, 30, '3001', '百家乐', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3001_23', 2, 1, 1, 190, '');
INSERT INTO `center_games` VALUES (191, 3, 30, '3003', '龙虎斗', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3003_1', 2, 1, 1, 191, '');
INSERT INTO `center_games` VALUES (192, 3, 30, '3005', '三公', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3005_1', 2, 1, 1, 192, '');
INSERT INTO `center_games` VALUES (193, 3, 30, '3006', '温州牌九', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3006_1', 2, 1, 1, 193, '');
INSERT INTO `center_games` VALUES (194, 3, 30, '3007', '轮盘', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3007_1', 2, 1, 1, 194, '');
INSERT INTO `center_games` VALUES (195, 3, 30, '3008', '骰宝', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3008_1', 2, 1, 1, 195, '');
INSERT INTO `center_games` VALUES (196, 3, 30, '3010', '德州扑克', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3010_1', 2, 1, 1, 196, '');
INSERT INTO `center_games` VALUES (197, 3, 30, '3011', '色碟', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3011_1', 2, 1, 1, 197, '');
INSERT INTO `center_games` VALUES (198, 3, 30, '3012', '牛牛', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3012_1', 2, 1, 1, 198, '');
INSERT INTO `center_games` VALUES (199, 3, 30, '3014', '无限21点', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3014_1', 2, 1, 1, 199, '');
INSERT INTO `center_games` VALUES (200, 3, 30, '3015', '番摊', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3015_1', 2, 1, 1, 200, '');
INSERT INTO `center_games` VALUES (201, 3, 30, '3016', '鱼虾蟹', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3016_1', 2, 1, 1, 201, '');
INSERT INTO `center_games` VALUES (202, 3, 30, '3017', '保险百家乐', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3017_1', 2, 1, 1, 202, '');
INSERT INTO `center_games` VALUES (203, 3, 30, '3018', '炸金花', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3018_1', 2, 1, 1, 203, '');
INSERT INTO `center_games` VALUES (204, 3, 30, '3019', '幸运转轮', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_3019_1', 2, 1, 1, 204, '');
INSERT INTO `center_games` VALUES (205, 3, 25, '5005', '惑星战记', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5005_5', 2, 1, 1, 205, '');
INSERT INTO `center_games` VALUES (206, 3, 25, '5007', '激爆水果盘', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5007_5', 2, 1, 0, 206, '');
INSERT INTO `center_games` VALUES (207, 3, 25, '5008', '猴子爬树', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5008_5', 2, 1, 0, 207, '');
INSERT INTO `center_games` VALUES (208, 3, 25, '5009', '金刚爬楼', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5009_5', 2, 1, 0, 208, '');
INSERT INTO `center_games` VALUES (209, 3, 25, '5010', '外星战记', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5010_5', 2, 1, 1, 209, '');
INSERT INTO `center_games` VALUES (210, 3, 25, '5012', '外星争霸', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5012_5', 2, 1, 1, 210, '');
INSERT INTO `center_games` VALUES (211, 3, 25, '5013', '传统', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5013_5', 2, 1, 1, 211, '');
INSERT INTO `center_games` VALUES (212, 3, 25, '5014', '丛林', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5014_5', 2, 1, 1, 212, '');
INSERT INTO `center_games` VALUES (213, 3, 25, '5015', 'FIFA2010', 'FIFA2010', NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5015_5', 2, 1, 1, 213, '');
INSERT INTO `center_games` VALUES (214, 3, 25, '5016', '史前丛林冒险', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5016_5', 2, 1, 0, 214, '');
INSERT INTO `center_games` VALUES (215, 3, 25, '5017', '星际大战', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5017_5', 2, 1, 0, 215, '');
INSERT INTO `center_games` VALUES (216, 3, 25, '5018', '齐天大圣', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5018_5', 2, 1, 0, 216, '');
INSERT INTO `center_games` VALUES (217, 3, 25, '5019', '水果乐园', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5019_5', 2, 1, 1, 217, '');
INSERT INTO `center_games` VALUES (218, 3, 25, '5025', '法海斗白蛇', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5025_5', 2, 1, 0, 218, '');
INSERT INTO `center_games` VALUES (219, 3, 25, '5026', '2012 伦敦奥运', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5026_5', 2, 1, 0, 219, '');
INSERT INTO `center_games` VALUES (220, 3, 25, '5027', '功夫龙', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5027_5', 2, 1, 1, 220, '');
INSERT INTO `center_games` VALUES (221, 3, 25, '5028', '中秋月光派对', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5028_5', 2, 1, 0, 221, '');
INSERT INTO `center_games` VALUES (222, 3, 25, '5029', '圣诞派对', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5029_5', 2, 1, 0, 222, '');
INSERT INTO `center_games` VALUES (223, 3, 25, '5030', '幸运财神', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5030_5', 2, 1, 1, 223, '');
INSERT INTO `center_games` VALUES (224, 3, 25, '5034', '王牌5PK', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5034_5', 2, 1, 0, 224, '');
INSERT INTO `center_games` VALUES (225, 3, 25, '5035', '加勒比扑克', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5035_5', 2, 1, 0, 225, '');
INSERT INTO `center_games` VALUES (226, 3, 25, '5039', '鱼虾蟹', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5039_5', 2, 1, 1, 226, '');
INSERT INTO `center_games` VALUES (227, 3, 25, '5040', '百搭二王', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5040_5', 2, 1, 0, 227, '');
INSERT INTO `center_games` VALUES (228, 3, 25, '5041', '7PK', '7PK', NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5041_5', 2, 1, 0, 228, '');
INSERT INTO `center_games` VALUES (229, 3, 25, '5043', '钻石水果盘', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5043_5', 2, 1, 1, 229, '');
INSERT INTO `center_games` VALUES (230, 3, 25, '5044', '明星97II', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5044_5', 2, 1, 1, 230, '');
INSERT INTO `center_games` VALUES (231, 3, 25, '5045', '森林舞会', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5045_5', 2, 1, 1, 231, '');
INSERT INTO `center_games` VALUES (232, 3, 25, '5046', '斗魂', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5046_5', 2, 1, 1, 232, '');
INSERT INTO `center_games` VALUES (233, 3, 25, '5054', '爆骰', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5054_5', 2, 1, 1, 233, '');
INSERT INTO `center_games` VALUES (234, 3, 25, '5057', '明星97', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5057_5', 2, 1, 1, 234, '');
INSERT INTO `center_games` VALUES (235, 3, 25, '5058', '疯狂水果盘', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5058_5', 2, 1, 1, 235, '');
INSERT INTO `center_games` VALUES (236, 3, 25, '5060', '动物奇观五', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5060_5', 2, 1, 0, 236, '');
INSERT INTO `center_games` VALUES (237, 3, 25, '5061', '超级7', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5061_5', 2, 1, 1, 237, '');
INSERT INTO `center_games` VALUES (238, 3, 25, '5062', '龙在囧途', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5062_5', 2, 1, 1, 238, '');
INSERT INTO `center_games` VALUES (239, 3, 25, '5063', '水果拉霸', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5063_5', 2, 1, 1, 239, '');
INSERT INTO `center_games` VALUES (240, 3, 25, '5064', '扑克拉霸', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5064_5', 2, 1, 1, 240, '');
INSERT INTO `center_games` VALUES (241, 3, 25, '5065', '筒子拉霸', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5065_5', 2, 1, 1, 241, '');
INSERT INTO `center_games` VALUES (242, 3, 25, '5066', '足球拉霸', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5066_5', 2, 1, 1, 242, '');
INSERT INTO `center_games` VALUES (243, 3, 25, '5067', '大话西游', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5067_5', 2, 1, 1, 243, '');
INSERT INTO `center_games` VALUES (244, 3, 25, '5068', '酷搜马戏团', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5068_5', 2, 1, 1, 244, '');
INSERT INTO `center_games` VALUES (245, 3, 25, '5069', '水果擂台', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5069_5', 2, 1, 1, 245, '');
INSERT INTO `center_games` VALUES (246, 3, 25, '5070', '黄金大转轮', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5070_5', 2, 1, 0, 246, '');
INSERT INTO `center_games` VALUES (247, 3, 25, '5073', '百家乐大转轮', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5073_5', 2, 1, 0, 247, '');
INSERT INTO `center_games` VALUES (248, 3, 25, '5076', '数字大转轮', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5076_5', 2, 1, 1, 248, '');
INSERT INTO `center_games` VALUES (249, 3, 25, '5077', '水果大转轮', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5077_5', 2, 1, 1, 249, '');
INSERT INTO `center_games` VALUES (250, 3, 25, '5078', '象棋大转轮', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5078_5', 2, 1, 0, 250, '');
INSERT INTO `center_games` VALUES (251, 3, 25, '5079', '3D数字大转轮', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5079_5', 2, 1, 1, 251, '');
INSERT INTO `center_games` VALUES (252, 3, 25, '5080', '乐透转轮', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5080_5', 2, 1, 1, 252, '');
INSERT INTO `center_games` VALUES (253, 3, 25, '5083', '钻石列车', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5083_5', 2, 1, 1, 253, '');
INSERT INTO `center_games` VALUES (254, 3, 25, '5084', '圣兽传说', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5084_5', 2, 1, 1, 254, '');
INSERT INTO `center_games` VALUES (255, 3, 25, '5088', '斗大', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5088_5', 2, 1, 1, 255, '');
INSERT INTO `center_games` VALUES (256, 3, 25, '5089', '红狗', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5089_5', 2, 1, 1, 256, '');
INSERT INTO `center_games` VALUES (257, 3, 25, '5090', '金鸡报喜', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5090_5', 2, 1, 1, 257, '');
INSERT INTO `center_games` VALUES (258, 3, 25, '5091', '三国拉霸', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5091_5', 2, 1, 0, 258, '');
INSERT INTO `center_games` VALUES (259, 3, 25, '5092', '封神榜', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5092_5', 2, 1, 0, 259, '');
INSERT INTO `center_games` VALUES (260, 3, 25, '5093', '金瓶梅', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5093_5', 2, 1, 1, 260, '');
INSERT INTO `center_games` VALUES (261, 3, 25, '5094', '金瓶梅2', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5094_5', 2, 1, 1, 261, '');
INSERT INTO `center_games` VALUES (262, 3, 25, '5095', '斗鸡', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5095_5', 2, 1, 1, 262, '');
INSERT INTO `center_games` VALUES (263, 3, 25, '5096', '五行', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5096_5', 2, 1, 1, 263, '');
INSERT INTO `center_games` VALUES (264, 3, 25, '5097', '海底世界', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5097_5', 2, 1, 1, 264, '');
INSERT INTO `center_games` VALUES (265, 3, 25, '5098', '五福临门', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5098_5', 2, 1, 1, 265, '');
INSERT INTO `center_games` VALUES (266, 3, 25, '5099', '金狗旺岁', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5099_5', 2, 1, 1, 266, '');
INSERT INTO `center_games` VALUES (267, 3, 25, '5100', '七夕', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5100_5', 2, 1, 1, 267, '');
INSERT INTO `center_games` VALUES (268, 3, 25, '5105', '欧式轮盘', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5105_5', 2, 1, 1, 268, '');
INSERT INTO `center_games` VALUES (269, 3, 25, '5106', '三国', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5106_5', 2, 1, 1, 269, '');
INSERT INTO `center_games` VALUES (270, 3, 25, '5107', '美式轮盘', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5107_5', 2, 1, 1, 270, '');
INSERT INTO `center_games` VALUES (271, 3, 25, '5108', '彩金轮盘', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5108_5', 2, 1, 1, 271, '');
INSERT INTO `center_games` VALUES (272, 3, 25, '5109', '法式轮盘', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5109_5', 2, 1, 1, 272, '');
INSERT INTO `center_games` VALUES (273, 3, 25, '5110', '夜上海', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5110_5', 2, 1, 1, 273, '');
INSERT INTO `center_games` VALUES (274, 3, 25, '5116', '西班牙21点', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5116_5', 2, 1, 0, 274, '');
INSERT INTO `center_games` VALUES (275, 3, 25, '5117', '维加斯21点', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5117_5', 2, 1, 0, 275, '');
INSERT INTO `center_games` VALUES (276, 3, 25, '5118', '奖金21点', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5118_5', 2, 1, 1, 276, '');
INSERT INTO `center_games` VALUES (277, 3, 25, '5119', '神秘岛', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5119_5', 2, 1, 1, 277, '');
INSERT INTO `center_games` VALUES (278, 3, 25, '5120', '女娲补天', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5120_5', 2, 1, 1, 278, '');
INSERT INTO `center_games` VALUES (279, 3, 25, '5122', '球球大作战', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5122_5', 2, 1, 1, 279, '');
INSERT INTO `center_games` VALUES (280, 3, 25, '5123', '经典21点', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5123_5', 2, 1, 1, 280, '');
INSERT INTO `center_games` VALUES (281, 3, 25, '5127', '绝地求生', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5127_5', 2, 1, 1, 281, '');
INSERT INTO `center_games` VALUES (282, 3, 25, '5128', '多福多财', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5128_5', 2, 1, 1, 282, '');
INSERT INTO `center_games` VALUES (283, 3, 25, '5131', '皇家德州扑克', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5131_5', 2, 1, 0, 283, '');
INSERT INTO `center_games` VALUES (284, 3, 25, '5138', '夹猪珠', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5138_5', 2, 1, 1, 284, '');
INSERT INTO `center_games` VALUES (285, 3, 25, '5139', '熊猫乐园', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5139_5', 2, 1, 1, 285, '');
INSERT INTO `center_games` VALUES (286, 3, 25, '5201', '火焰山', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5201_5', 2, 1, 0, 286, '');
INSERT INTO `center_games` VALUES (287, 3, 25, '5202', '月光宝盒', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5202_5', 2, 1, 0, 287, '');
INSERT INTO `center_games` VALUES (288, 3, 25, '5203', '爱你一万年', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5203_5', 2, 1, 0, 288, '');
INSERT INTO `center_games` VALUES (289, 3, 25, '5204', '2014 FIFA', '2014 FIFA', NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5204_5', 2, 1, 1, 289, '');
INSERT INTO `center_games` VALUES (290, 3, 25, '5402', '夜市人生', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5402_5', 2, 1, 1, 290, '');
INSERT INTO `center_games` VALUES (291, 3, 25, '5404', '沙滩排球', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5404_5', 2, 1, 1, 291, '');
INSERT INTO `center_games` VALUES (292, 3, 25, '5406', '神舟27', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5406_5', 2, 1, 0, 292, '');
INSERT INTO `center_games` VALUES (293, 3, 25, '5407', '大红帽与小野狼', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5407_5', 2, 1, 1, 293, '');
INSERT INTO `center_games` VALUES (294, 3, 25, '5601', '秘境冒险', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5601_5', 2, 1, 1, 294, '');
INSERT INTO `center_games` VALUES (295, 3, 25, '5701', '连连看', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5701_5', 2, 1, 0, 295, '');
INSERT INTO `center_games` VALUES (296, 3, 25, '5703', '发达啰', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5703_5', 2, 1, 0, 296, '');
INSERT INTO `center_games` VALUES (297, 3, 25, '5704', '斗牛', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5704_5', 2, 1, 0, 297, '');
INSERT INTO `center_games` VALUES (298, 3, 25, '5705', '聚宝盆', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5705_5', 2, 1, 0, 298, '');
INSERT INTO `center_games` VALUES (299, 3, 25, '5706', '浓情巧克力', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5706_5', 2, 1, 0, 299, '');
INSERT INTO `center_games` VALUES (300, 3, 25, '5707', '金钱豹', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5707_5', 2, 1, 0, 300, '');
INSERT INTO `center_games` VALUES (301, 3, 25, '5802', '阿基里斯', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5802_5', 2, 1, 0, 301, '');
INSERT INTO `center_games` VALUES (302, 3, 25, '5803', '阿兹特克宝藏', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5803_5', 2, 1, 1, 302, '');
INSERT INTO `center_games` VALUES (303, 3, 25, '5804', '大明星', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5804_5', 2, 1, 0, 303, '');
INSERT INTO `center_games` VALUES (304, 3, 25, '5805', '凯萨帝国', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5805_5', 2, 1, 1, 304, '');
INSERT INTO `center_games` VALUES (305, 3, 25, '5806', '奇幻花园', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5806_5', 2, 1, 0, 305, '');
INSERT INTO `center_games` VALUES (306, 3, 25, '5808', '浪人武士', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5808_5', 2, 1, 0, 306, '');
INSERT INTO `center_games` VALUES (307, 3, 25, '5809', '空战英豪', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5809_5', 2, 1, 0, 307, '');
INSERT INTO `center_games` VALUES (308, 3, 25, '5810', '航海时代', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5810_5', 2, 1, 1, 308, '');
INSERT INTO `center_games` VALUES (309, 3, 25, '5823', '发大财', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5823_5', 2, 1, 1, 309, '');
INSERT INTO `center_games` VALUES (310, 3, 25, '5824', '恶龙传说', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5824_5', 2, 1, 1, 310, '');
INSERT INTO `center_games` VALUES (311, 3, 25, '5825', '金莲', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5825_5', 2, 1, 0, 311, '');
INSERT INTO `center_games` VALUES (312, 3, 25, '5826', '金矿工', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5826_5', 2, 1, 0, 312, '');
INSERT INTO `center_games` VALUES (313, 3, 25, '5827', '老船长', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5827_5', 2, 1, 0, 313, '');
INSERT INTO `center_games` VALUES (314, 3, 25, '5828', '霸王龙', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5828_5', 2, 1, 1, 314, '');
INSERT INTO `center_games` VALUES (315, 3, 25, '5835', '喜福牛年', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5835_5', 2, 1, 1, 315, '');
INSERT INTO `center_games` VALUES (316, 3, 25, '5836', '龙卷风', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5836_5', 2, 1, 0, 316, '');
INSERT INTO `center_games` VALUES (317, 3, 25, '5837', '喜福猴年', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5837_5', 2, 1, 1, 317, '');
INSERT INTO `center_games` VALUES (319, 3, 25, '5839', '经典高球', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5839_5', 2, 1, 1, 319, '');
INSERT INTO `center_games` VALUES (320, 3, 25, '5901', '连环夺宝', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5901_5', 2, 1, 1, 320, '');
INSERT INTO `center_games` VALUES (321, 3, 25, '5902', '糖果派对', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 1, 0, '5_5902_5', 1, 1, 1, 321, '');
INSERT INTO `center_games` VALUES (322, 3, 25, '5903', '秦皇秘宝', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5903_5', 2, 1, 1, 322, '');
INSERT INTO `center_games` VALUES (323, 3, 25, '5904', '蒸气炸弹', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5904_5', 1, 1, 1, 323, '');
INSERT INTO `center_games` VALUES (324, 3, 25, '5907', '趣味台球', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5907_5', 1, 1, 1, 324, '');
INSERT INTO `center_games` VALUES (325, 3, 25, '5908', '糖果派对2', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5908_5', 1, 1, 1, 325, '');
INSERT INTO `center_games` VALUES (326, 3, 25, '5909', '开心消消乐', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5909_5', 2, 1, 1, 326, '');
INSERT INTO `center_games` VALUES (327, 3, 25, '5910', '魔法元素', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5910_5', 2, 1, 1, 327, '');
INSERT INTO `center_games` VALUES (328, 3, 25, '5912', '连环夺宝2', NULL, NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_5912_5', 1, 1, 1, 328, '');
INSERT INTO `center_games` VALUES (329, 3, 25, '5888', 'JACKPOT', 'JACKPOT', NULL, '', 5, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '5_5888_5', 2, 1, 1, 329, '');
INSERT INTO `center_games` VALUES (330, 3, 33, '30599', '捕鱼达人', NULL, NULL, '', 30, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_30599_30', 2, 1, 1, 330, '');
INSERT INTO `center_games` VALUES (331, 2, 11, 'texas', '德州扑克', NULL, NULL, '', 11, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 331, '');
INSERT INTO `center_games` VALUES (332, 2, 11, 'bull/rand ', '牛牛-经典庄', NULL, NULL, '', 31, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 332, '');
INSERT INTO `center_games` VALUES (333, 2, 11, 'bull/rob', '牛牛-看牌抢庄', NULL, NULL, '', 32, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 333, '');
INSERT INTO `center_games` VALUES (334, 2, 11, 'bull/fair', '牛牛-通比 ', NULL, NULL, '', 33, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 334, '');
INSERT INTO `center_games` VALUES (335, 2, 11, 'bull/mrob ', '抢庄牛牛', NULL, NULL, '', 34, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 335, '');
INSERT INTO `center_games` VALUES (336, 2, 35, 'fish', '李逵捕鱼', NULL, NULL, '', 51, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 336, '');
INSERT INTO `center_games` VALUES (337, 2, 35, 'jcby', '金蟾捕鱼', NULL, NULL, '', 52, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 337, '');
INSERT INTO `center_games` VALUES (338, 2, 11, 'baccarat', '欢乐30秒', NULL, NULL, '', 61, 2, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, NULL, 2, 1, 1, 338, '');
INSERT INTO `center_games` VALUES (339, 2, 11, 'hundredbull', ' 百人牛牛', NULL, NULL, '', 62, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 339, '');
INSERT INTO `center_games` VALUES (340, 2, 11, 'doratora', '龙虎', NULL, NULL, '', 63, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 340, '');
INSERT INTO `center_games` VALUES (341, 2, 46, 'carbrand', '奔驰宝马', NULL, NULL, '', 64, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 341, '');
INSERT INTO `center_games` VALUES (342, 2, 46, 'animal', '飞禽走兽', NULL, NULL, '', 65, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 342, '');
INSERT INTO `center_games` VALUES (343, 2, 11, 'zjh', ' 炸金花', NULL, NULL, '', 81, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 343, '');
INSERT INTO `center_games` VALUES (344, 2, 11, 'g28', '28杠', NULL, NULL, '', 91, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 344, '');
INSERT INTO `center_games` VALUES (345, 2, 11, 'fivecards', '港式五张', NULL, NULL, '', 101, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 345, '');
INSERT INTO `center_games` VALUES (346, 2, 11, 'sss', '十三水', NULL, NULL, '', 111, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 346, '');
INSERT INTO `center_games` VALUES (347, 3, 30, 'live', '真人大厅', NULL, NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '3_live_live_0', 2, 1, 1, 347, '');
INSERT INTO `center_games` VALUES (348, 3, 37, 'ball', 'BBIN体育', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '3_ball__1', 2, 1, 1, 348, '');
INSERT INTO `center_games` VALUES (351, 3, 25, 'pt', 'PT电子', NULL, NULL, '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_pt__1', 2, 1, 1, 351, '');
INSERT INTO `center_games` VALUES (349, 3, 25, 'game', 'BBIN电子', NULL, NULL, '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_game__1', 2, 1, 1, 349, '');
INSERT INTO `center_games` VALUES (821, 3, 25, '3021', 'HiLo', '', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '', 2, 1, 1, 821, '');
INSERT INTO `center_games` VALUES (352, 3, 25, 'mg', 'MG电子', NULL, NULL, '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_mg__1', 2, 1, 1, 352, '');
INSERT INTO `center_games` VALUES (353, 3, 25, 'gns', 'GNS电子', NULL, NULL, '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_gns__1', 2, 1, 1, 353, '');
INSERT INTO `center_games` VALUES (354, 3, 25, 'isb', 'ISB电子', NULL, NULL, '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_isb__1', 2, 1, 1, 354, '');
INSERT INTO `center_games` VALUES (355, 3, 37, 'nball', 'New BBIN体育', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_nball__1', 2, 1, 1, 355, '');
INSERT INTO `center_games` VALUES (356, 3, 33, 'fisharea', 'BBIN捕鱼', NULL, NULL, '', 0, 3, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_fisharea__1', 2, 1, 1, 356, '');
INSERT INTO `center_games` VALUES (357, 3, 37, 'sunplus', 'BBIN体育投注', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_sunplus__1', 2, 1, 1, 357, '');
INSERT INTO `center_games` VALUES (361, 1, 9, 'bj', '21点', 'Black Jack', '21點', '', 6010, 2, 0, 0, 3.00, 100.00, 95.00, 1, 1, 20192, NULL, 2, 1, 1, 361, '');
INSERT INTO `center_games` VALUES (360, 2, 46, 'xxl', '宝石消消乐', NULL, NULL, '', 121, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 360, '');
INSERT INTO `center_games` VALUES (359, 2, 35, 'hwby', '海王捕魚', 'Aquaman', NULL, '', 54, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 359, '');
INSERT INTO `center_games` VALUES (358, 2, 35, 'dsnh', '大圣闹海', 'Da Nao Long Gong', NULL, '', 53, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, NULL, 2, 1, 1, 358, '');
INSERT INTO `center_games` VALUES (366, 1, 9, 'ldnmw3D', '乐斗牛魔王3D', 'Happy Xi you 3D', '樂鬥牛魔王3D', '', 6703, 2, 0, 0, 1.00, 500.00, 95.00, 1, 0, 20192, NULL, 2, 1, 1, 366, '');
INSERT INTO `center_games` VALUES (367, 1, 34, 'fish_mfwz', '魔法王者', 'The Magicians', '魔法王者', '', 5007, 3, 0, 0, 0.10, 990.00, 97.30, 1, 0, 0, NULL, 2, 1, 1, 367, '');
INSERT INTO `center_games` VALUES (368, 6, 27, '17', '基蒂的双胞胎', 'Kitty Twins', NULL, '', 17, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 368, '');
INSERT INTO `center_games` VALUES (369, 6, 27, '18', '特斯拉', 'Tesla', NULL, '', 18, 1, 101, 101, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 369, '');
INSERT INTO `center_games` VALUES (370, 6, 27, '19', '达芬奇法典', 'DaVinci Codex', NULL, '', 19, 1, 100, 100, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 370, '');
INSERT INTO `center_games` VALUES (371, 6, 27, '20', '克利奥帕特拉珠宝', 'Cleopatra Jewels', NULL, '', 20, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 371, '');
INSERT INTO `center_games` VALUES (372, 6, 27, '21', '亚特兰提斯的世界', 'Atlantis World', NULL, '', 21, 1, 50, 50, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 372, '');
INSERT INTO `center_games` VALUES (373, 6, 27, '22', '水晶神秘', 'Crystal Mystery', NULL, '', 22, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 373, '');
INSERT INTO `center_games` VALUES (374, 6, 27, '23', '五星级豪华场', 'Five Star Luxury', NULL, '', 23, 1, 101, 101, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 374, '');
INSERT INTO `center_games` VALUES (375, 6, 27, '24', '财源滚滚', 'More Cash', NULL, '', 24, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 375, '');
INSERT INTO `center_games` VALUES (376, 6, 27, '25', '种钱得钱', 'Money Farm', NULL, '', 25, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 376, '');
INSERT INTO `center_games` VALUES (377, 6, 27, '26', '龙女', 'Dragon Lady', NULL, '', 26, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 377, '');
INSERT INTO `center_games` VALUES (378, 6, 27, '27', '燃烧的火焰', 'Burning Flame', NULL, '', 27, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 378, '');
INSERT INTO `center_games` VALUES (379, 6, 27, '28', '皇家宝石', 'Royal Gems', NULL, '', 28, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 379, '');
INSERT INTO `center_games` VALUES (380, 6, 27, '29', '火焰风暴', 'Storming Flame', NULL, '', 29, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 380, '');
INSERT INTO `center_games` VALUES (381, 6, 27, '30', '明星奖金', 'Star Cash', NULL, '', 30, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 381, '');
INSERT INTO `center_games` VALUES (382, 6, 27, '37', '宝玉', 'Jade Treasure', NULL, '', 37, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 382, '');
INSERT INTO `center_games` VALUES (383, 6, 27, '38', '88年财富', '88 Riches', NULL, '', 38, 1, 50, 50, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 383, '');
INSERT INTO `center_games` VALUES (384, 6, 27, '39', '国王的财富', 'King Of Wealth', NULL, '', 39, 1, 101, 101, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 384, '');
INSERT INTO `center_games` VALUES (385, 6, 27, '40', '幸运的狮子', 'Fortune Lions', NULL, '', 40, 1, 50, 50, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 385, '');
INSERT INTO `center_games` VALUES (386, 6, 27, '41', '拉美西斯的宝藏', 'Ramses Treasure', NULL, '', 41, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 386, '');
INSERT INTO `center_games` VALUES (387, 6, 27, '42', '卡里古拉', 'Caligula', NULL, '', 42, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 387, '');
INSERT INTO `center_games` VALUES (388, 6, 27, '43', '寻金之旅', 'Golden Dragon', NULL, '', 43, 1, 50, 50, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 388, '');
INSERT INTO `center_games` VALUES (389, 6, 27, '44', '幸运的婴儿', 'Lucky Babies', NULL, '', 44, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 389, '');
INSERT INTO `center_games` VALUES (390, 6, 27, '45', '三王', 'Three Kings', NULL, '', 45, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 390, '');
INSERT INTO `center_games` VALUES (391, 6, 27, '46', '雷声鸟', 'Thunder Bird', NULL, '', 46, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 391, '');
INSERT INTO `center_games` VALUES (392, 6, 27, '47', '魔龙', 'Magic Dragon', NULL, '', 47, 1, 101, 101, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 392, '');
INSERT INTO `center_games` VALUES (393, 6, 27, '48', '德州骑警的奖励', 'Texas Rangers Reward', NULL, '', 48, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 393, '');
INSERT INTO `center_games` VALUES (394, 6, 27, '49', '种钱得钱2', 'Money Farm 2', NULL, '', 49, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 394, '');
INSERT INTO `center_games` VALUES (395, 6, 27, '50', '老虎的心', 'Tiger Heart', NULL, '', 50, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 395, '');
INSERT INTO `center_games` VALUES (396, 6, 27, '51', '城堡血', 'Castle Blood', NULL, '', 51, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 396, '');
INSERT INTO `center_games` VALUES (397, 6, 27, '91', '海之女皇', 'Queen Of The Seas', NULL, '', 91, 1, 30, 30, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 397, '');
INSERT INTO `center_games` VALUES (398, 6, 27, '93', '皇帝的财富', 'Emperors Wealth', NULL, '', 93, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 398, '');
INSERT INTO `center_games` VALUES (399, 6, 27, '94', '斗牛士', 'El Toreo', NULL, '', 94, 1, 10, 10, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 399, '');
INSERT INTO `center_games` VALUES (400, 6, 36, '105', '捕鱼大师', NULL, NULL, '', 105, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 400, '');
INSERT INTO `center_games` VALUES (401, 6, 36, '411', '西游捕鱼', NULL, NULL, '', 411, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 401, '');
INSERT INTO `center_games` VALUES (402, 6, 31, '11', '普通百家乐', 'Baccarat', NULL, '', 1, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20193, NULL, 2, 1, 1, 402, '');
INSERT INTO `center_games` VALUES (403, 6, 31, '47', '极速百家乐', 'SpeedBaccarat', NULL, '', 7, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20193, NULL, 2, 1, 1, 403, '');
INSERT INTO `center_games` VALUES (404, 6, 31, '79', '共咪百家乐', 'MiCardBaccarat', NULL, '', 10, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20193, NULL, 2, 1, 1, 404, '');
INSERT INTO `center_games` VALUES (405, 6, 31, '271', '多彩百家乐', 'FullColorBaccarat', NULL, '', 11, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20193, NULL, 2, 1, 1, 405, '');
INSERT INTO `center_games` VALUES (406, 6, 31, '527', '龙虎', 'Dragontiger', NULL, '', 4, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20193, NULL, 2, 1, 1, 406, '');
INSERT INTO `center_games` VALUES (407, 6, 31, '1039', '骰宝', 'Sicbo', NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20193, NULL, 2, 1, 1, 407, '');
INSERT INTO `center_games` VALUES (408, 6, 31, '2063', '轮盘', 'Roulette', NULL, '', 2, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20193, NULL, 2, 1, 1, 408, '');
INSERT INTO `center_games` VALUES (409, 6, 31, '4111', '牛牛', 'BullBull', NULL, '', 13, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20193, NULL, 2, 1, 1, 409, '');
INSERT INTO `center_games` VALUES (410, 6, 31, '8207', '炸金花', 'WinThreeCards', NULL, '', 14, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20193, NULL, 2, 1, 1, 410, '');
INSERT INTO `center_games` VALUES (411, 8, 39, '0', '大厅', 'hall', NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 1, 0, 20198, NULL, 2, 1, 1, 411, '');
INSERT INTO `center_games` VALUES (412, 7, 32, '1', '百家乐', 'Baccarat', NULL, '', 1, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 412, '');
INSERT INTO `center_games` VALUES (413, 7, 32, '2', '波贝保险百家乐', 'bobeiBaccarat', NULL, '', 2, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 413, '');
INSERT INTO `center_games` VALUES (414, 7, 32, '3', '龙虎', 'dragon', NULL, '', 3, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 414, '');
INSERT INTO `center_games` VALUES (415, 7, 32, '4', '轮盘', '', NULL, '', 4, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 415, '');
INSERT INTO `center_games` VALUES (416, 7, 32, '5', '骰宝', '', NULL, '', 5, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 416, '');
INSERT INTO `center_games` VALUES (417, 7, 32, '7', '斗牛', '', NULL, '', 7, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 417, '');
INSERT INTO `center_games` VALUES (418, 7, 32, '8', '竞咪百家乐', 'jingmibobeiBaccarat', NULL, '', 8, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 418, '');
INSERT INTO `center_games` VALUES (419, 7, 32, '9', '赌场扑克', 'poker', NULL, '', 9, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 419, '');
INSERT INTO `center_games` VALUES (420, 7, 32, '10', '波贝VIP百家乐', 'bobei VIP Baccarat', NULL, '', 10, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 420, '');
INSERT INTO `center_games` VALUES (421, 7, 32, '11', '炸金花	', '', NULL, '', 11, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 421, '');
INSERT INTO `center_games` VALUES (422, 7, 32, '12', '极速骰宝	', '', NULL, '', 12, 5, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, NULL, 2, 1, 1, 422, '');
INSERT INTO `center_games` VALUES (423, 7, 32, '0', 'DG视讯大厅', 'hall', NULL, '', 0, 5, 0, 0, 0.00, 0.00, 0.00, 1, 0, 20198, NULL, 2, 1, 1, 423, '');
INSERT INTO `center_games` VALUES (424, 8, 39, '0', '足球', 'Soccer', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '1', 2, 1, 1, 424, '');
INSERT INTO `center_games` VALUES (425, 8, 39, '0', '篮球', 'BasketBall', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '2', 2, 1, 1, 425, '');
INSERT INTO `center_games` VALUES (426, 8, 39, '0', '美式足球', 'Football', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '3', 2, 1, 1, 426, '');
INSERT INTO `center_games` VALUES (427, 8, 39, '0', '棒球', 'Baseball', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '4', 2, 1, 1, 427, '');
INSERT INTO `center_games` VALUES (428, 8, 39, '0', '曲棍球', 'Hockey', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '5', 2, 1, 1, 428, '');
INSERT INTO `center_games` VALUES (429, 8, 39, '0', '长曲棍球', 'Lacrosse', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '6', 2, 1, 1, 429, '');
INSERT INTO `center_games` VALUES (430, 8, 39, '0', '网球', 'Tennis', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '7', 2, 1, 1, 430, '');
INSERT INTO `center_games` VALUES (431, 8, 39, '0', '羽毛球', 'Badminton', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '8', 2, 1, 1, 431, '');
INSERT INTO `center_games` VALUES (432, 8, 39, '0', '乒乓球', 'Table Tennis', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '9', 2, 1, 1, 432, '');
INSERT INTO `center_games` VALUES (433, 8, 39, '0', '高尔夫球', 'Golf', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '10', 2, 1, 1, 433, '');
INSERT INTO `center_games` VALUES (434, 8, 39, '0', '板球', 'Cricket', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '11', 2, 1, 1, 434, '');
INSERT INTO `center_games` VALUES (435, 8, 39, '0', '排球', 'Volleyball', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '12', 2, 1, 1, 435, '');
INSERT INTO `center_games` VALUES (436, 8, 39, '0', '手球', 'Handball', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '13', 2, 1, 1, 436, '');
INSERT INTO `center_games` VALUES (437, 8, 39, '0', '水球', 'Water Polo', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '14', 2, 1, 1, 437, '');
INSERT INTO `center_games` VALUES (438, 8, 39, '0', '沙滩足球', 'Beach Soccer', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '15', 2, 1, 1, 438, '');
INSERT INTO `center_games` VALUES (439, 8, 39, '0', '室内足球', 'Futsal', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '16', 2, 1, 1, 439, '');
INSERT INTO `center_games` VALUES (440, 8, 39, '0', '斯诺克', 'Pool/Snooker', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '17', 2, 1, 1, 440, '');
INSERT INTO `center_games` VALUES (441, 8, 39, '0', '橄榄球', 'Rugby', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '18', 2, 1, 1, 441, '');
INSERT INTO `center_games` VALUES (442, 8, 39, '0', '赛车', 'Motor Sport', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '19', 2, 1, 1, 442, '');
INSERT INTO `center_games` VALUES (443, 8, 39, '0', '飞镖', 'Darts', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '20', 2, 1, 1, 443, '');
INSERT INTO `center_games` VALUES (444, 8, 39, '0', '拳击', 'Boxing', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '21', 2, 1, 1, 444, '');
INSERT INTO `center_games` VALUES (445, 8, 39, '0', '田径', 'Athletics', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '22', 2, 1, 1, 445, '');
INSERT INTO `center_games` VALUES (446, 8, 39, '0', '自行车', 'Cycling', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '23', 2, 1, 1, 446, '');
INSERT INTO `center_games` VALUES (447, 8, 39, '0', '娱乐', 'Entertainment', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '24', 2, 1, 1, 447, '');
INSERT INTO `center_games` VALUES (448, 8, 39, '0', '冬季运动', 'Winter Sports', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '25', 2, 1, 1, 448, '');
INSERT INTO `center_games` VALUES (449, 8, 39, '0', '电子竞技', 'E-Sports', '', '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 20198, '26', 2, 1, 1, 449, '');
INSERT INTO `center_games` VALUES (450, 5, 10, '740', '二人麻将', '', '', '', 740, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 20198, '', 1, 1, 1, 450, '');
INSERT INTO `center_games` VALUES (452, 3, 37, 'FT', '足球', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_ball__1', 2, 1, 1, 452, '');
INSERT INTO `center_games` VALUES (462, 3, 33, '38001', '捕鱼大师 ', NULL, NULL, '', 30, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_38001_38', 2, 1, 1, 462, '');
INSERT INTO `center_games` VALUES (453, 3, 37, 'BK', '篮球', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_ball__1', 2, 1, 1, 453, '');
INSERT INTO `center_games` VALUES (454, 3, 37, 'FB', '美式足球', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_ball__1', 2, 1, 1, 454, '');
INSERT INTO `center_games` VALUES (455, 3, 37, 'IH', '冰球', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_ball__1', 2, 1, 1, 455, '');
INSERT INTO `center_games` VALUES (456, 3, 37, 'BS', '棒球', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_ball__1', 2, 1, 1, 456, '');
INSERT INTO `center_games` VALUES (457, 3, 37, 'TN', '网球', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_ball__1', 2, 1, 1, 457, '');
INSERT INTO `center_games` VALUES (458, 3, 37, 'F1', '其他', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_ball__1', 2, 1, 1, 458, '');
INSERT INTO `center_games` VALUES (459, 3, 37, 'SP', '冠军赛', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_ball__1', 2, 1, 1, 459, '');
INSERT INTO `center_games` VALUES (460, 3, 37, 'CB', '混合过关', NULL, NULL, '', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3_ball__1', 2, 1, 1, 460, '');
INSERT INTO `center_games` VALUES (463, 3, 33, '30598', '捕鱼达人2', '', '', '', 0, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '5_30598_30', 2, 1, 1, 463, '');
INSERT INTO `center_games` VALUES (464, 4, 38, '', '英雄联盟', '', '', 'https://img.avia01.com/upload/201804/081421485dc0.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2', 2, 1, 1, 464, '');
INSERT INTO `center_games` VALUES (465, 4, 38, '', '反恐精英', '', '', 'https://img.avia01.com/upload/201804/08142101a2a8.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2025', 2, 1, 1, 465, '');
INSERT INTO `center_games` VALUES (466, 4, 38, '', '刀塔II', '', '', 'https://img.avia01.com/upload/201804/08142117a58f.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '10', 2, 1, 1, 466, '');
INSERT INTO `center_games` VALUES (467, 4, 38, '', '王者荣耀', '', '', 'https://img.avia01.com/upload/201806/20154022d68a.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2040', 2, 1, 1, 467, '');
INSERT INTO `center_games` VALUES (468, 4, 38, '', '绝地求生', '', '', 'https://img.avia01.com/upload/201804/081428128868.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '1', 2, 1, 1, 468, '');
INSERT INTO `center_games` VALUES (469, 4, 38, '', '守望先锋', '', '', 'https://img.avia01.com/upload/201804/08142054167a.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2027', 2, 1, 1, 469, '');
INSERT INTO `center_games` VALUES (470, 4, 38, '', 'NBA2K', '', '', 'https://img.avia01.com/upload/201806/16214709119f.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2321', 2, 1, 1, 470, '');
INSERT INTO `center_games` VALUES (471, 4, 38, '', '炉石传说', '', '', 'https://img.avia01.com/upload/201805/030031100b0b.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2084', 2, 1, 1, 471, '');
INSERT INTO `center_games` VALUES (472, 4, 38, '', '彩虹6号', '', '', 'https://img.avia01.com/upload/201806/16174604656c.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2322', 2, 1, 1, 472, '');
INSERT INTO `center_games` VALUES (473, 4, 38, '', '风暴英雄', '', '', 'https://img.avia01.com/upload/201805/09160856f3b9.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2095', 2, 1, 1, 473, '');
INSERT INTO `center_games` VALUES (474, 4, 38, '', '星际争霸', '', '', 'https://img.avia01.com/upload/201805/08191155a4d5.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2085', 2, 1, 1, 474, '');
INSERT INTO `center_games` VALUES (475, 4, 38, '', '魔兽争霸', '', '', 'https://img.avia01.com/upload/201805/08191326d309.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2083', 2, 1, 1, 475, '');
INSERT INTO `center_games` VALUES (476, 4, 38, '', '使命召唤', '', '', 'https://img.avia01.com/upload/201805/17155005d77f.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2106', 2, 1, 1, 476, '');
INSERT INTO `center_games` VALUES (477, 4, 38, '', '体育赛事', '', '', 'https://img.avia01.com/upload/201804/08142134a96b.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '3', 2, 1, 1, 477, '');
INSERT INTO `center_games` VALUES (478, 4, 38, '', '直播游戏', '', '', 'https://img.avia01.com/upload/201805/03122231b73b.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2086', 2, 1, 1, 478, '');
INSERT INTO `center_games` VALUES (479, 4, 38, '', '街头霸王5', '', '', 'https://img.avia01.com/upload/201806/16174704f920.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2323', 2, 1, 1, 479, '');
INSERT INTO `center_games` VALUES (480, 4, 38, '', '坦克世界', '', '', 'https://img.avia01.com/upload/201806/161749004331.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2324', 2, 1, 1, 480, '');
INSERT INTO `center_games` VALUES (481, 4, 38, '', '拳击之夜', '', '', 'https://img.avia01.com/upload/201806/16175319ff4a.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2325', 2, 1, 1, 481, '');
INSERT INTO `center_games` VALUES (482, 4, 38, '', 'FIFA Online', '', '', 'https://img.avia01.com/upload/201806/20122917fe40.png', 0, 6, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '2333', 2, 1, 1, 482, '');
INSERT INTO `center_games` VALUES (483, 9, 29, '2', '棋圣', 'GodOfChess', '棋聖', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 483, '');
INSERT INTO `center_games` VALUES (484, 9, 29, '3', '血之吻', 'VampireKiss', '血之吻', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 484, '');
INSERT INTO `center_games` VALUES (485, 9, 29, '4', '森林泰后', 'WildTarzan', '森林泰后', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 485, '');
INSERT INTO `center_games` VALUES (486, 9, 29, '5', '金大款', 'Mr.Rich', '金大款', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 486, '');
INSERT INTO `center_games` VALUES (487, 9, 29, '8', '甜蜜蜜', 'SoSweet', '甜蜜蜜', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 487, '');
INSERT INTO `center_games` VALUES (488, 9, 29, '11', '梦游仙境2', 'Wonderland2', '夢遊仙境2', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 488, '');
INSERT INTO `center_games` VALUES (489, 9, 29, '12', '金玉满堂', 'TreasureHouse', '金玉滿堂', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 489, '');
INSERT INTO `center_games` VALUES (490, 9, 29, '13', '樱花妹子', 'SakuraLegend', '櫻花妹子', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 490, '');
INSERT INTO `center_games` VALUES (491, 9, 29, '15', '金鸡报喜', 'GuGuGu', '金雞報喜', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 491, '');
INSERT INTO `center_games` VALUES (492, 9, 29, '19', '风火轮', 'HotSpin', '風火輪', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 492, '');
INSERT INTO `center_games` VALUES (493, 9, 29, '21', '野狼传说', 'BigWolf', '野狼傳說', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 493, '');
INSERT INTO `center_games` VALUES (494, 9, 29, '23', '金元宝', 'YuanBao', '金元寶', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 494, '');
INSERT INTO `center_games` VALUES (495, 9, 29, '25', '扑克拉霸', 'PokerSLOT', '撲克拉霸', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 495, '');
INSERT INTO `center_games` VALUES (496, 9, 45, 'AB1', '皇金渔场2', 'ParadiseII', '', '', 0, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 496, '');
INSERT INTO `center_games` VALUES (497, 9, 29, '67', '赚金蛋', 'GoldenEggs', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 497, '');
INSERT INTO `center_games` VALUES (498, 9, 29, '69', '发财神', 'FaCaiShen', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 498, '');
INSERT INTO `center_games` VALUES (499, 9, 29, '76', '旺旺旺', 'WonWonWon', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 499, '');
INSERT INTO `center_games` VALUES (500, 9, 29, '61', '天天吃豆', 'Mr. Bean', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 500, '');
INSERT INTO `center_games` VALUES (501, 9, 29, '35', '疯狂哪吒', 'CrazyNuozha', '瘋狂哪吒', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 501, '');
INSERT INTO `center_games` VALUES (502, 9, 29, '68', '悟空偷桃', 'WuKong&Peaches', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 502, '');
INSERT INTO `center_games` VALUES (503, 9, 29, '72', '好运年年', 'HappyRichYear', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 503, '');
INSERT INTO `center_games` VALUES (504, 9, 29, '74', '聚宝盆', 'Treasure Bowl', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 504, '');
INSERT INTO `center_games` VALUES (505, 9, 29, '77', '火凤凰', 'RedPhoenix', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 505, '');
INSERT INTO `center_games` VALUES (506, 9, 29, '78', '阿波罗', 'Apollo', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 506, '');
INSERT INTO `center_games` VALUES (507, 9, 29, '80', '传奇海神', 'Poseidon', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 507, '');
INSERT INTO `center_games` VALUES (508, 9, 29, '81', '金银岛', 'Treasure Island', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 508, '');
INSERT INTO `center_games` VALUES (509, 9, 29, '83', '火之女王', 'FireQueen', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 509, '');
INSERT INTO `center_games` VALUES (510, 9, 29, '84', '奇幻魔术', 'WildMagic', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 510, '');
INSERT INTO `center_games` VALUES (511, 9, 29, '79', '变色龙', 'Chameleon', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 511, '');
INSERT INTO `center_games` VALUES (512, 9, 29, '65', '足球世界杯', 'GoldenKick', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 512, '');
INSERT INTO `center_games` VALUES (513, 9, 29, '92', '2018世界杯', 'WorldCupRussia2018', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 513, '');
INSERT INTO `center_games` VALUES (514, 9, 29, '221', '狄仁杰四大天王', 'Detective Dee 2', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 514, '');
INSERT INTO `center_games` VALUES (515, 9, 41, 'AD02', '四川麻将', '', '', '', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 515, '');
INSERT INTO `center_games` VALUES (516, 9, 29, 'AS09', '好莱坞宠物', 'Hollywood Pets', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 516, '');
INSERT INTO `center_games` VALUES (517, 9, 29, 'AS20', '死亡女王', 'Queen Of Dead', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 517, '');
INSERT INTO `center_games` VALUES (518, 9, 45, 'AMfish', '钓鱼高手', 'Fishing Master', '', '', 0, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 518, '');
INSERT INTO `center_games` VALUES (519, 9, 29, '111', '飞起来', 'Fly Out', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 519, '');
INSERT INTO `center_games` VALUES (520, 9, 41, 'AD03', '斗地主', '', '', '', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 520, '');
INSERT INTO `center_games` VALUES (521, 9, 29, '114', '钻饱宝', 'Gemstone', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 521, '');
INSERT INTO `center_games` VALUES (522, 9, 29, '141', '圣诞来啦', 'Xmas', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 522, '');
INSERT INTO `center_games` VALUES (523, 9, 29, '139', '直式火烧连环船', 'Fire Chibi M', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 523, '');
INSERT INTO `center_games` VALUES (524, 9, 29, '127', '直式武圣', 'God of War M', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 524, '');
INSERT INTO `center_games` VALUES (525, 9, 29, '129', '直式金鸡报喜2', 'Gu Gu Gu 2 M', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 525, '');
INSERT INTO `center_games` VALUES (526, 9, 29, '131', '直式发财神', 'Fa Cai Shen M', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 526, '');
INSERT INTO `center_games` VALUES (527, 9, 29, '133', '直式鸿福齐天', 'Good Fortune M', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 527, '');
INSERT INTO `center_games` VALUES (528, 9, 29, 'AU01', '喵喵', 'Meow Meow', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 528, '');
INSERT INTO `center_games` VALUES (529, 9, 29, 'AU02', '丧尸大餐', 'Feed the Zombie', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 529, '');
INSERT INTO `center_games` VALUES (530, 9, 29, 'AU05', '异外来客', 'Strange Encounter', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 530, '');
INSERT INTO `center_games` VALUES (531, 9, 29, 'AR04', '斗地主经典版', 'Dou Di Zhu', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 531, '');
INSERT INTO `center_games` VALUES (532, 9, 29, '112', '盗法老墓', 'Pyramid Raider', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 532, '');
INSERT INTO `center_games` VALUES (533, 9, 29, '115', '冰雪女王', 'Snow Queen', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 533, '');
INSERT INTO `center_games` VALUES (534, 9, 29, '1', '钻石水果王', 'FruitKing', '鑽石水果王', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 534, '');
INSERT INTO `center_games` VALUES (535, 9, 29, '6', '1945', '1945', '1945', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 535, '');
INSERT INTO `center_games` VALUES (536, 9, 29, '7', '跳起来', 'RaveJump', '跳起來', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 536, '');
INSERT INTO `center_games` VALUES (537, 9, 29, '9', '钟馗运财', 'ZhongKui', '鍾馗運財', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 537, '');
INSERT INTO `center_games` VALUES (538, 9, 29, '10', '五福临门', 'LuckyBats', '五福臨門', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 538, '');
INSERT INTO `center_games` VALUES (539, 9, 29, '14', '绝赢巫师', 'RichWitch', '絕贏巫師', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 539, '');
INSERT INTO `center_games` VALUES (540, 9, 29, '16', '五行', 'Super5', '五行', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 540, '');
INSERT INTO `center_games` VALUES (541, 9, 29, '17', '祥狮献瑞', 'GreatLion', '祥獅獻瑞', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 541, '');
INSERT INTO `center_games` VALUES (542, 9, 29, '18', '雀王', 'MahjongKing', '雀王', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 542, '');
INSERT INTO `center_games` VALUES (543, 9, 29, '20', '发发发', '888', '發發發', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 543, '');
INSERT INTO `center_games` VALUES (544, 9, 29, '22', '庶务西游二课', 'MonkeyOfficeLegend', '庶務西遊二課', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 544, '');
INSERT INTO `center_games` VALUES (545, 9, 29, '24', '跳起来2', 'RaveJump2', '跳起來2', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 545, '');
INSERT INTO `center_games` VALUES (546, 9, 29, '26', '777', '777', '777', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 546, '');
INSERT INTO `center_games` VALUES (547, 9, 29, '27', '魔法世界', 'Magic World', '魔法世界', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 547, '');
INSERT INTO `center_games` VALUES (548, 9, 29, '28', '食神', 'God of Cookery', '食神', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 548, '');
INSERT INTO `center_games` VALUES (549, 9, 29, '29', '水世界', 'WaterWorld', '水世界', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 549, '');
INSERT INTO `center_games` VALUES (550, 9, 29, '30', '三国序', 'Warrior Legend', '三國序', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 550, '');
INSERT INTO `center_games` VALUES (551, 9, 29, '31', '武圣', 'God of War', '武聖', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 551, '');
INSERT INTO `center_games` VALUES (552, 9, 29, '32', '通天神探狄仁杰', 'Detective Dee', '通天神探狄仁傑', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 552, '');
INSERT INTO `center_games` VALUES (553, 9, 29, '33', '火烧连环船', 'Fire Chibi', '火燒連環船', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 553, '');
INSERT INTO `center_games` VALUES (554, 9, 29, '34', '地鼠战役', 'Gophers War', '地鼠戰役', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 554, '');
INSERT INTO `center_games` VALUES (555, 9, 29, '36', '夜店大亨', 'Pub Tycoon', '夜店大亨', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 555, '');
INSERT INTO `center_games` VALUES (556, 9, 29, '38', '舞力全开', 'All Wilds', '舞力全開', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 556, '');
INSERT INTO `center_games` VALUES (557, 9, 29, '39', '飞天', 'Apsaras', '飛天', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 557, '');
INSERT INTO `center_games` VALUES (558, 9, 29, '40', '镖王争霸', 'Darts Championship', '鏢王爭霸', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 558, '');
INSERT INTO `center_games` VALUES (559, 9, 29, '41', '水球大战', 'Water Balloons', '水球大戰', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 559, '');
INSERT INTO `center_games` VALUES (560, 9, 29, '42', '福尔摩斯', 'Sherlock Holmes', '福爾摩斯', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 560, '');
INSERT INTO `center_games` VALUES (561, 9, 29, '43', '恭贺新禧', 'Gong He Xin Xi', '恭賀新禧', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 561, '');
INSERT INTO `center_games` VALUES (562, 9, 29, '44', '豪华水果王', 'Fruit King II', '豪華水果王', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 562, '');
INSERT INTO `center_games` VALUES (563, 9, 29, '45', '超级发', 'Super8', '超級發', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 563, '');
INSERT INTO `center_games` VALUES (564, 9, 29, '46', '狼月', 'Wolf Moon', '狼月', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 564, '');
INSERT INTO `center_games` VALUES (565, 9, 29, '47', '法老宝藏', 'Pharaoh\'s Gold', '法老寶藏', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 565, '');
INSERT INTO `center_games` VALUES (566, 9, 29, '48', '莲', 'Lotus', '蓮', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 566, '');
INSERT INTO `center_games` VALUES (567, 9, 29, '49', '寂寞星球', 'Lonely Planet', '寂寞星球', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 567, '');
INSERT INTO `center_games` VALUES (568, 9, 29, '50', '鸿福齐天', 'Good Fortune', '鴻福齊天', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 568, '');
INSERT INTO `center_games` VALUES (569, 9, 29, '51', '嗨爆大马戏', 'Ecstatic Circus', '嗨爆大馬戲', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 569, '');
INSERT INTO `center_games` VALUES (570, 9, 29, '52', '跳高高', 'Jump High', '跳高高', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 1, 0, '', 2, 1, 1, 570, '');
INSERT INTO `center_games` VALUES (571, 9, 29, '53', '来电99', 'Love Night', '來電99', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 571, '');
INSERT INTO `center_games` VALUES (572, 9, 29, '58', '金鸡报囍2', 'GuGuGu2', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 572, '');
INSERT INTO `center_games` VALUES (573, 9, 29, '56', '黯夜公爵', 'Dracula', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 573, '');
INSERT INTO `center_games` VALUES (574, 9, 29, '59', '夏日猩情', 'SummerMood', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 574, '');
INSERT INTO `center_games` VALUES (575, 9, 29, '55', '魔龙传奇', 'Dragon Heart', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 575, '');
INSERT INTO `center_games` VALUES (576, 9, 29, '62', '非常钻', 'SuperDiamonds', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 576, '');
INSERT INTO `center_games` VALUES (577, 9, 29, '63', '寻龙诀', 'The Ghouls', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 577, '');
INSERT INTO `center_games` VALUES (578, 9, 29, '57', '神兽争霸', 'The Beast War', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 578, '');
INSERT INTO `center_games` VALUES (579, 9, 29, '64', '宙斯', 'Zeus', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 579, '');
INSERT INTO `center_games` VALUES (580, 9, 29, '54', '火草泥马', 'Funny Alpaca', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 580, '');
INSERT INTO `center_games` VALUES (581, 9, 29, '66', '火爆777', 'Fire777', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 581, '');
INSERT INTO `center_games` VALUES (582, 9, 29, '70', '万饱龙', 'WanBaoDino', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 582, '');
INSERT INTO `center_games` VALUES (583, 9, 29, '60', '丛林舞会', 'JungleParty', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 583, '');
INSERT INTO `center_games` VALUES (584, 9, 29, '93', '世界杯明星', 'FootballStar', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 584, '');
INSERT INTO `center_games` VALUES (585, 9, 29, '94', '世界杯球衣', 'FootballJerseys', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 585, '');
INSERT INTO `center_games` VALUES (586, 9, 29, '95', '世界杯球鞋', 'FootballBoots', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 586, '');
INSERT INTO `center_games` VALUES (587, 9, 29, '96', '足球宝贝', 'FootballBaby', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 587, '');
INSERT INTO `center_games` VALUES (588, 9, 29, '97', '世界杯球场', 'WorldCupField', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 588, '');
INSERT INTO `center_games` VALUES (589, 9, 29, '98', '世界杯全明星', 'All Star Team', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 589, '');
INSERT INTO `center_games` VALUES (590, 9, 45, 'AB3', '皇金渔场', 'Paradise', '', '', 0, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 590, '');
INSERT INTO `center_games` VALUES (591, 9, 29, '201', '拳霸', 'MuayThai', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 591, '');
INSERT INTO `center_games` VALUES (592, 9, 29, '202', '舞媚娘', 'OrientalBeauty', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 592, '');
INSERT INTO `center_games` VALUES (593, 9, 29, '203', '嗨起来', 'RaveHigh', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 593, '');
INSERT INTO `center_games` VALUES (594, 9, 29, '204', '百宝箱', 'LuckyBoxes', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 594, '');
INSERT INTO `center_games` VALUES (595, 9, 29, '205', '蹦迪', 'DiscoNight', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 595, '');
INSERT INTO `center_games` VALUES (596, 9, 29, '86', '牛逼快跑', 'RunningToro', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 596, '');
INSERT INTO `center_games` VALUES (597, 9, 29, '87', '集电宝', 'GettingEnergies', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 597, '');
INSERT INTO `center_games` VALUES (598, 9, 29, '88', '金喜鹊桥', 'HappyMagpies', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 598, '');
INSERT INTO `center_games` VALUES (599, 9, 29, '89', '雷神', 'Thor', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 599, '');
INSERT INTO `center_games` VALUES (600, 9, 29, '99', '跳更高', 'Jump Higher', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 600, '');
INSERT INTO `center_games` VALUES (601, 9, 29, '105', '单手跳高高', 'Jumping Mobile', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 601, '');
INSERT INTO `center_games` VALUES (602, 9, 29, '100', '宾果消消消', 'Jellypop Humming', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 602, '');
INSERT INTO `center_games` VALUES (603, 9, 29, '101', '星星消消乐', 'Stars Matching', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 603, '');
INSERT INTO `center_games` VALUES (604, 9, 29, '102', '水果派对', 'Fruity Carnival', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 604, '');
INSERT INTO `center_games` VALUES (605, 9, 29, '103', '宝石配对', 'Jewel Luxury', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 605, '');
INSERT INTO `center_games` VALUES (606, 9, 29, '104', '海滨消消乐', 'Chicky Parm Parm', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 606, '');
INSERT INTO `center_games` VALUES (607, 9, 29, '108', '直式跳更高', 'Jump Higher mobile', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 607, '');
INSERT INTO `center_games` VALUES (608, 9, 29, '109', '单手跳起来', 'Rave Jump mobile', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 608, '');
INSERT INTO `center_games` VALUES (609, 9, 29, 'AS10', '幸运3', 'Lucky 3', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 609, '');
INSERT INTO `center_games` VALUES (610, 9, 29, 'AS17', '塞特的宝藏', 'Treasure of Seti', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 610, '');
INSERT INTO `center_games` VALUES (611, 9, 29, 'AS18', '疯狂软糖', 'Wild Fudge', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 611, '');
INSERT INTO `center_games` VALUES (612, 9, 29, 'AN01', '恶魔侦探', 'Demon Archive', '惡魔偵探', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 612, '');
INSERT INTO `center_games` VALUES (613, 9, 29, 'AN02', '雷神托尔', 'Powerful Thor', '雷神索爾', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 613, '');
INSERT INTO `center_games` VALUES (614, 9, 29, 'AN03', '财神', 'God of Fortune', '財神', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 614, '');
INSERT INTO `center_games` VALUES (615, 9, 29, 'AN04', '罗马竞技场', 'Colosseum', '羅馬競技場', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 615, '');
INSERT INTO `center_games` VALUES (616, 9, 29, 'AN05', '金银岛2', 'Treasure Island 2', '金銀島2', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 616, '');
INSERT INTO `center_games` VALUES (617, 9, 29, 'AN06', '开心农场', 'Happy Farm', '開心農場', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 617, '');
INSERT INTO `center_games` VALUES (618, 9, 29, 'AS19', '圣诞故事', 'Xmas Tales', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 618, '');
INSERT INTO `center_games` VALUES (619, 9, 29, '121', '直式跳起来2', 'Rave Jump 2 M', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 619, '');
INSERT INTO `center_games` VALUES (620, 9, 29, '123', '直式五福临门', 'Lucky Bats M', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 620, '');
INSERT INTO `center_games` VALUES (621, 9, 29, '125', '直式宙斯', 'Zeus M', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 621, '');
INSERT INTO `center_games` VALUES (622, 9, 29, '137', '直式蹦迪', 'Disco Night M', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 622, '');
INSERT INTO `center_games` VALUES (623, 9, 29, '135', '直式金鸡报喜', 'Gu Gu Gu M', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 623, '');
INSERT INTO `center_games` VALUES (624, 9, 29, 'AS33', '猪的运气', 'Pig Of Luck', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 624, '');
INSERT INTO `center_games` VALUES (625, 9, 29, '113', '飞天财神', 'Flying Cai Shen', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 625, '');
INSERT INTO `center_games` VALUES (626, 9, 29, '116', '梦游仙境', 'Wonderland', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 626, '');
INSERT INTO `center_games` VALUES (627, 9, 29, '118', '老司机', 'SkrSkr', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 627, '');
INSERT INTO `center_games` VALUES (628, 9, 29, '122', '印加祖玛', 'Zuma Wild', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 628, '');
INSERT INTO `center_games` VALUES (629, 9, 29, 'AR01', '妙笔生财', 'The Magic Brush', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 629, '');
INSERT INTO `center_games` VALUES (630, 9, 29, 'AR02', '喵财进宝', 'Fortune Cats', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 630, '');
INSERT INTO `center_games` VALUES (631, 9, 29, 'AR03', '此地无银三百两', 'Backyard Gold', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 631, '');
INSERT INTO `center_games` VALUES (632, 9, 29, 'AR05', '鱼跃龙门', 'Dragon Gate', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 632, '');
INSERT INTO `center_games` VALUES (633, 9, 29, 'AR06', '丛林宝藏', 'Jungle Treasure', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 633, '');
INSERT INTO `center_games` VALUES (634, 9, 29, 'AR07', '功夫小神通', 'Kickin\' Kash', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 634, '');
INSERT INTO `center_games` VALUES (635, 9, 29, '124', '锁象无敌', 'Invincible Elephant', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 635, '');
INSERT INTO `center_games` VALUES (636, 9, 29, 'AS01', '运气靴', 'Boots Of Luck', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 636, '');
INSERT INTO `center_games` VALUES (637, 9, 29, '117', '东方神起', '5 God beasts', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 637, '');
INSERT INTO `center_games` VALUES (638, 9, 29, 'AS02', '疯狂马戏团', 'Cirque de fous', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 638, '');
INSERT INTO `center_games` VALUES (639, 9, 29, 'AR08', '点石成金', 'Stone to Gold', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 639, '');
INSERT INTO `center_games` VALUES (640, 9, 29, 'AS03', '驯龙高手', 'Dragon Hunters', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 640, '');
INSERT INTO `center_games` VALUES (641, 9, 29, 'AU03', '火烧办公处', 'Burn the Office', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 641, '');
INSERT INTO `center_games` VALUES (642, 9, 29, 'AU06', '厕所囧境', 'Oh Crap', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 642, '');
INSERT INTO `center_games` VALUES (643, 9, 29, 'AR15', '爱琴海', 'Love Story', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 643, '');
INSERT INTO `center_games` VALUES (644, 9, 29, '126', '转珠猪', 'Piggy Farm', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 644, '');
INSERT INTO `center_games` VALUES (645, 9, 29, '128', '转大钱', 'Wheel Money', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 645, '');
INSERT INTO `center_games` VALUES (646, 9, 29, '130', '偷金妹子', 'Gold Stealer', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 646, '');
INSERT INTO `center_games` VALUES (647, 9, 29, '140', '火烧连环船2', 'Fire Chibi 2', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 647, '');
INSERT INTO `center_games` VALUES (648, 9, 45, 'AT01', '一炮捕鱼', 'OneShotFishing', '', '', 0, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 648, '');
INSERT INTO `center_games` VALUES (649, 9, 29, '132', '再喵一个', 'Meow', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 649, '');
INSERT INTO `center_games` VALUES (650, 9, 29, '136', '奔跑吧猛兽', 'Running Animals', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 650, '');
INSERT INTO `center_games` VALUES (651, 9, 29, '138', '跳过来', 'Move n\' Jump', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 651, '');
INSERT INTO `center_games` VALUES (652, 9, 29, '134', '家里有矿', 'Mine at home', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 652, '');
INSERT INTO `center_games` VALUES (653, 9, 29, 'AR41', '斗地主升级版', 'Dou Di Zhu Plus', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 653, '');
INSERT INTO `center_games` VALUES (654, 9, 29, 'AR20', '宝莲灯', 'Lotus Lantern', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 654, '');
INSERT INTO `center_games` VALUES (655, 9, 29, 'AR17', '马戏团连连发', 'Le Cirque', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 655, '');
INSERT INTO `center_games` VALUES (656, 9, 29, 'AR37', '幸运传奇', 'Lucky Legend', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 656, '');
INSERT INTO `center_games` VALUES (657, 9, 29, '142', '火神', 'Hephaestus', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 657, '');
INSERT INTO `center_games` VALUES (658, 9, 29, '143', '发财福娃', 'Fa Cai Fu Wa', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 658, '');
INSERT INTO `center_games` VALUES (659, 9, 29, '145', '印金工厂', 'Casting Gold', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 659, '');
INSERT INTO `center_games` VALUES (660, 9, 29, '157', '五形拳', '5 Boxing', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 660, '');
INSERT INTO `center_games` VALUES (661, 9, 29, '144', '钻更多', 'Diamond Treasure', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 661, '');
INSERT INTO `center_games` VALUES (662, 9, 29, '148', '有如神柱', 'Fortune Totem', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 662, '');
INSERT INTO `center_games` VALUES (663, 9, 29, 'AR12', '8级台风', 'Typhoon Cash', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 663, '');
INSERT INTO `center_games` VALUES (664, 9, 29, 'AR16', '守株待兔', 'Rabbit Rampage', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 664, '');
INSERT INTO `center_games` VALUES (665, 9, 29, 'AR18', '财运亨通', 'Eternal Fortune', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 665, '');
INSERT INTO `center_games` VALUES (666, 9, 29, 'AR21', '鹊桥', 'Magpie Bridge', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 666, '');
INSERT INTO `center_games` VALUES (667, 9, 29, 'AR24', '麻将小福星', 'Xiao Fu Xing', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 667, '');
INSERT INTO `center_games` VALUES (668, 9, 29, 'AR39', '僵尸的宝藏', 'Zombie\'s Fortune', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 668, '');
INSERT INTO `center_games` VALUES (669, 9, 29, '147', '花开富贵', 'Flower Fortunes', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 669, '');
INSERT INTO `center_games` VALUES (670, 9, 29, '146', '九连宝灯', 'Sky Lantern', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 670, '');
INSERT INTO `center_games` VALUES (671, 9, 29, 'AR29', '富贵金鸡', 'Wealthy Chicken', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 671, '');
INSERT INTO `center_games` VALUES (672, 9, 29, '153', '六颗糖', 'Six Candy', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 672, '');
INSERT INTO `center_games` VALUES (673, 9, 29, '149', '龙舟', 'Dragon Boat', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 673, '');
INSERT INTO `center_games` VALUES (674, 9, 29, '150', '寿星大发', 'Shou-Xin', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 674, '');
INSERT INTO `center_games` VALUES (675, 9, 29, '152', '双飞', 'Double Fly', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 675, '');
INSERT INTO `center_games` VALUES (676, 9, 29, '154', '宙斯他爹', 'Kronos', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 676, '');
INSERT INTO `center_games` VALUES (677, 9, 29, '151', '龙虎水果机', 'Dragon Tiger Fruit Slot', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 677, '');
INSERT INTO `center_games` VALUES (678, 9, 29, '160', '发财神2', 'Fa Cai Shen2', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 678, '');
INSERT INTO `center_games` VALUES (679, 9, 29, '163', '哪吒再临', 'Ne Zha Advent', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 679, '');
INSERT INTO `center_games` VALUES (680, 9, 29, '161', '大力神', 'Hercules', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 680, '');
INSERT INTO `center_games` VALUES (681, 5, 10, '1355', '搏一搏', '', '', '', 1355, 2, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '', 2, 1, 1, 681, '无独立入口');
INSERT INTO `center_games` VALUES (682, 5, 10, '1810', '单挑牛牛', '', '', '', 1810, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 682, '');
INSERT INTO `center_games` VALUES (683, 5, 10, '1990', '炸金牛', '', '', '', 1990, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 683, '');
INSERT INTO `center_games` VALUES (684, 5, 10, '1660', '血战到底', '', '', '', 1660, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 684, '');
INSERT INTO `center_games` VALUES (685, 5, 10, '1980', '百人骰宝', '', '', '', 1980, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 685, '');
INSERT INTO `center_games` VALUES (686, 5, 10, '1850', '押宝抢庄牛牛', '', '', '', 1850, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 686, '');
INSERT INTO `center_games` VALUES (687, 5, 10, '890', '看牌抢庄牛牛', '', '', '', 890, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 687, '');
INSERT INTO `center_games` VALUES (688, 5, 10, '1350', '幸运转盘', '', '', '', 1350, 2, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '', 2, 1, 1, 688, '');
INSERT INTO `center_games` VALUES (690, 5, 10, '650', '血流成河', '', '', '', 650, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 690, '');
INSERT INTO `center_games` VALUES (782, 5, 10, '1960', '奔驰宝马', '', '', '', 1960, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 782, '');
INSERT INTO `center_games` VALUES (691, 5, 10, '1940', '金鲨银鲨', '', '', '', 1940, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 691, '');
INSERT INTO `center_games` VALUES (692, 10, 44, '7003', '财神捕鱼', 'CaiShen Fishing', '', 'https://dl.55copy.com/jdb-assetsv3/games/7003/7003_cn.jpg', 0, 3, 0, 0, 0.00, 0.00, 0.00, 1, 1, 0, '7', 2, 1, 1, 692, '');
INSERT INTO `center_games` VALUES (693, 10, 44, '7004', '五龙捕鱼', 'Five Dragons Fishing', '', 'https://dl.55copy.com/jdb-assetsv3/games/7004/7004_cn.jpg', 0, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '7', 2, 1, 1, 693, '');
INSERT INTO `center_games` VALUES (694, 10, 44, '7002', '龙王捕鱼 2', 'Dragon Fishish 2', '', 'https://dl.55copy.com/jdb-assetsv3/games/7002/7002_cn.jpg', 0, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '7', 2, 1, 1, 694, '');
INSERT INTO `center_games` VALUES (695, 10, 44, '7001', '龙王捕鱼', 'Dragon Fishish', '', 'https://dl.55copy.com/jdb-assetsv3/games/7001/7001_cn.jpg', 0, 3, 0, 0, 0.00, 0.00, 0.00, 1, 1, 0, '7', 2, 1, 1, 695, '');
INSERT INTO `center_games` VALUES (696, 10, 28, '8047', '变脸II', 'WinningMaskII', '', 'https://dl.55copy.com/jdb-assetsv3/games/8047/8047_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 696, '');
INSERT INTO `center_games` VALUES (697, 10, 28, '8048', '芝麻开门II', 'OpenSesameII', '', 'https://dl.55copy.com/jdb-assetsv3/games/8048/8048_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 697, '');
INSERT INTO `center_games` VALUES (698, 10, 28, '8046', '关公', 'Guan Gong', '', 'https://dl.55copy.com/jdb-assetsv3/games/8046/8046_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 698, '');
INSERT INTO `center_games` VALUES (699, 10, 28, '8036', '龙王', 'Dragon King', '', 'https://dl.55copy.com/jdb-assetsv3/games/8036/8036_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 699, '');
INSERT INTO `center_games` VALUES (700, 10, 28, '8035', '幸运凤', 'Lucky Phoenix', '', 'https://dl.55copy.com/jdb-assetsv3/games/8035/8035_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 700, '');
INSERT INTO `center_games` VALUES (701, 10, 28, '8031', '金饺子', 'Super Dumpling', '', 'https://dl.55copy.com/jdb-assetsv3/games/8031/8031_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 701, '');
INSERT INTO `center_games` VALUES (702, 10, 28, '8030', '疯狂科学家', 'Crazy Scientist', '', 'https://dl.55copy.com/jdb-assetsv3/games/8030/8030_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 702, '');
INSERT INTO `center_games` VALUES (703, 10, 28, '8028', '幸运淘金鼠', 'Lucky Miner', '', 'https://dl.55copy.com/jdb-assetsv3/games/8028/8028_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 703, '');
INSERT INTO `center_games` VALUES (704, 10, 28, '8025', '神偷妙贼', 'Burglar', '', 'https://dl.55copy.com/jdb-assetsv3/games/8025/8025_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 704, '');
INSERT INTO `center_games` VALUES (705, 10, 28, '8024', '水晶王国', 'Crystal Realm', '', 'https://dl.55copy.com/jdb-assetsv3/games/8024/8024_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 705, '');
INSERT INTO `center_games` VALUES (706, 10, 28, '8022', '麻雀无双', 'MahJong', '', 'https://dl.55copy.com/jdb-assetsv3/games/8022/8022_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 706, '');
INSERT INTO `center_games` VALUES (707, 10, 28, '8029', '奇幻糖果岛', 'Candy Land', '', 'https://dl.55copy.com/jdb-assetsv3/games/8029/8029_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 707, '');
INSERT INTO `center_games` VALUES (708, 10, 28, '8044', '江山美人', 'Beauty And The Kingdom', '', 'https://dl.55copy.com/jdb-assetsv3/games/8044/8044_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 708, '');
INSERT INTO `center_games` VALUES (709, 10, 28, '8034', '金钱侠', 'Cash Man', '', 'https://dl.55copy.com/jdb-assetsv3/games/8034/8034_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 709, '');
INSERT INTO `center_games` VALUES (710, 10, 28, '8027', '料理厨王', 'Chef d\'oeuvre', '', 'https://dl.55copy.com/jdb-assetsv3/games/8027/8027_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 710, '');
INSERT INTO `center_games` VALUES (711, 10, 28, '8001', '幸运龙', 'Lucky Dragons', '', 'https://dl.55copy.com/jdb-assetsv3/games/8001/8001_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 711, '');
INSERT INTO `center_games` VALUES (712, 10, 28, '8007', '幸运麟', 'Lucky Qilin', '', 'https://dl.55copy.com/jdb-assetsv3/games/8007/8007_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 712, '');
INSERT INTO `center_games` VALUES (713, 10, 28, '8021', '黄金香蕉帝国', 'Banana Saga', '', 'https://dl.55copy.com/jdb-assetsv3/games/8021/8021_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 713, '');
INSERT INTO `center_games` VALUES (714, 10, 28, '8003', '变脸', 'Winning Mask', '', 'https://dl.55copy.com/jdb-assetsv3/games/8003/8003_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 1, 0, '0', 2, 1, 1, 714, '');
INSERT INTO `center_games` VALUES (715, 10, 28, '8006', '台湾黑熊', 'Formosa Bear', '', 'https://dl.55copy.com/jdb-assetsv3/games/8006/8006_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 715, '');
INSERT INTO `center_games` VALUES (716, 10, 28, '8017', '过新年', 'New Year', '', 'https://dl.55copy.com/jdb-assetsv3/games/8017/8017_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 716, '');
INSERT INTO `center_games` VALUES (717, 10, 28, '8002', '唐伯虎点秋香', 'Flirting Scholar Tang', '', 'https://dl.55copy.com/jdb-assetsv3/games/8002/8002_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 717, '');
INSERT INTO `center_games` VALUES (718, 10, 28, '8018', '拿破仑', 'Napoleon', '', 'https://dl.55copy.com/jdb-assetsv3/games/8018/8018_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 718, '');
INSERT INTO `center_games` VALUES (719, 10, 28, '8005', '骆马大冒险', 'Llama Adventure', '', 'https://dl.55copy.com/jdb-assetsv3/games/8005/8005_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 719, '');
INSERT INTO `center_games` VALUES (720, 10, 28, '8020', '芝麻开门', 'Open Sesame', '', 'https://dl.55copy.com/jdb-assetsv3/games/8020/8020_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 720, '');
INSERT INTO `center_games` VALUES (721, 10, 28, '8004', '悟空', 'Wu Kong', '', 'https://dl.55copy.com/jdb-assetsv3/games/8004/8004_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 721, '');
INSERT INTO `center_games` VALUES (722, 10, 28, '8015', '月光秘宝', 'Moonlight Treasure', '', 'https://dl.55copy.com/jdb-assetsv3/games/8015/8015_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 722, '');
INSERT INTO `center_games` VALUES (723, 10, 28, '8014', '招财狮', 'Lucky Lion', '', 'https://dl.55copy.com/jdb-assetsv3/games/8014/8014_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 723, '');
INSERT INTO `center_games` VALUES (724, 10, 28, '8016', '上班族狂想曲', 'Coffeeholics', '', 'https://dl.55copy.com/jdb-assetsv3/games/8016/8016_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 724, '');
INSERT INTO `center_games` VALUES (725, 10, 28, '8037', '魔术秀', 'Magic Show', '', 'https://dl.55copy.com/jdb-assetsv3/games/8037/8037_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 725, '');
INSERT INTO `center_games` VALUES (726, 10, 28, '8023', '奥林匹亚神庙', 'Olympian Temple', '', 'https://dl.55copy.com/jdb-assetsv3/games/8023/8023_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 726, '');
INSERT INTO `center_games` VALUES (727, 10, 28, '8019', '文房四宝', 'Four Treasures', '', 'https://dl.55copy.com/jdb-assetsv3/games/8019/8019_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 727, '');
INSERT INTO `center_games` VALUES (728, 10, 28, '8026', '热舞教父', 'Dancing Papa', '', 'https://dl.55copy.com/jdb-assetsv3/games/8026/8026_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 728, '');
INSERT INTO `center_games` VALUES (729, 10, 28, '8051', '喜洋羊', 'Xi Yang Yang', '', 'https://dl.55copy.com/jdb-assetsv3/games/8051/8051_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 729, '');
INSERT INTO `center_games` VALUES (730, 10, 28, '8050', '马上有钱', 'Fortune Horse', '', 'https://dl.55copy.com/jdb-assetsv3/games/8050/8050_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 730, '');
INSERT INTO `center_games` VALUES (731, 10, 28, '8049', '唐伯虎点秋香II', 'FlirtingScholarTangII', '', 'https://dl.55copy.com/jdb-assetsv3/games/8049/8049_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 731, '');
INSERT INTO `center_games` VALUES (732, 10, 28, '14040', '七海夺宝', 'PirateTreasure', '', 'https://dl.55copy.com/jdb-assetsv3/games/14040/14040_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 732, '');
INSERT INTO `center_games` VALUES (733, 10, 28, '14038', '埃及夺宝', 'EgyptTreasure', '', 'https://dl.55copy.com/jdb-assetsv3/games/14038/14038_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 733, '');
INSERT INTO `center_games` VALUES (734, 10, 28, '14034', '狗来富', 'Go Lai Fu', '', 'https://dl.55copy.com/jdb-assetsv3/games/14034/14034_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 734, '');
INSERT INTO `center_games` VALUES (735, 10, 28, '14023', '赌王扑克', 'PokerKing', '', 'https://dl.55copy.com/jdb-assetsv3/games/14023/14023_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 735, '');
INSERT INTO `center_games` VALUES (736, 10, 28, '14001', '斗鸡', 'Cock Fight', '', 'https://dl.55copy.com/jdb-assetsv3/games/14001/14001_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 736, '');
INSERT INTO `center_games` VALUES (737, 10, 28, '14002', '玛雅', 'Maya Run', '', 'https://dl.55copy.com/jdb-assetsv3/games/14002/14002_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 737, '');
INSERT INTO `center_games` VALUES (738, 10, 28, '14003', '屌丝熊猫', 'Panda Panda', '', 'https://dl.55copy.com/jdb-assetsv3/games/14003/14003_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 738, '');
INSERT INTO `center_games` VALUES (739, 10, 28, '14004', '塞尔达传说', 'Zelda', '', 'https://dl.55copy.com/jdb-assetsv3/games/14004/14004_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 739, '');
INSERT INTO `center_games` VALUES (740, 10, 28, '14005', '包大人', 'MrBao', '', 'https://dl.55copy.com/jdb-assetsv3/games/14005/14005_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 740, '');
INSERT INTO `center_games` VALUES (741, 10, 28, '14006', '亿万富翁', 'Billionaire', '', 'https://dl.55copy.com/jdb-assetsv3/games/14006/14006_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 741, '');
INSERT INTO `center_games` VALUES (742, 10, 28, '14007', '一拳超人', 'One Punch Man', '', 'https://dl.55copy.com/jdb-assetsv3/games/14007/14007_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 742, '');
INSERT INTO `center_games` VALUES (743, 10, 28, '14008', '神龙大侠', 'Dragon Warrior', '', 'https://dl.55copy.com/jdb-assetsv3/games/14008/14008_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 743, '');
INSERT INTO `center_games` VALUES (744, 10, 28, '14010', '飞龙在天', 'Dragon', '', 'https://dl.55copy.com/jdb-assetsv3/games/14010/14010_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 744, '');
INSERT INTO `center_games` VALUES (745, 10, 28, '14011', '银河护卫队', 'Guardians Of The Galaxy', '', 'https://dl.55copy.com/jdb-assetsv3/games/14011/14011_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 745, '');
INSERT INTO `center_games` VALUES (746, 10, 28, '14012', '街头霸王', 'Street Fighter', '', 'https://dl.55copy.com/jdb-assetsv3/games/14012/14012_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 746, '');
INSERT INTO `center_games` VALUES (747, 10, 28, '14015', '星球大战', 'Star Wars', '', 'https://dl.55copy.com/jdb-assetsv3/games/14015/14015_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 747, '');
INSERT INTO `center_games` VALUES (748, 10, 28, '14016', '王牌特工', 'Kingsman', '', 'https://dl.55copy.com/jdb-assetsv3/games/14016/14016_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 748, '');
INSERT INTO `center_games` VALUES (749, 10, 28, '14017', '少女前线', 'War Of Beauty', '', 'https://dl.55copy.com/jdb-assetsv3/games/14017/14017_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 749, '');
INSERT INTO `center_games` VALUES (750, 10, 28, '14025', '幸运赛车', 'LuckyRacing', '', 'https://dl.55copy.com/jdb-assetsv3/games/14025/14025_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 750, '');
INSERT INTO `center_games` VALUES (751, 10, 28, '14019', '宝石物语', 'Gems Gems', '', 'https://dl.55copy.com/jdb-assetsv3/games/14019/14019_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 751, '');
INSERT INTO `center_games` VALUES (752, 10, 28, '14021', '钱滚钱', 'Rolling In Money', '', 'https://dl.55copy.com/jdb-assetsv3/games/14021/14021_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 752, '');
INSERT INTO `center_games` VALUES (753, 10, 28, '14022', '采矿土豪', 'Mining Upstart', '', 'https://dl.55copy.com/jdb-assetsv3/games/14022/14022_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 753, '');
INSERT INTO `center_games` VALUES (754, 10, 28, '14026', '发大财', 'FaDaCai', '', 'https://dl.55copy.com/jdb-assetsv3/games/14026/14026_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 754, '');
INSERT INTO `center_games` VALUES (755, 10, 28, '14027', '好运777', 'LuckySeven', '', 'https://dl.55copy.com/jdb-assetsv3/games/14027/14027_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 755, '');
INSERT INTO `center_games` VALUES (756, 10, 28, '14033', '飞鸟派对', 'Birds Party', '', 'https://dl.55copy.com/jdb-assetsv3/games/14033/14033_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 756, '');
INSERT INTO `center_games` VALUES (757, 10, 28, '14030', '三倍金刚', 'TripleKingKong', '', 'https://dl.55copy.com/jdb-assetsv3/games/14030/14030_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 757, '');
INSERT INTO `center_games` VALUES (758, 10, 28, '14013', '春宵苦短', 'ChinaRouge', '', 'https://dl.55copy.com/jdb-assetsv3/games/14013/14013_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 758, '');
INSERT INTO `center_games` VALUES (759, 10, 28, '14039', '开运夺宝', 'Fortune Treasure', '', 'https://dl.55copy.com/jdb-assetsv3/games/14039/14039_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 759, '');
INSERT INTO `center_games` VALUES (760, 10, 28, '14029', '东方神兽', 'OrientAnimals', '', 'https://dl.55copy.com/jdb-assetsv3/games/14029/14029_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 760, '');
INSERT INTO `center_games` VALUES (761, 10, 28, '14036', '超级牛B', 'Super Nuibi', '', 'https://dl.55copy.com/jdb-assetsv3/games/14036/14036_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 761, '');
INSERT INTO `center_games` VALUES (762, 10, 28, '14035', '龙舞', 'Dragons World', '', 'https://dl.55copy.com/jdb-assetsv3/games/14035/14035_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 762, '');
INSERT INTO `center_games` VALUES (763, 10, 28, '14018', '妲己', 'DaJi', '', 'https://dl.55copy.com/jdb-assetsv3/games/14018/14018_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 763, '');
INSERT INTO `center_games` VALUES (764, 10, 28, '14020', '魔法乳神', 'CurvyMagician', '', 'https://dl.55copy.com/jdb-assetsv3/games/14020/14020_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 764, '');
INSERT INTO `center_games` VALUES (765, 10, 28, '15005', '幸运福娃', 'Lucky Fuwa', '', 'https://dl.55copy.com/jdb-assetsv3/games/15005/15005_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 765, '');
INSERT INTO `center_games` VALUES (766, 10, 28, '15012', '五福临门', 'Legendary5', '', 'https://dl.55copy.com/jdb-assetsv3/games/15012/15012_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 766, '');
INSERT INTO `center_games` VALUES (767, 10, 28, '15009', '忍者大进击', 'Ninja Rush', '', 'https://dl.55copy.com/jdb-assetsv3/games/15009/15009_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 767, '');
INSERT INTO `center_games` VALUES (768, 10, 28, '15004', '火牛阵', 'Fire Bull', '', 'https://dl.55copy.com/jdb-assetsv3/games/15004/15004_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 768, '');
INSERT INTO `center_games` VALUES (769, 10, 28, '15006', '印加帝国', 'Inca Empire', '', 'https://dl.55copy.com/jdb-assetsv3/games/15006/15006_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 769, '');
INSERT INTO `center_games` VALUES (770, 10, 28, '15010', '熊猫厨王', 'Chef Panda', '', 'https://dl.55copy.com/jdb-assetsv3/games/15010/15010_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 770, '');
INSERT INTO `center_games` VALUES (771, 10, 28, '15013', '九尾狐', 'Mystery of Ninetails', '', 'https://dl.55copy.com/jdb-assetsv3/games/15013/15013_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 771, '');
INSERT INTO `center_games` VALUES (772, 10, 28, '15002', '齐天大圣', 'Monkey King', '', 'https://dl.55copy.com/jdb-assetsv3/games/15002/15002_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 772, '');
INSERT INTO `center_games` VALUES (773, 10, 28, '15001', '金鸡报囍', 'Rooster In Love', '', 'https://dl.55copy.com/jdb-assetsv3/games/15001/15001_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 773, '');
INSERT INTO `center_games` VALUES (774, 10, 28, '15011', '后羿傳', 'Sun Archer', '', 'https://dl.55copy.com/jdb-assetsv3/games/15011/15011_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '0', 2, 1, 1, 774, '');
INSERT INTO `center_games` VALUES (775, 10, 28, '9007', '超激发水果盘', 'SuperSuperFruit', '', 'https://dl.55copy.com/jdb-assetsv3/games/9007/9007_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '9', 2, 1, 1, 775, '');
INSERT INTO `center_games` VALUES (776, 10, 28, '9006', '花果山传奇', 'HuaguoshanLegends', '', 'https://dl.55copy.com/jdb-assetsv3/games/9006/9006_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '9', 2, 1, 1, 776, '');
INSERT INTO `center_games` VALUES (777, 10, 28, '9001', '小玛莉', 'Classic Mario', '', 'https://dl.55copy.com/jdb-assetsv3/games/9001/9001_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '9', 2, 1, 1, 777, '');
INSERT INTO `center_games` VALUES (778, 10, 28, '9002', '新年快乐', 'Happy New Year', '', 'https://dl.55copy.com/jdb-assetsv3/games/9002/9002_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '9', 2, 1, 1, 778, '');
INSERT INTO `center_games` VALUES (779, 10, 28, '9003', '飞禽走兽', 'Birds And Animals', '', 'https://dl.55copy.com/jdb-assetsv3/games/9003/9003_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '9', 2, 1, 1, 779, '');
INSERT INTO `center_games` VALUES (780, 10, 28, '9004', '啤酒大亨', 'Beer Tycoon', '', 'https://dl.55copy.com/jdb-assetsv3/games/9004/9004_cn.jpg', 0, 1, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '9', 2, 1, 1, 780, '');
INSERT INTO `center_games` VALUES (781, 5, 42, '510', '红包捕鱼', '', '', '', 510, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 781, '');
INSERT INTO `center_games` VALUES (784, 10, 40, '18006', '押庄龙虎斗', 'DragonTiger', '', 'https://dl.55copy.com/jdb-assetsv3/games/18006/18006_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 1, 0, '18', 2, 1, 1, 784, '');
INSERT INTO `center_games` VALUES (785, 10, 40, '18017', '抢庄三公', 'Sangong', '', 'https://dl.55copy.com/jdb-assetsv3/games/18017/18017_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 785, '');
INSERT INTO `center_games` VALUES (786, 10, 40, '18010', '金葫芦5PK', 'Golden FullHouse 5PK', '', 'https://dl.55copy.com/jdb-assetsv3/games/18010/18010_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 786, '');
INSERT INTO `center_games` VALUES (787, 10, 40, '18001', '通比牛牛', 'Tongbi Niu Niu', '', 'https://dl.55copy.com/jdb-assetsv3/games/18001/18001_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 787, '');
INSERT INTO `center_games` VALUES (788, 10, 40, '18002', '抢庄牛牛', 'Qiang Zhuang Niu Niu', '', 'https://dl.55copy.com/jdb-assetsv3/games/18002/18002_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 788, '');
INSERT INTO `center_games` VALUES (789, 10, 40, '18015', '千变百人牛牛', 'Joker Bet NiuNiu', '', 'https://dl.55copy.com/jdb-assetsv3/games/18015/18015_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 1, 0, '18', 2, 1, 1, 789, '');
INSERT INTO `center_games` VALUES (790, 10, 40, '18011', '幸运星5PK', 'Lucky Stars 5PK', '', 'https://dl.55copy.com/jdb-assetsv3/games/18011/18011_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 790, '');
INSERT INTO `center_games` VALUES (791, 10, 40, '18016', '极速炸金花', 'Rush Golden Flower', '', 'https://dl.55copy.com/jdb-assetsv3/games/18016/18016_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 791, '');
INSERT INTO `center_games` VALUES (792, 10, 40, '18004', '押庄射龙门', 'Ya Zhuang Acey Deucey', '', 'https://dl.55copy.com/jdb-assetsv3/games/18004/18004_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 792, '');
INSERT INTO `center_games` VALUES (793, 11, 8, '0', '大厅', '', '', NULL, 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 793, '');
INSERT INTO `center_games` VALUES (794, 11, 8, '620', '德州扑克', '', '', NULL, 620, 2, 0, 0, 0.00, 0.00, 0.00, 1, 1, 0, '', 2, 1, 1, 794, '');
INSERT INTO `center_games` VALUES (795, 11, 8, '720', '二八杠', '', '', NULL, 720, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 795, '');
INSERT INTO `center_games` VALUES (796, 11, 8, '830', '抢庄牛牛', NULL, '', NULL, 830, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 796, '');
INSERT INTO `center_games` VALUES (797, 11, 8, '220', '炸金花', NULL, '', NULL, 220, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 797, '');
INSERT INTO `center_games` VALUES (798, 11, 8, '860', '三公', NULL, '', NULL, 860, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 798, '');
INSERT INTO `center_games` VALUES (799, 11, 8, '900', '龙虎斗', NULL, '', NULL, 900, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 799, '');
INSERT INTO `center_games` VALUES (800, 11, 8, '600', '21 点', NULL, '', NULL, 600, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 800, '');
INSERT INTO `center_games` VALUES (801, 11, 8, '870', '通比牛牛', NULL, '', NULL, 870, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 801, '');
INSERT INTO `center_games` VALUES (802, 11, 8, '230', '极速炸金花', NULL, '', NULL, 230, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 802, '');
INSERT INTO `center_games` VALUES (803, 11, 8, '730', '抢庄牌九', NULL, '', NULL, 730, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 803, '');
INSERT INTO `center_games` VALUES (804, 11, 8, '630', '十三水', NULL, '', NULL, 630, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 804, '');
INSERT INTO `center_games` VALUES (805, 11, 8, '610', '斗地主', NULL, '', NULL, 610, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 805, '');
INSERT INTO `center_games` VALUES (806, 11, 8, '890', '看三张抢庄牛牛', NULL, '', NULL, 890, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 806, '');
INSERT INTO `center_games` VALUES (807, 11, 8, '910', '百家乐', NULL, '', NULL, 910, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 807, '');
INSERT INTO `center_games` VALUES (808, 11, 8, '950', '红黑大战', NULL, '', NULL, 950, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 808, '');
INSERT INTO `center_games` VALUES (809, 11, 8, '740', '二人麻将', NULL, '', NULL, 740, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 809, '');
INSERT INTO `center_games` VALUES (810, 11, 8, '930', '百人牛牛', NULL, '', NULL, 930, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 810, '');
INSERT INTO `center_games` VALUES (811, 11, 43, '510', '捕鱼大作战', NULL, '', NULL, 510, 3, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 811, '');
INSERT INTO `center_games` VALUES (812, 11, 8, '8120', '血战到底', NULL, '', NULL, 8120, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 812, '');
INSERT INTO `center_games` VALUES (813, 11, 8, '920', '森林舞会', NULL, '', NULL, 920, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 813, '');
INSERT INTO `center_games` VALUES (814, 11, 8, '8150', '看四张抢庄牛牛', NULL, '', NULL, 8150, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 814, '');
INSERT INTO `center_games` VALUES (815, 11, 8, '8180', '宝石消消乐', NULL, '', NULL, 8180, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 815, '');
INSERT INTO `center_games` VALUES (816, 11, 8, '8160', '癞子牛牛', NULL, '', NULL, 8160, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 816, '');
INSERT INTO `center_games` VALUES (817, 11, 8, '8210', '搏一搏', NULL, '', NULL, 8210, 2, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '', 2, 1, 1, 817, '无独立入口');
INSERT INTO `center_games` VALUES (818, 11, 8, '8130', '跑得快', '', '', '', 8130, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 818, '');
INSERT INTO `center_games` VALUES (819, 12, NULL, '0', '大厅', NULL, '', '', 0, 5, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '', 2, 1, 1, 819, '');
INSERT INTO `center_games` VALUES (820, 3, 25, '3020', '走地百家乐', '', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '', 2, 1, 1, 820, '');
INSERT INTO `center_games` VALUES (823, 10, 40, '18008', '通比德州斗牛', 'Texas TB NiuNiu', '', 'https://dl.55copy.com/jdb-assetsv3/games/18008/18008_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 823, '');
INSERT INTO `center_games` VALUES (824, 10, 40, '18012', '百变抢庄牛牛', 'Joker QZ NiuNiu', '', 'https://dl.55copy.com/jdb-assetsv3/games/18012/18012_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 824, '');
INSERT INTO `center_games` VALUES (825, 10, 40, '18018', '德州抢庄斗牛', 'Texas QZ NiuNiu', '', 'https://dl.55copy.com/jdb-assetsv3/games/18018/18018_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 825, '');
INSERT INTO `center_games` VALUES (826, 10, 40, '18014', '抢庄六牛', 'Qiang Zhuang Liu Niu', '', 'https://dl.55copy.com/jdb-assetsv3/games/18014/18014_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 826, '');
INSERT INTO `center_games` VALUES (827, 10, 40, '18013', '通比六牛', 'Tong bi Liu Niu', '', 'https://dl.55copy.com/jdb-assetsv3/games/18013/18013_cn.jpg', 0, 2, 0, 0, 0.00, 0.00, 0.00, 1, 0, 0, '18', 2, 1, 1, 827, '');
INSERT INTO `center_games` VALUES (828, 6, 31, '', '真人大厅', 'live', NULL, '', 0, 5, 0, 0, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 402, '');
INSERT INTO `center_games` VALUES (829, 2, NULL, '', '', '', '', '', 1, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '', 2, 1, 1, 1, '0');
INSERT INTO `center_games` VALUES (830, 3, NULL, '5154', '', '', '', '', 0, 1, 0, 0, 0.00, 0.00, 0.00, 2, 0, 0, '', 2, 1, 1, 1, '0');

-- ----------------------------
-- Table structure for center_lock
-- ----------------------------
DROP TABLE IF EXISTS `center_lock`;
CREATE TABLE `center_lock`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `did` int(10) NOT NULL DEFAULT 0,
  `add_time` int(10) NOT NULL COMMENT '0',
  `tablename` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING HASH,
  INDEX `id`(`id`) USING BTREE,
  INDEX `did`(`did`) USING BTREE,
  INDEX `tablename`(`tablename`) USING BTREE
) ENGINE = MEMORY AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for center_platform
-- ----------------------------
DROP TABLE IF EXISTS `center_platform`;
CREATE TABLE `center_platform`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '平台名称',
  `module_status` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '平台游戏状态配置',
  `remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '备注名称',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '平台状态，1为启用，2为停止',
  `class_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '类文件名称',
  `paixu` int(8) NULL DEFAULT NULL COMMENT '显示顺序',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `paixu`(`paixu`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of center_platform
-- ----------------------------
INSERT INTO `center_platform` VALUES (1, 'FG乐游', '{\"1\":1,\"2\":1,\"3\":1}', '', 1, 'fg', 1);
INSERT INTO `center_platform` VALUES (2, '761', '{\"1\":1,\"2\":1,\"3\":1}', NULL, 1, 'api761', 2);
INSERT INTO `center_platform` VALUES (3, 'BBIN', '{\"1\":1,\"3\":1,\"5\":1,\"6\":1}', NULL, 1, 'bbin', 3);
INSERT INTO `center_platform` VALUES (4, '泛亚电竞', '{\"6\":1}', NULL, 1, 'fanya', 4);
INSERT INTO `center_platform` VALUES (5, '开元棋牌', '{\"2\":1,\"3\":1}', NULL, 1, 'ky', 5);
INSERT INTO `center_platform` VALUES (6, 'BG', '{\"1\":1,\"3\":1,\"5\":1}', NULL, 1, 'bg', 6);
INSERT INTO `center_platform` VALUES (7, 'DG', '{\"5\":1}', NULL, 1, 'dg', 7);
INSERT INTO `center_platform` VALUES (8, 'UG', '{\"6\":1}', NULL, 1, 'ug', 8);
INSERT INTO `center_platform` VALUES (9, 'CQ9', '{\"1\":1,\"2\":1,\"3\":1}', NULL, 1, 'cq9', 9);
INSERT INTO `center_platform` VALUES (10, 'JDB', '{\"1\":1,\"2\":1,\"3\":1}', NULL, 1, 'jdb', 10);
INSERT INTO `center_platform` VALUES (11, 'LEG', '{\"2\":1,\"3\":1}', NULL, 1, 'leg', 11);

-- ----------------------------
-- Table structure for center_runtime
-- ----------------------------
DROP TABLE IF EXISTS `center_runtime`;
CREATE TABLE `center_runtime`  (
  `k` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `v` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`k`) USING HASH
) ENGINE = MEMORY CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

SET FOREIGN_KEY_CHECKS = 1;
