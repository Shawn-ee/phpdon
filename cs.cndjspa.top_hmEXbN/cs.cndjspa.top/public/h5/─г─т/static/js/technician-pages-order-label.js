(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["technician-pages-order-label"],{"0986":function(t,e,i){"use strict";i.r(e);var n=i("0a76"),a=i.n(n);for(var l in n)["default"].indexOf(l)<0&&function(t){i.d(e,t,(function(){return n[t]}))}(l);e["default"]=a.a},"0a76":function(t,e,i){"use strict";i("7a82");var n=i("4ea4").default;Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("d81d"),i("4de4"),i("d3b7"),i("c740"),i("a434");var a=n(i("5530")),l=n(i("c7eb")),c=n(i("1da1")),s=i("26cb"),r={data:function(){return{options:{},base_label:[],check_label:[]}},computed:(0,s.mapState)({primaryColor:function(t){return t.config.configInfo.primaryColor},subColor:function(t){return t.config.configInfo.subColor}}),onLoad:function(t){var e=this;return(0,c.default)((0,l.default)().mark((function i(){return(0,l.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:e.options=t,e.$util.setNavigationBarColor({bg:e.primaryColor}),e.initIndex();case 3:case"end":return i.stop()}}),i)})))()},methods:(0,a.default)((0,a.default)({},(0,s.mapActions)([])),{},{initIndex:function(){var t=this;return(0,c.default)((0,l.default)().mark((function e(){var i;return(0,l.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$api.technician.labelList();case 2:i=e.sent,i.map((function(t){t.selected=0})),t.base_label=i;case 5:case"end":return e.stop()}}),e)})))()},toAddDel:function(t,e){var i=this.$util.deepCopy(this.base_label);if(1!=t){var n=this.$util.deepCopy(this.check_label),a=n[e].id,l=i.findIndex((function(t){return t.id==a}));i[l].is_select=0,this.base_label=i,n.splice(e,1),this.check_label=n}else{var c=i[e].is_select;if(1==c)return;i[e].is_select=1,this.base_label=i;var s=i.filter((function(t){return 1==t.is_select}));this.check_label=s}},submitForm:function(){var t=this;return(0,c.default)((0,l.default)().mark((function e(){var i,n,a,c,s;return(0,l.default)().wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(i=t.check_label.map((function(t){return t.id})),0!=i.length){e.next=4;break}return t.$util.showToast({title:"请选中标签"}),e.abrupt("return");case 4:return n=t.options,a=n.id,c=n.uid,s={order_id:a,user_id:c,label:i},t.$util.showLoading(),e.next=9,t.$api.technician.userLabelAdd(s);case 9:t.$util.hideAll(),t.$util.showToast({title:"评价成功"}),t.$util.back(),setTimeout((function(){t.$util.goUrl({url:1,openType:"navigateBack"})}),1e3);case 13:case"end":return e.stop()}}),e)})))()}})};e.default=r},"26ee":function(t,e,i){"use strict";i.r(e);var n=i("3dbb"),a=i("0986");for(var l in a)["default"].indexOf(l)<0&&function(t){i.d(e,t,(function(){return a[t]}))}(l);i("91cf");var c=i("f0c5"),s=Object(c["a"])(a["default"],n["b"],n["c"],!1,null,"59cb2586",null,!1,n["a"],void 0);e["default"]=s.exports},"3dbb":function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return a})),i.d(e,"a",(function(){}));var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"pages-technician-label"},[i("v-uni-view",{staticClass:"flex-y-center pd-lg"},[i("v-uni-view",{staticClass:"f-title c-title text-bold"},[t._v("推荐标签")]),i("v-uni-view",{staticClass:"f-caption c-caption ml-md"},[t._v("点击添加标签")])],1),i("v-uni-view",{staticClass:"list-item ml-lg mr-lg f-caption"},[0==t.base_label.length?i("v-uni-view",[t._v("暂无标签")]):t._e(),t._l(t.base_label,(function(e,n){return i("v-uni-view",{key:n,staticClass:"list-child radius",style:{color:1===e.is_select?"#CBCBCB":"#666"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.toAddDel(1,n)}}},[i("v-uni-view",{staticClass:"tag-item flex-center"},[i("i",{staticClass:"iconfont icon-add"}),i("v-uni-view",[t._v(t._s(e.title))])],1)],1)}))],2),i("v-uni-view",{staticClass:"flex-y-center pd-lg mt-lg"},[i("v-uni-view",{staticClass:"f-title c-title text-bold"},[t._v("已选标签")])],1),i("v-uni-view",{staticClass:"list-item ml-lg mr-lg f-caption"},[0==t.check_label.length?i("v-uni-view",[t._v("暂无选中标签")]):t._e(),t._l(t.check_label,(function(e,n){return i("v-uni-view",{key:n,staticClass:"list-child cur radius rel",staticStyle:{border:"none"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.toAddDel(2,n)}}},[i("v-uni-view",{staticClass:"bg-item radius abs",style:{background:t.primaryColor,borderColor:t.primaryColor}}),i("i",{staticClass:"iconfont icon-guanbi-fill abs"}),i("v-uni-view",{staticClass:"tag-item flex-center",style:{color:t.primaryColor}},[t._v(t._s(e.title))])],1)}))],2),i("v-uni-view",{staticClass:"space-max-footer"}),i("fix-bottom-button",{attrs:{text:[{text:"确定",type:"confirm"}],bgColor:"#fff"},on:{confirm:function(e){arguments[0]=e=t.$handleEvent(e),t.submitForm.apply(void 0,arguments)}}})],1)},a=[]},"91cf":function(t,e,i){"use strict";var n=i("f751"),a=i.n(n);a.a},f726:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */uni-page-body[data-v-59cb2586]{background:#fff}body.?%PAGE?%[data-v-59cb2586]{background:#fff}.pages-technician-label .list-item .list-child[data-v-59cb2586]{width:auto;min-width:%?120?%;height:%?70?%;display:inline-block;padding:0 %?20?%;margin:0 %?18?% %?23?% 0;border:%?1?% solid #e5e5e5}.pages-technician-label .list-item .list-child .tag-item[data-v-59cb2586]{height:%?70?%}.pages-technician-label .list-item .list-child .tag-item .icon-add[data-v-59cb2586]{font-size:%?24?%;margin-right:%?5?%}.pages-technician-label .list-item .list-child .bg-item[data-v-59cb2586]{top:0;left:0;width:100%;height:100%;opacity:.15}.pages-technician-label .list-item .list-child .icon-guanbi-fill[data-v-59cb2586]{top:%?-10?%;right:%?2?%;color:#b5bcc8;font-size:%?28?%}.pages-technician-label .list-item .cur[data-v-59cb2586]{margin:0 %?20?% %?28?% 0}',""]),t.exports=e},f751:function(t,e,i){var n=i("f726");n.__esModule&&(n=n.default),"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("2e6c491e",n,!0,{sourceMap:!1,shadowMode:!1})}}]);