/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : caiji_trunk

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 29/07/2019 00:15:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cj_client
-- ----------------------------
DROP TABLE IF EXISTS `cj_client`;
CREATE TABLE `cj_client`  (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '子端ID',
  `key` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '接口KEY',
  `stuat` int(1) NOT NULL DEFAULT 1 COMMENT '子端状态，1为有效，2为停止',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `stuat`(`stuat`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cj_client
-- ----------------------------
INSERT INTO `cj_client` VALUES (1, 'caiji', 1);
INSERT INTO `cj_client` VALUES (2, 'caiji', 1);
INSERT INTO `cj_client` VALUES (3, 'caiji', 1);
INSERT INTO `cj_client` VALUES (4, 'caiji', 1);
INSERT INTO `cj_client` VALUES (5, 'caiji', 1);

SET FOREIGN_KEY_CHECKS = 1;
