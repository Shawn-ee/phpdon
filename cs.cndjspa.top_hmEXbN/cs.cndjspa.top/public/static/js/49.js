webpackJsonp([49],{EyI9:function(t,e,r){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=r("mvHQ"),a=r.n(s),o=r("Xxa5"),n=r.n(o),u=r("exGp"),i=r.n(u),l={data:function(){var t=this;return{subForm:{virtual_status:0,pool_key:""},subFormRules:{virtual_status:{required:!0,type:"number",message:"请选择是否开启虚拟号码",trigger:"blur"},pool_key:{required:!0,validator:function(e,r,s){1!==t.subForm.virtual_status||t.subForm.pool_key?s():s(new Error("请输入号码池"))},trigger:"blur"}}}},created:function(){var t=this;return i()(n.a.mark(function e(){return n.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.getDetail();case 2:case"end":return e.stop()}},e,t)}))()},methods:{getDetail:function(){var t=this;return i()(n.a.mark(function e(){var r,s,a,o;return n.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$api.system.virtualConfigInfo();case 2:if(r=e.sent,s=r.code,a=r.data,200===s){e.next=7;break}return e.abrupt("return");case 7:for(o in t.subForm)t.subForm[o]=a[o];case 8:case"end":return e.stop()}},e,t)}))()},submitFormInfo:function(t){var e=this;this.$refs[t].validate(function(t){if(t){var r=JSON.parse(a()(e.subForm));e.$api.system.virtualConfigUpdate(r).then(function(t){200===t.code&&e.$message.success(e.$t("tips.successSub"))})}})}}},c={render:function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"lb-group-news"},[r("top-nav"),t._v(" "),r("div",{staticClass:"page-main"},[r("lb-tips",[r("a",{staticClass:"c-paragraph",attrs:{href:"https://www.kancloud.cn/nora_123/shangmenyuyue/3100499",target:"_blank"}},[t._v("点击查看虚拟号码配置文档")])]),t._v(" "),r("el-form",{ref:"subForm",attrs:{model:t.subForm,rules:t.subFormRules,"label-width":"160px"},nativeOn:{submit:function(t){t.preventDefault()}}},[r("el-form-item",{attrs:{label:"是否开启虚拟号码",prop:"virtual_status"}},[r("el-radio-group",{model:{value:t.subForm.virtual_status,callback:function(e){t.$set(t.subForm,"virtual_status",e)},expression:"subForm.virtual_status"}},[r("el-radio",{attrs:{label:1}},[t._v(t._s(t.$t("action.ON")))]),t._v(" "),r("el-radio",{attrs:{label:0}},[t._v(t._s(t.$t("action.OFF")))])],1),t._v(" "),r("lb-tool-tips",[t._v("开启后，必须配置号码池,\n          用于手机端；订单信息里面的电话仅显示部分且拨打电话时显示虚拟号码")])],1),t._v(" "),1===t.subForm.virtual_status?r("el-form-item",{attrs:{label:"号码池",prop:"pool_key"}},[r("el-input",{attrs:{placeholder:"请输入号码池"},model:{value:t.subForm.pool_key,callback:function(e){t.$set(t.subForm,"pool_key",e)},expression:"subForm.pool_key"}}),t._v(" "),r("lb-tool-tips",[t._v("号码池, 请前往阿里云获取配置 ")])],1):t._e(),t._v(" "),r("el-form-item",[r("lb-button",{attrs:{type:"primary"},on:{click:function(e){return t.submitFormInfo("subForm")}}},[t._v(t._s(t.$t("action.submit")))])],1)],1)],1)],1)},staticRenderFns:[]};var m=r("VU/8")(l,c,!1,function(t){r("mgPs")},"data-v-68e53431",null);e.default=m.exports},mgPs:function(t,e){}});