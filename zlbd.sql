/*
Navicat MySQL Data Transfer

Source Server         : 118.190.17.96_3306
Source Server Version : 50513
Source Host           : 118.190.17.96:3306
Source Database       : zlbd

Target Server Type    : MYSQL
Target Server Version : 50513
File Encoding         : 65001

Date: 2018-08-13 14:02:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `zxcms_admin`
-- ----------------------------
DROP TABLE IF EXISTS `zxcms_admin`;
CREATE TABLE `zxcms_admin` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `encrypt` varchar(6) NOT NULL DEFAULT '',
  `lastloginip` int(10) NOT NULL DEFAULT '0',
  `lastlogintime` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(40) NOT NULL DEFAULT '',
  `mobile` varchar(11) NOT NULL DEFAULT '',
  `realname` varchar(50) NOT NULL DEFAULT '',
  `openid` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(2:无效,1:有效)',
  `updatetime` int(10) NOT NULL DEFAULT '0',
  `uid` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxcms_admin
-- ----------------------------
INSERT INTO `zxcms_admin` VALUES ('12', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', '0', '0', '18351567069@163.com', '12345678900', '张家辉', '', '1', '0', '6');
INSERT INTO `zxcms_admin` VALUES ('13', '中粮', 'e10adc3949ba59abbe56e057f20f883e', '', '0', '0', '18351567069@163.com', '12345678900', '张家辉', '', '1', '0', '24');
INSERT INTO `zxcms_admin` VALUES ('14', '李旭', 'e10adc3949ba59abbe56e057f20f883e', '', '0', '0', '18351567069@163.com', '19351567089', '杨紫', '', '1', '0', '23');

-- ----------------------------
-- Table structure for `zxcms_admin_copy`
-- ----------------------------
DROP TABLE IF EXISTS `zxcms_admin_copy`;
CREATE TABLE `zxcms_admin_copy` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `encrypt` varchar(6) NOT NULL DEFAULT '',
  `lastloginip` int(10) NOT NULL DEFAULT '0',
  `lastlogintime` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(40) NOT NULL DEFAULT '',
  `mobile` varchar(11) NOT NULL DEFAULT '',
  `realname` varchar(50) NOT NULL DEFAULT '',
  `openid` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(2:无效,1:有效)',
  `updatetime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxcms_admin_copy
-- ----------------------------

-- ----------------------------
-- Table structure for `zxcms_admin_copy1`
-- ----------------------------
DROP TABLE IF EXISTS `zxcms_admin_copy1`;
CREATE TABLE `zxcms_admin_copy1` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `encrypt` varchar(6) NOT NULL DEFAULT '',
  `lastloginip` int(10) NOT NULL DEFAULT '0',
  `lastlogintime` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(40) NOT NULL DEFAULT '',
  `mobile` varchar(11) NOT NULL DEFAULT '',
  `realname` varchar(50) NOT NULL DEFAULT '',
  `openid` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(2:无效,1:有效)',
  `updatetime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxcms_admin_copy1
-- ----------------------------

-- ----------------------------
-- Table structure for `zxcms_admin_group`
-- ----------------------------
DROP TABLE IF EXISTS `zxcms_admin_group`;
CREATE TABLE `zxcms_admin_group` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `listorder` (`listorder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxcms_admin_group
-- ----------------------------

-- ----------------------------
-- Table structure for `zxcms_admin_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `zxcms_admin_group_access`;
CREATE TABLE `zxcms_admin_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxcms_admin_group_access
-- ----------------------------

-- ----------------------------
-- Table structure for `zxcms_admin_home`
-- ----------------------------
DROP TABLE IF EXISTS `zxcms_admin_home`;
CREATE TABLE `zxcms_admin_home` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) DEFAULT NULL COMMENT '用户名',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `password2` varchar(10) DEFAULT '' COMMENT '公司名称',
  `password3` varchar(20) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(12) DEFAULT NULL COMMENT '手机号',
  `time` varchar(20) DEFAULT '' COMMENT '时间',
  `toke` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxcms_admin_home
-- ----------------------------
INSERT INTO `zxcms_admin_home` VALUES ('23', '小孩', '21232f297a57a5a743894a0e4a801fc3', '飞机人', '刘李旭', '18351567059', '2020-10-10', '1533284252');
INSERT INTO `zxcms_admin_home` VALUES ('24', '小红', '21232f297a57a5a743894a0e4a801fc3', '非法', '刘李旭', '18351567059', '2020-10-10', '1533284507');
INSERT INTO `zxcms_admin_home` VALUES ('6', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', '18351567059', '2020-10-10', '0f2091a2daf72493a797bdc1d3f11b9d');

-- ----------------------------
-- Table structure for `zxcms_admin_id`
-- ----------------------------
DROP TABLE IF EXISTS `zxcms_admin_id`;
CREATE TABLE `zxcms_admin_id` (
  `id` int(3) NOT NULL,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(33) NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxcms_admin_id
-- ----------------------------
INSERT INTO `zxcms_admin_id` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- ----------------------------
-- Table structure for `zxcms_classs`
-- ----------------------------
DROP TABLE IF EXISTS `zxcms_classs`;
CREATE TABLE `zxcms_classs` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `ys` char(10) NOT NULL COMMENT '产品分类',
  `uid` int(4) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxcms_classs
-- ----------------------------
INSERT INTO `zxcms_classs` VALUES ('2', '肉类', '0000');
INSERT INTO `zxcms_classs` VALUES ('5', '水果', '0000');
INSERT INTO `zxcms_classs` VALUES ('7', '蔬菜', '0000');
INSERT INTO `zxcms_classs` VALUES ('9', '大米', '0006');
INSERT INTO `zxcms_classs` VALUES ('10', '酒水', '0006');
INSERT INTO `zxcms_classs` VALUES ('12', '衣服', '0023');
INSERT INTO `zxcms_classs` VALUES ('13', '帽子', '0023');

-- ----------------------------
-- Table structure for `zxcms_commodity`
-- ----------------------------
DROP TABLE IF EXISTS `zxcms_commodity`;
CREATE TABLE `zxcms_commodity` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '商品名称',
  `price` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '价格',
  `stock` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '库存',
  `ys` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '商品类',
  `file` char(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片',
  `admin_id` int(2) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxcms_commodity
-- ----------------------------
INSERT INTO `zxcms_commodity` VALUES ('3', '黄瓜', '2', '200', '蔬菜', '1217892.jpg', '00');
INSERT INTO `zxcms_commodity` VALUES ('6', '小青菜', '12', '200', '肉类', '', '00');
INSERT INTO `zxcms_commodity` VALUES ('8', '土豆', '12', '500', '蔬菜', '20180809/cb2f429b3c859364c2e2d1e6d8f8401c.jpg', '01');
INSERT INTO `zxcms_commodity` VALUES ('9', '青椒', '12', '2222', '蔬菜', '20180809/cb2f429b3c859364c2e2d1e6d8f8401c.jpg', '01');
INSERT INTO `zxcms_commodity` VALUES ('16', '长袖', '184', '3000', '衣服', '20180813/c8028fab78ecbf85a98cda076bbe4432.jpg', null);
INSERT INTO `zxcms_commodity` VALUES ('13', '小米', '9.8', '3000 ', '大米', '20180809/cb2f429b3c859364c2e2d1e6d8f8401c.jpg', '06');
INSERT INTO `zxcms_commodity` VALUES ('15', '中粮', '12', '1211', '酒水', '20180810/5d78589296b7b9d612682e4fcdf783be.jpg', '06');
INSERT INTO `zxcms_commodity` VALUES ('17', '裤子', '100', '1000', '衣服', '20180813/3fc459353ef8c722c8c816241a3371bf.jpg', null);
INSERT INTO `zxcms_commodity` VALUES ('18', '内裤', '90', '100', '衣服', '20180813/03b92390080713c54aa0fb6c50c4fd00.jpg', '23');
INSERT INTO `zxcms_commodity` VALUES ('19', '袜子', '30', '20000', '衣服', '20180813/8f3c557468e0b629b441ab794509c55b.jpg', '23');
INSERT INTO `zxcms_commodity` VALUES ('20', '鸭舌帽', '30', '200', '帽子', '20180813/4090211db2632322ad5e4ff14f498272.jpg', '23');

-- ----------------------------
-- Table structure for `zxcms_goods`
-- ----------------------------
DROP TABLE IF EXISTS `zxcms_goods`;
CREATE TABLE `zxcms_goods` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `uid` int(3) unsigned zerofill DEFAULT NULL,
  `number` char(20) DEFAULT NULL COMMENT '重量',
  `time` varchar(20) DEFAULT NULL COMMENT '时间',
  `good_id` int(4) unsigned zerofill DEFAULT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxcms_goods
-- ----------------------------
INSERT INTO `zxcms_goods` VALUES ('1', '020', '2', '2018-08-13', '0014');
INSERT INTO `zxcms_goods` VALUES ('2', null, null, '2018-08-13', '0014');
INSERT INTO `zxcms_goods` VALUES ('3', null, null, '2018-08-13', '0014');
INSERT INTO `zxcms_goods` VALUES ('4', null, null, '2018-08-13', '0014');
INSERT INTO `zxcms_goods` VALUES ('5', '013', '2', '2018-08-13', '0012');
INSERT INTO `zxcms_goods` VALUES ('6', '015', '3', '2018-08-13', '0012');
INSERT INTO `zxcms_goods` VALUES ('7', '020', '2', '2018-08-13', '0014');
INSERT INTO `zxcms_goods` VALUES ('8', '018', '2', '2018-08-13', '0014');
INSERT INTO `zxcms_goods` VALUES ('9', '019', '3', '2018-08-13', '0014');
INSERT INTO `zxcms_goods` VALUES ('10', '019', '3', '2018-08-13', '0014');
INSERT INTO `zxcms_goods` VALUES ('11', null, null, '2018-08-13', '0014');
INSERT INTO `zxcms_goods` VALUES ('12', '020', '4', '2018-08-13', '0014');
