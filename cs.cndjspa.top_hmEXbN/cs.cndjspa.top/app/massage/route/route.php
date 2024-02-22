<?php

use think\facade\Route;

//商城后端路由表
Route::group('admin', function () {
    //商品列表
    Route::post('Admin/login', 'Admin/login');

    Route::get('Admin/getConfig', 'Admin/getConfig');

    Route::get('Admin/getW7TmpV2', 'Admin/getW7TmpV2');
    //配置详情
    Route::post('AdminSetting/configInfo', 'AdminSetting/configInfo');
    //车费配置详情
    Route::get('AdminSetting/carConfigInfo', 'AdminSetting/carConfigInfo');
    //编辑车费配置
    Route::post('AdminSetting/carConfigUpdate', 'AdminSetting/carConfigUpdate');
    //配置修改
    Route::post('AdminSetting/configUpdate', 'AdminSetting/configUpdate');

    Route::post('AdminSetting/payConfigInfo', 'AdminSetting/payConfigInfo');

    Route::post('AdminSetting/payConfigUpdate', 'AdminSetting/payConfigUpdate');
    //banne列表
    Route::post('AdminSetting/bannerList', 'AdminSetting/bannerList');
    //banner添加
    Route::post('AdminSetting/bannerAdd', 'AdminSetting/bannerAdd');
    //banner编辑
    Route::post('AdminSetting/bannerUpdate', 'AdminSetting/bannerUpdate');
    //banner详情（id）
    Route::get('AdminSetting/bannerInfo', 'AdminSetting/bannerInfo');
    //修改密码（pass）
    Route::post('AdminSetting/updatePass', 'AdminSetting/updatePass');
    //评价标签列表
    Route::get('AdminSetting/lableList', 'AdminSetting/lableList');
    //评价标签详情
    Route::get('AdminSetting/lableInfo', 'AdminSetting/lableInfo');
    //添加评价标签
    Route::post('AdminSetting/lableAdd', 'AdminSetting/lableAdd');
    //编辑评价标签
    Route::post('AdminSetting/lableUpdate', 'AdminSetting/lableUpdate');

    Route::get('AdminSetting/adminList', 'AdminSetting/adminList');

    Route::get('AdminSetting/adminInfo', 'AdminSetting/adminInfo');

    Route::post('AdminSetting/adminAdd', 'AdminSetting/adminAdd');

    Route::post('AdminSetting/adminUpdate', 'AdminSetting/adminUpdate');

    Route::post('AdminSetting/adminStatusUpdate', 'AdminSetting/adminStatusUpdate');

    Route::get('AdminSetting/userSelect', 'AdminSetting/userSelect');

    Route::get('AdminSetting/cityList', 'AdminSetting/cityList');

    Route::get('AdminSetting/cityInfo', 'AdminSetting/cityInfo');

    Route::get('AdminSetting/citySelect', 'AdminSetting/citySelect');

    Route::post('AdminSetting/cityAdd', 'AdminSetting/cityAdd');

    Route::post('AdminSetting/cityUpdate', 'AdminSetting/cityUpdate');

    Route::get('AdminSetting/adminSelect', 'AdminSetting/adminSelect');

    Route::get('AdminSetting/getSaasAuth', 'AdminSetting/getSaasAuth');

    Route::get('AdminSetting/helpConfigInfo', 'AdminSetting/helpConfigInfo');

    Route::post('AdminSetting/helpConfigUpate', 'AdminSetting/helpConfigUpate');

    Route::get('AdminSetting/sendMsgConfigInfo', 'AdminSetting/sendMsgConfigInfo');

    Route::post('AdminSetting/sendMsgConfigUpdate', 'AdminSetting/sendMsgConfigUpdate');

    Route::get('AdminSetting/shortCodeConfigInfo', 'AdminSetting/shortCodeConfigInfo');

    Route::post('AdminSetting/shortCodeConfigUpdate', 'AdminSetting/shortCodeConfigUpdate');

    Route::get('AdminSetting/addClockInfo', 'AdminSetting/addClockInfo');

    Route::get('AdminSetting/provinceList', 'AdminSetting/provinceList');

    Route::post('AdminSetting/addClockUpdate', 'AdminSetting/addClockUpdate');

    //技师列表
    Route::get('AdminCoach/coachList', 'AdminCoach/coachList');
    //技师详情
    Route::get('AdminCoach/coachInfo', 'AdminCoach/coachInfo');
    //技师审核(status2通过,3拒绝,sh_text)
    Route::post('AdminCoach/coachUpdate', 'AdminCoach/coachUpdate');
    //技师等级列表
    Route::get('AdminCoach/levelList', 'AdminCoach/levelList');
    //添加技师等级
    Route::post('AdminCoach/levelAdd', 'AdminCoach/levelAdd');
    //编辑技师等级
    Route::post('AdminCoach/levelUpdate', 'AdminCoach/levelUpdate');
    //技师等级详情
    Route::get('AdminCoach/levelInfo', 'AdminCoach/levelInfo');
    //技师提现申请列表(type1是服务费提现，2是车费)
    Route::get('AdminCoach/walletList', 'AdminCoach/walletList');
    //提现详情
    Route::get('AdminCoach/walletInfo', 'AdminCoach/walletInfo');
    //通过提现(online:1线上，0线下)
    Route::post('AdminCoach/walletPass', 'AdminCoach/walletPass');
    //拒绝提现
    Route::post('AdminCoach/walletNoPass', 'AdminCoach/walletNoPass');
    //报警列表
    Route::get('AdminCoach/policeList', 'AdminCoach/policeList');
    //编辑报警
    Route::post('AdminCoach/policeUpdate', 'AdminCoach/policeUpdate');


    //优惠券列表(搜索：name)
    Route::get('AdminCoupon/couponList', 'AdminCoupon/couponList');
    //优惠券详情（id）
    Route::get('AdminCoupon/couponInfo', 'AdminCoupon/couponInfo');
    //添加优惠券
    Route::post('AdminCoupon/couponAdd', 'AdminCoupon/couponAdd');
    //编辑优惠券
    Route::post('AdminCoupon/couponUpdate', 'AdminCoupon/couponUpdate');
    //活动详情
    Route::get('AdminCoupon/couponAtvInfo', 'AdminCoupon/couponAtvInfo');
    //编辑活动
    Route::post('AdminCoupon/couponAtvUpdate', 'AdminCoupon/couponAtvUpdate');
    //后台派发卡券(coupon_id,user_id)
    Route::post('AdminCoupon/couponRecordAdd', 'AdminCoupon/couponRecordAdd');


    //储值充值卡列表
    Route::get('AdminBalance/cardList', 'AdminBalance/cardList');
    //储值充值卡列表
    Route::post('AdminBalance/cardAdd', 'AdminBalance/cardAdd');
    //编辑充值卡
    Route::post('AdminBalance/cardUpdate', 'AdminBalance/cardUpdate');
    //充值卡详情
    Route::get('AdminBalance/cardInfo', 'AdminBalance/cardInfo');
    //储值订单列表
    Route::get('AdminBalance/orderList', 'AdminBalance/orderList');
    //充值订单详情
    Route::get('AdminBalance/orderInfo', 'AdminBalance/orderInfo');

    Route::get('AdminBalance/orderInfo', 'AdminBalance/orderInfo');
    //服务列表(搜索：name)
    Route::get('AdminService/serviceList', 'AdminService/serviceList');
    //服务详情
    Route::get('AdminService/serviceInfo', 'AdminService/serviceInfo');
    //添加服务
    Route::post('AdminService/serviceAdd', 'AdminService/serviceAdd');
    //编辑服务|上下架删除
    Route::post('AdminService/serviceUpdate', 'AdminService/serviceUpdate');


    //后台提现列表
    Route::get('AdminCoach/walletList', 'AdminCoach/walletList');
    //同意打款（id,status=2,online 1：线上，0线下）
    Route::post('AdminCoach/walletPass', 'AdminCoach/walletPass');
    //拒绝打款（id,status=3）
    Route::post('AdminCoach/walletNoPass', 'AdminCoach/walletNoPass');
    //财务管理
    Route::get('AdminCoach/financeList', 'AdminCoach/financeList');

    Route::get('AdminCoach/userLabelList', 'AdminCoach/userLabelList');


    Route::get('AdminCoach/coachUserList', 'AdminCoach/coachUserList');

    Route::post('AdminCoach/coachAdd', 'AdminCoach/coachAdd');

    Route::post('AdminCoach/coachUpdateCheck', 'AdminCoach/coachUpdateCheck');

    Route::get('AdminCoach/coachUpdateInfo', 'AdminCoach/coachUpdateInfo');
    //商品列表
    Route::get('AdminGoods/goodsList', 'AdminGoods/goodsList');
    //审核商品数量
    Route::get('AdminGoods/goodsCount', 'AdminGoods/goodsCount');
    //审核详情
    Route::get('AdminGoods/shInfo', 'AdminGoods/shInfo');
    //审核商品详情
    Route::get('AdminGoods/shGoodsInfo', 'AdminGoods/shGoodsInfo');
    //同意|驳回申请 status 2 同意 3驳回
    Route::post('AdminGoods/shUpdate', 'AdminGoods/shUpdate');
    //用户列表
    Route::get('AdminUser/userList', 'AdminUser/userList');
    //退款列表
    Route::get('AdminOrder/refundOrderList', 'AdminOrder/refundOrderList');
    //订单列表
    Route::get('AdminOrder/orderList', 'AdminOrder/orderList');
    //订单详情
    Route::get('AdminOrder/orderInfo', 'AdminOrder/orderInfo');
    //退款详情
    Route::get('AdminOrder/refundOrderInfo', 'AdminOrder/refundOrderInfo');
    //拒绝退款
    Route::post('AdminOrder/noPassRefund', 'AdminOrder/noPassRefund');
    //同意退款
    Route::post('AdminOrder/passRefund', 'AdminOrder/passRefund');
    //订单评价列表
    Route::get('AdminOrder/commentList', 'AdminOrder/commentList');
    //编辑订单评价
    Route::post('AdminOrder/commentUpdate', 'AdminOrder/commentUpdate');
    //评价标签列表
    Route::get('AdminOrder/commentLableList', 'AdminOrder/commentLableList');
    //评价标签详情
    Route::get('AdminOrder/commentLableInfo', 'AdminOrder/commentLableInfo');
    //添加评价标签
    Route::post('AdminOrder/commentLableAdd', 'AdminOrder/commentLableAdd');
    //编辑评价标签
    Route::post('AdminOrder/commentLableUpdate', 'AdminOrder/commentLableUpdate');
    //提示列表(type,have_look,start_time,end_time)
    Route::get('AdminOrder/noticeList', 'AdminOrder/noticeList');
    //编辑提示()
    Route::post('AdminOrder/noticeUpdate', 'AdminOrder/noticeUpdate');
    //未查看的数量
    Route::post('AdminOrder/noLookCount', 'AdminOrder/noLookCount');
    //全部已读
    Route::post('AdminOrder/allLook', 'AdminOrder/allLook');

    Route::post('AdminOrder/adminUpdateOrder', 'AdminOrder/adminUpdateOrder');

    Route::post('AdminOrder/orderChangeCoach', 'AdminOrder/orderChangeCoach');

    Route::get('AdminOrder/orderChangeCoachList', 'AdminOrder/orderChangeCoachList');

    Route::get('AdminOrder/orderUpRecord', 'AdminOrder/orderUpRecord');
    //订单导出
    Route::get('AdminExcel/orderList', 'AdminExcel/orderList');
    //财务导出
    Route::get('AdminExcel/dateCount', 'AdminExcel/dateCount');

    Route::get('AdminExcel/subDataList', 'AdminExcel/subDataList');
    //打印机详情(id)
    Route::get('AdminPrinter/printerInfo', 'AdminPrinter/printerInfo');
    //编辑打印机
    Route::post('AdminPrinter/printerUpdate', 'AdminPrinter/printerUpdate');
    //打印机列表
    Route::get('AdminPrinter/printerList', 'AdminPrinter/printerList');
    //打印机添加
    Route::post('AdminPrinter/printerAdd', 'AdminPrinter/printerAdd');
    //佣金记录
    Route::post('AdminUser/commList', 'AdminUser/commList');

//    Route::get('AdminUser/commList', 'AdminUser/commList');
    Route::get('AdminUser/commList', 'AdminUser/cashList');

    Route::get('AdminUser/cashList', 'AdminUser/cashList');

    Route::post('AdminUser/delUserLabel', 'AdminUser/delUserLabel');

    Route::post('AdminUser/applyWallet', 'AdminUser/applyWallet');

    Route::get('AdminReseller/resellerList', 'AdminReseller/resellerList');

    Route::get('AdminReseller/resellerInfo', 'AdminReseller/resellerInfo');

    Route::post('AdminReseller/resellerUpdate', 'AdminReseller/resellerUpdate');


    Route::group('AdminChannel', function () {

        Route::get('cateList', 'AdminChannel/cateList');

        Route::get('cateSelect', 'AdminChannel/cateSelect');

        Route::get('channelSelect', 'AdminChannel/channelSelect');

        Route::post('cateAdd', 'AdminChannel/cateAdd');

        Route::post('cateUpdate', 'AdminChannel/cateUpdate');

        Route::get('cateInfo', 'AdminChannel/cateInfo');

        Route::get('channelList', 'AdminChannel/channelList');

        Route::get('channelInfo', 'AdminChannel/channelInfo');

        Route::post('channelUpdate', 'AdminChannel/channelUpdate');

    });

    /********************按摩6.0接口**********************/
    //添加物料分类
    Route::post('AdminShop/addCarte', 'AdminShop/addCarte');
    //编辑物料分类
    Route::post('AdminShop/editCarte', 'AdminShop/editCarte');
    Route::get('AdminShop/editCarte', 'AdminShop/editCarte');
    //分类列表
    Route::get('AdminShop/carteList', 'AdminShop/carteList');
    //上下架、删除
    Route::post('AdminShop/carteStatus', 'AdminShop/carteStatus');


    //分类下拉
    Route::get('AdminShop/goodsCarteList', 'AdminShop/goodsCarteList');
    //添加商品
    Route::post('AdminShop/addGoods', 'AdminShop/addGoods');
    //编辑商品
    Route::post('AdminShop/editGoods', 'AdminShop/editGoods');
    Route::get('AdminShop/editGoods', 'AdminShop/editGoods');
    //商品列表
    Route::get('AdminShop/goodsList', 'AdminShop/goodsList');
    //商品上下架、删除
    Route::post('AdminShop/goodsStatus', 'AdminShop/goodsStatus');


    //反馈记录列表
    Route::get('AdminSetting/feedbackList', 'AdminSetting/feedbackList');
    //反馈记录详情
    Route::get('AdminSetting/feedbackInfo', 'AdminSetting/feedbackInfo');
    //处理反馈记录
    Route::post('AdminSetting/feedbackHandle', 'AdminSetting/feedbackHandle');
    //申诉记录列表
    Route::get('AdminSetting/appealList', 'AdminSetting/appealList');
    //申诉记录详情
    Route::get('AdminSetting/appealInfo', 'AdminSetting/appealInfo');
    //处理申诉记录
    Route::post('AdminSetting/appealHandle', 'AdminSetting/appealHandle');

    Route::post('AdminSetting/configUpdateSchedule', 'AdminSetting/configUpdateSchedule');

    Route::get('AdminSetting/configInfoSchedule', 'AdminSetting/configInfoSchedule');

    Route::get('AdminSetting/getCarConfigList', 'AdminSetting/getCarConfigList');

    Route::get('AdminSetting/getCarConfigInfo', 'AdminSetting/getCarConfigInfo');

    Route::post('AdminSetting/getCarConfigAdd', 'AdminSetting/getCarConfigAdd');

    Route::post('AdminSetting/getCarConfigUpdate', 'AdminSetting/getCarConfigUpdate');

    Route::post('AdminSetting/getCarConfigDel', 'AdminSetting/getCarConfigDel');

    Route::get('AdminSetting/configSettingInfo', 'AdminSetting/configSettingInfo');

    Route::post('AdminSetting/configSettingUpdate', 'AdminSetting/configSettingUpdate');




    Route::get('AdminSetting/userLabelList', 'AdminSetting/userLabelList');

    Route::get('AdminSetting/userLabelInfo', 'AdminSetting/userLabelInfo');

    Route::post('AdminSetting/userLabelUpdate', 'AdminSetting/userLabelUpdate');

    Route::post('AdminSetting/userLabelAdd', 'AdminSetting/userLabelAdd');

    Route::get('AdminIndex/orderData', 'AdminIndex/orderData');

    Route::get('AdminIndex/agentOrderData', 'AdminIndex/agentOrderData');

    Route::get('AdminIndex/coachAndUserData', 'AdminIndex/coachAndUserData');
    //
    Route::get('AdminIndex/coachSaleData', 'AdminIndex/coachSaleData');


    Route::group('AdminArticle', function () {

        Route::get('fieldList', 'AdminArticle/fieldList');
        Route::get('fieldSelect', 'AdminArticle/fieldSelect');

        Route::get('fieldInfo', 'AdminArticle/fieldInfo');

        Route::get('articleList', 'AdminArticle/articleList');

        Route::post('fieldAdd', 'AdminArticle/fieldAdd');

        Route::post('fieldUpdate', 'AdminArticle/fieldUpdate');

        Route::get('articleInfo', 'AdminArticle/articleInfo');

        Route::post('articleAdd', 'AdminArticle/articleAdd');

        Route::post('articleUpdate', 'AdminArticle/articleUpdate');

        Route::get('subTitle', 'AdminArticle/subTitle');

        Route::get('subDataList', 'AdminArticle/subDataList');

    });


});


