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

 Date: 22/08/2023 12:07:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tpp
-- ----------------------------
DROP TABLE IF EXISTS `tpp`;
CREATE TABLE `tpp`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `CreateTime` int(11) NULL DEFAULT NULL,
  `AuthorizationCodeExpiredTime` int(11) NULL DEFAULT NULL,
  `AppId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `InfoType` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `AuthorizerAppid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `AuthorizationCode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `PreAuthCode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `ComponentVerifyTicket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3922 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
