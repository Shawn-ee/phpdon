webpackJsonp([17],{mpqJ:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=r("aFK5"),o=r.n(a),n=r("mvHQ"),i=r.n(n),l=r("Xxa5"),s=r.n(l),c=r("exGp"),p=r.n(c),d=r("PJh5"),u=r.n(d),m={data:function(){var e=this;return{pickerOptions:{disabledDate:function(e){return e.getTime()>1e3*(u()(u()(Date.now()).format("YYYY-MM-DD")).unix()+86400-1)}},statusOptions:[{label:"全部订单",value:0},{label:"已取消",value:-1},{label:"待支付",value:1},{label:"待服务",value:2},{label:"技师接单",value:3},{label:"技师出发",value:4},{label:"技师到达",value:5},{label:"服务中",value:6},{label:"已完成",value:7}],coachTypeList:[{id:0,title:"全部技师"},{id:1,title:"入驻技师"},{id:2,title:"非入驻技师"}],transfreTypeList:[{id:1,title:"距离最近"},{id:2,title:"最早可预约"}],carType:{0:"公交/地铁",1:"出租车"},payType:{1:"微信支付",2:"余额支付",3:"支付宝支付"},statusType:{"-1":"已取消",1:"待支付",2:"待服务",3:"技师接单",4:"技师出发",5:"技师到达",6:"服务中",7:"已完成",8:"待转单"},technicianStatusType:{2:"技师接单",3:"技师出发",4:"技师到达",5:"开始服务",6:"完成服务"},cityType:{3:{type:"success",text:"省"},1:{type:"primary",text:"城市"},2:{type:"danger",text:"区县"}},loading:{list:!1,transfer:!1},searchForm:{list:{page:1,limit:10,goods_name:"",coach_name:"",order_code:"",mobile:"",start_time:"",end_time:"",pay_type:0,is_coach:0,is_add:0},transfer:{page:1,limit:10,order_id:"",type:1}},tableData:{list:[],transfer:[]},total:{list:0,transfer:0},order_price:0,car_price:0,print:!1,printTableData:[],downloadLoading:!1,showDialog:{oper:!1,transfer:!1},showMap:!1,operForm:{order_id:"",type:"",lat:"",lng:"",address:"",img:[]},operFormRules:{lat:{required:!0,validator:function(t,r,a){var o=e.operForm.type;![3,4,6].includes(o)||r&&/^[\-\+]?((0|([1-8]\d?))(\.\d{1,15})?|90(\.0{1,15})?)$/.test(r)?a():a(new Error(r?"请输入正确的纬度":"请输入纬度"))},trigger:["change","blur"]},lng:{required:!0,validator:function(t,r,a){var o=e.operForm.type;![3,4,6].includes(o)||r&&/^[\-\+]?(0(\.\d{1,15})?|([1-9](\d)?)(\.\d{1,15})?|1[0-7]\d{1}(\.\d{1,15})?|180\.0{1,15})$/.test(r)?a():a(new Error(r?"请输入正确的经度":"请输入经度"))},trigger:["change","blur"]},address:{required:!0,validator:function(t,r,a){var o=e.operForm.type;[3,4,6].includes(o)&&!r?a(new Error("请输入"+e.technicianStatusType[o]+"地址 ")):a()},trigger:["change","blur"]},img:{required:!0,validator:function(t,r,a){var o=e.operForm.type;[4,6].includes(o)&&!r?a(new Error("请选择"+e.technicianStatusType[o]+"图片 ")):a()},trigger:["change","blur"]}},transferForm:{order_id:"",coach_type:1,coach_id:"",coach_name:"",mobile:"",text:""},transferSubFormRules:{coach_name:{required:!0,validator:this.$reg.isNotNull,text:"技师姓名",reg_type:2,trigger:"blur"},mobile:{required:!0,validator:this.$reg.isTel,text:"联系电话",reg_type:2,trigger:"blur"},text:{required:!0,validator:this.$reg.isNotNull,text:"其他备注",reg_type:2,trigger:"blur"}},lockTap:!1}},created:function(){var e=this;return p()(s.a.mark(function t(){return s.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:e.getTableDataList(1,"list");case 1:case"end":return t.stop()}},t,e)}))()},methods:{resetForm:function(e){var t=e+"Form";this.$refs[t].resetFields(),this.getTableDataList(1,e)},handleSizeChange:function(e,t){this.searchForm[t].limit=e,this.handleCurrentChange(1,t)},handleCurrentChange:function(e,t){this.searchForm[t].page=e,this.getTableDataList("",t)},getTableDataList:function(e,t){var r=this;e&&(this.searchForm[t].page=1),this.loading[t]=!0;var a=JSON.parse(i()(this.searchForm[t]));if("list"===t){var o=a.start_time;o&&o.length>0?(a.start_time=o[0]/1e3,a.end_time=o[1]/1e3):(a.start_time="",a.end_time="")}var n={list:"orderList",transfer:"orderChangeCoachList"}[t];this.$api.shop[n](a).then(function(e){if(r.loading[t]=!1,200===e.code){var a=e.data,o=a.data,n=a.total,i=a.order_price,l=a.car_price;if(r.tableData[t]=o,r.total[t]=n,"list"===t){o.map(function(e){e.refund_price=1*e.refund_price>0?e.refund_price:""}),r.order_price=i,r.car_price=l;var s=o.map(function(e){e.goods_text="",e.add_order_text="",e.order_goods.map(function(t,r){e.goods_text+=(0===r?"":"；")+t.goods_name+" 时长："+t.time_long+"分钟 单价：¥"+t.price+" 数量：x"+t.num+" "}),e.add_order_id&&e.add_order_id.length>0&&e.add_order_id.map(function(t,r){e.add_order_text+=(0===r?"":"；")+t.order_code+" "});var t=1===e.car_type?"全程"+e.distance+"，车费"+e.car_price+" ":"";return e.car_text=""+r.carType[e.car_type]+t+" ",[e.id,e.goods_text,e.user_name,e.mobile,e.coach_info.coach_name,e.coach_id?"入驻技师":"非入驻技师",u()(1e3*e.start_time).format("YYYY-MM-DD HH:mm:ss"),e.car_text,e.init_service_price,"¥"+e.pay_price+" ",e.refund_price?"¥"+e.refund_price+" ":"",e.add_order_text,e.order_code,e.transaction_id,u()(1e3*e.create_time).format("YYYY-MM-DD HH:mm:ss"),r.payType[e.pay_model],r.statusType[e.pay_type]]});r.printTableData=[["ID","服务项目信息","下单人","下单手机号","技师","技师类型","服务开始时间","出行费用","服务项目费用","实收金额","退款金额","子订单号","系统订单号","付款订单号","下单时间","支付方式","状态"],s]}}})},getCover:function(e,t){this.operForm[t]=e},getLatLng:function(e){this.operForm.lat=e.lat,this.operForm.lng=e.lng},toShowDialog:function(e,t){var r=this;return p()(s.a.mark(function a(){var o;return s.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:for(o in t=JSON.parse(i()(t)),r[e+"Form"])r[e+"Form"][o]=t[o];if("transfer"!==e){a.next=7;break}return r.searchForm.transfer.order_id=t.order_id,r.searchForm.transfer.type=1,a.next=7,r.getTableDataList(1,e);case 7:"oper"===e&&(t.img=[]),r.showDialog[e]=!0;case 9:case"end":return a.stop()}},a,r)}))()},changeCoachType:function(){this.transferForm.coach_name="",this.transferForm.text=""},handleTableChange:function(e,t){e=JSON.parse(i()(e)),this.currentRow=e},handleDialogConfirm:function(){var e=this;return p()(s.a.mark(function t(){var r,a,o,n,l,c,p,d,u,m,_,f;return s.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(r=!0,a=JSON.parse(i()(e.transferForm)),o=a.coach_type,1!==(void 0===o?1:o)){t.next=13;break}if(null!==e.currentRow&&e.currentRow.id){t.next=7;break}return e.$message.error("请选择技师"),t.abrupt("return");case 7:n=e.currentRow,l=n.id,c=void 0===l?0:l,p=n.coach_name,d=void 0===p?"":p,u=n.near_time,m=void 0===u?"":u,a.coach_id=c,a.coach_name=d,a.near_time=m,t.next=15;break;case 13:a.coach_id=0,e.$refs.transferSubForm.validate(function(e){e||(r=!1)});case 15:if(delete a.coach_type,!e.lockTap&&r){t.next=18;break}return t.abrupt("return");case 18:return e.lockTap=!0,t.next=21,e.$api.shop.orderChangeCoach(a);case 21:if(_=t.sent,f=_.code,e.lockTap=!1,200===f){t.next=26;break}return t.abrupt("return");case 26:e.$message.success(e.$t("tips.successOper")),e.getTableDataList("","list"),e.showDialog.transfer=!1;case 29:case"end":return t.stop()}},t,e)}))()},toOperOrderItem:function(e){var t=this;return p()(s.a.mark(function r(){var a;return s.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:a=e.type,e.type=1*a+1,t.$confirm("你确认要操作"+t.technicianStatusType[a]+"吗",t.$t("tips.reminder"),{confirmButtonText:t.$t("action.comfirm"),cancelButtonText:t.$t("action.cancel"),type:"warning"}).then(function(){t.toConfirmOperOrder(e)}).catch(function(){});case 3:case"end":return r.stop()}},r,t)}))()},toConfirmOperOrder:function(e){var t=this;return p()(s.a.mark(function r(){var a,o;return s.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:if(!t.lockTap){r.next=2;break}return r.abrupt("return");case 2:return t.lockTap=!0,r.next=5,t.$api.shop.adminUpdateOrder(e);case 5:if(a=r.sent,o=a.code,t.lockTap=!1,200===o){r.next=10;break}return r.abrupt("return");case 10:t.$message.success(t.$t("tips.successOper")),t.getTableDataList("","list");case 12:case"end":return r.stop()}},r,t)}))()},submitForm:function(){var e=this;return p()(s.a.mark(function t(){var r,a,o,n,l,c,p,d;return s.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(r=!0,e.$refs.operForm.validate(function(e){e||(r=!1)}),!r){t.next=13;break}return a=JSON.parse(i()(e.operForm)),o=e.$util.pick(a,["order_id"]),n=a.type,l=a.lat,c=a.lng,p=a.address,d=a.img,o.type=1*n+1,3===n&&(o.serout_lat=l,o.serout_lng=c,o.serout_address=p),4===n&&(o.arrive_img=d[0].url,o.arr_lat=l,o.arr_lng=c,o.arr_address=p),6===n&&(o.end_lat=l,o.end_lng=c,o.end_address=p,o.end_img=d[0].url),t.next=12,e.toConfirmOperOrder(o);case 12:e.showDialog.oper=!1;case 13:case"end":return t.stop()}},t,e)}))()},toExportExcel:function(){var e=this;this.downloadLoading=!0;var t=JSON.parse(i()(this.searchForm.list)),r=t.start_time;r&&r.length>0?(t.start_time=r[0]/1e3,t.end_time=r[1]/1e3):(t.start_time="",t.end_time="");var a=this.$util.getProCurrentHref(),n=a.indexOf("?")>0?"":"?",l=a.indexOf("?")>0;o()(t).forEach(function(e,r){n+=l?"&"+e+"="+t[e]:e+"="+t[e],l=!0});var s=window.localStorage.getItem("massage_minitk"),c=a+"/massage/admin/AdminExcel/orderList"+n+"&token="+s;window.location.href=c,setTimeout(function(){e.downloadLoading=!1},5e3)},printTable:function(){var e=this;this.print=!0,setTimeout(function(){e.$print(e.$refs.print),e.print=!1},50)}},filters:{handleTime:function(e,t){return 1===t?u()(1e3*e).format("YYYY-MM-DD"):2===t?u()(1e3*e).format("HH:mm:ss"):u()(1e3*e).format("YYYY-MM-DD HH:mm:ss")}}},_={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"lb-shop-order"},[r("top-nav"),e._v(" "),r("div",{staticClass:"page-main"},[r("el-row",{staticClass:"page-search-form"},[r("el-form",{ref:"listForm",attrs:{inline:!0,model:e.searchForm.list},nativeOn:{submit:function(e){e.preventDefault()}}},[r("el-form-item",{attrs:{label:"服务名称",prop:"goods_name"}},[r("el-input",{attrs:{placeholder:"请输入服务名称"},model:{value:e.searchForm.list.goods_name,callback:function(t){e.$set(e.searchForm.list,"goods_name",t)},expression:"searchForm.list.goods_name"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"技师姓名",prop:"coach_name"}},[r("el-input",{attrs:{placeholder:"请输入技师姓名"},model:{value:e.searchForm.list.coach_name,callback:function(t){e.$set(e.searchForm.list,"coach_name",t)},expression:"searchForm.list.coach_name"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"系统订单号",prop:"order_code"}},[r("el-input",{attrs:{placeholder:"请输入系统订单号"},model:{value:e.searchForm.list.order_code,callback:function(t){e.$set(e.searchForm.list,"order_code",t)},expression:"searchForm.list.order_code"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"下单手机号",prop:"mobile"}},[r("el-input",{staticStyle:{width:"200px"},attrs:{placeholder:"请输入下单时填写的手机号"},model:{value:e.searchForm.list.mobile,callback:function(t){e.$set(e.searchForm.list,"mobile",t)},expression:"searchForm.list.mobile"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"日期",prop:"start_time"}},[r("el-date-picker",{attrs:{type:"daterange","range-separator":"至","start-placeholder":"开始日期","end-placeholder":"结束日期","value-format":"timestamp","picker-options":e.pickerOptions,"default-time":["00:00:00","23:59:59"]},on:{change:function(t){return e.getTableDataList(1,"list")}},model:{value:e.searchForm.list.start_time,callback:function(t){e.$set(e.searchForm.list,"start_time",t)},expression:"searchForm.list.start_time"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"技师类型",prop:"is_coach"}},[r("el-select",{attrs:{placeholder:"请选择"},on:{change:function(t){return e.getTableDataList(1,"list")}},model:{value:e.searchForm.list.is_coach,callback:function(t){e.$set(e.searchForm.list,"is_coach",t)},expression:"searchForm.list.is_coach"}},e._l(e.coachTypeList,function(e){return r("el-option",{key:e.id,attrs:{label:e.title,value:e.id}})}),1)],1),e._v(" "),r("el-form-item",{attrs:{label:"状态",prop:"pay_type"}},[r("el-select",{attrs:{placeholder:"请选择"},on:{change:function(t){return e.getTableDataList(1,"list")}},model:{value:e.searchForm.list.pay_type,callback:function(t){e.$set(e.searchForm.list,"pay_type",t)},expression:"searchForm.list.pay_type"}},e._l(e.statusOptions,function(e){return r("el-option",{key:e.value,attrs:{label:e.label,value:e.value}})}),1)],1),e._v(" "),r("el-form-item",[r("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",type:"primary",icon:"el-icon-search"},on:{click:function(t){return e.getTableDataList(1,"list")}}},[e._v(e._s(e.$t("action.search")))]),e._v(" "),r("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",icon:"el-icon-refresh-left"},on:{click:function(t){return e.resetForm("list")}}},[e._v(e._s(e.$t("action.reset")))])],1)],1)],1),e._v(" "),r("el-row",{staticClass:"page-top-operate"},[r("lb-button",{attrs:{size:"mini",plain:"",type:"primary",icon:"el-icon-printer"},on:{click:e.printTable}},[e._v("打印")]),e._v(" "),r("lb-button",{attrs:{size:"mini",plain:"",type:"primary",icon:"el-icon-download",loading:e.downloadLoading},on:{click:e.toExportExcel}},[e._v("导出")])],1),e._v(" "),r("div",{staticClass:"pb-lg"},[e._v("\n      共"+e._s(e.total.list)+"条数据，订单金额共计："+e._s(e.order_price)+"元，车费共计："+e._s(e.car_price)+"元\n    ")]),e._v(" "),r("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.loading.list,expression:"loading.list"}],staticStyle:{width:"100%"},attrs:{data:e.tableData.list,"header-cell-style":{background:"#f5f7fa",color:"#606266"}}},[r("el-table-column",{attrs:{prop:"id",label:"ID",width:"80",fixed:""}}),e._v(" "),r("el-table-column",{attrs:{prop:"goods_info_text",width:"300",label:"服务项目信息"},scopedSlots:e._u([{key:"default",fn:function(t){return e._l(t.row.order_goods,function(t,a){return r("div",{key:a,staticClass:"pb-sm"},[r("div",{staticClass:"flex-center pt-md"},[r("lb-image",{staticClass:"avatar radius-5",attrs:{src:t.goods_cover}}),e._v(" "),r("div",{staticClass:"flex-1 f-caption c-caption ml-md",staticStyle:{width:"210px"}},[r("div",{staticClass:"flex-between"},[r("div",{staticClass:"f-paragraph c-title ellipsis",class:[{"max-300":t.refund_num>0}],staticStyle:{"line-height":"1.2","margin-bottom":"4px"}},[e._v("\n                    "+e._s(t.goods_name)+"\n                  ")]),e._v(" "),t.refund_num>0?r("div",{staticClass:"f-caption c-warning"},[e._v("\n                    已退x"+e._s(t.refund_num)+"\n                  ")]):e._e()]),e._v(" "),r("div",{staticClass:"f-caption",staticStyle:{"line-height":"1.4"}},[e._v("\n                  时长："+e._s(t.time_long)+" 分钟\n                ")]),e._v(" "),r("div",{staticClass:"flex-between f-caption mt-sm",staticStyle:{"line-height":"1.4"}},[r("div",{staticClass:"c-warning"},[e._v("¥"+e._s(t.price))]),e._v(" "),r("div",[e._v("x"+e._s(t.num))])])])],1)])})}}])}),e._v(" "),r("el-table-column",{attrs:{prop:"user_name",label:"下单人","min-width":"120"}}),e._v(" "),r("el-table-column",{attrs:{prop:"mobile","min-width":"120",label:"下单手机号"}}),e._v(" "),r("el-table-column",{attrs:{prop:"coach_info.coach_name",label:"技师","min-width":"120"}}),e._v(" "),r("el-table-column",{attrs:{prop:"coach_id",label:"技师类型","min-width":"120"},scopedSlots:e._u([{key:"default",fn:function(t){return[r("div",[e._v(e._s(t.row.coach_id?"入驻技师":"非入驻技师"))])]}}])}),e._v(" "),r("el-table-column",{attrs:{prop:"start_time","min-width":"120",label:"服务开始时间"},scopedSlots:e._u([{key:"default",fn:function(t){return[r("div",[e._v(e._s(e._f("handleTime")(t.row.start_time,1)))]),e._v(" "),r("div",[e._v(e._s(e._f("handleTime")(t.row.start_time,2)))])]}}])}),e._v(" "),r("el-table-column",{attrs:{prop:"car_type","min-width":"250",label:"出行费用"},scopedSlots:e._u([{key:"default",fn:function(t){return[r("div",[e._v("\n            "+e._s(e.carType[t.row.car_type])+"\n          ")]),e._v(" "),1==t.row.car_type?r("div",{staticClass:"flex-y-center"},[e._v("\n            全程"+e._s(t.row.distance)+"，车费¥"+e._s(t.row.car_price)+"\n          ")]):e._e()]}}])}),e._v(" "),r("el-table-column",{attrs:{prop:"init_service_price",width:"120",label:"服务项目费用"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n          ¥"+e._s(t.row.init_service_price)+"\n        ")]}}])}),e._v(" "),r("el-table-column",{attrs:{prop:"pay_price",label:"实收金额"},scopedSlots:e._u([{key:"default",fn:function(t){return[r("div",[e._v("¥"+e._s(t.row.pay_price))])]}}])}),e._v(" "),r("el-table-column",{attrs:{prop:"refund_price",label:"退款金额"},scopedSlots:e._u([{key:"default",fn:function(t){return t.row.refund_price?[r("div",[e._v("¥"+e._s(t.row.refund_price))])]:void 0}}],null,!0)}),e._v(" "),r("el-table-column",{attrs:{prop:"add_order_id",width:"150",label:"子订单号"},scopedSlots:e._u([{key:"default",fn:function(t){return t.row.add_order_id&&t.row.add_order_id.length>0?e._l(t.row.add_order_id,function(t,a){return r("div",{key:a,staticClass:"c-warning cursor-pointer",class:[{"mt-md":0!==a}],on:{click:function(r){return e.$router.push("/shop/order/detail?id="+t.id)}}},[e._v("\n            "+e._s(t.order_code)+"\n          ")])}):void 0}}],null,!0)}),e._v(" "),r("el-table-column",{attrs:{prop:"order_code",width:"150",label:"系统订单号"}}),e._v(" "),r("el-table-column",{attrs:{prop:"transaction_id",width:"150",label:"付款订单号"}}),e._v(" "),r("el-table-column",{attrs:{prop:"create_time","min-width":"120",label:"下单时间"},scopedSlots:e._u([{key:"default",fn:function(t){return[r("div",[e._v(e._s(e._f("handleTime")(t.row.create_time,1)))]),e._v(" "),r("div",[e._v(e._s(e._f("handleTime")(t.row.create_time,2)))])]}}])}),e._v(" "),r("el-table-column",{attrs:{prop:"pay_model",label:"支付方式","min-width":"120"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n          "+e._s(e.payType[t.row.pay_model])+"\n        ")]}}])}),e._v(" "),r("el-table-column",{attrs:{prop:"status",label:"状态"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n          "+e._s(e.statusType[t.row.pay_type])+"\n          "),t.row.coach_refund_time&&-1===t.row.pay_type?r("div",{staticClass:"f-icontext c-warning"},[e._v("\n            技师拒单\n          ")]):e._e(),e._v(" "),t.row.is_show?e._e():r("div",{staticClass:"f-icontext c-warning"},[e._v("\n            用户已删除\n          ")])]}}])}),e._v(" "),r("el-table-column",{attrs:{label:"操作","min-width":"160"},scopedSlots:e._u([{key:"default",fn:function(t){return[r("div",{staticClass:"table-operate"},[r("lb-button",{attrs:{size:"mini",type:"primary",plain:""},on:{click:function(r){return e.$router.push("/shop/order/detail?id="+t.row.id)}}},[e._v(e._s(e.$t("action.view")))]),e._v(" "),[2,3,4,5,6,8].includes(t.row.pay_type)?r("lb-button",{attrs:{size:"mini",type:"danger",plain:""},on:{click:function(r){return e.toShowDialog("transfer",{order_id:t.row.id,coach_type:1})}}},[e._v("转单")]):e._e(),e._v(" "),[2,3,4,5,6].includes(t.row.pay_type)?r("lb-button",{attrs:{size:"mini",type:"success",plain:""},on:{click:function(r){return e.toOperOrderItem({order_id:t.row.id,type:t.row.pay_type})}}},[e._v(e._s(e.technicianStatusType[t.row.pay_type]))]):e._e()],1)]}}])})],1),e._v(" "),r("table",{directives:[{name:"show",rawName:"v-show",value:e.print,expression:"print"}],ref:"print",staticStyle:{"font-size":"12px"},attrs:{border:"0",cellspacing:"0",cellapdding:"0"}},[r("thead",[r("tr",e._l(e.printTableData[0],function(t,a){return r("th",{key:a,staticStyle:{border:"1px solid"}},[e._v("\n            "+e._s(t)+"\n          ")])}),0)]),e._v(" "),r("tbody",e._l(e.printTableData[1],function(t,a){return r("tr",{key:a},e._l(t,function(t,a){return r("td",{key:a,staticStyle:{border:"1px solid"}},[e._v("\n            "+e._s(t)+"\n          ")])}),0)}),0)]),e._v(" "),r("lb-page",{attrs:{batch:!1,page:e.searchForm.list.page,pageSize:e.searchForm.list.limit,total:e.total.list},on:{handleSizeChange:function(t){return e.handleSizeChange(t,"list")},handleCurrentChange:function(t){return e.handleCurrentChange(t,"list")}}}),e._v(" "),r("el-dialog",{attrs:{title:"转派技师",visible:e.showDialog.transfer,width:"1000px",center:""},on:{"update:visible":function(t){return e.$set(e.showDialog,"transfer",t)}}},[r("el-form",{ref:"transferSubForm",staticClass:"dialog-form",attrs:{model:e.transferForm,rules:e.transferSubFormRules,"label-width":"80px"},nativeOn:{submit:function(e){e.preventDefault()}}},[r("el-form-item",{attrs:{label:"转派订单",prop:"coach_type"}},[r("el-radio-group",{on:{change:e.changeCoachType},model:{value:e.transferForm.coach_type,callback:function(t){e.$set(e.transferForm,"coach_type",t)},expression:"transferForm.coach_type"}},[r("el-radio",{attrs:{label:1}},[e._v("转派线上技师")]),e._v(" "),r("el-radio",{attrs:{label:2}},[e._v("转派线下技师")])],1)],1),e._v(" "),2===e.transferForm.coach_type?r("block",[r("el-form-item",{attrs:{label:"线下技师",prop:"coach_name"}},[r("el-input",{attrs:{placeholder:"请输入线下技师姓名",maxlength:"15","show-word-limit":""},model:{value:e.transferForm.coach_name,callback:function(t){e.$set(e.transferForm,"coach_name",t)},expression:"transferForm.coach_name"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"联系电话",prop:"mobile"}},[r("el-input",{attrs:{placeholder:"请输入联系电话",maxlength:"11","show-word-limit":""},model:{value:e.transferForm.mobile,callback:function(t){e.$set(e.transferForm,"mobile",t)},expression:"transferForm.mobile"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"转派备注",prop:"text"}},[r("el-input",{attrs:{type:"textarea",rows:10,maxlength:"400","show-word-limit":"",resize:"none",placeholder:"可备注技师提成、渠道、分销商等角色提成金额，以便线下结算"},model:{value:e.transferForm.text,callback:function(t){e.$set(e.transferForm,"text",t)},expression:"transferForm.text"}})],1)],1):e._e()],1),e._v(" "),1===e.transferForm.coach_type?r("div",{staticStyle:{"padding-left":"10px"}},[r("el-form",{ref:"transferForm",attrs:{inline:!0,model:e.searchForm.transfer,"label-width":"70px"}},[r("el-form-item",{attrs:{label:"输入查询",prop:"coach_name"}},[r("el-input",{attrs:{placeholder:"请输入技师姓名"},model:{value:e.searchForm.transfer.coach_name,callback:function(t){e.$set(e.searchForm.transfer,"coach_name",t)},expression:"searchForm.transfer.coach_name"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"筛选排序",prop:"type"}},[r("el-select",{attrs:{placeholder:"请选择"},on:{change:function(t){return e.getTableDataList(1,"transfer")}},model:{value:e.searchForm.transfer.type,callback:function(t){e.$set(e.searchForm.transfer,"type",t)},expression:"searchForm.transfer.type"}},e._l(e.transfreTypeList,function(e){return r("el-option",{key:e.id,attrs:{label:e.title,value:e.id}})}),1)],1),e._v(" "),r("el-form-item",[r("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",type:"primary",icon:"el-icon-search"},on:{click:function(t){return e.getTableDataList(1,"transfer")}}},[e._v(e._s(e.$t("action.search")))]),e._v(" "),r("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",icon:"el-icon-refresh-left"},on:{click:function(t){return e.resetForm("transfer")}}},[e._v(e._s(e.$t("action.reset")))])],1)],1),e._v(" "),r("el-table",{ref:"singleTable",staticStyle:{width:"100%"},attrs:{data:e.tableData.transfer,"header-cell-style":{background:"#f5f7fa",color:"#606266"},"tooltip-effect":"dark","highlight-current-row":""},on:{"current-change":e.handleTableChange}},[r("el-table-column",{attrs:{prop:"coach_name",label:"技师姓名"}}),e._v(" "),r("el-table-column",{attrs:{prop:"work_img",width:"150",label:"技师头像"},scopedSlots:e._u([{key:"default",fn:function(e){return[r("lb-image",{attrs:{src:e.row.work_img}})]}}],null,!1,1359628658)}),e._v(" "),r("el-table-column",{attrs:{prop:"distance",label:"距离"}}),e._v(" "),r("el-table-column",{attrs:{prop:"near_time",label:"最早可预约"}}),e._v(" "),r("el-table-column",{attrs:{prop:"admin_info.user_name",label:"所属代理商"},scopedSlots:e._u([{key:"default",fn:function(t){return[0===t.row.admin_id?r("div",[e._v("平台")]):r("div",[r("div",[e._v(e._s(t.row.admin_info.username))]),e._v(" "),r("el-tag",{attrs:{type:e.cityType[t.row.admin_info.city_type].type,size:"medium"}},[e._v(e._s(e.cityType[t.row.admin_info.city_type].text)+"代理")])],1)]}}],null,!1,1830304008)}),e._v(" "),r("el-table-column",{attrs:{prop:"mobile",label:"联系电话"}})],1),e._v(" "),r("lb-page",{attrs:{batch:!1,page:e.searchForm.transfer.page,pageSize:e.searchForm.transfer.limit,total:e.total.transfer},on:{handleSizeChange:function(t){return e.handleSizeChange(t,"transfer")},handleCurrentChange:function(t){return e.handleCurrentChange(t,"transfer")}}})],1):e._e(),e._v(" "),r("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[r("el-button",{on:{click:function(t){e.showDialog.transfer=!1}}},[e._v("取 消")]),e._v(" "),r("el-button",{attrs:{type:"primary"},on:{click:e.handleDialogConfirm}},[e._v("确 定")])],1)],1),e._v(" "),r("el-dialog",{staticClass:"dialog-form",attrs:{title:e.technicianStatusType[e.operForm.type],visible:e.showDialog.oper,width:"600px",center:""},on:{"update:visible":function(t){return e.$set(e.showDialog,"oper",t)}}},[r("el-form",{ref:"operForm",attrs:{model:e.operForm,rules:e.operFormRules,"label-width":"120px"},nativeOn:{submit:function(e){e.preventDefault()}}},[[4,6].includes(e.operForm.type)?r("el-form-item",{attrs:{label:e.technicianStatusType[e.operForm.type]+"图片",prop:"img"}},[r("lb-cover",{attrs:{fileList:e.operForm.img},on:{selectedFiles:function(t){return e.getCover(t,"img")}}})],1):e._e(),e._v(" "),[3,4,6].includes(e.operForm.type)?r("block",[r("el-form-item",{attrs:{label:e.technicianStatusType[e.operForm.type]+"地址",prop:"address"}},[r("el-input",{attrs:{placeholder:e.technicianStatusType[e.operForm.type]+"地址"},model:{value:e.operForm.address,callback:function(t){e.$set(e.operForm,"address",t)},expression:"operForm.address"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"经度",prop:"lng"}},[r("el-input",{attrs:{placeholder:"请输入经度"},model:{value:e.operForm.lng,callback:function(t){e.$set(e.operForm,"lng",t)},expression:"operForm.lng"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"纬度",prop:"lat"}},[r("el-input",{attrs:{placeholder:"请输入纬度"},model:{value:e.operForm.lat,callback:function(t){e.$set(e.operForm,"lat",t)},expression:"operForm.lat"}}),e._v(" "),r("lb-button",{attrs:{type:"primary",plain:"",size:"mini"},on:{click:function(t){e.showMap=!0}}},[e._v("获取经纬度")])],1)],1):e._e()],1),e._v(" "),r("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[r("el-button",{on:{click:function(t){e.showDialog.oper=!1}}},[e._v("取 消")]),e._v(" "),r("el-button",{attrs:{type:"primary"},on:{click:e.submitForm}},[e._v("确 定")])],1)],1),e._v(" "),r("lb-map",{attrs:{dialogVisible:e.showMap},on:{"update:dialogVisible":function(t){e.showMap=t},"update:dialog-visible":function(t){e.showMap=t},selectedLatLng:e.getLatLng}})],1)],1)},staticRenderFns:[]};var f=r("VU/8")(m,_,!1,function(e){r("rwpz"),r("qQ5X")},"data-v-24a87f94",null);t.default=f.exports},qQ5X:function(e,t){},rwpz:function(e,t){}});