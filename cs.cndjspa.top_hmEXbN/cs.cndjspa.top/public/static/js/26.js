webpackJsonp([26],{"/wvk":function(e,r){},"H+zg":function(e,r,t){"use strict";Object.defineProperty(r,"__esModule",{value:!0});var o=t("Xxa5"),s=t.n(o),n=t("exGp"),a=t.n(n),i={data:function(){return{subForm:{record_type:"",record_no:""},subFormRules:{record_type:{required:!0,type:"number",message:"请选择备案类型",trigger:"blur"},record_no:{required:!0,validator:this.$reg.isNotNull,text:"备案号",reg_type:2,trigger:"blur"}}}},created:function(){this.getFormInfo()},methods:{getFormInfo:function(){var e=this;return a()(s.a.mark(function r(){var t,o,n,a;return s.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,e.$api.system.configInfo();case 2:if(t=r.sent,o=t.code,n=t.data,200===o){r.next=7;break}return r.abrupt("return");case 7:for(a in e.subForm)e.subForm[a]=n[a];case 8:case"end":return r.stop()}},r,e)}))()},submitForm:function(){var e=this;this.$refs.subForm.validate(function(r){if(r){var t=e.subForm;t.record_type=t.record_no&&t.record_no.includes("公网安备")?2:1,e.$api.system.configUpdate(t).then(function(r){200===r.code&&e.$message.success(e.$t("tips.successSub"))})}})}}},c={render:function(){var e=this,r=e.$createElement,t=e._self._c||r;return t("div",{staticClass:"lb-system-wechat"},[t("top-nav"),e._v(" "),t("div",{staticClass:"page-main"},[t("lb-tips",[e._v("备案信息将展示在登录页面")]),e._v(" "),t("el-form",{ref:"subForm",staticClass:"config-form",attrs:{model:e.subForm,rules:e.subFormRules,"label-width":"140px"},nativeOn:{submit:function(e){e.preventDefault()}}},[t("el-form-item",{attrs:{label:"备案类型",prop:"record_type"}},[t("el-radio-group",{model:{value:e.subForm.record_type,callback:function(r){e.$set(e.subForm,"record_type",r)},expression:"subForm.record_type"}},[t("el-radio",{attrs:{label:1}},[e._v("ICP备案/许可证号")]),e._v(" "),t("el-radio",{attrs:{label:2}},[e._v("网站联网备案号")])],1),e._v(" "),t("lb-tool-tips",[e._v("用于登录页面展示，以百度备案号为例：\n          "),t("div",{staticClass:"mt-sm"},[e._v("ICP备案/许可证号：京ICP证030173号")]),e._v(" "),t("div",{staticClass:"mt-sm"},[e._v("网站联网备案号：京公网安备 11000002000001号")])])],1),e._v(" "),t("el-form-item",{attrs:{label:"备案号",prop:"record_no"}},[t("el-input",{attrs:{maxlength:"50","show-word-limit":"",placeholder:"请输入备案号"},model:{value:e.subForm.record_no,callback:function(r){e.$set(e.subForm,"record_no",r)},expression:"subForm.record_no"}})],1),e._v(" "),t("el-form-item",[t("lb-button",{attrs:{type:"primary"},on:{click:e.submitForm}},[e._v(e._s(e.$t("action.submit")))])],1)],1)],1)],1)},staticRenderFns:[]};var u=t("VU/8")(i,c,!1,function(e){t("/wvk")},"data-v-e2b8099c",null);r.default=u.exports}});