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

 Date: 22/08/2023 12:07:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tpp_authorizer_token
-- ----------------------------
DROP TABLE IF EXISTS `tpp_authorizer_token`;
CREATE TABLE `tpp_authorizer_token`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `authorizer_appid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `authorizer_access_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `authorizer_refresh_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `expire_at` int(11) NULL DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1授权 2未授权',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
