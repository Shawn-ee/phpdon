(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["user-pages-protocol"],{2014:function(n,t,e){"use strict";e("7a82");var o=e("4ea4").default;Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var i=o(e("c7eb")),a=o(e("1da1")),r=o(e("5530")),u=e("26cb"),s=o(e("affa")),f={components:{parser:s.default},data:function(){return{options:{},isLoad:!1,detail:{}}},computed:(0,u.mapState)({primaryColor:function(n){return n.config.configInfo.primaryColor},subColor:function(n){return n.config.configInfo.subColor},configInfo:function(n){return n.config.configInfo},userInfo:function(n){return n.user.userInfo},loginPage:function(n){return n.user.loginPage}}),onLoad:function(n){this.options=n,this.$util.showLoading(),this.initIndex()},methods:(0,r.default)((0,r.default)((0,r.default)({},(0,u.mapActions)(["getConfigInfo","getUserInfo"])),(0,u.mapMutations)(["updateUserItem"])),{},{initIndex:function(){var n=arguments,t=this;return(0,a.default)((0,i.default)().mark((function e(){var o;return(0,i.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:return n.length>0&&void 0!==n[0]&&n[0],e.next=3,t.$api.base.getConfig();case 3:o=e.sent,t.detail=o,t.$util.setNavigationBarColor({bg:t.primaryColor}),t.$util.hideAll(),t.isLoad=!0;case 8:case"end":return e.stop()}}),e)})))()},initRefresh:function(){this.initIndex(!0)},linkpress:function(n){console.log("linkpress",n)}})};t.default=f},4194:function(n,t,e){"use strict";e.r(t);var o=e("2014"),i=e.n(o);for(var a in o)["default"].indexOf(a)<0&&function(n){e.d(t,n,(function(){return o[n]}))}(a);t["default"]=i.a},4815:function(n,t,e){"use strict";e.d(t,"b",(function(){return o})),e.d(t,"c",(function(){return i})),e.d(t,"a",(function(){}));var o=function(){var n=this,t=n.$createElement,e=n._self._c||t;return n.isLoad?e("v-uni-view",{staticClass:"user-pages-protocol fill-base"},[e("v-uni-view",{staticClass:"pd-lg f-paragraph"},[e("parser",{attrs:{html:n.detail.login_protocol,"show-with-animation":!0,"lazy-load":!0},on:{linkpress:function(t){arguments[0]=t=n.$handleEvent(t),n.linkpress.apply(void 0,arguments)}}},[n._v("加载中...")])],1),e("v-uni-view",{staticClass:"space-footer"})],1):n._e()},i=[]},"4b76":function(n,t,e){"use strict";e.r(t);var o=e("4815"),i=e("4194");for(var a in i)["default"].indexOf(a)<0&&function(n){e.d(t,n,(function(){return i[n]}))}(a);var r=e("f0c5"),u=Object(r["a"])(i["default"],o["b"],o["c"],!1,null,"ce4f173e",null,!1,o["a"],void 0);t["default"]=u.exports}}]);