(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["user-pages-common-video"],{"0cd9":function(t,n,e){"use strict";e("7a82");var a=e("4ea4").default;Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var o=a(e("c7eb")),i=a(e("1da1")),r=e("26cb"),u={data:function(){return{url:"",number:""}},computed:(0,r.mapState)({primaryColor:function(t){return t.config.configInfo.primaryColor},subColor:function(t){return t.config.configInfo.subColor}}),onLoad:function(t){var n=this;return(0,i.default)((0,o.default)().mark((function e(){var a;return(0,o.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:n.$util.setNavigationBarColor({bg:n.primaryColor}),a=decodeURIComponent(t.url),n.url=a;case 3:case"end":return e.stop()}}),e)})))()},methods:{play:function(t){this.$util.log("play=> ",t)},pause:function(t){this.$util.log("pause=> ",t)},ended:function(t){this.$util.log("ended=> ",t)},waitingCallback:function(t){this.$util.log("waitingCallback=> ",t)},errorCallback:function(t){this.$util.log("errorCallback=> ",t)},loadedmetadata:function(t){this.$util.log("loadedmetadata=> ",t);var n=t.detail,e=n.width,a=n.height,o=(a/e*100).toFixed(2);this.number=o?"".concat(o,"%"):"56.25%"}}};n.default=u},"524a":function(t,n,e){var a=e("24fb");n=a(!1),n.push([t.i,".video-box[data-v-126727df]{position:relative;width:100%;height:0\n\t/* padding-bottom: 56.25%; */\n\t/*用 9/16 得出，其他比例类似*/}.my-video[data-v-126727df]{position:absolute;left:0;top:0;width:100%;height:100%;align-items:center}",""]),t.exports=n},"5f2e":function(t,n,e){"use strict";e.r(n);var a=e("0cd9"),o=e.n(a);for(var i in a)["default"].indexOf(i)<0&&function(t){e.d(n,t,(function(){return a[t]}))}(i);n["default"]=o.a},6552:function(t,n,e){"use strict";var a=e("8538"),o=e.n(a);o.a},"7cd9":function(t,n,e){"use strict";e.d(n,"b",(function(){return a})),e.d(n,"c",(function(){return o})),e.d(n,"a",(function(){}));var a=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("v-uni-view",{staticClass:"video-box",style:{paddingBottom:t.number}},[e("v-uni-video",{staticClass:"my-video",attrs:{"object-fit":"fill",preload:"meta",src:t.url,autoplay:"true",controls:!0},on:{play:function(n){arguments[0]=n=t.$handleEvent(n),t.play.apply(void 0,arguments)},pause:function(n){arguments[0]=n=t.$handleEvent(n),t.pause.apply(void 0,arguments)},ended:function(n){arguments[0]=n=t.$handleEvent(n),t.ended.apply(void 0,arguments)},waiting:function(n){arguments[0]=n=t.$handleEvent(n),t.waitingCallback.apply(void 0,arguments)},error:function(n){arguments[0]=n=t.$handleEvent(n),t.errorCallback.apply(void 0,arguments)},loadedmetadata:function(n){arguments[0]=n=t.$handleEvent(n),t.loadedmetadata.apply(void 0,arguments)}}})],1)},o=[]},8538:function(t,n,e){var a=e("524a");a.__esModule&&(a=a.default),"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var o=e("4f06").default;o("27b33863",a,!0,{sourceMap:!1,shadowMode:!1})},"9df9":function(t,n,e){"use strict";e.r(n);var a=e("7cd9"),o=e("5f2e");for(var i in o)["default"].indexOf(i)<0&&function(t){e.d(n,t,(function(){return o[t]}))}(i);e("6552");var r=e("f0c5"),u=Object(r["a"])(o["default"],a["b"],a["c"],!1,null,"126727df",null,!1,a["a"],void 0);n["default"]=u.exports}}]);