(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["user-pages-feedback-list"],{"012a":function(t,e,i){"use strict";var n=i("388b"),a=i.n(n);a.a},"388b":function(t,e,i){var n=i("c62f");n.__esModule&&(n=n.default),"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("2ed9d417",n,!0,{sourceMap:!1,shadowMode:!1})},"5a24":function(t,e,i){"use strict";i("7a82");var n=i("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("99af");var a=n(i("c7eb")),s=n(i("1da1")),r=i("26cb"),o={data:function(){return{tabList:[{title:"全部反馈",sort:"top desc",sign:1},{title:"未处理",sort:"price",sign:0,number:0},{title:"已处理",sort:"total_sale",sign:0}],activeIndex:0,loading:!0,isLoad:!1,param:{page:1,limit:10,status:0},list:{data:[]}}},computed:(0,r.mapState)({primaryColor:function(t){return t.config.configInfo.primaryColor},subColor:function(t){return t.config.configInfo.subColor},configInfo:function(t){return t.config.configInfo},userInfo:function(t){return t.user.userInfo}}),onLoad:function(){this.$util.setNavigationBarColor({bg:this.primaryColor}),this.initIndex()},onPullDownRefresh:function(){uni.showNavigationBarLoading(),this.initRefresh(),uni.stopPullDownRefresh()},onReachBottom:function(){this.list.current_page>=this.list.last_page||this.loading||(this.param.page=this.param.page+1,this.loading=!0,this.getList())},methods:{handerTabChange:function(t){this.activeIndex=t,this.param.status=t,this.initIndex()},initRefresh:function(){this.param.page=1,this.initIndex(!0)},initIndex:function(){var t=arguments,e=this;return(0,s.default)((0,a.default)().mark((function i(){var n;return(0,a.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(n=t.length>0&&void 0!==t[0]&&t[0],n||!e.$jweixin.isWechat()){i.next=5;break}return i.next=4,e.$jweixin.initJssdk();case 4:e.$jweixin.wxReady((function(){e.$jweixin.hideOptionMenu()}));case 5:e.getList();case 6:case"end":return i.stop()}}),i)})))()},getList:function(){var t=this;return(0,s.default)((0,a.default)().mark((function e(){var i,n,s;return(0,a.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:return t.$util.showLoading(),i=t.list,n=t.param,e.next=4,t.$api.mine.listFeedback(n);case 4:s=e.sent,1==t.param.page||(s.data=i.data.concat(s.data)),t.list=s,t.tabList[1].number=s.wait,t.isLoad=!0,t.loading=!1,t.$util.hideAll();case 10:case"end":return e.stop()}}),e)})))()}}};e.default=o},"8f2d":function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return a})),i.d(e,"a",(function(){}));var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("fixed",[i("tab",{attrs:{isLine:!0,list:t.tabList,activeIndex:1*t.activeIndex,color:"#9D9D9D",activeColor:t.primaryColor,width:100/t.tabList.length+"%",height:"100rpx",numberType:2},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.handerTabChange.apply(void 0,arguments)}}})],1),i("v-uni-view",{staticClass:"pd-md"},t._l(t.list.data,(function(e,n){return i("v-uni-view",{key:n,staticClass:"pl-lg pr-lg pb-lg fill-base radius-16 mb-md rel item-box"},[i("v-uni-view",{staticClass:"abs type-name text-center flex-center"},[i("v-uni-view",{staticClass:"taye-name-bg",style:{backgroundColor:t.primaryColor}}),i("v-uni-text",{staticClass:"c-base f-caption",staticStyle:{"z-index":"9"},style:{color:t.primaryColor}},[t._v(t._s(e.type_name))])],1),i("v-uni-view",{staticClass:"item-nav flex-between "},[i("v-uni-text",{staticClass:"f-paragraph text-bold"},[t._v("订单号 "+t._s(e.order_code||"无"))]),1==e.status?i("v-uni-text",{style:{color:t.primaryColor}},[t._v("未处理")]):i("v-uni-text",{staticClass:"c-caption"},[t._v("已处理")])],1),i("v-uni-view",{staticClass:"item-cont radius-16 pd-lg"},[i("v-uni-view",{staticClass:"f-paragraph text-bold pb-md"},[t._v("反馈内容")]),i("v-uni-view",{staticClass:"c-paragraph ellipsis-2",staticStyle:{"white-space":"pre-wrap"}},[t._v(t._s(e.content))])],1),i("v-uni-view",{staticClass:"flex pt-lg",staticStyle:{"justify-content":"flex-end"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.$util.goUrl({url:"/user/pages/feedback/detail?id="+e.id})}}},[i("v-uni-view",{staticClass:"reply f-desc c-base text-center",style:{backgroundColor:t.primaryColor}},[t._v("查看详情")])],1)],1)})),1),t.loading?i("load-more",{attrs:{noMore:t.list.current_page>=t.list.last_page&&t.list.data.length>0,loading:t.loading}}):t._e(),!t.loading&&t.list.data.length<=0&&1==t.list.current_page?i("abnor"):t._e(),i("v-uni-view",{staticClass:"space-footer"})],1)},a=[]},"99f8":function(t,e,i){"use strict";i.r(e);var n=i("5a24"),a=i.n(n);for(var s in n)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=a.a},c62f:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.item-nav[data-v-4d4247d5]{height:%?96?%}.item-box[data-v-4d4247d5]{padding-top:%?80?%}.item-cont[data-v-4d4247d5]{background-color:#f7f8fa;min-height:%?218?%}.type-name[data-v-4d4247d5]{top:0;left:0;width:%?146?%;height:%?47?%;line-height:%?47?%;overflow:hidden;border-bottom-right-radius:%?16?%;border-top-left-radius:%?16?%}.type-name .taye-name-bg[data-v-4d4247d5]{position:absolute;width:100%;height:100%;left:0;top:0;opacity:.1}.reply[data-v-4d4247d5]{width:%?140?%;height:%?56?%;line-height:%?56?%;border-radius:%?56?%}',""]),t.exports=e},d84e:function(t,e,i){"use strict";i.r(e);var n=i("8f2d"),a=i("99f8");for(var s in a)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return a[t]}))}(s);i("012a");var r=i("f0c5"),o=Object(r["a"])(a["default"],n["b"],n["c"],!1,null,"4d4247d5",null,!1,n["a"],void 0);e["default"]=o.exports}}]);