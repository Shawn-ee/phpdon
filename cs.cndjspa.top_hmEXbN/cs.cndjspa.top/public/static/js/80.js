webpackJsonp([80],{"7Rtn":function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=a("mvHQ"),s=a.n(r),n=a("Dd8w"),i=a.n(n),o=a("Xxa5"),l=a.n(o),c=a("exGp"),u=a.n(c),m=a("PJh5"),d=a.n(m),p=a("NYxO"),f={data:function(){var e=this;return{username:window.sessionStorage.getItem("ms_username"),loading:!1,searchForm:{page:1,limit:10,title:"",type:0},tableData:[],total:0,showDialog:!1,subForm:{id:0,username:"",passwd:"",is_admin:0,role:[]},subFormRules:{username:{required:!0,validator:this.$reg.isNotNull,text:"账号",reg_type:2,trigger:"blur"},passwd:{required:!0,validator:function(e,t,a){t?/^(\S){6,20}$/.test(t)?a():a(new Error("请输入6-20位非空白符的字符!")):a(new Error("请输入"+e.text))},text:"密码",trigger:"blur"},role:{required:!0,validator:function(t,a,r){1===e.subForm.is_admin?r():0===a.length?r(new Error("请选择所属角色")):r()},trigger:"change"}}}},activated:function(){var e=this;return u()(l.a.mark(function t(){return l.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.getBaseInfo();case 2:e.getTableDataList(1);case 3:case"end":return t.stop()}},t,e)}))()},methods:i()({},Object(p.c)(["changeRoutesItem"]),{getBaseInfo:function(){var e=this;return u()(l.a.mark(function t(){var a,r,s;return l.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$api.account.roleSelect();case 2:if(a=t.sent,r=a.code,s=a.data,200===r){t.next=7;break}return t.abrupt("return");case 7:e.roleList=s;case 8:case"end":return t.stop()}},t,e)}))()},resetForm:function(e){this.$refs[e].resetFields(),this.getTableDataList(1)},handleSizeChange:function(e){this.searchForm.limit=e,this.handleCurrentChange(1)},handleCurrentChange:function(e){this.searchForm.page=e,this.getTableDataList()},getTableDataList:function(e){var t=this;return u()(l.a.mark(function a(){var r,s,n;return l.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:return e&&(t.searchForm.page=1),t.loading=!0,a.next=4,t.$api.account.adminList(t.searchForm);case 4:if(r=a.sent,s=r.code,n=r.data,t.loading=!1,200===s){a.next=10;break}return a.abrupt("return");case 10:t.tableData=n.data,t.total=n.total;case 12:case"end":return a.stop()}},a,t)}))()},confirmDel:function(e){var t=this;this.$confirm(this.$t("tips.confirmDelete"),this.$t("tips.reminder"),{confirmButtonText:this.$t("action.comfirm"),cancelButtonText:this.$t("action.cancel"),type:"warning"}).then(function(){t.updateItem(e,-1)}).catch(function(){})},updateItem:function(e,t){var a=this;return u()(l.a.mark(function r(){return l.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:a.$api.account.adminUpdate({id:e,status:t}).then(function(e){if(200===e.code)a.$message.success(a.$t(-1===t?"tips.successDel":"tips.successOper")),-1===t&&(a.searchForm.page=a.searchForm.page<Math.ceil((a.total-1)/a.searchForm.limit)?a.searchForm.page:Math.ceil((a.total-1)/a.searchForm.limit),a.getTableDataList());else{if(-1===t)return;a.getTableDataList()}});case 1:case"end":return r.stop()}},r,a)}))()},toShowDialog:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{is_admin:0,role:[]};return u()(l.a.mark(function a(){var r,s,n,i,o,c,u;return l.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:if(r=t.id,!(s=void 0===r?0:r)){a.next=12;break}return a.next=4,e.$api.account.adminInfo({id:s});case 4:n=a.sent,i=n.data,o=i.role,c=o.map(function(e){return e.id}),i.passwd=i.o_passwd,i.role_info=o,i.role=c,t=i;case 12:for(u in e.subForm)e.subForm[u]=t[u];e.showDialog=!e.showDialog;case 14:case"end":return a.stop()}},a,e)}))()},submitFormInfo:function(){var e=this;return u()(l.a.mark(function t(){var a,r,n,i;return l.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(a=!0,e.$refs.subForm.validate(function(e){e||(a=!1)}),!a){t.next=23;break}return r=e.subForm.id?"adminUpdate":"adminAdd",delete(n=JSON.parse(s()(e.subForm))).is_admin,n.passwd||delete n.passwd,t.next=9,e.$api.account[r](n);case 9:if(i=t.sent,200===i.code){t.next=13;break}return t.abrupt("return");case 13:if(e.$message.success(e.$t(n.id?"tips.successRev":"tips.successSub")),e.showDialog=!1,e.username!==n.username){t.next=22;break}return e.changeRoutesItem({key:"isAuth",val:!1}),sessionStorage.removeItem("minitk"),sessionStorage.removeItem("ms_username"),e.$router.push("/login"),window.location.reload(),t.abrupt("return");case 22:e.getTableDataList();case 23:case"end":return t.stop()}},t,e)}))()}}),filters:{handleTime:function(e,t){return 1===t?d()(1e3*e).format("YYYY-MM-DD"):2===t?d()(1e3*e).format("HH:mm:ss"):d()(1e3*e).format("YYYY-MM-DD HH:mm:ss")}}},h={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"lb-system-news"},[a("top-nav"),e._v(" "),a("div",{staticClass:"page-main"},[a("lb-button",{directives:[{name:"hasPermi",rawName:"v-hasPermi",value:e.$route.name+"-add",expression:"`${$route.name}-add`"}],attrs:{type:"primary",icon:"el-icon-plus"},on:{click:e.toShowDialog}},[e._v(e._s(e.$t("menu.AccountAdd")))]),e._v(" "),a("div",{staticClass:"space-lg"}),e._v(" "),a("el-row",{staticClass:"page-search-form"},[a("el-form",{ref:"searchForm",attrs:{inline:!0,model:e.searchForm},nativeOn:{submit:function(e){e.preventDefault()}}},[a("el-form-item",{attrs:{label:"账号",prop:"title"}},[a("el-input",{attrs:{placeholder:"请输入账号"},model:{value:e.searchForm.title,callback:function(t){e.$set(e.searchForm,"title",t)},expression:"searchForm.title"}})],1),e._v(" "),a("el-form-item",[a("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",type:"primary",icon:"el-icon-search"},on:{click:function(t){return e.getTableDataList(1)}}},[e._v(e._s(e.$t("action.search")))]),e._v(" "),a("lb-button",{staticStyle:{"margin-right":"5px"},attrs:{size:"medium",icon:"el-icon-refresh-left"},on:{click:function(t){return e.resetForm("searchForm")}}},[e._v(e._s(e.$t("action.reset")))])],1)],1)],1),e._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticStyle:{width:"100%"},attrs:{data:e.tableData,"header-cell-style":{background:"#f5f7fa",color:"#606266"}}},[a("el-table-column",{attrs:{prop:"id",label:"ID"}}),e._v(" "),a("el-table-column",{attrs:{prop:"username",label:"账号"}}),e._v(" "),a("el-table-column",{attrs:{prop:"o_passwd",label:"密码"}}),e._v(" "),a("el-table-column",{attrs:{prop:"create_time",label:"创建时间"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("p",[e._v(e._s(e._f("handleTime")(t.row.create_time,1)))]),e._v(" "),a("p",[e._v(e._s(e._f("handleTime")(t.row.create_time,2)))])]}}])}),e._v(" "),a("el-table-column",{attrs:{"min-width":"120",label:"操作"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("div",{staticClass:"table-operate"},[a("lb-button",{directives:[{name:"hasPermi",rawName:"v-hasPermi",value:e.$route.name+"-edit",expression:"`${$route.name}-edit`"}],attrs:{size:"mini",plain:"",type:"primary"},on:{click:function(a){return e.toShowDialog(t.row)}}},[e._v(e._s(e.$t("action.edit")))]),e._v(" "),a("lb-button",{directives:[{name:"hasPermi",rawName:"v-hasPermi",value:e.$route.name+"-delete",expression:"`${$route.name}-delete`"},{name:"show",rawName:"v-show",value:0===t.row.is_admin,expression:"scope.row.is_admin === 0"}],attrs:{size:"mini",plain:"",type:"danger"},on:{click:function(a){return e.confirmDel(t.row.id)}}},[e._v(e._s(e.$t("action.delete")))])],1)]}}])})],1),e._v(" "),a("lb-page",{attrs:{batch:!1,page:e.searchForm.page,pageSize:e.searchForm.limit,total:e.total},on:{handleSizeChange:e.handleSizeChange,handleCurrentChange:e.handleCurrentChange}}),e._v(" "),a("el-dialog",{attrs:{title:e.$t(e.subForm.id?"menu.AccountEdit":"menu.AccountAdd"),visible:e.showDialog,width:"500px",center:""},on:{"update:visible":function(t){e.showDialog=t}}},[a("el-form",{ref:"subForm",staticClass:"dialog-form",attrs:{model:e.subForm,rules:e.subFormRules,"label-width":"100px"}},[a("el-form-item",{attrs:{label:"账号",prop:"username"}},[a("el-input",{attrs:{disabled:1===e.subForm.is_admin,placeholder:"请输入账号"},model:{value:e.subForm.username,callback:function(t){e.$set(e.subForm,"username",t)},expression:"subForm.username"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"密码",prop:"passwd"}},[a("el-input",{attrs:{placeholder:"请输入密码"},model:{value:e.subForm.passwd,callback:function(t){e.$set(e.subForm,"passwd",t)},expression:"subForm.passwd"}})],1),e._v(" "),0===e.subForm.is_admin?a("el-form-item",{attrs:{label:"所属角色",prop:"role"}},[a("el-select",{attrs:{multiple:"","collapse-tags":"",clearable:"",placeholder:"请选择"},model:{value:e.subForm.role,callback:function(t){e.$set(e.subForm,"role",t)},expression:"subForm.role"}},e._l(e.roleList,function(e){return a("el-option",{key:e.id,attrs:{label:e.title,value:e.id}})}),1)],1):e._e()],1),e._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(t){e.showDialog=!1}}},[e._v("取 消")]),e._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:e.submitFormInfo}},[e._v("确 定")])],1)],1)],1)],1)},staticRenderFns:[]};var b=a("VU/8")(f,h,!1,function(e){a("Wr2i")},"data-v-1c7a4ffa",null);t.default=b.exports},Wr2i:function(e,t){}});