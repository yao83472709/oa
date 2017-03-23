/*
Navicat MySQL Data Transfer

Source Server         : abon
Source Server Version : 50540
Source Host           : 192.168.199.225:3306
Source Database       : abon_oa

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-08-23 17:33:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `abon_account`
-- ----------------------------
DROP TABLE IF EXISTS `abon_account`;
CREATE TABLE `abon_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '账务总账表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `month` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '月份',
  `object_account` decimal(9,2) unsigned NOT NULL COMMENT '项目账',
  `run_account` decimal(9,2) unsigned NOT NULL COMMENT '流水账(其他)',
  `total_in` decimal(9,2) unsigned NOT NULL COMMENT '总收入',
  `daily_account` decimal(9,2) unsigned NOT NULL COMMENT '日常开销',
  `office_account` decimal(9,2) unsigned NOT NULL COMMENT '办公开销',
  `salary_account` decimal(9,2) unsigned NOT NULL COMMENT '人员薪资开销',
  `cost_account` decimal(9,2) unsigned NOT NULL COMMENT '成本开销',
  `taxation_account` decimal(9,2) unsigned NOT NULL COMMENT '税务开销',
  `other_account` decimal(9,2) unsigned NOT NULL COMMENT '其他开销',
  `total_out` decimal(9,2) unsigned NOT NULL COMMENT '总支出',
  `turnover` decimal(9,2) NOT NULL COMMENT '营业额(有符号)',
  `inventory` decimal(18,2) NOT NULL COMMENT '结存(此处用事物,先查出上一条记录的inventory, 经过收支计算后,写入新数据)(有符号)',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `month` (`month`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_account
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_account_bonus`
-- ----------------------------
DROP TABLE IF EXISTS `abon_account_bonus`;
CREATE TABLE `abon_account_bonus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '提成工资记录表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id(关联user表的id)',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '提成类型(1:项目提成;2:积分兑换)',
  `object_id` int(10) unsigned NOT NULL COMMENT '项目的Id  (关联object表)',
  `account_object_id` int(10) unsigned NOT NULL COMMENT '项目总账表的id  (关联account_object表的id)',
  `price` decimal(9,2) unsigned NOT NULL COMMENT '收款金额',
  `bonus` float unsigned NOT NULL COMMENT '提成比例',
  `salary` decimal(9,2) unsigned NOT NULL COMMENT '提成薪资  (  salary=price*bonus)',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `object_id` (`object_id`),
  KEY `account_object_id` (`account_object_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_account_bonus
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_account_object`
-- ----------------------------
DROP TABLE IF EXISTS `abon_account_object`;
CREATE TABLE `abon_account_object` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目总账表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `object_id` int(10) unsigned NOT NULL COMMENT '项目id(对应object表的id)',
  `object_name` varchar(45) NOT NULL COMMENT '项目名称',
  `user_id` int(10) unsigned NOT NULL COMMENT '业务员的id',
  `payment_ratio` varchar(45) NOT NULL COMMENT '付款比例（此处的值读取的是payment_ratio表中的值， 但不关联）',
  `total_price` decimal(9,2) unsigned NOT NULL COMMENT '总价格',
  `price` decimal(9,2) NOT NULL COMMENT '期账金额',
  `price_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '到账时间',
  `price_user_id` int(10) unsigned NOT NULL COMMENT '确认人员',
  `total_stage` tinyint(1) unsigned NOT NULL COMMENT '总账期数',
  `stage` tinyint(1) unsigned NOT NULL COMMENT '第几期账',
  `finish` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '收款是否已经完成( 0: 未完 ;1: 已完)total_stage=等于stage时，代表已完成】',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `user_id` (`user_id`),
  KEY `object_name` (`object_name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_account_object
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_account_run`
-- ----------------------------
DROP TABLE IF EXISTS `abon_account_run`;
CREATE TABLE `abon_account_run` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水账表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '日期',
  `type` tinyint(1) unsigned NOT NULL COMMENT '收支类型(1:收入;2:支出)',
  `account_type` int(10) unsigned NOT NULL COMMENT '收支种类(对应account_type表的id)',
  `money` decimal(9,2) unsigned NOT NULL COMMENT '金额',
  `description` varchar(255) NOT NULL COMMENT '摘要',
  `inventory` decimal(15,2) NOT NULL COMMENT '结存(此处用事物,先查出上一条记录的inventory, 经过收支计算后,写入新数据)(无符号)',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_account_run
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_account_salary`
-- ----------------------------
DROP TABLE IF EXISTS `abon_account_salary`;
CREATE TABLE `abon_account_salary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '工资账表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '员工id(对应user表的id)',
  `month` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '工资月份  (只记录年-月)',
  `name` varchar(10) NOT NULL COMMENT '员工姓名',
  `department` varchar(20) NOT NULL COMMENT '员工所属部门 ',
  `basic_salary` decimal(9,2) unsigned NOT NULL COMMENT '底薪',
  `integral_salary` decimal(9,2) unsigned NOT NULL COMMENT '积分工资',
  `safe_deduct` decimal(9,2) unsigned NOT NULL COMMENT '社保扣除',
  `deduct` decimal(9,2) unsigned NOT NULL COMMENT '其他扣除',
  `total_salary` decimal(9,2) unsigned NOT NULL COMMENT '实发总薪资  (basic_salary  +   integral_salary  -  safe_deduct    -  deduct)',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `month` (`month`),
  KEY `user_id` (`user_id`),
  KEY `name` (`name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_account_salary
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_account_salary_reward`
-- ----------------------------
DROP TABLE IF EXISTS `abon_account_salary_reward`;
CREATE TABLE `abon_account_salary_reward` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '薪资奖励处罚表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '员工的id(关联user表的id)',
  `month` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '月份',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型(1: 奖励;2:处罚)',
  `money` decimal(9,2) unsigned NOT NULL COMMENT '金额',
  `content` varchar(255) NOT NULL COMMENT '奖励处罚说明',
  `examine_id` int(10) unsigned NOT NULL COMMENT '操作者id(关联user表的id)',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_account_salary_reward
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_account_type`
-- ----------------------------
DROP TABLE IF EXISTS `abon_account_type`;
CREATE TABLE `abon_account_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '收支种类表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `name` varchar(15) NOT NULL COMMENT '种类名称',
  `status` tinyint(1) unsigned NOT NULL COMMENT '收支类型(1:收入 ;2: 支出 )',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_account_type
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_archives`
-- ----------------------------
DROP TABLE IF EXISTS `abon_archives`;
CREATE TABLE `abon_archives` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '作者id（关联user表的id）',
  `title` varchar(20) NOT NULL COMMENT '标题',
  `short_title` varchar(10) NOT NULL COMMENT '短标题',
  `click_number` int(11) NOT NULL COMMENT '点击量',
  `read_number` int(10) unsigned NOT NULL COMMENT '阅读量',
  `collection_number` int(10) unsigned NOT NULL COMMENT '收藏量',
  `transfer_number` int(10) unsigned NOT NULL COMMENT '转载量',
  `litpic` varchar(255) NOT NULL COMMENT '封面图片',
  `description` varchar(255) NOT NULL COMMENT '简介',
  `body` text NOT NULL COMMENT '内容',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_archives
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_archives_ discuss`
-- ----------------------------
DROP TABLE IF EXISTS `abon_archives_ discuss`;
CREATE TABLE `abon_archives_ discuss` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章评论表',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `archives_id` int(10) unsigned NOT NULL COMMENT '文章表的id（关联archives	表的id）',
  `user_id` int(10) unsigned NOT NULL COMMENT '评论者id（关联user表的id）',
  `p_id` int(10) unsigned NOT NULL COMMENT '评论回复上级栏目的id (对文章的评论:0  ;  对评论的回复:评论的id  )[本表关联]',
  `content` varchar(255) NOT NULL COMMENT '评论的内容',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`),
  KEY `archives_id` (`archives_id`),
  KEY `p_id` (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_archives_ discuss
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_archives_collection`
-- ----------------------------
DROP TABLE IF EXISTS `abon_archives_collection`;
CREATE TABLE `abon_archives_collection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章收藏转载表',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '收藏转载者id（关联user表的id）',
  `archives_id` int(10) unsigned NOT NULL COMMENT '文章表的id（关联archives	表的id）',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型(1:收藏;2:转载)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `archives_id` (`archives_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_archives_collection
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_area`
-- ----------------------------
DROP TABLE IF EXISTS `abon_area`;
CREATE TABLE `abon_area` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '中国地区表',
  `reid` int(11) NOT NULL COMMENT '上级栏目的id',
  `name` varchar(200) NOT NULL COMMENT '地区名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3328 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_area
-- ----------------------------
INSERT INTO `abon_area` VALUES ('1', '0', '安徽省');
INSERT INTO `abon_area` VALUES ('2', '0', '北京市');
INSERT INTO `abon_area` VALUES ('3', '0', '福建省');
INSERT INTO `abon_area` VALUES ('4', '0', '甘肃省');
INSERT INTO `abon_area` VALUES ('5', '0', '广东省');
INSERT INTO `abon_area` VALUES ('6', '0', '广西壮族自治区');
INSERT INTO `abon_area` VALUES ('7', '0', '贵州省');
INSERT INTO `abon_area` VALUES ('8', '0', '海南省');
INSERT INTO `abon_area` VALUES ('9', '0', '河北省');
INSERT INTO `abon_area` VALUES ('10', '0', '河南省');
INSERT INTO `abon_area` VALUES ('11', '0', '黑龙江省');
INSERT INTO `abon_area` VALUES ('12', '0', '湖北省');
INSERT INTO `abon_area` VALUES ('13', '0', '湖南省');
INSERT INTO `abon_area` VALUES ('14', '0', '吉林省');
INSERT INTO `abon_area` VALUES ('15', '0', '江苏省');
INSERT INTO `abon_area` VALUES ('16', '0', '江西省');
INSERT INTO `abon_area` VALUES ('17', '0', '辽宁省');
INSERT INTO `abon_area` VALUES ('18', '0', '内蒙古自治区');
INSERT INTO `abon_area` VALUES ('19', '0', '宁夏回族自治区');
INSERT INTO `abon_area` VALUES ('20', '0', '青海省');
INSERT INTO `abon_area` VALUES ('21', '0', '山东省');
INSERT INTO `abon_area` VALUES ('22', '0', '山西省');
INSERT INTO `abon_area` VALUES ('23', '0', '陕西省');
INSERT INTO `abon_area` VALUES ('24', '0', '上海市');
INSERT INTO `abon_area` VALUES ('25', '0', '四川省');
INSERT INTO `abon_area` VALUES ('26', '0', '天津市');
INSERT INTO `abon_area` VALUES ('27', '0', '西藏自治区');
INSERT INTO `abon_area` VALUES ('28', '0', '新疆维吾尔自治区');
INSERT INTO `abon_area` VALUES ('29', '0', '云南省');
INSERT INTO `abon_area` VALUES ('30', '0', '浙江省');
INSERT INTO `abon_area` VALUES ('31', '0', '重庆市');
INSERT INTO `abon_area` VALUES ('32', '0', '台湾省');
INSERT INTO `abon_area` VALUES ('33', '0', '香港特别行政区');
INSERT INTO `abon_area` VALUES ('34', '0', '澳门特别行政区');
INSERT INTO `abon_area` VALUES ('35', '1', '安庆市');
INSERT INTO `abon_area` VALUES ('36', '1', '蚌埠市');
INSERT INTO `abon_area` VALUES ('37', '1', '亳州市');
INSERT INTO `abon_area` VALUES ('38', '1', '池州市');
INSERT INTO `abon_area` VALUES ('39', '1', '滁州市');
INSERT INTO `abon_area` VALUES ('40', '1', '阜阳市');
INSERT INTO `abon_area` VALUES ('41', '1', '合肥市');
INSERT INTO `abon_area` VALUES ('42', '1', '淮北市');
INSERT INTO `abon_area` VALUES ('43', '1', '淮南市');
INSERT INTO `abon_area` VALUES ('44', '1', '黄山市');
INSERT INTO `abon_area` VALUES ('45', '1', '六安市');
INSERT INTO `abon_area` VALUES ('46', '1', '马鞍山市');
INSERT INTO `abon_area` VALUES ('47', '1', '铜陵市');
INSERT INTO `abon_area` VALUES ('48', '1', '芜湖市');
INSERT INTO `abon_area` VALUES ('49', '1', '宿州市');
INSERT INTO `abon_area` VALUES ('50', '1', '宣城市');
INSERT INTO `abon_area` VALUES ('51', '2', '北京市');
INSERT INTO `abon_area` VALUES ('52', '3', '福州市');
INSERT INTO `abon_area` VALUES ('53', '3', '厦门市');
INSERT INTO `abon_area` VALUES ('54', '3', '莆田市');
INSERT INTO `abon_area` VALUES ('55', '3', '三明市');
INSERT INTO `abon_area` VALUES ('56', '3', '泉州市');
INSERT INTO `abon_area` VALUES ('57', '3', '漳州市');
INSERT INTO `abon_area` VALUES ('58', '3', '南平市');
INSERT INTO `abon_area` VALUES ('59', '3', '龙岩市');
INSERT INTO `abon_area` VALUES ('60', '3', '宁德市');
INSERT INTO `abon_area` VALUES ('61', '4', '兰州市');
INSERT INTO `abon_area` VALUES ('62', '4', '嘉峪关市　');
INSERT INTO `abon_area` VALUES ('63', '4', '金昌市');
INSERT INTO `abon_area` VALUES ('64', '4', '白银市');
INSERT INTO `abon_area` VALUES ('65', '4', '天水市');
INSERT INTO `abon_area` VALUES ('66', '4', '武威市');
INSERT INTO `abon_area` VALUES ('67', '4', '张掖市');
INSERT INTO `abon_area` VALUES ('68', '4', '平凉市');
INSERT INTO `abon_area` VALUES ('69', '4', '酒泉市');
INSERT INTO `abon_area` VALUES ('70', '4', '庆阳市');
INSERT INTO `abon_area` VALUES ('71', '4', '定西市');
INSERT INTO `abon_area` VALUES ('72', '4', '陇南市');
INSERT INTO `abon_area` VALUES ('73', '4', '临夏州');
INSERT INTO `abon_area` VALUES ('74', '4', '甘南州');
INSERT INTO `abon_area` VALUES ('75', '5', '广州市');
INSERT INTO `abon_area` VALUES ('76', '5', '深圳市');
INSERT INTO `abon_area` VALUES ('77', '5', '珠海市');
INSERT INTO `abon_area` VALUES ('78', '5', '汕头市');
INSERT INTO `abon_area` VALUES ('79', '5', '韶关市');
INSERT INTO `abon_area` VALUES ('80', '5', '佛山市');
INSERT INTO `abon_area` VALUES ('81', '5', '江门市');
INSERT INTO `abon_area` VALUES ('82', '5', '湛江市');
INSERT INTO `abon_area` VALUES ('83', '5', '茂名市');
INSERT INTO `abon_area` VALUES ('84', '5', '肇庆市');
INSERT INTO `abon_area` VALUES ('85', '5', '惠州市');
INSERT INTO `abon_area` VALUES ('86', '5', '梅州市');
INSERT INTO `abon_area` VALUES ('87', '5', '汕尾市');
INSERT INTO `abon_area` VALUES ('88', '5', '河源市');
INSERT INTO `abon_area` VALUES ('89', '5', '阳江市');
INSERT INTO `abon_area` VALUES ('90', '5', '清远市');
INSERT INTO `abon_area` VALUES ('91', '5', '东莞市　');
INSERT INTO `abon_area` VALUES ('92', '5', '中山市　');
INSERT INTO `abon_area` VALUES ('93', '5', '潮州市');
INSERT INTO `abon_area` VALUES ('94', '5', '揭阳市');
INSERT INTO `abon_area` VALUES ('95', '5', '云浮市');
INSERT INTO `abon_area` VALUES ('96', '6', '南宁市');
INSERT INTO `abon_area` VALUES ('97', '6', '柳州市');
INSERT INTO `abon_area` VALUES ('98', '6', '桂林市');
INSERT INTO `abon_area` VALUES ('99', '6', '梧州市');
INSERT INTO `abon_area` VALUES ('100', '6', '北海市');
INSERT INTO `abon_area` VALUES ('101', '6', '防城港市');
INSERT INTO `abon_area` VALUES ('102', '6', '钦州市');
INSERT INTO `abon_area` VALUES ('103', '6', '贵港市');
INSERT INTO `abon_area` VALUES ('104', '6', '玉林市');
INSERT INTO `abon_area` VALUES ('105', '6', '百色市');
INSERT INTO `abon_area` VALUES ('106', '6', '贺州市');
INSERT INTO `abon_area` VALUES ('107', '6', '河池市');
INSERT INTO `abon_area` VALUES ('108', '6', '来宾市');
INSERT INTO `abon_area` VALUES ('109', '6', '崇左市');
INSERT INTO `abon_area` VALUES ('110', '7', '贵阳市');
INSERT INTO `abon_area` VALUES ('111', '7', '六盘水市');
INSERT INTO `abon_area` VALUES ('112', '7', '遵义市');
INSERT INTO `abon_area` VALUES ('113', '7', '安顺市');
INSERT INTO `abon_area` VALUES ('114', '7', '铜仁地区');
INSERT INTO `abon_area` VALUES ('115', '7', '毕节地区');
INSERT INTO `abon_area` VALUES ('116', '7', '黔西南布依族苗族自治州');
INSERT INTO `abon_area` VALUES ('117', '7', '黔东南苗族侗族自治州');
INSERT INTO `abon_area` VALUES ('118', '7', '黔南布依族苗族自治州');
INSERT INTO `abon_area` VALUES ('119', '8', '海口市');
INSERT INTO `abon_area` VALUES ('120', '8', '三亚市');
INSERT INTO `abon_area` VALUES ('121', '8', '省直辖行政单位');
INSERT INTO `abon_area` VALUES ('122', '9', '石家庄市');
INSERT INTO `abon_area` VALUES ('123', '9', '唐山市');
INSERT INTO `abon_area` VALUES ('124', '9', '秦皇岛市');
INSERT INTO `abon_area` VALUES ('125', '9', '邯郸市');
INSERT INTO `abon_area` VALUES ('126', '9', '邢台市');
INSERT INTO `abon_area` VALUES ('127', '9', '保定市');
INSERT INTO `abon_area` VALUES ('128', '9', '张家口市');
INSERT INTO `abon_area` VALUES ('129', '9', '承德市');
INSERT INTO `abon_area` VALUES ('130', '9', '沧州市');
INSERT INTO `abon_area` VALUES ('131', '9', '廊坊市');
INSERT INTO `abon_area` VALUES ('132', '9', '衡水市');
INSERT INTO `abon_area` VALUES ('133', '10', '郑州市');
INSERT INTO `abon_area` VALUES ('134', '10', '开封市');
INSERT INTO `abon_area` VALUES ('135', '10', '洛阳市');
INSERT INTO `abon_area` VALUES ('136', '10', '平顶山市');
INSERT INTO `abon_area` VALUES ('137', '10', '焦作市');
INSERT INTO `abon_area` VALUES ('138', '10', '鹤壁市');
INSERT INTO `abon_area` VALUES ('139', '10', '新乡市');
INSERT INTO `abon_area` VALUES ('140', '10', '安阳市');
INSERT INTO `abon_area` VALUES ('141', '10', '濮阳市');
INSERT INTO `abon_area` VALUES ('142', '10', '许昌市');
INSERT INTO `abon_area` VALUES ('143', '10', '漯河市');
INSERT INTO `abon_area` VALUES ('144', '10', '三门峡市');
INSERT INTO `abon_area` VALUES ('145', '10', '南阳市');
INSERT INTO `abon_area` VALUES ('146', '10', '商丘市');
INSERT INTO `abon_area` VALUES ('147', '10', '信阳市');
INSERT INTO `abon_area` VALUES ('148', '10', '周口市');
INSERT INTO `abon_area` VALUES ('149', '10', '驻马店市');
INSERT INTO `abon_area` VALUES ('150', '10', '省直辖');
INSERT INTO `abon_area` VALUES ('151', '11', '哈尔滨市');
INSERT INTO `abon_area` VALUES ('152', '11', '齐齐哈尔市');
INSERT INTO `abon_area` VALUES ('153', '11', '鸡西市');
INSERT INTO `abon_area` VALUES ('154', '11', '鹤岗市');
INSERT INTO `abon_area` VALUES ('155', '11', '双鸭山市');
INSERT INTO `abon_area` VALUES ('156', '11', '大庆市');
INSERT INTO `abon_area` VALUES ('157', '11', '伊春市');
INSERT INTO `abon_area` VALUES ('158', '11', '佳木斯市');
INSERT INTO `abon_area` VALUES ('159', '11', '七台河市');
INSERT INTO `abon_area` VALUES ('160', '11', '牡丹江市');
INSERT INTO `abon_area` VALUES ('161', '11', '黑河市');
INSERT INTO `abon_area` VALUES ('162', '11', '绥化市');
INSERT INTO `abon_area` VALUES ('163', '11', '大兴安岭地区');
INSERT INTO `abon_area` VALUES ('164', '12', '武汉市');
INSERT INTO `abon_area` VALUES ('165', '12', '黄石市');
INSERT INTO `abon_area` VALUES ('166', '12', '襄阳市');
INSERT INTO `abon_area` VALUES ('167', '12', '十堰市');
INSERT INTO `abon_area` VALUES ('168', '12', '荆州市');
INSERT INTO `abon_area` VALUES ('169', '12', '宜昌市');
INSERT INTO `abon_area` VALUES ('170', '12', '荆门市');
INSERT INTO `abon_area` VALUES ('171', '12', '鄂州市');
INSERT INTO `abon_area` VALUES ('172', '12', '孝感市');
INSERT INTO `abon_area` VALUES ('173', '12', '黄冈市');
INSERT INTO `abon_area` VALUES ('174', '12', '咸宁市');
INSERT INTO `abon_area` VALUES ('175', '12', '随州市');
INSERT INTO `abon_area` VALUES ('176', '12', '恩施州');
INSERT INTO `abon_area` VALUES ('177', '12', '省直辖');
INSERT INTO `abon_area` VALUES ('178', '13', '长沙市');
INSERT INTO `abon_area` VALUES ('179', '13', '株洲市');
INSERT INTO `abon_area` VALUES ('180', '13', '湘潭市');
INSERT INTO `abon_area` VALUES ('181', '13', '衡阳市');
INSERT INTO `abon_area` VALUES ('182', '13', '邵阳市');
INSERT INTO `abon_area` VALUES ('183', '13', '岳阳市');
INSERT INTO `abon_area` VALUES ('184', '13', '常德市');
INSERT INTO `abon_area` VALUES ('185', '13', '张家界市');
INSERT INTO `abon_area` VALUES ('186', '13', '益阳市');
INSERT INTO `abon_area` VALUES ('187', '13', '郴州市');
INSERT INTO `abon_area` VALUES ('188', '13', '永州市');
INSERT INTO `abon_area` VALUES ('189', '13', '怀化市');
INSERT INTO `abon_area` VALUES ('190', '13', '娄底市');
INSERT INTO `abon_area` VALUES ('191', '13', '湘西州');
INSERT INTO `abon_area` VALUES ('192', '14', '长春市');
INSERT INTO `abon_area` VALUES ('193', '14', '吉林市');
INSERT INTO `abon_area` VALUES ('194', '14', '四平市');
INSERT INTO `abon_area` VALUES ('195', '14', '辽源市');
INSERT INTO `abon_area` VALUES ('196', '14', '通化市');
INSERT INTO `abon_area` VALUES ('197', '14', '白山市');
INSERT INTO `abon_area` VALUES ('198', '14', '松原市');
INSERT INTO `abon_area` VALUES ('199', '14', '白城市');
INSERT INTO `abon_area` VALUES ('200', '14', '延边朝鲜族自治州');
INSERT INTO `abon_area` VALUES ('201', '15', '南京市');
INSERT INTO `abon_area` VALUES ('202', '15', '无锡市');
INSERT INTO `abon_area` VALUES ('203', '15', '徐州市');
INSERT INTO `abon_area` VALUES ('204', '15', '常州市');
INSERT INTO `abon_area` VALUES ('205', '15', '苏州市');
INSERT INTO `abon_area` VALUES ('206', '15', '南通市');
INSERT INTO `abon_area` VALUES ('207', '15', '连云港市');
INSERT INTO `abon_area` VALUES ('208', '15', '淮安市');
INSERT INTO `abon_area` VALUES ('209', '15', '盐城市');
INSERT INTO `abon_area` VALUES ('210', '15', '扬州市');
INSERT INTO `abon_area` VALUES ('211', '15', '镇江市');
INSERT INTO `abon_area` VALUES ('212', '15', '泰州市');
INSERT INTO `abon_area` VALUES ('213', '15', '宿迁市');
INSERT INTO `abon_area` VALUES ('214', '16', '南昌市');
INSERT INTO `abon_area` VALUES ('215', '16', '景德镇市');
INSERT INTO `abon_area` VALUES ('216', '16', '萍乡市');
INSERT INTO `abon_area` VALUES ('217', '16', '九江市');
INSERT INTO `abon_area` VALUES ('218', '16', '新余市');
INSERT INTO `abon_area` VALUES ('219', '16', '鹰潭市');
INSERT INTO `abon_area` VALUES ('220', '16', '赣州市');
INSERT INTO `abon_area` VALUES ('221', '16', '吉安市');
INSERT INTO `abon_area` VALUES ('222', '16', '宜春市');
INSERT INTO `abon_area` VALUES ('223', '16', '抚州市');
INSERT INTO `abon_area` VALUES ('224', '16', '上饶市');
INSERT INTO `abon_area` VALUES ('225', '17', '沈阳市');
INSERT INTO `abon_area` VALUES ('226', '17', '大连市');
INSERT INTO `abon_area` VALUES ('227', '17', '鞍山市');
INSERT INTO `abon_area` VALUES ('228', '17', '抚顺市');
INSERT INTO `abon_area` VALUES ('229', '17', '本溪市');
INSERT INTO `abon_area` VALUES ('230', '17', '丹东市');
INSERT INTO `abon_area` VALUES ('231', '17', '锦州市');
INSERT INTO `abon_area` VALUES ('232', '17', '营口市');
INSERT INTO `abon_area` VALUES ('233', '17', '阜新市');
INSERT INTO `abon_area` VALUES ('234', '17', '辽阳市');
INSERT INTO `abon_area` VALUES ('235', '17', '盘锦市');
INSERT INTO `abon_area` VALUES ('236', '17', '铁岭市');
INSERT INTO `abon_area` VALUES ('237', '17', '朝阳市');
INSERT INTO `abon_area` VALUES ('238', '17', '葫芦岛市');
INSERT INTO `abon_area` VALUES ('239', '18', '呼和浩特市');
INSERT INTO `abon_area` VALUES ('240', '18', '包　头　市');
INSERT INTO `abon_area` VALUES ('241', '18', '乌　海　市');
INSERT INTO `abon_area` VALUES ('242', '18', '赤　峰　市');
INSERT INTO `abon_area` VALUES ('243', '18', '通　辽　市');
INSERT INTO `abon_area` VALUES ('244', '18', '鄂尔多斯市');
INSERT INTO `abon_area` VALUES ('245', '18', '呼伦贝尔市');
INSERT INTO `abon_area` VALUES ('246', '18', '巴彦淖尔市');
INSERT INTO `abon_area` VALUES ('247', '18', '乌兰察布市');
INSERT INTO `abon_area` VALUES ('248', '18', '兴　安　盟');
INSERT INTO `abon_area` VALUES ('249', '18', '锡林郭勒盟');
INSERT INTO `abon_area` VALUES ('250', '18', '阿拉善盟');
INSERT INTO `abon_area` VALUES ('251', '19', '固原市');
INSERT INTO `abon_area` VALUES ('252', '19', '石嘴山市');
INSERT INTO `abon_area` VALUES ('253', '19', '吴忠市');
INSERT INTO `abon_area` VALUES ('254', '19', '银川市');
INSERT INTO `abon_area` VALUES ('255', '19', '中卫市');
INSERT INTO `abon_area` VALUES ('256', '20', '西 宁 市');
INSERT INTO `abon_area` VALUES ('257', '20', '海东地区');
INSERT INTO `abon_area` VALUES ('258', '20', '海 北 州');
INSERT INTO `abon_area` VALUES ('259', '20', '黄 南 州');
INSERT INTO `abon_area` VALUES ('260', '20', '海 南 州');
INSERT INTO `abon_area` VALUES ('261', '20', '果 洛 州');
INSERT INTO `abon_area` VALUES ('262', '20', '玉 树 州');
INSERT INTO `abon_area` VALUES ('263', '20', '海 西 州');
INSERT INTO `abon_area` VALUES ('264', '21', '济南市');
INSERT INTO `abon_area` VALUES ('265', '21', '青岛市');
INSERT INTO `abon_area` VALUES ('266', '21', '淄博市');
INSERT INTO `abon_area` VALUES ('267', '21', '枣庄市');
INSERT INTO `abon_area` VALUES ('268', '21', '东营市');
INSERT INTO `abon_area` VALUES ('269', '21', '烟台市');
INSERT INTO `abon_area` VALUES ('270', '21', '潍坊市');
INSERT INTO `abon_area` VALUES ('271', '21', '威海市');
INSERT INTO `abon_area` VALUES ('272', '21', '济宁市');
INSERT INTO `abon_area` VALUES ('273', '21', '泰安市');
INSERT INTO `abon_area` VALUES ('274', '21', '日照市');
INSERT INTO `abon_area` VALUES ('275', '21', '莱芜市');
INSERT INTO `abon_area` VALUES ('276', '21', '临沂市');
INSERT INTO `abon_area` VALUES ('277', '21', '德州市');
INSERT INTO `abon_area` VALUES ('278', '21', '聊城市');
INSERT INTO `abon_area` VALUES ('279', '21', '滨州市');
INSERT INTO `abon_area` VALUES ('280', '21', '菏泽市');
INSERT INTO `abon_area` VALUES ('281', '22', '大同市');
INSERT INTO `abon_area` VALUES ('282', '22', '晋城市');
INSERT INTO `abon_area` VALUES ('283', '22', '晋中市');
INSERT INTO `abon_area` VALUES ('284', '22', '临汾市');
INSERT INTO `abon_area` VALUES ('285', '22', '吕梁市');
INSERT INTO `abon_area` VALUES ('286', '22', '朔州市');
INSERT INTO `abon_area` VALUES ('287', '22', '太原市');
INSERT INTO `abon_area` VALUES ('288', '22', '忻州市');
INSERT INTO `abon_area` VALUES ('289', '22', '阳泉市');
INSERT INTO `abon_area` VALUES ('290', '22', '运城市');
INSERT INTO `abon_area` VALUES ('291', '22', '长治市');
INSERT INTO `abon_area` VALUES ('292', '23', '西安市');
INSERT INTO `abon_area` VALUES ('293', '23', '铜川市');
INSERT INTO `abon_area` VALUES ('294', '23', '宝鸡市');
INSERT INTO `abon_area` VALUES ('295', '23', '咸阳市');
INSERT INTO `abon_area` VALUES ('296', '23', '渭南市');
INSERT INTO `abon_area` VALUES ('297', '23', '延安市');
INSERT INTO `abon_area` VALUES ('298', '23', '汉中市');
INSERT INTO `abon_area` VALUES ('299', '23', '榆林市');
INSERT INTO `abon_area` VALUES ('300', '23', '安康市');
INSERT INTO `abon_area` VALUES ('301', '23', '商洛市');
INSERT INTO `abon_area` VALUES ('302', '24', '上海市');
INSERT INTO `abon_area` VALUES ('303', '25', '成都市');
INSERT INTO `abon_area` VALUES ('304', '25', '自贡市');
INSERT INTO `abon_area` VALUES ('305', '25', '攀枝花市');
INSERT INTO `abon_area` VALUES ('306', '25', '泸州市');
INSERT INTO `abon_area` VALUES ('307', '25', '德阳市');
INSERT INTO `abon_area` VALUES ('308', '25', '绵阳市');
INSERT INTO `abon_area` VALUES ('309', '25', '广元市');
INSERT INTO `abon_area` VALUES ('310', '25', '遂宁市');
INSERT INTO `abon_area` VALUES ('311', '25', '内江市');
INSERT INTO `abon_area` VALUES ('312', '25', '乐山市');
INSERT INTO `abon_area` VALUES ('313', '25', '南充市');
INSERT INTO `abon_area` VALUES ('314', '25', '宜宾市');
INSERT INTO `abon_area` VALUES ('315', '25', '广安市');
INSERT INTO `abon_area` VALUES ('316', '25', '达州市');
INSERT INTO `abon_area` VALUES ('317', '25', '眉山市');
INSERT INTO `abon_area` VALUES ('318', '25', '雅安市');
INSERT INTO `abon_area` VALUES ('319', '25', '巴中市');
INSERT INTO `abon_area` VALUES ('320', '25', '资阳市');
INSERT INTO `abon_area` VALUES ('321', '25', '阿坝州');
INSERT INTO `abon_area` VALUES ('322', '25', '甘孜州');
INSERT INTO `abon_area` VALUES ('323', '25', '凉山州');
INSERT INTO `abon_area` VALUES ('324', '26', '天津市');
INSERT INTO `abon_area` VALUES ('325', '27', '拉 萨 市');
INSERT INTO `abon_area` VALUES ('326', '27', '昌都地区');
INSERT INTO `abon_area` VALUES ('327', '27', '山南地区');
INSERT INTO `abon_area` VALUES ('328', '27', '日喀则地区');
INSERT INTO `abon_area` VALUES ('329', '27', '那曲地区');
INSERT INTO `abon_area` VALUES ('330', '27', '阿里地区');
INSERT INTO `abon_area` VALUES ('331', '27', '林芝地区');
INSERT INTO `abon_area` VALUES ('332', '28', '乌鲁木齐市');
INSERT INTO `abon_area` VALUES ('333', '28', '克拉玛依市');
INSERT INTO `abon_area` VALUES ('334', '28', '吐鲁番地区');
INSERT INTO `abon_area` VALUES ('335', '28', '哈密地区');
INSERT INTO `abon_area` VALUES ('336', '28', '和田地区');
INSERT INTO `abon_area` VALUES ('337', '28', '阿克苏地区');
INSERT INTO `abon_area` VALUES ('338', '28', '喀什地区');
INSERT INTO `abon_area` VALUES ('339', '28', '克孜勒苏柯尔克孜自治州');
INSERT INTO `abon_area` VALUES ('340', '28', '巴音郭楞蒙古自治州');
INSERT INTO `abon_area` VALUES ('341', '28', '昌吉回族自治州');
INSERT INTO `abon_area` VALUES ('342', '28', '博尔塔拉蒙古自治州');
INSERT INTO `abon_area` VALUES ('343', '28', '伊犁哈萨克自治州');
INSERT INTO `abon_area` VALUES ('344', '28', '塔城地区');
INSERT INTO `abon_area` VALUES ('345', '28', '阿勒泰地区');
INSERT INTO `abon_area` VALUES ('346', '28', '直辖行政单位');
INSERT INTO `abon_area` VALUES ('347', '29', '昆　明　市');
INSERT INTO `abon_area` VALUES ('348', '29', '曲　靖　市');
INSERT INTO `abon_area` VALUES ('349', '29', '玉　溪　市');
INSERT INTO `abon_area` VALUES ('350', '29', '保　山　市');
INSERT INTO `abon_area` VALUES ('351', '29', '昭　通　市');
INSERT INTO `abon_area` VALUES ('352', '29', '丽　江　市');
INSERT INTO `abon_area` VALUES ('353', '29', '普　洱　市');
INSERT INTO `abon_area` VALUES ('354', '29', '临　沧　市');
INSERT INTO `abon_area` VALUES ('355', '29', '文　山　州');
INSERT INTO `abon_area` VALUES ('356', '29', '红　河　州');
INSERT INTO `abon_area` VALUES ('357', '29', '西双版纳州');
INSERT INTO `abon_area` VALUES ('358', '29', '楚　雄　州');
INSERT INTO `abon_area` VALUES ('359', '29', '大　理　州');
INSERT INTO `abon_area` VALUES ('360', '29', '德　宏　州');
INSERT INTO `abon_area` VALUES ('361', '29', '怒　江　州');
INSERT INTO `abon_area` VALUES ('362', '29', '迪　庆　州');
INSERT INTO `abon_area` VALUES ('363', '30', '杭州市');
INSERT INTO `abon_area` VALUES ('364', '30', '宁波市');
INSERT INTO `abon_area` VALUES ('365', '30', '温州市');
INSERT INTO `abon_area` VALUES ('366', '30', '嘉兴市');
INSERT INTO `abon_area` VALUES ('367', '30', '湖州市');
INSERT INTO `abon_area` VALUES ('368', '30', '绍兴市');
INSERT INTO `abon_area` VALUES ('369', '30', '金华市');
INSERT INTO `abon_area` VALUES ('370', '30', '衢州市');
INSERT INTO `abon_area` VALUES ('371', '30', '舟山市');
INSERT INTO `abon_area` VALUES ('372', '30', '台州市');
INSERT INTO `abon_area` VALUES ('373', '30', '丽水市');
INSERT INTO `abon_area` VALUES ('374', '31', '重庆市');
INSERT INTO `abon_area` VALUES ('375', '32', '台 北 市');
INSERT INTO `abon_area` VALUES ('376', '32', '高 雄 市');
INSERT INTO `abon_area` VALUES ('377', '32', '基 隆 市');
INSERT INTO `abon_area` VALUES ('378', '32', '台 中 市');
INSERT INTO `abon_area` VALUES ('379', '32', '台 南 市');
INSERT INTO `abon_area` VALUES ('380', '32', '新 竹 市');
INSERT INTO `abon_area` VALUES ('381', '32', '嘉 义 市');
INSERT INTO `abon_area` VALUES ('382', '33', '香港岛');
INSERT INTO `abon_area` VALUES ('383', '33', '九龙');
INSERT INTO `abon_area` VALUES ('384', '33', '新界');
INSERT INTO `abon_area` VALUES ('385', '34', '澳门特别行政区');
INSERT INTO `abon_area` VALUES ('386', '35', '大观');
INSERT INTO `abon_area` VALUES ('387', '35', '怀宁');
INSERT INTO `abon_area` VALUES ('388', '35', '潜山');
INSERT INTO `abon_area` VALUES ('389', '35', '太湖');
INSERT INTO `abon_area` VALUES ('390', '35', '桐城');
INSERT INTO `abon_area` VALUES ('391', '35', '望江');
INSERT INTO `abon_area` VALUES ('392', '35', '宿松');
INSERT INTO `abon_area` VALUES ('393', '35', '宜秀');
INSERT INTO `abon_area` VALUES ('394', '35', '迎江');
INSERT INTO `abon_area` VALUES ('395', '35', '岳西');
INSERT INTO `abon_area` VALUES ('396', '35', '枞阳');
INSERT INTO `abon_area` VALUES ('397', '36', '蚌山');
INSERT INTO `abon_area` VALUES ('398', '36', '固镇');
INSERT INTO `abon_area` VALUES ('399', '36', '怀远');
INSERT INTO `abon_area` VALUES ('400', '36', '淮上');
INSERT INTO `abon_area` VALUES ('401', '36', '龙子湖');
INSERT INTO `abon_area` VALUES ('402', '36', '五河');
INSERT INTO `abon_area` VALUES ('403', '36', '禹会');
INSERT INTO `abon_area` VALUES ('404', '37', '利辛');
INSERT INTO `abon_area` VALUES ('405', '37', '蒙城');
INSERT INTO `abon_area` VALUES ('406', '37', '谯城');
INSERT INTO `abon_area` VALUES ('407', '37', '涡阳');
INSERT INTO `abon_area` VALUES ('408', '38', '东至');
INSERT INTO `abon_area` VALUES ('409', '38', '贵池');
INSERT INTO `abon_area` VALUES ('410', '38', '青阳');
INSERT INTO `abon_area` VALUES ('411', '38', '石台');
INSERT INTO `abon_area` VALUES ('412', '39', '定远');
INSERT INTO `abon_area` VALUES ('413', '39', '凤阳');
INSERT INTO `abon_area` VALUES ('414', '39', '来安');
INSERT INTO `abon_area` VALUES ('415', '39', '琅琊');
INSERT INTO `abon_area` VALUES ('416', '39', '明光');
INSERT INTO `abon_area` VALUES ('417', '39', '南谯');
INSERT INTO `abon_area` VALUES ('418', '39', '全椒');
INSERT INTO `abon_area` VALUES ('419', '39', '天长');
INSERT INTO `abon_area` VALUES ('420', '40', '阜南');
INSERT INTO `abon_area` VALUES ('421', '40', '界首');
INSERT INTO `abon_area` VALUES ('422', '40', '临泉');
INSERT INTO `abon_area` VALUES ('423', '40', '太和');
INSERT INTO `abon_area` VALUES ('424', '40', '颍东');
INSERT INTO `abon_area` VALUES ('425', '40', '颍泉');
INSERT INTO `abon_area` VALUES ('426', '40', '颍上');
INSERT INTO `abon_area` VALUES ('427', '40', '颍州');
INSERT INTO `abon_area` VALUES ('428', '41', '包河');
INSERT INTO `abon_area` VALUES ('429', '41', '巢湖');
INSERT INTO `abon_area` VALUES ('430', '41', '肥东');
INSERT INTO `abon_area` VALUES ('431', '41', '肥西');
INSERT INTO `abon_area` VALUES ('432', '41', '庐江');
INSERT INTO `abon_area` VALUES ('433', '41', '庐阳');
INSERT INTO `abon_area` VALUES ('434', '41', '蜀山');
INSERT INTO `abon_area` VALUES ('435', '41', '瑶海');
INSERT INTO `abon_area` VALUES ('436', '41', '长丰');
INSERT INTO `abon_area` VALUES ('437', '42', '杜集');
INSERT INTO `abon_area` VALUES ('438', '42', '烈山');
INSERT INTO `abon_area` VALUES ('439', '42', '濉溪');
INSERT INTO `abon_area` VALUES ('440', '42', '相山');
INSERT INTO `abon_area` VALUES ('441', '43', '八公山');
INSERT INTO `abon_area` VALUES ('442', '43', '大通');
INSERT INTO `abon_area` VALUES ('443', '43', '凤台');
INSERT INTO `abon_area` VALUES ('444', '43', '潘集');
INSERT INTO `abon_area` VALUES ('445', '43', '田家庵');
INSERT INTO `abon_area` VALUES ('446', '43', '谢家集');
INSERT INTO `abon_area` VALUES ('447', '44', '黄山');
INSERT INTO `abon_area` VALUES ('448', '44', '徽州');
INSERT INTO `abon_area` VALUES ('449', '44', '祁门');
INSERT INTO `abon_area` VALUES ('450', '44', '屯溪');
INSERT INTO `abon_area` VALUES ('451', '44', '歙县');
INSERT INTO `abon_area` VALUES ('452', '44', '休宁');
INSERT INTO `abon_area` VALUES ('453', '44', '黟县');
INSERT INTO `abon_area` VALUES ('454', '45', '霍邱');
INSERT INTO `abon_area` VALUES ('455', '45', '霍山');
INSERT INTO `abon_area` VALUES ('456', '45', '金安');
INSERT INTO `abon_area` VALUES ('457', '45', '金寨');
INSERT INTO `abon_area` VALUES ('458', '45', '寿县');
INSERT INTO `abon_area` VALUES ('459', '45', '舒城');
INSERT INTO `abon_area` VALUES ('460', '45', '裕安');
INSERT INTO `abon_area` VALUES ('461', '46', '博望');
INSERT INTO `abon_area` VALUES ('462', '46', '当涂');
INSERT INTO `abon_area` VALUES ('463', '46', '含山');
INSERT INTO `abon_area` VALUES ('464', '46', '和县');
INSERT INTO `abon_area` VALUES ('465', '46', '花山');
INSERT INTO `abon_area` VALUES ('466', '46', '雨山');
INSERT INTO `abon_area` VALUES ('467', '47', '郊区');
INSERT INTO `abon_area` VALUES ('468', '47', '狮子山');
INSERT INTO `abon_area` VALUES ('469', '47', '铜官山');
INSERT INTO `abon_area` VALUES ('470', '47', '铜陵');
INSERT INTO `abon_area` VALUES ('471', '48', '繁昌');
INSERT INTO `abon_area` VALUES ('472', '48', '镜湖');
INSERT INTO `abon_area` VALUES ('473', '48', '鸠江');
INSERT INTO `abon_area` VALUES ('474', '48', '南陵');
INSERT INTO `abon_area` VALUES ('475', '48', '三山');
INSERT INTO `abon_area` VALUES ('476', '48', '无为');
INSERT INTO `abon_area` VALUES ('477', '48', '芜湖');
INSERT INTO `abon_area` VALUES ('478', '48', '弋江');
INSERT INTO `abon_area` VALUES ('479', '49', '砀山');
INSERT INTO `abon_area` VALUES ('480', '49', '灵璧');
INSERT INTO `abon_area` VALUES ('481', '49', '泗县');
INSERT INTO `abon_area` VALUES ('482', '49', '萧县');
INSERT INTO `abon_area` VALUES ('483', '49', '埇桥');
INSERT INTO `abon_area` VALUES ('484', '50', '广德');
INSERT INTO `abon_area` VALUES ('485', '50', '绩溪');
INSERT INTO `abon_area` VALUES ('486', '50', '泾县');
INSERT INTO `abon_area` VALUES ('487', '50', '旌德');
INSERT INTO `abon_area` VALUES ('488', '50', '郎溪');
INSERT INTO `abon_area` VALUES ('489', '50', '宁国');
INSERT INTO `abon_area` VALUES ('490', '50', '宣州');
INSERT INTO `abon_area` VALUES ('491', '51', '昌平');
INSERT INTO `abon_area` VALUES ('492', '51', '朝阳');
INSERT INTO `abon_area` VALUES ('493', '51', '大兴');
INSERT INTO `abon_area` VALUES ('494', '51', '东城');
INSERT INTO `abon_area` VALUES ('495', '51', '房山');
INSERT INTO `abon_area` VALUES ('496', '51', '丰台');
INSERT INTO `abon_area` VALUES ('497', '51', '海淀');
INSERT INTO `abon_area` VALUES ('498', '51', '怀柔');
INSERT INTO `abon_area` VALUES ('499', '51', '门头沟');
INSERT INTO `abon_area` VALUES ('500', '51', '密云');
INSERT INTO `abon_area` VALUES ('501', '51', '平谷');
INSERT INTO `abon_area` VALUES ('502', '51', '石景山');
INSERT INTO `abon_area` VALUES ('503', '51', '顺义');
INSERT INTO `abon_area` VALUES ('504', '51', '通州');
INSERT INTO `abon_area` VALUES ('505', '51', '西城');
INSERT INTO `abon_area` VALUES ('506', '51', '延庆');
INSERT INTO `abon_area` VALUES ('507', '52', '仓山');
INSERT INTO `abon_area` VALUES ('508', '52', '福清');
INSERT INTO `abon_area` VALUES ('509', '52', '鼓楼');
INSERT INTO `abon_area` VALUES ('510', '52', '晋安');
INSERT INTO `abon_area` VALUES ('511', '52', '连江');
INSERT INTO `abon_area` VALUES ('512', '52', '罗源');
INSERT INTO `abon_area` VALUES ('513', '52', '马尾');
INSERT INTO `abon_area` VALUES ('514', '52', '闽侯');
INSERT INTO `abon_area` VALUES ('515', '52', '闽清');
INSERT INTO `abon_area` VALUES ('516', '52', '平潭');
INSERT INTO `abon_area` VALUES ('517', '52', '台江');
INSERT INTO `abon_area` VALUES ('518', '52', '永泰');
INSERT INTO `abon_area` VALUES ('519', '52', '长乐');
INSERT INTO `abon_area` VALUES ('520', '53', '海沧');
INSERT INTO `abon_area` VALUES ('521', '53', '湖里');
INSERT INTO `abon_area` VALUES ('522', '53', '集美');
INSERT INTO `abon_area` VALUES ('523', '53', '思明');
INSERT INTO `abon_area` VALUES ('524', '53', '同安');
INSERT INTO `abon_area` VALUES ('525', '53', '翔安');
INSERT INTO `abon_area` VALUES ('526', '54', '城厢');
INSERT INTO `abon_area` VALUES ('527', '54', '涵江');
INSERT INTO `abon_area` VALUES ('528', '54', '荔城');
INSERT INTO `abon_area` VALUES ('529', '54', '仙游');
INSERT INTO `abon_area` VALUES ('530', '54', '秀屿');
INSERT INTO `abon_area` VALUES ('531', '55', '大田');
INSERT INTO `abon_area` VALUES ('532', '55', '建宁');
INSERT INTO `abon_area` VALUES ('533', '55', '将乐');
INSERT INTO `abon_area` VALUES ('534', '55', '梅列');
INSERT INTO `abon_area` VALUES ('535', '55', '明溪');
INSERT INTO `abon_area` VALUES ('536', '55', '宁化');
INSERT INTO `abon_area` VALUES ('537', '55', '清流');
INSERT INTO `abon_area` VALUES ('538', '55', '三元');
INSERT INTO `abon_area` VALUES ('539', '55', '沙县');
INSERT INTO `abon_area` VALUES ('540', '55', '泰宁');
INSERT INTO `abon_area` VALUES ('541', '55', '永安');
INSERT INTO `abon_area` VALUES ('542', '55', '尤溪');
INSERT INTO `abon_area` VALUES ('543', '56', '安溪');
INSERT INTO `abon_area` VALUES ('544', '56', '德化');
INSERT INTO `abon_area` VALUES ('545', '56', '丰泽');
INSERT INTO `abon_area` VALUES ('546', '56', '惠安');
INSERT INTO `abon_area` VALUES ('547', '56', '金门');
INSERT INTO `abon_area` VALUES ('548', '56', '晋江');
INSERT INTO `abon_area` VALUES ('549', '56', '鲤城');
INSERT INTO `abon_area` VALUES ('550', '56', '洛江');
INSERT INTO `abon_area` VALUES ('551', '56', '南安');
INSERT INTO `abon_area` VALUES ('552', '56', '泉港');
INSERT INTO `abon_area` VALUES ('553', '56', '石狮');
INSERT INTO `abon_area` VALUES ('554', '56', '永春');
INSERT INTO `abon_area` VALUES ('555', '57', '东山');
INSERT INTO `abon_area` VALUES ('556', '57', '华安');
INSERT INTO `abon_area` VALUES ('557', '57', '龙海');
INSERT INTO `abon_area` VALUES ('558', '57', '龙文');
INSERT INTO `abon_area` VALUES ('559', '57', '南靖');
INSERT INTO `abon_area` VALUES ('560', '57', '平和');
INSERT INTO `abon_area` VALUES ('561', '57', '芗城');
INSERT INTO `abon_area` VALUES ('562', '57', '云霄');
INSERT INTO `abon_area` VALUES ('563', '57', '漳浦');
INSERT INTO `abon_area` VALUES ('564', '57', '长泰');
INSERT INTO `abon_area` VALUES ('565', '57', '诏安');
INSERT INTO `abon_area` VALUES ('566', '58', '光泽');
INSERT INTO `abon_area` VALUES ('567', '58', '建瓯');
INSERT INTO `abon_area` VALUES ('568', '58', '建阳');
INSERT INTO `abon_area` VALUES ('569', '58', '浦城');
INSERT INTO `abon_area` VALUES ('570', '58', '邵武');
INSERT INTO `abon_area` VALUES ('571', '58', '顺昌');
INSERT INTO `abon_area` VALUES ('572', '58', '松溪');
INSERT INTO `abon_area` VALUES ('573', '58', '武夷山');
INSERT INTO `abon_area` VALUES ('574', '58', '延平');
INSERT INTO `abon_area` VALUES ('575', '58', '政和');
INSERT INTO `abon_area` VALUES ('576', '59', '连城');
INSERT INTO `abon_area` VALUES ('577', '59', '上杭');
INSERT INTO `abon_area` VALUES ('578', '59', '武平');
INSERT INTO `abon_area` VALUES ('579', '59', '新罗');
INSERT INTO `abon_area` VALUES ('580', '59', '永定');
INSERT INTO `abon_area` VALUES ('581', '59', '漳平');
INSERT INTO `abon_area` VALUES ('582', '59', '长汀');
INSERT INTO `abon_area` VALUES ('583', '60', '福安');
INSERT INTO `abon_area` VALUES ('584', '60', '福鼎');
INSERT INTO `abon_area` VALUES ('585', '60', '古田');
INSERT INTO `abon_area` VALUES ('586', '60', '蕉城');
INSERT INTO `abon_area` VALUES ('587', '60', '屏南');
INSERT INTO `abon_area` VALUES ('588', '60', '寿宁');
INSERT INTO `abon_area` VALUES ('589', '60', '霞浦');
INSERT INTO `abon_area` VALUES ('590', '60', '柘荣');
INSERT INTO `abon_area` VALUES ('591', '60', '周宁');
INSERT INTO `abon_area` VALUES ('592', '61', '安宁');
INSERT INTO `abon_area` VALUES ('593', '61', '城关');
INSERT INTO `abon_area` VALUES ('594', '61', '皋兰');
INSERT INTO `abon_area` VALUES ('595', '61', '红古');
INSERT INTO `abon_area` VALUES ('596', '61', '七里河');
INSERT INTO `abon_area` VALUES ('597', '61', '西固');
INSERT INTO `abon_area` VALUES ('598', '61', '永登');
INSERT INTO `abon_area` VALUES ('599', '61', '榆中');
INSERT INTO `abon_area` VALUES ('600', '62', '雄关区');
INSERT INTO `abon_area` VALUES ('601', '62', '长城区');
INSERT INTO `abon_area` VALUES ('602', '62', '镜铁区');
INSERT INTO `abon_area` VALUES ('603', '63', '金川');
INSERT INTO `abon_area` VALUES ('604', '63', '永昌');
INSERT INTO `abon_area` VALUES ('605', '64', '白银');
INSERT INTO `abon_area` VALUES ('606', '64', '会宁');
INSERT INTO `abon_area` VALUES ('607', '64', '景泰');
INSERT INTO `abon_area` VALUES ('608', '64', '靖远');
INSERT INTO `abon_area` VALUES ('609', '64', '平川');
INSERT INTO `abon_area` VALUES ('610', '65', '甘谷');
INSERT INTO `abon_area` VALUES ('611', '65', '麦积');
INSERT INTO `abon_area` VALUES ('612', '65', '秦安');
INSERT INTO `abon_area` VALUES ('613', '65', '秦州');
INSERT INTO `abon_area` VALUES ('614', '65', '清水');
INSERT INTO `abon_area` VALUES ('615', '65', '武山');
INSERT INTO `abon_area` VALUES ('616', '65', '张家川');
INSERT INTO `abon_area` VALUES ('617', '66', '古浪');
INSERT INTO `abon_area` VALUES ('618', '66', '凉州');
INSERT INTO `abon_area` VALUES ('619', '66', '民勤');
INSERT INTO `abon_area` VALUES ('620', '66', '天祝');
INSERT INTO `abon_area` VALUES ('621', '67', '甘州');
INSERT INTO `abon_area` VALUES ('622', '67', '高台');
INSERT INTO `abon_area` VALUES ('623', '67', '临泽');
INSERT INTO `abon_area` VALUES ('624', '67', '民乐');
INSERT INTO `abon_area` VALUES ('625', '67', '山丹');
INSERT INTO `abon_area` VALUES ('626', '67', '肃南');
INSERT INTO `abon_area` VALUES ('627', '68', '崇信');
INSERT INTO `abon_area` VALUES ('628', '68', '华亭');
INSERT INTO `abon_area` VALUES ('629', '68', '泾川');
INSERT INTO `abon_area` VALUES ('630', '68', '静宁');
INSERT INTO `abon_area` VALUES ('631', '68', '崆峒');
INSERT INTO `abon_area` VALUES ('632', '68', '灵台');
INSERT INTO `abon_area` VALUES ('633', '68', '庄浪');
INSERT INTO `abon_area` VALUES ('634', '69', '阿克塞');
INSERT INTO `abon_area` VALUES ('635', '69', '敦煌');
INSERT INTO `abon_area` VALUES ('636', '69', '瓜州');
INSERT INTO `abon_area` VALUES ('637', '69', '金塔');
INSERT INTO `abon_area` VALUES ('638', '69', '肃北');
INSERT INTO `abon_area` VALUES ('639', '69', '肃州');
INSERT INTO `abon_area` VALUES ('640', '69', '玉门');
INSERT INTO `abon_area` VALUES ('641', '70', '合水');
INSERT INTO `abon_area` VALUES ('642', '70', '华池');
INSERT INTO `abon_area` VALUES ('643', '70', '环县');
INSERT INTO `abon_area` VALUES ('644', '70', '宁县');
INSERT INTO `abon_area` VALUES ('645', '70', '庆城');
INSERT INTO `abon_area` VALUES ('646', '70', '西峰');
INSERT INTO `abon_area` VALUES ('647', '70', '镇原');
INSERT INTO `abon_area` VALUES ('648', '70', '正宁');
INSERT INTO `abon_area` VALUES ('649', '71', '安定');
INSERT INTO `abon_area` VALUES ('650', '71', '临洮');
INSERT INTO `abon_area` VALUES ('651', '71', '陇西');
INSERT INTO `abon_area` VALUES ('652', '71', '岷县');
INSERT INTO `abon_area` VALUES ('653', '71', '通渭');
INSERT INTO `abon_area` VALUES ('654', '71', '渭源');
INSERT INTO `abon_area` VALUES ('655', '71', '漳县');
INSERT INTO `abon_area` VALUES ('656', '72', '成县');
INSERT INTO `abon_area` VALUES ('657', '72', '宕昌');
INSERT INTO `abon_area` VALUES ('658', '72', '徽县');
INSERT INTO `abon_area` VALUES ('659', '72', '康县');
INSERT INTO `abon_area` VALUES ('660', '72', '礼县');
INSERT INTO `abon_area` VALUES ('661', '72', '两当');
INSERT INTO `abon_area` VALUES ('662', '72', '文县');
INSERT INTO `abon_area` VALUES ('663', '72', '武都');
INSERT INTO `abon_area` VALUES ('664', '72', '西和');
INSERT INTO `abon_area` VALUES ('665', '73', '东乡族');
INSERT INTO `abon_area` VALUES ('666', '73', '广河');
INSERT INTO `abon_area` VALUES ('667', '73', '和政');
INSERT INTO `abon_area` VALUES ('668', '73', '积石山');
INSERT INTO `abon_area` VALUES ('669', '73', '康乐');
INSERT INTO `abon_area` VALUES ('670', '73', '临夏');
INSERT INTO `abon_area` VALUES ('671', '73', '临夏');
INSERT INTO `abon_area` VALUES ('672', '73', '永靖');
INSERT INTO `abon_area` VALUES ('673', '74', '迭部');
INSERT INTO `abon_area` VALUES ('674', '74', '合作');
INSERT INTO `abon_area` VALUES ('675', '74', '临潭');
INSERT INTO `abon_area` VALUES ('676', '74', '碌曲');
INSERT INTO `abon_area` VALUES ('677', '74', '玛曲');
INSERT INTO `abon_area` VALUES ('678', '74', '夏河');
INSERT INTO `abon_area` VALUES ('679', '74', '舟曲');
INSERT INTO `abon_area` VALUES ('680', '74', '卓尼');
INSERT INTO `abon_area` VALUES ('681', '75', '白云');
INSERT INTO `abon_area` VALUES ('682', '75', '从化');
INSERT INTO `abon_area` VALUES ('683', '75', '番禺');
INSERT INTO `abon_area` VALUES ('684', '75', '海珠');
INSERT INTO `abon_area` VALUES ('685', '75', '花都');
INSERT INTO `abon_area` VALUES ('686', '75', '黄埔');
INSERT INTO `abon_area` VALUES ('687', '75', '荔湾');
INSERT INTO `abon_area` VALUES ('688', '75', '萝岗');
INSERT INTO `abon_area` VALUES ('689', '75', '南沙');
INSERT INTO `abon_area` VALUES ('690', '75', '天河');
INSERT INTO `abon_area` VALUES ('691', '75', '越秀');
INSERT INTO `abon_area` VALUES ('692', '75', '增城');
INSERT INTO `abon_area` VALUES ('693', '76', '宝安');
INSERT INTO `abon_area` VALUES ('694', '76', '福田');
INSERT INTO `abon_area` VALUES ('695', '76', '龙岗');
INSERT INTO `abon_area` VALUES ('696', '76', '罗湖');
INSERT INTO `abon_area` VALUES ('697', '76', '南山');
INSERT INTO `abon_area` VALUES ('698', '76', '盐田');
INSERT INTO `abon_area` VALUES ('699', '77', '斗门');
INSERT INTO `abon_area` VALUES ('700', '77', '金湾');
INSERT INTO `abon_area` VALUES ('701', '77', '香洲');
INSERT INTO `abon_area` VALUES ('702', '78', '潮南');
INSERT INTO `abon_area` VALUES ('703', '78', '潮阳');
INSERT INTO `abon_area` VALUES ('704', '78', '澄海');
INSERT INTO `abon_area` VALUES ('705', '78', '濠江');
INSERT INTO `abon_area` VALUES ('706', '78', '金平');
INSERT INTO `abon_area` VALUES ('707', '78', '龙湖');
INSERT INTO `abon_area` VALUES ('708', '78', '南澳');
INSERT INTO `abon_area` VALUES ('709', '79', '乐昌');
INSERT INTO `abon_area` VALUES ('710', '79', '南雄');
INSERT INTO `abon_area` VALUES ('711', '79', '曲江');
INSERT INTO `abon_area` VALUES ('712', '79', '仁化');
INSERT INTO `abon_area` VALUES ('713', '79', '乳源');
INSERT INTO `abon_area` VALUES ('714', '79', '始兴');
INSERT INTO `abon_area` VALUES ('715', '79', '翁源');
INSERT INTO `abon_area` VALUES ('716', '79', '武江');
INSERT INTO `abon_area` VALUES ('717', '79', '新丰');
INSERT INTO `abon_area` VALUES ('718', '79', '浈江');
INSERT INTO `abon_area` VALUES ('719', '80', '禅城');
INSERT INTO `abon_area` VALUES ('720', '80', '高明');
INSERT INTO `abon_area` VALUES ('721', '80', '南海');
INSERT INTO `abon_area` VALUES ('722', '80', '三水');
INSERT INTO `abon_area` VALUES ('723', '80', '顺德');
INSERT INTO `abon_area` VALUES ('724', '81', '恩平');
INSERT INTO `abon_area` VALUES ('725', '81', '鹤山');
INSERT INTO `abon_area` VALUES ('726', '81', '江海');
INSERT INTO `abon_area` VALUES ('727', '81', '开平');
INSERT INTO `abon_area` VALUES ('728', '81', '蓬江');
INSERT INTO `abon_area` VALUES ('729', '81', '台山');
INSERT INTO `abon_area` VALUES ('730', '81', '新会');
INSERT INTO `abon_area` VALUES ('731', '82', '赤坎');
INSERT INTO `abon_area` VALUES ('732', '82', '雷州');
INSERT INTO `abon_area` VALUES ('733', '82', '廉江');
INSERT INTO `abon_area` VALUES ('734', '82', '麻章');
INSERT INTO `abon_area` VALUES ('735', '82', '坡头');
INSERT INTO `abon_area` VALUES ('736', '82', '遂溪');
INSERT INTO `abon_area` VALUES ('737', '82', '吴川');
INSERT INTO `abon_area` VALUES ('738', '82', '霞山');
INSERT INTO `abon_area` VALUES ('739', '82', '徐闻');
INSERT INTO `abon_area` VALUES ('740', '83', '电白');
INSERT INTO `abon_area` VALUES ('741', '83', '高州');
INSERT INTO `abon_area` VALUES ('742', '83', '化州');
INSERT INTO `abon_area` VALUES ('743', '83', '茂港');
INSERT INTO `abon_area` VALUES ('744', '83', '茂南');
INSERT INTO `abon_area` VALUES ('745', '83', '信宜');
INSERT INTO `abon_area` VALUES ('746', '84', '德庆');
INSERT INTO `abon_area` VALUES ('747', '84', '鼎湖');
INSERT INTO `abon_area` VALUES ('748', '84', '端州');
INSERT INTO `abon_area` VALUES ('749', '84', '封开');
INSERT INTO `abon_area` VALUES ('750', '84', '高要');
INSERT INTO `abon_area` VALUES ('751', '84', '广宁');
INSERT INTO `abon_area` VALUES ('752', '84', '怀集');
INSERT INTO `abon_area` VALUES ('753', '84', '四会');
INSERT INTO `abon_area` VALUES ('754', '85', '博罗');
INSERT INTO `abon_area` VALUES ('755', '85', '惠城');
INSERT INTO `abon_area` VALUES ('756', '85', '惠东');
INSERT INTO `abon_area` VALUES ('757', '85', '惠阳');
INSERT INTO `abon_area` VALUES ('758', '85', '龙门');
INSERT INTO `abon_area` VALUES ('759', '86', '大埔');
INSERT INTO `abon_area` VALUES ('760', '86', '丰顺');
INSERT INTO `abon_area` VALUES ('761', '86', '蕉岭');
INSERT INTO `abon_area` VALUES ('762', '86', '梅江');
INSERT INTO `abon_area` VALUES ('763', '86', '梅县');
INSERT INTO `abon_area` VALUES ('764', '86', '平远');
INSERT INTO `abon_area` VALUES ('765', '86', '五华');
INSERT INTO `abon_area` VALUES ('766', '86', '兴宁');
INSERT INTO `abon_area` VALUES ('767', '87', '城区');
INSERT INTO `abon_area` VALUES ('768', '87', '海丰');
INSERT INTO `abon_area` VALUES ('769', '87', '陆丰');
INSERT INTO `abon_area` VALUES ('770', '87', '陆河');
INSERT INTO `abon_area` VALUES ('771', '88', '东源');
INSERT INTO `abon_area` VALUES ('772', '88', '和平');
INSERT INTO `abon_area` VALUES ('773', '88', '连平');
INSERT INTO `abon_area` VALUES ('774', '88', '龙川');
INSERT INTO `abon_area` VALUES ('775', '88', '源城');
INSERT INTO `abon_area` VALUES ('776', '88', '紫金');
INSERT INTO `abon_area` VALUES ('777', '89', '江城');
INSERT INTO `abon_area` VALUES ('778', '89', '阳春');
INSERT INTO `abon_area` VALUES ('779', '89', '阳东');
INSERT INTO `abon_area` VALUES ('780', '89', '阳西');
INSERT INTO `abon_area` VALUES ('781', '90', '佛冈');
INSERT INTO `abon_area` VALUES ('782', '90', '连南');
INSERT INTO `abon_area` VALUES ('783', '90', '连山');
INSERT INTO `abon_area` VALUES ('784', '90', '连州');
INSERT INTO `abon_area` VALUES ('785', '90', '清城');
INSERT INTO `abon_area` VALUES ('786', '90', '清新');
INSERT INTO `abon_area` VALUES ('787', '90', '阳山');
INSERT INTO `abon_area` VALUES ('788', '90', '英德');
INSERT INTO `abon_area` VALUES ('789', '91', '莞城区');
INSERT INTO `abon_area` VALUES ('790', '91', '东城区');
INSERT INTO `abon_area` VALUES ('791', '91', '南城区');
INSERT INTO `abon_area` VALUES ('792', '91', '万江区');
INSERT INTO `abon_area` VALUES ('793', '92', '石歧区');
INSERT INTO `abon_area` VALUES ('794', '92', '东区');
INSERT INTO `abon_area` VALUES ('795', '92', '西区');
INSERT INTO `abon_area` VALUES ('796', '92', '南区');
INSERT INTO `abon_area` VALUES ('797', '92', '五桂山区');
INSERT INTO `abon_area` VALUES ('798', '92', '火炬开发区');
INSERT INTO `abon_area` VALUES ('799', '93', '潮安');
INSERT INTO `abon_area` VALUES ('800', '93', '饶平');
INSERT INTO `abon_area` VALUES ('801', '93', '湘桥');
INSERT INTO `abon_area` VALUES ('802', '94', '惠来');
INSERT INTO `abon_area` VALUES ('803', '94', '揭东');
INSERT INTO `abon_area` VALUES ('804', '94', '揭西');
INSERT INTO `abon_area` VALUES ('805', '94', '普宁');
INSERT INTO `abon_area` VALUES ('806', '94', '榕城');
INSERT INTO `abon_area` VALUES ('807', '95', '罗定');
INSERT INTO `abon_area` VALUES ('808', '95', '新兴');
INSERT INTO `abon_area` VALUES ('809', '95', '郁南');
INSERT INTO `abon_area` VALUES ('810', '95', '云安');
INSERT INTO `abon_area` VALUES ('811', '95', '云城');
INSERT INTO `abon_area` VALUES ('812', '96', '宾阳');
INSERT INTO `abon_area` VALUES ('813', '96', '横县');
INSERT INTO `abon_area` VALUES ('814', '96', '江南');
INSERT INTO `abon_area` VALUES ('815', '96', '良庆');
INSERT INTO `abon_area` VALUES ('816', '96', '隆安');
INSERT INTO `abon_area` VALUES ('817', '96', '马山');
INSERT INTO `abon_area` VALUES ('818', '96', '青秀');
INSERT INTO `abon_area` VALUES ('819', '96', '上林');
INSERT INTO `abon_area` VALUES ('820', '96', '武鸣');
INSERT INTO `abon_area` VALUES ('821', '96', '西乡塘');
INSERT INTO `abon_area` VALUES ('822', '96', '兴宁');
INSERT INTO `abon_area` VALUES ('823', '96', '邕宁');
INSERT INTO `abon_area` VALUES ('824', '97', '柳北');
INSERT INTO `abon_area` VALUES ('825', '97', '柳城');
INSERT INTO `abon_area` VALUES ('826', '97', '柳江');
INSERT INTO `abon_area` VALUES ('827', '97', '柳南');
INSERT INTO `abon_area` VALUES ('828', '97', '鹿寨');
INSERT INTO `abon_area` VALUES ('829', '97', '融安');
INSERT INTO `abon_area` VALUES ('830', '97', '融水');
INSERT INTO `abon_area` VALUES ('831', '97', '三江');
INSERT INTO `abon_area` VALUES ('832', '97', '鱼峰');
INSERT INTO `abon_area` VALUES ('833', '98', '叠彩');
INSERT INTO `abon_area` VALUES ('834', '98', '恭城');
INSERT INTO `abon_area` VALUES ('835', '98', '灌阳');
INSERT INTO `abon_area` VALUES ('836', '98', '荔蒲');
INSERT INTO `abon_area` VALUES ('837', '98', '临桂');
INSERT INTO `abon_area` VALUES ('838', '98', '灵川');
INSERT INTO `abon_area` VALUES ('839', '98', '龙胜');
INSERT INTO `abon_area` VALUES ('840', '98', '平乐');
INSERT INTO `abon_area` VALUES ('841', '98', '七星');
INSERT INTO `abon_area` VALUES ('842', '98', '全州');
INSERT INTO `abon_area` VALUES ('843', '98', '象山');
INSERT INTO `abon_area` VALUES ('844', '98', '兴安');
INSERT INTO `abon_area` VALUES ('845', '98', '秀峰');
INSERT INTO `abon_area` VALUES ('846', '98', '雁山');
INSERT INTO `abon_area` VALUES ('847', '98', '阳朔');
INSERT INTO `abon_area` VALUES ('848', '98', '永福');
INSERT INTO `abon_area` VALUES ('849', '98', '资源');
INSERT INTO `abon_area` VALUES ('850', '99', '苍梧');
INSERT INTO `abon_area` VALUES ('851', '99', '岑溪');
INSERT INTO `abon_area` VALUES ('852', '99', '龙圩');
INSERT INTO `abon_area` VALUES ('853', '99', '蒙山');
INSERT INTO `abon_area` VALUES ('854', '99', '藤县');
INSERT INTO `abon_area` VALUES ('855', '99', '万秀');
INSERT INTO `abon_area` VALUES ('856', '99', '长洲');
INSERT INTO `abon_area` VALUES ('857', '100', '海城');
INSERT INTO `abon_area` VALUES ('858', '100', '合浦');
INSERT INTO `abon_area` VALUES ('859', '100', '铁山港');
INSERT INTO `abon_area` VALUES ('860', '100', '银海');
INSERT INTO `abon_area` VALUES ('861', '101', '东兴');
INSERT INTO `abon_area` VALUES ('862', '101', '防城');
INSERT INTO `abon_area` VALUES ('863', '101', '港口');
INSERT INTO `abon_area` VALUES ('864', '101', '上思');
INSERT INTO `abon_area` VALUES ('865', '102', '灵山');
INSERT INTO `abon_area` VALUES ('866', '102', '浦北');
INSERT INTO `abon_area` VALUES ('867', '102', '钦北');
INSERT INTO `abon_area` VALUES ('868', '102', '钦南');
INSERT INTO `abon_area` VALUES ('869', '103', '港北');
INSERT INTO `abon_area` VALUES ('870', '103', '港南');
INSERT INTO `abon_area` VALUES ('871', '103', '桂平');
INSERT INTO `abon_area` VALUES ('872', '103', '平南');
INSERT INTO `abon_area` VALUES ('873', '103', '覃塘');
INSERT INTO `abon_area` VALUES ('874', '104', '北流');
INSERT INTO `abon_area` VALUES ('875', '104', '博白');
INSERT INTO `abon_area` VALUES ('876', '104', '福绵');
INSERT INTO `abon_area` VALUES ('877', '104', '陆川');
INSERT INTO `abon_area` VALUES ('878', '104', '容县');
INSERT INTO `abon_area` VALUES ('879', '104', '兴业');
INSERT INTO `abon_area` VALUES ('880', '104', '玉州');
INSERT INTO `abon_area` VALUES ('881', '105', '德保');
INSERT INTO `abon_area` VALUES ('882', '105', '靖西');
INSERT INTO `abon_area` VALUES ('883', '105', '乐业');
INSERT INTO `abon_area` VALUES ('884', '105', '凌云');
INSERT INTO `abon_area` VALUES ('885', '105', '隆林');
INSERT INTO `abon_area` VALUES ('886', '105', '那坡');
INSERT INTO `abon_area` VALUES ('887', '105', '平果');
INSERT INTO `abon_area` VALUES ('888', '105', '田东');
INSERT INTO `abon_area` VALUES ('889', '105', '田林');
INSERT INTO `abon_area` VALUES ('890', '105', '田阳');
INSERT INTO `abon_area` VALUES ('891', '105', '西林');
INSERT INTO `abon_area` VALUES ('892', '105', '右江');
INSERT INTO `abon_area` VALUES ('893', '106', '八步');
INSERT INTO `abon_area` VALUES ('894', '106', '富川');
INSERT INTO `abon_area` VALUES ('895', '106', '昭平');
INSERT INTO `abon_area` VALUES ('896', '106', '钟山');
INSERT INTO `abon_area` VALUES ('897', '107', '巴马');
INSERT INTO `abon_area` VALUES ('898', '107', '大化');
INSERT INTO `abon_area` VALUES ('899', '107', '东兰');
INSERT INTO `abon_area` VALUES ('900', '107', '都安');
INSERT INTO `abon_area` VALUES ('901', '107', '凤山');
INSERT INTO `abon_area` VALUES ('902', '107', '环江');
INSERT INTO `abon_area` VALUES ('903', '107', '金城江');
INSERT INTO `abon_area` VALUES ('904', '107', '罗城');
INSERT INTO `abon_area` VALUES ('905', '107', '南丹');
INSERT INTO `abon_area` VALUES ('906', '107', '天峨');
INSERT INTO `abon_area` VALUES ('907', '107', '宜州');
INSERT INTO `abon_area` VALUES ('908', '108', '合山');
INSERT INTO `abon_area` VALUES ('909', '108', '金秀');
INSERT INTO `abon_area` VALUES ('910', '108', '武宣');
INSERT INTO `abon_area` VALUES ('911', '108', '象州');
INSERT INTO `abon_area` VALUES ('912', '108', '忻城');
INSERT INTO `abon_area` VALUES ('913', '108', '兴宾');
INSERT INTO `abon_area` VALUES ('914', '109', '大新');
INSERT INTO `abon_area` VALUES ('915', '109', '扶绥');
INSERT INTO `abon_area` VALUES ('916', '109', '江洲');
INSERT INTO `abon_area` VALUES ('917', '109', '龙州');
INSERT INTO `abon_area` VALUES ('918', '109', '宁明');
INSERT INTO `abon_area` VALUES ('919', '109', '凭祥');
INSERT INTO `abon_area` VALUES ('920', '109', '天等');
INSERT INTO `abon_area` VALUES ('921', '110', '白云');
INSERT INTO `abon_area` VALUES ('922', '110', '观山湖');
INSERT INTO `abon_area` VALUES ('923', '110', '花溪');
INSERT INTO `abon_area` VALUES ('924', '110', '开阳');
INSERT INTO `abon_area` VALUES ('925', '110', '南明');
INSERT INTO `abon_area` VALUES ('926', '110', '清镇');
INSERT INTO `abon_area` VALUES ('927', '110', '乌当');
INSERT INTO `abon_area` VALUES ('928', '110', '息烽');
INSERT INTO `abon_area` VALUES ('929', '110', '修文');
INSERT INTO `abon_area` VALUES ('930', '110', '云岩');
INSERT INTO `abon_area` VALUES ('931', '111', '六枝');
INSERT INTO `abon_area` VALUES ('932', '111', '盘县');
INSERT INTO `abon_area` VALUES ('933', '111', '水城');
INSERT INTO `abon_area` VALUES ('934', '111', '钟山');
INSERT INTO `abon_area` VALUES ('935', '112', '赤水');
INSERT INTO `abon_area` VALUES ('936', '112', '道真');
INSERT INTO `abon_area` VALUES ('937', '112', '凤冈');
INSERT INTO `abon_area` VALUES ('938', '112', '红花岗');
INSERT INTO `abon_area` VALUES ('939', '112', '汇川');
INSERT INTO `abon_area` VALUES ('940', '112', '湄潭');
INSERT INTO `abon_area` VALUES ('941', '112', '仁怀');
INSERT INTO `abon_area` VALUES ('942', '112', '绥阳');
INSERT INTO `abon_area` VALUES ('943', '112', '桐梓');
INSERT INTO `abon_area` VALUES ('944', '112', '务川');
INSERT INTO `abon_area` VALUES ('945', '112', '习水');
INSERT INTO `abon_area` VALUES ('946', '112', '余庆');
INSERT INTO `abon_area` VALUES ('947', '112', '正安');
INSERT INTO `abon_area` VALUES ('948', '112', '遵义');
INSERT INTO `abon_area` VALUES ('949', '113', '关岭');
INSERT INTO `abon_area` VALUES ('950', '113', '平坝');
INSERT INTO `abon_area` VALUES ('951', '113', '普定');
INSERT INTO `abon_area` VALUES ('952', '113', '西秀');
INSERT INTO `abon_area` VALUES ('953', '113', '镇宁');
INSERT INTO `abon_area` VALUES ('954', '113', '紫云');
INSERT INTO `abon_area` VALUES ('955', '114', '碧江');
INSERT INTO `abon_area` VALUES ('956', '114', '德江');
INSERT INTO `abon_area` VALUES ('957', '114', '江口');
INSERT INTO `abon_area` VALUES ('958', '114', '石阡');
INSERT INTO `abon_area` VALUES ('959', '114', '思南');
INSERT INTO `abon_area` VALUES ('960', '114', '松桃');
INSERT INTO `abon_area` VALUES ('961', '114', '万山');
INSERT INTO `abon_area` VALUES ('962', '114', '沿河');
INSERT INTO `abon_area` VALUES ('963', '114', '印江');
INSERT INTO `abon_area` VALUES ('964', '114', '玉屏');
INSERT INTO `abon_area` VALUES ('965', '115', '大方');
INSERT INTO `abon_area` VALUES ('966', '115', '赫章');
INSERT INTO `abon_area` VALUES ('967', '115', '金沙');
INSERT INTO `abon_area` VALUES ('968', '115', '纳雍');
INSERT INTO `abon_area` VALUES ('969', '115', '七星关');
INSERT INTO `abon_area` VALUES ('970', '115', '黔西');
INSERT INTO `abon_area` VALUES ('971', '115', '威宁');
INSERT INTO `abon_area` VALUES ('972', '115', '织金');
INSERT INTO `abon_area` VALUES ('973', '116', '安龙');
INSERT INTO `abon_area` VALUES ('974', '116', '册亨');
INSERT INTO `abon_area` VALUES ('975', '116', '普安');
INSERT INTO `abon_area` VALUES ('976', '116', '晴隆');
INSERT INTO `abon_area` VALUES ('977', '116', '望谟');
INSERT INTO `abon_area` VALUES ('978', '116', '兴仁');
INSERT INTO `abon_area` VALUES ('979', '116', '兴义');
INSERT INTO `abon_area` VALUES ('980', '116', '贞丰');
INSERT INTO `abon_area` VALUES ('981', '117', '岑巩');
INSERT INTO `abon_area` VALUES ('982', '117', '从江');
INSERT INTO `abon_area` VALUES ('983', '117', '丹寨');
INSERT INTO `abon_area` VALUES ('984', '117', '黄平');
INSERT INTO `abon_area` VALUES ('985', '117', '剑河');
INSERT INTO `abon_area` VALUES ('986', '117', '锦屏');
INSERT INTO `abon_area` VALUES ('987', '117', '凯里');
INSERT INTO `abon_area` VALUES ('988', '117', '雷山');
INSERT INTO `abon_area` VALUES ('989', '117', '黎平');
INSERT INTO `abon_area` VALUES ('990', '117', '麻江');
INSERT INTO `abon_area` VALUES ('991', '117', '榕江');
INSERT INTO `abon_area` VALUES ('992', '117', '三穗');
INSERT INTO `abon_area` VALUES ('993', '117', '施秉');
INSERT INTO `abon_area` VALUES ('994', '117', '台江');
INSERT INTO `abon_area` VALUES ('995', '117', '天柱');
INSERT INTO `abon_area` VALUES ('996', '117', '镇远');
INSERT INTO `abon_area` VALUES ('997', '118', '都匀');
INSERT INTO `abon_area` VALUES ('998', '118', '独山');
INSERT INTO `abon_area` VALUES ('999', '118', '福泉');
INSERT INTO `abon_area` VALUES ('1000', '118', '贵定');
INSERT INTO `abon_area` VALUES ('1001', '118', '惠水');
INSERT INTO `abon_area` VALUES ('1002', '118', '荔波');
INSERT INTO `abon_area` VALUES ('1003', '118', '龙里');
INSERT INTO `abon_area` VALUES ('1004', '118', '罗甸');
INSERT INTO `abon_area` VALUES ('1005', '118', '平塘');
INSERT INTO `abon_area` VALUES ('1006', '118', '三都');
INSERT INTO `abon_area` VALUES ('1007', '118', '瓮安');
INSERT INTO `abon_area` VALUES ('1008', '118', '长顺');
INSERT INTO `abon_area` VALUES ('1009', '119', '龙华');
INSERT INTO `abon_area` VALUES ('1010', '119', '美兰');
INSERT INTO `abon_area` VALUES ('1011', '119', '琼山');
INSERT INTO `abon_area` VALUES ('1012', '119', '秀英');
INSERT INTO `abon_area` VALUES ('1013', '120', '河东区');
INSERT INTO `abon_area` VALUES ('1014', '120', '河西区');
INSERT INTO `abon_area` VALUES ('1015', '121', '白沙');
INSERT INTO `abon_area` VALUES ('1016', '121', '保亭');
INSERT INTO `abon_area` VALUES ('1017', '121', '昌江');
INSERT INTO `abon_area` VALUES ('1018', '121', '澄迈');
INSERT INTO `abon_area` VALUES ('1019', '121', '儋州');
INSERT INTO `abon_area` VALUES ('1020', '121', '定安');
INSERT INTO `abon_area` VALUES ('1021', '121', '东方');
INSERT INTO `abon_area` VALUES ('1022', '121', '乐东');
INSERT INTO `abon_area` VALUES ('1023', '121', '临高');
INSERT INTO `abon_area` VALUES ('1024', '121', '陵水');
INSERT INTO `abon_area` VALUES ('1025', '121', '南沙');
INSERT INTO `abon_area` VALUES ('1026', '121', '琼海');
INSERT INTO `abon_area` VALUES ('1027', '121', '琼中');
INSERT INTO `abon_area` VALUES ('1028', '121', '屯昌');
INSERT INTO `abon_area` VALUES ('1029', '121', '万宁');
INSERT INTO `abon_area` VALUES ('1030', '121', '文昌');
INSERT INTO `abon_area` VALUES ('1031', '121', '五指山');
INSERT INTO `abon_area` VALUES ('1032', '121', '西沙');
INSERT INTO `abon_area` VALUES ('1033', '121', '中沙');
INSERT INTO `abon_area` VALUES ('1034', '122', '高邑');
INSERT INTO `abon_area` VALUES ('1035', '122', '藁城');
INSERT INTO `abon_area` VALUES ('1036', '122', '行唐');
INSERT INTO `abon_area` VALUES ('1037', '122', '晋州');
INSERT INTO `abon_area` VALUES ('1038', '122', '井陉');
INSERT INTO `abon_area` VALUES ('1039', '122', '井陉');
INSERT INTO `abon_area` VALUES ('1040', '122', '灵寿');
INSERT INTO `abon_area` VALUES ('1041', '122', '鹿泉');
INSERT INTO `abon_area` VALUES ('1042', '122', '栾城');
INSERT INTO `abon_area` VALUES ('1043', '122', '平山');
INSERT INTO `abon_area` VALUES ('1044', '122', '桥东');
INSERT INTO `abon_area` VALUES ('1045', '122', '桥西');
INSERT INTO `abon_area` VALUES ('1046', '122', '深泽');
INSERT INTO `abon_area` VALUES ('1047', '122', '无极');
INSERT INTO `abon_area` VALUES ('1048', '122', '辛集');
INSERT INTO `abon_area` VALUES ('1049', '122', '新华');
INSERT INTO `abon_area` VALUES ('1050', '122', '新乐');
INSERT INTO `abon_area` VALUES ('1051', '122', '裕华');
INSERT INTO `abon_area` VALUES ('1052', '122', '元氏');
INSERT INTO `abon_area` VALUES ('1053', '122', '赞皇');
INSERT INTO `abon_area` VALUES ('1054', '122', '长安');
INSERT INTO `abon_area` VALUES ('1055', '122', '赵县');
INSERT INTO `abon_area` VALUES ('1056', '122', '正定');
INSERT INTO `abon_area` VALUES ('1057', '123', '曹妃甸');
INSERT INTO `abon_area` VALUES ('1058', '123', '丰南');
INSERT INTO `abon_area` VALUES ('1059', '123', '丰润');
INSERT INTO `abon_area` VALUES ('1060', '123', '古冶');
INSERT INTO `abon_area` VALUES ('1061', '123', '开平');
INSERT INTO `abon_area` VALUES ('1062', '123', '乐亭');
INSERT INTO `abon_area` VALUES ('1063', '123', '路北');
INSERT INTO `abon_area` VALUES ('1064', '123', '路南');
INSERT INTO `abon_area` VALUES ('1065', '123', '滦南');
INSERT INTO `abon_area` VALUES ('1066', '123', '滦县');
INSERT INTO `abon_area` VALUES ('1067', '123', '迁安');
INSERT INTO `abon_area` VALUES ('1068', '123', '迁西');
INSERT INTO `abon_area` VALUES ('1069', '123', '玉田');
INSERT INTO `abon_area` VALUES ('1070', '123', '遵化');
INSERT INTO `abon_area` VALUES ('1071', '124', '北戴河');
INSERT INTO `abon_area` VALUES ('1072', '124', '昌黎');
INSERT INTO `abon_area` VALUES ('1073', '124', '抚宁');
INSERT INTO `abon_area` VALUES ('1074', '124', '海港');
INSERT INTO `abon_area` VALUES ('1075', '124', '卢龙');
INSERT INTO `abon_area` VALUES ('1076', '124', '青龙');
INSERT INTO `abon_area` VALUES ('1077', '124', '山海关');
INSERT INTO `abon_area` VALUES ('1078', '125', '成安');
INSERT INTO `abon_area` VALUES ('1079', '125', '磁县');
INSERT INTO `abon_area` VALUES ('1080', '125', '丛台');
INSERT INTO `abon_area` VALUES ('1081', '125', '大名');
INSERT INTO `abon_area` VALUES ('1082', '125', '肥乡');
INSERT INTO `abon_area` VALUES ('1083', '125', '峰峰');
INSERT INTO `abon_area` VALUES ('1084', '125', '复兴');
INSERT INTO `abon_area` VALUES ('1085', '125', '馆陶');
INSERT INTO `abon_area` VALUES ('1086', '125', '广平');
INSERT INTO `abon_area` VALUES ('1087', '125', '邯郸');
INSERT INTO `abon_area` VALUES ('1088', '125', '邯山');
INSERT INTO `abon_area` VALUES ('1089', '125', '鸡泽');
INSERT INTO `abon_area` VALUES ('1090', '125', '临漳');
INSERT INTO `abon_area` VALUES ('1091', '125', '邱县');
INSERT INTO `abon_area` VALUES ('1092', '125', '曲周');
INSERT INTO `abon_area` VALUES ('1093', '125', '涉县');
INSERT INTO `abon_area` VALUES ('1094', '125', '魏县');
INSERT INTO `abon_area` VALUES ('1095', '125', '武安');
INSERT INTO `abon_area` VALUES ('1096', '125', '永年');
INSERT INTO `abon_area` VALUES ('1097', '126', '柏乡');
INSERT INTO `abon_area` VALUES ('1098', '126', '广宗');
INSERT INTO `abon_area` VALUES ('1099', '126', '巨鹿');
INSERT INTO `abon_area` VALUES ('1100', '126', '临城');
INSERT INTO `abon_area` VALUES ('1101', '126', '临西');
INSERT INTO `abon_area` VALUES ('1102', '126', '隆尧');
INSERT INTO `abon_area` VALUES ('1103', '126', '南宫');
INSERT INTO `abon_area` VALUES ('1104', '126', '南和');
INSERT INTO `abon_area` VALUES ('1105', '126', '内丘');
INSERT INTO `abon_area` VALUES ('1106', '126', '宁晋');
INSERT INTO `abon_area` VALUES ('1107', '126', '平乡');
INSERT INTO `abon_area` VALUES ('1108', '126', '桥东');
INSERT INTO `abon_area` VALUES ('1109', '126', '桥西');
INSERT INTO `abon_area` VALUES ('1110', '126', '清河');
INSERT INTO `abon_area` VALUES ('1111', '126', '任县');
INSERT INTO `abon_area` VALUES ('1112', '126', '沙河');
INSERT INTO `abon_area` VALUES ('1113', '126', '威县');
INSERT INTO `abon_area` VALUES ('1114', '126', '新河');
INSERT INTO `abon_area` VALUES ('1115', '126', '邢台');
INSERT INTO `abon_area` VALUES ('1116', '127', '安国');
INSERT INTO `abon_area` VALUES ('1117', '127', '安新');
INSERT INTO `abon_area` VALUES ('1118', '127', '北市');
INSERT INTO `abon_area` VALUES ('1119', '127', '博野');
INSERT INTO `abon_area` VALUES ('1120', '127', '定兴');
INSERT INTO `abon_area` VALUES ('1121', '127', '定州');
INSERT INTO `abon_area` VALUES ('1122', '127', '阜平');
INSERT INTO `abon_area` VALUES ('1123', '127', '高碑店');
INSERT INTO `abon_area` VALUES ('1124', '127', '高阳');
INSERT INTO `abon_area` VALUES ('1125', '127', '涞水');
INSERT INTO `abon_area` VALUES ('1126', '127', '涞源');
INSERT INTO `abon_area` VALUES ('1127', '127', '蠡县');
INSERT INTO `abon_area` VALUES ('1128', '127', '满城');
INSERT INTO `abon_area` VALUES ('1129', '127', '南市');
INSERT INTO `abon_area` VALUES ('1130', '127', '清苑');
INSERT INTO `abon_area` VALUES ('1131', '127', '曲阳');
INSERT INTO `abon_area` VALUES ('1132', '127', '容城');
INSERT INTO `abon_area` VALUES ('1133', '127', '顺平');
INSERT INTO `abon_area` VALUES ('1134', '127', '唐县');
INSERT INTO `abon_area` VALUES ('1135', '127', '望都');
INSERT INTO `abon_area` VALUES ('1136', '127', '新市');
INSERT INTO `abon_area` VALUES ('1137', '127', '雄县');
INSERT INTO `abon_area` VALUES ('1138', '127', '徐水');
INSERT INTO `abon_area` VALUES ('1139', '127', '易县');
INSERT INTO `abon_area` VALUES ('1140', '127', '涿州');
INSERT INTO `abon_area` VALUES ('1141', '128', '赤城');
INSERT INTO `abon_area` VALUES ('1142', '128', '崇礼');
INSERT INTO `abon_area` VALUES ('1143', '128', '沽源');
INSERT INTO `abon_area` VALUES ('1144', '128', '怀安');
INSERT INTO `abon_area` VALUES ('1145', '128', '怀来');
INSERT INTO `abon_area` VALUES ('1146', '128', '康保');
INSERT INTO `abon_area` VALUES ('1147', '128', '桥东');
INSERT INTO `abon_area` VALUES ('1148', '128', '桥西');
INSERT INTO `abon_area` VALUES ('1149', '128', '尚义');
INSERT INTO `abon_area` VALUES ('1150', '128', '万全');
INSERT INTO `abon_area` VALUES ('1151', '128', '蔚县');
INSERT INTO `abon_area` VALUES ('1152', '128', '下花园');
INSERT INTO `abon_area` VALUES ('1153', '128', '宣化');
INSERT INTO `abon_area` VALUES ('1154', '128', '宣化');
INSERT INTO `abon_area` VALUES ('1155', '128', '阳原');
INSERT INTO `abon_area` VALUES ('1156', '128', '张北');
INSERT INTO `abon_area` VALUES ('1157', '128', '涿鹿');
INSERT INTO `abon_area` VALUES ('1158', '129', '承德');
INSERT INTO `abon_area` VALUES ('1159', '129', '丰宁');
INSERT INTO `abon_area` VALUES ('1160', '129', '宽城');
INSERT INTO `abon_area` VALUES ('1161', '129', '隆化');
INSERT INTO `abon_area` VALUES ('1162', '129', '滦平');
INSERT INTO `abon_area` VALUES ('1163', '129', '平泉');
INSERT INTO `abon_area` VALUES ('1164', '129', '双滦');
INSERT INTO `abon_area` VALUES ('1165', '129', '双桥');
INSERT INTO `abon_area` VALUES ('1166', '129', '围场');
INSERT INTO `abon_area` VALUES ('1167', '129', '兴隆');
INSERT INTO `abon_area` VALUES ('1168', '129', '鹰手营子');
INSERT INTO `abon_area` VALUES ('1169', '130', '泊头');
INSERT INTO `abon_area` VALUES ('1170', '130', '沧县');
INSERT INTO `abon_area` VALUES ('1171', '130', '东光');
INSERT INTO `abon_area` VALUES ('1172', '130', '海兴');
INSERT INTO `abon_area` VALUES ('1173', '130', '河间');
INSERT INTO `abon_area` VALUES ('1174', '130', '黄骅');
INSERT INTO `abon_area` VALUES ('1175', '130', '孟村');
INSERT INTO `abon_area` VALUES ('1176', '130', '南皮');
INSERT INTO `abon_area` VALUES ('1177', '130', '青县');
INSERT INTO `abon_area` VALUES ('1178', '130', '任丘');
INSERT INTO `abon_area` VALUES ('1179', '130', '肃宁');
INSERT INTO `abon_area` VALUES ('1180', '130', '吴桥');
INSERT INTO `abon_area` VALUES ('1181', '130', '献县');
INSERT INTO `abon_area` VALUES ('1182', '130', '新华');
INSERT INTO `abon_area` VALUES ('1183', '130', '盐山');
INSERT INTO `abon_area` VALUES ('1184', '130', '运河');
INSERT INTO `abon_area` VALUES ('1185', '131', '安次');
INSERT INTO `abon_area` VALUES ('1186', '131', '霸州');
INSERT INTO `abon_area` VALUES ('1187', '131', '大厂');
INSERT INTO `abon_area` VALUES ('1188', '131', '大城');
INSERT INTO `abon_area` VALUES ('1189', '131', '固安');
INSERT INTO `abon_area` VALUES ('1190', '131', '广阳');
INSERT INTO `abon_area` VALUES ('1191', '131', '三河');
INSERT INTO `abon_area` VALUES ('1192', '131', '文安');
INSERT INTO `abon_area` VALUES ('1193', '131', '香河');
INSERT INTO `abon_area` VALUES ('1194', '131', '永清');
INSERT INTO `abon_area` VALUES ('1195', '132', '安平');
INSERT INTO `abon_area` VALUES ('1196', '132', '阜城');
INSERT INTO `abon_area` VALUES ('1197', '132', '故城');
INSERT INTO `abon_area` VALUES ('1198', '132', '冀州');
INSERT INTO `abon_area` VALUES ('1199', '132', '景县');
INSERT INTO `abon_area` VALUES ('1200', '132', '饶阳');
INSERT INTO `abon_area` VALUES ('1201', '132', '深州');
INSERT INTO `abon_area` VALUES ('1202', '132', '桃城');
INSERT INTO `abon_area` VALUES ('1203', '132', '武强');
INSERT INTO `abon_area` VALUES ('1204', '132', '武邑');
INSERT INTO `abon_area` VALUES ('1205', '132', '枣强');
INSERT INTO `abon_area` VALUES ('1206', '133', '登封');
INSERT INTO `abon_area` VALUES ('1207', '133', '二七');
INSERT INTO `abon_area` VALUES ('1208', '133', '巩义');
INSERT INTO `abon_area` VALUES ('1209', '133', '管城');
INSERT INTO `abon_area` VALUES ('1210', '133', '惠济');
INSERT INTO `abon_area` VALUES ('1211', '133', '金水');
INSERT INTO `abon_area` VALUES ('1212', '133', '上街');
INSERT INTO `abon_area` VALUES ('1213', '133', '新密');
INSERT INTO `abon_area` VALUES ('1214', '133', '新郑');
INSERT INTO `abon_area` VALUES ('1215', '133', '荥阳');
INSERT INTO `abon_area` VALUES ('1216', '133', '中牟');
INSERT INTO `abon_area` VALUES ('1217', '133', '中原');
INSERT INTO `abon_area` VALUES ('1218', '134', '鼓楼');
INSERT INTO `abon_area` VALUES ('1219', '134', '金明');
INSERT INTO `abon_area` VALUES ('1220', '134', '开封');
INSERT INTO `abon_area` VALUES ('1221', '134', '兰考');
INSERT INTO `abon_area` VALUES ('1222', '134', '龙亭');
INSERT INTO `abon_area` VALUES ('1223', '134', '杞县');
INSERT INTO `abon_area` VALUES ('1224', '134', '顺河');
INSERT INTO `abon_area` VALUES ('1225', '134', '通许');
INSERT INTO `abon_area` VALUES ('1226', '134', '尉氏');
INSERT INTO `abon_area` VALUES ('1227', '134', '禹王台');
INSERT INTO `abon_area` VALUES ('1228', '135', '瀍河');
INSERT INTO `abon_area` VALUES ('1229', '135', '吉利');
INSERT INTO `abon_area` VALUES ('1230', '135', '涧西');
INSERT INTO `abon_area` VALUES ('1231', '135', '老城');
INSERT INTO `abon_area` VALUES ('1232', '135', '栾川');
INSERT INTO `abon_area` VALUES ('1233', '135', '洛龙');
INSERT INTO `abon_area` VALUES ('1234', '135', '洛宁');
INSERT INTO `abon_area` VALUES ('1235', '135', '孟津');
INSERT INTO `abon_area` VALUES ('1236', '135', '汝阳');
INSERT INTO `abon_area` VALUES ('1237', '135', '嵩县');
INSERT INTO `abon_area` VALUES ('1238', '135', '西工');
INSERT INTO `abon_area` VALUES ('1239', '135', '新安');
INSERT INTO `abon_area` VALUES ('1240', '135', '偃师');
INSERT INTO `abon_area` VALUES ('1241', '135', '伊川');
INSERT INTO `abon_area` VALUES ('1242', '135', '宜阳');
INSERT INTO `abon_area` VALUES ('1243', '136', '宝丰');
INSERT INTO `abon_area` VALUES ('1244', '136', '郏县');
INSERT INTO `abon_area` VALUES ('1245', '136', '鲁山');
INSERT INTO `abon_area` VALUES ('1246', '136', '汝州');
INSERT INTO `abon_area` VALUES ('1247', '136', '石龙');
INSERT INTO `abon_area` VALUES ('1248', '136', '卫东');
INSERT INTO `abon_area` VALUES ('1249', '136', '舞钢');
INSERT INTO `abon_area` VALUES ('1250', '136', '新华');
INSERT INTO `abon_area` VALUES ('1251', '136', '叶县');
INSERT INTO `abon_area` VALUES ('1252', '136', '湛河');
INSERT INTO `abon_area` VALUES ('1253', '137', '博爱');
INSERT INTO `abon_area` VALUES ('1254', '137', '解放');
INSERT INTO `abon_area` VALUES ('1255', '137', '马村');
INSERT INTO `abon_area` VALUES ('1256', '137', '孟州');
INSERT INTO `abon_area` VALUES ('1257', '137', '沁阳');
INSERT INTO `abon_area` VALUES ('1258', '137', '山阳');
INSERT INTO `abon_area` VALUES ('1259', '137', '温县');
INSERT INTO `abon_area` VALUES ('1260', '137', '武陟');
INSERT INTO `abon_area` VALUES ('1261', '137', '修武');
INSERT INTO `abon_area` VALUES ('1262', '137', '中站');
INSERT INTO `abon_area` VALUES ('1263', '138', '鹤山');
INSERT INTO `abon_area` VALUES ('1264', '138', '浚县');
INSERT INTO `abon_area` VALUES ('1265', '138', '淇滨');
INSERT INTO `abon_area` VALUES ('1266', '138', '淇县');
INSERT INTO `abon_area` VALUES ('1267', '138', '山城');
INSERT INTO `abon_area` VALUES ('1268', '139', '封丘');
INSERT INTO `abon_area` VALUES ('1269', '139', '凤泉');
INSERT INTO `abon_area` VALUES ('1270', '139', '红旗');
INSERT INTO `abon_area` VALUES ('1271', '139', '辉县');
INSERT INTO `abon_area` VALUES ('1272', '139', '获嘉');
INSERT INTO `abon_area` VALUES ('1273', '139', '牧野');
INSERT INTO `abon_area` VALUES ('1274', '139', '卫滨');
INSERT INTO `abon_area` VALUES ('1275', '139', '卫辉');
INSERT INTO `abon_area` VALUES ('1276', '139', '新乡');
INSERT INTO `abon_area` VALUES ('1277', '139', '延津');
INSERT INTO `abon_area` VALUES ('1278', '139', '原阳');
INSERT INTO `abon_area` VALUES ('1279', '139', '长垣');
INSERT INTO `abon_area` VALUES ('1280', '140', '安阳');
INSERT INTO `abon_area` VALUES ('1281', '140', '北关');
INSERT INTO `abon_area` VALUES ('1282', '140', '滑县');
INSERT INTO `abon_area` VALUES ('1283', '140', '林州');
INSERT INTO `abon_area` VALUES ('1284', '140', '龙安');
INSERT INTO `abon_area` VALUES ('1285', '140', '内黄');
INSERT INTO `abon_area` VALUES ('1286', '140', '汤阴');
INSERT INTO `abon_area` VALUES ('1287', '140', '文峰');
INSERT INTO `abon_area` VALUES ('1288', '140', '殷都');
INSERT INTO `abon_area` VALUES ('1289', '141', '范县');
INSERT INTO `abon_area` VALUES ('1290', '141', '华龙');
INSERT INTO `abon_area` VALUES ('1291', '141', '南乐');
INSERT INTO `abon_area` VALUES ('1292', '141', '濮阳');
INSERT INTO `abon_area` VALUES ('1293', '141', '清丰');
INSERT INTO `abon_area` VALUES ('1294', '141', '台前');
INSERT INTO `abon_area` VALUES ('1295', '142', '魏都');
INSERT INTO `abon_area` VALUES ('1296', '142', '襄城');
INSERT INTO `abon_area` VALUES ('1297', '142', '许昌');
INSERT INTO `abon_area` VALUES ('1298', '142', '鄢陵');
INSERT INTO `abon_area` VALUES ('1299', '142', '禹州');
INSERT INTO `abon_area` VALUES ('1300', '142', '长葛');
INSERT INTO `abon_area` VALUES ('1301', '143', '临颍');
INSERT INTO `abon_area` VALUES ('1302', '143', '舞阳');
INSERT INTO `abon_area` VALUES ('1303', '143', '郾城');
INSERT INTO `abon_area` VALUES ('1304', '143', '源汇');
INSERT INTO `abon_area` VALUES ('1305', '143', '召陵');
INSERT INTO `abon_area` VALUES ('1306', '144', '湖滨');
INSERT INTO `abon_area` VALUES ('1307', '144', '灵宝');
INSERT INTO `abon_area` VALUES ('1308', '144', '卢氏');
INSERT INTO `abon_area` VALUES ('1309', '144', '渑池');
INSERT INTO `abon_area` VALUES ('1310', '144', '陕县');
INSERT INTO `abon_area` VALUES ('1311', '144', '义马');
INSERT INTO `abon_area` VALUES ('1312', '145', '邓州');
INSERT INTO `abon_area` VALUES ('1313', '145', '方城');
INSERT INTO `abon_area` VALUES ('1314', '145', '南召');
INSERT INTO `abon_area` VALUES ('1315', '145', '内乡');
INSERT INTO `abon_area` VALUES ('1316', '145', '社旗');
INSERT INTO `abon_area` VALUES ('1317', '145', '唐河');
INSERT INTO `abon_area` VALUES ('1318', '145', '桐柏');
INSERT INTO `abon_area` VALUES ('1319', '145', '宛城');
INSERT INTO `abon_area` VALUES ('1320', '145', '卧龙');
INSERT INTO `abon_area` VALUES ('1321', '145', '西峡');
INSERT INTO `abon_area` VALUES ('1322', '145', '淅川');
INSERT INTO `abon_area` VALUES ('1323', '145', '新野');
INSERT INTO `abon_area` VALUES ('1324', '145', '镇平');
INSERT INTO `abon_area` VALUES ('1325', '146', '梁园');
INSERT INTO `abon_area` VALUES ('1326', '146', '民权');
INSERT INTO `abon_area` VALUES ('1327', '146', '宁陵');
INSERT INTO `abon_area` VALUES ('1328', '146', '睢县');
INSERT INTO `abon_area` VALUES ('1329', '146', '睢阳');
INSERT INTO `abon_area` VALUES ('1330', '146', '夏邑');
INSERT INTO `abon_area` VALUES ('1331', '146', '永城');
INSERT INTO `abon_area` VALUES ('1332', '146', '虞城');
INSERT INTO `abon_area` VALUES ('1333', '146', '柘城');
INSERT INTO `abon_area` VALUES ('1334', '147', '固始');
INSERT INTO `abon_area` VALUES ('1335', '147', '光山');
INSERT INTO `abon_area` VALUES ('1336', '147', '淮滨');
INSERT INTO `abon_area` VALUES ('1337', '147', '潢川');
INSERT INTO `abon_area` VALUES ('1338', '147', '罗山');
INSERT INTO `abon_area` VALUES ('1339', '147', '平桥');
INSERT INTO `abon_area` VALUES ('1340', '147', '商城');
INSERT INTO `abon_area` VALUES ('1341', '147', '浉河');
INSERT INTO `abon_area` VALUES ('1342', '147', '息县');
INSERT INTO `abon_area` VALUES ('1343', '147', '新县');
INSERT INTO `abon_area` VALUES ('1344', '148', '川汇');
INSERT INTO `abon_area` VALUES ('1345', '148', '郸城');
INSERT INTO `abon_area` VALUES ('1346', '148', '扶沟');
INSERT INTO `abon_area` VALUES ('1347', '148', '淮阳');
INSERT INTO `abon_area` VALUES ('1348', '148', '鹿邑');
INSERT INTO `abon_area` VALUES ('1349', '148', '商水');
INSERT INTO `abon_area` VALUES ('1350', '148', '沈丘');
INSERT INTO `abon_area` VALUES ('1351', '148', '太康');
INSERT INTO `abon_area` VALUES ('1352', '148', '西华');
INSERT INTO `abon_area` VALUES ('1353', '148', '项城');
INSERT INTO `abon_area` VALUES ('1354', '149', '泌阳');
INSERT INTO `abon_area` VALUES ('1355', '149', '平舆');
INSERT INTO `abon_area` VALUES ('1356', '149', '确山');
INSERT INTO `abon_area` VALUES ('1357', '149', '汝南');
INSERT INTO `abon_area` VALUES ('1358', '149', '上蔡');
INSERT INTO `abon_area` VALUES ('1359', '149', '遂平');
INSERT INTO `abon_area` VALUES ('1360', '149', '西平');
INSERT INTO `abon_area` VALUES ('1361', '149', '新蔡');
INSERT INTO `abon_area` VALUES ('1362', '149', '驿城');
INSERT INTO `abon_area` VALUES ('1363', '149', '正阳');
INSERT INTO `abon_area` VALUES ('1364', '150', '济源');
INSERT INTO `abon_area` VALUES ('1365', '151', '阿城');
INSERT INTO `abon_area` VALUES ('1366', '151', '巴彦');
INSERT INTO `abon_area` VALUES ('1367', '151', '宾县');
INSERT INTO `abon_area` VALUES ('1368', '151', '道里');
INSERT INTO `abon_area` VALUES ('1369', '151', '道外');
INSERT INTO `abon_area` VALUES ('1370', '151', '方正');
INSERT INTO `abon_area` VALUES ('1371', '151', '呼兰');
INSERT INTO `abon_area` VALUES ('1372', '151', '木兰');
INSERT INTO `abon_area` VALUES ('1373', '151', '南岗');
INSERT INTO `abon_area` VALUES ('1374', '151', '平房');
INSERT INTO `abon_area` VALUES ('1375', '151', '尚志');
INSERT INTO `abon_area` VALUES ('1376', '151', '双城');
INSERT INTO `abon_area` VALUES ('1377', '151', '松北');
INSERT INTO `abon_area` VALUES ('1378', '151', '通河');
INSERT INTO `abon_area` VALUES ('1379', '151', '五常');
INSERT INTO `abon_area` VALUES ('1380', '151', '香坊');
INSERT INTO `abon_area` VALUES ('1381', '151', '延寿');
INSERT INTO `abon_area` VALUES ('1382', '151', '依兰');
INSERT INTO `abon_area` VALUES ('1383', '152', '昂昂溪');
INSERT INTO `abon_area` VALUES ('1384', '152', '拜泉');
INSERT INTO `abon_area` VALUES ('1385', '152', '富拉尔基');
INSERT INTO `abon_area` VALUES ('1386', '152', '富裕');
INSERT INTO `abon_area` VALUES ('1387', '152', '甘南');
INSERT INTO `abon_area` VALUES ('1388', '152', '建华');
INSERT INTO `abon_area` VALUES ('1389', '152', '克东');
INSERT INTO `abon_area` VALUES ('1390', '152', '克山');
INSERT INTO `abon_area` VALUES ('1391', '152', '龙江');
INSERT INTO `abon_area` VALUES ('1392', '152', '龙沙');
INSERT INTO `abon_area` VALUES ('1393', '152', '梅里斯');
INSERT INTO `abon_area` VALUES ('1394', '152', '讷河');
INSERT INTO `abon_area` VALUES ('1395', '152', '碾子山');
INSERT INTO `abon_area` VALUES ('1396', '152', '泰来');
INSERT INTO `abon_area` VALUES ('1397', '152', '铁锋');
INSERT INTO `abon_area` VALUES ('1398', '152', '依安');
INSERT INTO `abon_area` VALUES ('1399', '153', '城子河');
INSERT INTO `abon_area` VALUES ('1400', '153', '滴道');
INSERT INTO `abon_area` VALUES ('1401', '153', '恒山');
INSERT INTO `abon_area` VALUES ('1402', '153', '虎林');
INSERT INTO `abon_area` VALUES ('1403', '153', '鸡东');
INSERT INTO `abon_area` VALUES ('1404', '153', '鸡冠');
INSERT INTO `abon_area` VALUES ('1405', '153', '梨树');
INSERT INTO `abon_area` VALUES ('1406', '153', '麻山');
INSERT INTO `abon_area` VALUES ('1407', '153', '密山');
INSERT INTO `abon_area` VALUES ('1408', '154', '东山');
INSERT INTO `abon_area` VALUES ('1409', '154', '工农');
INSERT INTO `abon_area` VALUES ('1410', '154', '萝北');
INSERT INTO `abon_area` VALUES ('1411', '154', '南山');
INSERT INTO `abon_area` VALUES ('1412', '154', '绥滨');
INSERT INTO `abon_area` VALUES ('1413', '154', '向阳');
INSERT INTO `abon_area` VALUES ('1414', '154', '兴安');
INSERT INTO `abon_area` VALUES ('1415', '154', '兴山');
INSERT INTO `abon_area` VALUES ('1416', '155', '宝清');
INSERT INTO `abon_area` VALUES ('1417', '155', '宝山');
INSERT INTO `abon_area` VALUES ('1418', '155', '集贤');
INSERT INTO `abon_area` VALUES ('1419', '155', '尖山');
INSERT INTO `abon_area` VALUES ('1420', '155', '岭东');
INSERT INTO `abon_area` VALUES ('1421', '155', '饶河');
INSERT INTO `abon_area` VALUES ('1422', '155', '四方台');
INSERT INTO `abon_area` VALUES ('1423', '155', '友谊');
INSERT INTO `abon_area` VALUES ('1424', '156', '大同');
INSERT INTO `abon_area` VALUES ('1425', '156', '杜尔伯特');
INSERT INTO `abon_area` VALUES ('1426', '156', '红岗');
INSERT INTO `abon_area` VALUES ('1427', '156', '林甸');
INSERT INTO `abon_area` VALUES ('1428', '156', '龙凤');
INSERT INTO `abon_area` VALUES ('1429', '156', '让胡路');
INSERT INTO `abon_area` VALUES ('1430', '156', '萨尔图');
INSERT INTO `abon_area` VALUES ('1431', '156', '肇源');
INSERT INTO `abon_area` VALUES ('1432', '156', '肇州');
INSERT INTO `abon_area` VALUES ('1433', '157', '翠峦');
INSERT INTO `abon_area` VALUES ('1434', '157', '带岭');
INSERT INTO `abon_area` VALUES ('1435', '157', '红星');
INSERT INTO `abon_area` VALUES ('1436', '157', '嘉荫');
INSERT INTO `abon_area` VALUES ('1437', '157', '金山屯');
INSERT INTO `abon_area` VALUES ('1438', '157', '美溪');
INSERT INTO `abon_area` VALUES ('1439', '157', '南岔');
INSERT INTO `abon_area` VALUES ('1440', '157', '上甘岭');
INSERT INTO `abon_area` VALUES ('1441', '157', '汤旺河');
INSERT INTO `abon_area` VALUES ('1442', '157', '铁力');
INSERT INTO `abon_area` VALUES ('1443', '157', '乌马河');
INSERT INTO `abon_area` VALUES ('1444', '157', '乌伊岭');
INSERT INTO `abon_area` VALUES ('1445', '157', '五营');
INSERT INTO `abon_area` VALUES ('1446', '157', '西林');
INSERT INTO `abon_area` VALUES ('1447', '157', '新青');
INSERT INTO `abon_area` VALUES ('1448', '157', '伊春');
INSERT INTO `abon_area` VALUES ('1449', '157', '友好');
INSERT INTO `abon_area` VALUES ('1450', '158', '东风');
INSERT INTO `abon_area` VALUES ('1451', '158', '抚远');
INSERT INTO `abon_area` VALUES ('1452', '158', '富锦');
INSERT INTO `abon_area` VALUES ('1453', '158', '桦川');
INSERT INTO `abon_area` VALUES ('1454', '158', '桦南');
INSERT INTO `abon_area` VALUES ('1455', '158', '郊区');
INSERT INTO `abon_area` VALUES ('1456', '158', '前进');
INSERT INTO `abon_area` VALUES ('1457', '158', '汤原');
INSERT INTO `abon_area` VALUES ('1458', '158', '同江');
INSERT INTO `abon_area` VALUES ('1459', '158', '向阳');
INSERT INTO `abon_area` VALUES ('1460', '159', '勃利');
INSERT INTO `abon_area` VALUES ('1461', '159', '茄子河');
INSERT INTO `abon_area` VALUES ('1462', '159', '桃山');
INSERT INTO `abon_area` VALUES ('1463', '159', '新兴');
INSERT INTO `abon_area` VALUES ('1464', '160', '爱民');
INSERT INTO `abon_area` VALUES ('1465', '160', '东安');
INSERT INTO `abon_area` VALUES ('1466', '160', '东宁');
INSERT INTO `abon_area` VALUES ('1467', '160', '海林');
INSERT INTO `abon_area` VALUES ('1468', '160', '林口');
INSERT INTO `abon_area` VALUES ('1469', '160', '穆棱');
INSERT INTO `abon_area` VALUES ('1470', '160', '宁安');
INSERT INTO `abon_area` VALUES ('1471', '160', '绥芬河');
INSERT INTO `abon_area` VALUES ('1472', '160', '西安');
INSERT INTO `abon_area` VALUES ('1473', '160', '阳明');
INSERT INTO `abon_area` VALUES ('1474', '161', '爱辉');
INSERT INTO `abon_area` VALUES ('1475', '161', '北安');
INSERT INTO `abon_area` VALUES ('1476', '161', '嫩江');
INSERT INTO `abon_area` VALUES ('1477', '161', '孙吴');
INSERT INTO `abon_area` VALUES ('1478', '161', '五大连池');
INSERT INTO `abon_area` VALUES ('1479', '161', '逊克');
INSERT INTO `abon_area` VALUES ('1480', '162', '安达');
INSERT INTO `abon_area` VALUES ('1481', '162', '北林');
INSERT INTO `abon_area` VALUES ('1482', '162', '海伦');
INSERT INTO `abon_area` VALUES ('1483', '162', '兰西');
INSERT INTO `abon_area` VALUES ('1484', '162', '明水');
INSERT INTO `abon_area` VALUES ('1485', '162', '青冈');
INSERT INTO `abon_area` VALUES ('1486', '162', '庆安');
INSERT INTO `abon_area` VALUES ('1487', '162', '绥棱');
INSERT INTO `abon_area` VALUES ('1488', '162', '望奎');
INSERT INTO `abon_area` VALUES ('1489', '162', '肇东');
INSERT INTO `abon_area` VALUES ('1490', '163', '呼玛');
INSERT INTO `abon_area` VALUES ('1491', '163', '漠河');
INSERT INTO `abon_area` VALUES ('1492', '163', '塔河');
INSERT INTO `abon_area` VALUES ('1493', '164', '蔡甸');
INSERT INTO `abon_area` VALUES ('1494', '164', '东西湖');
INSERT INTO `abon_area` VALUES ('1495', '164', '汉南');
INSERT INTO `abon_area` VALUES ('1496', '164', '汉阳');
INSERT INTO `abon_area` VALUES ('1497', '164', '洪山');
INSERT INTO `abon_area` VALUES ('1498', '164', '黄陂');
INSERT INTO `abon_area` VALUES ('1499', '164', '江岸');
INSERT INTO `abon_area` VALUES ('1500', '164', '江汉');
INSERT INTO `abon_area` VALUES ('1501', '164', '江夏');
INSERT INTO `abon_area` VALUES ('1502', '164', '硚口');
INSERT INTO `abon_area` VALUES ('1503', '164', '青山');
INSERT INTO `abon_area` VALUES ('1504', '164', '武昌');
INSERT INTO `abon_area` VALUES ('1505', '164', '新洲');
INSERT INTO `abon_area` VALUES ('1506', '165', '大冶');
INSERT INTO `abon_area` VALUES ('1507', '165', '黄石港');
INSERT INTO `abon_area` VALUES ('1508', '165', '铁山');
INSERT INTO `abon_area` VALUES ('1509', '165', '西塞山');
INSERT INTO `abon_area` VALUES ('1510', '165', '下陆');
INSERT INTO `abon_area` VALUES ('1511', '165', '阳新');
INSERT INTO `abon_area` VALUES ('1512', '166', '保康');
INSERT INTO `abon_area` VALUES ('1513', '166', '樊城');
INSERT INTO `abon_area` VALUES ('1514', '166', '谷城');
INSERT INTO `abon_area` VALUES ('1515', '166', '老河口');
INSERT INTO `abon_area` VALUES ('1516', '166', '南漳');
INSERT INTO `abon_area` VALUES ('1517', '166', '襄城');
INSERT INTO `abon_area` VALUES ('1518', '166', '襄州');
INSERT INTO `abon_area` VALUES ('1519', '166', '宜城');
INSERT INTO `abon_area` VALUES ('1520', '166', '枣阳');
INSERT INTO `abon_area` VALUES ('1521', '167', '丹江口');
INSERT INTO `abon_area` VALUES ('1522', '167', '房县');
INSERT INTO `abon_area` VALUES ('1523', '167', '茅箭');
INSERT INTO `abon_area` VALUES ('1524', '167', '郧西');
INSERT INTO `abon_area` VALUES ('1525', '167', '郧县');
INSERT INTO `abon_area` VALUES ('1526', '167', '张湾');
INSERT INTO `abon_area` VALUES ('1527', '167', '竹山');
INSERT INTO `abon_area` VALUES ('1528', '167', '竹溪');
INSERT INTO `abon_area` VALUES ('1529', '168', '公安');
INSERT INTO `abon_area` VALUES ('1530', '168', '洪湖');
INSERT INTO `abon_area` VALUES ('1531', '168', '监利');
INSERT INTO `abon_area` VALUES ('1532', '168', '江陵');
INSERT INTO `abon_area` VALUES ('1533', '168', '荆州');
INSERT INTO `abon_area` VALUES ('1534', '168', '沙市');
INSERT INTO `abon_area` VALUES ('1535', '168', '石首');
INSERT INTO `abon_area` VALUES ('1536', '168', '松滋');
INSERT INTO `abon_area` VALUES ('1537', '169', '当阳');
INSERT INTO `abon_area` VALUES ('1538', '169', '点军');
INSERT INTO `abon_area` VALUES ('1539', '169', '五峰');
INSERT INTO `abon_area` VALUES ('1540', '169', '伍家岗');
INSERT INTO `abon_area` VALUES ('1541', '169', '西陵');
INSERT INTO `abon_area` VALUES ('1542', '169', '猇亭');
INSERT INTO `abon_area` VALUES ('1543', '169', '兴山');
INSERT INTO `abon_area` VALUES ('1544', '169', '夷陵');
INSERT INTO `abon_area` VALUES ('1545', '169', '宜都');
INSERT INTO `abon_area` VALUES ('1546', '169', '远安');
INSERT INTO `abon_area` VALUES ('1547', '169', '长阳');
INSERT INTO `abon_area` VALUES ('1548', '169', '枝江');
INSERT INTO `abon_area` VALUES ('1549', '169', '秭归');
INSERT INTO `abon_area` VALUES ('1550', '170', '东宝');
INSERT INTO `abon_area` VALUES ('1551', '170', '掇刀');
INSERT INTO `abon_area` VALUES ('1552', '170', '京山');
INSERT INTO `abon_area` VALUES ('1553', '170', '沙洋');
INSERT INTO `abon_area` VALUES ('1554', '170', '钟祥');
INSERT INTO `abon_area` VALUES ('1555', '171', '鄂城');
INSERT INTO `abon_area` VALUES ('1556', '171', '华容');
INSERT INTO `abon_area` VALUES ('1557', '171', '梁子湖');
INSERT INTO `abon_area` VALUES ('1558', '172', '安陆');
INSERT INTO `abon_area` VALUES ('1559', '172', '大悟');
INSERT INTO `abon_area` VALUES ('1560', '172', '汉川');
INSERT INTO `abon_area` VALUES ('1561', '172', '孝昌');
INSERT INTO `abon_area` VALUES ('1562', '172', '孝南');
INSERT INTO `abon_area` VALUES ('1563', '172', '应城');
INSERT INTO `abon_area` VALUES ('1564', '172', '云梦');
INSERT INTO `abon_area` VALUES ('1565', '173', '红安');
INSERT INTO `abon_area` VALUES ('1566', '173', '黄梅');
INSERT INTO `abon_area` VALUES ('1567', '173', '黄州');
INSERT INTO `abon_area` VALUES ('1568', '173', '罗田');
INSERT INTO `abon_area` VALUES ('1569', '173', '麻城');
INSERT INTO `abon_area` VALUES ('1570', '173', '蕲春');
INSERT INTO `abon_area` VALUES ('1571', '173', '团风');
INSERT INTO `abon_area` VALUES ('1572', '173', '武穴');
INSERT INTO `abon_area` VALUES ('1573', '173', '浠水');
INSERT INTO `abon_area` VALUES ('1574', '173', '英山');
INSERT INTO `abon_area` VALUES ('1575', '174', '赤壁');
INSERT INTO `abon_area` VALUES ('1576', '174', '崇阳');
INSERT INTO `abon_area` VALUES ('1577', '174', '嘉鱼');
INSERT INTO `abon_area` VALUES ('1578', '174', '通城');
INSERT INTO `abon_area` VALUES ('1579', '174', '通山');
INSERT INTO `abon_area` VALUES ('1580', '174', '咸安');
INSERT INTO `abon_area` VALUES ('1581', '175', '曾都');
INSERT INTO `abon_area` VALUES ('1582', '175', '广水');
INSERT INTO `abon_area` VALUES ('1583', '175', '随县');
INSERT INTO `abon_area` VALUES ('1584', '176', '巴东');
INSERT INTO `abon_area` VALUES ('1585', '176', '恩施');
INSERT INTO `abon_area` VALUES ('1586', '176', '鹤峰');
INSERT INTO `abon_area` VALUES ('1587', '176', '建始');
INSERT INTO `abon_area` VALUES ('1588', '176', '来凤');
INSERT INTO `abon_area` VALUES ('1589', '176', '利川');
INSERT INTO `abon_area` VALUES ('1590', '176', '咸丰');
INSERT INTO `abon_area` VALUES ('1591', '176', '宣恩');
INSERT INTO `abon_area` VALUES ('1592', '177', '潜江');
INSERT INTO `abon_area` VALUES ('1593', '177', '神农架');
INSERT INTO `abon_area` VALUES ('1594', '177', '天门');
INSERT INTO `abon_area` VALUES ('1595', '177', '仙桃');
INSERT INTO `abon_area` VALUES ('1596', '178', '芙蓉');
INSERT INTO `abon_area` VALUES ('1597', '178', '开福');
INSERT INTO `abon_area` VALUES ('1598', '178', '浏阳');
INSERT INTO `abon_area` VALUES ('1599', '178', '宁乡');
INSERT INTO `abon_area` VALUES ('1600', '178', '天心');
INSERT INTO `abon_area` VALUES ('1601', '178', '望城');
INSERT INTO `abon_area` VALUES ('1602', '178', '雨花');
INSERT INTO `abon_area` VALUES ('1603', '178', '岳麓');
INSERT INTO `abon_area` VALUES ('1604', '178', '长沙');
INSERT INTO `abon_area` VALUES ('1605', '179', '茶陵');
INSERT INTO `abon_area` VALUES ('1606', '179', '荷塘');
INSERT INTO `abon_area` VALUES ('1607', '179', '醴陵');
INSERT INTO `abon_area` VALUES ('1608', '179', '芦淞');
INSERT INTO `abon_area` VALUES ('1609', '179', '石峰');
INSERT INTO `abon_area` VALUES ('1610', '179', '天元');
INSERT INTO `abon_area` VALUES ('1611', '179', '炎陵');
INSERT INTO `abon_area` VALUES ('1612', '179', '攸县');
INSERT INTO `abon_area` VALUES ('1613', '179', '株洲');
INSERT INTO `abon_area` VALUES ('1614', '180', '韶山');
INSERT INTO `abon_area` VALUES ('1615', '180', '湘潭');
INSERT INTO `abon_area` VALUES ('1616', '180', '湘乡');
INSERT INTO `abon_area` VALUES ('1617', '180', '雨湖');
INSERT INTO `abon_area` VALUES ('1618', '180', '岳塘');
INSERT INTO `abon_area` VALUES ('1619', '181', '常宁');
INSERT INTO `abon_area` VALUES ('1620', '181', '衡东');
INSERT INTO `abon_area` VALUES ('1621', '181', '衡南');
INSERT INTO `abon_area` VALUES ('1622', '181', '衡山');
INSERT INTO `abon_area` VALUES ('1623', '181', '衡阳');
INSERT INTO `abon_area` VALUES ('1624', '181', '耒阳');
INSERT INTO `abon_area` VALUES ('1625', '181', '南岳');
INSERT INTO `abon_area` VALUES ('1626', '181', '祁东');
INSERT INTO `abon_area` VALUES ('1627', '181', '石鼓');
INSERT INTO `abon_area` VALUES ('1628', '181', '雁峰');
INSERT INTO `abon_area` VALUES ('1629', '181', '蒸湘');
INSERT INTO `abon_area` VALUES ('1630', '181', '珠晖');
INSERT INTO `abon_area` VALUES ('1631', '182', '北塔');
INSERT INTO `abon_area` VALUES ('1632', '182', '城步');
INSERT INTO `abon_area` VALUES ('1633', '182', '大祥');
INSERT INTO `abon_area` VALUES ('1634', '182', '洞口');
INSERT INTO `abon_area` VALUES ('1635', '182', '隆回');
INSERT INTO `abon_area` VALUES ('1636', '182', '邵东');
INSERT INTO `abon_area` VALUES ('1637', '182', '邵阳');
INSERT INTO `abon_area` VALUES ('1638', '182', '双清');
INSERT INTO `abon_area` VALUES ('1639', '182', '绥宁');
INSERT INTO `abon_area` VALUES ('1640', '182', '武冈');
INSERT INTO `abon_area` VALUES ('1641', '182', '新宁');
INSERT INTO `abon_area` VALUES ('1642', '182', '新邵');
INSERT INTO `abon_area` VALUES ('1643', '183', '华容');
INSERT INTO `abon_area` VALUES ('1644', '183', '君山');
INSERT INTO `abon_area` VALUES ('1645', '183', '临湘');
INSERT INTO `abon_area` VALUES ('1646', '183', '汨罗');
INSERT INTO `abon_area` VALUES ('1647', '183', '平江');
INSERT INTO `abon_area` VALUES ('1648', '183', '湘阴');
INSERT INTO `abon_area` VALUES ('1649', '183', '岳阳');
INSERT INTO `abon_area` VALUES ('1650', '183', '岳阳楼');
INSERT INTO `abon_area` VALUES ('1651', '183', '云溪');
INSERT INTO `abon_area` VALUES ('1652', '184', '安乡');
INSERT INTO `abon_area` VALUES ('1653', '184', '鼎城');
INSERT INTO `abon_area` VALUES ('1654', '184', '汉寿');
INSERT INTO `abon_area` VALUES ('1655', '184', '津市');
INSERT INTO `abon_area` VALUES ('1656', '184', '澧县');
INSERT INTO `abon_area` VALUES ('1657', '184', '临澧');
INSERT INTO `abon_area` VALUES ('1658', '184', '石门');
INSERT INTO `abon_area` VALUES ('1659', '184', '桃源');
INSERT INTO `abon_area` VALUES ('1660', '184', '武陵');
INSERT INTO `abon_area` VALUES ('1661', '185', '慈利');
INSERT INTO `abon_area` VALUES ('1662', '185', '桑植');
INSERT INTO `abon_area` VALUES ('1663', '185', '武陵源');
INSERT INTO `abon_area` VALUES ('1664', '185', '永定');
INSERT INTO `abon_area` VALUES ('1665', '186', '安化');
INSERT INTO `abon_area` VALUES ('1666', '186', '赫山');
INSERT INTO `abon_area` VALUES ('1667', '186', '南县');
INSERT INTO `abon_area` VALUES ('1668', '186', '桃江');
INSERT INTO `abon_area` VALUES ('1669', '186', '沅江');
INSERT INTO `abon_area` VALUES ('1670', '186', '资阳');
INSERT INTO `abon_area` VALUES ('1671', '187', '安仁');
INSERT INTO `abon_area` VALUES ('1672', '187', '北湖');
INSERT INTO `abon_area` VALUES ('1673', '187', '桂东');
INSERT INTO `abon_area` VALUES ('1674', '187', '桂阳');
INSERT INTO `abon_area` VALUES ('1675', '187', '嘉禾');
INSERT INTO `abon_area` VALUES ('1676', '187', '临武');
INSERT INTO `abon_area` VALUES ('1677', '187', '汝城');
INSERT INTO `abon_area` VALUES ('1678', '187', '苏仙');
INSERT INTO `abon_area` VALUES ('1679', '187', '宜章');
INSERT INTO `abon_area` VALUES ('1680', '187', '永兴');
INSERT INTO `abon_area` VALUES ('1681', '187', '资兴');
INSERT INTO `abon_area` VALUES ('1682', '188', '道县');
INSERT INTO `abon_area` VALUES ('1683', '188', '东安');
INSERT INTO `abon_area` VALUES ('1684', '188', '江华');
INSERT INTO `abon_area` VALUES ('1685', '188', '江永');
INSERT INTO `abon_area` VALUES ('1686', '188', '蓝山');
INSERT INTO `abon_area` VALUES ('1687', '188', '冷水滩');
INSERT INTO `abon_area` VALUES ('1688', '188', '零陵');
INSERT INTO `abon_area` VALUES ('1689', '188', '宁远');
INSERT INTO `abon_area` VALUES ('1690', '188', '祁阳');
INSERT INTO `abon_area` VALUES ('1691', '188', '双牌');
INSERT INTO `abon_area` VALUES ('1692', '188', '新田');
INSERT INTO `abon_area` VALUES ('1693', '189', '辰溪');
INSERT INTO `abon_area` VALUES ('1694', '189', '鹤城');
INSERT INTO `abon_area` VALUES ('1695', '189', '洪江');
INSERT INTO `abon_area` VALUES ('1696', '189', '会同');
INSERT INTO `abon_area` VALUES ('1697', '189', '靖州');
INSERT INTO `abon_area` VALUES ('1698', '189', '麻阳');
INSERT INTO `abon_area` VALUES ('1699', '189', '通道');
INSERT INTO `abon_area` VALUES ('1700', '189', '新晃');
INSERT INTO `abon_area` VALUES ('1701', '189', '溆浦');
INSERT INTO `abon_area` VALUES ('1702', '189', '沅陵');
INSERT INTO `abon_area` VALUES ('1703', '189', '芷江');
INSERT INTO `abon_area` VALUES ('1704', '189', '中方');
INSERT INTO `abon_area` VALUES ('1705', '190', '冷水江');
INSERT INTO `abon_area` VALUES ('1706', '190', '涟源');
INSERT INTO `abon_area` VALUES ('1707', '190', '娄星');
INSERT INTO `abon_area` VALUES ('1708', '190', '双峰');
INSERT INTO `abon_area` VALUES ('1709', '190', '新化');
INSERT INTO `abon_area` VALUES ('1710', '191', '保靖');
INSERT INTO `abon_area` VALUES ('1711', '191', '凤凰');
INSERT INTO `abon_area` VALUES ('1712', '191', '古丈');
INSERT INTO `abon_area` VALUES ('1713', '191', '花垣');
INSERT INTO `abon_area` VALUES ('1714', '191', '吉首');
INSERT INTO `abon_area` VALUES ('1715', '191', '龙山');
INSERT INTO `abon_area` VALUES ('1716', '191', '泸溪');
INSERT INTO `abon_area` VALUES ('1717', '191', '永顺');
INSERT INTO `abon_area` VALUES ('1718', '192', '朝阳');
INSERT INTO `abon_area` VALUES ('1719', '192', '德惠');
INSERT INTO `abon_area` VALUES ('1720', '192', '二道');
INSERT INTO `abon_area` VALUES ('1721', '192', '九台');
INSERT INTO `abon_area` VALUES ('1722', '192', '宽城');
INSERT INTO `abon_area` VALUES ('1723', '192', '绿园');
INSERT INTO `abon_area` VALUES ('1724', '192', '南关');
INSERT INTO `abon_area` VALUES ('1725', '192', '农安');
INSERT INTO `abon_area` VALUES ('1726', '192', '双阳');
INSERT INTO `abon_area` VALUES ('1727', '192', '榆树');
INSERT INTO `abon_area` VALUES ('1728', '193', '昌邑');
INSERT INTO `abon_area` VALUES ('1729', '193', '船营');
INSERT INTO `abon_area` VALUES ('1730', '193', '丰满');
INSERT INTO `abon_area` VALUES ('1731', '193', '桦甸');
INSERT INTO `abon_area` VALUES ('1732', '193', '蛟河');
INSERT INTO `abon_area` VALUES ('1733', '193', '龙潭');
INSERT INTO `abon_area` VALUES ('1734', '193', '磐石');
INSERT INTO `abon_area` VALUES ('1735', '193', '舒兰');
INSERT INTO `abon_area` VALUES ('1736', '193', '永吉');
INSERT INTO `abon_area` VALUES ('1737', '194', '公主岭');
INSERT INTO `abon_area` VALUES ('1738', '194', '梨树');
INSERT INTO `abon_area` VALUES ('1739', '194', '双辽');
INSERT INTO `abon_area` VALUES ('1740', '194', '铁东');
INSERT INTO `abon_area` VALUES ('1741', '194', '铁西');
INSERT INTO `abon_area` VALUES ('1742', '194', '伊通');
INSERT INTO `abon_area` VALUES ('1743', '195', '东丰');
INSERT INTO `abon_area` VALUES ('1744', '195', '东辽');
INSERT INTO `abon_area` VALUES ('1745', '195', '龙山');
INSERT INTO `abon_area` VALUES ('1746', '195', '西安');
INSERT INTO `abon_area` VALUES ('1747', '196', '东昌');
INSERT INTO `abon_area` VALUES ('1748', '196', '二道江');
INSERT INTO `abon_area` VALUES ('1749', '196', '辉南');
INSERT INTO `abon_area` VALUES ('1750', '196', '集安');
INSERT INTO `abon_area` VALUES ('1751', '196', '柳河');
INSERT INTO `abon_area` VALUES ('1752', '196', '梅河口');
INSERT INTO `abon_area` VALUES ('1753', '196', '通化');
INSERT INTO `abon_area` VALUES ('1754', '197', '抚松');
INSERT INTO `abon_area` VALUES ('1755', '197', '浑江');
INSERT INTO `abon_area` VALUES ('1756', '197', '江源');
INSERT INTO `abon_area` VALUES ('1757', '197', '靖宇');
INSERT INTO `abon_area` VALUES ('1758', '197', '临江');
INSERT INTO `abon_area` VALUES ('1759', '197', '长白');
INSERT INTO `abon_area` VALUES ('1760', '198', '扶余');
INSERT INTO `abon_area` VALUES ('1761', '198', '宁江');
INSERT INTO `abon_area` VALUES ('1762', '198', '前郭尔罗斯');
INSERT INTO `abon_area` VALUES ('1763', '198', '乾安');
INSERT INTO `abon_area` VALUES ('1764', '198', '长岭');
INSERT INTO `abon_area` VALUES ('1765', '199', '大安');
INSERT INTO `abon_area` VALUES ('1766', '199', '洮北');
INSERT INTO `abon_area` VALUES ('1767', '199', '洮南');
INSERT INTO `abon_area` VALUES ('1768', '199', '通榆');
INSERT INTO `abon_area` VALUES ('1769', '199', '镇赉');
INSERT INTO `abon_area` VALUES ('1770', '200', '安图');
INSERT INTO `abon_area` VALUES ('1771', '200', '敦化');
INSERT INTO `abon_area` VALUES ('1772', '200', '和龙');
INSERT INTO `abon_area` VALUES ('1773', '200', '珲春');
INSERT INTO `abon_area` VALUES ('1774', '200', '龙井');
INSERT INTO `abon_area` VALUES ('1775', '200', '图们');
INSERT INTO `abon_area` VALUES ('1776', '200', '汪清');
INSERT INTO `abon_area` VALUES ('1777', '200', '延吉');
INSERT INTO `abon_area` VALUES ('1778', '201', '高淳');
INSERT INTO `abon_area` VALUES ('1779', '201', '鼓楼');
INSERT INTO `abon_area` VALUES ('1780', '201', '建邺');
INSERT INTO `abon_area` VALUES ('1781', '201', '江宁');
INSERT INTO `abon_area` VALUES ('1782', '201', '溧水');
INSERT INTO `abon_area` VALUES ('1783', '201', '六合');
INSERT INTO `abon_area` VALUES ('1784', '201', '浦口');
INSERT INTO `abon_area` VALUES ('1785', '201', '栖霞');
INSERT INTO `abon_area` VALUES ('1786', '201', '秦淮');
INSERT INTO `abon_area` VALUES ('1787', '201', '玄武');
INSERT INTO `abon_area` VALUES ('1788', '201', '雨花台');
INSERT INTO `abon_area` VALUES ('1789', '202', '北塘');
INSERT INTO `abon_area` VALUES ('1790', '202', '滨湖');
INSERT INTO `abon_area` VALUES ('1791', '202', '崇安');
INSERT INTO `abon_area` VALUES ('1792', '202', '惠山');
INSERT INTO `abon_area` VALUES ('1793', '202', '江阴');
INSERT INTO `abon_area` VALUES ('1794', '202', '南长');
INSERT INTO `abon_area` VALUES ('1795', '202', '锡山');
INSERT INTO `abon_area` VALUES ('1796', '202', '宜兴');
INSERT INTO `abon_area` VALUES ('1797', '203', '丰县');
INSERT INTO `abon_area` VALUES ('1798', '203', '鼓楼');
INSERT INTO `abon_area` VALUES ('1799', '203', '贾汪');
INSERT INTO `abon_area` VALUES ('1800', '203', '沛县');
INSERT INTO `abon_area` VALUES ('1801', '203', '邳州');
INSERT INTO `abon_area` VALUES ('1802', '203', '泉山');
INSERT INTO `abon_area` VALUES ('1803', '203', '睢宁');
INSERT INTO `abon_area` VALUES ('1804', '203', '铜山');
INSERT INTO `abon_area` VALUES ('1805', '203', '新沂');
INSERT INTO `abon_area` VALUES ('1806', '203', '云龙');
INSERT INTO `abon_area` VALUES ('1807', '204', '金坛');
INSERT INTO `abon_area` VALUES ('1808', '204', '溧阳');
INSERT INTO `abon_area` VALUES ('1809', '204', '戚墅堰');
INSERT INTO `abon_area` VALUES ('1810', '204', '天宁');
INSERT INTO `abon_area` VALUES ('1811', '204', '武进');
INSERT INTO `abon_area` VALUES ('1812', '204', '新北');
INSERT INTO `abon_area` VALUES ('1813', '204', '钟楼');
INSERT INTO `abon_area` VALUES ('1814', '205', '常熟');
INSERT INTO `abon_area` VALUES ('1815', '205', '姑苏');
INSERT INTO `abon_area` VALUES ('1816', '205', '虎丘');
INSERT INTO `abon_area` VALUES ('1817', '205', '昆山');
INSERT INTO `abon_area` VALUES ('1818', '205', '太仓');
INSERT INTO `abon_area` VALUES ('1819', '205', '吴江');
INSERT INTO `abon_area` VALUES ('1820', '205', '吴中');
INSERT INTO `abon_area` VALUES ('1821', '205', '相城');
INSERT INTO `abon_area` VALUES ('1822', '205', '张家港');
INSERT INTO `abon_area` VALUES ('1823', '206', '崇川');
INSERT INTO `abon_area` VALUES ('1824', '206', '港闸');
INSERT INTO `abon_area` VALUES ('1825', '206', '海安');
INSERT INTO `abon_area` VALUES ('1826', '206', '海门');
INSERT INTO `abon_area` VALUES ('1827', '206', '启东');
INSERT INTO `abon_area` VALUES ('1828', '206', '如东');
INSERT INTO `abon_area` VALUES ('1829', '206', '如皋');
INSERT INTO `abon_area` VALUES ('1830', '206', '通州');
INSERT INTO `abon_area` VALUES ('1831', '207', '东海');
INSERT INTO `abon_area` VALUES ('1832', '207', '赣榆');
INSERT INTO `abon_area` VALUES ('1833', '207', '灌南');
INSERT INTO `abon_area` VALUES ('1834', '207', '灌云');
INSERT INTO `abon_area` VALUES ('1835', '207', '海州');
INSERT INTO `abon_area` VALUES ('1836', '207', '连云');
INSERT INTO `abon_area` VALUES ('1837', '207', '新浦');
INSERT INTO `abon_area` VALUES ('1838', '208', '洪泽');
INSERT INTO `abon_area` VALUES ('1839', '208', '淮阴');
INSERT INTO `abon_area` VALUES ('1840', '208', '金湖');
INSERT INTO `abon_area` VALUES ('1841', '208', '涟水');
INSERT INTO `abon_area` VALUES ('1842', '208', '清河');
INSERT INTO `abon_area` VALUES ('1843', '208', '清浦');
INSERT INTO `abon_area` VALUES ('1844', '208', '维安');
INSERT INTO `abon_area` VALUES ('1845', '208', '盱眙');
INSERT INTO `abon_area` VALUES ('1846', '209', '滨海');
INSERT INTO `abon_area` VALUES ('1847', '209', '大丰');
INSERT INTO `abon_area` VALUES ('1848', '209', '东台');
INSERT INTO `abon_area` VALUES ('1849', '209', '阜宁');
INSERT INTO `abon_area` VALUES ('1850', '209', '建湖');
INSERT INTO `abon_area` VALUES ('1851', '209', '射阳');
INSERT INTO `abon_area` VALUES ('1852', '209', '亭湖');
INSERT INTO `abon_area` VALUES ('1853', '209', '响水');
INSERT INTO `abon_area` VALUES ('1854', '209', '盐都');
INSERT INTO `abon_area` VALUES ('1855', '210', '宝应');
INSERT INTO `abon_area` VALUES ('1856', '210', '高邮');
INSERT INTO `abon_area` VALUES ('1857', '210', '广陵');
INSERT INTO `abon_area` VALUES ('1858', '210', '邗江');
INSERT INTO `abon_area` VALUES ('1859', '210', '江都');
INSERT INTO `abon_area` VALUES ('1860', '210', '仪征');
INSERT INTO `abon_area` VALUES ('1861', '211', '丹徒');
INSERT INTO `abon_area` VALUES ('1862', '211', '丹阳');
INSERT INTO `abon_area` VALUES ('1863', '211', '京口');
INSERT INTO `abon_area` VALUES ('1864', '211', '句容');
INSERT INTO `abon_area` VALUES ('1865', '211', '润州');
INSERT INTO `abon_area` VALUES ('1866', '211', '扬中');
INSERT INTO `abon_area` VALUES ('1867', '212', '高港');
INSERT INTO `abon_area` VALUES ('1868', '212', '海陵');
INSERT INTO `abon_area` VALUES ('1869', '212', '姜堰');
INSERT INTO `abon_area` VALUES ('1870', '212', '靖江');
INSERT INTO `abon_area` VALUES ('1871', '212', '泰兴');
INSERT INTO `abon_area` VALUES ('1872', '212', '兴化');
INSERT INTO `abon_area` VALUES ('1873', '213', '沭阳');
INSERT INTO `abon_area` VALUES ('1874', '213', '泗洪');
INSERT INTO `abon_area` VALUES ('1875', '213', '泗阳');
INSERT INTO `abon_area` VALUES ('1876', '213', '宿城');
INSERT INTO `abon_area` VALUES ('1877', '213', '宿豫');
INSERT INTO `abon_area` VALUES ('1878', '214', '安义');
INSERT INTO `abon_area` VALUES ('1879', '214', '东湖');
INSERT INTO `abon_area` VALUES ('1880', '214', '进贤');
INSERT INTO `abon_area` VALUES ('1881', '214', '南昌');
INSERT INTO `abon_area` VALUES ('1882', '214', '青山湖');
INSERT INTO `abon_area` VALUES ('1883', '214', '青云谱');
INSERT INTO `abon_area` VALUES ('1884', '214', '湾里');
INSERT INTO `abon_area` VALUES ('1885', '214', '西湖');
INSERT INTO `abon_area` VALUES ('1886', '214', '新建');
INSERT INTO `abon_area` VALUES ('1887', '215', '昌江');
INSERT INTO `abon_area` VALUES ('1888', '215', '浮梁');
INSERT INTO `abon_area` VALUES ('1889', '215', '乐平');
INSERT INTO `abon_area` VALUES ('1890', '215', '珠山');
INSERT INTO `abon_area` VALUES ('1891', '216', '安源');
INSERT INTO `abon_area` VALUES ('1892', '216', '莲花');
INSERT INTO `abon_area` VALUES ('1893', '216', '芦溪');
INSERT INTO `abon_area` VALUES ('1894', '216', '上栗');
INSERT INTO `abon_area` VALUES ('1895', '216', '湘东');
INSERT INTO `abon_area` VALUES ('1896', '217', '德安');
INSERT INTO `abon_area` VALUES ('1897', '217', '都昌');
INSERT INTO `abon_area` VALUES ('1898', '217', '共青城');
INSERT INTO `abon_area` VALUES ('1899', '217', '湖口');
INSERT INTO `abon_area` VALUES ('1900', '217', '九江');
INSERT INTO `abon_area` VALUES ('1901', '217', '庐山');
INSERT INTO `abon_area` VALUES ('1902', '217', '彭泽');
INSERT INTO `abon_area` VALUES ('1903', '217', '瑞昌');
INSERT INTO `abon_area` VALUES ('1904', '217', '武宁');
INSERT INTO `abon_area` VALUES ('1905', '217', '星子');
INSERT INTO `abon_area` VALUES ('1906', '217', '修水');
INSERT INTO `abon_area` VALUES ('1907', '217', '浔阳');
INSERT INTO `abon_area` VALUES ('1908', '217', '永修');
INSERT INTO `abon_area` VALUES ('1909', '218', '分宜');
INSERT INTO `abon_area` VALUES ('1910', '218', '渝水');
INSERT INTO `abon_area` VALUES ('1911', '219', '贵溪');
INSERT INTO `abon_area` VALUES ('1912', '219', '余江');
INSERT INTO `abon_area` VALUES ('1913', '219', '月湖');
INSERT INTO `abon_area` VALUES ('1914', '220', '安远');
INSERT INTO `abon_area` VALUES ('1915', '220', '崇义');
INSERT INTO `abon_area` VALUES ('1916', '220', '大余');
INSERT INTO `abon_area` VALUES ('1917', '220', '定南');
INSERT INTO `abon_area` VALUES ('1918', '220', '赣县');
INSERT INTO `abon_area` VALUES ('1919', '220', '会昌');
INSERT INTO `abon_area` VALUES ('1920', '220', '龙南');
INSERT INTO `abon_area` VALUES ('1921', '220', '南康');
INSERT INTO `abon_area` VALUES ('1922', '220', '宁都');
INSERT INTO `abon_area` VALUES ('1923', '220', '全南');
INSERT INTO `abon_area` VALUES ('1924', '220', '瑞金');
INSERT INTO `abon_area` VALUES ('1925', '220', '上犹');
INSERT INTO `abon_area` VALUES ('1926', '220', '石城');
INSERT INTO `abon_area` VALUES ('1927', '220', '信丰');
INSERT INTO `abon_area` VALUES ('1928', '220', '兴国');
INSERT INTO `abon_area` VALUES ('1929', '220', '寻乌');
INSERT INTO `abon_area` VALUES ('1930', '220', '于都');
INSERT INTO `abon_area` VALUES ('1931', '220', '章贡');
INSERT INTO `abon_area` VALUES ('1932', '221', '安福');
INSERT INTO `abon_area` VALUES ('1933', '221', '吉安');
INSERT INTO `abon_area` VALUES ('1934', '221', '吉水');
INSERT INTO `abon_area` VALUES ('1935', '221', '吉州');
INSERT INTO `abon_area` VALUES ('1936', '221', '井冈山');
INSERT INTO `abon_area` VALUES ('1937', '221', '青原');
INSERT INTO `abon_area` VALUES ('1938', '221', '遂川');
INSERT INTO `abon_area` VALUES ('1939', '221', '泰和');
INSERT INTO `abon_area` VALUES ('1940', '221', '万安');
INSERT INTO `abon_area` VALUES ('1941', '221', '峡江');
INSERT INTO `abon_area` VALUES ('1942', '221', '新干');
INSERT INTO `abon_area` VALUES ('1943', '221', '永丰');
INSERT INTO `abon_area` VALUES ('1944', '221', '永新');
INSERT INTO `abon_area` VALUES ('1945', '222', '丰城');
INSERT INTO `abon_area` VALUES ('1946', '222', '奉新');
INSERT INTO `abon_area` VALUES ('1947', '222', '高安');
INSERT INTO `abon_area` VALUES ('1948', '222', '靖安');
INSERT INTO `abon_area` VALUES ('1949', '222', '上高');
INSERT INTO `abon_area` VALUES ('1950', '222', '铜鼓');
INSERT INTO `abon_area` VALUES ('1951', '222', '万载');
INSERT INTO `abon_area` VALUES ('1952', '222', '宜丰');
INSERT INTO `abon_area` VALUES ('1953', '222', '袁州');
INSERT INTO `abon_area` VALUES ('1954', '222', '樟树');
INSERT INTO `abon_area` VALUES ('1955', '223', '崇仁');
INSERT INTO `abon_area` VALUES ('1956', '223', '东乡');
INSERT INTO `abon_area` VALUES ('1957', '223', '广昌');
INSERT INTO `abon_area` VALUES ('1958', '223', '金溪');
INSERT INTO `abon_area` VALUES ('1959', '223', '乐安');
INSERT INTO `abon_area` VALUES ('1960', '223', '黎川');
INSERT INTO `abon_area` VALUES ('1961', '223', '临川');
INSERT INTO `abon_area` VALUES ('1962', '223', '南城');
INSERT INTO `abon_area` VALUES ('1963', '223', '南丰');
INSERT INTO `abon_area` VALUES ('1964', '223', '宜黄');
INSERT INTO `abon_area` VALUES ('1965', '223', '资溪');
INSERT INTO `abon_area` VALUES ('1966', '224', '德兴');
INSERT INTO `abon_area` VALUES ('1967', '224', '广丰');
INSERT INTO `abon_area` VALUES ('1968', '224', '横峰');
INSERT INTO `abon_area` VALUES ('1969', '224', '鄱阳');
INSERT INTO `abon_area` VALUES ('1970', '224', '铅山');
INSERT INTO `abon_area` VALUES ('1971', '224', '上饶');
INSERT INTO `abon_area` VALUES ('1972', '224', '万年');
INSERT INTO `abon_area` VALUES ('1973', '224', '婺源');
INSERT INTO `abon_area` VALUES ('1974', '224', '信州');
INSERT INTO `abon_area` VALUES ('1975', '224', '弋阳');
INSERT INTO `abon_area` VALUES ('1976', '224', '余干');
INSERT INTO `abon_area` VALUES ('1977', '224', '玉山');
INSERT INTO `abon_area` VALUES ('1978', '225', '大东');
INSERT INTO `abon_area` VALUES ('1979', '225', '东陵');
INSERT INTO `abon_area` VALUES ('1980', '225', '法库');
INSERT INTO `abon_area` VALUES ('1981', '225', '和平');
INSERT INTO `abon_area` VALUES ('1982', '225', '皇姑');
INSERT INTO `abon_area` VALUES ('1983', '225', '康平');
INSERT INTO `abon_area` VALUES ('1984', '225', '辽中');
INSERT INTO `abon_area` VALUES ('1985', '225', '沈北');
INSERT INTO `abon_area` VALUES ('1986', '225', '沈河');
INSERT INTO `abon_area` VALUES ('1987', '225', '苏家屯');
INSERT INTO `abon_area` VALUES ('1988', '225', '铁西');
INSERT INTO `abon_area` VALUES ('1989', '225', '新民');
INSERT INTO `abon_area` VALUES ('1990', '225', '于洪');
INSERT INTO `abon_area` VALUES ('1991', '226', '甘井子');
INSERT INTO `abon_area` VALUES ('1992', '226', '金州');
INSERT INTO `abon_area` VALUES ('1993', '226', '旅顺口');
INSERT INTO `abon_area` VALUES ('1994', '226', '普兰店');
INSERT INTO `abon_area` VALUES ('1995', '226', '沙河口');
INSERT INTO `abon_area` VALUES ('1996', '226', '瓦房店');
INSERT INTO `abon_area` VALUES ('1997', '226', '西岗');
INSERT INTO `abon_area` VALUES ('1998', '226', '长海');
INSERT INTO `abon_area` VALUES ('1999', '226', '中山');
INSERT INTO `abon_area` VALUES ('2000', '226', '庄河');
INSERT INTO `abon_area` VALUES ('2001', '227', '海城');
INSERT INTO `abon_area` VALUES ('2002', '227', '立山');
INSERT INTO `abon_area` VALUES ('2003', '227', '千山');
INSERT INTO `abon_area` VALUES ('2004', '227', '台安');
INSERT INTO `abon_area` VALUES ('2005', '227', '铁东');
INSERT INTO `abon_area` VALUES ('2006', '227', '铁西');
INSERT INTO `abon_area` VALUES ('2007', '227', '岫岩');
INSERT INTO `abon_area` VALUES ('2008', '228', '东洲');
INSERT INTO `abon_area` VALUES ('2009', '228', '抚顺');
INSERT INTO `abon_area` VALUES ('2010', '228', '清原');
INSERT INTO `abon_area` VALUES ('2011', '228', '顺城');
INSERT INTO `abon_area` VALUES ('2012', '228', '望花');
INSERT INTO `abon_area` VALUES ('2013', '228', '新宾');
INSERT INTO `abon_area` VALUES ('2014', '228', '新抚');
INSERT INTO `abon_area` VALUES ('2015', '229', '本溪');
INSERT INTO `abon_area` VALUES ('2016', '229', '桓仁');
INSERT INTO `abon_area` VALUES ('2017', '229', '明山');
INSERT INTO `abon_area` VALUES ('2018', '229', '南芬');
INSERT INTO `abon_area` VALUES ('2019', '229', '平山');
INSERT INTO `abon_area` VALUES ('2020', '229', '溪湖');
INSERT INTO `abon_area` VALUES ('2021', '230', '东港');
INSERT INTO `abon_area` VALUES ('2022', '230', '凤城');
INSERT INTO `abon_area` VALUES ('2023', '230', '宽甸');
INSERT INTO `abon_area` VALUES ('2024', '230', '元宝');
INSERT INTO `abon_area` VALUES ('2025', '230', '振安');
INSERT INTO `abon_area` VALUES ('2026', '230', '振兴');
INSERT INTO `abon_area` VALUES ('2027', '231', '北镇');
INSERT INTO `abon_area` VALUES ('2028', '231', '古塔');
INSERT INTO `abon_area` VALUES ('2029', '231', '黑山');
INSERT INTO `abon_area` VALUES ('2030', '231', '凌海');
INSERT INTO `abon_area` VALUES ('2031', '231', '凌河');
INSERT INTO `abon_area` VALUES ('2032', '231', '太和');
INSERT INTO `abon_area` VALUES ('2033', '231', '义县');
INSERT INTO `abon_area` VALUES ('2034', '232', '鲅鱼圈');
INSERT INTO `abon_area` VALUES ('2035', '232', '大石桥');
INSERT INTO `abon_area` VALUES ('2036', '232', '盖州');
INSERT INTO `abon_area` VALUES ('2037', '232', '老边');
INSERT INTO `abon_area` VALUES ('2038', '232', '西市');
INSERT INTO `abon_area` VALUES ('2039', '232', '站前');
INSERT INTO `abon_area` VALUES ('2040', '233', '阜新');
INSERT INTO `abon_area` VALUES ('2041', '233', '海州');
INSERT INTO `abon_area` VALUES ('2042', '233', '清河门');
INSERT INTO `abon_area` VALUES ('2043', '233', '太平');
INSERT INTO `abon_area` VALUES ('2044', '233', '细河');
INSERT INTO `abon_area` VALUES ('2045', '233', '新邱');
INSERT INTO `abon_area` VALUES ('2046', '233', '彰武');
INSERT INTO `abon_area` VALUES ('2047', '234', '白塔');
INSERT INTO `abon_area` VALUES ('2048', '234', '灯塔');
INSERT INTO `abon_area` VALUES ('2049', '234', '弓长岭');
INSERT INTO `abon_area` VALUES ('2050', '234', '宏伟');
INSERT INTO `abon_area` VALUES ('2051', '234', '辽阳');
INSERT INTO `abon_area` VALUES ('2052', '234', '太子河');
INSERT INTO `abon_area` VALUES ('2053', '234', '文圣');
INSERT INTO `abon_area` VALUES ('2054', '235', '大洼');
INSERT INTO `abon_area` VALUES ('2055', '235', '盘山');
INSERT INTO `abon_area` VALUES ('2056', '235', '双台子');
INSERT INTO `abon_area` VALUES ('2057', '235', '兴隆台');
INSERT INTO `abon_area` VALUES ('2058', '236', '昌图');
INSERT INTO `abon_area` VALUES ('2059', '236', '开原');
INSERT INTO `abon_area` VALUES ('2060', '236', '清河');
INSERT INTO `abon_area` VALUES ('2061', '236', '调兵山');
INSERT INTO `abon_area` VALUES ('2062', '236', '铁岭');
INSERT INTO `abon_area` VALUES ('2063', '236', '西丰');
INSERT INTO `abon_area` VALUES ('2064', '236', '银州');
INSERT INTO `abon_area` VALUES ('2065', '237', '北票');
INSERT INTO `abon_area` VALUES ('2066', '237', '朝阳');
INSERT INTO `abon_area` VALUES ('2067', '237', '建平');
INSERT INTO `abon_area` VALUES ('2068', '237', '喀喇沁');
INSERT INTO `abon_area` VALUES ('2069', '237', '凌源');
INSERT INTO `abon_area` VALUES ('2070', '237', '龙城');
INSERT INTO `abon_area` VALUES ('2071', '237', '双塔');
INSERT INTO `abon_area` VALUES ('2072', '238', '建昌');
INSERT INTO `abon_area` VALUES ('2073', '238', '连山');
INSERT INTO `abon_area` VALUES ('2074', '238', '龙港');
INSERT INTO `abon_area` VALUES ('2075', '238', '南票');
INSERT INTO `abon_area` VALUES ('2076', '238', '绥中');
INSERT INTO `abon_area` VALUES ('2077', '238', '兴城');
INSERT INTO `abon_area` VALUES ('2078', '239', '和林格尔');
INSERT INTO `abon_area` VALUES ('2079', '239', '回民');
INSERT INTO `abon_area` VALUES ('2080', '239', '清水河');
INSERT INTO `abon_area` VALUES ('2081', '239', '赛罕');
INSERT INTO `abon_area` VALUES ('2082', '239', '土默特左');
INSERT INTO `abon_area` VALUES ('2083', '239', '托克托');
INSERT INTO `abon_area` VALUES ('2084', '239', '武川');
INSERT INTO `abon_area` VALUES ('2085', '239', '新城');
INSERT INTO `abon_area` VALUES ('2086', '239', '玉泉');
INSERT INTO `abon_area` VALUES ('2087', '240', '达尔罕茂明安');
INSERT INTO `abon_area` VALUES ('2088', '240', '东河');
INSERT INTO `abon_area` VALUES ('2089', '240', '固阳');
INSERT INTO `abon_area` VALUES ('2090', '240', '九原');
INSERT INTO `abon_area` VALUES ('2091', '240', '矿区');
INSERT INTO `abon_area` VALUES ('2092', '240', '昆都仑');
INSERT INTO `abon_area` VALUES ('2093', '240', '青山');
INSERT INTO `abon_area` VALUES ('2094', '240', '石拐');
INSERT INTO `abon_area` VALUES ('2095', '240', '土默特右');
INSERT INTO `abon_area` VALUES ('2096', '241', '海勃湾');
INSERT INTO `abon_area` VALUES ('2097', '241', '海南');
INSERT INTO `abon_area` VALUES ('2098', '241', '乌达');
INSERT INTO `abon_area` VALUES ('2099', '242', '阿鲁科尔沁');
INSERT INTO `abon_area` VALUES ('2100', '242', '敖汉');
INSERT INTO `abon_area` VALUES ('2101', '242', '巴林右');
INSERT INTO `abon_area` VALUES ('2102', '242', '巴林左');
INSERT INTO `abon_area` VALUES ('2103', '242', '红山');
INSERT INTO `abon_area` VALUES ('2104', '242', '喀喇沁');
INSERT INTO `abon_area` VALUES ('2105', '242', '克什克腾');
INSERT INTO `abon_area` VALUES ('2106', '242', '林西');
INSERT INTO `abon_area` VALUES ('2107', '242', '宁城');
INSERT INTO `abon_area` VALUES ('2108', '242', '松山');
INSERT INTO `abon_area` VALUES ('2109', '242', '翁牛特');
INSERT INTO `abon_area` VALUES ('2110', '242', '元宝山');
INSERT INTO `abon_area` VALUES ('2111', '243', '霍林郭勒');
INSERT INTO `abon_area` VALUES ('2112', '243', '开鲁');
INSERT INTO `abon_area` VALUES ('2113', '243', '科尔沁');
INSERT INTO `abon_area` VALUES ('2114', '243', '科尔沁左翼后');
INSERT INTO `abon_area` VALUES ('2115', '243', '科尔沁左翼中');
INSERT INTO `abon_area` VALUES ('2116', '243', '库伦');
INSERT INTO `abon_area` VALUES ('2117', '243', '奈曼');
INSERT INTO `abon_area` VALUES ('2118', '243', '扎鲁特');
INSERT INTO `abon_area` VALUES ('2119', '244', '达拉特');
INSERT INTO `abon_area` VALUES ('2120', '244', '东胜');
INSERT INTO `abon_area` VALUES ('2121', '244', '鄂托克');
INSERT INTO `abon_area` VALUES ('2122', '244', '鄂托克前');
INSERT INTO `abon_area` VALUES ('2123', '244', '杭锦');
INSERT INTO `abon_area` VALUES ('2124', '244', '乌审');
INSERT INTO `abon_area` VALUES ('2125', '244', '伊金霍洛');
INSERT INTO `abon_area` VALUES ('2126', '244', '准格尔');
INSERT INTO `abon_area` VALUES ('2127', '245', '阿荣');
INSERT INTO `abon_area` VALUES ('2128', '245', '陈巴尔虎');
INSERT INTO `abon_area` VALUES ('2129', '245', '额尔古纳');
INSERT INTO `abon_area` VALUES ('2130', '245', '鄂伦春');
INSERT INTO `abon_area` VALUES ('2131', '245', '鄂温克');
INSERT INTO `abon_area` VALUES ('2132', '245', '根河');
INSERT INTO `abon_area` VALUES ('2133', '245', '海拉尔');
INSERT INTO `abon_area` VALUES ('2134', '245', '满洲里');
INSERT INTO `abon_area` VALUES ('2135', '245', '莫力达瓦');
INSERT INTO `abon_area` VALUES ('2136', '245', '新巴尔虎右');
INSERT INTO `abon_area` VALUES ('2137', '245', '新巴尔虎左');
INSERT INTO `abon_area` VALUES ('2138', '245', '牙克石');
INSERT INTO `abon_area` VALUES ('2139', '245', '扎赉诺尔');
INSERT INTO `abon_area` VALUES ('2140', '245', '扎兰屯');
INSERT INTO `abon_area` VALUES ('2141', '246', '磴口');
INSERT INTO `abon_area` VALUES ('2142', '246', '杭锦后');
INSERT INTO `abon_area` VALUES ('2143', '246', '临河');
INSERT INTO `abon_area` VALUES ('2144', '246', '乌拉特后');
INSERT INTO `abon_area` VALUES ('2145', '246', '乌拉特前');
INSERT INTO `abon_area` VALUES ('2146', '246', '乌拉特中');
INSERT INTO `abon_area` VALUES ('2147', '246', '五原');
INSERT INTO `abon_area` VALUES ('2148', '247', '察哈尔右翼后');
INSERT INTO `abon_area` VALUES ('2149', '247', '察哈尔右翼前');
INSERT INTO `abon_area` VALUES ('2150', '247', '察哈尔右翼中');
INSERT INTO `abon_area` VALUES ('2151', '247', '丰镇');
INSERT INTO `abon_area` VALUES ('2152', '247', '化德');
INSERT INTO `abon_area` VALUES ('2153', '247', '集宁');
INSERT INTO `abon_area` VALUES ('2154', '247', '凉城');
INSERT INTO `abon_area` VALUES ('2155', '247', '商都');
INSERT INTO `abon_area` VALUES ('2156', '247', '四子王');
INSERT INTO `abon_area` VALUES ('2157', '247', '兴和');
INSERT INTO `abon_area` VALUES ('2158', '247', '卓资');
INSERT INTO `abon_area` VALUES ('2159', '248', '阿尔山');
INSERT INTO `abon_area` VALUES ('2160', '248', '科尔沁右翼前');
INSERT INTO `abon_area` VALUES ('2161', '248', '科尔沁右翼中');
INSERT INTO `abon_area` VALUES ('2162', '248', '突泉');
INSERT INTO `abon_area` VALUES ('2163', '248', '乌兰浩特');
INSERT INTO `abon_area` VALUES ('2164', '248', '扎赉特');
INSERT INTO `abon_area` VALUES ('2165', '249', '阿巴嘎');
INSERT INTO `abon_area` VALUES ('2166', '249', '东乌珠穆沁');
INSERT INTO `abon_area` VALUES ('2167', '249', '多伦');
INSERT INTO `abon_area` VALUES ('2168', '249', '二连浩特');
INSERT INTO `abon_area` VALUES ('2169', '249', '苏尼特右');
INSERT INTO `abon_area` VALUES ('2170', '249', '苏尼特左');
INSERT INTO `abon_area` VALUES ('2171', '249', '太仆寺');
INSERT INTO `abon_area` VALUES ('2172', '249', '西乌珠穆沁');
INSERT INTO `abon_area` VALUES ('2173', '249', '锡林浩特');
INSERT INTO `abon_area` VALUES ('2174', '249', '镶黄');
INSERT INTO `abon_area` VALUES ('2175', '249', '正蓝');
INSERT INTO `abon_area` VALUES ('2176', '249', '正镶白');
INSERT INTO `abon_area` VALUES ('2177', '250', '阿拉善右');
INSERT INTO `abon_area` VALUES ('2178', '250', '阿拉善左');
INSERT INTO `abon_area` VALUES ('2179', '250', '额济纳');
INSERT INTO `abon_area` VALUES ('2180', '251', '泾源');
INSERT INTO `abon_area` VALUES ('2181', '251', '隆德');
INSERT INTO `abon_area` VALUES ('2182', '251', '彭阳');
INSERT INTO `abon_area` VALUES ('2183', '251', '西吉');
INSERT INTO `abon_area` VALUES ('2184', '251', '原州');
INSERT INTO `abon_area` VALUES ('2185', '252', '大武口');
INSERT INTO `abon_area` VALUES ('2186', '252', '惠农');
INSERT INTO `abon_area` VALUES ('2187', '252', '平罗');
INSERT INTO `abon_area` VALUES ('2188', '253', '红寺堡');
INSERT INTO `abon_area` VALUES ('2189', '253', '利通');
INSERT INTO `abon_area` VALUES ('2190', '253', '青铜峡');
INSERT INTO `abon_area` VALUES ('2191', '253', '同心');
INSERT INTO `abon_area` VALUES ('2192', '253', '盐池');
INSERT INTO `abon_area` VALUES ('2193', '254', '贺兰');
INSERT INTO `abon_area` VALUES ('2194', '254', '金凤');
INSERT INTO `abon_area` VALUES ('2195', '254', '灵武');
INSERT INTO `abon_area` VALUES ('2196', '254', '西夏');
INSERT INTO `abon_area` VALUES ('2197', '254', '兴庆');
INSERT INTO `abon_area` VALUES ('2198', '254', '永宁');
INSERT INTO `abon_area` VALUES ('2199', '255', '海原');
INSERT INTO `abon_area` VALUES ('2200', '255', '沙坡头');
INSERT INTO `abon_area` VALUES ('2201', '255', '中宁');
INSERT INTO `abon_area` VALUES ('2202', '256', '城北');
INSERT INTO `abon_area` VALUES ('2203', '256', '城东');
INSERT INTO `abon_area` VALUES ('2204', '256', '城西');
INSERT INTO `abon_area` VALUES ('2205', '256', '城中');
INSERT INTO `abon_area` VALUES ('2206', '256', '大通');
INSERT INTO `abon_area` VALUES ('2207', '256', '湟源');
INSERT INTO `abon_area` VALUES ('2208', '256', '湟中');
INSERT INTO `abon_area` VALUES ('2209', '257', '互助');
INSERT INTO `abon_area` VALUES ('2210', '257', '化隆');
INSERT INTO `abon_area` VALUES ('2211', '257', '乐都');
INSERT INTO `abon_area` VALUES ('2212', '257', '民和');
INSERT INTO `abon_area` VALUES ('2213', '257', '平安');
INSERT INTO `abon_area` VALUES ('2214', '257', '循化');
INSERT INTO `abon_area` VALUES ('2215', '258', '刚察');
INSERT INTO `abon_area` VALUES ('2216', '258', '海晏');
INSERT INTO `abon_area` VALUES ('2217', '258', '门源');
INSERT INTO `abon_area` VALUES ('2218', '258', '祁连');
INSERT INTO `abon_area` VALUES ('2219', '259', '河南');
INSERT INTO `abon_area` VALUES ('2220', '259', '尖扎');
INSERT INTO `abon_area` VALUES ('2221', '259', '同仁');
INSERT INTO `abon_area` VALUES ('2222', '259', '泽库');
INSERT INTO `abon_area` VALUES ('2223', '260', '共和');
INSERT INTO `abon_area` VALUES ('2224', '260', '贵德');
INSERT INTO `abon_area` VALUES ('2225', '260', '贵南');
INSERT INTO `abon_area` VALUES ('2226', '260', '同德');
INSERT INTO `abon_area` VALUES ('2227', '260', '兴海');
INSERT INTO `abon_area` VALUES ('2228', '261', '班玛');
INSERT INTO `abon_area` VALUES ('2229', '261', '达日');
INSERT INTO `abon_area` VALUES ('2230', '261', '甘德');
INSERT INTO `abon_area` VALUES ('2231', '261', '久治');
INSERT INTO `abon_area` VALUES ('2232', '261', '玛多');
INSERT INTO `abon_area` VALUES ('2233', '261', '玛沁');
INSERT INTO `abon_area` VALUES ('2234', '262', '称多');
INSERT INTO `abon_area` VALUES ('2235', '262', '囊谦');
INSERT INTO `abon_area` VALUES ('2236', '262', '曲麻莱');
INSERT INTO `abon_area` VALUES ('2237', '262', '玉树');
INSERT INTO `abon_area` VALUES ('2238', '262', '杂多');
INSERT INTO `abon_area` VALUES ('2239', '262', '治多');
INSERT INTO `abon_area` VALUES ('2240', '263', '德令哈');
INSERT INTO `abon_area` VALUES ('2241', '263', '都兰');
INSERT INTO `abon_area` VALUES ('2242', '263', '格尔木');
INSERT INTO `abon_area` VALUES ('2243', '263', '天峻');
INSERT INTO `abon_area` VALUES ('2244', '263', '乌兰');
INSERT INTO `abon_area` VALUES ('2245', '264', '槐荫');
INSERT INTO `abon_area` VALUES ('2246', '264', '济阳');
INSERT INTO `abon_area` VALUES ('2247', '264', '历城');
INSERT INTO `abon_area` VALUES ('2248', '264', '历下');
INSERT INTO `abon_area` VALUES ('2249', '264', '平阴');
INSERT INTO `abon_area` VALUES ('2250', '264', '商河');
INSERT INTO `abon_area` VALUES ('2251', '264', '市中');
INSERT INTO `abon_area` VALUES ('2252', '264', '天桥');
INSERT INTO `abon_area` VALUES ('2253', '264', '章丘');
INSERT INTO `abon_area` VALUES ('2254', '264', '长清');
INSERT INTO `abon_area` VALUES ('2255', '265', '城阳');
INSERT INTO `abon_area` VALUES ('2256', '265', '黄岛');
INSERT INTO `abon_area` VALUES ('2257', '265', '即墨');
INSERT INTO `abon_area` VALUES ('2258', '265', '胶州');
INSERT INTO `abon_area` VALUES ('2259', '265', '莱西');
INSERT INTO `abon_area` VALUES ('2260', '265', '崂山');
INSERT INTO `abon_area` VALUES ('2261', '265', '李沧');
INSERT INTO `abon_area` VALUES ('2262', '265', '平度');
INSERT INTO `abon_area` VALUES ('2263', '265', '市北');
INSERT INTO `abon_area` VALUES ('2264', '265', '市南');
INSERT INTO `abon_area` VALUES ('2265', '266', '桓台');
INSERT INTO `abon_area` VALUES ('2266', '266', '临淄');
INSERT INTO `abon_area` VALUES ('2267', '266', '沂源');
INSERT INTO `abon_area` VALUES ('2268', '266', '张店');
INSERT INTO `abon_area` VALUES ('2269', '266', '周村');
INSERT INTO `abon_area` VALUES ('2270', '266', '淄川');
INSERT INTO `abon_area` VALUES ('2271', '267', '山亭');
INSERT INTO `abon_area` VALUES ('2272', '267', '市中');
INSERT INTO `abon_area` VALUES ('2273', '267', '台儿庄');
INSERT INTO `abon_area` VALUES ('2274', '267', '滕州');
INSERT INTO `abon_area` VALUES ('2275', '267', '薛城');
INSERT INTO `abon_area` VALUES ('2276', '267', '峄城');
INSERT INTO `abon_area` VALUES ('2277', '268', '东营');
INSERT INTO `abon_area` VALUES ('2278', '268', '广饶');
INSERT INTO `abon_area` VALUES ('2279', '268', '河口');
INSERT INTO `abon_area` VALUES ('2280', '268', '垦利');
INSERT INTO `abon_area` VALUES ('2281', '268', '利津');
INSERT INTO `abon_area` VALUES ('2282', '269', '福山');
INSERT INTO `abon_area` VALUES ('2283', '269', '海阳');
INSERT INTO `abon_area` VALUES ('2284', '269', '莱山');
INSERT INTO `abon_area` VALUES ('2285', '269', '莱阳');
INSERT INTO `abon_area` VALUES ('2286', '269', '莱州');
INSERT INTO `abon_area` VALUES ('2287', '269', '龙口');
INSERT INTO `abon_area` VALUES ('2288', '269', '牟平');
INSERT INTO `abon_area` VALUES ('2289', '269', '蓬莱');
INSERT INTO `abon_area` VALUES ('2290', '269', '栖霞');
INSERT INTO `abon_area` VALUES ('2291', '269', '长岛');
INSERT INTO `abon_area` VALUES ('2292', '269', '招远');
INSERT INTO `abon_area` VALUES ('2293', '269', '芝罘');
INSERT INTO `abon_area` VALUES ('2294', '270', '安丘');
INSERT INTO `abon_area` VALUES ('2295', '270', '昌乐');
INSERT INTO `abon_area` VALUES ('2296', '270', '昌邑');
INSERT INTO `abon_area` VALUES ('2297', '270', '坊子');
INSERT INTO `abon_area` VALUES ('2298', '270', '高密');
INSERT INTO `abon_area` VALUES ('2299', '270', '寒亭');
INSERT INTO `abon_area` VALUES ('2300', '270', '奎文');
INSERT INTO `abon_area` VALUES ('2301', '270', '临朐');
INSERT INTO `abon_area` VALUES ('2302', '270', '青州');
INSERT INTO `abon_area` VALUES ('2303', '270', '寿光');
INSERT INTO `abon_area` VALUES ('2304', '270', '潍城');
INSERT INTO `abon_area` VALUES ('2305', '270', '诸城');
INSERT INTO `abon_area` VALUES ('2306', '271', '环翠');
INSERT INTO `abon_area` VALUES ('2307', '271', '荣成');
INSERT INTO `abon_area` VALUES ('2308', '271', '乳山');
INSERT INTO `abon_area` VALUES ('2309', '271', '文登');
INSERT INTO `abon_area` VALUES ('2310', '272', '嘉祥');
INSERT INTO `abon_area` VALUES ('2311', '272', '金乡');
INSERT INTO `abon_area` VALUES ('2312', '272', '梁山');
INSERT INTO `abon_area` VALUES ('2313', '272', '曲阜');
INSERT INTO `abon_area` VALUES ('2314', '272', '任城');
INSERT INTO `abon_area` VALUES ('2315', '272', '泗水');
INSERT INTO `abon_area` VALUES ('2316', '272', '微山');
INSERT INTO `abon_area` VALUES ('2317', '272', '汶上');
INSERT INTO `abon_area` VALUES ('2318', '272', '兖州');
INSERT INTO `abon_area` VALUES ('2319', '272', '鱼台');
INSERT INTO `abon_area` VALUES ('2320', '272', '邹城');
INSERT INTO `abon_area` VALUES ('2321', '273', '岱岳');
INSERT INTO `abon_area` VALUES ('2322', '273', '东平');
INSERT INTO `abon_area` VALUES ('2323', '273', '肥城');
INSERT INTO `abon_area` VALUES ('2324', '273', '宁阳');
INSERT INTO `abon_area` VALUES ('2325', '273', '泰山');
INSERT INTO `abon_area` VALUES ('2326', '273', '新泰');
INSERT INTO `abon_area` VALUES ('2327', '274', '东港');
INSERT INTO `abon_area` VALUES ('2328', '274', '莒县');
INSERT INTO `abon_area` VALUES ('2329', '274', '岚山');
INSERT INTO `abon_area` VALUES ('2330', '274', '五莲');
INSERT INTO `abon_area` VALUES ('2331', '275', '钢城');
INSERT INTO `abon_area` VALUES ('2332', '275', '莱城');
INSERT INTO `abon_area` VALUES ('2333', '276', '苍山');
INSERT INTO `abon_area` VALUES ('2334', '276', '费县');
INSERT INTO `abon_area` VALUES ('2335', '276', '河东');
INSERT INTO `abon_area` VALUES ('2336', '276', '莒南');
INSERT INTO `abon_area` VALUES ('2337', '276', '兰山');
INSERT INTO `abon_area` VALUES ('2338', '276', '临沭');
INSERT INTO `abon_area` VALUES ('2339', '276', '罗庄');
INSERT INTO `abon_area` VALUES ('2340', '276', '蒙阴');
INSERT INTO `abon_area` VALUES ('2341', '276', '平邑');
INSERT INTO `abon_area` VALUES ('2342', '276', '郯城');
INSERT INTO `abon_area` VALUES ('2343', '276', '沂南');
INSERT INTO `abon_area` VALUES ('2344', '276', '沂水');
INSERT INTO `abon_area` VALUES ('2345', '277', '德城');
INSERT INTO `abon_area` VALUES ('2346', '277', '乐陵');
INSERT INTO `abon_area` VALUES ('2347', '277', '临邑');
INSERT INTO `abon_area` VALUES ('2348', '277', '陵县');
INSERT INTO `abon_area` VALUES ('2349', '277', '宁津');
INSERT INTO `abon_area` VALUES ('2350', '277', '平原');
INSERT INTO `abon_area` VALUES ('2351', '277', '齐河');
INSERT INTO `abon_area` VALUES ('2352', '277', '庆云');
INSERT INTO `abon_area` VALUES ('2353', '277', '武城');
INSERT INTO `abon_area` VALUES ('2354', '277', '夏津');
INSERT INTO `abon_area` VALUES ('2355', '277', '禹城');
INSERT INTO `abon_area` VALUES ('2356', '278', '茌平');
INSERT INTO `abon_area` VALUES ('2357', '278', '东阿');
INSERT INTO `abon_area` VALUES ('2358', '278', '东昌府');
INSERT INTO `abon_area` VALUES ('2359', '278', '高唐');
INSERT INTO `abon_area` VALUES ('2360', '278', '冠县');
INSERT INTO `abon_area` VALUES ('2361', '278', '临清');
INSERT INTO `abon_area` VALUES ('2362', '278', '莘县');
INSERT INTO `abon_area` VALUES ('2363', '278', '阳谷');
INSERT INTO `abon_area` VALUES ('2364', '279', '滨城');
INSERT INTO `abon_area` VALUES ('2365', '279', '博兴');
INSERT INTO `abon_area` VALUES ('2366', '279', '惠民');
INSERT INTO `abon_area` VALUES ('2367', '279', '无棣');
INSERT INTO `abon_area` VALUES ('2368', '279', '阳信');
INSERT INTO `abon_area` VALUES ('2369', '279', '沾化');
INSERT INTO `abon_area` VALUES ('2370', '279', '邹平');
INSERT INTO `abon_area` VALUES ('2371', '280', '曹县');
INSERT INTO `abon_area` VALUES ('2372', '280', '成武');
INSERT INTO `abon_area` VALUES ('2373', '280', '定陶');
INSERT INTO `abon_area` VALUES ('2374', '280', '东明');
INSERT INTO `abon_area` VALUES ('2375', '280', '巨野');
INSERT INTO `abon_area` VALUES ('2376', '280', '鄄城');
INSERT INTO `abon_area` VALUES ('2377', '280', '牡丹');
INSERT INTO `abon_area` VALUES ('2378', '280', '单县');
INSERT INTO `abon_area` VALUES ('2379', '280', '郓城');
INSERT INTO `abon_area` VALUES ('2380', '281', '城区');
INSERT INTO `abon_area` VALUES ('2381', '281', '大同');
INSERT INTO `abon_area` VALUES ('2382', '281', '广灵');
INSERT INTO `abon_area` VALUES ('2383', '281', '浑源');
INSERT INTO `abon_area` VALUES ('2384', '281', '矿区');
INSERT INTO `abon_area` VALUES ('2385', '281', '灵丘');
INSERT INTO `abon_area` VALUES ('2386', '281', '南郊');
INSERT INTO `abon_area` VALUES ('2387', '281', '天镇');
INSERT INTO `abon_area` VALUES ('2388', '281', '新荣');
INSERT INTO `abon_area` VALUES ('2389', '281', '阳高');
INSERT INTO `abon_area` VALUES ('2390', '281', '左云');
INSERT INTO `abon_area` VALUES ('2391', '282', '城区');
INSERT INTO `abon_area` VALUES ('2392', '282', '高平');
INSERT INTO `abon_area` VALUES ('2393', '282', '陵川');
INSERT INTO `abon_area` VALUES ('2394', '282', '沁水');
INSERT INTO `abon_area` VALUES ('2395', '282', '阳城');
INSERT INTO `abon_area` VALUES ('2396', '282', '泽州');
INSERT INTO `abon_area` VALUES ('2397', '283', '和顺');
INSERT INTO `abon_area` VALUES ('2398', '283', '介休');
INSERT INTO `abon_area` VALUES ('2399', '283', '灵石');
INSERT INTO `abon_area` VALUES ('2400', '283', '平遥');
INSERT INTO `abon_area` VALUES ('2401', '283', '祁县');
INSERT INTO `abon_area` VALUES ('2402', '283', '寿阳');
INSERT INTO `abon_area` VALUES ('2403', '283', '太谷');
INSERT INTO `abon_area` VALUES ('2404', '283', '昔阳');
INSERT INTO `abon_area` VALUES ('2405', '283', '榆次');
INSERT INTO `abon_area` VALUES ('2406', '283', '榆社');
INSERT INTO `abon_area` VALUES ('2407', '283', '左权');
INSERT INTO `abon_area` VALUES ('2408', '284', '安泽');
INSERT INTO `abon_area` VALUES ('2409', '284', '大宁');
INSERT INTO `abon_area` VALUES ('2410', '284', '汾西');
INSERT INTO `abon_area` VALUES ('2411', '284', '浮山');
INSERT INTO `abon_area` VALUES ('2412', '284', '古县');
INSERT INTO `abon_area` VALUES ('2413', '284', '洪洞');
INSERT INTO `abon_area` VALUES ('2414', '284', '侯马');
INSERT INTO `abon_area` VALUES ('2415', '284', '霍州');
INSERT INTO `abon_area` VALUES ('2416', '284', '吉县');
INSERT INTO `abon_area` VALUES ('2417', '284', '蒲县');
INSERT INTO `abon_area` VALUES ('2418', '284', '曲沃');
INSERT INTO `abon_area` VALUES ('2419', '284', '隰县');
INSERT INTO `abon_area` VALUES ('2420', '284', '乡宁');
INSERT INTO `abon_area` VALUES ('2421', '284', '襄汾');
INSERT INTO `abon_area` VALUES ('2422', '284', '尧都');
INSERT INTO `abon_area` VALUES ('2423', '284', '翼城');
INSERT INTO `abon_area` VALUES ('2424', '284', '永和');
INSERT INTO `abon_area` VALUES ('2425', '285', '方山');
INSERT INTO `abon_area` VALUES ('2426', '285', '汾阳');
INSERT INTO `abon_area` VALUES ('2427', '285', '交城');
INSERT INTO `abon_area` VALUES ('2428', '285', '交口');
INSERT INTO `abon_area` VALUES ('2429', '285', '岚县');
INSERT INTO `abon_area` VALUES ('2430', '285', '离石');
INSERT INTO `abon_area` VALUES ('2431', '285', '临县');
INSERT INTO `abon_area` VALUES ('2432', '285', '柳林');
INSERT INTO `abon_area` VALUES ('2433', '285', '石楼');
INSERT INTO `abon_area` VALUES ('2434', '285', '文水');
INSERT INTO `abon_area` VALUES ('2435', '285', '孝义');
INSERT INTO `abon_area` VALUES ('2436', '285', '兴县');
INSERT INTO `abon_area` VALUES ('2437', '285', '中阳');
INSERT INTO `abon_area` VALUES ('2438', '286', '怀仁');
INSERT INTO `abon_area` VALUES ('2439', '286', '平鲁');
INSERT INTO `abon_area` VALUES ('2440', '286', '山阴');
INSERT INTO `abon_area` VALUES ('2441', '286', '朔城');
INSERT INTO `abon_area` VALUES ('2442', '286', '应县');
INSERT INTO `abon_area` VALUES ('2443', '286', '右玉');
INSERT INTO `abon_area` VALUES ('2444', '287', '古交');
INSERT INTO `abon_area` VALUES ('2445', '287', '尖草坪');
INSERT INTO `abon_area` VALUES ('2446', '287', '晋源');
INSERT INTO `abon_area` VALUES ('2447', '287', '娄烦');
INSERT INTO `abon_area` VALUES ('2448', '287', '清徐');
INSERT INTO `abon_area` VALUES ('2449', '287', '万柏林');
INSERT INTO `abon_area` VALUES ('2450', '287', '小店');
INSERT INTO `abon_area` VALUES ('2451', '287', '杏花岭');
INSERT INTO `abon_area` VALUES ('2452', '287', '阳曲');
INSERT INTO `abon_area` VALUES ('2453', '287', '迎泽');
INSERT INTO `abon_area` VALUES ('2454', '288', '保德');
INSERT INTO `abon_area` VALUES ('2455', '288', '代县');
INSERT INTO `abon_area` VALUES ('2456', '288', '定襄');
INSERT INTO `abon_area` VALUES ('2457', '288', '繁峙');
INSERT INTO `abon_area` VALUES ('2458', '288', '河曲');
INSERT INTO `abon_area` VALUES ('2459', '288', '静乐');
INSERT INTO `abon_area` VALUES ('2460', '288', '岢岚');
INSERT INTO `abon_area` VALUES ('2461', '288', '宁武');
INSERT INTO `abon_area` VALUES ('2462', '288', '偏关');
INSERT INTO `abon_area` VALUES ('2463', '288', '神池');
INSERT INTO `abon_area` VALUES ('2464', '288', '五台');
INSERT INTO `abon_area` VALUES ('2465', '288', '五寨');
INSERT INTO `abon_area` VALUES ('2466', '288', '忻府');
INSERT INTO `abon_area` VALUES ('2467', '288', '原平');
INSERT INTO `abon_area` VALUES ('2468', '289', '城区');
INSERT INTO `abon_area` VALUES ('2469', '289', '郊区');
INSERT INTO `abon_area` VALUES ('2470', '289', '矿区');
INSERT INTO `abon_area` VALUES ('2471', '289', '平定');
INSERT INTO `abon_area` VALUES ('2472', '289', '盂县');
INSERT INTO `abon_area` VALUES ('2473', '290', '河津');
INSERT INTO `abon_area` VALUES ('2474', '290', '稷山');
INSERT INTO `abon_area` VALUES ('2475', '290', '绛县');
INSERT INTO `abon_area` VALUES ('2476', '290', '临猗');
INSERT INTO `abon_area` VALUES ('2477', '290', '平陆');
INSERT INTO `abon_area` VALUES ('2478', '290', '芮城');
INSERT INTO `abon_area` VALUES ('2479', '290', '万荣');
INSERT INTO `abon_area` VALUES ('2480', '290', '闻喜');
INSERT INTO `abon_area` VALUES ('2481', '290', '夏县');
INSERT INTO `abon_area` VALUES ('2482', '290', '新绛');
INSERT INTO `abon_area` VALUES ('2483', '290', '盐湖');
INSERT INTO `abon_area` VALUES ('2484', '290', '永济');
INSERT INTO `abon_area` VALUES ('2485', '290', '垣曲');
INSERT INTO `abon_area` VALUES ('2486', '291', '长治');
INSERT INTO `abon_area` VALUES ('2487', '291', '城区');
INSERT INTO `abon_area` VALUES ('2488', '291', '壶关');
INSERT INTO `abon_area` VALUES ('2489', '291', '郊区');
INSERT INTO `abon_area` VALUES ('2490', '291', '黎城');
INSERT INTO `abon_area` VALUES ('2491', '291', '潞城');
INSERT INTO `abon_area` VALUES ('2492', '291', '平顺');
INSERT INTO `abon_area` VALUES ('2493', '291', '沁县');
INSERT INTO `abon_area` VALUES ('2494', '291', '沁源');
INSERT INTO `abon_area` VALUES ('2495', '291', '屯留');
INSERT INTO `abon_area` VALUES ('2496', '291', '武乡');
INSERT INTO `abon_area` VALUES ('2497', '291', '襄垣');
INSERT INTO `abon_area` VALUES ('2498', '291', '长子');
INSERT INTO `abon_area` VALUES ('2499', '292', '灞桥');
INSERT INTO `abon_area` VALUES ('2500', '292', '碑林');
INSERT INTO `abon_area` VALUES ('2501', '292', '高陵');
INSERT INTO `abon_area` VALUES ('2502', '292', '户县');
INSERT INTO `abon_area` VALUES ('2503', '292', '蓝田');
INSERT INTO `abon_area` VALUES ('2504', '292', '莲湖');
INSERT INTO `abon_area` VALUES ('2505', '292', '临潼');
INSERT INTO `abon_area` VALUES ('2506', '292', '未央');
INSERT INTO `abon_area` VALUES ('2507', '292', '新城');
INSERT INTO `abon_area` VALUES ('2508', '292', '阎良');
INSERT INTO `abon_area` VALUES ('2509', '292', '雁塔');
INSERT INTO `abon_area` VALUES ('2510', '292', '长安');
INSERT INTO `abon_area` VALUES ('2511', '292', '周至');
INSERT INTO `abon_area` VALUES ('2512', '293', '王益');
INSERT INTO `abon_area` VALUES ('2513', '293', '耀州');
INSERT INTO `abon_area` VALUES ('2514', '293', '宜君');
INSERT INTO `abon_area` VALUES ('2515', '293', '印台');
INSERT INTO `abon_area` VALUES ('2516', '294', '陈仓');
INSERT INTO `abon_area` VALUES ('2517', '294', '凤县');
INSERT INTO `abon_area` VALUES ('2518', '294', '凤翔');
INSERT INTO `abon_area` VALUES ('2519', '294', '扶风');
INSERT INTO `abon_area` VALUES ('2520', '294', '金台');
INSERT INTO `abon_area` VALUES ('2521', '294', '麟游');
INSERT INTO `abon_area` VALUES ('2522', '294', '陇县');
INSERT INTO `abon_area` VALUES ('2523', '294', '眉县');
INSERT INTO `abon_area` VALUES ('2524', '294', '岐山');
INSERT INTO `abon_area` VALUES ('2525', '294', '千阳');
INSERT INTO `abon_area` VALUES ('2526', '294', '太白');
INSERT INTO `abon_area` VALUES ('2527', '294', '渭滨');
INSERT INTO `abon_area` VALUES ('2528', '295', '彬县');
INSERT INTO `abon_area` VALUES ('2529', '295', '淳化');
INSERT INTO `abon_area` VALUES ('2530', '295', '泾阳');
INSERT INTO `abon_area` VALUES ('2531', '295', '礼泉');
INSERT INTO `abon_area` VALUES ('2532', '295', '乾县');
INSERT INTO `abon_area` VALUES ('2533', '295', '秦都');
INSERT INTO `abon_area` VALUES ('2534', '295', '三原');
INSERT INTO `abon_area` VALUES ('2535', '295', '渭城');
INSERT INTO `abon_area` VALUES ('2536', '295', '武功');
INSERT INTO `abon_area` VALUES ('2537', '295', '兴平');
INSERT INTO `abon_area` VALUES ('2538', '295', '旬邑');
INSERT INTO `abon_area` VALUES ('2539', '295', '杨陵');
INSERT INTO `abon_area` VALUES ('2540', '295', '永寿');
INSERT INTO `abon_area` VALUES ('2541', '295', '长武');
INSERT INTO `abon_area` VALUES ('2542', '296', '白水');
INSERT INTO `abon_area` VALUES ('2543', '296', '澄城');
INSERT INTO `abon_area` VALUES ('2544', '296', '大荔');
INSERT INTO `abon_area` VALUES ('2545', '296', '富平');
INSERT INTO `abon_area` VALUES ('2546', '296', '韩城');
INSERT INTO `abon_area` VALUES ('2547', '296', '合阳');
INSERT INTO `abon_area` VALUES ('2548', '296', '华县');
INSERT INTO `abon_area` VALUES ('2549', '296', '华阴');
INSERT INTO `abon_area` VALUES ('2550', '296', '临渭');
INSERT INTO `abon_area` VALUES ('2551', '296', '蒲城');
INSERT INTO `abon_area` VALUES ('2552', '296', '潼关');
INSERT INTO `abon_area` VALUES ('2553', '297', '安塞');
INSERT INTO `abon_area` VALUES ('2554', '297', '宝塔');
INSERT INTO `abon_area` VALUES ('2555', '297', '富县');
INSERT INTO `abon_area` VALUES ('2556', '297', '甘泉');
INSERT INTO `abon_area` VALUES ('2557', '297', '黄陵');
INSERT INTO `abon_area` VALUES ('2558', '297', '黄龙');
INSERT INTO `abon_area` VALUES ('2559', '297', '洛川');
INSERT INTO `abon_area` VALUES ('2560', '297', '吴起');
INSERT INTO `abon_area` VALUES ('2561', '297', '延川');
INSERT INTO `abon_area` VALUES ('2562', '297', '延长');
INSERT INTO `abon_area` VALUES ('2563', '297', '宜川');
INSERT INTO `abon_area` VALUES ('2564', '297', '志丹');
INSERT INTO `abon_area` VALUES ('2565', '297', '子长');
INSERT INTO `abon_area` VALUES ('2566', '298', '城固');
INSERT INTO `abon_area` VALUES ('2567', '298', '佛坪');
INSERT INTO `abon_area` VALUES ('2568', '298', '汉台');
INSERT INTO `abon_area` VALUES ('2569', '298', '留坝');
INSERT INTO `abon_area` VALUES ('2570', '298', '略阳');
INSERT INTO `abon_area` VALUES ('2571', '298', '勉县');
INSERT INTO `abon_area` VALUES ('2572', '298', '南郑');
INSERT INTO `abon_area` VALUES ('2573', '298', '宁强');
INSERT INTO `abon_area` VALUES ('2574', '298', '西乡');
INSERT INTO `abon_area` VALUES ('2575', '298', '洋县');
INSERT INTO `abon_area` VALUES ('2576', '298', '镇巴');
INSERT INTO `abon_area` VALUES ('2577', '299', '定边');
INSERT INTO `abon_area` VALUES ('2578', '299', '府谷');
INSERT INTO `abon_area` VALUES ('2579', '299', '横山');
INSERT INTO `abon_area` VALUES ('2580', '299', '佳县');
INSERT INTO `abon_area` VALUES ('2581', '299', '靖边');
INSERT INTO `abon_area` VALUES ('2582', '299', '米脂');
INSERT INTO `abon_area` VALUES ('2583', '299', '清涧');
INSERT INTO `abon_area` VALUES ('2584', '299', '神木');
INSERT INTO `abon_area` VALUES ('2585', '299', '绥德');
INSERT INTO `abon_area` VALUES ('2586', '299', '吴堡');
INSERT INTO `abon_area` VALUES ('2587', '299', '榆阳');
INSERT INTO `abon_area` VALUES ('2588', '299', '子洲');
INSERT INTO `abon_area` VALUES ('2589', '300', '白河');
INSERT INTO `abon_area` VALUES ('2590', '300', '汉滨');
INSERT INTO `abon_area` VALUES ('2591', '300', '汉阴');
INSERT INTO `abon_area` VALUES ('2592', '300', '岚皋');
INSERT INTO `abon_area` VALUES ('2593', '300', '宁陕');
INSERT INTO `abon_area` VALUES ('2594', '300', '平利');
INSERT INTO `abon_area` VALUES ('2595', '300', '石泉');
INSERT INTO `abon_area` VALUES ('2596', '300', '旬阳');
INSERT INTO `abon_area` VALUES ('2597', '300', '镇坪');
INSERT INTO `abon_area` VALUES ('2598', '300', '紫阳');
INSERT INTO `abon_area` VALUES ('2599', '301', '丹凤');
INSERT INTO `abon_area` VALUES ('2600', '301', '洛南');
INSERT INTO `abon_area` VALUES ('2601', '301', '山阳');
INSERT INTO `abon_area` VALUES ('2602', '301', '商南');
INSERT INTO `abon_area` VALUES ('2603', '301', '商州');
INSERT INTO `abon_area` VALUES ('2604', '301', '柞水');
INSERT INTO `abon_area` VALUES ('2605', '301', '镇安');
INSERT INTO `abon_area` VALUES ('2606', '302', '宝山');
INSERT INTO `abon_area` VALUES ('2607', '302', '崇明');
INSERT INTO `abon_area` VALUES ('2608', '302', '奉贤');
INSERT INTO `abon_area` VALUES ('2609', '302', '虹口');
INSERT INTO `abon_area` VALUES ('2610', '302', '黄浦');
INSERT INTO `abon_area` VALUES ('2611', '302', '嘉定');
INSERT INTO `abon_area` VALUES ('2612', '302', '金山');
INSERT INTO `abon_area` VALUES ('2613', '302', '静安');
INSERT INTO `abon_area` VALUES ('2614', '302', '闵行');
INSERT INTO `abon_area` VALUES ('2615', '302', '浦东');
INSERT INTO `abon_area` VALUES ('2616', '302', '普陀');
INSERT INTO `abon_area` VALUES ('2617', '302', '青浦');
INSERT INTO `abon_area` VALUES ('2618', '302', '松江');
INSERT INTO `abon_area` VALUES ('2619', '302', '徐汇');
INSERT INTO `abon_area` VALUES ('2620', '302', '杨浦');
INSERT INTO `abon_area` VALUES ('2621', '302', '闸北');
INSERT INTO `abon_area` VALUES ('2622', '302', '长宁');
INSERT INTO `abon_area` VALUES ('2623', '303', '成华');
INSERT INTO `abon_area` VALUES ('2624', '303', '崇州');
INSERT INTO `abon_area` VALUES ('2625', '303', '大邑');
INSERT INTO `abon_area` VALUES ('2626', '303', '都江堰');
INSERT INTO `abon_area` VALUES ('2627', '303', '金牛');
INSERT INTO `abon_area` VALUES ('2628', '303', '金堂');
INSERT INTO `abon_area` VALUES ('2629', '303', '锦江');
INSERT INTO `abon_area` VALUES ('2630', '303', '龙泉驿');
INSERT INTO `abon_area` VALUES ('2631', '303', '彭州');
INSERT INTO `abon_area` VALUES ('2632', '303', '郫县');
INSERT INTO `abon_area` VALUES ('2633', '303', '蒲江');
INSERT INTO `abon_area` VALUES ('2634', '303', '青白江');
INSERT INTO `abon_area` VALUES ('2635', '303', '青羊');
INSERT INTO `abon_area` VALUES ('2636', '303', '邛崃');
INSERT INTO `abon_area` VALUES ('2637', '303', '双流');
INSERT INTO `abon_area` VALUES ('2638', '303', '温江');
INSERT INTO `abon_area` VALUES ('2639', '303', '武侯');
INSERT INTO `abon_area` VALUES ('2640', '303', '新都');
INSERT INTO `abon_area` VALUES ('2641', '303', '新津');
INSERT INTO `abon_area` VALUES ('2642', '304', '大安');
INSERT INTO `abon_area` VALUES ('2643', '304', '富顺');
INSERT INTO `abon_area` VALUES ('2644', '304', '贡井');
INSERT INTO `abon_area` VALUES ('2645', '304', '荣县');
INSERT INTO `abon_area` VALUES ('2646', '304', '沿滩');
INSERT INTO `abon_area` VALUES ('2647', '304', '自流井');
INSERT INTO `abon_area` VALUES ('2648', '305', '东区');
INSERT INTO `abon_area` VALUES ('2649', '305', '米易');
INSERT INTO `abon_area` VALUES ('2650', '305', '仁和');
INSERT INTO `abon_area` VALUES ('2651', '305', '西区');
INSERT INTO `abon_area` VALUES ('2652', '305', '盐边');
INSERT INTO `abon_area` VALUES ('2653', '306', '古蔺');
INSERT INTO `abon_area` VALUES ('2654', '306', '合江');
INSERT INTO `abon_area` VALUES ('2655', '306', '江阳');
INSERT INTO `abon_area` VALUES ('2656', '306', '龙马潭');
INSERT INTO `abon_area` VALUES ('2657', '306', '泸县');
INSERT INTO `abon_area` VALUES ('2658', '306', '纳溪');
INSERT INTO `abon_area` VALUES ('2659', '306', '叙永');
INSERT INTO `abon_area` VALUES ('2660', '307', '广汉');
INSERT INTO `abon_area` VALUES ('2661', '307', '旌阳');
INSERT INTO `abon_area` VALUES ('2662', '307', '罗江');
INSERT INTO `abon_area` VALUES ('2663', '307', '绵竹');
INSERT INTO `abon_area` VALUES ('2664', '307', '什邡');
INSERT INTO `abon_area` VALUES ('2665', '307', '中江');
INSERT INTO `abon_area` VALUES ('2666', '308', '安县');
INSERT INTO `abon_area` VALUES ('2667', '308', '北川');
INSERT INTO `abon_area` VALUES ('2668', '308', '涪城');
INSERT INTO `abon_area` VALUES ('2669', '308', '江油');
INSERT INTO `abon_area` VALUES ('2670', '308', '平武');
INSERT INTO `abon_area` VALUES ('2671', '308', '三台');
INSERT INTO `abon_area` VALUES ('2672', '308', '盐亭');
INSERT INTO `abon_area` VALUES ('2673', '308', '游仙');
INSERT INTO `abon_area` VALUES ('2674', '308', '梓潼');
INSERT INTO `abon_area` VALUES ('2675', '309', '苍溪');
INSERT INTO `abon_area` VALUES ('2676', '309', '朝天');
INSERT INTO `abon_area` VALUES ('2677', '309', '剑阁');
INSERT INTO `abon_area` VALUES ('2678', '309', '利州');
INSERT INTO `abon_area` VALUES ('2679', '309', '青川');
INSERT INTO `abon_area` VALUES ('2680', '309', '旺苍');
INSERT INTO `abon_area` VALUES ('2681', '309', '昭化');
INSERT INTO `abon_area` VALUES ('2682', '310', '安居');
INSERT INTO `abon_area` VALUES ('2683', '310', '船山');
INSERT INTO `abon_area` VALUES ('2684', '310', '大英');
INSERT INTO `abon_area` VALUES ('2685', '310', '蓬溪');
INSERT INTO `abon_area` VALUES ('2686', '310', '射洪');
INSERT INTO `abon_area` VALUES ('2687', '311', '东兴');
INSERT INTO `abon_area` VALUES ('2688', '311', '隆昌');
INSERT INTO `abon_area` VALUES ('2689', '311', '市中');
INSERT INTO `abon_area` VALUES ('2690', '311', '威远');
INSERT INTO `abon_area` VALUES ('2691', '311', '资中');
INSERT INTO `abon_area` VALUES ('2692', '312', '峨边');
INSERT INTO `abon_area` VALUES ('2693', '312', '峨眉山');
INSERT INTO `abon_area` VALUES ('2694', '312', '夹江');
INSERT INTO `abon_area` VALUES ('2695', '312', '犍为');
INSERT INTO `abon_area` VALUES ('2696', '312', '金口河');
INSERT INTO `abon_area` VALUES ('2697', '312', '井研');
INSERT INTO `abon_area` VALUES ('2698', '312', '马边');
INSERT INTO `abon_area` VALUES ('2699', '312', '沐川');
INSERT INTO `abon_area` VALUES ('2700', '312', '沙湾');
INSERT INTO `abon_area` VALUES ('2701', '312', '市中');
INSERT INTO `abon_area` VALUES ('2702', '312', '五通桥');
INSERT INTO `abon_area` VALUES ('2703', '313', '高坪');
INSERT INTO `abon_area` VALUES ('2704', '313', '嘉陵');
INSERT INTO `abon_area` VALUES ('2705', '313', '阆中');
INSERT INTO `abon_area` VALUES ('2706', '313', '南部');
INSERT INTO `abon_area` VALUES ('2707', '313', '蓬安');
INSERT INTO `abon_area` VALUES ('2708', '313', '顺庆');
INSERT INTO `abon_area` VALUES ('2709', '313', '西充');
INSERT INTO `abon_area` VALUES ('2710', '313', '仪陇');
INSERT INTO `abon_area` VALUES ('2711', '313', '营山');
INSERT INTO `abon_area` VALUES ('2712', '314', '翠屏');
INSERT INTO `abon_area` VALUES ('2713', '314', '高县');
INSERT INTO `abon_area` VALUES ('2714', '314', '珙县');
INSERT INTO `abon_area` VALUES ('2715', '314', '江安');
INSERT INTO `abon_area` VALUES ('2716', '314', '筠连');
INSERT INTO `abon_area` VALUES ('2717', '314', '南溪');
INSERT INTO `abon_area` VALUES ('2718', '314', '屏山');
INSERT INTO `abon_area` VALUES ('2719', '314', '兴文');
INSERT INTO `abon_area` VALUES ('2720', '314', '宜宾');
INSERT INTO `abon_area` VALUES ('2721', '314', '长宁');
INSERT INTO `abon_area` VALUES ('2722', '315', '广安');
INSERT INTO `abon_area` VALUES ('2723', '315', '广安');
INSERT INTO `abon_area` VALUES ('2724', '315', '华蓥');
INSERT INTO `abon_area` VALUES ('2725', '315', '邻水');
INSERT INTO `abon_area` VALUES ('2726', '315', '武胜');
INSERT INTO `abon_area` VALUES ('2727', '315', '岳池');
INSERT INTO `abon_area` VALUES ('2728', '316', '达川');
INSERT INTO `abon_area` VALUES ('2729', '316', '大竹');
INSERT INTO `abon_area` VALUES ('2730', '316', '开江');
INSERT INTO `abon_area` VALUES ('2731', '316', '渠县');
INSERT INTO `abon_area` VALUES ('2732', '316', '通川');
INSERT INTO `abon_area` VALUES ('2733', '316', '万源');
INSERT INTO `abon_area` VALUES ('2734', '316', '宣汉');
INSERT INTO `abon_area` VALUES ('2735', '317', '丹棱');
INSERT INTO `abon_area` VALUES ('2736', '317', '东坡');
INSERT INTO `abon_area` VALUES ('2737', '317', '洪雅');
INSERT INTO `abon_area` VALUES ('2738', '317', '彭山');
INSERT INTO `abon_area` VALUES ('2739', '317', '青神');
INSERT INTO `abon_area` VALUES ('2740', '317', '仁寿');
INSERT INTO `abon_area` VALUES ('2741', '318', '宝兴');
INSERT INTO `abon_area` VALUES ('2742', '318', '汉源');
INSERT INTO `abon_area` VALUES ('2743', '318', '芦山');
INSERT INTO `abon_area` VALUES ('2744', '318', '名山');
INSERT INTO `abon_area` VALUES ('2745', '318', '石棉');
INSERT INTO `abon_area` VALUES ('2746', '318', '天全');
INSERT INTO `abon_area` VALUES ('2747', '318', '荥经');
INSERT INTO `abon_area` VALUES ('2748', '318', '雨城');
INSERT INTO `abon_area` VALUES ('2749', '319', '巴州');
INSERT INTO `abon_area` VALUES ('2750', '319', '恩阳');
INSERT INTO `abon_area` VALUES ('2751', '319', '南江');
INSERT INTO `abon_area` VALUES ('2752', '319', '平昌');
INSERT INTO `abon_area` VALUES ('2753', '319', '通江');
INSERT INTO `abon_area` VALUES ('2754', '320', '安岳');
INSERT INTO `abon_area` VALUES ('2755', '320', '简阳');
INSERT INTO `abon_area` VALUES ('2756', '320', '乐至');
INSERT INTO `abon_area` VALUES ('2757', '320', '雁江');
INSERT INTO `abon_area` VALUES ('2758', '321', '阿坝');
INSERT INTO `abon_area` VALUES ('2759', '321', '黑水');
INSERT INTO `abon_area` VALUES ('2760', '321', '红原');
INSERT INTO `abon_area` VALUES ('2761', '321', '金川');
INSERT INTO `abon_area` VALUES ('2762', '321', '九寨沟');
INSERT INTO `abon_area` VALUES ('2763', '321', '理县');
INSERT INTO `abon_area` VALUES ('2764', '321', '马尔康');
INSERT INTO `abon_area` VALUES ('2765', '321', '茂县');
INSERT INTO `abon_area` VALUES ('2766', '321', '壤塘');
INSERT INTO `abon_area` VALUES ('2767', '321', '若尔盖');
INSERT INTO `abon_area` VALUES ('2768', '321', '松潘');
INSERT INTO `abon_area` VALUES ('2769', '321', '汶川');
INSERT INTO `abon_area` VALUES ('2770', '321', '小金');
INSERT INTO `abon_area` VALUES ('2771', '322', '巴塘');
INSERT INTO `abon_area` VALUES ('2772', '322', '白玉');
INSERT INTO `abon_area` VALUES ('2773', '322', '丹巴');
INSERT INTO `abon_area` VALUES ('2774', '322', '道孚');
INSERT INTO `abon_area` VALUES ('2775', '322', '稻城');
INSERT INTO `abon_area` VALUES ('2776', '322', '得荣');
INSERT INTO `abon_area` VALUES ('2777', '322', '德格');
INSERT INTO `abon_area` VALUES ('2778', '322', '甘孜');
INSERT INTO `abon_area` VALUES ('2779', '322', '九龙');
INSERT INTO `abon_area` VALUES ('2780', '322', '康定');
INSERT INTO `abon_area` VALUES ('2781', '322', '理塘');
INSERT INTO `abon_area` VALUES ('2782', '322', '炉霍');
INSERT INTO `abon_area` VALUES ('2783', '322', '泸定');
INSERT INTO `abon_area` VALUES ('2784', '322', '色达');
INSERT INTO `abon_area` VALUES ('2785', '322', '石渠');
INSERT INTO `abon_area` VALUES ('2786', '322', '乡城');
INSERT INTO `abon_area` VALUES ('2787', '322', '新龙');
INSERT INTO `abon_area` VALUES ('2788', '322', '雅江');
INSERT INTO `abon_area` VALUES ('2789', '323', '布拖');
INSERT INTO `abon_area` VALUES ('2790', '323', '德昌');
INSERT INTO `abon_area` VALUES ('2791', '323', '甘洛');
INSERT INTO `abon_area` VALUES ('2792', '323', '会东');
INSERT INTO `abon_area` VALUES ('2793', '323', '会理');
INSERT INTO `abon_area` VALUES ('2794', '323', '金阳');
INSERT INTO `abon_area` VALUES ('2795', '323', '雷波');
INSERT INTO `abon_area` VALUES ('2796', '323', '美姑');
INSERT INTO `abon_area` VALUES ('2797', '323', '冕宁');
INSERT INTO `abon_area` VALUES ('2798', '323', '木里');
INSERT INTO `abon_area` VALUES ('2799', '323', '宁南');
INSERT INTO `abon_area` VALUES ('2800', '323', '普格');
INSERT INTO `abon_area` VALUES ('2801', '323', '西昌');
INSERT INTO `abon_area` VALUES ('2802', '323', '喜德');
INSERT INTO `abon_area` VALUES ('2803', '323', '盐源');
INSERT INTO `abon_area` VALUES ('2804', '323', '越西');
INSERT INTO `abon_area` VALUES ('2805', '323', '昭觉');
INSERT INTO `abon_area` VALUES ('2806', '324', '宝坻');
INSERT INTO `abon_area` VALUES ('2807', '324', '北辰');
INSERT INTO `abon_area` VALUES ('2808', '324', '滨海');
INSERT INTO `abon_area` VALUES ('2809', '324', '东丽');
INSERT INTO `abon_area` VALUES ('2810', '324', '和平');
INSERT INTO `abon_area` VALUES ('2811', '324', '河北');
INSERT INTO `abon_area` VALUES ('2812', '324', '河东');
INSERT INTO `abon_area` VALUES ('2813', '324', '河西');
INSERT INTO `abon_area` VALUES ('2814', '324', '红桥');
INSERT INTO `abon_area` VALUES ('2815', '324', '蓟县');
INSERT INTO `abon_area` VALUES ('2816', '324', '津南');
INSERT INTO `abon_area` VALUES ('2817', '324', '静海');
INSERT INTO `abon_area` VALUES ('2818', '324', '南开');
INSERT INTO `abon_area` VALUES ('2819', '324', '宁河');
INSERT INTO `abon_area` VALUES ('2820', '324', '武清');
INSERT INTO `abon_area` VALUES ('2821', '324', '西青');
INSERT INTO `abon_area` VALUES ('2822', '325', '城关');
INSERT INTO `abon_area` VALUES ('2823', '325', '达孜');
INSERT INTO `abon_area` VALUES ('2824', '325', '当雄');
INSERT INTO `abon_area` VALUES ('2825', '325', '堆龙德庆');
INSERT INTO `abon_area` VALUES ('2826', '325', '林周');
INSERT INTO `abon_area` VALUES ('2827', '325', '墨竹工卡');
INSERT INTO `abon_area` VALUES ('2828', '325', '尼木');
INSERT INTO `abon_area` VALUES ('2829', '325', '曲水');
INSERT INTO `abon_area` VALUES ('2830', '326', '八宿');
INSERT INTO `abon_area` VALUES ('2831', '326', '边坝');
INSERT INTO `abon_area` VALUES ('2832', '326', '察雅');
INSERT INTO `abon_area` VALUES ('2833', '326', '昌都');
INSERT INTO `abon_area` VALUES ('2834', '326', '丁青');
INSERT INTO `abon_area` VALUES ('2835', '326', '贡觉');
INSERT INTO `abon_area` VALUES ('2836', '326', '江达');
INSERT INTO `abon_area` VALUES ('2837', '326', '类乌齐');
INSERT INTO `abon_area` VALUES ('2838', '326', '洛隆');
INSERT INTO `abon_area` VALUES ('2839', '326', '芒康');
INSERT INTO `abon_area` VALUES ('2840', '326', '左贡');
INSERT INTO `abon_area` VALUES ('2841', '327', '措美');
INSERT INTO `abon_area` VALUES ('2842', '327', '错那');
INSERT INTO `abon_area` VALUES ('2843', '327', '贡嘎');
INSERT INTO `abon_area` VALUES ('2844', '327', '加查');
INSERT INTO `abon_area` VALUES ('2845', '327', '浪卡子');
INSERT INTO `abon_area` VALUES ('2846', '327', '隆子');
INSERT INTO `abon_area` VALUES ('2847', '327', '洛扎');
INSERT INTO `abon_area` VALUES ('2848', '327', '乃东');
INSERT INTO `abon_area` VALUES ('2849', '327', '琼结');
INSERT INTO `abon_area` VALUES ('2850', '327', '曲松');
INSERT INTO `abon_area` VALUES ('2851', '327', '桑日');
INSERT INTO `abon_area` VALUES ('2852', '327', '扎囊');
INSERT INTO `abon_area` VALUES ('2853', '328', '昂仁');
INSERT INTO `abon_area` VALUES ('2854', '328', '白朗');
INSERT INTO `abon_area` VALUES ('2855', '328', '定结');
INSERT INTO `abon_area` VALUES ('2856', '328', '定日');
INSERT INTO `abon_area` VALUES ('2857', '328', '岗巴');
INSERT INTO `abon_area` VALUES ('2858', '328', '吉隆');
INSERT INTO `abon_area` VALUES ('2859', '328', '江孜');
INSERT INTO `abon_area` VALUES ('2860', '328', '康马');
INSERT INTO `abon_area` VALUES ('2861', '328', '拉孜');
INSERT INTO `abon_area` VALUES ('2862', '328', '南木林');
INSERT INTO `abon_area` VALUES ('2863', '328', '聂拉木');
INSERT INTO `abon_area` VALUES ('2864', '328', '仁布');
INSERT INTO `abon_area` VALUES ('2865', '328', '日喀则');
INSERT INTO `abon_area` VALUES ('2866', '328', '萨嘎');
INSERT INTO `abon_area` VALUES ('2867', '328', '萨迦');
INSERT INTO `abon_area` VALUES ('2868', '328', '谢通门');
INSERT INTO `abon_area` VALUES ('2869', '328', '亚东');
INSERT INTO `abon_area` VALUES ('2870', '328', '仲巴');
INSERT INTO `abon_area` VALUES ('2871', '329', '安多');
INSERT INTO `abon_area` VALUES ('2872', '329', '巴青');
INSERT INTO `abon_area` VALUES ('2873', '329', '班戈');
INSERT INTO `abon_area` VALUES ('2874', '329', '比如');
INSERT INTO `abon_area` VALUES ('2875', '329', '嘉黎');
INSERT INTO `abon_area` VALUES ('2876', '329', '那曲');
INSERT INTO `abon_area` VALUES ('2877', '329', '尼玛');
INSERT INTO `abon_area` VALUES ('2878', '329', '聂荣');
INSERT INTO `abon_area` VALUES ('2879', '329', '申扎');
INSERT INTO `abon_area` VALUES ('2880', '329', '双湖');
INSERT INTO `abon_area` VALUES ('2881', '329', '索县');
INSERT INTO `abon_area` VALUES ('2882', '330', '措勤');
INSERT INTO `abon_area` VALUES ('2883', '330', '噶尔');
INSERT INTO `abon_area` VALUES ('2884', '330', '改则');
INSERT INTO `abon_area` VALUES ('2885', '330', '革吉');
INSERT INTO `abon_area` VALUES ('2886', '330', '普兰');
INSERT INTO `abon_area` VALUES ('2887', '330', '日土');
INSERT INTO `abon_area` VALUES ('2888', '330', '札达');
INSERT INTO `abon_area` VALUES ('2889', '331', '波密');
INSERT INTO `abon_area` VALUES ('2890', '331', '察隅');
INSERT INTO `abon_area` VALUES ('2891', '331', '工布江达');
INSERT INTO `abon_area` VALUES ('2892', '331', '朗县');
INSERT INTO `abon_area` VALUES ('2893', '331', '林芝');
INSERT INTO `abon_area` VALUES ('2894', '331', '米林');
INSERT INTO `abon_area` VALUES ('2895', '331', '墨脱');
INSERT INTO `abon_area` VALUES ('2896', '332', '达坂城');
INSERT INTO `abon_area` VALUES ('2897', '332', '米东');
INSERT INTO `abon_area` VALUES ('2898', '332', '沙依巴克');
INSERT INTO `abon_area` VALUES ('2899', '332', '水磨沟');
INSERT INTO `abon_area` VALUES ('2900', '332', '天山');
INSERT INTO `abon_area` VALUES ('2901', '332', '头屯河');
INSERT INTO `abon_area` VALUES ('2902', '332', '乌鲁木齐');
INSERT INTO `abon_area` VALUES ('2903', '332', '新市');
INSERT INTO `abon_area` VALUES ('2904', '333', '白碱滩');
INSERT INTO `abon_area` VALUES ('2905', '333', '独山子');
INSERT INTO `abon_area` VALUES ('2906', '333', '克拉玛依');
INSERT INTO `abon_area` VALUES ('2907', '333', '乌尔禾');
INSERT INTO `abon_area` VALUES ('2908', '334', '鄯善');
INSERT INTO `abon_area` VALUES ('2909', '334', '吐鲁番');
INSERT INTO `abon_area` VALUES ('2910', '334', '托克逊');
INSERT INTO `abon_area` VALUES ('2911', '335', '巴里坤');
INSERT INTO `abon_area` VALUES ('2912', '335', '哈密');
INSERT INTO `abon_area` VALUES ('2913', '335', '伊吾');
INSERT INTO `abon_area` VALUES ('2914', '336', '策勒');
INSERT INTO `abon_area` VALUES ('2915', '336', '和田');
INSERT INTO `abon_area` VALUES ('2916', '336', '和田');
INSERT INTO `abon_area` VALUES ('2917', '336', '洛浦');
INSERT INTO `abon_area` VALUES ('2918', '336', '民丰');
INSERT INTO `abon_area` VALUES ('2919', '336', '墨玉');
INSERT INTO `abon_area` VALUES ('2920', '336', '皮山');
INSERT INTO `abon_area` VALUES ('2921', '336', '于田');
INSERT INTO `abon_area` VALUES ('2922', '337', '阿克苏');
INSERT INTO `abon_area` VALUES ('2923', '337', '阿瓦提');
INSERT INTO `abon_area` VALUES ('2924', '337', '拜城');
INSERT INTO `abon_area` VALUES ('2925', '337', '柯坪');
INSERT INTO `abon_area` VALUES ('2926', '337', '库车');
INSERT INTO `abon_area` VALUES ('2927', '337', '沙雅');
INSERT INTO `abon_area` VALUES ('2928', '337', '温宿');
INSERT INTO `abon_area` VALUES ('2929', '337', '乌什');
INSERT INTO `abon_area` VALUES ('2930', '337', '新和');
INSERT INTO `abon_area` VALUES ('2931', '338', '巴楚');
INSERT INTO `abon_area` VALUES ('2932', '338', '伽师');
INSERT INTO `abon_area` VALUES ('2933', '338', '喀什');
INSERT INTO `abon_area` VALUES ('2934', '338', '麦盖提');
INSERT INTO `abon_area` VALUES ('2935', '338', '莎车');
INSERT INTO `abon_area` VALUES ('2936', '338', '疏附');
INSERT INTO `abon_area` VALUES ('2937', '338', '疏勒');
INSERT INTO `abon_area` VALUES ('2938', '338', '塔什库尔干');
INSERT INTO `abon_area` VALUES ('2939', '338', '叶城');
INSERT INTO `abon_area` VALUES ('2940', '338', '英吉沙');
INSERT INTO `abon_area` VALUES ('2941', '338', '岳普湖');
INSERT INTO `abon_area` VALUES ('2942', '338', '泽普');
INSERT INTO `abon_area` VALUES ('2943', '339', '阿合奇');
INSERT INTO `abon_area` VALUES ('2944', '339', '阿克陶');
INSERT INTO `abon_area` VALUES ('2945', '339', '阿图什');
INSERT INTO `abon_area` VALUES ('2946', '339', '乌恰');
INSERT INTO `abon_area` VALUES ('2947', '340', '博湖');
INSERT INTO `abon_area` VALUES ('2948', '340', '和静');
INSERT INTO `abon_area` VALUES ('2949', '340', '和硕');
INSERT INTO `abon_area` VALUES ('2950', '340', '库尔勒');
INSERT INTO `abon_area` VALUES ('2951', '340', '轮台');
INSERT INTO `abon_area` VALUES ('2952', '340', '且末');
INSERT INTO `abon_area` VALUES ('2953', '340', '若羌');
INSERT INTO `abon_area` VALUES ('2954', '340', '尉犁');
INSERT INTO `abon_area` VALUES ('2955', '340', '焉耆');
INSERT INTO `abon_area` VALUES ('2956', '341', '昌吉');
INSERT INTO `abon_area` VALUES ('2957', '341', '阜康');
INSERT INTO `abon_area` VALUES ('2958', '341', '呼图壁');
INSERT INTO `abon_area` VALUES ('2959', '341', '吉木萨尔');
INSERT INTO `abon_area` VALUES ('2960', '341', '玛纳斯');
INSERT INTO `abon_area` VALUES ('2961', '341', '木垒');
INSERT INTO `abon_area` VALUES ('2962', '341', '奇台');
INSERT INTO `abon_area` VALUES ('2963', '342', '阿拉山口');
INSERT INTO `abon_area` VALUES ('2964', '342', '博乐');
INSERT INTO `abon_area` VALUES ('2965', '342', '精河');
INSERT INTO `abon_area` VALUES ('2966', '342', '温泉');
INSERT INTO `abon_area` VALUES ('2967', '343', '察布查尔');
INSERT INTO `abon_area` VALUES ('2968', '343', '巩留');
INSERT INTO `abon_area` VALUES ('2969', '343', '霍城');
INSERT INTO `abon_area` VALUES ('2970', '343', '奎屯');
INSERT INTO `abon_area` VALUES ('2971', '343', '尼勒克');
INSERT INTO `abon_area` VALUES ('2972', '343', '特克斯');
INSERT INTO `abon_area` VALUES ('2973', '343', '新源');
INSERT INTO `abon_area` VALUES ('2974', '343', '伊宁');
INSERT INTO `abon_area` VALUES ('2975', '343', '伊宁');
INSERT INTO `abon_area` VALUES ('2976', '343', '昭苏');
INSERT INTO `abon_area` VALUES ('2977', '344', '额敏');
INSERT INTO `abon_area` VALUES ('2978', '344', '和布克赛尔');
INSERT INTO `abon_area` VALUES ('2979', '344', '沙湾');
INSERT INTO `abon_area` VALUES ('2980', '344', '塔城');
INSERT INTO `abon_area` VALUES ('2981', '344', '托里');
INSERT INTO `abon_area` VALUES ('2982', '344', '乌苏');
INSERT INTO `abon_area` VALUES ('2983', '344', '裕民');
INSERT INTO `abon_area` VALUES ('2984', '345', '阿勒泰');
INSERT INTO `abon_area` VALUES ('2985', '345', '布尔津');
INSERT INTO `abon_area` VALUES ('2986', '345', '福海');
INSERT INTO `abon_area` VALUES ('2987', '345', '富蕴');
INSERT INTO `abon_area` VALUES ('2988', '345', '哈巴河');
INSERT INTO `abon_area` VALUES ('2989', '345', '吉木乃');
INSERT INTO `abon_area` VALUES ('2990', '345', '青河');
INSERT INTO `abon_area` VALUES ('2991', '346', '阿拉尔');
INSERT INTO `abon_area` VALUES ('2992', '346', '北屯');
INSERT INTO `abon_area` VALUES ('2993', '346', '石河子');
INSERT INTO `abon_area` VALUES ('2994', '346', '铁门关');
INSERT INTO `abon_area` VALUES ('2995', '346', '图木舒克');
INSERT INTO `abon_area` VALUES ('2996', '346', '五家渠');
INSERT INTO `abon_area` VALUES ('2997', '347', '安宁');
INSERT INTO `abon_area` VALUES ('2998', '347', '呈贡');
INSERT INTO `abon_area` VALUES ('2999', '347', '东川');
INSERT INTO `abon_area` VALUES ('3000', '347', '富民');
INSERT INTO `abon_area` VALUES ('3001', '347', '官渡');
INSERT INTO `abon_area` VALUES ('3002', '347', '晋宁');
INSERT INTO `abon_area` VALUES ('3003', '347', '禄劝');
INSERT INTO `abon_area` VALUES ('3004', '347', '盘龙');
INSERT INTO `abon_area` VALUES ('3005', '347', '石林');
INSERT INTO `abon_area` VALUES ('3006', '347', '嵩明');
INSERT INTO `abon_area` VALUES ('3007', '347', '五华');
INSERT INTO `abon_area` VALUES ('3008', '347', '西山');
INSERT INTO `abon_area` VALUES ('3009', '347', '寻甸');
INSERT INTO `abon_area` VALUES ('3010', '347', '宜良');
INSERT INTO `abon_area` VALUES ('3011', '348', '富源');
INSERT INTO `abon_area` VALUES ('3012', '348', '会泽');
INSERT INTO `abon_area` VALUES ('3013', '348', '陆良');
INSERT INTO `abon_area` VALUES ('3014', '348', '罗平');
INSERT INTO `abon_area` VALUES ('3015', '348', '马龙');
INSERT INTO `abon_area` VALUES ('3016', '348', '麒麟');
INSERT INTO `abon_area` VALUES ('3017', '348', '师宗');
INSERT INTO `abon_area` VALUES ('3018', '348', '宣威');
INSERT INTO `abon_area` VALUES ('3019', '348', '沾益');
INSERT INTO `abon_area` VALUES ('3020', '349', '澄江');
INSERT INTO `abon_area` VALUES ('3021', '349', '峨山');
INSERT INTO `abon_area` VALUES ('3022', '349', '红塔');
INSERT INTO `abon_area` VALUES ('3023', '349', '华宁');
INSERT INTO `abon_area` VALUES ('3024', '349', '江川');
INSERT INTO `abon_area` VALUES ('3025', '349', '通海');
INSERT INTO `abon_area` VALUES ('3026', '349', '新平');
INSERT INTO `abon_area` VALUES ('3027', '349', '易门');
INSERT INTO `abon_area` VALUES ('3028', '349', '元江');
INSERT INTO `abon_area` VALUES ('3029', '350', '昌宁');
INSERT INTO `abon_area` VALUES ('3030', '350', '龙陵');
INSERT INTO `abon_area` VALUES ('3031', '350', '隆阳');
INSERT INTO `abon_area` VALUES ('3032', '350', '施甸');
INSERT INTO `abon_area` VALUES ('3033', '350', '腾冲');
INSERT INTO `abon_area` VALUES ('3034', '351', '大关');
INSERT INTO `abon_area` VALUES ('3035', '351', '鲁甸');
INSERT INTO `abon_area` VALUES ('3036', '351', '巧家');
INSERT INTO `abon_area` VALUES ('3037', '351', '水富');
INSERT INTO `abon_area` VALUES ('3038', '351', '绥江');
INSERT INTO `abon_area` VALUES ('3039', '351', '威信');
INSERT INTO `abon_area` VALUES ('3040', '351', '盐津');
INSERT INTO `abon_area` VALUES ('3041', '351', '彝良');
INSERT INTO `abon_area` VALUES ('3042', '351', '永善');
INSERT INTO `abon_area` VALUES ('3043', '351', '昭阳');
INSERT INTO `abon_area` VALUES ('3044', '351', '镇雄');
INSERT INTO `abon_area` VALUES ('3045', '352', '古城');
INSERT INTO `abon_area` VALUES ('3046', '352', '华坪');
INSERT INTO `abon_area` VALUES ('3047', '352', '宁蒗');
INSERT INTO `abon_area` VALUES ('3048', '352', '永胜');
INSERT INTO `abon_area` VALUES ('3049', '352', '玉龙');
INSERT INTO `abon_area` VALUES ('3050', '353', '江城');
INSERT INTO `abon_area` VALUES ('3051', '353', '景东');
INSERT INTO `abon_area` VALUES ('3052', '353', '景谷');
INSERT INTO `abon_area` VALUES ('3053', '353', '澜沧');
INSERT INTO `abon_area` VALUES ('3054', '353', '孟连');
INSERT INTO `abon_area` VALUES ('3055', '353', '墨江');
INSERT INTO `abon_area` VALUES ('3056', '353', '宁洱');
INSERT INTO `abon_area` VALUES ('3057', '353', '思茅');
INSERT INTO `abon_area` VALUES ('3058', '353', '西盟');
INSERT INTO `abon_area` VALUES ('3059', '353', '镇沅');
INSERT INTO `abon_area` VALUES ('3060', '354', '沧源');
INSERT INTO `abon_area` VALUES ('3061', '354', '凤庆');
INSERT INTO `abon_area` VALUES ('3062', '354', '耿马');
INSERT INTO `abon_area` VALUES ('3063', '354', '临翔');
INSERT INTO `abon_area` VALUES ('3064', '354', '双江');
INSERT INTO `abon_area` VALUES ('3065', '354', '永德');
INSERT INTO `abon_area` VALUES ('3066', '354', '云县');
INSERT INTO `abon_area` VALUES ('3067', '354', '镇康');
INSERT INTO `abon_area` VALUES ('3068', '355', '富宁');
INSERT INTO `abon_area` VALUES ('3069', '355', '广南');
INSERT INTO `abon_area` VALUES ('3070', '355', '麻栗坡');
INSERT INTO `abon_area` VALUES ('3071', '355', '马关');
INSERT INTO `abon_area` VALUES ('3072', '355', '丘北');
INSERT INTO `abon_area` VALUES ('3073', '355', '文山');
INSERT INTO `abon_area` VALUES ('3074', '355', '西畴');
INSERT INTO `abon_area` VALUES ('3075', '355', '砚山');
INSERT INTO `abon_area` VALUES ('3076', '356', '个旧');
INSERT INTO `abon_area` VALUES ('3077', '356', '河口');
INSERT INTO `abon_area` VALUES ('3078', '356', '红河');
INSERT INTO `abon_area` VALUES ('3079', '356', '建水');
INSERT INTO `abon_area` VALUES ('3080', '356', '金平');
INSERT INTO `abon_area` VALUES ('3081', '356', '开远');
INSERT INTO `abon_area` VALUES ('3082', '356', '泸西');
INSERT INTO `abon_area` VALUES ('3083', '356', '绿春');
INSERT INTO `abon_area` VALUES ('3084', '356', '蒙自');
INSERT INTO `abon_area` VALUES ('3085', '356', '弥勒');
INSERT INTO `abon_area` VALUES ('3086', '356', '屏边');
INSERT INTO `abon_area` VALUES ('3087', '356', '石屏');
INSERT INTO `abon_area` VALUES ('3088', '356', '元阳');
INSERT INTO `abon_area` VALUES ('3089', '357', '景洪');
INSERT INTO `abon_area` VALUES ('3090', '357', '勐海');
INSERT INTO `abon_area` VALUES ('3091', '357', '勐腊');
INSERT INTO `abon_area` VALUES ('3092', '358', '楚雄');
INSERT INTO `abon_area` VALUES ('3093', '358', '大姚');
INSERT INTO `abon_area` VALUES ('3094', '358', '禄丰');
INSERT INTO `abon_area` VALUES ('3095', '358', '牟定');
INSERT INTO `abon_area` VALUES ('3096', '358', '南华');
INSERT INTO `abon_area` VALUES ('3097', '358', '双柏');
INSERT INTO `abon_area` VALUES ('3098', '358', '武定');
INSERT INTO `abon_area` VALUES ('3099', '358', '姚安');
INSERT INTO `abon_area` VALUES ('3100', '358', '永仁');
INSERT INTO `abon_area` VALUES ('3101', '358', '元谋');
INSERT INTO `abon_area` VALUES ('3102', '359', '宾川');
INSERT INTO `abon_area` VALUES ('3103', '359', '大理');
INSERT INTO `abon_area` VALUES ('3104', '359', '洱源');
INSERT INTO `abon_area` VALUES ('3105', '359', '鹤庆');
INSERT INTO `abon_area` VALUES ('3106', '359', '剑川');
INSERT INTO `abon_area` VALUES ('3107', '359', '弥渡');
INSERT INTO `abon_area` VALUES ('3108', '359', '南涧');
INSERT INTO `abon_area` VALUES ('3109', '359', '巍山');
INSERT INTO `abon_area` VALUES ('3110', '359', '祥云');
INSERT INTO `abon_area` VALUES ('3111', '359', '漾濞');
INSERT INTO `abon_area` VALUES ('3112', '359', '永平');
INSERT INTO `abon_area` VALUES ('3113', '359', '云龙');
INSERT INTO `abon_area` VALUES ('3114', '360', '梁河');
INSERT INTO `abon_area` VALUES ('3115', '360', '陇川');
INSERT INTO `abon_area` VALUES ('3116', '360', '芒市');
INSERT INTO `abon_area` VALUES ('3117', '360', '瑞丽');
INSERT INTO `abon_area` VALUES ('3118', '360', '盈江');
INSERT INTO `abon_area` VALUES ('3119', '361', '福贡');
INSERT INTO `abon_area` VALUES ('3120', '361', '贡山');
INSERT INTO `abon_area` VALUES ('3121', '361', '兰坪');
INSERT INTO `abon_area` VALUES ('3122', '361', '泸水');
INSERT INTO `abon_area` VALUES ('3123', '362', '德钦');
INSERT INTO `abon_area` VALUES ('3124', '362', '维西');
INSERT INTO `abon_area` VALUES ('3125', '362', '香格里拉');
INSERT INTO `abon_area` VALUES ('3126', '363', '滨江');
INSERT INTO `abon_area` VALUES ('3127', '363', '淳安');
INSERT INTO `abon_area` VALUES ('3128', '363', '富阳');
INSERT INTO `abon_area` VALUES ('3129', '363', '拱墅');
INSERT INTO `abon_area` VALUES ('3130', '363', '建德');
INSERT INTO `abon_area` VALUES ('3131', '363', '江干');
INSERT INTO `abon_area` VALUES ('3132', '363', '临安');
INSERT INTO `abon_area` VALUES ('3133', '363', '上城');
INSERT INTO `abon_area` VALUES ('3134', '363', '桐庐');
INSERT INTO `abon_area` VALUES ('3135', '363', '西湖');
INSERT INTO `abon_area` VALUES ('3136', '363', '下城');
INSERT INTO `abon_area` VALUES ('3137', '363', '萧山');
INSERT INTO `abon_area` VALUES ('3138', '363', '余杭');
INSERT INTO `abon_area` VALUES ('3139', '364', '北仑');
INSERT INTO `abon_area` VALUES ('3140', '364', '慈溪');
INSERT INTO `abon_area` VALUES ('3141', '364', '奉化');
INSERT INTO `abon_area` VALUES ('3142', '364', '海曙');
INSERT INTO `abon_area` VALUES ('3143', '364', '江北');
INSERT INTO `abon_area` VALUES ('3144', '364', '江东');
INSERT INTO `abon_area` VALUES ('3145', '364', '宁海');
INSERT INTO `abon_area` VALUES ('3146', '364', '象山');
INSERT INTO `abon_area` VALUES ('3147', '364', '鄞州');
INSERT INTO `abon_area` VALUES ('3148', '364', '余姚');
INSERT INTO `abon_area` VALUES ('3149', '364', '镇海');
INSERT INTO `abon_area` VALUES ('3150', '365', '苍南');
INSERT INTO `abon_area` VALUES ('3151', '365', '洞头');
INSERT INTO `abon_area` VALUES ('3152', '365', '乐清');
INSERT INTO `abon_area` VALUES ('3153', '365', '龙湾');
INSERT INTO `abon_area` VALUES ('3154', '365', '鹿城');
INSERT INTO `abon_area` VALUES ('3155', '365', '瓯海');
INSERT INTO `abon_area` VALUES ('3156', '365', '平阳');
INSERT INTO `abon_area` VALUES ('3157', '365', '瑞安');
INSERT INTO `abon_area` VALUES ('3158', '365', '泰顺');
INSERT INTO `abon_area` VALUES ('3159', '365', '文成');
INSERT INTO `abon_area` VALUES ('3160', '365', '永嘉');
INSERT INTO `abon_area` VALUES ('3161', '366', '海宁');
INSERT INTO `abon_area` VALUES ('3162', '366', '海盐');
INSERT INTO `abon_area` VALUES ('3163', '366', '嘉善');
INSERT INTO `abon_area` VALUES ('3164', '366', '南湖');
INSERT INTO `abon_area` VALUES ('3165', '366', '平湖');
INSERT INTO `abon_area` VALUES ('3166', '366', '桐乡');
INSERT INTO `abon_area` VALUES ('3167', '366', '秀洲');
INSERT INTO `abon_area` VALUES ('3168', '367', '安吉');
INSERT INTO `abon_area` VALUES ('3169', '367', '德清');
INSERT INTO `abon_area` VALUES ('3170', '367', '南浔');
INSERT INTO `abon_area` VALUES ('3171', '367', '吴兴');
INSERT INTO `abon_area` VALUES ('3172', '367', '长兴');
INSERT INTO `abon_area` VALUES ('3173', '368', '柯桥');
INSERT INTO `abon_area` VALUES ('3174', '368', '上虞');
INSERT INTO `abon_area` VALUES ('3175', '368', '嵊州');
INSERT INTO `abon_area` VALUES ('3176', '368', '新昌');
INSERT INTO `abon_area` VALUES ('3177', '368', '越城');
INSERT INTO `abon_area` VALUES ('3178', '368', '诸暨');
INSERT INTO `abon_area` VALUES ('3179', '369', '东阳');
INSERT INTO `abon_area` VALUES ('3180', '369', '金东');
INSERT INTO `abon_area` VALUES ('3181', '369', '兰溪');
INSERT INTO `abon_area` VALUES ('3182', '369', '磐安');
INSERT INTO `abon_area` VALUES ('3183', '369', '浦江');
INSERT INTO `abon_area` VALUES ('3184', '369', '武义');
INSERT INTO `abon_area` VALUES ('3185', '369', '婺城');
INSERT INTO `abon_area` VALUES ('3186', '369', '义乌');
INSERT INTO `abon_area` VALUES ('3187', '369', '永康');
INSERT INTO `abon_area` VALUES ('3188', '370', '常山');
INSERT INTO `abon_area` VALUES ('3189', '370', '江山');
INSERT INTO `abon_area` VALUES ('3190', '370', '开化');
INSERT INTO `abon_area` VALUES ('3191', '370', '柯城');
INSERT INTO `abon_area` VALUES ('3192', '370', '龙游');
INSERT INTO `abon_area` VALUES ('3193', '370', '衢江');
INSERT INTO `abon_area` VALUES ('3194', '371', '岱山');
INSERT INTO `abon_area` VALUES ('3195', '371', '定海');
INSERT INTO `abon_area` VALUES ('3196', '371', '普陀');
INSERT INTO `abon_area` VALUES ('3197', '371', '嵊泗');
INSERT INTO `abon_area` VALUES ('3198', '372', '黄岩');
INSERT INTO `abon_area` VALUES ('3199', '372', '椒江');
INSERT INTO `abon_area` VALUES ('3200', '372', '临海');
INSERT INTO `abon_area` VALUES ('3201', '372', '路桥');
INSERT INTO `abon_area` VALUES ('3202', '372', '三门');
INSERT INTO `abon_area` VALUES ('3203', '372', '天台');
INSERT INTO `abon_area` VALUES ('3204', '372', '温岭');
INSERT INTO `abon_area` VALUES ('3205', '372', '仙居');
INSERT INTO `abon_area` VALUES ('3206', '372', '玉环');
INSERT INTO `abon_area` VALUES ('3207', '373', '缙云');
INSERT INTO `abon_area` VALUES ('3208', '373', '景宁');
INSERT INTO `abon_area` VALUES ('3209', '373', '莲都');
INSERT INTO `abon_area` VALUES ('3210', '373', '龙泉');
INSERT INTO `abon_area` VALUES ('3211', '373', '青田');
INSERT INTO `abon_area` VALUES ('3212', '373', '庆元');
INSERT INTO `abon_area` VALUES ('3213', '373', '松阳');
INSERT INTO `abon_area` VALUES ('3214', '373', '遂昌');
INSERT INTO `abon_area` VALUES ('3215', '373', '云和');
INSERT INTO `abon_area` VALUES ('3216', '374', '巴南');
INSERT INTO `abon_area` VALUES ('3217', '374', '北碚');
INSERT INTO `abon_area` VALUES ('3218', '374', '璧山');
INSERT INTO `abon_area` VALUES ('3219', '374', '城口');
INSERT INTO `abon_area` VALUES ('3220', '374', '大渡口');
INSERT INTO `abon_area` VALUES ('3221', '374', '大足');
INSERT INTO `abon_area` VALUES ('3222', '374', '垫江');
INSERT INTO `abon_area` VALUES ('3223', '374', '丰都');
INSERT INTO `abon_area` VALUES ('3224', '374', '奉节');
INSERT INTO `abon_area` VALUES ('3225', '374', '涪陵');
INSERT INTO `abon_area` VALUES ('3226', '374', '合川');
INSERT INTO `abon_area` VALUES ('3227', '374', '江北');
INSERT INTO `abon_area` VALUES ('3228', '374', '江津');
INSERT INTO `abon_area` VALUES ('3229', '374', '九龙坡');
INSERT INTO `abon_area` VALUES ('3230', '374', '开县');
INSERT INTO `abon_area` VALUES ('3231', '374', '梁平');
INSERT INTO `abon_area` VALUES ('3232', '374', '南岸');
INSERT INTO `abon_area` VALUES ('3233', '374', '南川');
INSERT INTO `abon_area` VALUES ('3234', '374', '彭水');
INSERT INTO `abon_area` VALUES ('3235', '374', '綦江');
INSERT INTO `abon_area` VALUES ('3236', '374', '黔江');
INSERT INTO `abon_area` VALUES ('3237', '374', '荣昌');
INSERT INTO `abon_area` VALUES ('3238', '374', '沙坪坝');
INSERT INTO `abon_area` VALUES ('3239', '374', '石柱');
INSERT INTO `abon_area` VALUES ('3240', '374', '铜梁');
INSERT INTO `abon_area` VALUES ('3241', '374', '潼南');
INSERT INTO `abon_area` VALUES ('3242', '374', '万州');
INSERT INTO `abon_area` VALUES ('3243', '374', '巫山');
INSERT INTO `abon_area` VALUES ('3244', '374', '巫溪');
INSERT INTO `abon_area` VALUES ('3245', '374', '武隆');
INSERT INTO `abon_area` VALUES ('3246', '374', '秀山');
INSERT INTO `abon_area` VALUES ('3247', '374', '永川');
INSERT INTO `abon_area` VALUES ('3248', '374', '酉阳');
INSERT INTO `abon_area` VALUES ('3249', '374', '渝北');
INSERT INTO `abon_area` VALUES ('3250', '374', '渝中');
INSERT INTO `abon_area` VALUES ('3251', '374', '云阳');
INSERT INTO `abon_area` VALUES ('3252', '374', '长寿');
INSERT INTO `abon_area` VALUES ('3253', '374', '忠县');
INSERT INTO `abon_area` VALUES ('3254', '375', '中正区');
INSERT INTO `abon_area` VALUES ('3255', '375', '大同区');
INSERT INTO `abon_area` VALUES ('3256', '375', '中山区 ');
INSERT INTO `abon_area` VALUES ('3257', '375', '松山区 ');
INSERT INTO `abon_area` VALUES ('3258', '375', '大安区 ');
INSERT INTO `abon_area` VALUES ('3259', '375', '万华区');
INSERT INTO `abon_area` VALUES ('3260', '375', '信义区');
INSERT INTO `abon_area` VALUES ('3261', '375', '士林区');
INSERT INTO `abon_area` VALUES ('3262', '375', '北投区');
INSERT INTO `abon_area` VALUES ('3263', '375', '内湖区');
INSERT INTO `abon_area` VALUES ('3264', '375', '南港区');
INSERT INTO `abon_area` VALUES ('3265', '375', '文山区');
INSERT INTO `abon_area` VALUES ('3266', '376', '新兴区 ');
INSERT INTO `abon_area` VALUES ('3267', '376', '前金区');
INSERT INTO `abon_area` VALUES ('3268', '376', '芩雅区');
INSERT INTO `abon_area` VALUES ('3269', '376', '盐埕区');
INSERT INTO `abon_area` VALUES ('3270', '376', '鼓山区');
INSERT INTO `abon_area` VALUES ('3271', '376', '旗津区');
INSERT INTO `abon_area` VALUES ('3272', '376', '前镇区');
INSERT INTO `abon_area` VALUES ('3273', '376', '三民区');
INSERT INTO `abon_area` VALUES ('3274', '376', '左营区');
INSERT INTO `abon_area` VALUES ('3275', '376', '楠梓区');
INSERT INTO `abon_area` VALUES ('3276', '376', '小港区');
INSERT INTO `abon_area` VALUES ('3277', '377', '仁爱区');
INSERT INTO `abon_area` VALUES ('3278', '377', '信义区');
INSERT INTO `abon_area` VALUES ('3279', '377', '中正区');
INSERT INTO `abon_area` VALUES ('3280', '377', '中山区');
INSERT INTO `abon_area` VALUES ('3281', '377', '安乐区');
INSERT INTO `abon_area` VALUES ('3282', '377', '暖暖区');
INSERT INTO `abon_area` VALUES ('3283', '377', '七堵区');
INSERT INTO `abon_area` VALUES ('3284', '378', '中 区');
INSERT INTO `abon_area` VALUES ('3285', '378', '东 区');
INSERT INTO `abon_area` VALUES ('3286', '378', '南 区');
INSERT INTO `abon_area` VALUES ('3287', '378', '西 区 ');
INSERT INTO `abon_area` VALUES ('3288', '378', '北 区 ');
INSERT INTO `abon_area` VALUES ('3289', '378', '北屯区');
INSERT INTO `abon_area` VALUES ('3290', '378', '西屯区');
INSERT INTO `abon_area` VALUES ('3291', '378', '南屯区 ');
INSERT INTO `abon_area` VALUES ('3292', '379', '中西区');
INSERT INTO `abon_area` VALUES ('3293', '379', '东 区');
INSERT INTO `abon_area` VALUES ('3294', '379', '南 区 ');
INSERT INTO `abon_area` VALUES ('3295', '379', '北 区 ');
INSERT INTO `abon_area` VALUES ('3296', '379', '安平区');
INSERT INTO `abon_area` VALUES ('3297', '379', '安南区');
INSERT INTO `abon_area` VALUES ('3298', '380', '东 区');
INSERT INTO `abon_area` VALUES ('3299', '380', '北 区');
INSERT INTO `abon_area` VALUES ('3300', '380', '香山区');
INSERT INTO `abon_area` VALUES ('3301', '381', '东 区 ');
INSERT INTO `abon_area` VALUES ('3302', '381', '西 区');
INSERT INTO `abon_area` VALUES ('3303', '382', '中西区');
INSERT INTO `abon_area` VALUES ('3304', '382', '东区');
INSERT INTO `abon_area` VALUES ('3305', '382', '南区');
INSERT INTO `abon_area` VALUES ('3306', '382', '湾仔区');
INSERT INTO `abon_area` VALUES ('3307', '383', '九龙城区');
INSERT INTO `abon_area` VALUES ('3308', '383', '观塘区');
INSERT INTO `abon_area` VALUES ('3309', '383', '深水埗区');
INSERT INTO `abon_area` VALUES ('3310', '383', '黄大仙区');
INSERT INTO `abon_area` VALUES ('3311', '383', '油尖旺区');
INSERT INTO `abon_area` VALUES ('3312', '384', '离岛区');
INSERT INTO `abon_area` VALUES ('3313', '384', '葵青区');
INSERT INTO `abon_area` VALUES ('3314', '384', '北区');
INSERT INTO `abon_area` VALUES ('3315', '384', '西贡区');
INSERT INTO `abon_area` VALUES ('3316', '384', '沙田区');
INSERT INTO `abon_area` VALUES ('3317', '384', '大埔区');
INSERT INTO `abon_area` VALUES ('3318', '384', '荃湾区');
INSERT INTO `abon_area` VALUES ('3319', '384', '屯门区');
INSERT INTO `abon_area` VALUES ('3320', '384', '元朗区');
INSERT INTO `abon_area` VALUES ('3321', '385', ' 花地玛堂区');
INSERT INTO `abon_area` VALUES ('3322', '385', ' 圣安多尼堂区');
INSERT INTO `abon_area` VALUES ('3323', '385', '大堂区');
INSERT INTO `abon_area` VALUES ('3324', '385', ' 望德堂区');
INSERT INTO `abon_area` VALUES ('3325', '385', ' 风顺堂区');
INSERT INTO `abon_area` VALUES ('3326', '385', ' 嘉模堂区');
INSERT INTO `abon_area` VALUES ('3327', '385', ' 圣方济各堂区');

-- ----------------------------
-- Table structure for `abon_attendance`
-- ----------------------------
DROP TABLE IF EXISTS `abon_attendance`;
CREATE TABLE `abon_attendance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '考勤统计表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `month` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '月份 ',
  `name` varchar(10) NOT NULL COMMENT '姓名',
  `phone` char(11) NOT NULL COMMENT '手机号 (用手机号关联到user表中的id)',
  `late_number` int(10) unsigned NOT NULL COMMENT '迟到次数',
  `late_time` int(10) unsigned NOT NULL COMMENT '迟到分钟',
  `revert_late_number` int(10) unsigned NOT NULL COMMENT '消迟到次数',
  `early_number` int(10) unsigned NOT NULL COMMENT '早退次数',
  `early_time` int(10) unsigned NOT NULL COMMENT '早退分钟数',
  `revert_early_time` int(10) unsigned NOT NULL COMMENT '消早退分钟',
  `out_day` float unsigned NOT NULL COMMENT '外出天数',
  `business_trip` float unsigned NOT NULL COMMENT '出差天数',
  `leave` float unsigned NOT NULL COMMENT '事假天数',
  `leave_sick` float unsigned NOT NULL COMMENT '病假天数',
  `paid_leave` float unsigned NOT NULL COMMENT '带薪假天数',
  `trim_day` float unsigned NOT NULL COMMENT '调休天数',
  `vacation` float unsigned NOT NULL COMMENT '婚假天数',
  `check_leave` float unsigned NOT NULL COMMENT '产检假天数\n',
  `maternity_leave` float unsigned NOT NULL COMMENT '产假天数\n',
  `escort_leave` float unsigned NOT NULL COMMENT '陪产假天数',
  `funeral_leave` float unsigned NOT NULL COMMENT '丧假天数',
  `work_days` float unsigned NOT NULL COMMENT '工作天数',
  `away_work_days` float unsigned NOT NULL COMMENT '旷工天数',
  `true_work_days` float unsigned NOT NULL COMMENT '实际工作天数',
  `true_work_days_vice` float unsigned NOT NULL COMMENT '实际工作天数2  (不包含出差和外出的天数)',
  `work_time` float unsigned NOT NULL COMMENT '正常工作时长',
  `true_work_time` float unsigned NOT NULL COMMENT '工作时长',
  `overtime` float unsigned NOT NULL COMMENT '加班时长',
  `trim_overtime` float unsigned NOT NULL COMMENT '调休加班时长',
  `overtime_salary` float unsigned NOT NULL COMMENT '工资加班时长',
  `overtime_home` float unsigned NOT NULL COMMENT '在家加班',
  `overtime_day` int(10) unsigned NOT NULL COMMENT '20点以后下班',
  `info` varchar(225) NOT NULL COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `month` (`month`),
  KEY `phone` (`phone`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_attendance
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_business_origin`
-- ----------------------------
DROP TABLE IF EXISTS `abon_business_origin`;
CREATE TABLE `abon_business_origin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '业务来源表',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `name` varchar(45) NOT NULL COMMENT '业务来源名称',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at   软删除时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_business_origin
-- ----------------------------
INSERT INTO `abon_business_origin` VALUES ('3', '2016-08-23 16:59:09', '0', '1', '其他', '2016-08-23 16:59:09', '0000-00-00 00:00:00');
INSERT INTO `abon_business_origin` VALUES ('4', '2016-08-23 17:01:33', '0', '1', '其他', '2016-08-23 17:01:33', '0000-00-00 00:00:00');
INSERT INTO `abon_business_origin` VALUES ('5', '2016-08-23 17:16:27', '0', '1', '其他', null, null);
INSERT INTO `abon_business_origin` VALUES ('6', null, '0', '1', '', null, null);

-- ----------------------------
-- Table structure for `abon_business_type`
-- ----------------------------
DROP TABLE IF EXISTS `abon_business_type`;
CREATE TABLE `abon_business_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '业务类型表id',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `name` varchar(45) NOT NULL COMMENT '业务类型名称',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_business_type
-- ----------------------------
INSERT INTO `abon_business_type` VALUES ('1', '2016-08-22 11:49:38', '0', '1', '电商网站', '2016-08-22 11:46:12', '0000-00-00 00:00:00');
INSERT INTO `abon_business_type` VALUES ('2', '2016-08-22 11:49:43', '0', '1', '企业网站', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `abon_business_type` VALUES ('3', '2016-08-22 14:03:03', '0', '1', '功能网站', '2016-08-22 12:05:00', '0000-00-00 00:00:00');
INSERT INTO `abon_business_type` VALUES ('4', '2016-08-22 14:03:31', '0', '1', '论坛网站', '2016-08-22 12:05:00', '0000-00-00 00:00:00');
INSERT INTO `abon_business_type` VALUES ('5', '2016-08-22 14:03:42', '0', '1', 'app', '2016-08-22 12:05:00', '0000-00-00 00:00:00');
INSERT INTO `abon_business_type` VALUES ('6', '2016-08-22 14:03:53', '0', '1', 'webApp', '2016-08-22 12:05:00', '0000-00-00 00:00:00');
INSERT INTO `abon_business_type` VALUES ('7', '2016-08-22 16:24:58', '0', '1', '旅游网站', '2016-08-22 12:05:00', '0000-00-00 00:00:00');
INSERT INTO `abon_business_type` VALUES ('8', '2016-08-22 12:05:00', '0', '1', '企业网站', '2016-08-22 12:05:00', '0000-00-00 00:00:00');
INSERT INTO `abon_business_type` VALUES ('9', '2016-08-22 12:05:00', '0', '1', '企业网站', '2016-08-22 12:05:00', '0000-00-00 00:00:00');
INSERT INTO `abon_business_type` VALUES ('10', '2016-08-22 13:29:12', '0', '1', '企业网站', '2016-08-22 13:29:12', '0000-00-00 00:00:00');
INSERT INTO `abon_business_type` VALUES ('11', '2016-08-22 14:09:19', '0', '1', '企业网站', '2016-08-22 14:09:19', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `abon_company`
-- ----------------------------
DROP TABLE IF EXISTS `abon_company`;
CREATE TABLE `abon_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '公司表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `name` varchar(45) NOT NULL COMMENT '公司名',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `super_id` (`super_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_company
-- ----------------------------
INSERT INTO `abon_company` VALUES ('1', '2016-08-23 16:57:28', '1', '213', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `abon_company` VALUES ('2', '2016-08-23 16:57:29', '0', '213', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `abon_company_power`
-- ----------------------------
DROP TABLE IF EXISTS `abon_company_power`;
CREATE TABLE `abon_company_power` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '公司的权限表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `name` varchar(15) NOT NULL COMMENT '权限名',
  `power_list_id` varchar(255) NOT NULL COMMENT '权限列表 ( 关联sys_power_list表的id的json集合)  [必须 是super_power对应的超级管理员有的权限]',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_company_power
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_consume`
-- ----------------------------
DROP TABLE IF EXISTS `abon_consume`;
CREATE TABLE `abon_consume` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '报销记录表(审核通过后写入account_run表中)',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '报销人员',
  `content` varchar(255) NOT NULL COMMENT '报销事项',
  `money` decimal(9,2) unsigned NOT NULL COMMENT '报销金额',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0:未审核 ; 1: 已审核通过; 2:未通过)',
  `examine_id` int(10) unsigned NOT NULL COMMENT '审核者id(关联user表的id)',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_consume
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_coustomer_log`
-- ----------------------------
DROP TABLE IF EXISTS `abon_coustomer_log`;
CREATE TABLE `abon_coustomer_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '客户记录表',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `customer_id` int(10) unsigned NOT NULL COMMENT '客户id(关联customer表的id)',
  `make_id` int(10) unsigned NOT NULL COMMENT '操作者id(对应user表的id)【写入此记录的user_id】',
  `type` tinyint(1) unsigned NOT NULL COMMENT '记录类型(1:建项; 2:领取;3:分配；4：转移)',
  `project_id` int(10) unsigned NOT NULL COMMENT '建项者id(对应user表的id)',
  `allot_id` int(10) unsigned NOT NULL COMMENT '分配给user的id(对应user表的id)',
  `get_id` int(10) unsigned NOT NULL COMMENT '领取者id(对应user表的id)',
  `remove_id` int(10) unsigned NOT NULL COMMENT '转出者id(对应user表的id)',
  `receive_id` int(10) unsigned NOT NULL COMMENT '转入者id(对应user表的id)',
  `examine` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是不通过审核(0:未审核;1:审核;2:未通过;3:不需要审核)',
  `examine_id` int(10) unsigned NOT NULL COMMENT '审核者id(关联user表的id)',
  `examine_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_coustomer_log
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_customer`
-- ----------------------------
DROP TABLE IF EXISTS `abon_customer`;
CREATE TABLE `abon_customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '客户资料表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '客户类型(1:公海客户;2:私人客户; 3:已立项)',
  `number` varchar(45) NOT NULL COMMENT '客户编号',
  `name` varchar(10) NOT NULL COMMENT '客户姓名',
  `company` varchar(45) NOT NULL COMMENT '公司名称',
  `phone` char(11) NOT NULL COMMENT '手机',
  `email` varchar(45) NOT NULL COMMENT '邮箱',
  `offer` varchar(45) NOT NULL COMMENT '报价',
  `type_id` int(10) unsigned NOT NULL COMMENT '业务类型  ( 关联business_type表id)',
  `developer_id` int(10) unsigned NOT NULL COMMENT '开发人员(关联user表的id)',
  `salesman_id` int(10) unsigned NOT NULL COMMENT '业务员 (关联user表的id)',
  `customer_state_id` int(10) unsigned NOT NULL COMMENT '状态(关联customer_state的id)',
  `origin_id` int(10) unsigned NOT NULL COMMENT '业务来源(对应business_orgin表的id)',
  `change` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是正在转移中的项目(0:不是; 1:  转移中)',
  `lose` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否丢单(0:丢单;1: 正常)',
  `lose_id` int(10) unsigned NOT NULL COMMENT '上次丢单人员id(对应user表中的超级管理员的id)',
  `province` int(10) unsigned NOT NULL COMMENT '省(关联area表的id)',
  `city` int(10) unsigned NOT NULL COMMENT '市(关联area表的id)',
  `county` int(10) unsigned NOT NULL COMMENT '县(关联area表的id)',
  `address` varchar(45) NOT NULL COMMENT '地址',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`),
  KEY `name` (`company_id`,`type`,`name`),
  KEY `phone` (`company_id`,`type`,`phone`),
  KEY `state` (`company_id`,`type`,`customer_state_id`),
  KEY `created_at` (`company_id`,`type`,`created_at`),
  KEY `number` (`company_id`,`type`,`number`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_customer
-- ----------------------------
INSERT INTO `abon_customer` VALUES ('1', '2016-08-22 16:46:58', '0', '1', '1', 'ABON1471855619', '山姆·沃尔顿', '沃尔玛（WAL-MART STORES）', '18708156629', '460868361@qq.com', '19000.00', '1', '2', '0', '0', '1', '0', '1', '0', '25', '303', '2627', '金牛区荷花池150号', '2016-08-22 14:38:25', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `abon_customer_dynamic`
-- ----------------------------
DROP TABLE IF EXISTS `abon_customer_dynamic`;
CREATE TABLE `abon_customer_dynamic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '客户动态表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `customer_id` int(10) unsigned NOT NULL COMMENT '客户id(关联customer表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '操作者id(关联user表的id)',
  `content` varchar(255) NOT NULL COMMENT '最新动态内容',
  `next_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '下次跟进时间',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at   软删除时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_customer_dynamic
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_customer_state`
-- ----------------------------
DROP TABLE IF EXISTS `abon_customer_state`;
CREATE TABLE `abon_customer_state` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '客户状态表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `name` varchar(15) NOT NULL COMMENT '客户状态',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at   软删除时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_customer_state
-- ----------------------------
INSERT INTO `abon_customer_state` VALUES ('1', '2016-08-22 15:24:14', '0', '1', '待分配', '2016-08-22 15:24:14', '0000-00-00 00:00:00');
INSERT INTO `abon_customer_state` VALUES ('2', '2016-08-22 16:37:56', '0', '1', '已分配', '2016-08-22 16:36:15', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `abon_data`
-- ----------------------------
DROP TABLE IF EXISTS `abon_data`;
CREATE TABLE `abon_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '资料表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id (关联user表的id)',
  `department_id` int(10) unsigned NOT NULL COMMENT '部门 (对应department表的id)',
  `description` varchar(255) NOT NULL COMMENT '资料简介',
  `content` varchar(255) NOT NULL COMMENT '资料内容',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `department_id` (`company_id`,`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_data
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_department`
-- ----------------------------
DROP TABLE IF EXISTS `abon_department`;
CREATE TABLE `abon_department` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '公司部门表 ',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `name` varchar(20) NOT NULL COMMENT '部门名称',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `super_id` (`super_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_department
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_goods`
-- ----------------------------
DROP TABLE IF EXISTS `abon_goods`;
CREATE TABLE `abon_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '积分商品表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `title` varchar(45) NOT NULL COMMENT '商品标题',
  `shorttitle` varchar(45) NOT NULL COMMENT '缩略标题',
  `integral` int(10) unsigned NOT NULL COMMENT '商总兑换积分数',
  `number` int(11) NOT NULL DEFAULT '-1' COMMENT '库存(有符号)  -1:无限',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `description` varchar(255) NOT NULL COMMENT '简介',
  `body` text NOT NULL COMMENT '商品详情',
  `litpic` varchar(255) NOT NULL COMMENT '商品封面图片',
  `is_up` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架（1：上架；0：下架）',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_goods_order`
-- ----------------------------
DROP TABLE IF EXISTS `abon_goods_order`;
CREATE TABLE `abon_goods_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品订单表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id(对应user表的id)',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `order_title` varchar(45) NOT NULL COMMENT '商品标题',
  `integral` int(10) unsigned NOT NULL COMMENT '兑换积分',
  `number` int(10) unsigned NOT NULL COMMENT '兑换数量',
  `total_integral` int(10) unsigned NOT NULL COMMENT '兑换总积分',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `goods_id` (`goods_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_goods_order
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_grade`
-- ----------------------------
DROP TABLE IF EXISTS `abon_grade`;
CREATE TABLE `abon_grade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '职称等级表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `name` varchar(15) NOT NULL COMMENT '职称名',
  `grade` tinyint(2) unsigned NOT NULL COMMENT '等级',
  `experience` int(10) unsigned NOT NULL COMMENT '升级经验',
  `rebate` float unsigned NOT NULL DEFAULT '10' COMMENT '积分折扣（如：8.5）',
  `bonus` float unsigned NOT NULL DEFAULT '0' COMMENT '薪资提成',
  `gift` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '生日礼物（0：无；1：有）',
  `power` float unsigned NOT NULL DEFAULT '0' COMMENT '期权（如：2：2%）',
  `social` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '社保（0： 无；1：有）',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`),
  KEY `super_id` (`super_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_grade
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_honor`
-- ----------------------------
DROP TABLE IF EXISTS `abon_honor`;
CREATE TABLE `abon_honor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '荣誉榜',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id(对应user表的id)',
  `issue_id` int(10) unsigned NOT NULL COMMENT '颁发者id(对应user表的id)',
  `name` varchar(45) NOT NULL COMMENT '荣誉名称',
  `litpic` varchar(255) NOT NULL COMMENT '荣誉头像地址',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '荣誉类型( 0:无积分奖励;   1: 有积分奖励 )',
  `integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分奖励数量  ',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_honor
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_integral_log`
-- ----------------------------
DROP TABLE IF EXISTS `abon_integral_log`;
CREATE TABLE `abon_integral_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '积分记录表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户的id(关联user表的id)',
  `type` tinyint(1) DEFAULT NULL COMMENT '积分类型（1：正常增加；2：消费；3：奖励；4：处罚）',
  `integral` int(10) unsigned NOT NULL COMMENT '积分数量',
  `description` varchar(255) NOT NULL COMMENT '描述(处罚原因)',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_integral_log
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_notice`
-- ----------------------------
DROP TABLE IF EXISTS `abon_notice`;
CREATE TABLE `abon_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '通知表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '通告者用户id(对应user表的id)',
  `department_id` varchar(255) NOT NULL COMMENT '部门 (对应department表的id的json集合)【0：全体】',
  `content` varchar(255) NOT NULL COMMENT '通知内容',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_object`
-- ----------------------------
DROP TABLE IF EXISTS `abon_object`;
CREATE TABLE `abon_object` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '业务员的id',
  `customer_id` int(10) unsigned NOT NULL COMMENT '客户基本资料(对应customer表的id)',
  `agreement_number` varchar(45) NOT NULL COMMENT '合同编号',
  `object_status_id` tinyint(3) unsigned NOT NULL COMMENT '项目状态(关联object_status的id)',
  `price` decimal(9,2) unsigned NOT NULL COMMENT '成交价',
  `is_invoice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开发票（0：不开；1：开具）',
  `payment_ratio` varchar(15) NOT NULL COMMENT '付款比例（此处的值读取的是payment_ratio表中的值， 但不关联）',
  `record` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已备案（0：未备案；1：已备案）',
  `record_file` varchar(255) NOT NULL COMMENT '网站备案资料',
  `developer_file` varchar(255) NOT NULL COMMENT '网站开发资料',
  `description` mediumtext NOT NULL COMMENT '项目描述',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_object
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_object_status`
-- ----------------------------
DROP TABLE IF EXISTS `abon_object_status`;
CREATE TABLE `abon_object_status` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目状态表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `value` varchar(15) NOT NULL COMMENT '状态名',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_object_status
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_object_user`
-- ----------------------------
DROP TABLE IF EXISTS `abon_object_user`;
CREATE TABLE `abon_object_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目实施人员表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `object_id` int(10) unsigned NOT NULL COMMENT '项目id(对应object表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '实施人员（关联user表的id ）',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型(1:普通 ; 2: 替换他人的项目)',
  `is_leader` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是组长（0：不 是；1： 是）',
  `score` tinyint(1) unsigned NOT NULL COMMENT '评分（1：A，2：B，3：C，4：D，5：E【做的差换人】，6：因事换人）',
  `replace_user_id` int(10) unsigned NOT NULL COMMENT '替换的实施人员id（关联user表的id ）',
  `bereplace_user_id` int(10) unsigned NOT NULL COMMENT '被替换的实施人员id（关联user表的id ）',
  `is_bonus` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否可以提成 (0:不提成 ;  1:可以提成)  [score评分为5时,不可以提成,]',
  `bonus_type` tinyint(1) unsigned NOT NULL COMMENT '提成比例类型(1:采用公司对每个员工制定的提成比例; 2:在当前部门提成总比例中按比例提成; 3:按单独的提成比例提成)',
  `bonus` float unsigned NOT NULL COMMENT '提成比例',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_object_user
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_object_vice`
-- ----------------------------
DROP TABLE IF EXISTS `abon_object_vice`;
CREATE TABLE `abon_object_vice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目副表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `object_id` int(10) unsigned NOT NULL COMMENT '项目id(对应object表的id)',
  `customer_id` int(10) unsigned NOT NULL COMMENT '客户基本资料(对应customer表的id)',
  `department_id` int(10) unsigned NOT NULL COMMENT '部门 (对应department表的id)',
  `start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `examine_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '定稿时间',
  `true_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '实际开始时间',
  `true_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '实际结束时间',
  `true_examine_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '实际定稿时间',
  `description` varchar(255) NOT NULL COMMENT '备注',
  `bonus` float unsigned NOT NULL COMMENT '提成总比例',
  `finish` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否完成(0:未完成;1:已完成)',
  `file` varchar(255) NOT NULL COMMENT '文件资料',
  `confirm_file` varchar(255) NOT NULL COMMENT '确定涵',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_object_vice
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_payment_ratio`
-- ----------------------------
DROP TABLE IF EXISTS `abon_payment_ratio`;
CREATE TABLE `abon_payment_ratio` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '付款比例表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `value` varchar(15) NOT NULL COMMENT '付款比例值（形式：3:4:3）',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_payment_ratio
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_power_group`
-- ----------------------------
DROP TABLE IF EXISTS `abon_power_group`;
CREATE TABLE `abon_power_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '职位权限分组表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `name` varchar(45) NOT NULL COMMENT '职位名称',
  `power_id` varchar(255) NOT NULL COMMENT '权限 ( 关联sys_power_list表的id的json集合) [必须 是aompany_power对应公司有的权限]',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_power_group
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_sort`
-- ----------------------------
DROP TABLE IF EXISTS `abon_sort`;
CREATE TABLE `abon_sort` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '排行榜表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `name` varchar(45) NOT NULL COMMENT '排行榜名称',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id(对应user表的id)',
  `department_id` int(10) unsigned NOT NULL COMMENT '部门 (对应department表的id)',
  `sort_sysconfig_id` int(10) unsigned NOT NULL COMMENT '统计的方式(对应sort_sysconfig表的id )',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '时期',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型(1:月度 ;2 :年度)',
  `sort` tinyint(1) unsigned NOT NULL COMMENT '排行',
  `prize` varchar(255) NOT NULL COMMENT '奖品',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `department_id` (`company_id`,`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_sort
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_sort_prize`
-- ----------------------------
DROP TABLE IF EXISTS `abon_sort_prize`;
CREATE TABLE `abon_sort_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '排行奖品表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `department_id` int(10) unsigned NOT NULL COMMENT '部门 (对应department表的id)  (为0时,全部部门)',
  `type` tinyint(1) unsigned NOT NULL COMMENT '类型(1:月度 ;2 :年度)',
  `sort` tinyint(1) unsigned NOT NULL COMMENT '排行',
  `prize` varchar(255) NOT NULL COMMENT '奖品',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `department_id` (`company_id`,`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_sort_prize
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_sort_sysconfig`
-- ----------------------------
DROP TABLE IF EXISTS `abon_sort_sysconfig`;
CREATE TABLE `abon_sort_sysconfig` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '排行统计项目项表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `department_id` int(10) unsigned NOT NULL COMMENT '部门 (对应department表的id)',
  `sys_sort_id` varchar(255) NOT NULL COMMENT '排行栏目id (对应sys_sort表的id的json集合)',
  `type` varchar(255) DEFAULT NULL COMMENT '排行统计方式(对应sys_sort_type表的id的json集合)[与sys_sort_id一一对应]',
  `name` varchar(45) NOT NULL COMMENT '排行榜名称',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `department_id` (`company_id`,`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_sort_sysconfig
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_super_power`
-- ----------------------------
DROP TABLE IF EXISTS `abon_super_power`;
CREATE TABLE `abon_super_power` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '超级管理员的权限表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `name` varchar(15) DEFAULT NULL COMMENT '权限名',
  `power_list_id` varchar(45) DEFAULT NULL COMMENT '权限 ( 关联sys_power_list表的id的json集合) ',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `super_id` (`super_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_super_power
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_sysconfig`
-- ----------------------------
DROP TABLE IF EXISTS `abon_sysconfig`;
CREATE TABLE `abon_sysconfig` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '系统配置表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `varname` varchar(255) NOT NULL COMMENT '配置的name',
  `info` varchar(255) NOT NULL COMMENT '简介 ',
  `value` mediumtext NOT NULL COMMENT '内容，值',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_sysconfig
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_sys_list`
-- ----------------------------
DROP TABLE IF EXISTS `abon_sys_list`;
CREATE TABLE `abon_sys_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '系统栏目表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `name` varchar(20) NOT NULL COMMENT '栏目name',
  `type_id` int(10) unsigned NOT NULL COMMENT '上级栏目的id(一级栏目的type_id为0;其他 的为对应上级栏目的id);',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_sys_list
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_sys_power_list`
-- ----------------------------
DROP TABLE IF EXISTS `abon_sys_power_list`;
CREATE TABLE `abon_sys_power_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '系统表权限栏目列表   [系统所有的权限都在sys_power_list中,管理员在power_group表中设置不同的权限组]',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `name` varchar(15) NOT NULL COMMENT '权限栏目名',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_sys_power_list
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_sys_sort`
-- ----------------------------
DROP TABLE IF EXISTS `abon_sys_sort`;
CREATE TABLE `abon_sys_sort` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '系统 排行栏目',
  `name` varchar(45) NOT NULL COMMENT '排行栏目页面显示名称',
  `table` varchar(45) NOT NULL COMMENT '表',
  `field` varchar(45) NOT NULL COMMENT '字段',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_sys_sort
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_sys_sort_type`
-- ----------------------------
DROP TABLE IF EXISTS `abon_sys_sort_type`;
CREATE TABLE `abon_sys_sort_type` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT COMMENT '排行统计方式',
  `name` varchar(45) DEFAULT NULL COMMENT '排行统计方式的名称(如: 求和/平均数)',
  `value` varchar(45) DEFAULT NULL COMMENT '排行统计方式的值(如: sum/agv)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_sys_sort_type
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_user`
-- ----------------------------
DROP TABLE IF EXISTS `abon_user`;
CREATE TABLE `abon_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '账号表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `username` char(11) NOT NULL COMMENT '用户名',
  `real_name` varchar(11) NOT NULL COMMENT '真实姓名',
  `number` varchar(45) NOT NULL COMMENT '员工编号 ',
  `password` char(32) NOT NULL COMMENT '密码',
  `password_salt` char(32) NOT NULL COMMENT 'salt字段',
  `department_id` int(10) unsigned NOT NULL COMMENT '部门 (对应department表的id)',
  `is_super` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是超级管理员(0:不是[默认];1: 是)',
  `is_company` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是公司管理员(0:不是[默认];1: 是)',
  `is_developer` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是客户开发人员(1: 是;0 否)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否在职（0：离职；1：在职;  2:冻结）',
  `integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `experience` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '经验',
  `grade` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '账号等级',
  `power_group_id` int(10) unsigned NOT NULL COMMENT '权限组(对应power_group的id)',
  `head_portrait` varchar(255) NOT NULL COMMENT '头像',
  `bonus` float unsigned NOT NULL DEFAULT '0' COMMENT '公司制定的员工提成比例',
  `company_number` tinyint(1) unsigned NOT NULL COMMENT '可以创建的公司数量',
  `company_true_number` tinyint(1) unsigned NOT NULL COMMENT '已经创建的公司数量',
  `phone` char(11) NOT NULL COMMENT '手机',
  `email` varchar(45) NOT NULL COMMENT '邮箱',
  `sex` tinyint(1) unsigned NOT NULL COMMENT '性别 (1:男;2:女;  3: 保密)',
  `birthday` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '员工生日',
  `entry` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '入职时间',
  `created_id` int(10) unsigned NOT NULL COMMENT '创建者id(关联user表的id)',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_user
-- ----------------------------
INSERT INTO `abon_user` VALUES ('1', '2016-08-22 18:23:05', '0', '1', '18708156629', '补中松', 'abon0001', '7a7e6fb17ea3b1d98d0ab521ca9d95f3', 'd185e6b3299197a0033886cd816f75c1', '0', '0', '0', '0', '1', '0', '0', '1', '1', '', '0', '0', '0', '18708156629', '460868361@qq.com', '1', '2016-08-22 18:23:05', '0000-00-00 00:00:00', '0', '2016-08-22 18:23:05', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `abon_work`
-- ----------------------------
DROP TABLE IF EXISTS `abon_work`;
CREATE TABLE `abon_work` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '工作任务表 ',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '任务人员id（关联user表的id ）',
  `make_id` int(10) unsigned NOT NULL COMMENT '任务指派者id(关联user表的id)',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '任务来源(1:新任务; 2:转入任务)',
  `department_id` int(10) unsigned NOT NULL COMMENT '部门 (对应department表的id)',
  `urgency` tinyint(1) unsigned NOT NULL COMMENT '紧急程序(1:;2:;3:;4:;5:;6:;7:;8:;9:;) [待定]',
  `integral` int(10) unsigned NOT NULL COMMENT '积分数量',
  `actual_integral` int(10) unsigned NOT NULL COMMENT '任务完成后的实得的积分',
  `description` varchar(255) NOT NULL COMMENT '任务简述',
  `file` varchar(255) NOT NULL COMMENT '文件资料',
  `finish_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '完成时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:任务有效; 0 :任务已转出)',
  `remove_id` int(11) NOT NULL COMMENT '转出者id(对应user表的id)(type为2时, 有效)',
  `receive_id` int(11) NOT NULL COMMENT '转入者id(对应user表的id)( status为0时,有效)',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_work
-- ----------------------------

-- ----------------------------
-- Table structure for `abon_work_order`
-- ----------------------------
DROP TABLE IF EXISTS `abon_work_order`;
CREATE TABLE `abon_work_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '工单表',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated_at    更新时间',
  `super_id` int(10) unsigned NOT NULL COMMENT '超级管理员的id(对应user表中的超级管理员的id)',
  `company_id` int(10) unsigned NOT NULL COMMENT '公司id(对应company表的id)',
  `user_id` int(10) unsigned NOT NULL COMMENT '编写员(关联user表的id ）',
  `number` varchar(45) NOT NULL COMMENT '工单编号',
  `name` varchar(10) NOT NULL COMMENT '客户姓名',
  `company_name` varchar(45) NOT NULL COMMENT '公司名称',
  `type_id` tinyint(3) unsigned NOT NULL COMMENT '业务类型  ( 关联business_type表id)',
  `description` varchar(255) NOT NULL COMMENT '项目描述',
  `type` varchar(255) NOT NULL COMMENT '更改类型, 对应各个部门, 由部长审核; (对应department表的id的json集) ',
  `examine` varchar(255) NOT NULL COMMENT '是否已审核 ;  递归的对应type字段中的json数组关系;  数组值为1:通过;  0 :未通过;',
  `content` text NOT NULL COMMENT '回复内容;递归的对应type字段中的json数组关系;  ',
  `total_examine` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已通过全部的审核(0:未审核 ;  1:已审核)',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at   创建时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'deleted_at  软删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `number` (`number`),
  KEY `name` (`name`),
  KEY `company_name` (`company_name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of abon_work_order
-- ----------------------------
