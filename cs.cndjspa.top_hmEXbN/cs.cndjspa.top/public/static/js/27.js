webpackJsonp([27],{mHKU:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=a("mvHQ"),r=a.n(n),i=a("Xxa5"),s=a.n(i),o=a("exGp"),l=a.n(o),c=a("PJh5"),u=a.n(c),p={data:function(){return{loading:{list:!1,user:!1},sendType:{0:"活动派发",1:"平台定向派发",2:"用户领取"},searchForm:{list:{page:1,limit:10,name:""},user:{page:1,limit:10,nickName:""}},tableData:{list:[],user:[]},total:{list:0,user:0},cur_coupon:{},multipleSelection:[],showDialog:!1}},activated:function(){this.getTableDataList(1,"list")},methods:{resetForm:function(t){var e=t+"Form";this.$refs[e].resetFields(),this.getTableDataList(1,t)},handleSizeChange:function(t,e){this.searchForm[e].limit=t,this.handleCurrentChange(1,e)},handleCurrentChange:function(t,e){this.searchForm[e].page=t,this.getTableDataList("",e)},getTableDataList:function(t,e){var a=this;return l()(s.a.mark(function n(){var r,i,o,l;return s.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(t&&(a.searchForm[e].page=1),a.loading[e]=!0,r=a.searchForm[e],"list"!==e){n.next=9;break}return n.next=6,a.$api.market.couponList(r);case 6:n.t0=n.sent,n.next=12;break;case 9:return n.next=11,a.$api.custom.userList(r);case 11:n.t0=n.sent;case 12:if(i=n.t0,o=i.code,l=i.data,a.loading[e]=!1,200===o){n.next=18;break}return n.abrupt("return");case 18:a.tableData[e]=l.data,a.total[e]=l.total;case 20:case"end":return n.stop()}},n,a)}))()},confirmDel:function(t){var e=this;this.$confirm(this.$t("tips.confirmDelete"),this.$t("tips.reminder"),{confirmButtonText:this.$t("action.comfirm"),cancelButtonText:this.$t("action.cancel"),type:"warning"}).then(function(){e.updateItem(t,-1)}).catch(function(){})},updateItem:function(t,e){var a=this;return l()(s.a.mark(function n(){return s.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:a.$api.market.couponUpdate({id:t,status:e}).then(function(t){if(200===t.code)a.$message.success(a.$t(-1===e?"tips.successDel":"tips.successOper")),-1===e&&(a.searchForm.list.page=a.searchForm.list.page<Math.ceil((a.total.list-1)/a.searchForm.list.limit)?a.searchForm.list.page:Math.ceil((a.total.list-1)/a.searchForm.list.limit),a.getTableDataList("","list"));else{if(-1===e)return;a.getTableDataList("","list")}});case 1:case"end":return n.stop()}},n,a)}))()},toShowDialog:function(t){var e=this;return l()(s.a.mark(function a(){return s.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:return e.searchForm.user.nickName="",e.cur_coupon=JSON.parse(r()(t)),a.next=4,e.getTableDataList(1,"user");case 4:e.showDialog=!e.showDialog;case 5:case"end":return a.stop()}},a,e)}))()},handleSelectionChange:function(t){this.multipleSelection=t},handleDialogConfirm:function(){var t=this;return l()(s.a.mark(function e(){var a,n,i,o,l,c,u,p,m,d,f;return s.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(!((a=JSON.parse(r()(t.multipleSelection))).length<1)){e.next=4;break}return t.$message.error("请选择用户"),e.abrupt("return");case 4:e.t0=s.a.keys(a);case 5:if((e.t1=e.t0()).done){e.next=15;break}if(n=e.t1.value,i=1*n+1,o=a[n],l=o.id,c=o.nickName,u=o.num,p=c?"；用户昵称："+c:"",void 0===u?0:u){e.next=13;break}return t.$message.error("选择用户 第"+i+"条数据：（用户ID："+l+p+"）未设置卡券数量"),e.abrupt("return");case 13:e.next=5;break;case 15:return m=a.map(function(t){return{id:t.id,num:t.num}}),d={coupon_id:t.cur_coupon.id,user:m},e.next=19,t.$api.market.couponRecordAdd(d);case 19:if(f=e.sent,200===f.code){e.next=24;break}return t.showDialog=!1,e.abrupt("return");case 24:t.$message.success("卡券派发成功"),t.getTableDataList("","list"),t.showDialog=!1;case 27:case"end":return e.stop()}},e,t)}))()}},filters:{handleTime:function(t,e){return 1===e?u()(1e3*t).format("YYYY-MM-DD"):2===e?u()(1e3*t).format("HH:mm:ss"):u()(1e3*t).format("YYYY-MM-DD HH:mm:ss")}}},m={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"lb-examine-goods"},[a("top-nav"),t._v(" "),a("div",{staticClass:"page-main"},[a("lb-button",{attrs:{type:"primary",icon:"el-icon-plus"},on:{click:function(e){return t.$router.push("/market/coupon/edit")}}},[t._v(t._s(t.$t("menu.MarketCouponAdd")))]),t._v(" "),a("div",{staticClass:"space-lg"}),t._v(" "),a("el-row",{staticClass:"page-search-form"},[a("el-form",{ref:"listForm",attrs:{inline:!0,model:t.searchForm.list},nativeOn:{submit:function(t){t.preventDefault()}}},[a("el-form-item",{attrs:{label:"输入查询",prop:"name"}},[a("el-input",{attrs:{placeholder:"请输入卡券名称"},model:{value:t.searchForm.list.name,callback:function(e){t.$set(t.searchForm.list,"name",e)},expression:"searchForm.list.name"}})],1),t._v(" "),a("el-form-item",[a("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",type:"primary",icon:"el-icon-search"},on:{click:function(e){return t.getTableDataList(1,"list")}}},[t._v(t._s(t.$t("action.search")))]),t._v(" "),a("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",icon:"el-icon-refresh-left"},on:{click:function(e){return t.resetForm("list")}}},[t._v(t._s(t.$t("action.reset")))])],1)],1)],1),t._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.list,expression:"loading.list"}],staticStyle:{width:"100%"},attrs:{data:t.tableData.list,"header-cell-style":{background:"#f5f7fa",color:"#606266"}}},[a("el-table-column",{attrs:{prop:"id",label:"ID"}}),t._v(" "),a("el-table-column",{attrs:{prop:"title",label:"卡券名称"}}),t._v(" "),a("el-table-column",{attrs:{prop:"type",label:"使用条件"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("p",[t._v("\n            "+t._s(0===e.row.type?"消费满¥"+e.row.full+"减¥"+e.row.discount:"立减¥"+e.row.discount)+"\n          ")])]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"send_type","min-width":"120",label:"派发方式"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("p",[t._v(t._s(t.sendType[e.row.send_type]))])]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"top",width:"100",label:"排序值"}}),t._v(" "),a("el-table-column",{attrs:{prop:"create_time","min-width":"120",label:"创建时间"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("p",[t._v(t._s(t._f("handleTime")(e.row.create_time,1)))]),t._v(" "),a("p",[t._v(t._s(t._f("handleTime")(e.row.create_time,2)))])]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"status",label:"是否上架"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-switch",{attrs:{"active-value":1,"inactive-value":0},on:{change:function(a){return t.updateItem(e.row.id,e.row.status)}},model:{value:e.row.status,callback:function(a){t.$set(e.row,"status",a)},expression:"scope.row.status"}})]}}])}),t._v(" "),a("el-table-column",{attrs:{label:"操作","min-width":"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",{staticClass:"table-operate"},[a("lb-button",{attrs:{size:"mini",plain:"",type:"primary"},on:{click:function(a){return t.$router.push("/market/coupon/edit?id="+e.row.id)}}},[t._v(t._s(t.$t("action.edit")))]),t._v(" "),a("lb-button",{attrs:{size:"mini",plain:"",type:"danger"},on:{click:function(a){return t.confirmDel(e.row.id)}}},[t._v(t._s(t.$t("action.delete")))]),t._v(" "),1===e.row.send_type?a("lb-button",{attrs:{size:"mini",plain:"",type:"success"},on:{click:function(a){return t.toShowDialog(e.row)}}},[t._v("指定派发")]):t._e()],1)]}}])})],1),t._v(" "),a("lb-page",{attrs:{batch:!1,page:t.searchForm.list.page,pageSize:t.searchForm.list.limit,total:t.total.list},on:{handleSizeChange:function(e){return t.handleSizeChange(e,"list")},handleCurrentChange:function(e){return t.handleCurrentChange(e,"list")}}}),t._v(" "),a("el-dialog",{attrs:{title:"指定派发",visible:t.showDialog,width:"1000px",center:""},on:{"update:visible":function(e){t.showDialog=e}}},[a("lb-tips",[a("div",{staticClass:"flex-y-center"},[t._v("\n          卡券名称：\n          "),a("div",{staticClass:"c-link"},[t._v(t._s(t.cur_coupon.title))])]),t._v(" "),a("div",{staticClass:"flex-y-center"},[t._v("\n          使用条件：\n          "),a("div",{staticClass:"c-link"},[t._v("\n            "+t._s(0===t.cur_coupon.type?"消费满¥"+t.cur_coupon.full+"减¥"+t.cur_coupon.discount:"立减¥"+t.cur_coupon.discount)+"\n          ")])])]),t._v(" "),a("el-form",{ref:"userForm",attrs:{inline:!0,model:t.searchForm.user,"label-width":"70px"}},[a("el-form-item",{attrs:{label:"输入查询",prop:"nickName"}},[a("el-input",{attrs:{placeholder:"请输入用户昵称/手机号"},model:{value:t.searchForm.user.nickName,callback:function(e){t.$set(t.searchForm.user,"nickName",e)},expression:"searchForm.user.nickName"}})],1),t._v(" "),a("el-form-item",[a("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",type:"primary",icon:"el-icon-search"},on:{click:function(e){return t.getTableDataList(1,"user")}}},[t._v(t._s(t.$t("action.search")))]),t._v(" "),a("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",icon:"el-icon-refresh-left"},on:{click:function(e){return t.resetForm("user")}}},[t._v(t._s(t.$t("action.reset")))])],1)],1),t._v(" "),a("el-table",{ref:"multipleTable",staticStyle:{width:"100%"},attrs:{data:t.tableData.user,"header-cell-style":{background:"#f5f7fa",color:"#606266"},"tooltip-effect":"dark"},on:{"selection-change":t.handleSelectionChange}},[a("el-table-column",{attrs:{type:"selection",width:"55"}}),t._v(" "),a("el-table-column",{attrs:{prop:"id",width:"100",label:"用户ID"}}),t._v(" "),a("el-table-column",{attrs:{prop:"nickName",label:"用户昵称"}}),t._v(" "),a("el-table-column",{attrs:{prop:"avatarUrl",width:"150",label:"用户头像"},scopedSlots:t._u([{key:"default",fn:function(t){return[a("lb-image",{attrs:{src:t.row.avatarUrl}})]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"phone",label:"手机号"}}),a("el-table-column",{attrs:{prop:"num",label:"卡券数量",width:"220"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-input-number",{staticClass:"lb-input-number mini",attrs:{controls:!1,min:1,precision:0,placeholder:"请输入卡券数量"},model:{value:e.row.num,callback:function(a){t.$set(e.row,"num",a)},expression:"scope.row.num"}})]}}])})],1),t._v(" "),a("lb-page",{attrs:{batch:!1,page:t.searchForm.user.page,pageSize:t.searchForm.user.limit,total:t.total.user},on:{handleSizeChange:function(e){return t.handleSizeChange(e,"user")},handleCurrentChange:function(e){return t.handleCurrentChange(e,"user")}}}),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.showDialog=!1}}},[t._v("取 消")]),t._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:t.handleDialogConfirm}},[t._v("确 定")])],1)],1)],1)],1)},staticRenderFns:[]};var d=a("VU/8")(p,m,!1,function(t){a("uzNp")},"data-v-ccecfafa",null);e.default=d.exports},uzNp:function(t,e){}});