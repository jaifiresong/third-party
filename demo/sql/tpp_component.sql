/*
 Navicat MySQL Data Transfer

 Source Server         : huiyang_polar
 Source Server Type    : MySQL
 Source Server Version : 50616
 Source Host           : 47.96.123.101:4417
 Source Schema         : lzlj-qdgl

 Target Server Type    : MySQL
 Target Server Version : 50616
 File Encoding         : 65001

 Date: 22/08/2023 12:07:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tpp_component
-- ----------------------------
DROP TABLE IF EXISTS `tpp_component`;
CREATE TABLE `tpp_component`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `AppId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '平台APPID',
  `component_access_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '平台TOKEN',
  `expire_at` int(11) NULL DEFAULT NULL COMMENT '过期时间',
  `pre_auth_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `pre_auth_code_expire_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
