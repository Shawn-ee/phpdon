webpackJsonp([67],{dHqH:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=a("Xxa5"),s=a.n(r),n=a("exGp"),o=a.n(n),i=a("PJh5"),l=a.n(i),c={data:function(){return{loading:!1,searchForm:{page:1,limit:10},tableData:[],total:0,addDialog:!1,dialogTitle:!0,subForm:{name:"",sort:0,id:0},subFormRules:{name:{required:!0,validator:this.$reg.isNotNull,text:"分类名",reg_type:2,trigger:"blur"}}}},activated:function(){this.getTableDataList()},methods:{handleSizeChange:function(t){this.searchForm.limit=t,this.handleCurrentChange(1)},handleCurrentChange:function(t){this.searchForm.page=t,this.getTableDataList()},setAddDialog:function(){this.subForm={name:"",sort:0},this.dialogTitle=!0,this.addDialog=!0},toShowApply:function(t){var e=this;return o()(s.a.mark(function a(){var r,n,o;return s.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:return a.next=2,e.$api.mall.editCarte({id:t});case 2:for(o in r=a.sent,n=r.data,e.subForm.id=0,e.subForm)e.subForm[o]=n[o];e.dialogTitle=!1,e.addDialog=!0;case 8:case"end":return a.stop()}},a,e)}))()},getTableDataList:function(t){var e=this;return o()(s.a.mark(function a(){var r,n,o,i;return s.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:return t&&(e.searchForm.page=1),e.loading=!0,r=e.searchForm,a.next=5,e.$api.mall.carteList(r);case 5:if(n=a.sent,o=n.code,i=n.data,e.loading=!1,200===o){a.next=11;break}return a.abrupt("return");case 11:e.tableData=i.data,e.total=i.total;case 13:case"end":return a.stop()}},a,e)}))()},confirmDel:function(t,e){var a=this;this.$confirm(this.$t("tips.confirmDelete"),this.$t("tips.reminder"),{confirmButtonText:this.$t("action.comfirm"),cancelButtonText:this.$t("action.cancel"),type:"warning"}).then(function(){a.updateItem(t,e)}).catch(function(){})},updateItem:function(t,e){var a=this;return o()(s.a.mark(function r(){return s.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:a.$api.mall.carteStatus({id:t,status:e}).then(function(t){if(200===t.code)a.$message.success(a.$t(-1===e?"tips.successDel":"tips.successOper")),-1===e&&(a.searchForm.page=a.searchForm.page<Math.ceil((a.total-1)/a.searchForm.limit)?a.searchForm.page:Math.ceil((a.total-1)/a.searchForm.limit),a.getTableDataList());else{if(-1===e)return;a.getTableDataList()}});case 1:case"end":return r.stop()}},r,a)}))()},submitFormInfo:function(){var t=this;return o()(s.a.mark(function e(){var a,r;return s.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(a=!0,t.$refs.subForm.validate(function(t){t||(a=!1)}),!a){e.next=13;break}return t.subForm.sort=t.subForm.sort||0,e.next=6,t.$api.mall[t.subForm.id?"editCartePost":"addCarte"](t.subForm);case 6:if(r=e.sent,200===r.code){e.next=10;break}return e.abrupt("return");case 10:t.$message.success(t.$t("tips.successSub")),t.addDialog=!1,t.getTableDataList();case 13:case"end":return e.stop()}},e,t)}))()}},filters:{handleTime:function(t,e){return 1===e?l()(1e3*t).format("YYYY-MM-DD"):2===e?l()(1e3*t).format("HH:mm:ss"):l()(1e3*t).format("YYYY-MM-DD HH:mm:ss")}}},u={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"lb-custom"},[a("top-nav"),t._v(" "),a("div",{staticClass:"page-main"},[a("el-row",{staticClass:"page-top-operate"},[a("lb-button",{attrs:{size:"medium",type:"primary",icon:"el-icon-plus"},on:{click:t.setAddDialog}},[t._v("添加分类")])],1),t._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticStyle:{width:"100%"},attrs:{data:t.tableData,"header-cell-style":{background:"#f5f7fa",color:"#606266"}}},[a("el-table-column",{attrs:{prop:"id",label:"ID"}}),t._v(" "),a("el-table-column",{attrs:{prop:"name",label:"分类名"}}),t._v(" "),a("el-table-column",{attrs:{prop:"status",label:"是否上架"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-switch",{attrs:{"active-value":1,"inactive-value":0},on:{change:function(a){return t.updateItem(e.row.id,e.row.status)}},model:{value:e.row.status,callback:function(a){t.$set(e.row,"status",a)},expression:"scope.row.status"}})]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"sort",label:"排序值"}}),t._v(" "),a("el-table-column",{attrs:{prop:"create_time",label:"创建时间"}}),t._v(" "),a("el-table-column",{attrs:{label:"操作","min-width":"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",{staticClass:"table-operate"},[a("lb-button",{attrs:{size:"mini",plain:"",type:"primary"},on:{click:function(a){return t.toShowApply(e.row.id)}}},[t._v(t._s(t.$t("action.edit")))]),t._v(" "),a("lb-button",{attrs:{size:"mini",plain:"",type:"danger"},on:{click:function(a){return t.confirmDel(e.row.id,-1)}}},[t._v(t._s(t.$t("action.delete")))])],1)]}}])})],1),t._v(" "),a("lb-page",{attrs:{batch:!1,page:t.searchForm.page,pageSize:t.searchForm.limit,total:t.total},on:{handleSizeChange:t.handleSizeChange,handleCurrentChange:t.handleCurrentChange}})],1),t._v(" "),a("el-dialog",{attrs:{title:t.dialogTitle?"添加分类":"编辑分类",visible:t.addDialog,width:"500px",center:""},on:{"update:visible":function(e){t.addDialog=e}}},[a("el-form",{ref:"subForm",staticClass:"dialog-form",attrs:{model:t.subForm,rules:t.subFormRules,"label-width":"100px"}},[a("el-form-item",{attrs:{label:"分类名",prop:"name"}},[a("el-input",{attrs:{maxlength:"10","show-word-limit":"",placeholder:"请输入分类名"},model:{value:t.subForm.name,callback:function(e){t.$set(t.subForm,"name",e)},expression:"subForm.name"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"排序值",prop:"sort"}},[a("el-input-number",{staticClass:"lb-input-number",attrs:{min:0,controls:!1,placeholder:"请输入排序值"},model:{value:t.subForm.sort,callback:function(e){t.$set(t.subForm,"sort",e)},expression:"subForm.sort"}}),t._v(" "),a("lb-tool-tips",[t._v("值越大, 排序越靠前")])],1)],1),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.addDialog=!1}}},[t._v("取 消")]),t._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:t.submitFormInfo}},[t._v("确 定")])],1)],1)],1)},staticRenderFns:[]};var m=a("VU/8")(c,u,!1,function(t){a("ua5t")},"data-v-4283fa46",null);e.default=m.exports},ua5t:function(t,e){}});