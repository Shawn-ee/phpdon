-- MySQL dump 10.13  Distrib 5.7.40, for Linux (x86_64)
--
-- Host: localhost    Database: cs_cndjspa_top
-- ------------------------------------------------------
-- Server version	5.7.40-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ims_massage_add_clock_setting`
--

DROP TABLE IF EXISTS `ims_massage_add_clock_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_add_clock_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `times` int(11) DEFAULT '1',
  `balance` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_add_clock_setting`
--

LOCK TABLES `ims_massage_add_clock_setting` WRITE;
/*!40000 ALTER TABLE `ims_massage_add_clock_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_add_clock_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_aliyun_phone_config`
--

DROP TABLE IF EXISTS `ims_massage_aliyun_phone_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_aliyun_phone_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pool_key` varchar(128) DEFAULT '' COMMENT '号码池',
  `virtual_status` tinyint(3) DEFAULT '0',
  `reminder_public` tinyint(3) DEFAULT '0' COMMENT '语音通知 专属模式 1公共模式',
  `reminder_tmpl_id` varchar(64) DEFAULT '' COMMENT '语音通知模版id',
  `reminder_phone` varchar(32) DEFAULT '' COMMENT '语音通知电话',
  `reminder_status` tinyint(3) DEFAULT '0' COMMENT '语音通知开关',
  `reminder_timing` int(255) DEFAULT '0' COMMENT '语音通知定时任务',
  `reminder_admin_status` tinyint(3) DEFAULT '0' COMMENT '来电提醒是否通知管理员',
  `reminder_admin_phone` text,
  `notice_agent` tinyint(3) DEFAULT '0' COMMENT '是否通知代理商',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_aliyun_phone_config`
--

