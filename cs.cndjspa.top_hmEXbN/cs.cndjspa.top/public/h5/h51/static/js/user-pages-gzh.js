(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["user-pages-gzh"],{2099:function(e,n,t){"use strict";t.d(n,"b",(function(){return i})),t.d(n,"c",(function(){return o})),t.d(n,"a",(function(){}));var i=function(){var e=this,n=e.$createElement,t=e._self._c||n;return e.isLoad?t("v-uni-view",{staticClass:"mine-pages-gzh flex-center flex-column"},[e.configInfo.web_code_img?t("v-uni-image",{staticClass:"web-code-img",attrs:{mode:"widthFix",src:e.configInfo.web_code_img}}):t("v-uni-view",{staticClass:"gzh-img-info rel"},[t("v-uni-image",{staticClass:"gzh-img",attrs:{src:e.gzh_img}}),e.configInfo.web_code_img?e._e():t("v-uni-view",{staticClass:"none-text f-title flex-center abs"},[e._v("商家还没有放公众号二维码哟~")])],1),e.configInfo.web_code_img?e._e():t("v-uni-view",{staticClass:"home-btn flex-center f-sm-title c-base radius",style:{background:e.primaryColor},on:{click:function(n){n.stopPropagation(),arguments[0]=n=e.$handleEvent(n),e.$util.goUrl({url:"/pages/service",openType:"redirectTo"})}}},[e._v("直接进入首页")])],1):e._e()},o=[]},"9d5d":function(e,n,t){var i=t("24fb");n=i(!1),n.push([e.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */uni-page-body[data-v-2e7e4da6]{background:#fefffe}body.?%PAGE?%[data-v-2e7e4da6]{background:#fefffe}.mine-pages-gzh .web-code-img[data-v-2e7e4da6]{width:%?750?%}.mine-pages-gzh .gzh-img-info[data-v-2e7e4da6]{width:%?536?%;height:%?552?%;margin-top:%?114?%}.mine-pages-gzh .gzh-img-info .gzh-img[data-v-2e7e4da6]{width:%?536?%;height:%?552?%;border-radius:%?30?%}.mine-pages-gzh .gzh-img-info .none-text[data-v-2e7e4da6]{width:%?536?%;color:#2e2e31;bottom:%?-20?%}.mine-pages-gzh .home-btn[data-v-2e7e4da6]{width:%?690?%;height:%?90?%;margin-top:%?126?%}',""]),e.exports=n},"9fb8":function(e,n,t){"use strict";t.r(n);var i=t("f070"),o=t.n(i);for(var a in i)["default"].indexOf(a)<0&&function(e){t.d(n,e,(function(){return i[e]}))}(a);n["default"]=o.a},ba53:function(e,n,t){var i=t("9d5d");i.__esModule&&(i=i.default),"string"===typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);var o=t("4f06").default;o("f72c3d64",i,!0,{sourceMap:!1,shadowMode:!1})},d91e:function(e,n,t){"use strict";var i=t("ba53"),o=t.n(i);o.a},e05f:function(e,n,t){"use strict";t.r(n);var i=t("2099"),o=t("9fb8");for(var a in o)["default"].indexOf(a)<0&&function(e){t.d(n,e,(function(){return o[e]}))}(a);t("d91e");var r=t("f0c5"),s=Object(r["a"])(o["default"],i["b"],i["c"],!1,null,"2e7e4da6",null,!1,i["a"],void 0);n["default"]=s.exports},f070:function(e,n,t){"use strict";t("7a82");var i=t("4ea4").default;Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var o=i(t("5530")),a=i(t("c7eb")),r=i(t("1da1")),s=t("26cb"),u={data:function(){return{isLoad:!1,options:{},gzh_img:"https://lbqny.migugu.com/admin/anmo/mine/web-code-img.png"}},computed:(0,s.mapState)({primaryColor:function(e){return e.config.configInfo.primaryColor},subColor:function(e){return e.config.configInfo.subColor},configInfo:function(e){return e.config.configInfo},userInfo:function(e){return e.user.userInfo}}),onLoad:function(e){var n=this;return(0,r.default)((0,a.default)().mark((function t(){return(0,a.default)().wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,n.updateCommonOptions(e);case 2:return e=t.sent,n.options=e,t.next=6,n.initIndex();case 6:case"end":return t.stop()}}),t)})))()},methods:(0,o.default)((0,o.default)((0,o.default)({},(0,s.mapActions)(["getConfigInfo","getUserInfo","updateCommonOptions"])),(0,s.mapMutations)(["updateConfigItem"])),{},{initIndex:function(){var e=this;return(0,r.default)((0,a.default)().mark((function n(){return(0,a.default)().wrap((function(n){while(1)switch(n.prev=n.next){case 0:return n.next=2,e.getUserInfo();case 2:return n.next=4,e.getConfigInfo();case 4:e.$util.setNavigationBarColor({bg:e.primaryColor}),e.isLoad=!0;case 6:case"end":return n.stop()}}),n)})))()}})};n.default=u}}]);