webpackJsonp([75],{Ncgt:function(e,t){},Wl5p:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=r("mvHQ"),s=r.n(a),i=r("Xxa5"),o=r.n(i),n=r("exGp"),l=r.n(n),u={data:function(){var e=this;return{navTitle:"",base_enroll:[],subForm:{id:0,title:"",text:"",is_form:0,field:[],top:0},subFormRules:{title:{required:!0,validator:this.$reg.isNotNull,text:"文章标题",reg_type:2,trigger:"blur"},text:{required:!0,type:"string",message:"请输入文章内容",trigger:"blur"},is_form:{required:!0,type:"number",message:"请选择是否关联表单",trigger:"blur"},field:{required:!0,validator:function(t,r,a){1===e.subForm.is_form&&0===r.length?a(new Error("请选择表单内容")):a()},trigger:"blur"},top:{required:!0,type:"number",message:"请输入排序值",trigger:"blur"}}}},created:function(){var e=this;return l()(o.a.mark(function t(){var r,a;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return r=e.$route.query.id,a=void 0===r?0:r,e.subForm.id=a,e.navTitle=e.$t(a?"menu.MarketArticleEdit":"menu.MarketArticleAdd"),t.next=5,e.getBaseInfo();case 5:if(a){t.next=7;break}return t.abrupt("return");case 7:e.getDetail();case 8:case"end":return t.stop()}},t,e)}))()},methods:{getBaseInfo:function(){var e=this;return l()(o.a.mark(function t(){var r,a,s;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$api.market.fieldSelect();case 2:if(r=t.sent,a=r.code,s=r.data,200===a){t.next=7;break}return t.abrupt("return");case 7:e.base_enroll=s;case 8:case"end":return t.stop()}},t,e)}))()},getDetail:function(){var e=this;return l()(o.a.mark(function t(){var r,a,s,i,n;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return r=e.subForm.id,t.next=3,e.$api.market.articleInfo({id:r});case 3:if(a=t.sent,s=a.code,i=a.data,200===s){t.next=8;break}return t.abrupt("return");case 8:for(n in e.subForm)e.subForm[n]=i[n];case 9:case"end":return t.stop()}},t,e)}))()},submitForm:function(){var e=this;this.$refs.subForm.validate(function(t){if(t){var r=JSON.parse(s()(e.subForm)),a=r.id?"articleUpdate":"articleAdd";e.$api.market[a](r).then(function(t){200===t.code&&(e.$message.success(e.$t(r.id?"tips.successRev":"tips.successSub")),e.$router.back(-1))})}})}}},c={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"lb-market-edit"},[r("top-nav",{attrs:{title:e.navTitle,isBack:!0}}),e._v(" "),r("div",{staticClass:"page-main"},[r("el-form",{ref:"subForm",attrs:{model:e.subForm,rules:e.subFormRules,"label-width":"120px"},nativeOn:{submit:function(e){e.preventDefault()}}},[r("el-form-item",{attrs:{label:"文章标题",prop:"title"}},[r("el-input",{attrs:{maxlength:"20","show-word-limit":"",placeholder:"请输入文章标题"},model:{value:e.subForm.title,callback:function(t){e.$set(e.subForm,"title",t)},expression:"subForm.title"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"文章内容",prop:"text"}},[r("lb-ueditor",{attrs:{destroy:!0},model:{value:e.subForm.text,callback:function(t){e.$set(e.subForm,"text",t)},expression:"subForm.text"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"是否关联表单",prop:"is_form"}},[r("el-radio-group",{model:{value:e.subForm.is_form,callback:function(t){e.$set(e.subForm,"is_form",t)},expression:"subForm.is_form"}},[r("el-radio",{attrs:{label:1}},[e._v("是")]),e._v(" "),r("el-radio",{attrs:{label:0}},[e._v("否")])],1)],1),e._v(" "),e.subForm.is_form?r("el-form-item",{attrs:{label:"表单内容",prop:"field"}},[r("el-select",{attrs:{multiple:"","collapse-tags":"",placeholder:"请选择"},model:{value:e.subForm.field,callback:function(t){e.$set(e.subForm,"field",t)},expression:"subForm.field"}},e._l(e.base_enroll,function(e){return r("el-option",{key:e.id,attrs:{label:e.title,value:e.id}})}),1)],1):e._e(),e._v(" "),r("el-form-item",{attrs:{label:"排序值",prop:"top"}},[r("el-input-number",{staticClass:"lb-input-number",attrs:{min:0,controls:!1,placeholder:"请输入排序值"},model:{value:e.subForm.top,callback:function(t){e.$set(e.subForm,"top",t)},expression:"subForm.top"}}),e._v(" "),r("lb-tool-tips",[e._v("值越大, 排序越靠前")])],1),e._v(" "),r("el-form-item",[r("lb-button",{attrs:{type:"primary"},on:{click:e.submitForm}},[e._v(e._s(e.$t("action.submit")))]),e._v(" "),r("lb-button",{on:{click:function(t){return e.$router.back(-1)}}},[e._v(e._s(e.$t("action.back")))])],1)],1)],1)],1)},staticRenderFns:[]};var m=r("VU/8")(u,c,!1,function(e){r("Ncgt")},"data-v-22d2a349",null);t.default=m.exports}});