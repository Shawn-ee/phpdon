(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-mine"],{"071e":function(t,e,i){var n=i("60af");n.__esModule&&(n=n.default),"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("c6773f0e",n,!0,{sourceMap:!1,shadowMode:!1})},"2e31":function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return a})),i.d(e,"a",(function(){}));var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return t.isLoad?i("v-uni-view",{staticClass:"pages-mine"},[i("v-uni-image",{staticClass:"mine-bg abs",attrs:{mode:"aspectFill","lazy-load":!0,src:t.configInfo[t.image_type[t.userPageType]]}}),1==t.userPageType?[i("v-uni-view",{staticClass:"pd-lg",staticStyle:{height:"292rpx"}},[i("v-uni-view",{staticClass:"pt-lg rel",class:[{"flex-warp":t.userInfo.nickName},{"flex-center":!t.userInfo.nickName}]},[i("v-uni-view",{staticClass:"avatar_view",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.authUserProfile.apply(void 0,arguments)}}},[i("v-uni-image",{staticClass:"avatar radius",attrs:{mode:"aspectFill",src:t.userInfo.avatarUrl||"/static/mine/default_user.png"}}),t.userInfo.id&&1==t.mineInfo.is_admin?i("v-uni-view",{staticClass:"text",style:{color:t.primaryColor}},[t._v("代理商")]):t._e()],1),!t.userInfo||t.userInfo&&!t.userInfo.id?i("v-uni-view",{staticClass:"flex-1 f-md-title text-bold ml-md",style:{color:t.configInfo[t.font_type[t.userPageType]]},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.authUserProfile.apply(void 0,arguments)}}},[t._v("登录")]):i("v-uni-view",{staticClass:"flex-1 ml-md mt-sm rel",style:{color:t.configInfo[t.font_type[t.userPageType]]}},[i("v-uni-view",{staticClass:"flex-between"},[i("v-uni-view",{staticClass:"flex-y-center f-title text-bold",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.authUserProfile.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"mr-sm max-500 ellipsis"},[t._v(t._s(t.userInfo.nickName||"默认用户"))])],1),i("v-uni-view",{staticClass:"notice-item ml-md",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.$util.goUrl({url:"/user/pages/setting"})}}},[i("i",{staticClass:"iconfont icon-xitong text-bold"})])],1),i("v-uni-view",{staticClass:"flex-between"},[i("v-uni-view",{staticClass:"member-tag flex-center mt-sm pl-md pr-md f-caption radius "},[i("i",{staticClass:"iconfont iconhuiyuanka mr-sm"}),t._v(t._s(2===t.mineInfo.coach_status?t.mineInfo.coach_level.title||"技师":"普通用户"))]),i("v-uni-view",{staticClass:"f-desc"},[2===t.mineInfo.coach_status&&1*t.mineInfo.service_time_long>0?[t._v(t._s("已服务"+t.mineInfo.service_time_long+"分钟"))]:t._e()],2)],1)],1)],1)],1),i("v-uni-view",{staticClass:"share-collect-list flex-x-center pd-lg mt-sm ml-md mr-md fill-base box-shadow radius-20 rel"},[i("v-uni-view",{staticClass:"share-item flex-center flex-column",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.$util.toCheckLogin({url:"/user/pages/coupon/list"})}}},[i("v-uni-view",{staticClass:"f-sm-title text-bold"},[t._v(t._s(t.mineInfo.coupon_count||0))]),i("v-uni-view",{staticClass:"f-caption c-caption"},[t._v("卡券")])],1),t.plugAuth.dynamic?i("v-uni-view",{staticClass:"share-item flex-center flex-column",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.$util.toCheckLogin({url:"/user/pages/follow"})}}},[i("v-uni-view",{staticClass:"f-sm-title text-bold"},[t._v(t._s(t.mineInfo.follow_count||0))]),i("v-uni-view",{staticClass:"f-caption c-caption"},[t._v("关注")])],1):t._e(),i("v-uni-view",{staticClass:"share-item flex-center flex-column",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.$util.toCheckLogin({url:"/user/pages/collect"})}}},[i("v-uni-view",{staticClass:"f-sm-title text-bold"},[t._v(t._s(t.mineInfo.collect_count||0))]),i("v-uni-view",{staticClass:"f-caption c-caption"},[t._v("收藏")])],1)],1),i("auth",{attrs:{needAuth:t.userInfo&&(!t.userInfo.phone||!t.userInfo.nickName),must:!0,type:t.userInfo.phone?"userInfo":"phone"},on:{go:function(e){arguments[0]=e=t.$handleEvent(e),t.$util.toCheckLogin({url:"/user/pages/stored/list"})}}},[i("v-uni-view",{staticClass:"flex-center pd-lg mt-md ml-md mr-md fill-base box-shadow radius-20 rel"},[i("v-uni-view",{staticClass:"flex-1 mr-lg c-title"},[i("v-uni-view",{staticClass:"f-paragraph"},[t._v("我的余额")]),i("v-uni-view",{staticClass:"f-big-title text-bold"},[t._v(t._s(t.mineInfo.balance||0))])],1),i("v-uni-view",{staticClass:"store-btn flex-center f-paragraph c-base radius",style:{background:t.primaryColor}},[t._v("立即充值")])],1)],1),1===t.mineInfo.is_atv_status?i("auth",{staticStyle:{width:"100%"},attrs:{needAuth:t.userInfo&&(!t.userInfo.phone||!t.userInfo.nickName),must:!0,type:t.userInfo.phone?"userInfo":"phone"},on:{go:function(e){arguments[0]=e=t.$handleEvent(e),t.toAtv.apply(void 0,arguments)}}},[i("v-uni-view",{staticStyle:{height:"14rpx"}}),i("v-uni-image",{staticClass:"share-atv-img",attrs:{src:"https://lbqny.migugu.com/admin/anmo/mine/share_atv.png"}})],1):t._e(),i("v-uni-view",{staticClass:"mine-menu-list box-shadow fill-base radius-16",style:{margin:1===t.mineInfo.is_atv_status?"10rpx 30rpx 0 30rpx":""}},[i("v-uni-view",{staticClass:"menu-title flex-between pl-lg pr-md b-1px-b",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.$util.toCheckLogin({url:"/pages/order"})}}},[i("v-uni-view",{staticClass:"f-paragraph c-title text-bold"},[t._v("我的订单")]),i("v-uni-view",{staticClass:"flex-y-center f-caption c-paragraph"},[t._v("全部订单"),i("i",{staticClass:"iconfont icon-right"})])],1),i("v-uni-view",{staticClass:"flex-warp pt-lg pb-lg"},t._l(t.orderList,(function(e,n){return i("v-uni-view",{key:n,staticClass:"item-child flex-center flex-column f-caption c-paragraph",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toJump("orderList",n)}}},[i("i",{staticClass:"iconfont",class:e.icon,style:{color:t.primaryColor}}),i("v-uni-view",{staticClass:"mt-sm"},[t._v(t._s(e.text))])],1)})),1)],1),t.mineInfo.id?i("v-uni-view",{staticClass:"mine-menu-list box-shadow fill-base radius-16"},[i("v-uni-view",{staticClass:"menu-title flex-between pl-lg pr-md b-1px-b"},[i("v-uni-view",{staticClass:"f-paragraph c-title text-bold"},[t._v("其他")])],1),i("v-uni-view",{staticClass:"flex-warp pt-lg pb-lg"},t._l(t.mineInfo.is_fx?t.distributionList:t.distributionApplyList,(function(e,n){return"绑定技师"!=e.text||1==t.mineInfo.is_admin?i("v-uni-view",{key:n,staticClass:"item-child flex-center flex-column f-caption c-paragraph",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toJump(t.mineInfo.is_fx?"distributionList":"distributionApplyList",n)}}},[i("v-uni-view",{staticClass:"item-img flex-center radius",staticStyle:{background:"#F8F8F8"}},[i("i",{staticClass:"iconfont c-title",class:e.icon})]),i("v-uni-view",{staticClass:"mt-sm"},[t._v(t._s(e.text))])],1):t._e()})),1)],1):t._e(),i("v-uni-view",{staticClass:"mine-tool-list fill-base radius-16"},[t._l(t.toolList,(function(e,n){return[i("v-uni-view",{key:n+"_0",staticClass:"list-item pt-lg pb-lg ml-lg mr-lg flex-center",class:[{"b-1px-t":0!=n}],on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toJump("toolList",n)}}},[i("i",{staticClass:"left-icon flex-center iconfont",class:e.icon,style:{color:t.primaryColor}}),i("v-uni-view",{staticClass:"flex-1 flex-between ml-md"},[i("v-uni-view",{staticClass:"f-paragraph c-title"},[t._v(t._s(e.text))]),i("i",{staticClass:"iconfont",class:[{"iconbodadianhua text-bold":"联系客服"==e.text},{"icon-right":"联系客服"!=e.text}],style:{fontSize:"联系客服"==e.text?"50rpx":"",color:"联系客服"==e.text?t.primaryColor:""}})],1)],1)]})),2==t.mineInfo.coach_status||3==t.mineInfo.coach_status?i("v-uni-view",{staticClass:"list-item pd-lg flex-center b-1px-t",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toChange.apply(void 0,arguments)}}},[i("i",{staticClass:"left-icon flex-center iconfont iconqiehuanjishiduan",style:{color:t.primaryColor}}),i("v-uni-view",{staticClass:"flex-1 flex-between ml-md"},[i("v-uni-view",{staticClass:"f-paragraph c-title"},[t._v("切换技师端")]),i("i",{staticClass:"iconfont icon-switch c-caption"})],1)],1):t._e()],2)]:t._e(),2==t.userPageType?[i("v-uni-view",{staticClass:"addr-time-help-list flex-x-center f-desc rel",style:{color:t.configInfo[t.font_type[t.userPageType]]}},[i("v-uni-view",{staticClass:"flex-center flex-column",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toChooseLocation(!1)}}},[i("i",{staticClass:"iconfont iconweizhigengxin1"}),i("v-uni-view",[t._v("位置更新")])],1),i("v-uni-view",{staticClass:"flex-center flex-column",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.$util.goUrl({url:"/technician/pages/time-manage"})}}},[i("i",{staticClass:"iconfont iconshijianguanli2"}),i("v-uni-view",[t._v("时间管理")])],1),i("v-uni-view",{staticClass:"flex-center flex-column",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toHelp.apply(void 0,arguments)}}},[i("i",{staticClass:"iconfont iconyijianbaojing"}),i("v-uni-view",[t._v("一键报警")])],1)],1),t.coachInfo.id?i("v-uni-view",{staticClass:"coach-info fill-base ml-lg mr-lg pd-lg radius-16 rel"},[i("v-uni-view",{staticClass:"flex-center pb-lg"},[i("v-uni-view",{staticClass:"avatar radius"},[i("v-uni-view",{staticClass:"h5-image avatar radius",style:{backgroundImage:"url('"+t.coachInfo.work_img+"')"},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toPreviewImage(t.index,1)}}})],1),i("v-uni-view",{staticClass:"flex-1 ml-md"},[i("v-uni-view",{staticClass:"flex-between"},[i("v-uni-view",{staticClass:"coach-name text-bold max-300 ellipsis"},[t._v(t._s(t.coachInfo.coach_name))]),i("v-uni-view",{staticClass:"coach-text f-paragraph flex-y-center",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.$util.goUrl({url:"/technician/pages/apply?is_edit=1"})}}},[t._v("个人信息"),i("i",{staticClass:"iconfont icon-right"})])],1),i("v-uni-view",{staticClass:"flex-warp mt-sm"},[i("v-uni-view",{staticClass:"tag-item flex-center",style:{color:t.primaryColor,border:"1rpx solid "+t.primaryColor}},[t._v("已认证")]),2===t.mineInfo.coach_status?i("v-uni-view",{staticClass:"tag-item flex-center ml-sm",style:{color:t.coachInfo.is_work?t.primaryColor:"#5A677E",border:"1rpx solid "+(t.coachInfo.is_work?t.primaryColor:"#5A677E")}},[t._v(t._s(t.coachInfo.is_work?t.textType[t.coachInfo.text_type]:"请假中"))]):t._e(),i("v-uni-view",{staticClass:"tag-item flex-center ml-sm",style:{color:t.primaryColor,border:"1rpx solid "+t.primaryColor}},[t._v(t._s(t.coachInfo.coach_level.title))])],1)],1)],1),i("v-uni-view",{staticClass:"flex-center pt-lg b-1px-t"},[i("v-uni-view",{staticClass:"map-addr flex-center rel"},[i("v-uni-view",{staticClass:"map-addr radius abs",style:{background:t.primaryColor}}),i("v-uni-view",{staticClass:"flex-y-center f-desc",style:{color:t.primaryColor}},[i("i",{staticClass:"iconfont icondangqianweizhi"}),t._v("当前")])],1),i("v-uni-view",{staticClass:"flex-1 ml-md ellipsis"},[t._v(t._s(t.coachInfo.address))])],1)],1):t._e(),i("v-uni-view",{staticClass:"mine-count-list flex-between mt-md rel"},[3==t.mineInfo.coach_status?i("v-uni-view",{staticClass:"cancel-auth iconfont icon-biaoqian c-caption flex-center abs"},[i("v-uni-view",{staticClass:"text-bold f-icontext abs"},[t._v("取消授权")])],1):t._e(),i("v-uni-view",{staticClass:"item-child ml-lg mr-sm fill-base f-caption box-shadow radius-16",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.$util.goUrl({url:"/technician/pages/income/index"})}}},[i("v-uni-view",{staticClass:"flex-y-baseline",style:{color:t.primaryColor}},[t._v("¥"),i("v-uni-view",{staticClass:"f-sm-title"},[t._v(t._s(t.coachInfo.service_price||0))])],1),i("v-uni-view",{staticClass:"flex-between mt-sm"},[i("v-uni-view",{staticClass:"text f-paragraph"},[t._v("服务收入")]),i("v-uni-view",{staticClass:"cash-btn flex-center f-desc c-base radius",style:{background:t.primaryColor}},[t._v("去提现")])],1)],1),i("v-uni-view",{staticClass:"item-child ml-sm mr-lg pt-lg pb-lg pl-md pr-sm fill-base f-caption c-desc box-shadow radius-16 ",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.$util.goUrl({url:"/user/pages/cash-out?type=carfee"})}}},[i("v-uni-view",{staticClass:"flex-y-baseline",style:{color:t.primaryColor}},[t._v("¥"),i("v-uni-view",{staticClass:"f-sm-title"},[t._v(t._s(t.coachInfo.car_price||0))])],1),i("v-uni-view",{staticClass:"flex-between mt-sm"},[i("v-uni-view",{staticClass:"text f-paragraph"},[t._v("车费")]),i("v-uni-view",{staticClass:"cash-btn flex-center f-desc c-base radius",style:{background:t.primaryColor}},[t._v("去提现")])],1)],1)],1),i("v-uni-view",{staticClass:"mine-menu-list box-shadow fill-base radius-16"},[i("v-uni-view",{staticClass:"menu-title flex-between pl-lg pr-sm"},[i("v-uni-view",{staticClass:"f-paragraph c-title text-bold"},[t._v("我的订单")])],1),i("v-uni-view",{staticClass:"flex-warp pb-lg"},t._l(t.orderList2,(function(e,n){return i("v-uni-view",{key:n,staticClass:"item-child flex-center flex-column f-caption c-title",staticStyle:{width:"25%"},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toJump("orderList2",n)}}},[i("v-uni-view",{staticClass:"item-img rel flex-center radius"},[e.number>0?i("v-uni-view",{staticClass:"abs item-child-number flex-center"},[t._v(t._s(e.number<100?e.number:"99+"))]):t._e(),i("v-uni-view",{staticClass:"item-img radius abs",style:{background:t.primaryColor}}),i("i",{staticClass:"iconfont c-title",class:e.icon,style:{color:t.primaryColor}})],1),i("v-uni-view",{staticClass:"mt-sm"},[t._v(t._s(e.text))])],1)})),1)],1),i("v-uni-view",{staticClass:"mine-menu-list box-shadow fill-base radius-16"},[i("v-uni-view",{staticClass:"menu-title flex-between pl-lg pr-sm"},[i("v-uni-view",{staticClass:"f-paragraph c-title text-bold"},[t._v("其他功能")])],1),i("v-uni-view",{staticClass:"flex-warp pb-sm"},t._l(t.toolList2,(function(e,n){return i("v-uni-view",{key:n,staticClass:"item-child flex-center flex-column f-caption c-title",staticStyle:{width:"25%",margin:"10rpx 0 20rpx 0"},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toJump("toolList2",n)}}},[i("i",{staticClass:"iconfont c-title",class:e.icon,style:{color:t.primaryColor}}),i("v-uni-view",{staticClass:"mt-sm"},[t._v(t._s(e.text))])],1)})),1)],1)]:t._e(),i("v-uni-view",{staticClass:"space-footer"}),i("v-uni-view",{style:{height:t.configInfo.tabbarHeight+"px"}}),i("tabbar",{attrs:{cur:5}})],2):t._e()},a=[]},"3b74":function(t,e,i){"use strict";i.r(e);var n=i("890a"),a=i.n(n);for(var s in n)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=a.a},"44cb":function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return a})),i.d(e,"a",(function(){}));var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"custom-tabbar fix flex-center fill-base b-1px-t"},t._l(t.configInfo.tabBar,(function(e,n){return i("v-uni-view",{key:n,staticClass:"flex-center flex-column mt-sm",style:{width:100/t.configInfo.tabBar.length+"%",color:t.cur==e.id?t.primaryColor:"#666"},on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.changeTab(e.id)}}},[i("i",{staticClass:"iconfont",class:t.cur==e.id?e.selected_img:e.default_img}),i("v-uni-view",{staticClass:"text"},[t._v(t._s(e.name))])],1)})),1)},a=[]},"60af":function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.custom-tabbar[data-v-67cc264a]{height:%?98?%;bottom:0;height:calc(%?98?% + env(safe-area-inset-bottom) / 2);padding-bottom:calc(env(safe-area-inset-bottom) / 2)}.custom-tabbar .iconfont[data-v-67cc264a]{font-size:%?40?%}.custom-tabbar .text[data-v-67cc264a]{font-size:%?22?%;margin-top:%?5?%;height:%?32?%}',""]),t.exports=e},"668e":function(t,e,i){var n=i("95da");n.__esModule&&(n=n.default),"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("fc4cc872",n,!0,{sourceMap:!1,shadowMode:!1})},7450:function(t,e,i){"use strict";i.r(e);var n=i("2e31"),a=i("3b74");for(var s in a)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return a[t]}))}(s);i("c057");var o=i("f0c5"),c=Object(o["a"])(a["default"],n["b"],n["c"],!1,null,"67ff4940",null,!1,n["a"],void 0);e["default"]=c.exports},"890a":function(t,e,i){"use strict";i("7a82");var n=i("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=n(i("3835")),s=n(i("5530")),o=n(i("c7eb")),c=n(i("1da1"));i("99af"),i("d3b7"),i("3ca3"),i("ddb0"),i("d81d"),i("4de4"),i("3c65"),i("c740"),i("a434"),i("caad");var r=i("26cb"),l=n(i("b05d")),u={components:{tabbar:l.default},props:{imagelist:{type:Array,default:function(){return[]}}},data:function(){return{nickname:"",flag:!1,avatarUrl:"",isLoad:!1,options:{},textType:{1:"可服务",2:"服务中",3:"可预约"},is_share:!0,orderList:[{icon:"icondaizhifu",text:"待支付",url:"/pages/order?tab=1"},{icon:"icondaifuwu",text:"待服务",url:"/pages/order?tab=2"},{icon:"iconanmo2",text:"服务中",url:"/pages/order?tab=3"},{icon:"icondaipingjia",text:"待评价",url:"/pages/order?tab=4"},{icon:"icontuikuan",text:"退款/售后",url:"/user/pages/refund/list"}],orderList2:[{icon:"icondaijiedan",text:"待接单",url:"/technician/pages/order/list",number:0},{icon:"iconyijiedan",text:"待服务",url:"/technician/pages/order/list?tab=1",number:0},{icon:"iconfuwuzhong",text:"服务中",url:"/technician/pages/order/list?tab=2",number:0}],distributionList:[{icon:"iconwodeshouyi",text:"我的收益",url:"/user/pages/distribution/income"},{icon:"icontuiguanghaibao",text:"推广海报",url:"/user/pages/distribution/poster"},{icon:"iconwodetuandui1",text:"我的粉丝",url:"/user/pages/distribution/team"},{icon:"iconbangdingjishi",text:"绑定技师",url:"/user/pages/distribution/bind-technician"}],distributionApplyList:[{icon:"iconwodeshouyi",text:"申请分销商",url:"/user/pages/distribution/apply"},{icon:"iconbangdingjishi",text:"绑定技师",url:"/user/pages/distribution/bind-technician"}],toolList:[{icon:"icondizhiguanli",text:"地址管理",url:"/user/pages/address/list"},{icon:"iconwentifankui",text:"问题反馈",url:"/user/pages/feedback/box"},{icon:"iconlianxikefu",text:"联系客服",url:""}],toolList2:[{icon:"icondengjiguanli",text:"等级管理",url:"/technician/pages/level"},{icon:"iconchefeimingxi",text:"车费明细",url:"/technician/pages/car-fare"},{icon:"iconchefeitixianjilu",text:"车费提现记录",url:"/technician/pages/income/car-fee-record"},{icon:"iconwuliaoshangcheng",text:"物料商城",url:"/technician/pages/shop/list"},{icon:"iconchapingshensu",text:"差评申诉",url:"/technician/pages/bad-comments/box"},{icon:"iconqiehuanjishiduan",text:"切换用户端",url:"change"}],image_type:{1:"user_image",2:"coach_image"},font_type:{1:"user_font_color",2:"coach_font_color"},showAuth:!1,offsetL:360,offsetT:0}},computed:(0,r.mapState)({primaryColor:function(t){return t.config.configInfo.primaryColor},subColor:function(t){return t.config.configInfo.subColor},configInfo:function(t){return t.config.configInfo},plugAuth:function(t){return t.config.plugAuth},commonOptions:function(t){return t.user.commonOptions},userInfo:function(t){return t.user.userInfo},userPageType:function(t){return t.user.userPageType},mineInfo:function(t){return t.user.mineInfo},coachInfo:function(t){return t.user.coachInfo}}),onLoad:function(t){this.options=t;var e=t.type,i=void 0===e?1:e;i&&this.updateUserItem({key:"userPageType",val:i});var n=this.mineInfo.id,a=void 0===n?-1:n;-1==a&&this.$util.showLoading(),this.initIndex()},onShow:function(){return(0,c.default)((0,o.default)().mark((function t(){return(0,o.default)().wrap((function(t){while(1)switch(t.prev=t.next){case 0:case"end":return t.stop()}}),t)})))()},onPullDownRefresh:function(){uni.showNavigationBarLoading(),this.initRefresh(),uni.stopPullDownRefresh()},methods:(0,s.default)((0,s.default)((0,s.default)({},(0,r.mapActions)(["getConfigInfo","getPlugAuth","getUserInfo","getMineInfo","getCoachInfo","getAuthUserProfile","updateCommonOptions","toPlayAudio"])),(0,r.mapMutations)(["updateUserItem"])),{},{initIndex:function(){var t=arguments,e=this;return(0,c.default)((0,o.default)().mark((function i(){var n,a,s,c,r,l,u;return(0,o.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(n=t.length>0&&void 0!==t[0]&&t[0],n||!e.$jweixin.isWechat()){i.next=5;break}return i.next=4,e.$jweixin.initJssdk();case 4:e.$jweixin.wxReady((function(){e.$jweixin.hideOptionMenu()}));case 5:if(e.configInfo.id&&!n){i.next=8;break}return i.next=8,e.getConfigInfo();case 8:return i.next=10,Promise.all([e.getPlugAuth(),e.getMineInfo()]);case 10:if(e.isLoad=!0,e.configInfo.fx_check,a=e.mineInfo,s=a.coach_status,a.fx_status,2!=s&&3!=s){i.next=16;break}return i.next=16,e.getCoachInfo();case 16:2==e.userPageType&&e.getOrderNumCall(),e.updateUserItem({key:"userPageType",val:2==s||3==s?e.userPageType:1}),c=["coach_status","channel_status"],r={coach_status:{text:"申请技师",list:{icon:"iconshenqingjishi",text:"申请技师",url:"/user/pages/apply"}},channel_status:{text:"申请渠道商",list:{icon:"icon-zuzhi",text:"申请渠道商",url:"/user/pages/channel/apply"},list2:{icon:"icon-zuzhi",text:"我是渠道商",url:"/user/pages/channel/income"}}},c.map((function(t){if(2!=e.mineInfo[t]){var i=e.toolList.filter((function(e){return e.text===r[t].text}));if(0===i.length&&e.toolList.unshift(r[t].list),"channel_status"===t){var n=e.toolList.findIndex((function(t){return"我是渠道商"===t.text}));-1!=n&&e.toolList.splice(n,1)}}else if(e.toolList.map((function(i,n){i.text===r[t].text&&e.toolList.splice(n,1)})),"channel_status"===t){var a=e.toolList.filter((function(t){return"我是渠道商"===t.text}));0===a.length&&e.toolList.unshift(r[t].list2)}})),l=e.toolList2.findIndex((function(t){return"动态发布"==t.text})),e.plugAuth.dynamic&&-1==l&&(u=e.toolList2.findIndex((function(t){return"差评申诉"==t.text})),e.toolList2.splice(u+1,0,{icon:"icon-dongtai1",text:"动态发布",url:"/dynamic/pages/technician/list"})),e.$util.hideAll();case 24:case"end":return i.stop()}}),i)})))()},closeMask:function(){this.flag=!1},setoff:function(){this.flag=!1},showMask:function(){this.flag=!0},initRefresh:function(){this.initIndex(!0)},getOrderNumCall:function(){var t=this;return(0,c.default)((0,o.default)().mark((function e(){var i;return(0,o.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$api.technician.getOrderNum();case 2:i=e.sent,t.orderList2[0].number=i.wait,t.orderList2[1].number=i.start,t.orderList2[2].number=i.progress;case 6:case"end":return e.stop()}}),e)})))()},authUserProfile:function(){var t=this;return(0,c.default)((0,o.default)().mark((function e(){var i,n;return(0,o.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(i=t.userInfo.id,n=void 0===i?0:i,n){e.next=4;break}return t.$util.toCheckLogin({url:"/pages/mine"}),e.abrupt("return");case 4:case"end":return e.stop()}}),e)})))()},bindblur:function(t){console.log("1",t.detail.value),this.nickname=t.detail.value},onChooseavatar:function(t){var e=this;return(0,c.default)((0,o.default)().mark((function i(){var n,a;return(0,o.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:return console.log(t.detail.avatarUrl,"0000000000"),e,e,i.next=5,e.$api.base.uploadFile({filePath:t.detail.avatarUrl,formData:{type:"picture"}});case 5:n=i.sent,a=n.attachment_path,e.avatarUrl=a,console.log(a);case 9:case"end":return i.stop()}}),i)})))()},updateuser:function(){var t=this,e=this;e.imageList;return""==this.avatarUrl?(uni.showToast({title:"请上传头像",icon:"none"}),!1):""==this.nickname?(uni.showToast({title:"请输入昵称",icon:"none"}),!1):void uni.getUserProfile({desc:"用于完善个人资料",success:function(i){console.log(i),console.log(e.nickname),console.log(e.avatarUrl);var n=i.encryptedData,a=i.iv,s={nickName:e.nickname,avatarUrl:e.avatarUrl},o=Object.assign({},s,{encryptedData:n,iv:a});t.toUpdateUserInfo(o)},fail:function(e){t.toUpdateUserInfo()}})},toUpdateUserInfo:function(t){var e=this;return(0,c.default)((0,o.default)().mark((function i(){var n,a;return(0,o.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(console.log(t),e.pMust,!t.nickName){i.next=10;break}return e.$util.showLoading({title:"更新中"}),n=e.commonOptions.coupon_atv_id,a=void 0===n?0:n,t.coupon_atv_id=a,i.next=8,e.getAuthUserProfile(t);case 8:e.closeMask(),setTimeout((function(){e.$util.hideAll()}),1e3);case 10:case"end":return i.stop()}}),i)})))()},toChooseLocation:function(t){var e=this;return(0,c.default)((0,o.default)().mark((function i(){var n,s,c,r,l,u,f,d;return(0,o.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(2!=e.userPageType||!t){i.next=2;break}return i.abrupt("return");case 2:return i.next=4,e.$util.checkAuth({type:"userLocation"});case 4:return i.next=6,uni.chooseLocation();case 6:if(n=i.sent,s=(0,a.default)(n,2),c=s[1],r=c.address,l=void 0===r?"":r,u=c.longitude,f=c.latitude,l){i.next=15;break}return i.abrupt("return");case 15:return i.next=17,e.$api.technician.coachUpdate({address:l,lng:u,lat:f});case 17:d=e.$util.deepCopy(e.coachInfo),d.address=l,e.updateUserItem({key:"coachInfo",val:d}),e.$util.showToast({title:"更新成功"});case 21:case"end":return i.stop()}}),i)})))()},toJump:function(t,e){var i=this[t][e],n=i.url,a=i.text;if(["申请技师","申请分销商","申请渠道商"].includes(a))this.toApply("申请技师"==a?1:"申请分销商"==a?2:3);else if("切换用户端"!=a)if("联系客服"!=a){var s="orderList"==t&&4!==e?"reLaunch":"navigateTo";this.$util.log(n),this.$util.toCheckLogin({url:n,openType:s})}else{var o=this.configInfo,c=o.mobile;o.im_type;this.$util.goUrl({url:c,openType:"call"})}else this.toChange()},toAtv:function(){var t=this;return(0,c.default)((0,o.default)().mark((function e(){var i;return(0,o.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(t.mineInfo.is_atv){e.next=3;break}return t.$util.showToast({title:"暂无活动"}),e.abrupt("return");case 3:return i=t.commonOptions,i.coupon_atv_id=0,e.next=7,t.updateCommonOptions(i);case 7:t.$util.toCheckLogin({url:"/user/pages/coupon/share"});case 8:case"end":return e.stop()}}),e)})))()},toApply:function(t){var e=this;return(0,c.default)((0,o.default)().mark((function i(){var n,a,s,c,r,l,u,f,d,p;return(0,o.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:n=e.mineInfo,a=n.coach_status,s=void 0===a?-1:a,c=n.fx_status,r=void 0===c?-1:c,l=n.channel_status,u=void 0===l?-1:l,f=1==t?s:2==t?r:u,d={1:"/technician/pages/apply",2:"/user/pages/distribution/apply",3:"/user/pages/channel/apply"},p=-1==f?d[t]:"/user/pages/apply-result?type=".concat(t),e.$util.log(p),e.$util.toCheckLogin({url:p});case 6:case"end":return i.stop()}}),i)})))()},toChange:function(){var t=this;return(0,c.default)((0,o.default)().mark((function e(){var i,n;return(0,o.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(uni.pageScrollTo({duration:500,scrollTop:0}),i=t.userPageType,n=void 0===i?1:i,2!=n){e.next=5;break}return e.next=5,t.getCoachInfo();case 5:1==n&&t.getOrderNumCall(),t.updateUserItem({key:"userPageType",val:2==n?1:2});case 7:case"end":return e.stop()}}),e)})))()},onChange:function(t){var e=this,i=t.detail,n=i.x,a=i.y;this.$nextTick((function(){e.offsetL=n,e.offsetT=a}))},toHelp:function(){var t=this;return(0,c.default)((0,o.default)().mark((function e(){var i,n,a,s,c,r,l,u,f,d,p;return(0,o.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(!t.$jweixin.isWechat()){e.next=22;break}return t.$util.showLoading(),e.next=4,t.$jweixin.wxReady2();case 4:return e.next=6,t.$jweixin.getWxLocation();case 6:if(i=e.sent,n=i.latitude,a=void 0===n?0:n,s=i.longitude,c=void 0===s?0:s,a){e.next=15;break}return t.$util.hideAll(),t.$util.showToast({title:"请授权定位当前地址"}),e.abrupt("return");case 15:if(!a||!c){e.next=22;break}return r="".concat(a,",").concat(c),e.next=19,t.$api.base.getMapInfo({location:r});case 19:l=e.sent,u=JSON.parse(l),f=u.status,d=u.result,0==f&&(t.$util.hideAll(),p=d.address,t.toPolice({lat:a,lng:c,address:p}));case 22:case"end":return e.stop()}}),e)})))()},toPolice:function(t){var e=this;return(0,c.default)((0,o.default)().mark((function i(){return(0,o.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:return i.next=2,e.$api.technician.police(t);case 2:e.$util.hideAll(),e.$util.showToast({title:"求救成功"});case 4:case"end":return i.stop()}}),i)})))()}})};e.default=u},"95da":function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.pages-mine .mine-bg[data-v-67ff4940]{width:100%;height:%?368?%;z-index:0}.pages-mine .mine-master-bg[data-v-67ff4940]{width:100%;height:%?514?%;z-index:-1}.pages-mine .avatar_view[data-v-67ff4940]{width:%?120?%;height:%?120?%}.pages-mine .avatar_view .avatar[data-v-67ff4940]{width:%?120?%;height:%?120?%;overflow:hidden}.pages-mine .avatar_view .avatar uni-open-data[data-v-67ff4940]{width:%?120?%;height:%?120?%}.pages-mine .avatar_view .text[data-v-67ff4940]{width:%?110?%;position:absolute;bottom:%?-5?%;left:%?5?%;height:%?36?%;line-height:%?36?%;background:#fff;border-radius:%?18?%;font-size:%?24?%;text-align:center}.pages-mine .member-tag[data-v-67ff4940]{min-width:%?168?%;height:%?42?%;background:hsla(0,0%,100%,.5)}.pages-mine .member-tag .iconfont[data-v-67ff4940]{font-size:%?28?%}.pages-mine .icon-shuaxin[data-v-67ff4940],\n.pages-mine .icon-xitong[data-v-67ff4940]{font-size:%?40?%}.pages-mine .addr-time-help-list[data-v-67ff4940]{width:100%;padding:%?40?% 0}.pages-mine .addr-time-help-list .flex-center[data-v-67ff4940]{width:33.33%}.pages-mine .addr-time-help-list .flex-center .iconfont[data-v-67ff4940]{font-size:%?60?%;margin-bottom:%?10?%}.pages-mine .coach-info .avatar[data-v-67ff4940]{width:%?140?%;height:%?140?%}.pages-mine .coach-info .coach-name[data-v-67ff4940]{font-size:%?34?%;color:#142c57}.pages-mine .coach-info .coach-text[data-v-67ff4940]{color:#5a677e}.pages-mine .coach-info .icon-right[data-v-67ff4940]{font-size:%?22?%}.pages-mine .coach-info .tag-item[data-v-67ff4940]{min-width:%?92?%;height:%?36?%;padding:0 %?10?%;font-size:%?24?%;border-radius:%?6?%;-webkit-transform:rotate(1turn);transform:rotate(1turn)}.pages-mine .coach-info .map-addr[data-v-67ff4940]{width:%?102?%;height:%?46?%;padding-right:%?6?%}.pages-mine .coach-info .map-addr .iconfont[data-v-67ff4940]{margin-right:%?2?%}.pages-mine .coach-info .map-addr.abs[data-v-67ff4940]{top:0;left:0;opacity:.1}.pages-mine .mine-count-list .cancel-auth[data-v-67ff4940]{width:%?110?%;height:%?100?%;font-size:%?100?%;top:%?-20?%;right:%?55?%}.pages-mine .mine-count-list .cancel-auth .text-bold[data-v-67ff4940]{height:%?26?%;-webkit-transform:rotate(-32deg);transform:rotate(-32deg)}.pages-mine .mine-count-list .item-child[data-v-67ff4940]{width:50%;padding:%?28?%}.pages-mine .mine-count-list .item-child .text[data-v-67ff4940]{color:#5a677e}.pages-mine .mine-count-list .item-child .cash-btn[data-v-67ff4940]{width:%?108?%;height:%?46?%;-webkit-transform:rotate(1turn);transform:rotate(1turn)}.pages-mine .share-collect-list .share-item[data-v-67ff4940]{width:50%;height:%?105?%}.pages-mine .share-collect-list .item-child[data-v-67ff4940]{width:50%}.pages-mine .share-collect-list .item-child .item-icon[data-v-67ff4940]{width:%?70?%;height:%?70?%}.pages-mine .share-collect-list .item-child .item-icon .iconfont[data-v-67ff4940]{font-size:%?38?%}.pages-mine .share-collect-list .item-child .item-icon .item-icon[data-v-67ff4940]{top:0;left:0;opacity:.1}.pages-mine .store-btn[data-v-67ff4940]{width:%?182?%;height:%?62?%}.pages-mine .share-atv-img[data-v-67ff4940]{width:%?716?%;height:%?190?%;margin:0 auto}.pages-mine .mine-menu-list[data-v-67ff4940]{margin:%?20?% %?30?% 0 %?30?%}.pages-mine .mine-menu-list .menu-title[data-v-67ff4940]{height:%?90?%}.pages-mine .mine-menu-list .menu-title .iconfont[data-v-67ff4940]{font-size:%?24?%}.pages-mine .mine-menu-list .item-child[data-v-67ff4940]{width:20%;margin:%?10?% 0}.pages-mine .mine-menu-list .item-child .iconfont[data-v-67ff4940]{font-size:%?52?%}.pages-mine .mine-menu-list .item-child .item-img[data-v-67ff4940]{width:%?88?%;height:%?88?%}.pages-mine .mine-menu-list .item-child .item-img .iconfont[data-v-67ff4940]{font-size:%?44?%}.pages-mine .mine-menu-list .item-child .item-img .item-img[data-v-67ff4940]{top:0;left:0;opacity:.1}.pages-mine .mine-menu-list .item-child .item-child-number[data-v-67ff4940]{right:0;top:0;width:%?24?%;height:%?24?%;border-radius:%?24?%;background-color:#f1381f;color:#fff;font-size:%?18?%}.pages-mine .mine-tool-list[data-v-67ff4940]{margin:%?20?% %?30?% 0 %?30?%;box-shadow:0 3px 6px 0 hsla(0,0%,89%,.47)}.pages-mine .mine-tool-list .list-item .left-icon[data-v-67ff4940]{width:%?42?%;font-size:%?42?%}.pages-mine .mine-tool-list .list-item .icon-right[data-v-67ff4940]{font-size:%?28?%}.pages-mine .mine-tool-list .list-item .icon-switch[data-v-67ff4940]{font-size:%?70?%;line-height:%?48?%}.pages-mine .mine-tool-list .list-item.b-1px-t[data-v-67ff4940]:before{left:%?60?%}\n/* 查询弹出层 */\n/* 设置背景遮罩层样式 */.mask[data-v-67ff4940]{z-index:9999;position:fixed;left:0;top:0;right:0;bottom:0;background:rgba(0,0,0,.5);display:flex;justify-content:center;align-items:center;flex-direction:column}\n/* 设置遮罩内容样式 */.maskContent[data-v-67ff4940]{width:70%;background:#fff;border-radius:8px;padding:%?40?%}\n/* 设置关闭按钮图片的位置 */.closeImg[data-v-67ff4940]{position:fixed;top:34%;right:18%;z-index:9999}\n/* 设置关闭按钮宽高 */.closeImg_image[data-v-67ff4940]{width:%?50?%;height:%?50?%}\n/* 设置关闭按钮图片的位置 */.closeImg1[data-v-67ff4940]{margin-left:40%;margin-bottom:5%}\n/* 设置关闭按钮宽高 */.closeImg1_image[data-v-67ff4940]{width:%?180?%;height:%?180?%}.btn[data-v-67ff4940]{width:100%;margin:%?30?% auto;background:#17a976;color:#fff;line-height:%?70?%;font-size:%?30?%;text-align:center;border-radius:5px;height:%?70?%}.input[data-v-67ff4940]{border:1px solid #ccc;border-radius:5px;font-size:%?28?%;padding:0 %?10?%;margin:%?20?% 0;line-height:%?70?%;height:%?70?%}',""]),t.exports=e},"9ec8":function(t,e,i){"use strict";i.r(e);var n=i("f8d3"),a=i.n(n);for(var s in n)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=a.a},b05d:function(t,e,i){"use strict";i.r(e);var n=i("44cb"),a=i("9ec8");for(var s in a)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return a[t]}))}(s);i("f944");var o=i("f0c5"),c=Object(o["a"])(a["default"],n["b"],n["c"],!1,null,"67cc264a",null,!1,n["a"],void 0);e["default"]=c.exports},c057:function(t,e,i){"use strict";var n=i("668e"),a=i.n(n);a.a},f8d3:function(t,e,i){"use strict";i("7a82");var n=i("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=n(i("5530"));i("a9e3"),i("e9c4"),i("ac1f");var s=i("26cb"),o={components:{},props:{cur:{type:Number||String,default:function(){return"0"}}},data:function(){return{}},computed:(0,s.mapState)({primaryColor:function(t){return t.config.configInfo.primaryColor},subColor:function(t){return t.config.configInfo.subColor},configInfo:function(t){return t.config.configInfo},commonOptions:function(t){return t.user.commonOptions},activeIndex:function(t){return t.order.activeIndex}}),mounted:function(){var t=this,e=uni.getSystemInfoSync().windowHeight,i=JSON.parse(JSON.stringify(this.configInfo)),n=i.navBarHeight;setTimeout((function(){var a=uni.createSelectorQuery().in(t);a.select(".custom-tabbar").boundingClientRect((function(a){var s=e-a.height-n;i.curSysHeight=s,i.tabbarHeight=a.height,t.updateConfigItem({key:"configInfo",val:i})})).exec()}),200)},methods:(0,a.default)((0,a.default)({},(0,s.mapMutations)(["updateConfigItem"])),{},{changeTab:function(t){var e=this.activeIndex,i={1:"/pages/service",2:"/pages/technician",3:"/pages/dynamic",4:"/pages/order?tab=".concat(e),5:"/pages/mine"};t!=this.cur&&this.$util.goUrl({url:i[t],openType:"reLaunch"})}})};e.default=o},f944:function(t,e,i){"use strict";var n=i("071e"),a=i.n(n);a.a}}]);