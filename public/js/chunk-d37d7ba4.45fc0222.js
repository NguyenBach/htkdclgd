(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-d37d7ba4"],{"00c1":function(t,e,i){},"09ae":function(t,e,i){"use strict";i.r(e);var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"card"},[i("div",{staticClass:"card-header card-header-icon card-header-rose"},[i("div",{staticClass:"card-icon"},[i("router-link",{attrs:{to:{name:"adminSchool"}}},[i("i",{staticClass:"material-icons",staticStyle:{color:"#FFFFFF"}},[t._v("arrow_back")])])],1),i("h4",{staticClass:"card-title"},[t._v("\n      Chỉnh sửa thông tin trường học\n    ")])]),i("school-form",{attrs:{typeSubmit:"update",universityId:t.universityId},on:{successCallback:t.createSuccess}})],1)},a=[],s=(i("8e6e"),i("ac6a"),i("456d"),i("6b54"),i("2397"),i("bd86")),r=(i("96cf"),i("3b8d")),o=i("d225"),l=i("b0b4"),c=i("4e2b"),m=i("308d"),u=i("6bb5"),v=i("9ab4"),y=i("60a3"),d=i("6901"),p=i("2f62");function b(t,e){var i=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),i.push.apply(i,n)}return i}function f(t){for(var e=1;e<arguments.length;e++){var i=null!=arguments[e]?arguments[e]:{};e%2?b(Object(i),!0).forEach((function(e){Object(s["a"])(t,e,i[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(i)):b(Object(i)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(i,e))}))}return t}function g(t){var e=h();return function(){var i,n=Object(u["a"])(t);if(e){var a=Object(u["a"])(this).constructor;i=Reflect.construct(n,arguments,a)}else i=n.apply(this,arguments);return Object(m["a"])(this,i)}}function h(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}var _=function(t){Object(c["a"])(i,t);var e=g(i);function i(){var t;return Object(o["a"])(this,i),t=e.apply(this,arguments),t.universityId=0,t}return Object(l["a"])(i,[{key:"createSuccess",value:function(t){t&&this.$router.push({name:"uniDashboard"})}},{key:"created",value:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.universityId=this.$route.params.id||this.getUniversityID;case 1:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}()}]),i}(y["c"]);_=Object(v["a"])([Object(y["a"])({components:{SchoolForm:d["a"]},computed:f({},Object(p["c"])("user",["getUniversityID"]))})],_);var C=_,U=C,O=i("2877"),x=Object(O["a"])(U,n,a,!1,null,"7bf97f86",null);e["default"]=x.exports},6901:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{directives:[{name:"loading",rawName:"v-loading",value:t.isLoading,expression:"isLoading"}],staticClass:"card-body"},[i("form",[i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-12"},t._l(t.errors.all(),(function(t){return i("el-alert",{key:t,attrs:{title:t,type:"error"}})})),1)]),i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-6"},[i("div",{staticClass:"form-group"},[i("label",{},[t._v("Tên tiếng việt")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.name_vi,expression:"myUniversity.name_vi"},{name:"validate",rawName:"v-validate",value:"required",expression:"'required'"}],staticClass:"form-control",attrs:{type:"text",name:"name_vi"},domProps:{value:t.myUniversity.name_vi},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"name_vi",e.target.value)}}})])]),i("div",{staticClass:"col-md-6"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Tên tiếng anh")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.name_en,expression:"myUniversity.name_en"}],staticClass:"form-control",attrs:{type:"text",name:"name_en"},domProps:{value:t.myUniversity.name_en},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"name_en",e.target.value)}}})])])]),i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-3"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Tên tiếng việt viết tắt")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.short_name_vi,expression:"myUniversity.short_name_vi"}],staticClass:"form-control",attrs:{type:"text",name:"short_name_vi"},domProps:{value:t.myUniversity.short_name_vi},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"short_name_vi",e.target.value)}}})])]),i("div",{staticClass:"col-md-3"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Tên tiếng anh viết tắt")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.short_name_en,expression:"myUniversity.short_name_en"}],staticClass:"form-control",attrs:{type:"text",name:"short_name_en"},domProps:{value:t.myUniversity.short_name_en},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"short_name_en",e.target.value)}}})])]),i("div",{staticClass:"col-md-6"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Tên cũ")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.name_before,expression:"myUniversity.name_before"}],staticClass:"form-control",attrs:{type:"text",name:"name_before"},domProps:{value:t.myUniversity.name_before},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"name_before",e.target.value)}}})])])]),i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-6"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Cơ quan chủ quản")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.governing_body,expression:"myUniversity.governing_body"}],staticClass:"form-control",attrs:{type:"text",name:"governing_body"},domProps:{value:t.myUniversity.governing_body},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"governing_body",e.target.value)}}})])]),i("div",{staticClass:"col-md-6"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Địa chỉ")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.address,expression:"myUniversity.address"}],staticClass:"form-control",attrs:{type:"text",name:"address"},domProps:{value:t.myUniversity.address},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"address",e.target.value)}}})])])]),i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-3"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Số điện thoại")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.phone_number,expression:"myUniversity.phone_number"}],staticClass:"form-control",attrs:{type:"text",name:"phone_number"},domProps:{value:t.myUniversity.phone_number},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"phone_number",e.target.value)}}})])]),i("div",{staticClass:"col-md-3"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Số fax")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.fax_number,expression:"myUniversity.fax_number"}],staticClass:"form-control",attrs:{type:"text",name:"fax_number"},domProps:{value:t.myUniversity.fax_number},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"fax_number",e.target.value)}}})])]),i("div",{staticClass:"col-md-3"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Địa chỉ email")]),i("input",{directives:[{name:"validate",rawName:"v-validate",value:"email",expression:"'email'"},{name:"model",rawName:"v-model",value:t.myUniversity.email,expression:"myUniversity.email"}],staticClass:"form-control",attrs:{type:"text",name:"email"},domProps:{value:t.myUniversity.email},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"email",e.target.value)}}})])]),i("div",{staticClass:"col-md-3"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Website")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.website,expression:"myUniversity.website"}],staticClass:"form-control",attrs:{type:"text",name:"website"},domProps:{value:t.myUniversity.website},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"website",e.target.value)}}})])])]),i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-4"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Năm thành lập")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.founded_year,expression:"myUniversity.founded_year"}],staticClass:"form-control",attrs:{type:"text",name:"founded_year"},domProps:{value:t.myUniversity.founded_year},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"founded_year",e.target.value)}}})])]),i("div",{staticClass:"col-md-4"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Thời gian bắt đầu đào tạo khóa I")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.k1_start_date,expression:"myUniversity.k1_start_date"}],staticClass:"form-control",attrs:{type:"date",name:"k1_start_date"},domProps:{value:t.myUniversity.k1_start_date},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"k1_start_date",e.target.value)}}})])]),i("div",{staticClass:"col-md-4"},[i("div",{staticClass:"form-group"},[i("label",{staticClass:"bmd-label-floating"},[t._v("Thời gian cấp bằng tốt nghiệp cho khoá I")]),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.k1_end_date,expression:"myUniversity.k1_end_date"}],staticClass:"form-control",attrs:{type:"date",name:"k1_end_date"},domProps:{value:t.myUniversity.k1_end_date},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"k1_end_date",e.target.value)}}})])])]),i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-12"},[i("div",{staticClass:"form-group",staticStyle:{"text-align":"left"}},[i("label",{staticClass:"bmd-label-floating",staticStyle:{"margin-right":"20px"}},[t._v("\n            Loại hình cơ sở giáo\n            dục\n          ")]),i("el-radio-group",{on:{change:t.institutionChange},model:{value:t.myUniversity.institution_type,callback:function(e){t.$set(t.myUniversity,"institution_type",e)},expression:"myUniversity.institution_type"}},[i("el-radio-button",{attrs:{label:"1"}},[t._v("Công lập")]),i("el-radio-button",{attrs:{label:"2"}},[t._v("Bán công")]),i("el-radio-button",{attrs:{label:"3"}},[t._v("Dân lập")]),i("el-radio-button",{attrs:{label:"4"}},[t._v("Tư thục")]),i("el-radio-button",{attrs:{label:"0"}},[t._v("Khác: "+t._s(t.myUniversity.institution_type_other))])],1),i("input",{directives:[{name:"model",rawName:"v-model",value:t.myUniversity.institution_type_other,expression:"myUniversity.institution_type_other"}],staticClass:"form-control",attrs:{type:"text",disabled:t.otherInstitutionDisable,placeholder:"Loại hình khác",name:"institution_type_other"},domProps:{value:t.myUniversity.institution_type_other},on:{input:function(e){e.target.composing||t.$set(t.myUniversity,"institution_type_other",e.target.value)}}})],1)])]),i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-12"},[i("div",{staticClass:"form-group",staticStyle:{"text-align":"left"}},[i("label",{staticClass:"bmd-label-floating",staticStyle:{display:"block"}},[t._v("\n            Các loại hình đào tạo của cơ sở\n            giáo dục\n          ")]),i("el-checkbox-group",{model:{value:t.checkList,callback:function(e){t.checkList=e},expression:"checkList"}},[i("el-checkbox",{attrs:{label:"1"}},[t._v("Chính quy")]),i("el-checkbox",{attrs:{label:"2"}},[t._v("Không chính quy")]),i("el-checkbox",{attrs:{label:"3"}},[t._v("Từ xa")]),i("el-checkbox",{attrs:{label:"4"}},[t._v("Liên kết đào tạo với nước ngoài")]),i("el-checkbox",{attrs:{label:"5"}},[t._v("Liên kết đào tạo trong nước")])],1),i("el-select",{staticClass:"form-control",attrs:{multiple:"",filterable:"","allow-create":"","default-first-option":"",placeholder:"Loại hình đào tạo khác"},model:{value:t.myUniversity.training_type_other,callback:function(e){t.$set(t.myUniversity,"training_type_other",e)},expression:"myUniversity.training_type_other"}},t._l(t.trainingTypes,(function(t){return i("el-option",{key:t.id,attrs:{label:t.name,value:t.name}})})),1)],1)])]),i("button",{staticClass:"btn btn-rose pull-right",attrs:{type:"button"},on:{click:t.onSubmit}},[t._v(t._s(t.buttonName))]),i("div",{staticClass:"clearfix"})])])},a=[],s=(i("8e6e"),i("ac6a"),i("456d"),i("6b54"),i("2397"),i("bd86")),r=i("d225"),o=i("b0b4"),l=i("4e2b"),c=i("308d"),m=i("6bb5"),u=i("9ab4"),v=i("60a3"),y=i("2f62");function d(t,e){var i=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),i.push.apply(i,n)}return i}function p(t){for(var e=1;e<arguments.length;e++){var i=null!=arguments[e]?arguments[e]:{};e%2?d(Object(i),!0).forEach((function(e){Object(s["a"])(t,e,i[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(i)):d(Object(i)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(i,e))}))}return t}function b(t){var e=f();return function(){var i,n=Object(m["a"])(t);if(e){var a=Object(m["a"])(this).constructor;i=Reflect.construct(n,arguments,a)}else i=n.apply(this,arguments);return Object(c["a"])(this,i)}}function f(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}var g=function(t){Object(l["a"])(i,t);var e=b(i);function i(){var t;return Object(r["a"])(this,i),t=e.apply(this,arguments),t.myUniversity={name_vi:"",name_en:"",short_name_vi:"",short_name_en:"",name_before:"",governing_body:"",address:"",phone_number:"",fax_number:" ",email:"",website:"",founded_year:"",k1_start_date:"",k1_end_date:"",institution_type:1,institution_type_other:"",training_type:"1",training_type_other:[]},t.checkList=[],t.buttonName="Tạo trường đại học",t.isLoading=!0,t.otherInstitutionDisable=!0,t.trainingTypes=[],t}return Object(o["a"])(i,[{key:"onSubmit",value:function(){var t=this,e="";e="create"===this.typeSubmit?"university/create":"university/update/"+this.universityId,""!==this.myUniversity.name_vi&&(this.myUniversity.training_type=JSON.stringify(this.checkList),this.axios.post(e,this.myUniversity).then((function(){"create"===t.typeSubmit?t.$notify.success("Tạo mới trường học thành công!"):t.$notify.success("Cập nhật thông tin trường học thành công!"),t.$emit("successCallback",!0)})))}},{key:"institutionChange",value:function(t){0===parseInt(t)?this.otherInstitutionDisable=!1:this.otherInstitutionDisable=!0}},{key:"getTrainingType",value:function(){var t=this;this.axios.get("university/training-type/list").then((function(e){t.trainingTypes=e.data.data.training_type})).catch((function(e){t.$notify.error("Lấy danh sách loại hình đào tạo thất bại")}))}},{key:"created",value:function(){var t=this;0!==this.universityId?this.axios.get("university/"+this.universityId).then((function(e){t.myUniversity=e.data.data.university,t.myUniversity.training_type_other=JSON.parse(t.myUniversity.training_type_other),console.log(t.myUniversity.training_type),t.checkList=JSON.parse(t.myUniversity.training_type),t.isLoading=!1})):this.isLoading=!1,"create"!==this.typeSubmit&&(this.buttonName="Cập nhật thông tin trường"),this.getTrainingType()}},{key:"trainingOtherType",get:function(){if(this.myUniversity.training_type_other){var t=JSON.parse(this.myUniversity.training_type_other);return t.join(",")}return""}}]),i}(v["c"]);Object(u["a"])([Object(v["b"])({required:!1,default:"create",type:String})],g.prototype,"typeSubmit",void 0),Object(u["a"])([Object(v["b"])({required:!1,default:0})],g.prototype,"universityId",void 0),g=Object(u["a"])([Object(v["a"])({components:{},computed:p({},Object(y["c"])("user",["getUniversityID"]))})],g);var h=g,_=h,C=(i("8def"),i("2877")),U=Object(C["a"])(_,n,a,!1,null,"740f6c80",null);e["a"]=U.exports},"8def":function(t,e,i){"use strict";var n=i("00c1"),a=i.n(n);a.a}}]);
//# sourceMappingURL=chunk-d37d7ba4.45fc0222.js.map