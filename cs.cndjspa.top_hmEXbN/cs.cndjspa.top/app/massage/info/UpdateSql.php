<?php
//获取表前缀
$prefix = longbing_get_prefix();

//每个一个sql语句结束，都必须以英文分号结束。因为在执行sql时，需要分割单个脚本执行。
//表前缀需要自己添加{$prefix} 以下脚本被测试脚本


$sql = <<<updateSql

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_address` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_balance_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '' COMMENT '标题',
  `price` double(10,2) DEFAULT '0.00' COMMENT '售卖价格',
  `true_price` double(10,2) DEFAULT '0.00' COMMENT '实际价格',
  `top` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_balance_order_list` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_balance_refund_order` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_balance_water` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `img` varchar(128) DEFAULT '',
  `top` int(11) DEFAULT '1',
  `link` varchar(255) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_car` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0',
  `service_id` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '1',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_car_price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `distance_free` double(11,2) DEFAULT '0.00' COMMENT '多少公里免费',
  `start_price` double(10,2) DEFAULT '9.00' COMMENT '起步价',
  `start_distance` double(10,2) DEFAULT '9.00' COMMENT '起步距离',
  `distance_price` double(10,2) DEFAULT '1.90' COMMENT '每公里多少钱',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coach_collect` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0',
  `create_time` bigint(12) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coach_level` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `time_long` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `create_time` bigint(12) DEFAULT '0',
  `balance` int(11) DEFAULT '0' COMMENT '抽成比例',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coach_list` (
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
  `license` varchar(625) DEFAULT '' COMMENT '执照',
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coach_police` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `text` varchar(1024) DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  `have_look` tinyint(3) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_comment_lable` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT '0',
  `lable_id` int(11) DEFAULT NULL,
  `lable_title` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coupon` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}shequshop_school_goods_sh_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sh_id` int(11) DEFAULT '0' COMMENT '审核id',
  `goods_id` int(11) DEFAULT '0',
  `goods_name` varchar(255) DEFAULT '' COMMENT '商品列表',
  `cate_id` int(11) DEFAULT '0' COMMENT '分类id',
  `cover` varchar(255) DEFAULT '' COMMENT '封面图',
  `imgs` text COMMENT '轮播图',
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coupon_atv` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coupon_atv_coupon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `atv_id` int(11) DEFAULT '0',
  `coupon_id` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coupon_atv_record` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coupon_atv_record_coupon` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `atv_id` int(11) DEFAULT '0',
  `record_id` int(11) DEFAULT '0' COMMENT '发起的活动id',
  `coupon_id` int(11) DEFAULT '0' COMMENT '优惠券id',
  `num` int(11) DEFAULT '1' COMMENT '张数',
  `status` int(11) DEFAULT '1',
  `success_num` int(11) DEFAULT '0' COMMENT '已发多少张',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coupon_atv_record_list` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `record_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0' COMMENT '发起人',
  `to_inv_id` int(11) DEFAULT '0' COMMENT '被邀请人',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coupon_goods` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `coupon_id` int(11) DEFAULT '0',
  `goods_id` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0' COMMENT '0平台，用户领取',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coupon_record` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_lable` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `top` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_order_address` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_order_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `order_id` int(11) DEFAULT NULL,
  `star` int(255) DEFAULT '0',
  `text` varchar(625) DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `coach_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_order_goods_list` (
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
  `true_price` double(10,5) DEFAULT '0.00',
  `pay_type` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_order_list` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_refund_order` (
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
  `text` varchar(625) DEFAULT '',
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_refund_order_goods` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_service_coach` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `ser_id` int(11) DEFAULT '0' COMMENT '服务id',
  `coach_id` int(11) DEFAULT '0' COMMENT '教练id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_service_list` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_user_list` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_wallet_list` (
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
  `type` tinyint(3) DEFAULT '0' COMMENT '1是车费',
  `online` tinyint(3) DEFAULT '0',
  `payment_no` varchar(64) DEFAULT '',
  `text` varchar(1024) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}shequshop_school_admin` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT '',
  `passwd` varchar(255) DEFAULT '',
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}shequshop_school_attachment` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}shequshop_school_attachment_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}shequshop_school_config` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}shequshop_school_oos_config` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}shequshop_school_pay_config` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}shequshop_school_wechat_code` (
`id` char(32) NOT NULL DEFAULT '',
  `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT 'uniacid',
  `data` text COMMENT '数据',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `deleted` tinyint(1) DEFAULT '0' COMMENT '1：已回收；0：可用；',
  `path` varchar(500) DEFAULT '',
  `count` int(11) DEFAULT '0' COMMENT '扫码次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_notice_list` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT '0',
  `have_look` tinyint(3) DEFAULT '0' COMMENT '是否被查看',
  `type` tinyint(3) DEFAULT '1' COMMENT '1是订单，2是退款',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_printer` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_cash_list` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_city_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(64) DEFAULT '',
  `lng` varchar(32) DEFAULT '',
  `lat` varchar(32) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  `true_name` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `{$prefix}massage_distribution_list` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



ALTER TABLE `{$prefix}massage_service_service_list` ADD COLUMN  `init_price` double(10,2) DEFAULT '0.00' COMMENT '原价';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN `pid` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN `cash` double(10,2) DEFAULT '0.00' COMMENT '分销佣金';

ALTER TABLE `{$prefix}massage_service_service_list` ADD COLUMN `com_balance` int(11) DEFAULT '0' COMMENT '分销比例';

ALTER TABLE `{$prefix}massage_service_service_list` ADD COLUMN `sub_title` varchar(255) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_coach_list` modify COLUMN `license` text COMMENT '执照';

ALTER TABLE `{$prefix}massage_service_refund_order` modify COLUMN `text` varchar(625) CHARACTER SET utf8mb4 DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `arr_address` varchar(225) DEFAULT '';


ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `arr_address` varchar(225) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `arr_lng` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `arr_lat` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `end_img` varchar(255) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `end_lng` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `end_lat` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `end_address` varchar(255) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `app_pay` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_coach_list` ADD COLUMN  `admin_add` tinyint(3) DEFAULT '0' COMMENT '是否是后台添加';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `im_type` int(11) DEFAULT '1';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN  `unionid` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN  `app_openid` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN  `web_openid` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN  `wechat_openid` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN  `last_login_type` tinyint(3) DEFAULT '0' COMMENT '0小程序 1app 2web';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `app_app_secret` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `app_app_id` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `login_protocol` text CHARACTER SET utf8mb4;

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `web_app_secret` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `web_app_id` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `map_secret` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_balance_order_list` ADD COLUMN  `app_pay` tinyint(3) DEFAULT '0';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN  `is_admin` tinyint(3) DEFAULT '1' COMMENT '是否是超管';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN  `balance` int(11) DEFAULT '0' COMMENT '分佣比例';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN  `user_id` int(11) DEFAULT '0' COMMENT '绑定用户';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN  `status` tinyint(3) DEFAULT '1';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN  `passwd_text` varchar(255) DEFAULT '';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN  `cash` double(10,2) DEFAULT '0.00' COMMENT '佣金';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN  `lock` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN  `phone` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN  `admin_id` int(11) DEFAULT '0' COMMENT '加盟商id';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN  `admin_balance` int(11) DEFAULT '0' COMMENT '加盟商佣金比例';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN  `admin_cash` decimal(10,2) DEFAULT '0.00' COMMENT '加盟商佣金';

ALTER TABLE `{$prefix}massage_service_coach_list` ADD COLUMN  `admin_id` int(11) DEFAULT '0' COMMENT '加盟商id';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN  `coach_balance` int(11) DEFAULT '0' COMMENT '技师佣金比例';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN  `coach_cash` decimal(10,2) DEFAULT '0.00' COMMENT '技师佣金';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN  `company_cash` decimal(10,2) DEFAULT '0.00' COMMENT '平台抽层';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN  `user_cash` decimal(10,2) DEFAULT '0.00' COMMENT '用户分销';

ALTER TABLE `{$prefix}massage_service_order_commission` ADD COLUMN `type` int(11) DEFAULT '1' COMMENT '1分销 2加盟商 3技师 4分销商';

ALTER TABLE `{$prefix}massage_service_order_commission` ADD COLUMN `balance` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_order_commission` ADD COLUMN `admin_id` int(11) DEFAULT '0' COMMENT '加盟商id';

ALTER TABLE `{$prefix}massage_service_wallet_list` ADD COLUMN `admin_id` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_refund_order` ADD COLUMN `admin_id` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_order_comment` ADD COLUMN `admin_id` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN `new_cash` decimal(10,2) DEFAULT '0.00' COMMENT '新的分销佣金可提现';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN `lock` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_coupon` ADD COLUMN `user_limit` int(11) DEFAULT '1' COMMENT '1不限制 2新用户';

ALTER TABLE `{$prefix}massage_service_coach_list` ADD COLUMN `city_id` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `company_pay` tinyint(3) DEFAULT '1';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `short_id` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `short_secret` varchar(64) DEFAULT '';



ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `fx_check` tinyint(3) DEFAULT '0' COMMENT '是否开启分销审核';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN `is_fx` tinyint(3) DEFAULT '0';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `is_bus` tinyint(3) DEFAULT '1' COMMENT '是否支持公共交通';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `bus_start_time` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `bus_end_time` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_notice_list` ADD COLUMN  `admin_id` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `app_text` varchar(64) DEFAULT '' COMMENT 'app名称';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `app_logo` varchar(255) DEFAULT '' COMMENT 'applogo';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `record_type` int(11) DEFAULT '1';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `record_no` varchar(255) DEFAULT '';



ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `trading_rules` text COMMENT '交易规则';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `user_image` varchar(255) DEFAULT '' COMMENT '个人中心背景图';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `user_font_color` varchar(32) DEFAULT '' COMMENT '文字颜色';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `coach_image` varchar(255) DEFAULT '' COMMENT '技师端背景图';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN  `coach_font_color` varchar(32) DEFAULT '' COMMENT '文字颜色';

ALTER TABLE `{$prefix}massage_service_coach_list` ADD COLUMN  `video` varchar(255) DEFAULT '' COMMENT '视频';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN  `channel_id` int(11) DEFAULT '0' COMMENT '渠道商';

ALTER TABLE `{$prefix}shequshop_school_config` modify COLUMN `user_image` varchar(255) DEFAULT 'https://lbqny.migugu.com/admin/anmo/mine/bg.png' COMMENT '个人中心背景图';

ALTER TABLE `{$prefix}shequshop_school_config` modify COLUMN `user_font_color` varchar(32) DEFAULT '#ffffff' COMMENT '文字颜色';

ALTER TABLE `{$prefix}shequshop_school_config` modify COLUMN `coach_image` varchar(255) DEFAULT 'https://lbqny.migugu.com/admin/anmo/mine/bg.png' COMMENT '技师端背景图';

ALTER TABLE `{$prefix}shequshop_school_config` modify COLUMN `coach_font_color` varchar(32) DEFAULT '#ffffff' COMMENT '文字颜色';

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_order_comment_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT '0',
  `comment_id` int(11) DEFAULT '0',
  `star` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_wx_upload` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `key` varchar(625) DEFAULT '' COMMENT '密钥',
  `version` varchar(32) DEFAULT '' COMMENT '版本号',
  `content` varchar(1024) DEFAULT '' COMMENT '描述',
  `app_id` varchar(1024) DEFAULT '' COMMENT 'app_id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信上传配置';




CREATE TABLE IF NOT EXISTS `{$prefix}massage_channel_cate` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `create_time` bigint(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='渠道商分类';


CREATE TABLE IF NOT EXISTS `{$prefix}massage_channel_list` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='渠道商';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `app_banner` text;

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `information_protection` longtext COMMENT '个人信息保护';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `countdown_voice` varchar(255) DEFAULT '' COMMENT '倒计时语音';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `primaryColor` varchar(255) DEFAULT '#A40035';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `subColor` varchar(255) DEFAULT '#F1C06B';



ALTER TABLE `{$prefix}massage_service_coach_list` ADD COLUMN `is_update` tinyint(3) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `coach_refund_text` varchar(625) CHARACTER SET utf8mb4 DEFAULT '';

ALTER TABLE `{$prefix}shequshop_school_config` modify COLUMN `trading_rules` longtext COMMENT '交易规则';


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coach_update` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 COMMENT='技师修改表';

ALTER TABLE `{$prefix}massage_service_coach_update` ADD COLUMN `city_id` int(11) DEFAULT '0';


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coach_time` (
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
  PRIMARY KEY (`id`),
  KEY `coach_id` (`coach_id`) USING BTREE,
  KEY `date` (`date`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='技师时间管理';

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coach_time_list` (
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
  PRIMARY KEY (`id`),
  KEY `time_id` (`time_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='技师时间管理时间节点表';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `trip_start_address` varchar(255) DEFAULT ''  COMMENT '技师出发地址';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `trip_end_address` varchar(255) DEFAULT '' COMMENT '技师到达地址';

ALTER TABLE `{$prefix}massage_service_coach_time_list` ADD COLUMN `is_click` tinyint(3) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `is_add` tinyint(3) DEFAULT '0' COMMENT '是否是加钟订单';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `add_pid` int(11) DEFAULT '0' COMMENT '加钟订单的父id';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `label_time` bigint(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_service_list` ADD COLUMN `is_add` tinyint(3) DEFAULT '0' COMMENT '是否是加钟服务';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `time_interval` int(11) DEFAULT '0' COMMENT '时间间隔 单位分钟';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `anonymous_evaluate` tinyint(3) DEFAULT '0' COMMENT '是否开启匿名评价';

ALTER TABLE `{$prefix}massage_service_refund_order` ADD COLUMN `is_add` tinyint(3) DEFAULT '0' COMMENT '是否是加钟订单';

ALTER TABLE `{$prefix}massage_service_car` ADD COLUMN `order_id` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_order_address` ADD COLUMN `address_id` int(11) DEFAULT '0';


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_shop_carte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT '' COMMENT '名称',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态 1上架 0下架 -1 删除',
  `sort` int(10) DEFAULT NULL COMMENT '排序值  倒序',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='物料分类';

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_shop_goods` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='物料商城商品';

CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coach_appeal` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='技师申诉';


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_coach_feedback` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='技师问题反馈';

ALTER TABLE `{$prefix}massage_service_car_price` ADD COLUMN `invented_distance` double(10,2) DEFAULT '0.00' COMMENT '虚拟里程';

ALTER TABLE `{$prefix}massage_service_coupon_atv` ADD COLUMN `is_atv_status` tinyint(3) DEFAULT '1';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `service_btn_color` varchar(64) DEFAULT '#282B34';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `service_font_color` varchar(64) DEFAULT '#EBDDB1';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `serout_lng` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `serout_lat` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `serout_address` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN `city_type` tinyint(3) DEFAULT '1' COMMENT '1城市代理 2区县代理';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN `admin_pid` int(11) DEFAULT '0' COMMENT '上级代理商';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN `level_balance` int(11) DEFAULT '0' COMMENT '上级';

ALTER TABLE `{$prefix}shequshop_school_admin` ADD COLUMN `city_id` int(11) DEFAULT '0' COMMENT '城市id';

ALTER TABLE `{$prefix}massage_service_city_list` ADD COLUMN `pid` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_order_commission` ADD COLUMN  `city_type` int(11) DEFAULT '1' COMMENT '1市级 2县级';

ALTER TABLE `{$prefix}massage_service_coach_level` ADD COLUMN `price` decimal(10,2) DEFAULT '0.00' COMMENT '最低业绩';

ALTER TABLE `{$prefix}massage_service_coach_level` ADD COLUMN `add_balance` int(11) DEFAULT '0' COMMENT '加钟率';

ALTER TABLE `{$prefix}massage_service_coach_level` ADD COLUMN `integral` double(10,2) DEFAULT '0.00' COMMENT '积分';

ALTER TABLE `{$prefix}massage_service_coach_level` ADD COLUMN `top` int(11) DEFAULT '0' COMMENT '等级';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `level_cycle` int(11) DEFAULT '0' COMMENT '0不限 1每周 2每月 3每季度 4每年';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `web_code_img` varchar(255) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_balance_order_list` ADD COLUMN `coach_id` int(11) DEFAULT '0';

ALTER TABLE `{$prefix}massage_service_balance_order_list` ADD COLUMN `integral` double(10,2) DEFAULT '0.00' COMMENT '积分';

ALTER TABLE `{$prefix}massage_service_coach_list` ADD COLUMN `integral` decimal(10,2) DEFAULT '0.00' COMMENT '积分';

ALTER TABLE `{$prefix}massage_service_city_list` ADD COLUMN `city_type` tinyint(3) DEFAULT '1';

ALTER TABLE `{$prefix}massage_service_city_list` ADD COLUMN `province` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_city_list` ADD COLUMN `city` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_city_list` ADD COLUMN `area` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_city_list` ADD COLUMN `id` int(11) unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE `{$prefix}massage_service_city_list` ADD COLUMN `province_code` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_city_list` ADD COLUMN `city_code` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_city_list` ADD COLUMN `area_code` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_order_list` ADD COLUMN `pay_model` int(11) DEFAULT '1';

ALTER TABLE `{$prefix}massage_service_balance_order_list` ADD COLUMN `pay_model` int(11) DEFAULT '1';

ALTER TABLE `{$prefix}massage_service_balance_order_list` ADD COLUMN `rebates_balance` int(11) DEFAULT '0' COMMENT '返佣比例';

ALTER TABLE `{$prefix}shequshop_school_pay_config` ADD COLUMN `ali_appid` varchar(64) DEFAULT '' COMMENT '支付宝appid';

ALTER TABLE `{$prefix}shequshop_school_pay_config` ADD COLUMN `ali_privatekey` text COMMENT '支付宝私钥';

ALTER TABLE `{$prefix}shequshop_school_pay_config` ADD COLUMN `ali_publickey` text COMMENT '支付宝公钥';

ALTER TABLE `{$prefix}massage_service_coach_list` ADD COLUMN `order_num` int(11) DEFAULT '0' COMMENT '技师虚拟订单数量';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `promotion_poster_img` varchar(255) DEFAULT 'https://lbqny.migugu.com/admin/anmo/mine/fx-share.png';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `bind_technician_img` varchar(255) DEFAULT 'https://lbqnyv2.migugu.com/bianzu18.png';

ALTER TABLE `{$prefix}shequshop_school_config` ADD COLUMN `is_current` tinyint(3) DEFAULT '2' COMMENT '2上个周期 1本期';





ALTER TABLE `{$prefix}massage_service_banner` ADD COLUMN   `connect_type` int(11) DEFAULT '1' COMMENT '1查看大图；2文章（默认1）\ntype_id  关联内容id\n';
ALTER TABLE `{$prefix}massage_service_banner` ADD COLUMN   `type_id` int(11) DEFAULT '1';

ALTER TABLE `{$prefix}massage_service_order_goods_list` ADD COLUMN  `status` tinyint(3) DEFAULT '1';

ALTER TABLE `{$prefix}massage_service_coach_police` ADD COLUMN `lng` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_coach_police` ADD COLUMN `lat` varchar(32) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_coach_police` ADD COLUMN `address` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN `ios_openid` varchar(64) DEFAULT '0' COMMENT '苹果登录的账号';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN `push_id` varchar(64) DEFAULT '';

ALTER TABLE `{$prefix}massage_service_user_list` ADD COLUMN `alipay_number` varchar(128) DEFAULT '' COMMENT '支付宝账号';

ALTER TABLE `{$prefix}shequshop_school_pay_config` ADD COLUMN `alipay_status` tinyint(3) DEFAULT '0';

alter table `{$prefix}massage_aliyun_reminder_record`  ADD COLUMN `status` tinyint(3) DEFAULT '1';

alter table `{$prefix}massage_service_car_price`  ADD COLUMN `city_id` int(11) DEFAULT '0' COMMENT '城市id';
alter table `{$prefix}massage_service_car_price`  ADD COLUMN `status` tinyint(3) DEFAULT '1';
alter table `{$prefix}massage_service_car_price`  ADD COLUMN `create_time` bigint(11) DEFAULT '0';

alter table `{$prefix}massage_service_coach_list`  ADD COLUMN `recommend` tinyint(3) DEFAULT '0' COMMENT '是否是推荐技师';

alter table `{$prefix}shequshop_school_pay_config`  ADD COLUMN `appCretPublicKey` varchar(255) DEFAULT '' COMMENT '支付宝应用公钥';
alter table `{$prefix}shequshop_school_pay_config`  ADD COLUMN `alipayCretPublicKey` varchar(255) DEFAULT '' COMMENT '支付宝公钥';
alter table `{$prefix}shequshop_school_pay_config`  ADD COLUMN `alipayRootCret` varchar(255) DEFAULT '' COMMENT '支付宝根证书';
alter table `{$prefix}shequshop_school_pay_config`  ADD COLUMN `alipay_type` tinyint(3) DEFAULT '1' COMMENT '1 密钥模式 2证书模式';
alter table `{$prefix}massage_service_coach_level`  ADD COLUMN `online_time` int(11) DEFAULT '0' COMMENT '在线时长小时';

alter table `{$prefix}massage_service_coach_level`  ADD COLUMN `agent_article_id` int(11) DEFAULT '0' COMMENT '代理商入住的文章id';

alter table `{$prefix}shequshop_school_config`  ADD COLUMN `agent_article_id` int(11) DEFAULT '0' COMMENT '代理商入住的文章id';

alter table `{$prefix}shequshop_school_admin`  ADD COLUMN `province` varchar(255) DEFAULT '';



alter table `{$prefix}massage_service_order_address` ADD INDEX  `order_id` (`order_id`) USING BTREE;

alter table `{$prefix}massage_service_order_goods_list` ADD INDEX  `order_id` (`order_id`) USING BTREE;

alter table `{$prefix}massage_service_order_list` ADD INDEX `uniacid` (`uniacid`) USING BTREE;

alter table `{$prefix}massage_coach_work_log` ADD INDEX `coach_id` (`coach_id`) USING BTREE;




CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_user_label_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `label_id` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `user_id` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_user_label_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_integral_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `integral` double(10,2) DEFAULT '0.00',
  `type` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `order_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





CREATE TABLE IF NOT EXISTS `{$prefix}massage_aliyun_phone_config` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_aliyun_phone_record` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_aliyun_play_record` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_aliyun_reminder_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `create_time` bigint(11) DEFAULT '0',
  `res` text COMMENT '通知结果',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `{$prefix}massage_help_notice_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `help_phone` varchar(32) DEFAULT '' COMMENT '求救电话',
  `help_user_id` text COMMENT '求救人',
  `help_voice` varchar(255) DEFAULT '' COMMENT '求救录音',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_order_price_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_price` decimal(10,2) DEFAULT '0.00',
  `can_refund_price` decimal(10,2) DEFAULT '0.00',
  `is_top` int(11) DEFAULT NULL,
  `top_order_id` int(11) DEFAULT '0',
  `transaction_id` varchar(128) DEFAULT '',
  `order_code` varchar(128) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_order_list_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT '0',
  `sign_time` bigint(11) DEFAULT '0' COMMENT '签字时间',
  `sign_img` varchar(255) DEFAULT '' COMMENT '签字图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_up_order_goods_list` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_service_up_order_list` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_article_connect` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT '0',
  `field_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_article_form_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `field_type` int(11) DEFAULT '1',
  `title` varchar(128) CHARACTER SET utf8mb4 DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `top` int(11) DEFAULT '0',
  `is_required` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_article_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `text` longtext CHARACTER SET utf8mb4,
  `is_form` tinyint(3) DEFAULT '0',
  `top` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_article_sub_data` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sub_id` int(11) DEFAULT '0',
  `field_id` int(11) DEFAULT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 DEFAULT '',
  `value` varchar(1024) CHARACTER SET utf8mb4 DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `field_type` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





CREATE TABLE IF NOT EXISTS `{$prefix}massage_article_sub_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_time` bigint(11) DEFAULT '0',
  `article_id` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `dynamic_check` tinyint(3) DEFAULT '1' COMMENT '1手动审核 2自动',
  `dynamic_comment_check` tinyint(3) DEFAULT '1',
  `app_download_img` varchar(255) DEFAULT '' COMMENT 'app下载图片',
  `android_link` varchar(255) DEFAULT '' COMMENT '安卓下载链接',
  `ios_link` varchar(255) DEFAULT '' COMMENT 'ios下载链接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_shield_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `type` tinyint(3) DEFAULT '1' COMMENT '1动态  2技师',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_coach_work_log` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_send_msg_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `help_tmpl_id` varchar(64) DEFAULT '',
  `gzh_appid` varchar(64) DEFAULT '',
  `order_tmp_id` varchar(64) DEFAULT '',
  `cancel_tmp_id` varchar(64) DEFAULT '',
  `coachupdate_tmp_id` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_short_code_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `short_sign` varchar(255) DEFAULT '' COMMENT '短信签名',
  `order_short_code` varchar(255) DEFAULT '' COMMENT '订单短信模版code',
  `refund_short_code` varchar(255) DEFAULT NULL COMMENT '退单短信模版code',
  `help_short_code` varchar(255) DEFAULT '',
  `short_code` varchar(255) DEFAULT NULL,
  `short_code_status` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_dynamic_comment` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_dynamic_follow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `have_look` tinyint(3) DEFAULT '0',
  `dynamic_id` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `dynamic_num` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_dynamic_list` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_dynamic_thumbs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `dynamic_id` int(11) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '1',
  `have_look` tinyint(3) DEFAULT '0',
  `coach_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$prefix}massage_dynamic_watch_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `dynamic_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


alter table `{$prefix}massage_config`  ADD COLUMN `dynamic_status` tinyint(3) DEFAULT '1' COMMENT '动态开关';


CREATE TABLE IF NOT EXISTS `{$prefix}massage_coach_time_log` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `{$prefix}massage_add_clock_setting` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `times` int(11) DEFAULT '1',
  `balance` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table `{$prefix}massage_config`  ADD COLUMN `clock_cash_status` tinyint(3) DEFAULT '1' COMMENT '加钟返佣金';


CREATE TABLE IF NOT EXISTS `{$prefix}massage_order_coach_change_logs` (
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
  `text` varchar(625) CHARACTER SET utf8mb4 DEFAULT '',
  `old_coach_name` varchar(255) CHARACTER SET utf8mb4 DEFAULT '',
  `start_time` bigint(11) DEFAULT '0' COMMENT '原来订单的开始时间',
  `end_time` bigint(11) DEFAULT '0' COMMENT '原来订单的结束时间',
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单技师移交记录表';



CREATE TABLE IF NOT EXISTS `{$prefix}massage_order_control_log` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `admin_control` tinyint(3) DEFAULT '0',
  `create_time` bigint(11) DEFAULT '0',
  `pay_type` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单操作日志';


alter table `{$prefix}massage_order_control_log`  ADD COLUMN  `old_pay_type` int(11) DEFAULT '0';

alter table `{$prefix}massage_order_control_log`  ADD COLUMN  `user_id` int(11) DEFAULT '0' COMMENT '用户id';

alter table `{$prefix}massage_aliyun_phone_record`  ADD COLUMN  `create_time` bigint(11) DEFAULT '0';

alter table `{$prefix}massage_aliyun_phone_record`  ADD COLUMN   `text` text;

alter table `{$prefix}massage_config`  ADD COLUMN  `balance_cash` tinyint(3) DEFAULT '0' COMMENT '余额返回佣金';

alter table `{$prefix}massage_config`  ADD COLUMN  `balance_integral` tinyint(3) DEFAULT '1' COMMENT '余额返回积分';

alter table `{$prefix}massage_config`  ADD COLUMN  `balance_balance` int(11) DEFAULT '100' COMMENT '返回的比例';


alter table `{$prefix}massage_integral_list`  ADD COLUMN  `balance` int(11) DEFAULT '0';
alter table `{$prefix}massage_integral_list`  ADD COLUMN  `user_id` int(11) DEFAULT NULL;
alter table `{$prefix}massage_integral_list`  ADD COLUMN  `user_cash` decimal(10,2) DEFAULT '0.00' COMMENT '用户充值金额';
alter table `{$prefix}massage_service_coach_list`  ADD COLUMN  `balance_cash` decimal(10,2) DEFAULT '0.00' COMMENT '邀请充值余额返回佣金';

alter table `{$prefix}massage_service_coach_list`  ADD COLUMN  `index_top` tinyint(3) DEFAULT '0' COMMENT '虚拟排序';

alter table `{$prefix}massage_aliyun_phone_config` ADD COLUMN  `notice_agent` tinyint(3) DEFAULT '0' COMMENT '是否通知代理商';



alter table `{$prefix}massage_service_wallet_list` ADD COLUMN  `apply_transfer` tinyint(3) DEFAULT '0' COMMENT '申请转账方式';

alter table `{$prefix}massage_service_wallet_list` ADD COLUMN  `lock` int(11) DEFAULT '0';

alter table `{$prefix}massage_service_coach_list` ADD COLUMN  `coach_position` tinyint(3) DEFAULT '0' COMMENT '实时定位';

alter table `{$prefix}massage_service_coach_list` ADD COLUMN  `near_time` bigint(11) DEFAULT '0';

alter table `{$prefix}massage_order_coach_change_logs` ADD COLUMN `pay_type` int(11) DEFAULT '2';

alter table `{$prefix}massage_order_coach_change_logs` ADD COLUMN `old_coach_mobile` varchar(32) DEFAULT '';

alter table `{$prefix}massage_order_coach_change_logs` ADD COLUMN `now_coach_mobile` varchar(32) DEFAULT '';

alter table `{$prefix}massage_order_coach_change_logs` ADD COLUMN `is_new` tinyint(3) DEFAULT '0';

alter table `{$prefix}shequshop_school_attachment` ADD COLUMN `admin_id` int(11) DEFAULT '0';

alter table `{$prefix}massage_aliyun_play_record` ADD COLUMN  `call_type` int(11) DEFAULT '0' COMMENT '呼叫类型。取值：\n0：主叫，即phone_no打给peer_no。\n1：被叫，即peer_no打给phone_no。\n4：呼叫拦截。';

CREATE TABLE IF NOT EXISTS `{$prefix}massage_config_setting` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `key` varchar(64) DEFAULT '',
  `value` varchar(1024) CHARACTER SET utf8mb4 DEFAULT '',
  `text` varchar(255) DEFAULT '' COMMENT '备注',
  `default_value` varchar(255) CHARACTER SET utf8mb4 DEFAULT '',
  `field_type` int(32) DEFAULT '1' COMMENT '1数字 2 字符串',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_role_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT '0',
  `role_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_role_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(64) DEFAULT '',
  `status` tinyint(3) DEFAULT '1',
  `create_time` bigint(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}massage_role_node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT '0' COMMENT '角色id',
  `node` varchar(625) DEFAULT '',
  `auth` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

updateSql;


return $sql;