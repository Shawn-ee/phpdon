(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["user-pages-choose-technician"],{"0734":function(t,e,i){"use strict";i("7a82");var n=i("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("99af");var a=n(i("3835")),s=n(i("5530")),o=n(i("c7eb")),c=n(i("1da1")),r=i("26cb"),l={components:{},data:function(){return{isLoad:!1,options:{},imgType:{1:"top",2:"hot",3:"new"},textType:{1:"可服务",2:"服务中",3:"可预约"},param:{page:1,ser_id:0,coach_name:""},list:{data:[]},loading:!0,showInd:-1,showType:"",lockTap:!1,serviceList:[],commentList:[],pageLen:1}},computed:(0,r.mapState)({primaryColor:function(t){return t.config.configInfo.primaryColor},subColor:function(t){return t.config.configInfo.subColor},configInfo:function(t){return t.config.configInfo},loginType:function(t){return t.user.loginType},userInfo:function(t){return t.user.userInfo},location:function(t){return t.user.location}}),onLoad:function(t){var e=this;return(0,c.default)((0,o.default)().mark((function i(){return(0,o.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:return e.options=t,i.next=3,e.initIndex();case 3:e.isLoad=!0;case 4:case"end":return i.stop()}}),i)})))()},onPullDownRefresh:function(){uni.showNavigationBarLoading(),this.initRefresh(),uni.stopPullDownRefresh()},onReachBottom:function(){this.list.current_page>=this.list.last_page||this.loading||(this.param.page=this.param.page+1,this.loading=!0,this.getList())},methods:(0,s.default)((0,s.default)({},(0,r.mapMutations)(["updateUserItem"])),{},{initIndex:function(){var t=arguments,e=this;return(0,c.default)((0,o.default)().mark((function i(){var n;return(0,o.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(n=t.length>0&&void 0!==t[0]&&t[0],n||!e.$jweixin.isWechat()){i.next=5;break}return i.next=4,e.$jweixin.initJssdk();case 4:e.$jweixin.wxReady((function(){e.$jweixin.hideOptionMenu()}));case 5:e.pageLen=getCurrentPages().length,e.getList();case 7:case"end":return i.stop()}}),i)})))()},initRefresh:function(){this.showInd=-1,this.param.page=1,this.initIndex(!0)},toOpenLocation:function(){this.$util.checkAuth({type:"userLocation"})},toSearch:function(t){this.param.page=1,this.param.coach_name=t,this.getList()},toChooseLocation:function(t){var e=this;return(0,c.default)((0,o.default)().mark((function t(){var i,n,s,c,r,l,u,d,p,f,v,m,g,h;return(0,o.default)().wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,e.$util.checkAuth({type:"userLocation"});case 2:return t.next=4,uni.chooseLocation();case 4:if(i=t.sent,n=(0,a.default)(i,2),s=n[1],c=s.address,r=void 0===c?"":c,l=s.longitude,u=s.latitude,d=s.province,p=void 0===d?"":d,f=s.city,v=void 0===f?"":f,m=s.district,g=void 0===m?"":m,l){t.next=19;break}return t.abrupt("return");case 19:h={lng:l,lat:u,address:r,province:p,city:v,district:g},e.updateUserItem({key:"location",val:h}),e.param.page=1,e.getList();case 23:case"end":return t.stop()}}),t)})))()},getList:function(){var t=this;return(0,c.default)((0,o.default)().mark((function e(){var i,n,a,s,c,r,l,u,d,p,f,v,m,g,h,w,x,_,C,y,b,k,$,L,I;return(0,o.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(i=t.location,i.lat){e.next=22;break}if(!t.$jweixin.isWechat()){e.next=21;break}return t.$util.showLoading(),e.next=6,t.$jweixin.wxReady2();case 6:return e.next=8,t.$jweixin.getWxLocation();case 8:if(n=e.sent,a=n.latitude,s=void 0===a?0:a,c=n.longitude,r=void 0===c?0:c,i={lng:r,lat:s,address:"定位失败",province:"",city:"",district:""},!s||!r){e.next=21;break}return l="".concat(s,",").concat(r),e.next=18,t.$api.base.getMapInfo({location:l});case 18:u=e.sent,d=JSON.parse(u),p=d.status,f=d.result,0==p&&(v=f.address,m=f.address_component,g=m.province,h=m.city,w=m.district,i={lng:r,lat:s,address:v,province:g,city:h,district:w});case 21:t.updateUserItem({key:"location",val:i});case 22:return x=t.options.id,_=t.list,C=t.param,y=i,b=y.lng,k=void 0===b?0:b,$=y.lat,L=void 0===$?0:$,C=Object.assign({},C,{ser_id:x,lng:k,lat:L}),e.next=28,t.$api.service.serviceCoachList(C);case 28:I=e.sent,1==t.param.page||(I.data=_.data.concat(I.data)),t.list=I,t.loading=!1,t.$util.hideAll();case 32:case"end":return e.stop()}}),e)})))()},handerTabChange:function(t){this.activeIndex=t,this.showInd=-1,this.$util.showLoading(),this.param.page=1,this.getList()},toPreviewImage:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0,i=this.list.data[t],n=i.self_img,a=i.work_img;e&&(n=[a]),this.$util.previewImage({current:n[0],urls:n})},toShowPopup:function(t,e){var i=this;return(0,c.default)((0,o.default)().mark((function n(){return(0,o.default)().wrap((function(n){while(1)switch(n.prev=n.next){case 0:return i.showInd=t,i.showType=e,n.next=4,i.getCommentList();case 4:i.$refs.technician_item.open();case 5:case"end":return n.stop()}}),n)})))()},getCommentList:function(){var t=this;return(0,c.default)((0,o.default)().mark((function e(){var i,n;return(0,o.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:return i=t.list.data[t.showInd].id,n={coach_id:i,page:1},e.next=4,t.$api.service.commentList(n);case 4:t.commentList=e.sent;case 5:case"end":return e.stop()}}),e)})))()},toCollect:function(t){var e=this;return(0,c.default)((0,o.default)().mark((function i(){var n,a,s,c,r;return(0,o.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:return n=e.list.data[t],a=n.id,s=n.is_collect,c=n.collect_num,r=s?"delCollect":"addCollect",i.next=4,e.$api.mine[r]({coach_id:a});case 4:e.$util.showToast({title:s?"取消成功":"收藏成功"}),e.list.data[t].is_collect=1==s?0:1,e.list.data[t].collect_num=1==s?c-1:c+1;case 7:case"end":return i.stop()}}),i)})))()},goInfo:function(t){var e=this.list.data[t].id;this.$util.goUrl({url:"/user/pages/technician-info?id=".concat(e)})},toOrder:function(t,e){var i=this;return(0,c.default)((0,o.default)().mark((function n(){var a,s,c,r,l,u;return(0,o.default)().wrap((function(n){while(1)switch(n.prev=n.next){case 0:if(0!=e){n.next=2;break}return n.abrupt("return");case 2:if(a=i.list.data[t],s=a.id,c=a.user_id,r=void 0===c?0:c,r){n.next=5;break}return n.abrupt("return");case 5:if(l=i.options.id,!i.lockTap){n.next=8;break}return n.abrupt("return");case 8:return i.lockTap=!0,n.prev=9,n.next=12,i.$api.order.addCar({service_id:l,coach_id:s,num:1,is_top:1});case 12:i.lockTap=!1,u="/user/pages/order?id=".concat(s,"&ser_id=").concat(l),i.$util.goUrl({url:u}),n.next=20;break;case 17:n.prev=17,n.t0=n["catch"](9),i.lockTap=!1;case 20:case"end":return n.stop()}}),n,null,[[9,17]])})))()},toBack:function(){var t=this.pageLen,e=t>1?1:"/pages/service",i=t>1?"navigateBack":"reLaunch";this.$util.goUrl({url:e,openType:i})}})};e.default=l},"459a":function(t,e,i){var n=i("8e3b");n.__esModule&&(n=n.default),"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("0325ec2f",n,!0,{sourceMap:!1,shadowMode:!1})},"8e3b":function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */',""]),t.exports=e},"9b17":function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return a})),i.d(e,"a",(function(){}));var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"pages-technician"},[i("uni-nav-bar",{attrs:{fixed:!1,shadow:!1,statusBar:!0,onlyLeft:!0,color:"#fff",backgroundColor:t.primaryColor}},[i("v-uni-view",{staticClass:"map-info flex-y-center",attrs:{slot:"left"},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toChooseLocation.apply(void 0,arguments)}},slot:"left"},[i("v-uni-view",{staticClass:"flex-y-center pl-md c-base"},[i("i",{staticClass:"iconfont iconjuli mr-sm"}),i("v-uni-view",{staticClass:"map-text max-400 ellipsis"},[t._v(t._s(t.location.address?t.location.address:t.isLoad?"定位失败":"定位中..."))]),i("i",{staticClass:"iconfont icon-down"})],1)],1)],1),i("search",{attrs:{type:"input",placeholder:"请输入技师姓名"},on:{input:function(e){arguments[0]=e=t.$handleEvent(e),t.toSearch.apply(void 0,arguments)}}}),i("v-uni-view",{staticClass:"space-md"}),t._l(t.list.data,(function(e,n){return i("v-uni-view",{key:n,staticClass:"list-item flex-center pd-lg mt-md ml-md mr-md fill-base radius-16 rel"},[1==e.coach_type_status?i("v-uni-image",{staticClass:"king-img abs",attrs:{src:"https://lbqny.migugu.com/admin/anmo/mine/king.gif"}}):t._e(),i("v-uni-view",{staticClass:"flex-center flex-column"},[i("v-uni-view",{staticClass:"item-img rel"},[i("v-uni-view",{staticClass:"item-img radius"},[i("v-uni-view",{staticClass:"h5-image item-img radius",style:{backgroundImage:"url('"+e.work_img+"')"},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toPreviewImage(n,1)}}})],1),e.coach_type_status?i("v-uni-view",{staticClass:"h5-image abs",class:[t.imgType[e.coach_type_status]+"-img"],style:{backgroundImage:3===e.coach_type_status?"url('https://lbqny.migugu.com/admin/anmo/mine/"+t.imgType[e.coach_type_status]+".png')":"url('https://lbqny.migugu.com/admin/anmo/mine/"+t.imgType[e.coach_type_status]+".gif')"},on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),1==e.coach_type_status&&t.toPreviewImage(n,1)}}}):t._e()],1),i("v-uni-view",{staticClass:"item-tag flex-center f-icontext c-base radius-20",style:{background:1===e.text_type?t.configInfo.service_btn_color:3==e.text_type?t.primaryColor:"",color:1===e.text_type?t.configInfo.service_font_color:3===e.text_type?"#fff":""}},[t._v(t._s(t.textType[e.text_type]))])],1),i("v-uni-view",{staticClass:"flex-1 ml-md max-510"},[i("v-uni-view",{staticClass:"flex-between"},[i("v-uni-view",{staticClass:"flex-y-center f-title c-title"},[i("v-uni-view",{staticClass:"text-bold max-200 ellipsis"},[t._v(t._s(e.coach_name))]),i("v-uni-view",{staticClass:"more-img flex-center ml-sm f-icontext",style:{color:t.primaryColor,border:"1rpx solid "+t.primaryColor},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toPreviewImage(n)}}},[t._v("更多照片")])],1),e.near_time?i("v-uni-view",{staticClass:"flex-y-center f-icontext c-caption"},[t._v("最早可约"),i("v-uni-view",{staticClass:"can-service-btn flex-center rel"},[i("v-uni-view",{staticClass:"bg abs",style:{background:t.primaryColor}}),i("v-uni-view",{staticClass:"text flex-center abs",style:{color:t.primaryColor}},[t._v(t._s(e.near_time))])],1)],1):t._e()],1),i("v-uni-view",{staticClass:"flex-between mt-sm mb-md pb-md b-1px-b"},[i("v-uni-view",{staticClass:"flex-y-center f-icontext"},[i("v-uni-view",{staticClass:"flex-y-center"},[i("i",{staticClass:"iconfont iconyduixingxingshixin icon-font-color"}),i("v-uni-view",{staticClass:"star-text"},[t._v(t._s(e.star))])],1),i("v-uni-view",{staticClass:"order-num"},[t._v("已服务 "+t._s(e.order_num>9999?"9999+":e.order_num)+"单")])],1),i("v-uni-view",{staticClass:"flex-center"},[i("i",{staticClass:"iconfont iconjuli",style:{color:t.primaryColor}}),i("v-uni-view",{staticClass:"f-desc c-title"},[t._v(t._s(e.distance))])],1)],1),i("v-uni-view",{staticClass:"flex-between"},[i("v-uni-view",{staticClass:"flex-y-center f-desc c-caption"},[i("v-uni-view",{staticClass:"flex-y-center",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toShowPopup(n,"message")}}},[i("i",{staticClass:"iconfont iconpinglun mr-sm"}),t._v(t._s(e.comment_num))]),i("v-uni-view",{staticClass:"flex-y-center ml-md",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.toCollect(n)}}},[i("i",{staticClass:"iconfont mr-sm",class:[{iconshoucang1:!e.is_collect},{iconshoucang2:e.is_collect}],style:{color:e.is_collect?t.primaryColor:""}}),t._v(t._s(e.collect_num))]),i("v-uni-view",{staticClass:"flex-y-center ml-md",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.goInfo(n)}}},[i("i",{staticClass:"iconfont iconxiangqing mr-sm"}),i("v-uni-view",{staticClass:"f-icontext"},[t._v("详情")])],1)],1),i("v-uni-view",{staticClass:"item-btn flex-center f-desc c-base",style:{background:e.user_id?0==e.is_work?"#ccc":t.primaryColor:"#888"},on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.toOrder(n,e.is_work)}}},[t._v("立即预约")])],1)],1)],1)})),t.loading?i("load-more",{attrs:{noMore:t.list.current_page>=t.list.last_page&&t.list.data.length>0,loading:t.loading}}):t._e(),!t.loading&&t.list.data.length<=0&&1==t.list.current_page?i("abnor"):t._e(),i("v-uni-view",{staticClass:"space-footer"}),i("uni-popup",{ref:"technician_item",attrs:{type:"bottom"}},[-1!=t.showInd?i("v-uni-view",{staticClass:"technician-popup fill-base"},[i("v-uni-view",{staticClass:"pd-lg",class:[{"flex-center":"technician"==t.showType},{"flex-warp":"message"==t.showType}]},[i("v-uni-image",{staticClass:"item-avatar radius",attrs:{src:t.list.data[t.showInd].work_img}}),i("v-uni-view",{staticClass:"flex-1 ml-md",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.$refs.technician_item.close()}}},[i("v-uni-view",{staticClass:"flex-between"},[i("v-uni-view",{staticClass:"flex-y-baseline f-caption c-caption"},[i("v-uni-view",{staticClass:"f-title c-title text-bold mr-sm max-350 ellipsis"},[t._v(t._s(t.list.data[t.showInd].coach_name))]),t._v("从业"+t._s(t.list.data[t.showInd].work_time)+"年")],1),i("i",{staticClass:"iconfont icon-close"})],1),"message"==t.showType?i("v-uni-scroll-view",{staticClass:"technician-text f-caption c-caption mt-sm",attrs:{"scroll-y":!0},on:{touchmove:function(e){e.stopPropagation(),e.preventDefault(),arguments[0]=e=t.$handleEvent(e)}}},[t._v(t._s(t.list.data[t.showInd].text))]):t._e()],1)],1),i("v-uni-view",{staticClass:"space-sm fill-body"}),i("v-uni-scroll-view",{staticClass:"list-content",attrs:{"scroll-y":!0},on:{touchmove:function(e){e.stopPropagation(),e.preventDefault(),arguments[0]=e=t.$handleEvent(e)}}},["message"==t.showType?t._l(t.commentList.data,(function(e,n){return i("v-uni-view",{key:n,staticClass:" list-message flex-warp pd-lg",class:[{"b-1px-t":0!=n}]},[i("v-uni-image",{staticClass:"item-avatar radius",attrs:{src:e.avatarUrl}}),i("v-uni-view",{staticClass:"flex-1 ml-md"},[i("v-uni-view",{staticClass:"flex-between"},[i("v-uni-view",{staticClass:"flex-y-center"},[i("v-uni-view",{staticClass:"f-paragraph c-title mr-md"},[t._v(t._s(e.nickName))]),i("v-uni-view",{staticClass:"flex-warp"},t._l(5,(function(t,n){return i("i",{key:n,staticClass:"iconfont iconyduixingxingshixin icon-font-color",style:{backgroundImage:n<e.star?"-webkit-linear-gradient(270deg, #FAD961 0%, #F76B1C 100%)":"-webkit-linear-gradient(270deg, #f4f6f8 0%, #ccc 100%)"}})})),0)],1),i("v-uni-view",{staticClass:"f-icontext c-caption"},[t._v(t._s(e.create_time))])],1),i("v-uni-view",{staticClass:"flex-warp mt-sm"},t._l(e.lable_text,(function(e,n){return i("v-uni-view",{key:n,staticClass:"pt-sm pb-sm pl-md pr-md mt-sm mr-sm radius fill-body f-caption c-desc"},[t._v(t._s(e))])})),1),i("v-uni-view",{staticClass:"f-caption c-caption mt-md"},[i("v-uni-text",{staticStyle:{"word-break":"break-all"},attrs:{decode:"emsp"}},[t._v(t._s(e.text))])],1)],1)],1)})):t._e()],2),!t.loading&&"message"==t.showType&&t.commentList.data.length<=0?i("v-uni-view",{staticStyle:{margin:"0 100rpx"}},[i("abnor")],1):t._e(),"message"==t.showType&&t.commentList.last_page>1?[i("v-uni-view",{staticClass:"space-lg b-1px-t"}),i("v-uni-view",{staticClass:"more-btn flex-center f-paragraph c-base radius",staticStyle:{width:"300rpx",height:"80rpx",margin:"0 auto"},style:{background:t.primaryColor},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.$refs.technician_item.close(),t.$util.goUrl({url:"/user/pages/comment?index="+t.showInd})}}},[t._v("查看更多")]),i("v-uni-view",{staticClass:"space-lg"})]:t._e(),t.commentList.data.length>0&&1==t.commentList.last_page?i("v-uni-view",{staticClass:"space-safe"}):t._e()],2):t._e()],1),i("v-uni-view",{staticClass:"space-max-footer"}),i("fix-bottom-button",{attrs:{text:[{type:"confirm",text:t.pageLen>1?"返回上页":"返回首页"}],bgColor:"#fff"},on:{confirm:function(e){arguments[0]=e=t.$handleEvent(e),t.toBack.apply(void 0,arguments)}}})],2)},a=[]},c9e5:function(t,e,i){"use strict";i.r(e);var n=i("9b17"),a=i("cedf");for(var s in a)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return a[t]}))}(s);i("f98b");var o=i("f0c5"),c=Object(o["a"])(a["default"],n["b"],n["c"],!1,null,"11eb0956",null,!1,n["a"],void 0);e["default"]=c.exports},cedf:function(t,e,i){"use strict";i.r(e);var n=i("0734"),a=i.n(n);for(var s in n)["default"].indexOf(s)<0&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=a.a},f98b:function(t,e,i){"use strict";var n=i("459a"),a=i.n(n);a.a}}]);