LOCK TABLES `ims_massage_aliyun_phone_config` WRITE;
/*!40000 ALTER TABLE `ims_massage_aliyun_phone_config` DISABLE KEYS */;
INSERT INTO `ims_massage_aliyun_phone_config` VALUES (2,666,'',0,0,'','',0,0,0,NULL,0);
/*!40000 ALTER TABLE `ims_massage_aliyun_phone_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_aliyun_phone_record`
--

DROP TABLE IF EXISTS `ims_massage_aliyun_phone_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_aliyun_phone_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `subs_id` varchar(64) DEFAULT '',
  `phone_a` varchar(32) DEFAULT '',
  `phone_b` varchar(32) DEFAULT '',
  `phone_x` varchar(32) DEFAULT '',
  `expire_date` bigint(11) DEFAULT '0',
  `status` bigint(11) DEFAULT '1',
  `need_record` tinyint(3) DEFAULT '1',
  `pool_key` varchar(255) DEFAULT '',
  `order_id` int(11) DEFAULT '0',
  `order_code` varchar(255) DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  `text` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_aliyun_phone_record`
--

LOCK TABLES `ims_massage_aliyun_phone_record` WRITE;
/*!40000 ALTER TABLE `ims_massage_aliyun_phone_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_aliyun_phone_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_aliyun_play_record`
--

DROP TABLE IF EXISTS `ims_massage_aliyun_play_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_aliyun_play_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `pool_key` varchar(128) DEFAULT '',
  `phone_x` varchar(32) DEFAULT '' COMMENT '虚拟号码',
  `phone_a` varchar(32) DEFAULT '',
  `phone_b` varchar(32) DEFAULT '',
  `call_time` bigint(11) DEFAULT NULL COMMENT '拨打时间',
  `start_time` bigint(11) DEFAULT '0' COMMENT '接起时间',
  `end_time` bigint(11) DEFAULT '0' COMMENT '挂断时间',
  `record_url` varchar(255) DEFAULT NULL COMMENT '放音录音URL',
  `ring_record_url` varchar(255) DEFAULT NULL COMMENT '放音录音URL',
  `call_id` varchar(64) DEFAULT '' COMMENT '话记录ID',
  `sub_id` varchar(64) DEFAULT '' COMMENT '关系',
  `out_id` varchar(128) DEFAULT '',
  `call_type` int(11) DEFAULT '0' COMMENT '呼叫类型。取值：0：主叫，即phone_no打给peer_no。1：被叫，即peer_no打给phone_no。4：呼叫拦截。',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_aliyun_play_record`
--

LOCK TABLES `ims_massage_aliyun_play_record` WRITE;
/*!40000 ALTER TABLE `ims_massage_aliyun_play_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_aliyun_play_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_aliyun_reminder_record`
--

DROP TABLE IF EXISTS `ims_massage_aliyun_reminder_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_aliyun_reminder_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `create_time` bigint(11) DEFAULT '0',
  `res` text COMMENT '通知结果',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1059 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_aliyun_reminder_record`
--

LOCK TABLES `ims_massage_aliyun_reminder_record` WRITE;
/*!40000 ALTER TABLE `ims_massage_aliyun_reminder_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_aliyun_reminder_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_article_connect`
--

DROP TABLE IF EXISTS `ims_massage_article_connect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_article_connect` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT '0',
  `field_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_article_connect`
--

LOCK TABLES `ims_massage_article_connect` WRITE;
/*!40000 ALTER TABLE `ims_massage_article_connect` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_article_connect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_article_form_field`
--

DROP TABLE IF EXISTS `ims_massage_article_form_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_article_form_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `field_type` int(11) DEFAULT '1',
  `title` varchar(128) CHARACTER SET utf8mb4 DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `top` int(11) DEFAULT '0',
  `is_required` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_article_form_field`
--

LOCK TABLES `ims_massage_article_form_field` WRITE;
/*!40000 ALTER TABLE `ims_massage_article_form_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_article_form_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_article_list`
--

DROP TABLE IF EXISTS `ims_massage_article_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_article_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `text` longtext CHARACTER SET utf8mb4,
  `is_form` tinyint(3) DEFAULT '0',
  `top` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_article_list`
--

LOCK TABLES `ims_massage_article_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_article_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_article_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_article_sub_data`
--

DROP TABLE IF EXISTS `ims_massage_article_sub_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_article_sub_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sub_id` int(11) DEFAULT '0',
  `field_id` int(11) DEFAULT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 DEFAULT '',
  `value` varchar(1024) CHARACTER SET utf8mb4 DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `field_type` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_article_sub_data`
--

LOCK TABLES `ims_massage_article_sub_data` WRITE;
/*!40000 ALTER TABLE `ims_massage_article_sub_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_article_sub_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_article_sub_list`
--

DROP TABLE IF EXISTS `ims_massage_article_sub_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_article_sub_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_time` bigint(11) DEFAULT '0',
  `article_id` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_article_sub_list`
--

LOCK TABLES `ims_massage_article_sub_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_article_sub_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_article_sub_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_channel_cate`
--

DROP TABLE IF EXISTS `ims_massage_channel_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_channel_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='渠道商分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_channel_cate`
--

LOCK TABLES `ims_massage_channel_cate` WRITE;
/*!40000 ALTER TABLE `ims_massage_channel_cate` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_channel_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_channel_list`
--

DROP TABLE IF EXISTS `ims_massage_channel_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_channel_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4,
  `sh_text` text CHARACTER SET utf8mb4,
  `sh_time` bigint(11) DEFAULT '0',
  `user_name` varchar(255) CHARACTER SET utf8mb4 DEFAULT '',
  `mobile` varchar(32) DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='渠道商';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_channel_list`
--

LOCK TABLES `ims_massage_channel_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_channel_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_channel_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_coach_time_log`
--

DROP TABLE IF EXISTS `ims_massage_coach_time_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_coach_time_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `start_time` varchar(32) DEFAULT '',
  `end_time` varchar(32) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `date` varchar(32) DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  `is_work` int(11) DEFAULT '0',
  `is_admin` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=892 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_coach_time_log`
--

LOCK TABLES `ims_massage_coach_time_log` WRITE;
/*!40000 ALTER TABLE `ims_massage_coach_time_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_coach_time_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_coach_work_log`
--

DROP TABLE IF EXISTS `ims_massage_coach_work_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_coach_work_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `date` varchar(11) DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  `time` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `true_time` bigint(11) DEFAULT '0',
  `start_time` varchar(32) DEFAULT '',
  `end_time` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `coach_id` (`coach_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=381357 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_coach_work_log`
--

LOCK TABLES `ims_massage_coach_work_log` WRITE;
/*!40000 ALTER TABLE `ims_massage_coach_work_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_coach_work_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_code`
--

DROP TABLE IF EXISTS `ims_massage_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `code` varchar(50) NOT NULL COMMENT '激活码',
  `phone` int(11) NOT NULL COMMENT '手机号',
  `money` int(10) NOT NULL COMMENT '金额',
  `state` int(2) NOT NULL COMMENT '状态 1未使用 2已使用',
  `type` int(2) NOT NULL COMMENT '类型 1抖音',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  `change_time` datetime DEFAULT NULL COMMENT '使用时间',
  `is_delete` int(2) DEFAULT '0' COMMENT '0正常 1失效',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_code`
--

LOCK TABLES `ims_massage_code` WRITE;
/*!40000 ALTER TABLE `ims_massage_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_config`
--

DROP TABLE IF EXISTS `ims_massage_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `dynamic_check` tinyint(3) DEFAULT '1' COMMENT '1手动审核 2自动',
  `dynamic_comment_check` tinyint(3) DEFAULT '1',
  `recommend_style` tinyint(3) DEFAULT '1' COMMENT '推荐技师样式',
  `app_download_img` varchar(255) DEFAULT '' COMMENT 'app下载图片',
  `android_link` varchar(255) DEFAULT '' COMMENT '安卓下载链接',
  `ios_link` varchar(255) DEFAULT '' COMMENT 'ios下载链接',
  `dynamic_status` tinyint(3) DEFAULT '1' COMMENT '动态开关',
  `clock_cash_status` tinyint(3) DEFAULT '1' COMMENT '加钟返佣金',
  `balance_cash` tinyint(3) DEFAULT '0' COMMENT '余额返回佣金',
  `balance_integral` tinyint(3) DEFAULT '1' COMMENT '余额返回积分',
  `balance_balance` int(11) DEFAULT '100' COMMENT '返回的比例',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='配置分表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_config`
--

LOCK TABLES `ims_massage_config` WRITE;
/*!40000 ALTER TABLE `ims_massage_config` DISABLE KEYS */;
INSERT INTO `ims_massage_config` VALUES (3,666,1,1,1,'','','',1,1,0,1,100);
/*!40000 ALTER TABLE `ims_massage_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_config_setting`
--

DROP TABLE IF EXISTS `ims_massage_config_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_config_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `key` varchar(64) DEFAULT '',
  `value` varchar(1024) CHARACTER SET utf8mb4 DEFAULT '',
  `text` varchar(255) DEFAULT '' COMMENT '备注',
  `default_value` varchar(255) CHARACTER SET utf8mb4 DEFAULT '',
  `field_type` int(32) DEFAULT '1' COMMENT '1数字 2 字符串',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_config_setting`
--

LOCK TABLES `ims_massage_config_setting` WRITE;
/*!40000 ALTER TABLE `ims_massage_config_setting` DISABLE KEYS */;
INSERT INTO `ims_massage_config_setting` VALUES (14,666,'wechat_transfer','0','微信转账','0',1),(15,666,'alipay_transfer','0','支付宝转账','0',1),(16,666,'under_transfer','1','线下转账','1',1),(17,666,'coach_format','1','技师列表的版式','1',1),(18,666,'recommend_style','1','推荐技师样式','1',1),(19,666,'coach_level_show','1','技师比例是否显示','1',1),(20,666,'order_dispatch','0','是否派单','0',1);
/*!40000 ALTER TABLE `ims_massage_config_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_distribution_list`
--

DROP TABLE IF EXISTS `ims_massage_distribution_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_distribution_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `user_name` varchar(32) CHARACTER SET utf8mb4 DEFAULT '',
  `mobile` varchar(32) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  `text` varchar(625) CHARACTER SET utf8mb4 DEFAULT '',
  `sh_text` varchar(625) DEFAULT '',
  `sh_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_distribution_list`
--

LOCK TABLES `ims_massage_distribution_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_distribution_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_distribution_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_dynamic_comment`
--

DROP TABLE IF EXISTS `ims_massage_dynamic_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_dynamic_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `dynamic_id` int(11) DEFAULT '0',
  `text` text CHARACTER SET utf8mb4,
  `comment_id` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  `have_look` tinyint(3) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_dynamic_comment`
--

LOCK TABLES `ims_massage_dynamic_comment` WRITE;
/*!40000 ALTER TABLE `ims_massage_dynamic_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_dynamic_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_dynamic_follow`
--

DROP TABLE IF EXISTS `ims_massage_dynamic_follow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_dynamic_follow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `have_look` tinyint(3) DEFAULT '0',
  `dynamic_id` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `dynamic_num` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_dynamic_follow`
--

LOCK TABLES `ims_massage_dynamic_follow` WRITE;
/*!40000 ALTER TABLE `ims_massage_dynamic_follow` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_dynamic_follow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_dynamic_list`
--

DROP TABLE IF EXISTS `ims_massage_dynamic_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_dynamic_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 DEFAULT '',
  `cover` varchar(255) DEFAULT NULL,
  `imgs` text,
  `text` text CHARACTER SET utf8mb4,
  `lng` varchar(32) DEFAULT '',
  `lat` varchar(32) DEFAULT '',
  `address` varchar(128) DEFAULT '',
  `user_id` int(11) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0' COMMENT 'j技师id',
  `status` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `top` int(11) DEFAULT '0',
  `pv` int(11) DEFAULT '0' COMMENT '浏览数',
  `check_time` bigint(11) DEFAULT '0',
  `check_text` varchar(625) DEFAULT '' COMMENT '拒绝理由',
  `type` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_dynamic_list`
--

LOCK TABLES `ims_massage_dynamic_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_dynamic_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_dynamic_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_dynamic_thumbs`
--

DROP TABLE IF EXISTS `ims_massage_dynamic_thumbs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_dynamic_thumbs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `dynamic_id` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `have_look` tinyint(3) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_dynamic_thumbs`
--

LOCK TABLES `ims_massage_dynamic_thumbs` WRITE;
/*!40000 ALTER TABLE `ims_massage_dynamic_thumbs` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_dynamic_thumbs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_dynamic_watch_record`
--

DROP TABLE IF EXISTS `ims_massage_dynamic_watch_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_dynamic_watch_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `dynamic_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_dynamic_watch_record`
--

LOCK TABLES `ims_massage_dynamic_watch_record` WRITE;
/*!40000 ALTER TABLE `ims_massage_dynamic_watch_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_dynamic_watch_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_help_notice_config`
--

DROP TABLE IF EXISTS `ims_massage_help_notice_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_help_notice_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `help_phone` varchar(32) DEFAULT '' COMMENT '求救电话',
  `help_user_id` text COMMENT '求救人',
  `help_voice` varchar(255) DEFAULT '' COMMENT '求救录音',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_help_notice_config`
--

LOCK TABLES `ims_massage_help_notice_config` WRITE;
/*!40000 ALTER TABLE `ims_massage_help_notice_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_help_notice_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_integral_list`
--

DROP TABLE IF EXISTS `ims_massage_integral_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_integral_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `integral` double(10,2) DEFAULT '0.00',
  `type` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `order_id` int(11) DEFAULT '0',
  `balance` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `user_cash` decimal(10,2) DEFAULT '0.00' COMMENT '用户充值金额',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_integral_list`
--

LOCK TABLES `ims_massage_integral_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_integral_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_integral_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_order_coach_change_log`
--

DROP TABLE IF EXISTS `ims_massage_order_coach_change_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_order_coach_change_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `old_coach_id` int(11) DEFAULT '0',
  `now_coach_id` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `now_coach_name` varchar(255) CHARACTER SET utf8mb4 DEFAULT '',
  `car_price` decimal(10,2) DEFAULT NULL,
  `init_coach_id` int(11) DEFAULT '0' COMMENT '第一个技师的id',
  `have_car_price` tinyint(3) DEFAULT '0' COMMENT '是否已经给了车费',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单技师移交记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_order_coach_change_log`
--

LOCK TABLES `ims_massage_order_coach_change_log` WRITE;
/*!40000 ALTER TABLE `ims_massage_order_coach_change_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_order_coach_change_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_order_coach_change_logs`
--

DROP TABLE IF EXISTS `ims_massage_order_coach_change_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_order_coach_change_logs` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `is_new` varchar(20) NOT NULL,
  `status` int(12) NOT NULL,
  `have_car_price` varchar(20) NOT NULL,
  `pay_type` int(11) DEFAULT '2',
  `old_coach_mobile` varchar(32) DEFAULT '',
  `now_coach_mobile` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_order_coach_change_logs`
--

LOCK TABLES `ims_massage_order_coach_change_logs` WRITE;
/*!40000 ALTER TABLE `ims_massage_order_coach_change_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_order_coach_change_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_order_control_log`
--

DROP TABLE IF EXISTS `ims_massage_order_control_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_order_control_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `admin_control` tinyint(3) DEFAULT '0' COMMENT '1后台 2技师 3用户',
  `create_time` bigint(11) DEFAULT '0',
  `pay_type` tinyint(3) DEFAULT '0',
  `old_pay_type` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3727 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单操作日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_order_control_log`
--

LOCK TABLES `ims_massage_order_control_log` WRITE;
/*!40000 ALTER TABLE `ims_massage_order_control_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_order_control_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_role_admin`
--

DROP TABLE IF EXISTS `ims_massage_role_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_role_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT '0',
  `role_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_role_admin`
--

LOCK TABLES `ims_massage_role_admin` WRITE;
/*!40000 ALTER TABLE `ims_massage_role_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_role_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_role_list`
--

DROP TABLE IF EXISTS `ims_massage_role_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_role_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(64) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_role_list`
--

LOCK TABLES `ims_massage_role_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_role_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_role_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_role_node`
--

DROP TABLE IF EXISTS `ims_massage_role_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_role_node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT '0' COMMENT '角色id',
  `node` varchar(625) DEFAULT '',
  `auth` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_role_node`
--

LOCK TABLES `ims_massage_role_node` WRITE;
/*!40000 ALTER TABLE `ims_massage_role_node` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_role_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_send_msg_config`
--

DROP TABLE IF EXISTS `ims_massage_send_msg_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_send_msg_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `help_tmpl_id` varchar(64) DEFAULT '',
  `gzh_appid` varchar(64) DEFAULT '',
  `order_tmp_id` varchar(64) DEFAULT '',
  `cancel_tmp_id` varchar(64) DEFAULT '',
  `coachupdate_tmp_id` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_send_msg_config`
--

LOCK TABLES `ims_massage_send_msg_config` WRITE;
/*!40000 ALTER TABLE `ims_massage_send_msg_config` DISABLE KEYS */;
INSERT INTO `ims_massage_send_msg_config` VALUES (2,666,'','','','','');
/*!40000 ALTER TABLE `ims_massage_send_msg_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_address`
--

DROP TABLE IF EXISTS `ims_massage_service_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_name` varchar(64) DEFAULT '',
  `mobile` varchar(32) DEFAULT '',
  `province` varchar(64) DEFAULT '',
  `city` varchar(64) DEFAULT '',
  `area` varchar(64) DEFAULT '',
  `status` tinyint(3) DEFAULT '0',
  `lng` varchar(64) DEFAULT '0',
  `lat` varchar(64) DEFAULT '0',
  `address` varchar(255) DEFAULT '',
  `top` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `address_info` varchar(625) DEFAULT '',
  `user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1382 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_address`
--

LOCK TABLES `ims_massage_service_address` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_balance_card`
--

DROP TABLE IF EXISTS `ims_massage_service_balance_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_balance_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '' COMMENT '标题',
  `price` double(10,2) DEFAULT '0.00' COMMENT '售卖价格',
  `true_price` double(10,2) DEFAULT '0.00' COMMENT '实际价格',
  `top` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='余额充值卡';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_balance_card`
--

LOCK TABLES `ims_massage_service_balance_card` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_balance_card` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_balance_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_balance_order_list`
--

DROP TABLE IF EXISTS `ims_massage_service_balance_order_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_balance_order_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `order_code` varchar(255) DEFAULT '',
  `transaction_id` varchar(255) DEFAULT '',
  `pay_price` double(10,2) DEFAULT '0.00',
  `sale_price` double(10,2) DEFAULT '0.00',
  `true_price` double(10,2) DEFAULT '0.00',
  `create_time` bigint(12) DEFAULT '0',
  `pay_time` bigint(12) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `title` varchar(255) DEFAULT '',
  `card_id` int(11) DEFAULT '0',
  `now_balance` double(10,2) DEFAULT '0.00' COMMENT '当前余额',
  `app_pay` tinyint(3) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0',
  `integral` double(10,2) DEFAULT '0.00' COMMENT '积分',
  `pay_model` tinyint(3) DEFAULT '1',
  `rebates_balance` int(11) DEFAULT '0' COMMENT '返佣比例',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=302 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='充值订单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_balance_order_list`
--

LOCK TABLES `ims_massage_service_balance_order_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_balance_order_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_balance_order_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_balance_refund_order`
--

DROP TABLE IF EXISTS `ims_massage_service_balance_refund_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_balance_refund_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `order_code` varchar(255) DEFAULT '',
  `transaction_id` varchar(255) DEFAULT '',
  `card_id` int(11) DEFAULT '0',
  `order_id` int(11) DEFAULT '0',
  `apply_price` double(10,2) DEFAULT '0.00',
  `refund_price` double(10,2) DEFAULT '0.00',
  `title` varchar(255) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  `sh_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_balance_refund_order`
--

LOCK TABLES `ims_massage_service_balance_refund_order` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_balance_refund_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_balance_refund_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_balance_water`
--

DROP TABLE IF EXISTS `ims_massage_service_balance_water`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_balance_water` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `order_id` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '1' COMMENT '1充值,2消费',
  `add` tinyint(3) DEFAULT '0',
  `price` double(10,2) DEFAULT '0.00' COMMENT '多少钱',
  `create_time` bigint(12) DEFAULT '0',
  `before_balance` double(10,2) DEFAULT '0.00',
  `after_balance` double(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2202 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='余额明细';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_balance_water`
--

LOCK TABLES `ims_massage_service_balance_water` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_balance_water` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_balance_water` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_banner`
--

DROP TABLE IF EXISTS `ims_massage_service_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `img` varchar(128) DEFAULT '',
  `top` int(11) DEFAULT '1',
  `link` varchar(255) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `connect_type` int(11) DEFAULT '1' COMMENT '1查看大图；2文章（默认1）\ntype_id  关联内容id\n',
  `type_id` int(11) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_banner`
--

LOCK TABLES `ims_massage_service_banner` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_car`
--

DROP TABLE IF EXISTS `ims_massage_service_car`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_car` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0',
  `service_id` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '1',
  `status` tinyint(3) DEFAULT '1',
  `order_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7502 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_car`
--

LOCK TABLES `ims_massage_service_car` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_car` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_car` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_car_price`
--

DROP TABLE IF EXISTS `ims_massage_service_car_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_car_price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `distance_free` double(11,2) DEFAULT '0.00' COMMENT '多少公里免费',
  `start_price` double(10,2) DEFAULT '9.00' COMMENT '起步价',
  `start_distance` double(10,2) DEFAULT '9.00' COMMENT '起步距离',
  `distance_price` double(10,2) DEFAULT '1.90' COMMENT '每公里多少钱',
  `invented_distance` double(10,2) DEFAULT '0.00' COMMENT '虚拟里程',
  `city_id` int(11) DEFAULT '0' COMMENT '城市id',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_car_price`
--

LOCK TABLES `ims_massage_service_car_price` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_car_price` DISABLE KEYS */;
INSERT INTO `ims_massage_service_car_price` VALUES (39,666,0.00,9.00,9.00,1.90,0.00,0,1,1704980574);
/*!40000 ALTER TABLE `ims_massage_service_car_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_cash_list`
--

DROP TABLE IF EXISTS `ims_massage_service_cash_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_cash_list` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT '1' COMMENT '1加盟商 2技师 3分销商',
  `user_id` int(11) DEFAULT '0',
  `cash` decimal(10,2) DEFAULT '0.00',
  `order_id` int(11) DEFAULT '0',
  `under_user` int(11) DEFAULT '0' COMMENT '来源',
  `status` int(11) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  `balance` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_cash_list`
--

LOCK TABLES `ims_massage_service_cash_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_cash_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_cash_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_city_list`
--

DROP TABLE IF EXISTS `ims_massage_service_city_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_city_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(64) NOT NULL DEFAULT '',
  `lng` varchar(32) DEFAULT '',
  `lat` varchar(32) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  `true_name` varchar(64) DEFAULT '',
  `pid` int(11) DEFAULT '0',
  `city_type` tinyint(3) DEFAULT '1',
  `province` varchar(64) DEFAULT '',
  `city` varchar(64) NOT NULL DEFAULT '',
  `area` varchar(64) DEFAULT '',
  `province_code` varchar(64) DEFAULT '',
  `city_code` varchar(64) DEFAULT '',
  `area_code` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_city_list`
--

LOCK TABLES `ims_massage_service_city_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_city_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_city_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coach_appeal`
--

DROP TABLE IF EXISTS `ims_massage_service_coach_appeal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coach_appeal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) DEFAULT '0' COMMENT '技师id',
  `uniacid` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `order_code` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '订单号',
  `order_id` int(11) DEFAULT '0' COMMENT '订单id',
  `content` text COMMENT '内容',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态 1待处理 2已处理',
  `reply_content` text CHARACTER SET utf8 COMMENT '回复内容',
  `reply_date` datetime DEFAULT NULL COMMENT '回复时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='技师申诉';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coach_appeal`
--

LOCK TABLES `ims_massage_service_coach_appeal` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coach_appeal` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coach_appeal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coach_collect`
--

DROP TABLE IF EXISTS `ims_massage_service_coach_collect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coach_collect` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0',
  `create_time` bigint(12) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2076 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coach_collect`
--

LOCK TABLES `ims_massage_service_coach_collect` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coach_collect` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coach_collect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coach_feedback`
--

DROP TABLE IF EXISTS `ims_massage_service_coach_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coach_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '类型名称',
  `coach_id` int(11) DEFAULT '0' COMMENT '修改为用户id',
  `uniacid` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `order_code` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '订单号',
  `content` text COMMENT '内容',
  `images` text CHARACTER SET utf8 COMMENT '图片地址 json',
  `video_url` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '视频地址',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态 1待处理 2已处理',
  `reply_content` text CHARACTER SET utf8 COMMENT '回复内容',
  `reply_date` datetime DEFAULT NULL COMMENT '回复时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='技师问题反馈';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coach_feedback`
--

LOCK TABLES `ims_massage_service_coach_feedback` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coach_feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coach_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coach_level`
--

DROP TABLE IF EXISTS `ims_massage_service_coach_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coach_level` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `time_long` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `create_time` bigint(12) DEFAULT '0',
  `balance` int(11) DEFAULT '0' COMMENT '抽成比例',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '最低业绩',
  `add_balance` int(11) DEFAULT '0' COMMENT '加钟率',
  `integral` double(10,2) DEFAULT '0.00' COMMENT '积分',
  `top` int(11) DEFAULT '0' COMMENT '等级',
  `online_time` int(11) DEFAULT '0' COMMENT '在线时长小时',
  `agent_article_id` int(11) DEFAULT '0' COMMENT '代理商入住的文章id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coach_level`
--

LOCK TABLES `ims_massage_service_coach_level` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coach_level` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coach_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coach_list`
--

DROP TABLE IF EXISTS `ims_massage_service_coach_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coach_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `coach_name` varchar(255) DEFAULT '' COMMENT '名称',
  `user_id` int(11) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  `sex` tinyint(3) DEFAULT '0' COMMENT '性别',
  `work_time` bigint(12) DEFAULT '0' COMMENT '从业年份',
  `city` varchar(255) DEFAULT '' COMMENT '城市',
  `lng` varchar(255) DEFAULT '',
  `lat` varchar(255) DEFAULT '',
  `address` varchar(625) DEFAULT '' COMMENT '详细地址',
  `text` varchar(625) DEFAULT '' COMMENT '简介',
  `id_card` varchar(625) DEFAULT '',
  `license` text COMMENT '执照',
  `work_img` varchar(255) DEFAULT '' COMMENT '工作照',
  `self_img` text COMMENT '个人照片',
  `is_work` tinyint(3) DEFAULT '1' COMMENT '是否工作',
  `start_time` varchar(32) DEFAULT '',
  `end_time` varchar(32) DEFAULT '',
  `service_price` double(10,2) DEFAULT '0.00',
  `car_price` double(10,2) DEFAULT '0.00',
  `id_code` varchar(255) DEFAULT '',
  `sh_text` varchar(1024) DEFAULT '',
  `sh_time` bigint(11) DEFAULT '0',
  `star` double(10,1) DEFAULT '5.0',
  `admin_add` tinyint(3) DEFAULT '0' COMMENT '是否是后台添加',
  `admin_id` int(11) DEFAULT '0' COMMENT '加盟商id',
  `city_id` int(11) DEFAULT '0',
  `video` varchar(255) DEFAULT '' COMMENT '视频',
  `is_update` tinyint(3) DEFAULT '0',
  `integral` decimal(10,2) DEFAULT '0.00' COMMENT '积分',
  `order_num` int(11) DEFAULT '0' COMMENT '技师虚拟订单数量',
  `recommend` tinyint(3) DEFAULT '0' COMMENT '是否是推荐技师',
  `balance_cash` decimal(10,2) DEFAULT '0.00' COMMENT '邀请充值余额返回佣金',
  `index_top` tinyint(3) DEFAULT '0' COMMENT '虚拟排序',
  `coach_position` tinyint(3) DEFAULT '0' COMMENT '实时定位',
  `near_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=357 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='技师表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coach_list`
--

LOCK TABLES `ims_massage_service_coach_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coach_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coach_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coach_police`
--

DROP TABLE IF EXISTS `ims_massage_service_coach_police`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coach_police` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `text` varchar(1024) DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  `have_look` tinyint(3) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `lng` varchar(32) DEFAULT '',
  `lat` varchar(32) DEFAULT '',
  `address` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coach_police`
--

LOCK TABLES `ims_massage_service_coach_police` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coach_police` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coach_police` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coach_time`
--

DROP TABLE IF EXISTS `ims_massage_service_coach_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coach_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coach_id` int(11) DEFAULT '0' COMMENT '技师id',
  `date` char(16) DEFAULT '' COMMENT '日期  格式Y-m-d',
  `info` text COMMENT '日期节点详情',
  `hours` int(11) DEFAULT '0' COMMENT '日期节点在线时长',
  `uniacid` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `start_time` varchar(32) DEFAULT '' COMMENT '开始时间',
  `end_time` varchar(32) DEFAULT '' COMMENT '结束时间',
  `max_day` varchar(255) DEFAULT '',
  `time_unit` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `coach_id` (`coach_id`) USING BTREE,
  KEY `date` (`date`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1531 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='技师时间管理';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coach_time`
--

LOCK TABLES `ims_massage_service_coach_time` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coach_time` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coach_time` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coach_time_list`
--

DROP TABLE IF EXISTS `ims_massage_service_coach_time_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coach_time_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_id` int(11) DEFAULT '0' COMMENT '时间管理设置id',
  `time_str` varchar(16) DEFAULT '' COMMENT '开始时间戳',
  `time_str_end` varchar(16) DEFAULT '' COMMENT '结束时间戳',
  `time_text` varchar(16) DEFAULT '' COMMENT '时间',
  `time_texts` varchar(16) DEFAULT '' COMMENT '日期',
  `status` int(3) DEFAULT NULL COMMENT '状态',
  `create_time` bigint(11) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0' COMMENT '技师id',
  `uniacid` int(11) DEFAULT '0',
  `is_click` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `time_id` (`time_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=43972 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='技师时间管理时间节点表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coach_time_list`
--

LOCK TABLES `ims_massage_service_coach_time_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coach_time_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coach_time_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coach_update`
--

DROP TABLE IF EXISTS `ims_massage_service_coach_update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coach_update` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `coach_name` varchar(255) DEFAULT '' COMMENT '名称',
  `user_id` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  `sex` tinyint(3) DEFAULT '0' COMMENT '性别',
  `work_time` bigint(12) DEFAULT '0' COMMENT '从业年份',
  `city` varchar(255) DEFAULT '' COMMENT '城市',
  `lng` varchar(255) DEFAULT '',
  `lat` varchar(255) DEFAULT '',
  `address` varchar(625) DEFAULT '' COMMENT '详细地址',
  `text` varchar(625) DEFAULT '' COMMENT '简介',
  `id_card` varchar(625) DEFAULT '',
  `license` text COMMENT '执照',
  `work_img` varchar(255) DEFAULT '' COMMENT '工作照',
  `self_img` text COMMENT '个人照片',
  `is_work` tinyint(3) DEFAULT '1' COMMENT '是否工作',
  `start_time` varchar(32) DEFAULT '',
  `end_time` varchar(32) DEFAULT '',
  `id_code` varchar(255) DEFAULT '',
  `sh_text` varchar(1024) DEFAULT '',
  `sh_time` bigint(11) DEFAULT '0',
  `video` varchar(255) DEFAULT '' COMMENT '视频',
  `city_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=275 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='技师修改表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coach_update`
--

LOCK TABLES `ims_massage_service_coach_update` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coach_update` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coach_update` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_comment_lable`
--

DROP TABLE IF EXISTS `ims_massage_service_comment_lable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_comment_lable` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT '0',
  `lable_id` int(11) DEFAULT NULL,
  `lable_title` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=711 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_comment_lable`
--

LOCK TABLES `ims_massage_service_comment_lable` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_comment_lable` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_comment_lable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coupon`
--

DROP TABLE IF EXISTS `ims_massage_service_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coupon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '' COMMENT '名称',
  `type` tinyint(3) DEFAULT '0',
  `full` double(10,2) DEFAULT NULL COMMENT '满多少',
  `discount` double(10,2) DEFAULT NULL COMMENT '减多少',
  `rule` text COMMENT '规则',
  `text` text COMMENT '详情',
  `send_type` tinyint(3) DEFAULT '0' COMMENT '派发方式',
  `time_limit` tinyint(3) DEFAULT '0' COMMENT '时间限制',
  `start_time` bigint(12) DEFAULT '0',
  `end_time` bigint(12) DEFAULT '0',
  `day` int(11) DEFAULT '0' COMMENT '有效期',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(12) DEFAULT '0',
  `top` int(11) DEFAULT '0',
  `stock` int(11) DEFAULT '0' COMMENT '库存',
  `have_send` int(11) DEFAULT '0' COMMENT '已发多少张',
  `i` int(11) DEFAULT '0',
  `user_limit` int(11) DEFAULT '1' COMMENT '1不限制 2新用户',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coupon`
--

LOCK TABLES `ims_massage_service_coupon` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coupon_atv`
--

DROP TABLE IF EXISTS `ims_massage_service_coupon_atv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coupon_atv` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '0',
  `start_time` bigint(12) DEFAULT '0',
  `end_time` bigint(12) DEFAULT '0',
  `inv_user_num` int(11) DEFAULT '0' COMMENT '邀请好友数量',
  `inv_time` int(11) DEFAULT '0' COMMENT '邀请有效期',
  `atv_num` int(11) DEFAULT '0' COMMENT '发起活动次数',
  `inv_user` int(11) DEFAULT '0' COMMENT '邀请人',
  `to_inv_user` int(11) DEFAULT '0' COMMENT '被邀请人',
  `share_img` varchar(625) DEFAULT '',
  `is_atv_status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coupon_atv`
--

LOCK TABLES `ims_massage_service_coupon_atv` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coupon_atv` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coupon_atv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coupon_atv_coupon`
--

DROP TABLE IF EXISTS `ims_massage_service_coupon_atv_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coupon_atv_coupon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `atv_id` int(11) DEFAULT '0',
  `coupon_id` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=486 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coupon_atv_coupon`
--

LOCK TABLES `ims_massage_service_coupon_atv_coupon` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coupon_atv_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coupon_atv_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coupon_atv_record`
--

DROP TABLE IF EXISTS `ims_massage_service_coupon_atv_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coupon_atv_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `atv_id` int(11) DEFAULT '0' COMMENT '目前只有一个活动,没有什么用',
  `atv_start_time` bigint(11) DEFAULT '0',
  `atv_end_time` bigint(11) DEFAULT NULL,
  `inv_user_num` int(11) DEFAULT '0' COMMENT '邀请好友数量',
  `inv_time` int(11) DEFAULT '0' COMMENT '有效期',
  `end_time` bigint(11) DEFAULT '0',
  `start_time` bigint(11) DEFAULT '0',
  `inv_user` tinyint(3) DEFAULT '0',
  `to_inv_user` tinyint(3) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `num` int(11) DEFAULT '1',
  `share_img` varchar(625) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coupon_atv_record`
--

LOCK TABLES `ims_massage_service_coupon_atv_record` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coupon_atv_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coupon_atv_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coupon_atv_record_coupon`
--

DROP TABLE IF EXISTS `ims_massage_service_coupon_atv_record_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coupon_atv_record_coupon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `atv_id` int(11) DEFAULT '0',
  `record_id` int(11) DEFAULT '0' COMMENT '发起的活动id',
  `coupon_id` int(11) DEFAULT '0' COMMENT '优惠券id',
  `num` int(11) DEFAULT '1' COMMENT '张数',
  `status` int(11) DEFAULT '1',
  `success_num` int(11) DEFAULT '0' COMMENT '已发多少张',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coupon_atv_record_coupon`
--

LOCK TABLES `ims_massage_service_coupon_atv_record_coupon` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coupon_atv_record_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coupon_atv_record_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coupon_atv_record_list`
--

DROP TABLE IF EXISTS `ims_massage_service_coupon_atv_record_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coupon_atv_record_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `record_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0' COMMENT '发起人',
  `to_inv_id` int(11) DEFAULT '0' COMMENT '被邀请人',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coupon_atv_record_list`
--

LOCK TABLES `ims_massage_service_coupon_atv_record_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coupon_atv_record_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coupon_atv_record_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coupon_goods`
--

DROP TABLE IF EXISTS `ims_massage_service_coupon_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coupon_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `coupon_id` int(11) DEFAULT '0',
  `goods_id` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0' COMMENT '0平台，用户领取',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1048 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coupon_goods`
--

LOCK TABLES `ims_massage_service_coupon_goods` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coupon_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coupon_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_coupon_record`
--

DROP TABLE IF EXISTS `ims_massage_service_coupon_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_coupon_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `coupon_id` int(11) DEFAULT '0',
  `title` varchar(225) DEFAULT '',
  `type` int(11) DEFAULT '0',
  `full` double(10,2) DEFAULT '0.00',
  `discount` double(10,2) DEFAULT '0.00',
  `start_time` bigint(12) DEFAULT '0',
  `end_time` bigint(13) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(12) DEFAULT '0',
  `num` int(11) DEFAULT '1',
  `use_time` bigint(11) DEFAULT '0',
  `order_id` int(11) DEFAULT '0',
  `pid` int(11) DEFAULT '0',
  `rule` text,
  `text` text,
  `is_show` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `type` (`type`,`coupon_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_coupon_record`
--

LOCK TABLES `ims_massage_service_coupon_record` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_coupon_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_coupon_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_lable`
--

DROP TABLE IF EXISTS `ims_massage_service_lable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_lable` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `top` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_lable`
--

LOCK TABLES `ims_massage_service_lable` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_lable` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_lable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_notice_list`
--

DROP TABLE IF EXISTS `ims_massage_service_notice_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_notice_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT '0',
  `have_look` tinyint(3) DEFAULT '0' COMMENT '是否被查看',
  `type` tinyint(3) DEFAULT '1' COMMENT '1是订单，2是退款',
  `create_time` bigint(11) DEFAULT '0',
  `admin_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3302 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_notice_list`
--

LOCK TABLES `ims_massage_service_notice_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_notice_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_notice_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_order_address`
--

DROP TABLE IF EXISTS `ims_massage_service_order_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_order_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT '0',
  `user_name` varchar(64) DEFAULT '',
  `mobile` varchar(32) DEFAULT '',
  `province` varchar(64) DEFAULT '',
  `city` varchar(64) DEFAULT '',
  `area` varchar(64) DEFAULT '',
  `lng` varchar(32) DEFAULT '0',
  `lat` varchar(32) DEFAULT '0',
  `address` varchar(255) DEFAULT '',
  `address_info` varchar(625) DEFAULT '',
  `address_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3655 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_order_address`
--

LOCK TABLES `ims_massage_service_order_address` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_order_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_order_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_order_comment`
--

DROP TABLE IF EXISTS `ims_massage_service_order_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_order_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `order_id` int(11) DEFAULT NULL,
  `star` int(255) DEFAULT '0',
  `text` varchar(625) CHARACTER SET utf8mb4 DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `coach_id` int(11) DEFAULT '0',
  `admin_id` int(11) DEFAULT '0',
  `goods_star` varchar(625) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=590 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单评价';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_order_comment`
--

LOCK TABLES `ims_massage_service_order_comment` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_order_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_order_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_order_comment_goods`
--

DROP TABLE IF EXISTS `ims_massage_service_order_comment_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_order_comment_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT '0',
  `comment_id` int(11) DEFAULT '0',
  `star` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=455 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_order_comment_goods`
--

LOCK TABLES `ims_massage_service_order_comment_goods` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_order_comment_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_order_comment_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_order_commission`
--

DROP TABLE IF EXISTS `ims_massage_service_order_commission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_order_commission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `top_id` int(11) DEFAULT '0' COMMENT '上级id',
  `order_id` int(11) DEFAULT '0',
  `order_code` varchar(255) DEFAULT '',
  `cash` double(10,2) DEFAULT NULL COMMENT '佣金',
  `create_time` bigint(12) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `update_time` bigint(12) DEFAULT '0',
  `cash_time` bigint(11) DEFAULT '0',
  `type` int(11) DEFAULT '1' COMMENT '1分销 2加盟商 3技师 4分销商 5上级分销商 6省代分销 7技师拉用户充值余额',
  `balance` int(11) DEFAULT '0',
  `admin_id` int(11) DEFAULT '0' COMMENT '加盟商id',
  `city_type` int(11) DEFAULT '1' COMMENT '1市级 2县级',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3542 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_order_commission`
--

LOCK TABLES `ims_massage_service_order_commission` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_order_commission` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_order_commission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_order_commission_goods`
--

DROP TABLE IF EXISTS `ims_massage_service_order_commission_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_order_commission_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_goods_id` int(11) DEFAULT '0',
  `commission_id` int(11) DEFAULT '0',
  `cash` double(10,2) DEFAULT NULL,
  `balance` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_order_commission_goods`
--

LOCK TABLES `ims_massage_service_order_commission_goods` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_order_commission_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_order_commission_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_order_goods_list`
--

DROP TABLE IF EXISTS `ims_massage_service_order_goods_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_order_goods_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `order_id` int(11) DEFAULT '0',
  `goods_id` int(11) DEFAULT '0' COMMENT '服务id',
  `goods_name` varchar(255) DEFAULT '' COMMENT '服务名称',
  `goods_cover` varchar(255) DEFAULT '' COMMENT '封面图',
  `price` double(10,2) DEFAULT '0.00',
  `num` int(11) DEFAULT '1' COMMENT '数量',
  `coach_id` int(11) DEFAULT '0',
  `time_long` int(11) DEFAULT '0',
  `can_refund_num` int(11) DEFAULT '0',
  `true_price` double(10,5) DEFAULT '0.00000',
  `pay_type` tinyint(3) DEFAULT '1',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3870 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_order_goods_list`
--

LOCK TABLES `ims_massage_service_order_goods_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_order_goods_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_order_goods_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_order_list`
--

DROP TABLE IF EXISTS `ims_massage_service_order_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_order_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `order_code` varchar(255) DEFAULT '' COMMENT '订单号',
  `pay_type` tinyint(3) DEFAULT '1',
  `transaction_id` varchar(64) DEFAULT '' COMMENT '商户订单号',
  `pay_price` decimal(10,2) DEFAULT '0.00',
  `car_price` double(10,2) DEFAULT '0.00' COMMENT '出行费用',
  `true_car_price` double(10,2) DEFAULT '0.00',
  `service_price` double(10,2) DEFAULT '0.00' COMMENT '服务费用',
  `true_service_price` double(10,2) DEFAULT '0.00',
  `coach_id` int(11) DEFAULT '0' COMMENT '服务技师',
  `start_time` bigint(12) DEFAULT '0',
  `end_time` bigint(12) DEFAULT '0',
  `time_long` int(11) DEFAULT '0' COMMENT '服务时长',
  `true_time_long` int(11) DEFAULT '0' COMMENT '真实服务时长出来退款的',
  `pay_time` bigint(12) DEFAULT '0',
  `create_time` bigint(12) DEFAULT '0',
  `text` varchar(625) DEFAULT '',
  `can_tx_time` int(11) DEFAULT '0',
  `can_tx_date` int(11) DEFAULT '0' COMMENT '可提现时间',
  `hx_user` int(11) DEFAULT '0' COMMENT '核销人',
  `have_tx` tinyint(3) DEFAULT '0',
  `balance` double(10,2) DEFAULT '0.00',
  `receiving_time` bigint(11) DEFAULT '0' COMMENT '接单时间',
  `serout_time` bigint(11) DEFAULT '0' COMMENT '出发时间',
  `arrive_time` bigint(11) DEFAULT '0' COMMENT '到达时间',
  `start_service_time` bigint(11) DEFAULT '0' COMMENT '开始服务时间',
  `arrive_img` varchar(625) DEFAULT '' COMMENT '到达拍照',
  `order_end_time` bigint(11) DEFAULT '0' COMMENT '订单核销时间',
  `is_comment` tinyint(3) DEFAULT '0',
  `distance` double(10,2) DEFAULT '0.00' COMMENT '距离',
  `car_type` tinyint(3) DEFAULT '0',
  `coach_refund_time` bigint(11) DEFAULT '0' COMMENT '拒绝接单',
  `coach_refund_code` varchar(64) DEFAULT '',
  `coupon_id` int(11) DEFAULT '0',
  `discount` double(10,2) DEFAULT '0.00' COMMENT '优惠金额',
  `init_service_price` double(10,2) DEFAULT '0.00',
  `over_time` bigint(11) DEFAULT '0',
  `is_show` tinyint(3) DEFAULT '1',
  `arr_address` varchar(225) DEFAULT '',
  `arr_lng` varchar(32) DEFAULT '',
  `arr_lat` varchar(32) DEFAULT '',
  `end_img` varchar(255) DEFAULT '',
  `end_lng` varchar(32) DEFAULT '',
  `end_lat` varchar(32) DEFAULT '',
  `end_address` varchar(255) DEFAULT '',
  `app_pay` int(11) DEFAULT '0',
  `admin_id` int(11) DEFAULT '0' COMMENT '加盟商id',
  `admin_balance` int(11) DEFAULT '0' COMMENT '加盟商佣金比例',
  `admin_cash` decimal(10,2) DEFAULT '0.00' COMMENT '加盟商佣金',
  `coach_balance` int(11) DEFAULT '0' COMMENT '技师佣金比例',
  `coach_cash` decimal(10,2) DEFAULT '0.00' COMMENT '技师佣金',
  `company_cash` decimal(10,2) DEFAULT '0.00' COMMENT '平台抽层',
  `user_cash` decimal(10,2) DEFAULT '0.00' COMMENT '用户分销',
  `channel_id` int(11) DEFAULT '0' COMMENT '渠道商',
  `channel_cate_id` int(11) DEFAULT '0' COMMENT '渠道',
  `coach_refund_text` varchar(625) CHARACTER SET utf8mb4 DEFAULT '',
  `trip_start_address` varchar(255) DEFAULT '' COMMENT '技师出发地址',
  `trip_end_address` varchar(255) DEFAULT '' COMMENT '技师到达地址',
  `is_add` tinyint(3) DEFAULT '0' COMMENT '是否是加钟订单',
  `add_pid` int(11) DEFAULT '0' COMMENT '加钟订单的父id',
  `label_time` bigint(11) DEFAULT '0',
  `serout_lng` varchar(32) DEFAULT '',
  `serout_lat` varchar(32) DEFAULT '',
  `serout_address` varchar(32) DEFAULT '',
  `pay_model` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uniacid` (`uniacid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4635 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_order_list`
--

LOCK TABLES `ims_massage_service_order_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_order_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_order_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_order_list_data`
--

DROP TABLE IF EXISTS `ims_massage_service_order_list_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_order_list_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT '0',
  `sign_time` bigint(11) DEFAULT '0' COMMENT '签字时间',
  `sign_img` varchar(255) DEFAULT '' COMMENT '签字图片',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3239 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_order_list_data`
--

LOCK TABLES `ims_massage_service_order_list_data` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_order_list_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_order_list_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_order_price_log`
--

DROP TABLE IF EXISTS `ims_massage_service_order_price_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_order_price_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_price` decimal(10,2) DEFAULT '0.00',
  `can_refund_price` decimal(10,2) DEFAULT '0.00',
  `is_top` int(11) DEFAULT NULL,
  `top_order_id` int(11) DEFAULT '0',
  `transaction_id` varchar(128) DEFAULT '',
  `order_code` varchar(128) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1342 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_order_price_log`
--

LOCK TABLES `ims_massage_service_order_price_log` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_order_price_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_order_price_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_printer`
--

DROP TABLE IF EXISTS `ims_massage_service_printer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_printer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT '0' COMMENT '门店id',
  `user` varchar(64) DEFAULT '0' COMMENT '用户id',
  `code` varchar(64) DEFAULT '0' COMMENT '终端号',
  `api_key` varchar(64) DEFAULT '0' COMMENT 'api_key',
  `printer_key` varchar(64) DEFAULT '0' COMMENT '打印机key',
  `type` int(11) DEFAULT '1' COMMENT '1:飞蛾 2:易联云',
  `user_ticket` int(11) DEFAULT '0' COMMENT '用户小票',
  `user_ticket_num` int(11) DEFAULT '1' COMMENT '用户小票联数',
  `kitchen_ticket` int(11) DEFAULT '0' COMMENT '后厨小票',
  `kitchen_ticket_num` int(11) DEFAULT '1' COMMENT '后厨小票联数',
  `status` int(11) DEFAULT '1',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `auto` int(11) DEFAULT '1' COMMENT '自动打印',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_printer`
--

LOCK TABLES `ims_massage_service_printer` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_printer` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_printer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_refund_order`
--

DROP TABLE IF EXISTS `ims_massage_service_refund_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_refund_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_code` varchar(64) DEFAULT '',
  `order_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `transaction_id` varchar(64) DEFAULT '',
  `coach_id` int(11) DEFAULT '0' COMMENT '教练',
  `pay_price` double(10,2) DEFAULT '0.00',
  `apply_price` double(10,2) DEFAULT '0.00',
  `refund_price` double(10,2) DEFAULT '0.00',
  `status` int(11) DEFAULT '1',
  `text` varchar(625) CHARACTER SET utf8mb4 DEFAULT '',
  `refund_text` varchar(625) DEFAULT '',
  `create_time` bigint(12) DEFAULT '0',
  `refund_time` bigint(12) DEFAULT '0',
  `balance` double(10,2) DEFAULT '0.00',
  `cancel_time` bigint(11) DEFAULT '0',
  `out_refund_no` varchar(64) DEFAULT '',
  `imgs` varchar(1024) DEFAULT '',
  `car_price` double(10,2) DEFAULT '0.00',
  `time_long` int(11) DEFAULT '0' COMMENT '退款服务时长',
  `service_price` double(10,2) DEFAULT '0.00',
  `admin_id` int(11) DEFAULT '0',
  `is_add` tinyint(3) DEFAULT '0' COMMENT '是否是加钟订单',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=751 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='退款订单表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_refund_order`
--

LOCK TABLES `ims_massage_service_refund_order` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_refund_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_refund_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_refund_order_goods`
--

DROP TABLE IF EXISTS `ims_massage_service_refund_order_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_refund_order_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `refund_id` int(11) DEFAULT '0',
  `goods_id` int(11) DEFAULT '0',
  `goods_name` varchar(255) DEFAULT '',
  `goods_cover` varchar(255) DEFAULT '',
  `goods_price` decimal(10,2) DEFAULT '0.00',
  `num` int(11) DEFAULT '1',
  `order_goods_id` int(11) DEFAULT '0',
  `order_id` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=814 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='退款订单子表 暂时没用';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_refund_order_goods`
--

LOCK TABLES `ims_massage_service_refund_order_goods` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_refund_order_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_refund_order_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_service_coach`
--

DROP TABLE IF EXISTS `ims_massage_service_service_coach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_service_coach` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `ser_id` int(11) DEFAULT '0' COMMENT '服务id',
  `coach_id` int(11) DEFAULT '0' COMMENT '教练id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16879 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_service_coach`
--

LOCK TABLES `ims_massage_service_service_coach` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_service_coach` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_service_coach` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_service_list`
--

DROP TABLE IF EXISTS `ims_massage_service_service_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_service_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '' COMMENT '标题',
  `cover` varchar(255) DEFAULT '' COMMENT '封面图',
  `price` double(10,2) DEFAULT '0.00' COMMENT '价格',
  `sale` int(11) DEFAULT '0' COMMENT '销量',
  `true_sale` int(11) DEFAULT '0' COMMENT '实际销量',
  `total_sale` int(11) DEFAULT '0' COMMENT '总销量',
  `time_long` int(11) DEFAULT '0' COMMENT '服务时长',
  `max_time` int(11) DEFAULT '0' COMMENT '最长预约',
  `introduce` text COMMENT '介绍',
  `explain` text COMMENT '说明',
  `notice` text COMMENT '须知',
  `top` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  `star` double(10,2) DEFAULT '5.00',
  `imgs` text,
  `lock` int(11) DEFAULT '0',
  `init_price` double(10,2) DEFAULT '0.00' COMMENT '原价',
  `com_balance` int(11) DEFAULT '0' COMMENT '分销比例',
  `sub_title` varchar(255) DEFAULT '',
  `is_add` tinyint(3) DEFAULT '0' COMMENT '是否是加钟服务',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_service_list`
--

LOCK TABLES `ims_massage_service_service_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_service_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_service_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_shop_carte`
--

DROP TABLE IF EXISTS `ims_massage_service_shop_carte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_shop_carte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT '' COMMENT '名称',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态 1上架 0下架 -1 删除',
  `sort` int(10) DEFAULT NULL COMMENT '排序值  倒序',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='物料分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_shop_carte`
--

LOCK TABLES `ims_massage_service_shop_carte` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_shop_carte` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_shop_carte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_shop_goods`
--

DROP TABLE IF EXISTS `ims_massage_service_shop_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_shop_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '名称',
  `carte` varchar(255) DEFAULT '' COMMENT '分类 以，分割',
  `cover` varchar(255) DEFAULT '' COMMENT '封面图',
  `images` text COMMENT '轮播图 json',
  `image_url` varchar(255) DEFAULT NULL COMMENT '轮播跳转链接',
  `video_url` varchar(255) DEFAULT NULL COMMENT '视频地址',
  `desc` longtext COMMENT '详情',
  `phone` varchar(255) DEFAULT NULL COMMENT '平台手机号',
  `uniacid` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1' COMMENT '状态 1上架 0下架 -1 删除',
  `sort` int(10) DEFAULT NULL COMMENT '排序值  倒序',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='物料商城商品';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_shop_goods`
--

LOCK TABLES `ims_massage_service_shop_goods` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_shop_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_shop_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_up_order_goods_list`
--

DROP TABLE IF EXISTS `ims_massage_service_up_order_goods_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_up_order_goods_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT '',
  `goods_cover` varchar(255) DEFAULT '',
  `price` decimal(10,2) DEFAULT '0.00',
  `true_price` decimal(10,2) DEFAULT '0.00',
  `time_long` int(11) DEFAULT '0',
  `num` int(11) DEFAULT NULL,
  `order_goods_id` int(11) DEFAULT '0',
  `pay_price` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_up_order_goods_list`
--

LOCK TABLES `ims_massage_service_up_order_goods_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_up_order_goods_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_up_order_goods_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_up_order_list`
--

DROP TABLE IF EXISTS `ims_massage_service_up_order_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_up_order_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_code` varchar(64) DEFAULT '',
  `pay_price` decimal(10,2) DEFAULT '0.00',
  `user_id` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `pay_type` tinyint(3) DEFAULT '1',
  `transaction_id` varchar(64) DEFAULT '',
  `surplus_price` decimal(10,2) DEFAULT '0.00' COMMENT '除去退款剩余金额',
  `pay_model` int(11) DEFAULT '1',
  `order_price` decimal(10,2) DEFAULT '0.00',
  `pay_time` bigint(11) DEFAULT '0',
  `total_num` int(11) DEFAULT '0',
  `order_goods_id` int(11) DEFAULT '0',
  `balance` decimal(10,2) DEFAULT '0.00',
  `coach_id` int(11) DEFAULT '0',
  `time_long` int(11) DEFAULT '0',
  `service_price` decimal(10,2) DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT '0.00',
  `over_time` int(11) DEFAULT '0',
  `true_service_price` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_up_order_list`
--

LOCK TABLES `ims_massage_service_up_order_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_up_order_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_up_order_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_user_label_data`
--

DROP TABLE IF EXISTS `ims_massage_service_user_label_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_user_label_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `label_id` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `user_id` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=356 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_user_label_data`
--

LOCK TABLES `ims_massage_service_user_label_data` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_user_label_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_user_label_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_user_label_list`
--

DROP TABLE IF EXISTS `ims_massage_service_user_label_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_user_label_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_user_label_list`
--

LOCK TABLES `ims_massage_service_user_label_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_user_label_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_user_label_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_user_list`
--

DROP TABLE IF EXISTS `ims_massage_service_user_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_user_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(64) NOT NULL DEFAULT '',
  `nickName` varchar(255) CHARACTER SET utf8mb4 DEFAULT '',
  `avatarUrl` varchar(255) DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `cap_id` int(11) DEFAULT '0',
  `city` varchar(255) DEFAULT '',
  `country` varchar(255) DEFAULT '',
  `gender` int(11) DEFAULT '0',
  `language` varchar(32) DEFAULT '',
  `province` varchar(128) DEFAULT '',
  `balance` double(10,2) DEFAULT '0.00' COMMENT '余额',
  `phone` varchar(32) DEFAULT '',
  `session_key` varchar(255) DEFAULT '',
  `pid` int(11) DEFAULT '0',
  `cash` double(10,2) DEFAULT '0.00' COMMENT '分销佣金',
  `unionid` varchar(64) DEFAULT '',
  `app_openid` varchar(64) DEFAULT '',
  `web_openid` varchar(64) DEFAULT '',
  `wechat_openid` varchar(64) DEFAULT '',
  `last_login_type` tinyint(3) DEFAULT '0' COMMENT '0小程序 1app 2web',
  `new_cash` decimal(10,2) DEFAULT '0.00' COMMENT '新的分销佣金可提现',
  `lock` int(11) DEFAULT '0',
  `is_fx` tinyint(3) DEFAULT '0',
  `ios_openid` varchar(64) DEFAULT '0' COMMENT '苹果登录的账号',
  `push_id` varchar(64) DEFAULT '',
  `alipay_number` varchar(128) DEFAULT '' COMMENT '支付宝账号',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `openid` (`openid`,`uniacid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3903 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_user_list`
--

LOCK TABLES `ims_massage_service_user_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_user_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_user_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_service_wallet_list`
--

DROP TABLE IF EXISTS `ims_massage_service_wallet_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_service_wallet_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT '',
  `user_id` int(11) DEFAULT '0',
  `coach_id` int(11) DEFAULT NULL,
  `total_price` double(10,2) DEFAULT '0.00' COMMENT '总代提现多少',
  `apply_price` double(10,2) DEFAULT '0.00',
  `service_price` double(10,2) DEFAULT '0.00' COMMENT '手续费',
  `balance` int(11) DEFAULT '0' COMMENT '提成比例',
  `true_price` double(10,2) DEFAULT '0.00' COMMENT '实际到账',
  `status` int(11) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '11',
  `sh_time` bigint(11) DEFAULT '0',
  `type` tinyint(3) DEFAULT '0' COMMENT '1是车费 2服务费 3加盟 4用户分销',
  `online` tinyint(3) DEFAULT '0',
  `payment_no` varchar(64) DEFAULT '',
  `text` varchar(1024) DEFAULT '',
  `admin_id` int(11) DEFAULT '0',
  `lock` int(11) DEFAULT '0',
  `apply_transfer` tinyint(3) DEFAULT '0' COMMENT '申请转账方式',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='佣金提现';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_service_wallet_list`
--

LOCK TABLES `ims_massage_service_wallet_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_service_wallet_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_service_wallet_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_shield_list`
--

DROP TABLE IF EXISTS `ims_massage_shield_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_shield_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `type` tinyint(3) DEFAULT '1' COMMENT '1动态  2技师',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_shield_list`
--

LOCK TABLES `ims_massage_shield_list` WRITE;
/*!40000 ALTER TABLE `ims_massage_shield_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_shield_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_short_code_config`
--

DROP TABLE IF EXISTS `ims_massage_short_code_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_short_code_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `short_sign` varchar(255) DEFAULT '' COMMENT '短信签名',
  `order_short_code` varchar(255) DEFAULT '' COMMENT '订单短信模版code',
  `refund_short_code` varchar(255) DEFAULT NULL COMMENT '退单短信模版code',
  `help_short_code` varchar(255) DEFAULT '',
  `short_code` varchar(255) DEFAULT NULL,
  `short_code_status` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_short_code_config`
--

LOCK TABLES `ims_massage_short_code_config` WRITE;
/*!40000 ALTER TABLE `ims_massage_short_code_config` DISABLE KEYS */;
INSERT INTO `ims_massage_short_code_config` VALUES (3,666,'','',NULL,'',NULL,0);
/*!40000 ALTER TABLE `ims_massage_short_code_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_virtual_bind_log`
--

DROP TABLE IF EXISTS `ims_massage_virtual_bind_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_virtual_bind_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `text` text,
  `order_id` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_virtual_bind_log`
--

LOCK TABLES `ims_massage_virtual_bind_log` WRITE;
/*!40000 ALTER TABLE `ims_massage_virtual_bind_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_virtual_bind_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_massage_wx_upload`
--

DROP TABLE IF EXISTS `ims_massage_wx_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_massage_wx_upload` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `key` varchar(625) DEFAULT '' COMMENT '密钥',
  `version` varchar(32) DEFAULT '' COMMENT '版本号',
  `content` varchar(1024) DEFAULT '' COMMENT '描述',
  `app_id` varchar(1024) DEFAULT '' COMMENT 'app_id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='微信上传配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_massage_wx_upload`
--

LOCK TABLES `ims_massage_wx_upload` WRITE;
/*!40000 ALTER TABLE `ims_massage_wx_upload` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_massage_wx_upload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_shequshop_school_admin`
--

DROP TABLE IF EXISTS `ims_shequshop_school_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_shequshop_school_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT '',
  `passwd` varchar(255) DEFAULT '',
  `create_time` int(11) DEFAULT '0',
  `is_admin` tinyint(3) DEFAULT '1' COMMENT '是否是超管',
  `balance` int(11) DEFAULT '0' COMMENT '分佣比例',
  `user_id` int(11) DEFAULT '0' COMMENT '绑定用户',
  `status` tinyint(3) DEFAULT '1',
  `passwd_text` varchar(255) DEFAULT '',
  `cash` double(10,2) DEFAULT '0.00' COMMENT '佣金',
  `lock` int(11) DEFAULT '0',
  `city_type` tinyint(3) DEFAULT '1' COMMENT '1城市代理 2区县代理3省代',
  `admin_pid` int(11) DEFAULT '0' COMMENT '上级代理商',
  `level_balance` int(11) DEFAULT '0' COMMENT '上级',
  `city_id` int(11) DEFAULT '0' COMMENT '城市id',
  `province` varchar(255) DEFAULT '',
  `phone` int(20) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_shequshop_school_admin`
--

LOCK TABLES `ims_shequshop_school_admin` WRITE;
/*!40000 ALTER TABLE `ims_shequshop_school_admin` DISABLE KEYS */;
INSERT INTO `ims_shequshop_school_admin` VALUES (1,666,'admin','d23a457be84ab338c2f6bca4954a3673',1625585405,1,0,0,1,'',0.00,0,1,0,0,0,'',0);
/*!40000 ALTER TABLE `ims_shequshop_school_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_shequshop_school_attachment`
--

DROP TABLE IF EXISTS `ims_shequshop_school_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_shequshop_school_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `module_upload_dir` varchar(100) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `longbing_attachment_path` char(255) NOT NULL DEFAULT '' COMMENT 'path',
  `longbing_driver` char(10) NOT NULL DEFAULT '' COMMENT 'loacl',
  `longbing_from` varchar(255) NOT NULL DEFAULT '' COMMENT 'web',
  `admin_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5764 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_shequshop_school_attachment`
--

LOCK TABLES `ims_shequshop_school_attachment` WRITE;
/*!40000 ALTER TABLE `ims_shequshop_school_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_shequshop_school_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_shequshop_school_attachment_group`
--

DROP TABLE IF EXISTS `ims_shequshop_school_attachment_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_shequshop_school_attachment_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_shequshop_school_attachment_group`
--

LOCK TABLES `ims_shequshop_school_attachment_group` WRITE;
/*!40000 ALTER TABLE `ims_shequshop_school_attachment_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_shequshop_school_attachment_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_shequshop_school_config`
--

DROP TABLE IF EXISTS `ims_shequshop_school_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_shequshop_school_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `appid` varchar(32) DEFAULT '',
  `appsecret` varchar(64) DEFAULT '',
  `app_name` varchar(255) DEFAULT '',
  `over_time` int(11) DEFAULT '300' COMMENT '订单超时取消',
  `cash_balance` int(11) DEFAULT '100' COMMENT ' 提现比列',
  `min_cash` double(10,2) DEFAULT '0.00' COMMENT '最低提现金额',
  `max_day` int(11) DEFAULT '0' COMMENT '最长预约时间',
  `time_unit` int(11) DEFAULT '30' COMMENT '时长单位',
  `service_cover_time` int(11) DEFAULT '0' COMMENT '服务倒计时',
  `can_tx_time` int(11) DEFAULT '24' COMMENT '多少小时后可提现',
  `cash_mini` double(10,2) DEFAULT '0.01',
  `mobile` varchar(255) DEFAULT '',
  `im_type` int(11) DEFAULT '1',
  `app_app_id` varchar(64) DEFAULT '',
  `app_app_secret` varchar(64) DEFAULT '',
  `login_protocol` text CHARACTER SET utf8mb4,
  `web_app_id` varchar(64) DEFAULT '',
  `web_app_secret` varchar(64) DEFAULT '',
  `map_secret` varchar(64) DEFAULT '',
  `company_pay` tinyint(3) DEFAULT '1',
  `short_id` varchar(64) DEFAULT '' COMMENT '阿里云短信AccessKey',
  `short_secret` varchar(64) DEFAULT '' COMMENT '阿里云短信Secret',
  `fx_check` tinyint(3) DEFAULT '0' COMMENT '是否开启分销审核',
  `is_bus` tinyint(3) DEFAULT '1' COMMENT '是否支持公共交通',
  `bus_start_time` varchar(32) DEFAULT '',
  `bus_end_time` varchar(32) DEFAULT '',
  `app_text` varchar(64) DEFAULT '' COMMENT 'app名称',
  `app_logo` varchar(255) DEFAULT '' COMMENT 'applogo',
  `record_type` int(11) DEFAULT '1',
  `record_no` varchar(255) DEFAULT '',
  `trading_rules` longtext COMMENT '交易规则',
  `user_image` varchar(255) DEFAULT 'https://lbqny.migugu.com/admin/anmo/mine/bg.png' COMMENT '个人中心背景图',
  `user_font_color` varchar(32) DEFAULT '#ffffff' COMMENT '文字颜色',
  `coach_image` varchar(255) DEFAULT 'https://lbqny.migugu.com/admin/anmo/mine/bg.png' COMMENT '技师端背景图',
  `coach_font_color` varchar(32) DEFAULT '#ffffff' COMMENT '文字颜色',
  `app_banner` text,
  `information_protection` longtext COMMENT '个人信息保护',
  `countdown_voice` varchar(255) DEFAULT '' COMMENT '倒计时语音',
  `primaryColor` varchar(255) DEFAULT '#A40035',
  `subColor` varchar(255) DEFAULT '#F1C06B',
  `time_interval` int(11) DEFAULT '0' COMMENT '时间间隔 单位分钟',
  `anonymous_evaluate` tinyint(3) DEFAULT '0' COMMENT '是否开启匿名评价',
  `service_btn_color` varchar(64) DEFAULT '#282B34',
  `service_font_color` varchar(64) DEFAULT '#EBDDB1',
  `level_cycle` int(11) DEFAULT '0' COMMENT '0不限 1每周 3每月 4每季度 5每年',
  `web_code_img` varchar(255) DEFAULT '',
  `promotion_poster_img` varchar(255) DEFAULT 'https://lbqny.migugu.com/admin/anmo/mine/fx-share.png',
  `bind_technician_img` varchar(255) DEFAULT 'https://lbqnyv2.migugu.com/bianzu18.png',
  `is_current` tinyint(3) DEFAULT '2' COMMENT '2上个周期 1本期',
  `agent_article_id` int(11) DEFAULT '0' COMMENT '代理商入住的文章id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_shequshop_school_config`
--

LOCK TABLES `ims_shequshop_school_config` WRITE;
/*!40000 ALTER TABLE `ims_shequshop_school_config` DISABLE KEYS */;
INSERT INTO `ims_shequshop_school_config` VALUES (3,666,'','','',300,100,0.00,0,30,0,24,0.01,'',1,'','',NULL,'','','',1,'','',0,1,'','','','',1,'',NULL,'https://lbqny.migugu.com/admin/anmo/mine/bg.png','#ffffff','https://lbqny.migugu.com/admin/anmo/mine/bg.png','#ffffff',NULL,NULL,'','#A40035','#F1C06B',0,0,'#282B34','#EBDDB1',0,'','https://lbqny.migugu.com/admin/anmo/mine/fx-share.png','https://lbqnyv2.migugu.com/bianzu18.png',2,0);
/*!40000 ALTER TABLE `ims_shequshop_school_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_shequshop_school_goods_sh_list`
--

DROP TABLE IF EXISTS `ims_shequshop_school_goods_sh_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_shequshop_school_goods_sh_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sh_id` int(11) DEFAULT '0' COMMENT '审核id',
  `goods_id` int(11) DEFAULT '0',
  `goods_name` varchar(255) DEFAULT '' COMMENT '商品列表',
  `cate_id` int(11) DEFAULT '0' COMMENT '分类id',
  `cover` varchar(255) DEFAULT '' COMMENT '封面图',
  `imgs` text COMMENT '轮播图',
  `text` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_shequshop_school_goods_sh_list`
--

LOCK TABLES `ims_shequshop_school_goods_sh_list` WRITE;
/*!40000 ALTER TABLE `ims_shequshop_school_goods_sh_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_shequshop_school_goods_sh_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_shequshop_school_oos_config`
--

DROP TABLE IF EXISTS `ims_shequshop_school_oos_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_shequshop_school_oos_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `miniapp_name` varchar(50) NOT NULL DEFAULT '',
  `open_oss` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-本地 1-阿里云 2-七牛云  3--腾讯云',
  `aliyun_bucket` varchar(255) NOT NULL DEFAULT '' COMMENT '仓库',
  `aliyun_access_key_id` varchar(50) NOT NULL DEFAULT '' COMMENT '阿里云',
  `aliyun_access_key_secret` varchar(100) NOT NULL DEFAULT '' COMMENT '阿里云',
  `aliyun_base_dir` varchar(200) NOT NULL DEFAULT '' COMMENT '图片等资源存储根目录',
  `aliyun_zidinyi_yuming` varchar(255) NOT NULL DEFAULT '' COMMENT '自定义域名',
  `aliyun_endpoint` varchar(255) NOT NULL DEFAULT '',
  `aliyun_rules` text COMMENT '阿里云的规则配置',
  `qiniu_accesskey` varchar(100) NOT NULL DEFAULT '' COMMENT '七牛云秘钥',
  `qiniu_secretkey` varchar(100) NOT NULL DEFAULT '' COMMENT '七牛云秘钥',
  `qiniu_bucket` varchar(50) NOT NULL DEFAULT '' COMMENT '七牛云仓库',
  `qiniu_yuming` varchar(255) NOT NULL DEFAULT '' COMMENT '七牛自定义域名  前面要加http://',
  `qiniu_rules` text COMMENT '七牛的规则配置',
  `tenxunyun_appid` varchar(20) NOT NULL DEFAULT '' COMMENT '腾讯云的appid',
  `tenxunyun_secretid` varchar(50) NOT NULL DEFAULT '' COMMENT '腾讯云secretid',
  `tenxunyun_secretkey` varchar(50) NOT NULL DEFAULT '' COMMENT '腾讯云的配置',
  `tenxunyun_bucket` varchar(50) NOT NULL DEFAULT '' COMMENT '腾讯云图片仓库',
  `tenxunyun_region` varchar(50) NOT NULL DEFAULT '' COMMENT '腾讯云地域',
  `tenxunyun_yuming` varchar(300) NOT NULL DEFAULT '' COMMENT '腾讯云域名',
  `apiclient_cert` varchar(200) NOT NULL DEFAULT '',
  `apiclient_key` varchar(200) NOT NULL DEFAULT '' COMMENT '两个证书文件路径',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_sync` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否同步',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '储蓄名字',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_shequshop_school_oos_config`
--

LOCK TABLES `ims_shequshop_school_oos_config` WRITE;
/*!40000 ALTER TABLE `ims_shequshop_school_oos_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_shequshop_school_oos_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_shequshop_school_pay_config`
--

DROP TABLE IF EXISTS `ims_shequshop_school_pay_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_shequshop_school_pay_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uniacid` int(10) NOT NULL DEFAULT '0' COMMENT '小程序关联id',
  `mch_id` varchar(255) NOT NULL DEFAULT '' COMMENT '商户号',
  `pay_key` varchar(255) NOT NULL DEFAULT '' COMMENT '支付秘钥',
  `cert_path` varchar(255) NOT NULL DEFAULT '' COMMENT '证书',
  `key_path` varchar(255) NOT NULL DEFAULT '' COMMENT '证书',
  `min_price` int(6) NOT NULL DEFAULT '0' COMMENT '最低提现金额',
  `pay_name` varchar(255) NOT NULL DEFAULT 'wechat' COMMENT '支付类型',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `ali_appid` varchar(64) DEFAULT '' COMMENT '支付宝appid',
  `ali_privatekey` text COMMENT '支付宝私钥',
  `ali_publickey` text COMMENT '支付宝公钥',
  `alipay_status` tinyint(3) DEFAULT '0',
  `appCretPublicKey` varchar(255) DEFAULT '' COMMENT '支付宝应用公钥',
  `alipayCretPublicKey` varchar(255) DEFAULT '' COMMENT '支付宝公钥',
  `alipayRootCret` varchar(255) DEFAULT '' COMMENT '支付宝根证书',
  `alipay_type` tinyint(3) DEFAULT '1' COMMENT '1 密钥模式 2证书模式',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_shequshop_school_pay_config`
--

LOCK TABLES `ims_shequshop_school_pay_config` WRITE;
/*!40000 ALTER TABLE `ims_shequshop_school_pay_config` DISABLE KEYS */;
INSERT INTO `ims_shequshop_school_pay_config` VALUES (2,666,'','','','',0,'wechat',0,0,'',NULL,NULL,0,'','','',1);
/*!40000 ALTER TABLE `ims_shequshop_school_pay_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_shequshop_school_wechat_code`
--

DROP TABLE IF EXISTS `ims_shequshop_school_wechat_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_shequshop_school_wechat_code` (
  `id` char(32) NOT NULL DEFAULT '',
  `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT 'uniacid',
  `data` text COMMENT '数据',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `deleted` tinyint(1) DEFAULT '0' COMMENT '1：已回收；0：可用；',
  `path` varchar(500) DEFAULT '',
  `count` int(11) DEFAULT '0' COMMENT '扫码次数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='二维码';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_shequshop_school_wechat_code`
--

LOCK TABLES `ims_shequshop_school_wechat_code` WRITE;
/*!40000 ALTER TABLE `ims_shequshop_school_wechat_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_shequshop_school_wechat_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lbv2_admin_violation`
--

DROP TABLE IF EXISTS `lbv2_admin_violation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lbv2_admin_violation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT '',
  `goods_id` int(11) DEFAULT NULL,
  `last_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lbv2_admin_violation`
--

LOCK TABLES `lbv2_admin_violation` WRITE;
/*!40000 ALTER TABLE `lbv2_admin_violation` DISABLE KEYS */;
/*!40000 ALTER TABLE `lbv2_admin_violation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'cs_cndjspa_top'
--

--
-- Dumping routines for database 'cs_cndjspa_top'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-11 21:45:25
