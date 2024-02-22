webpackJsonp([84],{"M+bL":function(e,n,t){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var u=t("Xxa5"),i=t.n(u),r=t("exGp"),s=t.n(r),a={data:function(){return{options:[{value:0,label:"本地上传"},{value:2,label:"七牛云上传"},{value:1,label:"阿里云OSS上传"},{value:3,label:"腾讯云上传"}],baseForm:{id:""},baseFormRules:{},open_oss:0,qiniuyunForm:{qiniu_accesskey:"",qiniu_secretkey:"",qiniu_bucket:"",qiniu_yuming:""},qiniuyunFormRules:{qiniu_accesskey:{required:!0,type:"string",message:"请输入AccessKey",trigger:"blur"},qiniu_secretkey:{required:!0,type:"string",message:"请输入SecretKey",trigger:"blur"},qiniu_bucket:{required:!0,type:"string",message:"请输入仓库名称",trigger:"blur"},qiniu_yuming:{required:!0,type:"string",message:"请输入自定义域名",trigger:"blur"}},aliyunForm:{aliyun_bucket:"",aliyun_access_key_id:"",aliyun_access_key_secret:"",aliyun_base_dir:"",aliyun_zidinyi_yuming:"",aliyun_endpoint:""},aliyunFormRules:{aliyun_bucket:{required:!0,type:"string",message:"请输入仓库名称",trigger:"blur"},aliyun_access_key_id:{required:!0,type:"string",message:"请输入AccessKeyId",trigger:"blur"},aliyun_access_key_secret:{required:!0,type:"string",message:"请输入AccessKeySecret",trigger:"blur"},aliyun_base_dir:{required:!0,type:"string",message:"请输入上传根目录",trigger:"blur"},aliyun_zidinyi_yuming:{required:!0,type:"string",message:"请输入自定义域名",trigger:"blur"},aliyun_endpoint:{required:!0,type:"string",message:"请输入Endpoint",trigger:"blur"}},tengxunyunForm:{tenxunyun_appid:"",tenxunyun_secretid:"",tenxunyun_secretkey:"",tenxunyun_bucket:"",tenxunyun_region:"",tenxunyun_yuming:""},tengxunyunFormRules:{tenxunyun_appid:{required:!0,type:"string",message:"请输入AppId",trigger:"blur"},tenxunyun_secretid:{required:!0,type:"string",message:"请输入SecretId",trigger:"blur"},tenxunyun_secretkey:{required:!0,type:"string",message:"请输入SecretKey",trigger:"blur"},tenxunyun_bucket:{required:!0,type:"string",message:"请输入仓库名称",trigger:"blur"},tenxunyun_region:{required:!1,type:"string",message:"请输入仓库地域",trigger:"blur"},tenxunyun_yuming:{required:!0,type:"string",message:"请输入仓库域名",trigger:"blur"}}}},created:function(){this.getFormInfo()},methods:{getFormInfo:function(){var e=this;return s()(i.a.mark(function n(){var t,u,r,s,a,l,o;return i.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,e.$api.system.getOssConfig();case 2:if(t=n.sent,u=t.code,r=t.data,200===u){n.next=7;break}return n.abrupt("return");case 7:for(e.open_oss=r.open_oss,a=0,l=(s=["baseForm","qiniuyunForm","aliyunForm","tengxunyunForm"]).length;a<l;a++)for(o in e[s[a]])e[s[a]][o]=r[o];case 10:case"end":return n.stop()}},n,e)}))()},submitForm:function(e){var n=this,t=["baseForm"];"baseForm"!==e&&t.push(e);for(var u=!0,i=0,r=t.length;i<r;i++)this.$refs[t[i]].validate(function(e){if(!e)return u=!1,!1});if(u){var s=this[e];s.open_oss=this.open_oss,this.$api.system.updateOssConfig({oss_config:s}).then(function(e){200===e.code&&n.$message.success(n.$t("tips.successSub"))})}}}},l={render:function(){var e=this,n=e.$createElement,t=e._self._c||n;return t("div",{staticClass:"lb-system-upload"},[t("top-nav"),e._v(" "),t("div",{staticClass:"page-main"},[t("el-form",{ref:"baseForm",attrs:{"label-width":"130px",model:e.baseForm,rules:e.baseFormRules},nativeOn:{submit:function(e){e.preventDefault()}}},[t("el-form-item",{attrs:{required:"",label:"请选择上传类型"}},[t("el-select",{attrs:{placeholder:"请选择"},model:{value:e.open_oss,callback:function(n){e.open_oss=n},expression:"open_oss"}},e._l(e.options,function(e){return t("el-option",{key:e.value,attrs:{label:e.label,value:e.value}})}),1)],1),e._v(" "),0===e.open_oss?t("el-form-item",[t("lb-button",{attrs:{type:"primary"},on:{click:function(n){return e.submitForm("baseForm")}}},[e._v(e._s(e.$t("action.submit")))])],1):e._e()],1),e._v(" "),t("el-form",{directives:[{name:"show",rawName:"v-show",value:2===e.open_oss,expression:"open_oss === 2"}],ref:"qiniuyunForm",attrs:{model:e.qiniuyunForm,rules:e.qiniuyunFormRules,"label-width":"130px"},nativeOn:{submit:function(e){e.preventDefault()}}},[t("el-form-item",{attrs:{label:"AccessKey",prop:"qiniu_accesskey"}},[t("el-input",{attrs:{type:"password",placeholder:"请输入AccessKey"},model:{value:e.qiniuyunForm.qiniu_accesskey,callback:function(n){e.$set(e.qiniuyunForm,"qiniu_accesskey",n)},expression:"qiniuyunForm.qiniu_accesskey"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"SecretKey",prop:"qiniu_secretkey"}},[t("el-input",{attrs:{type:"password",placeholder:"请输入SecretKey"},model:{value:e.qiniuyunForm.qiniu_secretkey,callback:function(n){e.$set(e.qiniuyunForm,"qiniu_secretkey",n)},expression:"qiniuyunForm.qiniu_secretkey"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"仓库名称",prop:"qiniu_bucket"}},[t("el-input",{attrs:{placeholder:"请输入仓库名称"},model:{value:e.qiniuyunForm.qiniu_bucket,callback:function(n){e.$set(e.qiniuyunForm,"qiniu_bucket",n)},expression:"qiniuyunForm.qiniu_bucket"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"自定义域名",prop:"qiniu_yuming"}},[t("el-input",{attrs:{placeholder:"请输入自定义域名"},model:{value:e.qiniuyunForm.qiniu_yuming,callback:function(n){e.$set(e.qiniuyunForm,"qiniu_yuming",n)},expression:"qiniuyunForm.qiniu_yuming"}}),e._v(" "),t("lb-tool-tips",[e._v("域名前面要加http://")])],1),e._v(" "),t("el-form-item",[t("lb-button",{attrs:{type:"primary"},on:{click:function(n){return e.submitForm("qiniuyunForm")}}},[e._v(e._s(e.$t("action.submit")))])],1)],1),e._v(" "),t("el-form",{directives:[{name:"show",rawName:"v-show",value:1===e.open_oss,expression:"open_oss === 1"}],ref:"aliyunForm",attrs:{model:e.aliyunForm,rules:e.aliyunFormRules,"label-width":"130px"},nativeOn:{submit:function(e){e.preventDefault()}}},[t("el-form-item",{attrs:{label:"仓库名称",prop:"aliyun_bucket"}},[t("el-input",{attrs:{placeholder:"请输入仓库名称"},model:{value:e.aliyunForm.aliyun_bucket,callback:function(n){e.$set(e.aliyunForm,"aliyun_bucket",n)},expression:"aliyunForm.aliyun_bucket"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"AccessKeyId",prop:"aliyun_access_key_id"}},[t("el-input",{attrs:{type:"password",placeholder:"请输入AccessKeyId"},model:{value:e.aliyunForm.aliyun_access_key_id,callback:function(n){e.$set(e.aliyunForm,"aliyun_access_key_id",n)},expression:"aliyunForm.aliyun_access_key_id"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"AccessKeySecret",prop:"aliyun_access_key_secret"}},[t("el-input",{attrs:{type:"password",placeholder:"请输入AccessKeySecret"},model:{value:e.aliyunForm.aliyun_access_key_secret,callback:function(n){e.$set(e.aliyunForm,"aliyun_access_key_secret",n)},expression:"aliyunForm.aliyun_access_key_secret"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"上传根目录",prop:"aliyun_base_dir"}},[t("el-input",{attrs:{placeholder:"请输入上传根目录"},model:{value:e.aliyunForm.aliyun_base_dir,callback:function(n){e.$set(e.aliyunForm,"aliyun_base_dir",n)},expression:"aliyunForm.aliyun_base_dir"}}),e._v(" "),t("lb-tool-tips",[e._v("代表仓库顶层目录名称,请以英文字母命名,前后不用加'/',例如：mingpian_image")])],1),e._v(" "),t("el-form-item",{attrs:{label:"自定义域名",prop:"aliyun_zidinyi_yuming"}},[t("el-input",{attrs:{placeholder:"请输入自定义域名"},model:{value:e.aliyunForm.aliyun_zidinyi_yuming,callback:function(n){e.$set(e.aliyunForm,"aliyun_zidinyi_yuming",n)},expression:"aliyunForm.aliyun_zidinyi_yuming"}}),e._v(" "),t("lb-tool-tips",[e._v("自定义域名前面要加https://,结尾不用加'/'")])],1),e._v(" "),t("el-form-item",{attrs:{label:"Endpoint",prop:"aliyun_endpoint"}},[t("el-input",{attrs:{placeholder:"请输入Endpoint"},model:{value:e.aliyunForm.aliyun_endpoint,callback:function(n){e.$set(e.aliyunForm,"aliyun_endpoint",n)},expression:"aliyunForm.aliyun_endpoint"}}),e._v(" "),t("lb-tool-tips",[e._v("例如：oss-cn-beijing.aliyuncs.com")])],1),e._v(" "),t("el-form-item",[t("lb-button",{attrs:{type:"primary"},on:{click:function(n){return e.submitForm("aliyunForm")}}},[e._v(e._s(e.$t("action.submit")))])],1)],1),e._v(" "),t("el-form",{directives:[{name:"show",rawName:"v-show",value:3===e.open_oss,expression:"open_oss === 3"}],ref:"tengxunyunForm",attrs:{model:e.tengxunyunForm,rules:e.tengxunyunFormRules,"label-width":"130px"},nativeOn:{submit:function(e){e.preventDefault()}}},[t("el-form-item",{attrs:{label:"AppID",prop:"tenxunyun_appid"}},[t("el-input",{attrs:{type:"password",placeholder:"请输入AppID"},model:{value:e.tengxunyunForm.tenxunyun_appid,callback:function(n){e.$set(e.tengxunyunForm,"tenxunyun_appid",n)},expression:"tengxunyunForm.tenxunyun_appid"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"SecretID",prop:"tenxunyun_secretid"}},[t("el-input",{attrs:{type:"password",placeholder:"请输入SecretID"},model:{value:e.tengxunyunForm.tenxunyun_secretid,callback:function(n){e.$set(e.tengxunyunForm,"tenxunyun_secretid",n)},expression:"tengxunyunForm.tenxunyun_secretid"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"SecretKey",prop:"tenxunyun_secretkey"}},[t("el-input",{attrs:{type:"password",placeholder:"请输入SecretKey"},model:{value:e.tengxunyunForm.tenxunyun_secretkey,callback:function(n){e.$set(e.tengxunyunForm,"tenxunyun_secretkey",n)},expression:"tengxunyunForm.tenxunyun_secretkey"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"仓库名称",prop:"tenxunyun_bucket"}},[t("el-input",{attrs:{placeholder:"请输入仓库名称"},model:{value:e.tengxunyunForm.tenxunyun_bucket,callback:function(n){e.$set(e.tengxunyunForm,"tenxunyun_bucket",n)},expression:"tengxunyunForm.tenxunyun_bucket"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"仓库地域",prop:"tenxunyun_region"}},[t("el-input",{attrs:{placeholder:"请输入仓库地域"},model:{value:e.tengxunyunForm.tenxunyun_region,callback:function(n){e.$set(e.tengxunyunForm,"tenxunyun_region",n)},expression:"tengxunyunForm.tenxunyun_region"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"仓库域名",prop:"tenxunyun_yuming"}},[t("el-input",{attrs:{placeholder:"请输入仓库域名"},model:{value:e.tengxunyunForm.tenxunyun_yuming,callback:function(n){e.$set(e.tengxunyunForm,"tenxunyun_yuming",n)},expression:"tengxunyunForm.tenxunyun_yuming"}})],1),e._v(" "),t("el-form-item",[t("lb-button",{attrs:{type:"primary"},on:{click:function(n){return e.submitForm("tengxunyunForm")}}},[e._v(e._s(e.$t("action.submit")))])],1)],1)],1)],1)},staticRenderFns:[]};var o=t("VU/8")(a,l,!1,function(e){t("xJRu")},"data-v-15a2aa44",null);n.default=o.exports},xJRu:function(e,n){}});