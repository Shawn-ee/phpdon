(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["technician-pages-time-manage"],{"19e6":function(t,i,e){"use strict";e.r(i);var a=e("1d74"),n=e("ff17");for(var s in n)["default"].indexOf(s)<0&&function(t){e.d(i,t,(function(){return n[t]}))}(s);e("dbfc");var o=e("f0c5"),r=Object(o["a"])(n["default"],a["b"],a["c"],!1,null,"64ba90f4",null,!1,a["a"],void 0);i["default"]=r.exports},"1d74":function(t,i,e){"use strict";e.d(i,"b",(function(){return n})),e.d(i,"c",(function(){return s})),e.d(i,"a",(function(){return a}));var a={wPicker:e("9fee").default},n=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-uni-view",{staticClass:"technician-time-manage"},[e("v-uni-view",{staticClass:"fill-base pd-lg flex-between"},[e("v-uni-view",{staticClass:"flex-1 flex-y-baseline f-title c-title"},[t._v("是否接单"),e("v-uni-view",{staticClass:"f-paragraph ml-sm",style:{color:1==t.form.is_work?t.primaryColor:"#999"}},[t._v(t._s(1==t.form.is_work?"接单":"休息"))])],1),e("v-uni-view",{on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.toChangeItem.apply(void 0,arguments)}}},[e("i",{staticClass:"iconfont icon-switch c-caption ml-sm",class:[{"icon-switch-on":1==t.form.is_work}],style:{color:1==t.form.is_work?t.primaryColor:""}})])],1),e("v-uni-view",{staticClass:"fill-base mt-md b-1px-b"},[e("v-uni-view",{staticClass:"f-title c-title pd-lg"},[t._v("选择接单时间")])],1),e("v-uni-view",{staticClass:"flex-center fill-base f-paragraph c-desc pt-lg pb-lg b-1px-b"},[e("v-uni-view",{staticClass:"item-time flex-center flex-column",on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.toShowTime("start_time")}}},[e("v-uni-view",[t._v("开始时间")]),e("v-uni-view",{staticClass:"mt-sm",style:{color:t.form.start_time?t.primaryColor:"#999"}},[t._v(t._s(t.form.start_time||"选择时间"))])],1),e("v-uni-view",{staticClass:"item-time flex-center flex-column  b-1px-l",on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.toShowTime("end_time")}}},[e("v-uni-view",[t._v("结束时间")]),e("v-uni-view",{staticClass:"mt-sm",style:{color:t.form.end_time?t.primaryColor:"#999"}},[t._v(t._s(t.is_next_day?"次日":"")+t._s(t.form.end_time||"选择时间"))])],1)],1),e("v-uni-view",{staticClass:"fill-base pb-lg",staticStyle:{"border-bottom-left-radius":"32rpx","border-bottom-right-radius":"32rpx"}},[e("v-uni-view",{staticClass:"flex pl-md pr-md pt-lg pb-lg"},[e("v-uni-view",{staticClass:"f-min-title"},[t._v("设置不可接单时间")]),e("v-uni-view",{staticClass:"f-paragraph c-disable"},[t._v("（只能设置近"+t._s(t.dayList.length)+"天的时间）")])],1),e("tab",{attrs:{list:t.dayList,activeIndex:1*t.dayCurrent,activeColor:t.primaryColor,width:"150rpx",height:"80rpx"},on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.handerTabChange.apply(void 0,arguments)}}})],1),t.dayList.length>0?e("v-uni-view",{staticClass:"date-list flex pt-md"},t._l(t.dayList[t.dayCurrent].sub,(function(i,a){return e("v-uni-view",{key:a,staticClass:"date-item radius-16 flex-center ml-md mt-md",class:t.isTimes(i.time_str)||1==i.is_order||3==t.form.coach_status?"date-item-prohibit c-disable":"fill-base c-5A677E",style:{background:3==t.form.coach_status||0!=i.status||0!=i.is_order||t.isTimes(i.time_str)?"":t.primaryColor,color:0!=i.status||0!=i.is_order||t.isTimes(i.time_str)?"":"#fff"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.getDateTime(a)}}},[e("v-uni-view",{staticClass:"text-center"},[e("v-uni-view",{staticClass:"f-min-title"},[t._v(t._s(i.time_text))]),e("v-uni-view",{staticClass:"f-caption"},[t._v(t._s(t.isTimes(i.time_str)||0==i.status?"不可预约":"可预约"))])],1)],1)})),1):t._e(),e("v-uni-view",{staticClass:"space-max-footer"}),e("w-picker",{ref:"time",attrs:{visible:t.showTime,mode:"time",value:t.toDayTime,current:!1,second:!1,themeColor:t.primaryColor},on:{"update:visible":function(i){arguments[0]=i=t.$handleEvent(i),t.showTime=i},confirm:function(i){arguments[0]=i=t.$handleEvent(i),t.onConfirm.apply(void 0,arguments)}}}),3!=t.form.coach_status?e("fix-bottom-button",{attrs:{text:[{text:"保存",type:"confirm",isAuth:!0}],bgColor:"#fff"},on:{confirm:function(i){arguments[0]=i=t.$handleEvent(i),t.submit.apply(void 0,arguments)}}}):t._e()],1)},s=[]},"9ff5":function(t,i,e){var a=e("24fb");i=a(!1),i.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.technician-time-manage .iconfont[data-v-64ba90f4]{font-size:%?80?%;line-height:%?34?%}.technician-time-manage .item-time[data-v-64ba90f4]{width:50%}.technician-time-manage .date-title[data-v-64ba90f4]{padding-bottom:%?60?%}.technician-time-manage .date-title uni-text[data-v-64ba90f4]{border-bottom:3px solid transparent}.technician-time-manage .date-list[data-v-64ba90f4]{word-break:break-all;flex-flow:wrap}.technician-time-manage .date-list .date-item[data-v-64ba90f4]{width:%?163?%;height:%?110?%;border:1px solid #e5e5e5}.technician-time-manage .date-list .date-item-prohibit[data-v-64ba90f4]{background:#f6f7f7}.technician-time-manage .date-list .c-5A677E[data-v-64ba90f4]{color:#5a677e}',""]),t.exports=i},d41e:function(t,i,e){var a=e("9ff5");a.__esModule&&(a=a.default),"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=e("4f06").default;n("3369fc23",a,!0,{sourceMap:!1,shadowMode:!1})},dbfc:function(t,i,e){"use strict";var a=e("d41e"),n=e.n(a);n.a},fda8:function(t,i,e){"use strict";e("7a82");var a=e("4ea4").default;Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0,e("d3b7"),e("159b"),e("99af");var n=a(e("c7eb")),s=a(e("1da1")),o=a(e("5530")),r=e("26cb"),c=a(e("9fee")),u=a(e("d7a3")),l={components:{wPicker:c.default,tab:u.default},data:function(){return{toDay:"",toDayTime:"",showKey:"",showTime:!1,form:{id:0,is_work:0,start_time:"",end_time:"",coach_status:0,time_unit:""},is_next_day:!1,dayList:[],dayCurrent:0}},computed:(0,r.mapState)({primaryColor:function(t){return t.config.configInfo.primaryColor},subColor:function(t){return t.config.configInfo.subColor},userInfo:function(t){return t.user.userInfo}}),onLoad:function(){this.initIndex()},methods:(0,o.default)((0,o.default)({},(0,r.mapMutations)(["updateTechnicianItem"])),{},{initIndex:function(){var t=this;return(0,s.default)((0,n.default)().mark((function i(){var e,a,s;return(0,n.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(!t.$jweixin.isWechat()){i.next=4;break}return i.next=3,t.$jweixin.initJssdk();case 3:t.$jweixin.wxReady((function(){t.$jweixin.hideOptionMenu()}));case 4:return e=new Date(Math.ceil((new Date).getTime())),t.toDay=t.$util.formatTime(e,"YY-M-D"),t.toDayTime=t.$util.formatTime(e,"h:m"),i.next=9,t.$api.technician.timeConfig();case 9:for(s in a=i.sent,t.form)t.form[s]=a[s];a.day_list.forEach((function(t,i){t.title=0==i?"今天":t.dat_text,t.sub=[]})),t.form.time_unit=a.time_unit,t.dayList=a.day_list,t.$util.setNavigationBarColor({bg:t.primaryColor}),t.toCount();case 16:case"end":return i.stop()}}),i)})))()},toChangeItem:function(){3!=this.form.coach_status&&(this.form.is_work=1==this.form.is_work?0:1)},toShowTime:function(t){3!=this.form.coach_status&&(this.showKey=t,this.showTime=!0)},onConfirm:function(t){this.form[this.showKey]=t.result,this.toCount()},toCount:function(){var t=this.toDay,i=void 0===t?"":t,e=this.form,a=e.start_time,n=void 0===a?"":a,s=e.end_time,o=void 0===s?"":s;if(i&&n&&o){var r="".concat(i," ").concat(n),c="".concat(i," ").concat(o);this.is_next_day=this.$util.DateToUnix(r)>=this.$util.DateToUnix(c),this.dayList.forEach((function(t){t.sub=[]})),this.getTimeCall()}},getTimeCall:function(){var t=this;return(0,s.default)((0,n.default)().mark((function i(){var e,a,s,o,r,c,u,l;return(0,n.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:return t.$util.showLoading(),e=t.form,a=e.start_time,s=void 0===a?"":a,o=e.end_time,r=void 0===o?"":o,c=t.dayCurrent,u=t.dayList,i.next=5,t.$api.technician.getTime({start_time:s,end_time:r,dat_str:u[c].dat_str});case 5:l=i.sent,t.dayList[c].sub=l,t.$util.hideAll();case 8:case"end":return i.stop()}}),i)})))()},submit:function(){var t=this;return(0,s.default)((0,n.default)().mark((function i(){var e;return(0,n.default)().wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(e=t.$util.deepCopy(t.form),e.start_time&&e.end_time){i.next=4;break}return t.$util.showToast({title:e.start_time?"请选择结束时间":"请选择开始时间"}),i.abrupt("return");case 4:return delete e.coach_status,e.time_text=t.dayList,t.$util.showLoading(),i.next=9,t.$api.technician.setTimeConfig(e);case 9:t.$util.hideAll(),t.$util.showToast({title:"保存成功"}),t.updateTechnicianItem({key:"haveOperItem",val:!0}),setTimeout((function(){t.$util.back(),t.$util.goUrl({url:1,openType:"navigateBack"})}),1e3);case 13:case"end":return i.stop()}}),i)})))()},setDate:function(t){this.dayCurrent=t},getDateTime:function(t){if(3!=this.form.coach_status){var i=this.dayCurrent;this.dayList[i].sub&&1==this.dayList[i].sub[t].is_order||(this.dayList[i].sub[t].is_click=0==this.dayList[i].sub[t].is_click?1:0,this.dayList[i].sub[t].status=0==this.dayList[i].sub[t].status?1:0)}},handerTabChange:function(t){3!=this.form.coach_status&&(this.dayCurrent=t,this.dayList[t].sub&&this.dayList[t].sub.length||this.getTimeCall())},isTimes:function(t){var i=new Date;return i.getTime()/1e3>t}})};i.default=l},ff17:function(t,i,e){"use strict";e.r(i);var a=e("fda8"),n=e.n(a);for(var s in a)["default"].indexOf(s)<0&&function(t){e.d(i,t,(function(){return a[t]}))}(s);i["default"]=n.a}}]);