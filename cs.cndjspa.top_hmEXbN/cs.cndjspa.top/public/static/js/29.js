webpackJsonp([29],{"3v7X":function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=a("Xxa5"),n=a.n(r),s=a("exGp"),i=a.n(s),o=a("PJh5"),l=a.n(o),c={data:function(){return{statusOptions:[],loading:!1,searchForm:{page:1,limit:10,name:"",carte:0},tableData:[],total:0}},activated:function(){this.goodsCarteListCall(),this.getTableDataList()},methods:{resetForm:function(t){this.$refs[t].resetFields(),this.getTableDataList(1)},handleSizeChange:function(t){this.searchForm.limit=t,this.handleCurrentChange(1)},handleCurrentChange:function(t){this.searchForm.page=t,this.getTableDataList()},goodsCarteListCall:function(){var t=this;return i()(n.a.mark(function e(){var a,r,s;return n.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$api.mall.goodsCarteList();case 2:if(a=e.sent,r=a.code,s=a.data,200===r){e.next=7;break}return e.abrupt("return");case 7:t.statusOptions=s,t.statusOptions.unshift({id:0,name:"全部"});case 9:case"end":return e.stop()}},e,t)}))()},getTableDataList:function(t){var e=this;return i()(n.a.mark(function a(){var r,s,i,o;return n.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:return t&&(e.searchForm.page=1),e.loading=!0,r=e.searchForm,a.next=5,e.$api.mall.goodsList(r);case 5:if(s=a.sent,i=s.code,o=s.data,e.loading=!1,200===i){a.next=11;break}return a.abrupt("return");case 11:e.tableData=o.data,e.total=o.total;case 13:case"end":return a.stop()}},a,e)}))()},confirmDel:function(t,e){var a=this;this.$confirm(this.$t("tips.confirmDelete"),this.$t("tips.reminder"),{confirmButtonText:this.$t("action.comfirm"),cancelButtonText:this.$t("action.cancel"),type:"warning"}).then(function(){a.updateItem(t,e)}).catch(function(){})},updateItem:function(t,e){var a=this;return i()(n.a.mark(function r(){return n.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:a.$api.mall.goodsStatus({id:t,status:e}).then(function(t){if(200===t.code)a.$message.success(a.$t(-1===e?"tips.successDel":"tips.successOper")),-1===e&&(a.searchForm.page=a.searchForm.page<Math.ceil((a.total-1)/a.searchForm.limit)?a.searchForm.page:Math.ceil((a.total-1)/a.searchForm.limit),a.getTableDataList());else{if(-1===e)return;a.getTableDataList()}});case 1:case"end":return r.stop()}},r,a)}))()}},filters:{handleTime:function(t,e){return 1===e?l()(1e3*t).format("YYYY-MM-DD"):2===e?l()(1e3*t).format("HH:mm:ss"):l()(1e3*t).format("YYYY-MM-DD HH:mm:ss")}}},u={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"lb-custom"},[a("top-nav"),t._v(" "),a("div",{staticClass:"page-main"},[a("el-row",{staticClass:"page-search-form"},[a("el-form",{ref:"searchForm",attrs:{inline:!0,model:t.searchForm},nativeOn:{submit:function(t){t.preventDefault()}}},[a("el-form-item",{attrs:{label:"分类",prop:"carte"}},[a("el-select",{attrs:{placeholder:"请选择"},on:{change:function(e){return t.getTableDataList(1)}},model:{value:t.searchForm.carte,callback:function(e){t.$set(t.searchForm,"carte",e)},expression:"searchForm.carte"}},t._l(t.statusOptions,function(t){return a("el-option",{key:t.id,attrs:{label:t.name,value:t.id}})}),1)],1),t._v(" "),a("el-form-item",{attrs:{label:"商品名称",prop:"name"}},[a("el-input",{attrs:{placeholder:"请输入商品名称"},model:{value:t.searchForm.name,callback:function(e){t.$set(t.searchForm,"name",e)},expression:"searchForm.name"}})],1),t._v(" "),a("el-form-item",[a("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",type:"primary",icon:"el-icon-search"},on:{click:function(e){return t.getTableDataList(1)}}},[t._v(t._s(t.$t("action.search")))]),t._v(" "),a("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",icon:"el-icon-refresh-left"},on:{click:function(e){return t.resetForm("searchForm")}}},[t._v(t._s(t.$t("action.reset")))])],1)],1)],1),t._v(" "),a("el-row",{staticClass:"page-top-operate"},[a("lb-button",{attrs:{size:"medium",type:"primary",icon:"el-icon-plus"},on:{click:function(e){return t.$router.push("/mall/edit")}}},[t._v("添加商品")])],1),t._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticStyle:{width:"100%"},attrs:{data:t.tableData,"header-cell-style":{background:"#f5f7fa",color:"#606266"}}},[a("el-table-column",{attrs:{prop:"cover",label:"商品图"},scopedSlots:t._u([{key:"default",fn:function(t){return[a("lb-image",{attrs:{src:t.row.cover}})]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"name",label:"商品名称"}}),t._v(" "),a("el-table-column",{attrs:{prop:"carte",label:"所属分类"}}),t._v(" "),a("el-table-column",{attrs:{prop:"price",label:"商品价格"}}),t._v(" "),a("el-table-column",{attrs:{prop:"status",label:"是否上架"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-switch",{attrs:{"active-value":1,"inactive-value":0},on:{change:function(a){return t.updateItem(e.row.id,e.row.status)}},model:{value:e.row.status,callback:function(a){t.$set(e.row,"status",a)},expression:"scope.row.status"}})]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"sort",label:"排序值"}}),t._v(" "),a("el-table-column",{attrs:{prop:"create_time",label:"创建时间","min-width":"160"}}),t._v(" "),a("el-table-column",{attrs:{label:"操作","min-width":"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",{staticClass:"table-operate"},[a("lb-button",{attrs:{size:"mini",plain:"",type:"primary"},on:{click:function(a){return t.$router.push("/mall/edit?id="+e.row.id)}}},[t._v(t._s(t.$t("action.edit")))]),t._v(" "),a("lb-button",{attrs:{size:"mini",plain:"",type:"danger"},on:{click:function(a){return t.confirmDel(e.row.id,-1)}}},[t._v(t._s(t.$t("action.delete")))])],1)]}}])})],1),t._v(" "),a("lb-page",{attrs:{batch:!1,page:t.searchForm.page,pageSize:t.searchForm.limit,total:t.total},on:{handleSizeChange:t.handleSizeChange,handleCurrentChange:t.handleCurrentChange}})],1)],1)},staticRenderFns:[]};var m=a("VU/8")(c,u,!1,function(t){a("9fYp")},"data-v-c3623a0c",null);e.default=m.exports},"9fYp":function(t,e){}});