webpackJsonp([19],{EQHf:function(t,e){},GhVZ:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=a("mvHQ"),r=a.n(s),l=a("Xxa5"),n=a.n(l),i=a("exGp"),o=a.n(i),c=a("PJh5"),u=a.n(c),p={data:function(){return{total_cash:0,unrecorded_cash:0,wallet_cash:0,unrecorded_wallet_cash:0,showDialog:!1,statusOptions:[{label:"全部",value:0},{label:"未入账",value:1},{label:"已入账",value:2}],statusOptions2:[{label:"全部",value:0},{label:"分销商",value:1},{label:"代理商",value:2},{label:"技师",value:3}],statusType:{1:"未入账",2:"已入账"},cityType:{1:"城市",2:"区县",3:"省"},typeText:{1:"分销商",2:"代理商",3:"技师",4:"分销商",5:"代理商",6:"代理商"},loading:!1,searchForm:{page:1,limit:10,top_name:"",status:0,type:0},tableData:[],total:0,subForm:{apply_price:"",text:""},subFormRules:{apply_price:{required:!0,validator:this.$reg.isMoney,text:"提现金额",trigger:"blur"}}}},created:function(){this.getTableDataList()},methods:{resetForm:function(t){this.$refs[t].resetFields(),this.searchForm.type=0,this.getTableDataList(1)},handleSizeChange:function(t){this.searchForm.limit=t,this.handleCurrentChange(1)},handleCurrentChange:function(t){this.searchForm.page=t,this.getTableDataList()},getTableDataList:function(t){var e=this;return o()(n.a.mark(function a(){var s,r,l,i;return n.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:return t&&(e.searchForm.page=1),e.loading=!0,s=e.searchForm,a.next=5,e.$api.agent.cashList(s);case 5:if(r=a.sent,l=r.code,i=r.data,e.loading=!1,200===l){a.next=11;break}return a.abrupt("return");case 11:e.tableData=i.data,e.total=i.total,["total_cash","unrecorded_cash","wallet_cash"].map(function(t){e[t]=i[t]}),e.unrecorded_wallet_cash=(1*i.unrecorded_cash+1*i.wallet_cash).toFixed(2),e.subForm.apply_price=e.total_cash;case 17:case"end":return a.stop()}},a,e)}))()},confirmDel:function(t){var e=this;this.$confirm(this.$t("tips.confirmDelete"),this.$t("tips.reminder"),{confirmButtonText:this.$t("action.comfirm"),cancelButtonText:this.$t("action.cancel"),type:"warning"}).then(function(){e.updateItem(t,-1)}).catch(function(){})},updateItem:function(t,e){var a=this;return o()(n.a.mark(function s(){return n.a.wrap(function(s){for(;;)switch(s.prev=s.next){case 0:a.$api.shop.commentUpdate({id:t,status:e}).then(function(t){if(200===t.code)a.$message.success(a.$t(-1===e?"tips.successDel":"tips.successOper")),-1===e&&(a.searchForm.page=a.searchForm.page<Math.ceil((a.total-1)/a.searchForm.limit)?a.searchForm.page:Math.ceil((a.total-1)/a.searchForm.limit),a.getTableDataList());else{if(-1===e)return;a.getTableDataList()}});case 1:case"end":return s.stop()}},s,a)}))()},submitFormInfo:function(){var t=this;return o()(n.a.mark(function e(){var a,s,l;return n.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(a=!0,t.$refs.subForm.validate(function(t){t||(a=!1)}),!a){e.next=13;break}return s=JSON.parse(r()(t.subForm)),e.next=6,t.$api.agent.applyWallet(s);case 6:if(l=e.sent,200===l.code){e.next=10;break}return e.abrupt("return");case 10:t.$message.success(t.$t("tips.successSub")),t.showDialog=!1,t.getTableDataList();case 13:case"end":return e.stop()}},e,t)}))()}},filters:{handleTime:function(t,e){return 1===e?u()(1e3*t).format("YYYY-MM-DD"):2===e?u()(1e3*t).format("HH:mm:ss"):u()(1e3*t).format("YYYY-MM-DD HH:mm:ss")}}},m={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"lb-shop-refund"},[a("top-nav"),t._v(" "),a("div",{staticClass:"page-main"},[a("el-row",{staticClass:"page-search-form"},[a("div",{staticClass:"f_r_sb_c"},[a("div",{staticClass:"f_c_m_c"},[a("span",[t._v("可用余额")]),t._v(" "),a("div",{staticClass:"f_r_m_c",staticStyle:{margin:"20px 0"}},[a("el-button",{staticStyle:{"font-size":"30px","margin-right":"10px"},attrs:{type:"text"}},[t._v(t._s(t.total_cash||0))]),t._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:function(e){t.showDialog=!0}}},[t._v("提现")]),t._v(" "),a("el-button",{attrs:{type:"text"},on:{click:function(e){return t.$router.push("/finance/record")}}},[t._v("提现记录")])],1)]),t._v(" "),a("div",{staticClass:"f_c_m_c"},[a("span",[t._v("总金额(元)")]),t._v(" "),a("div",{staticClass:"f_r_m_c",staticStyle:{"font-size":"30px",margin:"20px 0"}},[t._v("\n            "+t._s(t.unrecorded_wallet_cash||0)+"\n          ")])]),t._v(" "),a("div",{staticClass:"f_c_m_c"},[a("div",{staticClass:"f_r_m_c"},[a("span",[t._v("未入账(元)")]),t._v(" "),a("lb-tool-tips",{attrs:{padding:0}},[t._v("\n              平台未到账的服务订单金额\n            ")])],1),t._v(" "),a("div",{staticClass:"f_r_m_c",staticStyle:{"font-size":"30px",margin:"20px 0"}},[t._v("\n            "+t._s(t.unrecorded_cash||0)+"\n          ")])])])]),t._v(" "),a("el-row",{staticClass:"page-search-form"},[a("el-form",{ref:"searchForm",attrs:{inline:!0,model:t.searchForm},nativeOn:{submit:function(t){t.preventDefault()}}},[a("el-form-item",{attrs:{label:"佣金获得者",prop:"top_name"}},[a("el-input",{attrs:{placeholder:"请输入佣金获得者姓名"},model:{value:t.searchForm.top_name,callback:function(e){t.$set(t.searchForm,"top_name",e)},expression:"searchForm.top_name"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"状态",prop:"status"}},[a("el-select",{attrs:{placeholder:"请选择"},on:{change:function(e){return t.getTableDataList(1)}},model:{value:t.searchForm.status,callback:function(e){t.$set(t.searchForm,"status",e)},expression:"searchForm.status"}},t._l(t.statusOptions,function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})}),1)],1),t._v(" "),a("el-form-item",{attrs:{label:"提成类型",prop:"status"}},[a("el-select",{attrs:{placeholder:"请选择"},on:{change:function(e){return t.getTableDataList(1)}},model:{value:t.searchForm.type,callback:function(e){t.$set(t.searchForm,"type",e)},expression:"searchForm.type"}},t._l(t.statusOptions2,function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})}),1)],1),t._v(" "),a("el-form-item",[a("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",type:"primary",icon:"el-icon-search"},on:{click:function(e){return t.getTableDataList(1)}}},[t._v(t._s(t.$t("action.search")))]),t._v(" "),a("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",icon:"el-icon-refresh-left"},on:{click:function(e){return t.resetForm("searchForm")}}},[t._v(t._s(t.$t("action.reset")))])],1)],1)],1),t._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticStyle:{width:"100%"},attrs:{data:t.tableData,"header-cell-style":{background:"#f5f7fa",color:"#606266"}}},[a("el-table-column",{attrs:{prop:"id",label:"ID","min-width":"80",fixed:""}}),t._v(" "),a("el-table-column",{attrs:{prop:"top_name",label:"佣金获得者","min-width":"120"}}),t._v(" "),a("el-table-column",{attrs:{prop:"nickName",label:"来源","min-width":"120"}}),t._v(" "),a("el-table-column",{attrs:{prop:"order_code",width:"150",label:"系统订单号"}}),t._v(" "),a("el-table-column",{attrs:{prop:"transaction_id",width:"150",label:"商户订单号"}}),t._v(" "),a("el-table-column",{attrs:{prop:"total_price",label:"佣金类型","min-width":"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("span",[t._v("\n            "+t._s([2,5,6].includes(e.row.type)?t.cityType[e.row.city_type]:"")+t._s(t.typeText[e.row.type]))])]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"status",label:"状态"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n          "+t._s(t.statusType[e.row.status])+"\n        ")]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"pay_price",label:"订单总金额","min-width":"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" ¥"+t._s(e.row.pay_price))]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"order_goods",label:"提成比例","min-width":"300"},scopedSlots:t._u([{key:"default",fn:function(e){return[1==e.row.type?a("div",t._l(e.row.order_goods,function(e,s){return a("div",{key:s,staticClass:"pb-sm",staticStyle:{width:"250px"}},[a("div",{staticClass:"flex-center pt-md"},[a("lb-image",{staticClass:"avatar radius-5",attrs:{src:e.goods_cover}}),t._v(" "),a("div",{staticClass:"flex-1 f-caption c-caption ml-md",staticStyle:{width:"180px"}},[a("div",{staticClass:"flex-between"},[a("div",{staticClass:"f-paragraph c-title ellipsis",staticStyle:{"line-height":"1.2","margin-bottom":"4px"}},[t._v("\n                      "+t._s(e.goods_name)+"\n                    ")])]),t._v(" "),a("div",{staticClass:"flex-y-center"},[t._v("\n                    提成比例\n                    "),a("div",{staticClass:"c-warning ml-sm"},[t._v(t._s(e.balance)+"%")])]),t._v(" "),a("div",{staticClass:"flex-between f-caption"},[a("div",{staticClass:"c-warning"},[t._v("¥"+t._s(e.true_price))]),t._v(" "),a("div",[t._v("x"+t._s(e.num))])])])],1)])}),0):a("div",[t._v(t._s(e.row.balance)+"%")])]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"cash",label:"此单提成金额","min-width":"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" ¥"+t._s(e.row.cash))]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"create_time","min-width":"120",label:"时间"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",[t._v(t._s(t._f("handleTime")(e.row.create_time,1)))]),t._v(" "),a("div",[t._v(t._s(t._f("handleTime")(e.row.create_time,2)))])]}}])})],1),t._v(" "),a("lb-page",{attrs:{batch:!1,page:t.searchForm.page,pageSize:t.searchForm.limit,total:t.total},on:{handleSizeChange:t.handleSizeChange,handleCurrentChange:t.handleCurrentChange}})],1),t._v(" "),a("el-dialog",{attrs:{title:"提现信息核对",visible:t.showDialog,width:"600px",center:""},on:{"update:visible":function(e){t.showDialog=e}}},[a("el-form",{ref:"subForm",staticClass:"dialog-form",attrs:{model:t.subForm,rules:t.subFormRules,"label-width":"120px"}},[a("el-form-item",{attrs:{label:"提现金额",prop:"apply_price"}},[a("el-input",{attrs:{placeholder:"请输入提现金额"},model:{value:t.subForm.apply_price,callback:function(e){t.$set(t.subForm,"apply_price",e)},expression:"subForm.apply_price"}},[a("template",{slot:"append"},[t._v("元")])],2)],1),t._v(" "),a("el-form-item",{attrs:{label:"提现金额",prop:"text"}},[a("el-input",{attrs:{type:"textarea",rows:10,maxlength:"300","show-word-limit":"",resize:"none",placeholder:"请输入备注信息"},model:{value:t.subForm.text,callback:function(e){t.$set(t.subForm,"text",e)},expression:"subForm.text"}})],1)],1),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.showDialog=!1}}},[t._v("取 消")]),t._v(" "),a("el-button",{directives:[{name:"preventReClick",rawName:"v-preventReClick"}],attrs:{type:"primary"},on:{click:function(e){return t.submitFormInfo("sub")}}},[t._v("确 定")])],1)],1)],1)},staticRenderFns:[]};var _=a("VU/8")(p,m,!1,function(t){a("EQHf"),a("uof7")},"data-v-1bf48248",null);e.default=_.exports},uof7:function(t,e){}});