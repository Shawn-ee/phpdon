(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["user-pages-information"],{"42d2":function(n,t,e){"use strict";e.r(t);var i=e("c58f"),o=e("f935");for(var a in o)["default"].indexOf(a)<0&&function(n){e.d(t,n,(function(){return o[n]}))}(a);var r=e("f0c5"),u=Object(r["a"])(o["default"],i["b"],i["c"],!1,null,"d1815142",null,!1,i["a"],void 0);t["default"]=u.exports},a965:function(n,t,e){"use strict";e("7a82");var i=e("4ea4").default;Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var o=i(e("c7eb")),a=i(e("1da1")),r=i(e("5530")),u=e("26cb"),f=i(e("affa")),s={components:{parser:f.default},data:function(){return{options:{},isLoad:!1,detail:{}}},computed:(0,u.mapState)({primaryColor:function(n){return n.config.configInfo.primaryColor},subColor:function(n){return n.config.configInfo.subColor},configInfo:function(n){return n.config.configInfo},userInfo:function(n){return n.user.userInfo},loginPage:function(n){return n.user.loginPage}}),onLoad:function(n){this.options=n,this.$util.showLoading(),this.initIndex()},methods:(0,r.default)((0,r.default)((0,r.default)({},(0,u.mapActions)(["getConfigInfo","getUserInfo"])),(0,u.mapMutations)(["updateUserItem"])),{},{initIndex:function(){var n=arguments,t=this;return(0,a.default)((0,o.default)().mark((function e(){var i;return(0,o.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:return n.length>0&&void 0!==n[0]&&n[0],e.next=3,t.$api.base.getConfig();case 3:i=e.sent,t.detail=i,t.$util.setNavigationBarColor({bg:t.primaryColor}),t.$util.hideAll(),t.isLoad=!0;case 8:case"end":return e.stop()}}),e)})))()},initRefresh:function(){this.initIndex(!0)},linkpress:function(n){}})};t.default=s},c58f:function(n,t,e){"use strict";e.d(t,"b",(function(){return i})),e.d(t,"c",(function(){return o})),e.d(t,"a",(function(){}));var i=function(){var n=this,t=n.$createElement,e=n._self._c||t;return n.isLoad?e("v-uni-view",{staticClass:"user-pages-information fill-base"},[e("v-uni-view",{staticClass:"pd-lg f-paragraph"},[e("parser",{attrs:{html:n.detail.information_protection,"show-with-animation":!0,"lazy-load":!0},on:{linkpress:function(t){arguments[0]=t=n.$handleEvent(t),n.linkpress.apply(void 0,arguments)}}},[n._v("加载中...")])],1),e("v-uni-view",{staticClass:"space-footer"})],1):n._e()},o=[]},f935:function(n,t,e){"use strict";e.r(t);var i=e("a965"),o=e.n(i);for(var a in i)["default"].indexOf(a)<0&&function(n){e.d(t,n,(function(){return i[n]}))}(a);t["default"]=o.a}}]);