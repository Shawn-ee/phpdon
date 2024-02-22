<?php
use think\facade\Route;
/**
 * @model card
 * @author yangqi
 * @create time 2019年11月25日23:09:59
 * 
 */
Route::group('admin' ,function(){
    //获取微擎版权接口
    Route::get('getW7Tmp' ,'admin/getW7Tmp');
    //后台概览
    Route::get('overview', 'admin/overview');
    //工具中心
    Route::get('tool', 'admin/toolCenter');
    //公司列表
    Route::get('company', 'admin/companyList');
    //下架 / 上架 / 删除公司
    Route::post('updateCompany', 'admin/updateCompanyStatus');
    //编辑 / 新增公司
    Route::post('editCompany', 'admin/editCompany');
    //后台公司信息
    Route::get('companyInfo', 'admin/companyInfo');
    //新增 / 编辑 部门信息
    Route::post('editDepartment', 'admin/editDepartment');
    //职位列表
    Route::get('positionList', 'admin/position');
    //下架 / 上架 / 删除职位
    Route::post('updatePosition', 'admin/updatePositionStatus');
    //编辑职位
    Route::post('editPosition', 'admin/editPosition');
    //员工列表
    Route::get('staffs', 'admin/staffs');
    //用户列表
    Route::get('cardExcel', 'admin/cardExcel');

    Route::get('users', 'admin/users');
    //取消员工 名片 / boss / 推荐
    Route::post('cancelStaff', 'admin/cancelStaff');
    //设置员工 名片 / boss / 推荐
    Route::post('setStaff', 'admin/setStaff');
    //编辑员工名片回显数据
    Route::get('staffInfo', 'admin/staffInfo');
    //编辑员工名片
    Route::post('editStaff', 'admin/editStaff');
    //分配BOSS权限回显数据
    Route::get('authBossInfo', 'admin/authBossInfo');
    //分配BOSS权限
    Route::post('editAuthBoss', 'admin/editAuthBoss');
    //重新生成员工小程序码
    Route::post('reCreateStaffQr', 'admin/createStaffQr');
    //印象标签列表
    Route::get('tags', 'admin/tags');
    //下架 / 上架 / 印象标签
    Route::post('updateTag', 'admin/updateTagStatus');
    //新增 / 编辑标签
    Route::post('editTag', 'admin/editTag');
    //免审口令
    Route::post('getAuthCode', 'admin/authCode');
    //手机创建设置
    Route::post('getPhoneCreate', 'admin/phoneCreate');
    //音频视频设置
    Route::post('getDefaultMedia', 'admin/defaultMedia');
    //默认配置
    Route::post('defaultSetting', 'admin/defaultSetting');
    //返回json
    Route::post('returnJson', 'admin/returnJson');
    //名片设置
    Route::post('getCardSetting', 'admin/cardSetting');

    Route::post('websitebind', 'admin/websitebind');
    Route::get('getPluginAuth', 'admin/getPluginAuth');
    //获取展示模块
    Route::get('getPermission', 'admin/getPermissionV2');
    Route::get('getPermissionV2', 'admin/getPermissionV2');

    Route::get('returnAdmin', 'admin/admin');
});
Route::get('getPermission', 'admin/getPermissionV2');
//小程序接口 
Route::group('app' ,function(){
    //用户在小程序授权之后跟新信息
    Route::any('clearCache', 'index/clearCacheData');
    //用户在小程序授权之后跟新信息
    Route::post('updateWechat', 'index/updateWechatInfo');
    //用户信息
    Route::get('info', 'index/userInfo');
    //名片列表
    Route::get('center', 'index/userCenter');
    //收藏名片
    Route::post('collection', 'index/collectionCard');
    //取消收藏
    Route::post('uncollection', 'index/unCollectionCard');
    //小程序配置
    Route::get('config', 'IndexV2/config');

    Route::get('configV2', 'IndexV2/configV2');
    //小程序允许使用的名片样式
    Route::get('cardTypes', 'index/cardType');
    //修改名片样式
    Route::post('editType', 'index/editCardType');
    //修改名片录音
    Route::post('editVoice', 'index/editCardVoice');
    //创建 / 编辑名片时回显数据
    Route::get('review', 'index/reviewData');
    //名片信息
    Route::get('cardInfo', 'index/cardInfo');
    //名片信息
    Route::get('cardInfoV2', 'index/cardInfoV2');

    Route::get('cardInfoDiy', 'index/cardInfoV3');
    //名片信息（统计）
    Route::get('cardCount', 'index/getCardCount');
    //默认配置
    Route::get('defaultSetting', 'index/defaultSetting');
    //编辑自我描述
    Route::post('editDesc', 'index/editDesc');
    //编辑名片图片展示
    Route::post('editImages', 'index/editImages');
    //创建 / 修改名片
    Route::post('create', 'index/createCard');
    //点赞 / 取消点赞 名片 / 语音
    Route::post('thumb', 'index/thumbStaff');
    //点赞 / 取消点赞 印象标签
    Route::post('thumbTag', 'index/thumbTag');
    //收集formId
    Route::post('reportFormId', 'index/getFormIdFromMini');
    //上报手机号
    Route::post('reportPhone', 'index/reportPhone');
    //百度上报手机号
    Route::post('baiduReportPhone', 'index/baiduReportPhone');
    //编辑标签回显数据
    Route::get('reviewTags', 'index/reviewTags');
    //编辑标签
    Route::post('editTags', 'index/editTags');
    //获取微信小程序码
    Route::post('getWxCode', 'index/getWxCode');
    //获取微信小程序码信息
    Route::get('getWxCodeData', 'index/getWxCodeData');
    //剩余通知条数
    Route::get('formIds', 'Index/formIds');
    //删除名片录音功能接口
    Route::get('clearCardInfoVoice', 'Index/clearCardInfoVoice');
    //生成
    Route::post('getQr', 'Index/getQr');
    //获取套餐是否过期
    Route::get('authStatus' , 'Index/authStatus');
    //名片首页diy
    Route::get('cardInfoDiy' , 'Index/cardInfoV3');
});