//商城后端路由表
Route::group('app', function () {
    //首页
    Route::get('Index/index', 'Index/index');

    Route::get('Index/plugAuth', 'Index/plugAuth');

    Route::get('Index/recommendCoach', 'Index/recommendCoach');

    Route::get('Index/getCity', 'Index/getCity');

    Route::get('Index/couponList', 'Index/couponList');

    Route::post('Index/userGetCoupon', 'Index/userGetCoupon');

    Route::get('Index/coachInfo', 'Index/coachInfo');
    //再来一单(order_id)
    Route::post('Index/onceMoreOrder', 'Index/onceMoreOrder');
    //评价列表(coach_id)
    Route::get('Index/commentList', 'Index/commentList');
    //服务列表(sort:price 价格排序 ，total_sale销量排序 star评价排序 ,)
    Route::get('Index/serviceList', 'Index/serviceList');
    //服务详情(id)
    Route::get('Index/serviceInfo', 'Index/serviceInfo');
    //服务技师列表(ser_id，服务id,lat,lng)
    Route::get('Index/serviceCoachList', 'Index/serviceCoachList');
    //技师服务列表(coach_id)
    Route::get('Index/coachServiceList', 'Index/coachServiceList');

    Route::get('Index/getMapInfo', 'Index/getMapInfo');

    Route::get('Index/typeServiceCoachList', 'Index/typeServiceCoachList');

    Route::post('IndexUser/delUserInfo', 'IndexUser/delUserInfo');
    //用户授权
    Route::post('IndexUser/userUpdate', 'IndexUser/userUpdate');

    Route::post('IndexUser/attestationCoach', 'IndexUser/attestationCoach');
    //申请技师
    Route::post('IndexUser/coachApply', 'IndexUser/coachApply');
    //教练收藏列表
    Route::get('IndexUser/coachCollectList', 'IndexUser/coachCollectList');
    //添加技师收藏(coach_id)
    Route::post('IndexUser/addCollect', 'IndexUser/addCollect');
    //删除技师收藏(coach_id)
    Route::post('IndexUser/delCollect', 'IndexUser/delCollect');

    Route::post('IndexUser/shieldCoachAdd', 'IndexUser/shieldCoachAdd');

    Route::post('IndexUser/shieldCoachDel', 'IndexUser/shieldCoachDel');

    Route::get('IndexUser/shieldCoachList', 'IndexUser/shieldCoachList');

    Route::get('IndexUser/userInfo', 'IndexUser/userInfo');

    Route::post('IndexUser/reportPhone', 'IndexUser/reportPhone');
    //优惠券活动详情
    Route::post('IndexUser/couponAtvInfo', 'IndexUser/couponAtvInfo');
    //用户|团长个人中心
    Route::get('IndexUser/index', 'IndexUser/index');
    //个人团长信息
    Route::get('IndexUser/coachInfo', 'IndexUser/coachInfo');
    //用户地址列表
    Route::get('IndexUser/addressList', 'IndexUser/addressList');

    Route::get('IndexUser/getVirtualPhone', 'IndexUser/getVirtualPhone');
    //地址详情
    Route::get('IndexUser/addressInfo', 'IndexUser/addressInfo');
    //添加地址
    Route::post('IndexUser/addressAdd', 'IndexUser/addressAdd');
    //编辑地址
    Route::post('IndexUser/addressUpdate', 'IndexUser/addressUpdate');
    //删除地址
    Route::post('IndexUser/addressDel', 'IndexUser/addressDel');
    //获取默认地址
    Route::get('IndexUser/getDefultAddress', 'IndexUser/getDefultAddress');
    //活动二维码
    Route::post('IndexUser/atvQr', 'IndexUser/atvQr');
    //用户优惠券列表（status1，2，3）
    Route::get('IndexUser/userCouponList', 'IndexUser/userCouponList');
    //删除优惠券（coupon_id）
    Route::post('IndexUser/couponDel', 'IndexUser/couponDel');
    //获取配置信息
    Route::get('Index/configInfo', 'Index/configInfo');
    //技师首页
    Route::get('IndexCoach/coachIndex', 'IndexCoach/coachIndex');
    //技师编辑
    Route::post('IndexCoach/coachUpdate', 'IndexCoach/coachUpdate');
    //团长核销订单（id）
    Route::post('IndexCoach/hxOrder', 'IndexCoach/hxOrder');
    //订单列表
    Route::get('IndexCoach/orderList', 'IndexCoach/orderList');
    //团长佣金信息
    Route::get('IndexCoach/capCashInfo', 'IndexCoach/capCashInfo');
    //团长佣金信息(车费)
    Route::get('IndexCoach/capCashInfoCar', 'IndexCoach/capCashInfoCar');

    Route::get('IndexCoach/balanceCommissionList', 'IndexCoach/balanceCommissionList');

    Route::get('IndexCoach/balanceCommissionData', 'IndexCoach/balanceCommissionData');
    //提现记录
    Route::get('IndexCoach/capCashList', 'IndexCoach/capCashList');
    //申请提现(apply_price,text,type：1服务费提现，2车费提现)
    Route::post('IndexCoach/applyWallet', 'IndexCoach/applyWallet');
    //技师获取虚拟电话 order_id
    Route::post('IndexCoach/getVirtualPhone', 'IndexCoach/getVirtualPhone');
    //报警
    Route::post('IndexCoach/police', 'IndexCoach/police');
    //技师修改订单信息(type,order_id)
    Route::post('IndexCoach/updateOrder', 'IndexCoach/updateOrder');

    Route::post('IndexCoach/coachUpdateV2', 'IndexCoach/coachUpdateV2');

    Route::post('IndexCoach/shieldUserAdd', 'IndexCoach/shieldUserAdd');

    Route::post('IndexCoach/shieldUserDel', 'IndexCoach/shieldUserDel');

    Route::get('IndexCoach/shieldCoachList', 'IndexCoach/shieldCoachList');


    Route::get('IndexGoods/indexCapList', 'IndexGoods/indexCapList');
    //选择楼长(cap_id)
    Route::post('IndexGoods/selectCap', 'IndexGoods/selectCap');
    //分类列表
    Route::get('IndexGoods/cateList', 'IndexGoods/cateList');
    //商品首页信息
    Route::get('IndexGoods/index', 'IndexGoods/index');

    //商品列表
    Route::get('IndexGoods/goodsList', 'IndexGoods/goodsList');
    //商品详情
    Route::get('IndexGoods/goodsInfo', 'IndexGoods/goodsInfo');

    //购物车信息（coach_id）
    Route::get('Index/carInfo', 'Index/carInfo');
    //添加购物车（service_id,coach_id,num = 1）
    Route::post('Index/addCar', 'Index/addCar');
    //删除购物车|减少购物车商品数量（id,num=1）
    Route::post('Index/delCar', 'Index/delCar');
    //批量删除购物车（coach）
    Route::post('Index/delSomeCar', 'Index/delSomeCar');
    //修改购物车（ID ：arr）
    Route::post('Index/carUpdate', 'Index/carUpdate');
    //
    Route::post('IndexOrder/payOrder', 'IndexOrder/payOrder');
    //下单的那个页面(coach_id，有优惠券就传 coupon_id)
    Route::get('IndexOrder/payOrderInfo', 'IndexOrder/payOrderInfo');
    //用户订单列表（pay_type,name）
    Route::get('IndexOrder/orderList', 'IndexOrder/orderList');

    Route::post('IndexOrder/delOrder', 'IndexOrder/delOrder');

    Route::get('IndexOrder/getUpOrderGoods', 'IndexOrder/getUpOrderGoods');

    Route::any('IndexOrder/upOrderGoods', 'IndexOrder/upOrderGoods');
    //订单详情
    Route::get('IndexOrder/orderInfo', 'IndexOrder/orderInfo');
    //重新支付
    Route::post('IndexOrder/rePayOrder', 'IndexOrder/rePayOrder');
    //取消订单
    Route::post('IndexOrder/cancelOrder', 'IndexOrder/cancelOrder');
    //申请退款（order_id,list:['id','num']）
    Route::post('IndexOrder/applyOrder', 'IndexOrder/applyOrder');
    //取消退款
    Route::post('IndexOrder/cancelRefundOrder', 'IndexOrder/cancelRefundOrder');
    //用户端退款列表（name,status）
    Route::get('IndexOrder/refundOrderList', 'IndexOrder/refundOrderList');
    //退款详情
    Route::get('IndexOrder/refundOrderInfo', 'IndexOrder/refundOrderInfo');
    //刷新订单二维码(id)
    Route::post('IndexOrder/refreshQr', 'IndexOrder/refreshQr');

    Route::post('IndexOrder/checkAddOrder', 'IndexOrder/checkAddOrder');
    //选中时间(coach_id,day)
    Route::get('IndexOrder/timeText', 'IndexOrder/timeText');

    Route::get('IndexOrder/dayText', 'IndexOrder/dayText');
    //添加评价(order_id,text，star)
    Route::post('IndexOrder/addComment', 'IndexOrder/addComment');

    Route::get('IndexOrder/lableList', 'IndexOrder/lableList');
    //可用的优惠券(coach_id)
    Route::get('IndexOrder/couponList', 'IndexOrder/couponList');

    Route::post('IndexOrder/userSignOrder', 'IndexOrder/userSignOrder');

    Route::get('IndexOrder/orderUpRecord', 'IndexOrder/orderUpRecord');

    Route::get('IndexOrder/getAddClockOrder', 'IndexOrder/getAddClockOrder');

    Route::post('IndexOrder/upOrderInfo', 'IndexOrder/upOrderInfo');

    //储值充值卡列表
    Route::get('IndexBalance/cardList', 'IndexBalance/cardList');

    Route::get('IndexBalance/coachList', 'IndexBalance/coachList');
    //充值余额(card_id)
    Route::post('IndexBalance/payBalanceOrder', 'IndexBalance/payBalanceOrder');
    //充值订单列表(时间筛选 start_time,end_time)
    Route::get('IndexBalance/balaceOrder', 'IndexBalance/balaceOrder');
    //消费明细
    Route::get('IndexBalance/payWater', 'IndexBalance/payWater');
    //佣金列表 status 0,1,2
    Route::get('IndexUser/commList', 'IndexUser/commList');
    //img
    Route::post('IndexUser/base64ToImg', 'IndexUser/base64ToImg');

    Route::get('IndexUser/adminCoachQr', 'IndexUser/adminCoachQr');

    Route::get('IndexUser/userCashInfo', 'IndexUser/userCashInfo');

    Route::post('IndexUser/applyWallet', 'IndexUser/applyWallet');

    Route::post('IndexUser/bindAlipayNumber', 'IndexUser/bindAlipayNumber');

    Route::get('IndexUser/walletList', 'IndexUser/walletList');

    Route::get('IndexUser/myTeam', 'IndexUser/myTeam');

    Route::get('IndexUser/userCommQr', 'IndexUser/userCommQr');
    //申请分销商 user_name mobile
    Route::post('IndexUser/applyReseller', 'IndexUser/applyReseller');

    Route::get('IndexUser/resellerInfo', 'IndexUser/resellerInfo');


    Route::get('IndexOrder/getIsBus', 'IndexOrder/getIsBus');

    //申请分销商 user_name mobile
    Route::post('IndexUser/applyChannel', 'IndexUser/applyChannel');

    Route::get('IndexUser/channelInfo', 'IndexUser/channelInfo');

    Route::get('IndexUser/channelCateSelect', 'IndexUser/channelCateSelect');

    Route::post('IndexUser/sendShortMsg', 'IndexUser/sendShortMsg');

    Route::post('IndexUser/bindUserPhone', 'IndexUser/bindUserPhone');


    Route::group('IndexChannel', function () {

        Route::get('index', 'IndexChannel/index');

        Route::get('channelQr', 'IndexChannel/channelQr');

        Route::get('orderList', 'IndexChannel/orderList');


    });

    /********************按摩6.0接口**********************/

    //技师时间管理回显
    Route::get('IndexCoach/timeConfig', 'IndexCoach/getTimeConfig');
    //技师时间管理设置
    Route::post('IndexCoach/timeConfig', 'IndexCoach/setTimeConfig');
    //技师接单时间获取时间节点
    Route::get('IndexCoach/getTime', 'IndexCoach/getTime');
    //技师车费明细列表
    Route::get('IndexCoach/carMoneyList', 'IndexCoach/carMoneyList');
    //订单数量
    Route::get('IndexCoach/getOrderNum', 'IndexCoach/getOrderNum');
    //物料商城-商品列表
    Route::get('IndexCoach/goodsList', 'IndexCoach/goodsList');
    //物料商城-分类列表
    Route::get('IndexCoach/carteList', 'IndexCoach/carteList');
    //物料商城-商品详情
    Route::get('IndexCoach/goodsInfo', 'IndexCoach/goodsInfo');
    //添加反馈
    Route::post('IndexCoach/addFeedback', 'IndexUser/addFeedback');
    //反馈列表
    Route::get('IndexCoach/listFeedback', 'IndexUser/listFeedback');
    //反馈详情
    Route::get('IndexCoach/feedbackInfo', 'IndexUser/feedbackInfo');
    //提交申诉
    Route::post('IndexCoach/addAppeal', 'IndexCoach/addAppeal');
    //申诉记录列表
    Route::get('IndexCoach/appealList', 'IndexCoach/appealList');
    //订单列表
    Route::get('IndexCoach/appealOrder', 'IndexCoach/appealOrder');

    Route::get('IndexCoach/userLabelList', 'IndexCoach/userLabelList');

    Route::get('IndexCoach/labelList', 'IndexCoach/labelList');

    Route::get('IndexCoach/orderInfo', 'IndexCoach/orderInfo');

    Route::post('IndexCoach/userLabelAdd', 'IndexCoach/userLabelAdd');

    Route::get('IndexCoach/coachBalanceQr', 'IndexCoach/coachBalanceQr');
    Route::get('IndexCoach/coachLevel', 'IndexCoach/coachLevel');

    Route::get('IndexCoach/coachCommissionList', 'IndexCoach/coachCommissionList');

    Route::get('IndexCoach/coachCommissionData', 'IndexCoach/coachCommissionData');

    Route::get('IndexCoach/coachCommissionInfo', 'IndexCoach/coachCommissionInfo');


    Route::group('IndexArticle', function () {

        Route::get('articleList', 'IndexArticle/articleList');

        Route::get('articleInfo', 'IndexArticle/articleInfo');

        Route::post('subArticleForm', 'IndexArticle/subArticleForm');

    });

});


//支付
Route::any('IndexWxPay/returnPay', 'IndexWxPay/returnPay');

Route::any('IndexWxPay/aliNotify', 'IndexWxPay/aliNotify');

Route::any('IndexWxPay/aliNotifyBalance', 'IndexWxPay/aliNotifyBalance');















