webpackJsonp([64],{"9UY5":function(e,t){},y6lP:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=a("mvHQ"),s=a.n(r),c=a("Xxa5"),n=a.n(c),o=a("exGp"),i=a.n(o),m={data:function(){return{subForm:{dynamic_status:1,dynamic_check:1,dynamic_comment_check:1},subFormRules:{dynamic_status:{required:!0,type:"number",message:"请选择",trigger:"blur"},dynamic_check:{required:!0,type:"number",message:"请选择",trigger:"blur"},dynamic_comment_check:{required:!0,type:"number",message:"请选择",trigger:"blur"}}}},created:function(){this.getFormInfo()},methods:{getFormInfo:function(){var e=this;return i()(n.a.mark(function t(){var a,r,s,c;return n.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$api.system.configInfoSchedule();case 2:if(a=t.sent,r=a.code,s=a.data,200===r){t.next=7;break}return t.abrupt("return");case 7:for(c in e.subForm)e.subForm[c]=s[c];case 8:case"end":return t.stop()}},t,e)}))()},submitForm:function(){var e=this;this.$refs.subForm.validate(function(t){if(t){var a=JSON.parse(s()(e.subForm));e.$api.system.configUpdateSchedule(a).then(function(t){200===t.code&&e.$message.success(e.$t("tips.successSub"))})}})}}},u={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"lb-dynamic-set"},[a("top-nav"),e._v(" "),a("div",{staticClass:"page-main"},[a("el-form",{ref:"subForm",staticClass:"submit-form",attrs:{model:e.subForm,rules:e.subFormRules,"label-width":"150px"},nativeOn:{submit:function(e){e.preventDefault()}}},[a("el-form-item",{attrs:{label:"是否开启动态发布",prop:"dynamic_status"}},[a("el-radio-group",{model:{value:e.subForm.dynamic_status,callback:function(t){e.$set(e.subForm,"dynamic_status",t)},expression:"subForm.dynamic_status"}},[a("el-radio",{attrs:{label:1}},[e._v(e._s(e.$t("action.ON")))]),e._v(" "),a("el-radio",{attrs:{label:0}},[e._v(e._s(e.$t("action.OFF")))])],1),e._v(" "),a("lb-tool-tips",[e._v("关闭后，手机端将不再展示动态发布相关内容")])],1),e._v(" "),e.subForm.dynamic_status?a("block",[a("el-form-item",{attrs:{label:"动态审核方式",prop:"dynamic_check"}},[a("el-radio-group",{model:{value:e.subForm.dynamic_check,callback:function(t){e.$set(e.subForm,"dynamic_check",t)},expression:"subForm.dynamic_check"}},[a("el-radio",{attrs:{label:1}},[e._v("人工审核")]),e._v(" "),a("el-radio",{attrs:{label:2}},[e._v("自动审核")])],1)],1),e._v(" "),a("el-form-item",{attrs:{label:"评论审核方式",prop:"dynamic_comment_check"}},[a("el-radio-group",{model:{value:e.subForm.dynamic_comment_check,callback:function(t){e.$set(e.subForm,"dynamic_comment_check",t)},expression:"subForm.dynamic_comment_check"}},[a("el-radio",{attrs:{label:1}},[e._v("人工审核")]),e._v(" "),a("el-radio",{attrs:{label:2}},[e._v("自动审核")])],1)],1)],1):e._e(),e._v(" "),a("el-form-item",[a("lb-button",{attrs:{type:"primary"},on:{click:e.submitForm}},[e._v(e._s(e.$t("action.submit")))])],1)],1)],1)],1)},staticRenderFns:[]};var l=a("VU/8")(m,u,!1,function(e){a("9UY5")},"data-v-488d7a79",null);t.default=l.exports}});