//=====================================兼容老的小程序接口=====================================


//将线上图片转为本地图片用于前端cavans画图
Route::get('getImage', 'GetImage/getImage');

Route::group('' ,function(){
    //用户在小程序授权之后跟新信息
    Route::any('clearCache', 'index/clearCacheData');
    //用户在小程序授权之后跟新信息
    Route::post('updateWechat', 'index/updateWechatInfo');
    //用户信息
    Route::get('info', 'index/userInfo');
    //名片列表
    Route::get('center', 'index/userCenter');
    //收藏名片
    Route::post('collection', 'index/collectionCard');
    //取消收藏
    Route::post('uncollection', 'index/unCollectionCard');
    //小程序配置
    Route::get('config', 'index/config');
    //小程序允许使用的名片样式
    Route::get('cardTypes', 'index/cardType');
    //修改名片样式
    Route::post('editType', 'index/editCardType');
    //修改名片录音
    Route::post('editVoice', 'index/editCardVoice');
    //创建 / 编辑名片时回显数据
    Route::get('review', 'index/reviewData');
    //名片信息
    Route::get('cardInfo', 'index/cardInfo');
    //名片信息
    Route::get('cardInfoV2', 'index/cardInfoV2');
    //名片信息（统计）
    Route::get('cardCount', 'index/getCardCount');
    //编辑自我描述
    Route::post('editDesc', 'index/editDesc');
    //编辑名片图片展示
    Route::post('editImages', 'index/editImages');
    //创建 / 修改名片
    Route::post('create', 'index/createCard');
    //点赞 / 取消点赞 名片 / 语音
    Route::post('thumb', 'index/thumbStaff');
    //点赞 / 取消点赞 印象标签
    Route::post('thumbTag', 'index/thumbTag');
    //收集formId
    Route::post('reportFormId', 'index/getFormIdFromMini');
    //上报手机号
    Route::post('reportPhone', 'index/reportPhone');
    //编辑标签回显数据
    Route::get('reviewTags', 'index/reviewTags');
    //编辑标签
    Route::post('editTags', 'index/editTags');
    //获取微信小程序码
    Route::post('getWxCode', 'index/getWxCode');
    //获取微信小程序码信息
    Route::get('getWxCodeData', 'index/getWxCodeData');
    //剩余通知条数
    Route::get('formIds', 'Index/formIds');
    //删除名片录音功能接口
    Route::get('clearCardInfoVoice', 'Index/clearCardInfoVoice');
});

