(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["technician-pages-shop-detail"],{"18aa":function(e,n,t){var i=t("d2d4");i.__esModule&&(i=i.default),"string"===typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);var a=t("4f06").default;a("1d1262ce",i,!0,{sourceMap:!1,shadowMode:!1})},"1ac5":function(e,n,t){"use strict";t("7a82");var i=t("4ea4").default;Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var a=i(t("c7eb")),o=i(t("1da1")),s=i(t("5530"));t("99af");var r=t("26cb"),u=i(t("affa")),c=i(t("88dd")),d=i(t("0964")),l={components:{parser:u.default,shopBanner:c.default},data:function(){return{isLoad:!1,options:{},shopInfo:{},isShare:!1}},computed:(0,r.mapState)({primaryColor:function(e){return e.config.configInfo.primaryColor},subColor:function(e){return e.config.configInfo.subColor},configInfo:function(e){return e.config.configInfo},userInfo:function(e){return e.user.userInfo}}),onLoad:function(e){e.pid&&(this.isShare=!0),this.options=e,this.initIndex()},onPullDownRefresh:function(){uni.showNavigationBarLoading(),this.initRefresh(),uni.stopPullDownRefresh()},onShareAppMessage:function(){var e=this.userInfo.id,n=void 0===e?0:e,t=this.shopInfo,i=t.id,a=t.name,o=t.cover,s="/technician/pages/shop/detail?id=".concat(i,"&pid=").concat(n);return{title:a,imageUrl:o,path:s}},methods:(0,s.default)((0,s.default)({},(0,r.mapActions)(["getConfigInfo","getUserInfo"])),{},{initRefresh:function(){this.initIndex(!0)},initIndex:function(){var e=arguments,n=this;return(0,o.default)((0,a.default)().mark((function t(){var i,o,s,r,u;return(0,a.default)().wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(i=e.length>0&&void 0!==e[0]&&e[0],o=n.options.pid,s=void 0===o?0:o,r=n.userInfo.id,u=void 0===r?0:r,!s||u){t.next=6;break}return t.next=6,n.getUserInfo();case 6:if(n.configInfo.id&&!i){t.next=9;break}return t.next=9,n.getConfigInfo();case 9:return t.next=11,n.goodsInfoCall();case 11:if(!n.$jweixin.isWechat()){t.next=15;break}return t.next=14,n.$jweixin.initJssdk();case 14:n.toAppShare();case 15:case"end":return t.stop()}}),t)})))()},goodsInfoCall:function(){var e=this;return(0,o.default)((0,a.default)().mark((function n(){var t;return(0,a.default)().wrap((function(n){while(1)switch(n.prev=n.next){case 0:return e.$util.showLoading(),t=e.options.id,n.next=4,e.$api.technician.goodsInfo({id:t});case 4:e.shopInfo=n.sent,e.isLoad=!0,e.$util.hideAll();case 7:case"end":return n.stop()}}),n)})))()},swiperChange:function(e){},linkpress:function(e){},toAppShare:function(){var e=this,n=this.userInfo.id,t=void 0===n?0:n,i=this.shopInfo,a=i.id,o=i.name,s=i.cover,r=d.default.siteroot,u=r.split("/index.php")[0],c="".concat(u,"/h5/#/technician/pages/shop/detail?id=").concat(a,"&pid=").concat(t);this.$jweixin.wxReady((function(){e.$jweixin.showOptionMenu(),e.$jweixin.shareAppMessage(o,"",c,s),e.$jweixin.shareTimelineMessage(o,c,s)}))}})};n.default=l},"2e4e":function(e,n,t){var i=t("24fb");n=i(!1),n.push([e.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.shop .shop-swiper[data-v-b4e3de6a]{height:%?564?%}.shop .shop-box-title[data-v-b4e3de6a]{line-height:%?110?%;height:%?110?%}.shop .shop-box-item[data-v-b4e3de6a]{width:100%;height:%?388?%}.shop .shop-box-item uni-image[data-v-b4e3de6a]{vertical-align:bottom;width:100%;height:100%}.shop .share-btn[data-v-b4e3de6a]{right:%?30?%;bottom:%?30?%;height:%?42?%}',""]),e.exports=n},3225:function(e,n,t){"use strict";t("7a82"),Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0,t("a9e3");var i=t("26cb"),a={props:{detail:{type:Object,default:function(){return{}}},isShare:{type:Boolean,default:function(){return!1}},setCurrent:{type:Number,default:function(){return 0}}},watch:{"detail.images":function(e,n){this.current=0}},data:function(){return{statusBarHeight:uni.getSystemInfoSync().statusBarHeight,videoContexts:{},playVideo:!1,current:0}},computed:(0,i.mapState)({primaryColor:function(e){return e.config.configInfo.primaryColor},subColor:function(e){return e.config.configInfo.subColor},configInfo:function(e){return e.config.configInfo},userInfo:function(e){return e.user.userInfo}}),created:function(){this.videoContexts=uni.createVideoContext("video_id",this)},methods:{handerSwiperChange:function(e){var n=e.detail.current;this.current=n,this.videoContexts.pause(),this.playVideo=!1},swiperTransition:function(e){},playCurrent:function(){this.videoContexts.play(),this.playVideo=!0},onPlay:function(e){},onPause:function(e){},onEnded:function(e){},onError:function(e){},onTimeUpdate:function(e){},onWaiting:function(e){},onProgress:function(e){},onLoadedMetaData:function(e){},handerBannerClick:function(e){var n=this.detail,t=n.image_url,i=n.video_url,a=void 0===i?"":i;0==e&&a?this.playVideo=!0:t&&this.$util.goUrl({openType:"web",url:t})},goBack:function(){uni.navigateBack({delta:1})}}};n.default=a},3889:function(e,n,t){var i=t("2e4e");i.__esModule&&(i=i.default),"string"===typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);var a=t("4f06").default;a("5edb4629",i,!0,{sourceMap:!1,shadowMode:!1})},6154:function(e,n,t){"use strict";var i=t("3889"),a=t.n(i);a.a},6378:function(e,n,t){"use strict";t.r(n);var i=t("3225"),a=t.n(i);for(var o in i)["default"].indexOf(o)<0&&function(e){t.d(n,e,(function(){return i[e]}))}(o);n["default"]=a.a},"764e":function(e,n,t){"use strict";t.d(n,"b",(function(){return i})),t.d(n,"c",(function(){return a})),t.d(n,"a",(function(){}));var i=function(){var e=this,n=e.$createElement,t=e._self._c||n;return e.isLoad?t("v-uni-view",{staticClass:"shop"},[t("v-uni-view",{staticClass:"shop-swiper"},[t("shopBanner",{attrs:{detail:e.shopInfo,isShare:e.isShare}})],1),t("v-uni-view",[t("v-uni-view",{staticClass:"pd-lg fill-base flex-between rel",staticStyle:{"align-items":"flex-end"}},[t("v-uni-view",[t("v-uni-view",{staticClass:"f-sm-title text-bold c-black"},[e._v(e._s(e.shopInfo.name))]),t("v-uni-view",{staticClass:"pt-md c-warning",staticStyle:{"line-height":"1"}},[t("v-uni-text",{staticClass:"f-icontext"},[e._v("￥")]),t("v-uni-text",{staticClass:"f-sm-title text-bold"},[e._v(e._s(e.shopInfo.price))])],1)],1)],1),t("v-uni-view",{staticClass:"mt-md fill-base pl-lg pr-lg"},[t("v-uni-view",{staticClass:"f-min-title c-black shop-box-title"},[e._v("商品详情")]),t("v-uni-view",{staticClass:"fill-base pt-lg pb-lg"},[t("parser",{attrs:{html:e.shopInfo.desc,"show-with-animation":!0,"lazy-load":!0},on:{linkpress:function(n){arguments[0]=n=e.$handleEvent(n),e.linkpress.apply(void 0,arguments)}}},[e._v("加载中...")])],1)],1)],1),t("v-uni-view",{staticClass:"space-max-footer"}),t("fix-bottom-button",{attrs:{text:[{type:"confirm",text:"联系平台"}],bgColor:"#fff"},on:{confirm:function(n){arguments[0]=n=e.$handleEvent(n),e.$util.goUrl({url:e.shopInfo.phone,openType:"call"})}}})],1):e._e()},a=[]},7849:function(e,n,t){"use strict";t.r(n);var i=t("1ac5"),a=t.n(i);for(var o in i)["default"].indexOf(o)<0&&function(e){t.d(n,e,(function(){return i[e]}))}(o);n["default"]=a.a},"88dd":function(e,n,t){"use strict";t.r(n);var i=t("bac6"),a=t("6378");for(var o in a)["default"].indexOf(o)<0&&function(e){t.d(n,e,(function(){return a[e]}))}(o);t("b0ac");var s=t("f0c5"),r=Object(s["a"])(a["default"],i["b"],i["c"],!1,null,"eed20546",null,!1,i["a"],void 0);n["default"]=r.exports},b0ac:function(e,n,t){"use strict";var i=t("18aa"),a=t.n(i);a.a},bac6:function(e,n,t){"use strict";t.d(n,"b",(function(){return i})),t.d(n,"c",(function(){return a})),t.d(n,"a",(function(){}));var i=function(){var e=this,n=e.$createElement,t=e._self._c||n;return t("v-uni-view",{staticClass:"rel"},[t("v-uni-view",{staticClass:"abs",staticStyle:{"z-index":"99"},style:{top:e.statusBarHeight+"px"}},[e.isShare?t("v-uni-view",{class:[{"back-user-ios":e.configInfo.isIos},{"back-user-android":!e.configInfo.isIos}],on:{click:function(n){arguments[0]=n=e.$handleEvent(n),e.$util.goUrl({url:"/pages/service",openType:"reLaunch"})}}},[t("v-uni-view",{staticClass:"iconshouye iconfont"}),t("v-uni-view",{staticClass:"back-user_text"},[e._v("回到首页")])],1):e._e()],1),t("v-uni-view",{staticClass:"banner"},[t("v-uni-swiper",{staticClass:"banner-swiper",style:{background:e.playVideo&&!e.detail.video_vid?"#000":"#f4f6f8"},attrs:{autoplay:!e.playVideo,current:e.current},on:{change:function(n){arguments[0]=n=e.$handleEvent(n),e.handerSwiperChange.apply(void 0,arguments)},transition:function(n){arguments[0]=n=e.$handleEvent(n),e.swiperTransition.apply(void 0,arguments)}}},e._l(e.detail.images,(function(n,i){return t("v-uni-swiper-item",{key:i,on:{click:function(n){arguments[0]=n=e.$handleEvent(n),e.handerBannerClick(i)}}},[0==i&&e.detail.video_url?[e.playVideo?e._e():[t("v-uni-view",{staticClass:"banner-swiper c-base iconfont icontushucxuanzebofangtiaozhuan abs flex-center",staticStyle:{top:"0rpx","font-size":"80rpx","z-index":"9"},on:{click:function(n){n.stopPropagation(),arguments[0]=n=e.$handleEvent(n),e.playCurrent.apply(void 0,arguments)}}}),t("v-uni-image",{staticClass:"banner-img",attrs:{src:n,mode:"aspectFill"}})],e.playVideo&&!e.detail.video_vid?t("v-uni-view",{staticClass:"video-box"},[t("v-uni-video",{staticClass:"my-video",attrs:{id:"video_id",loop:!1,"enable-play-gesture":!0,"enable-progress-gesture":!1,src:e.detail.video_url,autoplay:e.playVideo},on:{play:function(n){arguments[0]=n=e.$handleEvent(n),e.onPlay.apply(void 0,arguments)},pause:function(n){arguments[0]=n=e.$handleEvent(n),e.onPause.apply(void 0,arguments)},ended:function(n){arguments[0]=n=e.$handleEvent(n),e.onEnded.apply(void 0,arguments)},timeupdate:function(n){arguments[0]=n=e.$handleEvent(n),e.onTimeUpdate.apply(void 0,arguments)},waiting:function(n){arguments[0]=n=e.$handleEvent(n),e.onWaiting.apply(void 0,arguments)},progress:function(n){arguments[0]=n=e.$handleEvent(n),e.onProgress.apply(void 0,arguments)},loadedmetadata:function(n){arguments[0]=n=e.$handleEvent(n),e.onLoadedMetaData.apply(void 0,arguments)}}})],1):e._e()]:t("v-uni-image",{staticClass:"banner-img",attrs:{src:n,mode:"aspectFill"}})],2)})),1),!e.playVideo&&e.detail.images.length?t("v-uni-view",{staticClass:"banner-tagitem banner-tagitem_count"},[e._v(e._s(e.current+1)+"/"+e._s(e.detail.images.length))]):e._e()],1)],1)},a=[]},d2d4:function(e,n,t){var i=t("24fb");n=i(!1),n.push([e.i,".home-return-btn[data-v-eed20546]{margin-top:%?10?%;margin-left:%?24?%;width:%?60?%;height:%?60?%;border:none;background-color:rgba(0,0,0,.3)}.video-box[data-v-eed20546]{position:relative;width:100%;height:%?500?%}.my-video[data-v-eed20546]{position:absolute;left:0;top:0;width:100%;height:80%;align-items:center;margin-top:%?120?%}.banner[data-v-eed20546]{position:relative}.banner-swiper[data-v-eed20546]{width:%?750?%;height:%?564?%}.banner-img[data-v-eed20546]{width:100%;height:100%}.banner-taglist[data-v-eed20546]{display:flex;align-items:center;justify-content:center;position:absolute;bottom:%?32?%;width:100%}.banner-tagitem[data-v-eed20546]{display:flex;align-items:center;justify-content:center;width:%?90?%;height:%?42?%;border-radius:%?21?%;background:hsla(0,0%,100%,.8);color:#2b2b2b;font-size:%?22?%;margin-left:%?32?%}.banner-tagitem[data-v-eed20546]:nth-child(1){margin-left:0}.banner-tagitem_count[data-v-eed20546]{background:rgba(0,0,0,.5);color:#fff;position:absolute;bottom:%?32?%;right:%?32?%;z-index:10}.banner-tagitem_active[data-v-eed20546]{background:#19c865;color:#fff}",""]),e.exports=n},f9df:function(e,n,t){"use strict";t.r(n);var i=t("764e"),a=t("7849");for(var o in a)["default"].indexOf(o)<0&&function(e){t.d(n,e,(function(){return a[e]}))}(o);t("6154");var s=t("f0c5"),r=Object(s["a"])(a["default"],i["b"],i["c"],!1,null,"b4e3de6a",null,!1,i["a"],void 0);n["default"]=r.exports}}]);