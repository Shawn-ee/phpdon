(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["technician-pages-bad-comments-list"],{2227:function(t,n,i){var a=i("24fb");n=a(!1),n.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.item-nav[data-v-40430ec0]{height:%?96?%}.item-cont[data-v-40430ec0]{background-color:#f7f8fa;min-height:%?218?%}',""]),t.exports=n},"268f":function(t,n,i){"use strict";i.d(n,"b",(function(){return a})),i.d(n,"c",(function(){return e})),i.d(n,"a",(function(){}));var a=function(){var t=this,n=t.$createElement,i=t._self._c||n;return i("v-uni-view",[i("fixed",[i("tab",{attrs:{isLine:!0,list:t.tabList,activeIndex:1*t.activeIndex,color:"#9D9D9D",activeColor:t.primaryColor,width:100/t.tabList.length+"%",height:"100rpx",numberType:2},on:{change:function(n){arguments[0]=n=t.$handleEvent(n),t.handerTabChange.apply(void 0,arguments)}}})],1),i("v-uni-view",{staticClass:"pd-md"},t._l(t.list.data,(function(n,a){return i("v-uni-view",{key:a,staticClass:"pl-lg pr-lg pb-lg fill-base radius-16 mb-md"},[i("v-uni-view",{staticClass:"item-nav flex-between "},[i("v-uni-text",{staticClass:"f-paragraph text-bold"},[t._v("订单号 "+t._s(n.order_code))]),1==n.status?i("v-uni-text",{style:{color:t.primaryColor}},[t._v("未处理")]):i("v-uni-text",{staticClass:"c-caption"},[t._v("已处理")])],1),i("v-uni-view",{staticClass:"item-cont radius-16 pd-lg"},[i("v-uni-view",{staticClass:"f-paragraph text-bold pb-md"},[t._v("申诉理由")]),i("v-uni-view",{staticClass:"c-paragraph ellipsis-2",staticStyle:{"white-space":"pre-wrap"}},[t._v(t._s(n.content))])],1),2==n.status?i("v-uni-view",[i("v-uni-view",{staticClass:"f-paragraph text-bold pb-md pt-lg"},[t._v("处理结果")]),i("v-uni-view",{staticClass:"c-paragraph",staticStyle:{"white-space":"pre-wrap"}},[t._v(t._s(n.reply_content||"无"))])],1):t._e()],1)})),1),t.loading?i("load-more",{attrs:{noMore:t.list.current_page>=t.list.last_page&&t.list.data.length>0,loading:t.loading}}):t._e(),!t.loading&&t.list.data.length<=0&&1==t.list.current_page?i("abnor"):t._e(),i("v-uni-view",{staticClass:"space-footer"})],1)},e=[]},3265:function(t,n,i){"use strict";i.r(n);var a=i("268f"),e=i("c514");for(var s in e)["default"].indexOf(s)<0&&function(t){i.d(n,t,(function(){return e[t]}))}(s);i("c486");var r=i("f0c5"),o=Object(r["a"])(e["default"],a["b"],a["c"],!1,null,"40430ec0",null,!1,a["a"],void 0);n["default"]=o.exports},"38c4":function(t,n,i){"use strict";i("7a82");var a=i("4ea4").default;Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0,i("99af");var e=a(i("c7eb")),s=a(i("1da1")),r=i("26cb"),o={data:function(){return{tabList:[{title:"全部反馈",sort:"top desc",sign:1},{title:"未处理",sort:"price",sign:0,number:0},{title:"已处理",sort:"total_sale",sign:0}],activeIndex:0,loading:!0,isLoad:!1,param:{page:1,limit:10,status:0},list:{data:[]}}},computed:(0,r.mapState)({primaryColor:function(t){return t.config.configInfo.primaryColor},subColor:function(t){return t.config.configInfo.subColor},configInfo:function(t){return t.config.configInfo},userInfo:function(t){return t.user.userInfo}}),onLoad:function(){this.$util.setNavigationBarColor({bg:this.primaryColor}),this.initIndex()},onPullDownRefresh:function(){uni.showNavigationBarLoading(),this.initRefresh(),uni.stopPullDownRefresh()},onReachBottom:function(){this.list.current_page>=this.list.last_page||this.loading||(this.param.page=this.param.page+1,this.loading=!0,this.getList())},methods:{initIndex:function(){var t=arguments,n=this;return(0,s.default)((0,e.default)().mark((function i(){var a;return(0,e.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(a=t.length>0&&void 0!==t[0]&&t[0],a||!n.$jweixin.isWechat()){i.next=5;break}return i.next=4,n.$jweixin.initJssdk();case 4:n.$jweixin.wxReady((function(){n.$jweixin.hideOptionMenu()}));case 5:n.getList();case 6:case"end":return i.stop()}}),i)})))()},handerTabChange:function(t){this.activeIndex=t,this.param.status=t,this.getList()},initRefresh:function(){this.param.page=1,this.initIndex(!0)},getList:function(){var t=this;return(0,s.default)((0,e.default)().mark((function n(){var i,a,s;return(0,e.default)().wrap((function(n){while(1)switch(n.prev=n.next){case 0:return t.$util.showLoading(),i=t.list,a=t.param,n.next=4,t.$api.technician.appealList(a);case 4:s=n.sent,1==t.param.page||(s.data=i.data.concat(s.data)),t.list=s,t.tabList[1].number=s.wait,t.isLoad=!0,t.loading=!1,t.$util.hideAll();case 10:case"end":return n.stop()}}),n)})))()}}};n.default=o},c486:function(t,n,i){"use strict";var a=i("e358"),e=i.n(a);e.a},c514:function(t,n,i){"use strict";i.r(n);var a=i("38c4"),e=i.n(a);for(var s in a)["default"].indexOf(s)<0&&function(t){i.d(n,t,(function(){return a[t]}))}(s);n["default"]=e.a},e358:function(t,n,i){var a=i("2227");a.__esModule&&(a=a.default),"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var e=i("4f06").default;e("e42b6f98",a,!0,{sourceMap:!1,shadowMode:!1})}}]);