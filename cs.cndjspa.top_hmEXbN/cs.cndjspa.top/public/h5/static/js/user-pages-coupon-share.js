(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["user-pages-coupon-share"],{3786:function(t,e,n){"use strict";var i=n("8115"),s=n.n(i);s.a},"5ca7":function(t,e,n){"use strict";n.d(e,"b",(function(){return i})),n.d(e,"c",(function(){return s})),n.d(e,"a",(function(){}));var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.isLoad?n("v-uni-view",{staticClass:"user-coupon-share"},[t.options.pid?n("v-uni-view",{staticClass:"abs",class:[{"back-user-ios none":t.configInfo.isIos},{"back-user-android none":!t.configInfo.isIos}],staticStyle:{"z-index":"1",right:"30rpx"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.$util.goUrl({url:"/pages/service",openType:"reLaunch"})}}},[n("v-uni-view",{staticClass:"iconshouye iconfont"}),n("v-uni-view",{staticClass:"back-user_text"},[t._v("回到首页")])],1):t._e(),n("v-uni-image",{staticClass:"coupon-img",attrs:{src:t.shareImg}}),n("v-uni-view",{staticClass:"coupon-content"},[n("v-uni-view",{staticClass:"flex-center flex-column"},[n("v-uni-view",{staticClass:"flex-center f-paragraph pt-lg pb-md",style:{color:t.primaryColor}},[t._v(t._s(1==t.detail.status?"距活动结束还剩":"活动已结束"))]),n("v-uni-view",{staticClass:"count-down"},[n("countdown",{attrs:{type:"2",targetTime:t.over_time_text},on:{callback:function(e){arguments[0]=e=t.$handleEvent(e),t.countEnd.apply(void 0,arguments)}}})],1),n("v-uni-view",{staticClass:"space-lg"}),n("v-uni-view",{staticClass:"space-lg"}),n("v-uni-view",{staticClass:"ml-lg mr-lg pt-lg pb-sm pl-lg pr-lg rel radius-20",staticStyle:{background:"#FFFAF4"}},[n("v-uni-view",{staticClass:"menu-img mt-lg abs"},[n("v-uni-image",{staticClass:"menu-img",attrs:{src:"/static/coupon/menu.png"}}),n("v-uni-view",{staticClass:"menu-title flex-center abs",style:{color:t.primaryColor}},[t._v("邀请记录")])],1),n("v-uni-view",{staticClass:"space-lg"}),n("v-uni-view",{staticClass:"space-lg"}),n("v-uni-view",{staticClass:"flex-center f-desc pb-md",style:{color:t.primaryColor}},[n("v-uni-view",{staticClass:"user-item"},[t._v("用户")]),n("v-uni-view",{staticClass:"time-item"},[t._v("时间")])],1),n("v-uni-image",{staticClass:"line-img",attrs:{src:"/static/coupon/line.png"}}),t.record_list.data.length>0?n("v-uni-scroll-view",{staticClass:"user-list-info",attrs:{"scroll-y":!0}},t._l(t.record_list.data,(function(e,i){return n("v-uni-view",{key:i,staticClass:"user-list flex-between f-desc c-title b-1px-b"},[n("v-uni-view",{staticClass:"flex-y-center pt-md pb-md"},[n("v-uni-image",{staticClass:"avatar radius",attrs:{src:e.avatarUrl}}),n("v-uni-view",{staticClass:"ml-md max-300 ellipsis"},[t._v(t._s(e.nickName||"用户"+e.id))])],1),n("v-uni-view",[t._v(t._s(e.create_time))])],1)})),1):t._e(),0==t.record_list.data.length?n("abnor",{attrs:{percent:"70%"}}):t._e(),n("v-uni-view",{staticClass:"space-sm"})],1),t.detail.id?n("v-uni-view",{staticClass:"mt-md ml-lg mr-lg pt-lg pb-lg pl-lg pr-lg rel radius-20",staticStyle:{background:"#FFFAF4"}},[n("v-uni-view",{staticClass:"atv-rule pd-md radius-16",style:{border:"1px solid "+t.primaryColor}},[n("v-uni-view",{staticClass:"flex-center f-paragraph pt-sm pb-md",style:{color:t.primaryColor}},[t._v("活动规则")]),n("v-uni-view",{staticClass:"f-desc c-desc"},[t._v("1、活动总计可发起"+t._s(t.detail.atv_num)+"次；")]),1==t.detail.to_inv_user?n("v-uni-view",{staticClass:"f-desc c-desc"},[t._v("2、被推荐人授权用户信息后即可获得相应奖励；")]):t._e(),n("v-uni-view",{staticClass:"f-desc c-desc"},[t._v(t._s(1==t.detail.to_inv_user?3:2)+"、活动发起人每成功邀请"+t._s(t.detail.inv_user_num)+"位好友授权用户信息后，即可获得以下卡券：")]),t._l(t.detail.coupon,(function(e,i){return n("v-uni-view",{key:i,staticClass:"flex-warp f-desc c-desc"},[n("v-uni-view",[t._v("（"+t._s(1*i+1)+"）卡券："+t._s(e.title)+"；数量：x"+t._s(e.num))])],1)})),n("v-uni-view",{staticClass:"space-md"})],2)],1):t._e(),n("v-uni-view",{staticClass:"space-footer"})],1)],1),n("uni-popup",{ref:"show_share_item",attrs:{type:"bottom"}},[n("v-uni-view",{staticClass:"popup-share pd-lg f-desc c-desc fill-base"},[n("v-uni-view",{staticClass:"flex-center"},[n("v-uni-view",{staticClass:"list-item flex-center flex-column",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toAppShare(1)}}},[n("v-uni-image",{staticClass:"item-image",attrs:{src:"/static/coupon/wechat.png"}}),n("v-uni-view",{staticStyle:{"font-size":"26rpx",color:"#666"}},[t._v("分享给好友")])],1),n("v-uni-view",{staticClass:"list-item flex-center flex-column",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toAppShare(2)}}},[n("v-uni-image",{staticClass:"item-image",attrs:{src:"/static/coupon/wechat-moments.png"}}),n("v-uni-view",[t._v("分享到朋友圈")])],1)],1),n("v-uni-view",{staticClass:"space-footer"})],1)],1)],1):t._e()},s=[]},"5e81":function(t,e,n){"use strict";n.r(e);var i=n("cc7a"),s=n.n(i);for(var a in i)["default"].indexOf(a)<0&&function(t){n.d(e,t,(function(){return i[t]}))}(a);e["default"]=s.a},8115:function(t,e,n){var i=n("e0c7");i.__esModule&&(i=i.default),"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var s=n("4f06").default;s("0cb13931",i,!0,{sourceMap:!1,shadowMode:!1})},"95a0":function(t,e,n){"use strict";n.r(e);var i=n("5ca7"),s=n("5e81");for(var a in s)["default"].indexOf(a)<0&&function(t){n.d(e,t,(function(){return s[t]}))}(a);n("3786");var o=n("f0c5"),r=Object(o["a"])(s["default"],i["b"],i["c"],!1,null,"bd071d58",null,!1,i["a"],void 0);e["default"]=r.exports},cc7a:function(t,e,n){"use strict";n("7a82");var i=n("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,n("99af");var s=i(n("5530")),a=i(n("c7eb")),o=i(n("1da1")),r=n("26cb"),c=i(n("cb4e")),u=i(n("0964")),l={components:{countdown:c.default},data:function(){return{shareImg:"https://lbqny.migugu.com/admin/anmo/coupon/bg.png",isLoad:!1,options:{},detail:{end_time:""},record_list:{},qr_code:""}},computed:(0,r.mapState)({primaryColor:function(t){return t.config.configInfo.primaryColor},subColor:function(t){return t.config.configInfo.subColor},configInfo:function(t){return t.config.configInfo},commonOptions:function(t){return t.user.commonOptions},userInfo:function(t){return t.user.userInfo},over_time_text:function(){return(new Date).getTime()+1e3*this.detail.end_time}}),onLoad:function(t){var e=this;return(0,o.default)((0,a.default)().mark((function n(){return(0,a.default)().wrap((function(n){while(1)switch(n.prev=n.next){case 0:return e.$util.showLoading(),n.next=3,e.updateCommonOptions(t);case 3:return t=n.sent,e.options=t,n.next=7,e.initIndex();case 7:case"end":return n.stop()}}),n)})))()},onPullDownRefresh:function(){uni.showNavigationBarLoading(),this.initRefresh(),uni.stopPullDownRefresh()},onShareAppMessage:function(t){var e=this.detail,n=e.id,i=e.share_img,s=this.userInfo.id,a=void 0===s?0:s,o="/user/pages/coupon/share?pid=".concat(a,"&coupon_atv_id=").concat(n);return this.$util.log(o),this.$refs.show_share_item.close(),{title:"",imageUrl:i,path:o}},methods:(0,s.default)((0,s.default)((0,s.default)({},(0,r.mapActions)(["getConfigInfo","getUserInfo","updateCommonOptions"])),(0,r.mapMutations)(["updateUserItem"])),{},{initIndex:function(){var t=arguments,e=this;return(0,o.default)((0,a.default)().mark((function n(){var i;return(0,a.default)().wrap((function(n){while(1)switch(n.prev=n.next){case 0:if(i=t.length>0&&void 0!==t[0]&&t[0],e.configInfo.id&&!i){n.next=4;break}return n.next=4,e.getConfigInfo();case 4:return n.next=6,e.getDetail();case 6:if(e.$util.setNavigationBarColor({bg:e.primaryColor}),i||!e.$jweixin.isWechat()){n.next=11;break}return n.next=10,e.$jweixin.initJssdk();case 10:e.toAppShare();case 11:case"end":return n.stop()}}),n)})))()},initRefresh:function(){this.initIndex(!0)},getDetail:function(){var t=this;return(0,o.default)((0,a.default)().mark((function e(){var n,i,s,o,r;return(0,a.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:return n=t.options.coupon_atv_id,i=void 0===n?0:n,e.next=3,t.$api.mine.couponAtvInfo({id:i});case 3:s=e.sent,o=s.record_list,r=s.atv_info,1!==r.status&&(r.end_time=0),t.detail=r,t.record_list=o,t.isLoad=!0,t.$util.hideAll();case 11:case"end":return e.stop()}}),e)})))()},countEnd:function(){var t=this;this.$util.log("倒计时完了"),setTimeout((function(){t.initRefresh(),t.$util.back()}),1e3)},toShare:function(){var t=this;return(0,o.default)((0,a.default)().mark((function e(){var n,i;return(0,a.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(1==t.detail.status){e.next=2;break}return e.abrupt("return");case 2:if(t.qr_code){e.next=10;break}return t.$util.showLoading(),n=t.detail.id,e.next=7,t.$api.mine.atvQr({page:"user/pages/coupon/share",coupon_atv_id:n});case 7:i=e.sent,t.$util.hideAll(),t.qr_code=i;case 10:if(t.$refs.show_share_item.open(),t.detail.user_id!=t.userInfo.id){e.next=13;break}return e.abrupt("return");case 13:t.getDetail();case 14:case"end":return e.stop()}}),e)})))()},toPoster:function(){this.$refs.show_share_item.close(),this.$util.goUrl({url:"/user/pages/coupon/poster"})},toAppShare:function(){var t=this,e=this.detail,n=e.id,i=e.share_img,s=e.status,a=this.userInfo.id,o=void 0===a?0:a,r=1*s==1?"showOptionMenu":"hideOptionMenu",c="邀请有礼",l="邀请新人 获得福利",d=u.default.siteroot,p=d.split("/index.php")[0],v="".concat(p,"/h5/#/user/pages/coupon/share?coupon_atv_id=").concat(n,"&pid=").concat(o);this.$jweixin.wxReady((function(){t.$jweixin[r](),t.$jweixin.shareAppMessage(c,l,v,i),t.$jweixin.shareTimelineMessage(c,v,i)}))}})};e.default=l},e0c7:function(t,e,n){var i=n("24fb");e=i(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.user-coupon-share .coupon-img[data-v-bd071d58]{width:%?750?%;height:%?560?%}.user-coupon-share .coupon-content[data-v-bd071d58]{width:%?750?%;min-height:%?1431?%;background:linear-gradient(0deg,#a40035,#ffae89)}.user-coupon-share .coupon-content .count-down[data-v-bd071d58]{height:%?56?%}.user-coupon-share .coupon-content .menu-img[data-v-bd071d58]{width:%?426?%;height:%?100?%}.user-coupon-share .coupon-content .menu-img.abs[data-v-bd071d58]{top:%?-56?%;left:50%;margin-left:%?-213?%}.user-coupon-share .coupon-content .menu-title[data-v-bd071d58]{width:%?426?%;height:%?90?%;font-size:%?36?%;top:0}.user-coupon-share .coupon-content .line-img[data-v-bd071d58]{width:%?630?%;height:%?1?%}.user-coupon-share .coupon-content .user-item[data-v-bd071d58]{width:%?360?%}.user-coupon-share .coupon-content .time-item[data-v-bd071d58]{width:%?220?%}.user-coupon-share .coupon-content .user-list-info[data-v-bd071d58]{height:%?746?%}.user-coupon-share .coupon-content .user-list-info .user-list .avatar[data-v-bd071d58]{width:%?56?%;height:%?56?%;background:#ffae89}.user-coupon-share .coupon-content .share-img[data-v-bd071d58]{width:%?541?%;height:%?140?%;margin:0 auto}.user-coupon-share .coupon-content .share-title[data-v-bd071d58]{width:%?541?%;height:%?125?%;font-size:%?36?%;top:0}.user-coupon-share .coupon-content .atv-rule[data-v-bd071d58]{-webkit-transform:rotate(1turn);transform:rotate(1turn)}.user-coupon-share .popup-share .list-item[data-v-bd071d58]{width:50%}.user-coupon-share .popup-share .list-item .item-image[data-v-bd071d58]{width:%?66?%;height:%?66?%}',""]),t.exports=e}}]);