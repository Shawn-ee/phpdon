webpackJsonp([33],{OT9E:function(t,o,e){"use strict";Object.defineProperty(o,"__esModule",{value:!0});var c=e("mvHQ"),r=e.n(c),i=e("Xxa5"),n=e.n(i),s=e("exGp"),l=e.n(s),a={data:function(){return{default_img:"https://lbqny.migugu.com/admin/anmo/mine/bg.png",colorList:["#739bc6","#60a06a","#d4b64c","#c09e51","#d5964b","#c26a51","#ffb6b1","#b0b4c7","#616570"],color:{service_btn_color:"",service_font_color:"",user_font_color:"",coach_font_color:""},ind:{service_btn_color:0,service_font_color:0,user_font_color:0,coach_font_color:0},subForm:{service_btn_color:"",service_font_color:"",user_font_color:"",user_image:[],coach_font_color:"",coach_image:[]},subFormRules:{service_btn_color:{required:!0,type:"string",message:"请选择按钮颜色",trigger:"blur"},service_font_color:{required:!0,type:"string",message:"请选择文字颜色",trigger:"blur"},user_font_color:{required:!0,type:"string",message:"请选择文字颜色",trigger:"blur"},user_image:{required:!0,type:"array",message:"请选择背景图",trigger:"blur"},coach_font_color:{required:!0,type:"string",message:"请选择文字颜色",trigger:"blur"},coach_image:{required:!0,type:"array",message:"请选择背景图",trigger:"blur"}}}},created:function(){this.getFormInfo()},methods:{getFormInfo:function(){var t=this;return l()(n.a.mark(function o(){var e,c,r,i,s,l,a,_,f,u,v,m,d,g;return n.a.wrap(function(o){for(;;)switch(o.prev=o.next){case 0:return o.next=2,t.$api.system.configInfo();case 2:if(e=o.sent,c=e.code,r=e.data,200===c){o.next=7;break}return o.abrupt("return");case 7:for(g in i=r.service_btn_color,s=r.service_font_color,l=r.user_font_color,a=r.coach_font_color,_=r.user_image,f=r.coach_image,r.service_btn_color=i||"#282B34",r.service_font_color=s||"#EBDDB1",r.user_font_color=l||"#ffffff",r.coach_font_color=a||"#ffffff",r.user_image=[{url:_||t.default_img}],r.coach_image=[{url:f||t.default_img}],u=t.colorList.findIndex(function(t){return t===r.service_btn_color}),v=t.colorList.findIndex(function(t){return t===r.service_font_color}),m=t.colorList.findIndex(function(t){return t===r.user_font_color}),d=t.colorList.findIndex(function(t){return t===r.coach_font_color}),-1===u&&(u=9),-1===v&&(v=9),-1===m&&(m=9),-1===d&&(d=9),t.ind.service_btn_color=u,t.ind.service_font_color=v,t.ind.user_font_color=m,t.ind.coach_font_color=d,t.color.service_btn_color=r.service_btn_color,t.color.service_font_color=r.service_font_color,t.color.user_font_color=r.user_font_color,t.color.coach_font_color=r.coach_font_color,t.subForm)t.subForm[g]=r[g];case 31:case"end":return o.stop()}},o,t)}))()},getCover:function(t,o){this.subForm[o]=t},changeIndex:function(t,o){var e=this;return l()(n.a.mark(function c(){return n.a.wrap(function(c){for(;;)switch(c.prev=c.next){case 0:e.ind[o]=t,e.subForm[o]=e.colorList[t];case 2:case"end":return c.stop()}},c,e)}))()},changeColor:function(t,o){this.subForm[o]=t},toReset:function(t){if("service"===t)return this.ind[t+"_btn_color"]=9,this.ind[t+"_font_color"]=9,this.color[t+"_btn_color"]="#282B34",this.color[t+"_font_color"]="#EBDDB1",this.subForm[t+"_btn_color"]="#282B34",this.subForm[t+"_font_color"]="#EBDDB1",void this.submitForm();this.ind[t+"_font_color"]=9,this.color[t+"_font_color"]="#ffffff",this.subForm[t+"_font_color"]="#ffffff",this.subForm[t+"_image"]=[{url:this.default_img}],this.submitForm()},submitForm:function(){var t=this;this.$refs.subForm.validate(function(o){if(o){var e=JSON.parse(r()(t.subForm));e.user_image=e.user_image[0].url,e.coach_image=e.coach_image[0].url,t.$api.system.configUpdate(e).then(function(o){200===o.code&&t.$message.success(t.$t("tips.successSub"))})}})}}},_={render:function(){var t=this,o=t.$createElement,e=t._self._c||o;return e("div",{staticClass:"lb-system-wechat"},[e("top-nav"),t._v(" "),e("div",{staticClass:"page-main"},[e("el-form",{ref:"subForm",staticClass:"config-form",attrs:{model:t.subForm,rules:t.subFormRules,"label-width":"150px"},nativeOn:{submit:function(t){t.preventDefault()}}},[e("lb-classify-title",{attrs:{title:"技师页面 - 可服务按钮"}}),t._v(" "),e("el-form-item",{attrs:{label:"按钮颜色",prop:"service_btn_color"}},[e("div",{staticClass:"flex-warp"},[e("div",{staticClass:"flex-warp mt-sm"},t._l(t.colorList,function(o,c){return e("div",{key:c},[e("div",{staticClass:"color-item",class:[{active:c===t.ind.service_btn_color}],on:{click:function(o){return t.changeIndex(c,"service_btn_color")}}},[e("div",{staticClass:"flex-center"},[e("div",{staticClass:"primaryColor flex-center"},[e("div",{staticClass:"color-bg",style:{background:o}})])]),t._v(" "),c===t.ind.service_btn_color?e("i",{staticClass:"iconfont icon-xuanze-fill flex-center"}):t._e()])])}),0),t._v(" "),e("div",{staticClass:"color-item mt-sm",class:[{active:9===t.ind.service_btn_color}],staticStyle:{width:"auto",padding:"0 2px"},on:{click:function(o){return t.changeIndex(9,"service_btn_color")}}},[e("div",{staticClass:"flex-center",staticStyle:{"margin-top":"4px"}},[e("el-color-picker",{staticStyle:{"margin-right":"4px"},attrs:{size:"mini"},on:{change:function(o){return t.changeColor(o,"service_btn_color")}},model:{value:t.color.service_btn_color,callback:function(o){t.$set(t.color,"service_btn_color",o)},expression:"color.service_btn_color"}})],1),t._v(" "),e("div",{staticClass:"flex-y-center",staticStyle:{height:"18px","margin-top":"4px"}},[e("div",{staticStyle:{"line-height":"18px","font-size":"10px"}},[t._v("自定义配色")]),t._v(" "),e("i",{staticClass:"iconfont icon-xuanze flex-center",class:[{"icon-xuanze-fill":9===t.ind.service_btn_color}],staticStyle:{margin:"0"}})])])])]),t._v(" "),e("el-form-item",{attrs:{label:"文字颜色",prop:"service_font_color"}},[e("div",{staticClass:"flex-warp"},[e("div",{staticClass:"flex-warp mt-sm"},t._l(t.colorList,function(o,c){return e("div",{key:c},[e("div",{staticClass:"color-item",class:[{active:c===t.ind.service_font_color}],on:{click:function(o){return t.changeIndex(c,"service_font_color")}}},[e("div",{staticClass:"flex-center"},[e("div",{staticClass:"primaryColor flex-center"},[e("div",{staticClass:"color-bg",style:{background:o}})])]),t._v(" "),c===t.ind.service_font_color?e("i",{staticClass:"iconfont icon-xuanze-fill flex-center"}):t._e()])])}),0),t._v(" "),e("div",{staticClass:"color-item mt-sm",class:[{active:9===t.ind.service_font_color}],staticStyle:{width:"auto",padding:"0 2px"},on:{click:function(o){return t.changeIndex(9,"service_font_color")}}},[e("div",{staticClass:"flex-center",staticStyle:{"margin-top":"4px"}},[e("el-color-picker",{staticStyle:{"margin-right":"4px"},attrs:{size:"mini"},on:{change:function(o){return t.changeColor(o,"service_font_color")}},model:{value:t.color.service_font_color,callback:function(o){t.$set(t.color,"service_font_color",o)},expression:"color.service_font_color"}})],1),t._v(" "),e("div",{staticClass:"flex-y-center",staticStyle:{height:"18px","margin-top":"4px"}},[e("div",{staticStyle:{"line-height":"18px","font-size":"10px"}},[t._v("自定义配色")]),t._v(" "),e("i",{staticClass:"iconfont icon-xuanze flex-center",class:[{"icon-xuanze-fill":9===t.ind.service_font_color}],staticStyle:{margin:"0"}})])])])]),t._v(" "),e("el-form-item",[e("lb-button",{attrs:{type:"danger",plain:""},on:{click:function(o){return t.toReset("service")}}},[t._v(t._s(t.$t("action.defaultSet")))])],1),t._v(" "),e("lb-classify-title",{attrs:{title:"个人中心 - 用户端"}}),t._v(" "),e("el-form-item",{attrs:{label:"背景图",prop:"user_image"}},[e("lb-cover",{attrs:{fileList:t.subForm.user_image},on:{selectedFiles:function(o){return t.getCover(o,"user_image")}}}),t._v(" "),e("lb-tool-tips",[t._v("图片建议尺寸：750 * 368")])],1),t._v(" "),e("el-form-item",{attrs:{label:"文字颜色",prop:"user_font_color"}},[e("div",{staticClass:"flex-warp"},[e("div",{staticClass:"flex-warp mt-sm"},t._l(t.colorList,function(o,c){return e("div",{key:c},[e("div",{staticClass:"color-item",class:[{active:c===t.ind.user_font_color}],on:{click:function(o){return t.changeIndex(c,"user_font_color")}}},[e("div",{staticClass:"flex-center"},[e("div",{staticClass:"primaryColor flex-center"},[e("div",{staticClass:"color-bg",style:{background:o}})])]),t._v(" "),c===t.ind.user_font_color?e("i",{staticClass:"iconfont icon-xuanze-fill flex-center"}):t._e()])])}),0),t._v(" "),e("div",{staticClass:"color-item mt-sm",class:[{active:9===t.ind.user_font_color}],staticStyle:{width:"auto",padding:"0 2px"},on:{click:function(o){return t.changeIndex(9,"user_font_color")}}},[e("div",{staticClass:"flex-center",staticStyle:{"margin-top":"4px"}},[e("el-color-picker",{staticStyle:{"margin-right":"4px"},attrs:{size:"mini"},on:{change:function(o){return t.changeColor(o,"user_font_color")}},model:{value:t.color.user_font_color,callback:function(o){t.$set(t.color,"user_font_color",o)},expression:"color.user_font_color"}})],1),t._v(" "),e("div",{staticClass:"flex-y-center",staticStyle:{height:"18px","margin-top":"4px"}},[e("div",{staticStyle:{"line-height":"18px","font-size":"10px"}},[t._v("自定义配色")]),t._v(" "),e("i",{staticClass:"iconfont icon-xuanze flex-center",class:[{"icon-xuanze-fill":9===t.ind.user_font_color}],staticStyle:{margin:"0"}})])])])]),t._v(" "),e("el-form-item",[e("lb-button",{attrs:{type:"danger",plain:""},on:{click:function(o){return t.toReset("user")}}},[t._v(t._s(t.$t("action.defaultSet")))])],1),t._v(" "),e("lb-classify-title",{attrs:{title:"个人中心 - 技师端"}}),t._v(" "),e("el-form-item",{attrs:{label:"背景图",prop:"coach_image"}},[e("lb-cover",{attrs:{fileList:t.subForm.coach_image},on:{selectedFiles:function(o){return t.getCover(o,"coach_image")}}}),t._v(" "),e("lb-tool-tips",[t._v("图片建议尺寸：750 * 368")])],1),t._v(" "),e("el-form-item",{attrs:{label:"文字颜色",prop:"coach_font_color"}},[e("div",{staticClass:"flex-warp"},[e("div",{staticClass:"flex-warp mt-sm"},t._l(t.colorList,function(o,c){return e("div",{key:c},[e("div",{staticClass:"color-item",class:[{active:c===t.ind.coach_font_color}],on:{click:function(o){return t.changeIndex(c,"coach_font_color")}}},[e("div",{staticClass:"flex-center"},[e("div",{staticClass:"primaryColor flex-center"},[e("div",{staticClass:"color-bg",style:{background:o}})])]),t._v(" "),c===t.ind.coach_font_color?e("i",{staticClass:"iconfont icon-xuanze-fill flex-center"}):t._e()])])}),0),t._v(" "),e("div",{staticClass:"color-item mt-sm",class:[{active:9===t.ind.coach_font_color}],staticStyle:{width:"auto",padding:"0 2px"},on:{click:function(o){return t.changeIndex(9,"coach_font_color")}}},[e("div",{staticClass:"flex-center",staticStyle:{"margin-top":"4px"}},[e("el-color-picker",{staticStyle:{"margin-right":"4px"},attrs:{size:"mini"},on:{change:function(o){return t.changeColor(o,"coach_font_color")}},model:{value:t.color.coach_font_color,callback:function(o){t.$set(t.color,"coach_font_color",o)},expression:"color.coach_font_color"}})],1),t._v(" "),e("div",{staticClass:"flex-y-center",staticStyle:{height:"18px","margin-top":"4px"}},[e("div",{staticStyle:{"line-height":"18px","font-size":"10px"}},[t._v("自定义配色")]),t._v(" "),e("i",{staticClass:"iconfont icon-xuanze flex-center",class:[{"icon-xuanze-fill":9===t.ind.coach_font_color}],staticStyle:{margin:"0"}})])])])]),t._v(" "),e("el-form-item",[e("lb-button",{attrs:{type:"danger",plain:""},on:{click:function(o){return t.toReset("coach")}}},[t._v(t._s(t.$t("action.defaultSet")))])],1),t._v(" "),e("el-form-item",[e("lb-button",{attrs:{type:"primary"},on:{click:t.submitForm}},[t._v(t._s(t.$t("action.submit")))])],1)],1)],1)],1)},staticRenderFns:[]};var f=e("VU/8")(a,_,!1,function(t){e("cKaQ")},"data-v-7fac97ca",null);o.default=f.exports},cKaQ:function(t,o){}});