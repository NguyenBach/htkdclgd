(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-26825875"],{1847:function(t,e,a){"use strict";var i=a("e8b5"),r=a.n(i);r.a},"320e":function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"card-body"},[a("form",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},t._l(t.errors.all(),(function(t){return a("el-alert",{key:t,attrs:{title:t,type:"error"}})})),1)]),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("div",{staticClass:"form-group"},[a("div",[a("el-date-picker",{attrs:{type:"year",placeholder:"Pick a year"},model:{value:t.year,callback:function(e){t.year=e},expression:"year"}})],1)])])]),a("div",{staticClass:"row"},[t._m(0),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group"},[a("label",{staticClass:"bmd-label-floating"},[t._v("Số lượng (người)")]),a("input",{directives:[{name:"model",rawName:"v-model.number",value:t.formData.sl_tham_gia,expression:"formData.sl_tham_gia",modifiers:{number:!0}},{name:"validate",rawName:"v-validate",value:"required|decimal:2",expression:"'required|decimal:2'"}],staticClass:"form-control",attrs:{type:"text",name:"gstotal"},domProps:{value:t.formData.sl_tham_gia},on:{input:function(e){e.target.composing||t.$set(t.formData,"sl_tham_gia",t._n(e.target.value))},blur:function(e){return t.$forceUpdate()}}})])]),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group"},[a("label",{staticClass:"bmd-label-floating"},[t._v("Tỷ lệ (%) trên tổng số sinh viên")]),a("input",{directives:[{name:"model",rawName:"v-model.number",value:t.formData.ti_le,expression:"formData.ti_le",modifiers:{number:!0}},{name:"validate",rawName:"v-validate",value:"required|decimal:2",expression:"'required|decimal:2'"}],staticClass:"form-control",attrs:{type:"text",name:"gstotal"},domProps:{value:t.formData.ti_le},on:{input:function(e){e.target.composing||t.$set(t.formData,"ti_le",t._n(e.target.value))},blur:function(e){return t.$forceUpdate()}}})])])]),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("button",{staticClass:"btn btn-success",attrs:{type:"button"},on:{click:t.onSubmit}},[t._v("Cập nhật")])])])])])},r=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-md-12"},[a("h6",[t._v("Sinh viên tham gia nghiên cứu khoa học:")])])}],n=(a("6b54"),a("2397"),a("d225")),s=a("b0b4"),c=a("4e2b"),l=a("308d"),o=a("6bb5"),u=a("9ab4"),d=a("60a3");function h(t){var e=f();return function(){var a,i=Object(o["a"])(t);if(e){var r=Object(o["a"])(this).constructor;a=Reflect.construct(i,arguments,r)}else a=i.apply(this,arguments);return Object(l["a"])(this,a)}}function f(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}var v=function(t){Object(c["a"])(a,t);var e=h(a);function a(){var t;return Object(n["a"])(this,a),t=e.apply(this,arguments),t.year=t.thisYear,t.formData={sl_tham_gia:0,ti_le:0},t}return Object(s["a"])(a,[{key:"onSubmit",value:function(){var t=this;if(0===this.$validator.errors.all().length){for(var e in this.formData)delete this.formData[e].id,delete this.formData[e].university_id,delete this.formData[e].year;this.axios.post("sv-tham-gia-nckh/"+this.thisYear.getFullYear(),{sl_tham_gia:this.formData.sl_tham_gia,ti_le:this.formData.ti_le}).then((function(){t.$notify.success("Cập nhật thành công!"),t.$emit("onSubmitSuccess")}))}else this.$notify.error("Vui lòng nhập đủ và chính xác thông tin!")}},{key:"changeData",value:function(t){this.formData=this.data}},{key:"changeYear",value:function(t,e){t.getTime()!==e.getTime()&&this.$emit("changeYear",t)}},{key:"changePropYear",value:function(t){this.year=t}}]),a}(d["c"]);Object(u["a"])([Object(d["b"])({required:!0})],v.prototype,"data",void 0),Object(u["a"])([Object(d["b"])({required:!0,default:!0,type:Boolean})],v.prototype,"isCreate",void 0),Object(u["a"])([Object(d["b"])({required:!0})],v.prototype,"thisYear",void 0),Object(u["a"])([Object(d["d"])("isCreate",{immediate:!0,deep:!0})],v.prototype,"changeData",null),Object(u["a"])([Object(d["d"])("year",{immediate:!1,deep:!0})],v.prototype,"changeYear",null),Object(u["a"])([Object(d["d"])("thisYear",{immediate:!1,deep:!0})],v.prototype,"changePropYear",null),v=Object(u["a"])([d["a"]],v);var m=v,p=m,_=(a("457f"),a("2877")),b=Object(_["a"])(p,i,r,!1,null,"74a0f458",null);e["a"]=b.exports},"457f":function(t,e,a){"use strict";var i=a("aa3c"),r=a.n(i);r.a},"7ce9":function(t,e,a){},"834e":function(t,e,a){"use strict";a.r(e);var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("SinhVienKtx")],1),a("div",{staticClass:"col-md-12"},[a("SinhVienNckh")],1)])},r=[],n=(a("6b54"),a("2397"),a("d225")),s=a("4e2b"),c=a("308d"),l=a("6bb5"),o=a("9ab4"),u=a("60a3"),d=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"card"},[a("div",{staticClass:"card-header card-header-icon card-header-rose"},[t.isShowEdit?a("div",{staticClass:"card-icon card-icon-right"},[a("a",{attrs:{href:"javascript:;"},on:{click:function(e){t.dialogVisible=!0}}},[a("i",{staticClass:"material-icons",staticStyle:{color:"#ffffff"}},[t._v("playlist_add")])])]):t._e(),a("h4",{staticClass:"card-title"},[t._v("23. Ký túc xá cho sinh viên:")]),a("div",{staticStyle:{"marigin-top":"5px"}},[a("el-date-picker",{attrs:{type:"year",placeholder:"Pick a year"},model:{value:t.year,callback:function(e){t.year=e},expression:"year"}})],1)]),a("div",{staticClass:"card-body"},[a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.isLoading,expression:"isLoading"}],staticStyle:{width:"100%"},attrs:{data:t.listData}},[a("el-table-column",{attrs:{label:"Các tiêu chí",align:"center",prop:"name"}}),a("el-table-column",{attrs:{label:t.getYear(1),align:"center",prop:"year_4"}}),a("el-table-column",{attrs:{label:t.getYear(2),align:"center",prop:"year_3"}}),a("el-table-column",{attrs:{label:t.getYear(3),align:"center",prop:"year_2"}}),a("el-table-column",{attrs:{label:t.getYear(4),align:"center",prop:"year_1"}}),a("el-table-column",{attrs:{label:t.getYear(5),align:"center",prop:"year_0"}})],1),a("el-dialog",{attrs:{visible:t.dialogVisible,width:"600",top:"5vh"},on:{"update:visible":function(e){t.dialogVisible=e}}},[a("SvKiTucXaForm",{attrs:{data:t.data,isCreate:t.isNull,thisYear:t.year},on:{onSubmitSuccess:t.onSubmit,changeYear:t.changeYear}})],1)],1)])},h=[],f=(a("96cf"),a("3b8d")),v=a("b0b4"),m=a("87ee");function p(t){var e=_();return function(){var a,i=Object(l["a"])(t);if(e){var r=Object(l["a"])(this).constructor;a=Reflect.construct(i,arguments,r)}else a=i.apply(this,arguments);return Object(c["a"])(this,a)}}function _(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}var b=function(t){Object(s["a"])(a,t);var e=p(a);function a(){var t;return Object(n["a"])(this,a),t=e.apply(this,arguments),t.data={tong_dien_tich:0,sl_sinh_vien:0,sl_sv_co_nhu_cau:0,sl_sv_dc_o:0},t.listData=[],t.year=new Date,t.isLoading=!1,t.dialogVisible=!1,t.isNull=!0,t}return Object(v["a"])(a,[{key:"getYear",value:function(t){return t-=5,(this.year.getFullYear()+t).toString()}},{key:"getYearKey",value:function(t){return t-=5,"key_"+(this.year.getFullYear()+t).toString()}},{key:"init",value:function(){var t=Object(f["a"])(regeneratorRuntime.mark((function t(){var e,a,i,r,n,s,c;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return e=[{name:"1. Tổng diện tích phòng ở (m2)"},{name:"2. Số lượng sinh viên "},{name:"3. Số sinh viên có nhu cầu ở ký túc xá"},{name:"4. Số lượng sinh viên được ở ký túc xá"},{name:"5. Tỷ số diện tích trên đầu sinh viên ở trong ký túc xá, m2/người"}],this.isLoading=!0,t.next=4,this.axios.get("sv-ktx/list/"+this.year.getFullYear());case 4:for(a=t.sent,i=a.data.data,this.data=i[this.year.getFullYear()]?i[this.year.getFullYear()].sv_ktx:null,this.data||(this.data={tong_dien_tich:0,sl_sinh_vien:0,sl_sv_co_nhu_cau:0,sl_sv_dc_o:0}),r=4;r>=0;r--)n=this.year.getFullYear()-r,s="year_"+r,c=i[n],c?c.sl_sv_dc_o?c.ti_le=(c.tong_dien_tich/c.sl_sv_dc_o).toFixed(2):c.ti_le=0:c={tong_dien_tich:0,sl_sinh_vien:0,sl_sv_co_nhu_cau:0,sl_sv_dc_o:0,ti_le:0},e[0][s]=c["tong_dien_tich"],e[1][s]=c["sl_sinh_vien"],e[2][s]=c["sl_sv_co_nhu_cau"],e[3][s]=c["sl_sv_dc_o"],e[4][s]=c["ti_le"];this.isLoading=!1,this.listData=e;case 11:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}()},{key:"onSubmit",value:function(){this.dialogVisible=!1,this.init()}},{key:"onChangeYear",value:function(t){this.year=t}},{key:"changeYear",value:function(t){this.year=t}},{key:"changeData",value:function(){this.init()}},{key:"created",value:function(){this.init()}}]),a}(u["c"]);Object(o["a"])([Object(u["d"])("year",{immediate:!1})],b.prototype,"changeData",null),b=Object(o["a"])([Object(u["a"])({components:{SvKiTucXaForm:m["a"]}})],b);var g=b,y=g,C=(a("1847"),a("2877")),j=Object(C["a"])(y,d,h,!1,null,"18ecb2cb",null),O=j.exports,D=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"card"},[a("div",{staticClass:"card-header card-header-icon card-header-rose"},[t.isShowEdit?a("div",{staticClass:"card-icon card-icon-right"},[a("a",{attrs:{href:"javascript:;"},on:{click:function(e){t.dialogVisible=!0}}},[a("i",{staticClass:"material-icons",staticStyle:{color:"#ffffff"}},[t._v("playlist_add")])])]):t._e(),a("h4",{staticClass:"card-title"},[t._v("24. Sinh viên tham gia nghiên cứu khoa học:")]),a("div",{staticStyle:{"margin-top":"5px"}},[a("el-date-picker",{attrs:{type:"year",placeholder:"Pick a year"},model:{value:t.year,callback:function(e){t.year=e},expression:"year"}})],1)]),a("div",{staticClass:"card-body"},[a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.isLoading,expression:"isLoading"}],staticStyle:{width:"100%"},attrs:{data:t.listData}},[a("el-table-column",{attrs:{label:"Các tiêu chí",align:"center",prop:"name"}}),t._l(5,(function(e){return a("el-table-column",{key:e,attrs:{label:t.getYear(e),align:"center",prop:t.getYear(e)}})}))],2),a("el-dialog",{attrs:{visible:t.dialogVisible,width:"600",top:"5vh"},on:{"update:visible":function(e){t.dialogVisible=e}}},[a("SvNckhForm",{attrs:{data:t.data,isCreate:t.isNull,thisYear:t.year},on:{onSubmitSuccess:t.onSubmit,changeYear:t.changeYear}})],1)],1)])},k=[],x=a("320e");function S(t){var e=Y();return function(){var a,i=Object(l["a"])(t);if(e){var r=Object(l["a"])(this).constructor;a=Reflect.construct(i,arguments,r)}else a=i.apply(this,arguments);return Object(c["a"])(this,a)}}function Y(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}var w=function(t){Object(s["a"])(a,t);var e=S(a);function a(){var t;return Object(n["a"])(this,a),t=e.apply(this,arguments),t.data={sl_tham_gia:0,ti_le:0},t.listData=[],t.year=new Date,t.isLoading=!1,t.dialogVisible=!1,t.isNull=!0,t}return Object(v["a"])(a,[{key:"getYear",value:function(t){return t-=5,(this.year.getFullYear()+t).toString()}},{key:"init",value:function(){var t=Object(f["a"])(regeneratorRuntime.mark((function t(){var e,a,i,r,n;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return e=[{name:"Số lượng (người)"},{name:"Tỷ lệ (%) trên tổng số sinh viên "}],this.isLoading=!0,t.next=4,this.axios.get("sv-tham-gia-nckh/list/"+this.year.getFullYear());case 4:for(r in a=t.sent,i=a.data.data,i[this.year.getFullYear()]?this.data=i[this.year.getFullYear()]:this.data={sl_tham_gia:0,ti_le:0},i)n=i[r],n||(n={sl_tham_gia:0,ti_le:0}),e[0][r]=n["sl_tham_gia"],e[1][r]=n["ti_le"];this.listData=e,this.isLoading=!1;case 10:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}()},{key:"onSubmit",value:function(){this.dialogVisible=!1,this.init()}},{key:"onChangeYear",value:function(t){this.year=t}},{key:"changeYear",value:function(t){this.year=t}},{key:"changeData",value:function(){this.init()}},{key:"created",value:function(){this.init()}}]),a}(u["c"]);Object(o["a"])([Object(u["d"])("year",{immediate:!1})],w.prototype,"changeData",null),w=Object(o["a"])([Object(u["a"])({components:{SvNckhForm:x["a"]}})],w);var R=w,$=R,N=(a("ea79"),Object(C["a"])($,D,k,!1,null,"18181e98",null)),P=N.exports;function q(t){var e=F();return function(){var a,i=Object(l["a"])(t);if(e){var r=Object(l["a"])(this).constructor;a=Reflect.construct(i,arguments,r)}else a=i.apply(this,arguments);return Object(c["a"])(this,a)}}function F(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}var V=function(t){Object(s["a"])(a,t);var e=q(a);function a(){return Object(n["a"])(this,a),e.apply(this,arguments)}return a}(u["c"]);V=Object(o["a"])([Object(u["a"])({components:{SinhVienKtx:O,SinhVienNckh:P}})],V);var T=V,L=T,E=Object(C["a"])(L,i,r,!1,null,"e9817c06",null);e["default"]=E.exports},"87ee":function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"card-body"},[a("form",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},t._l(t.errors.all(),(function(t){return a("el-alert",{key:t,attrs:{title:t,type:"error"}})})),1)]),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("div",{staticClass:"form-group"},[a("div",[a("el-date-picker",{attrs:{type:"year",placeholder:"Pick a year"},model:{value:t.year,callback:function(e){t.year=e},expression:"year"}})],1)])])]),a("div",{staticClass:"row"},[t._m(0),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group"},[a("label",{staticClass:"bmd-label-floating"},[t._v("1. Tổng diện tích phòng ở (m2)")]),a("input",{directives:[{name:"model",rawName:"v-model.number",value:t.formData.tong_dien_tich,expression:"formData.tong_dien_tich",modifiers:{number:!0}},{name:"validate",rawName:"v-validate",value:"required|decimal:2",expression:"'required|decimal:2'"}],staticClass:"form-control",attrs:{type:"text",name:"gstotal"},domProps:{value:t.formData.tong_dien_tich},on:{input:function(e){e.target.composing||t.$set(t.formData,"tong_dien_tich",t._n(e.target.value))},blur:function(e){return t.$forceUpdate()}}})])]),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group"},[a("label",{staticClass:"bmd-label-floating"},[t._v("2. Số lượng sinh viên")]),a("input",{directives:[{name:"model",rawName:"v-model.number",value:t.formData.sl_sinh_vien,expression:"formData.sl_sinh_vien",modifiers:{number:!0}},{name:"validate",rawName:"v-validate",value:"required|decimal:2",expression:"'required|decimal:2'"}],staticClass:"form-control",attrs:{type:"text",name:"gstotal"},domProps:{value:t.formData.sl_sinh_vien},on:{input:function(e){e.target.composing||t.$set(t.formData,"sl_sinh_vien",t._n(e.target.value))},blur:function(e){return t.$forceUpdate()}}})])]),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group"},[a("label",{staticClass:"bmd-label-floating"},[t._v("3. Số sinh viên có nhu cầu ở ký túc xá")]),a("input",{directives:[{name:"model",rawName:"v-model.number",value:t.formData.sl_sv_co_nhu_cau,expression:"formData.sl_sv_co_nhu_cau",modifiers:{number:!0}},{name:"validate",rawName:"v-validate",value:"required|decimal:2",expression:"'required|decimal:2'"}],staticClass:"form-control",attrs:{type:"text",name:"gstotal"},domProps:{value:t.formData.sl_sv_co_nhu_cau},on:{input:function(e){e.target.composing||t.$set(t.formData,"sl_sv_co_nhu_cau",t._n(e.target.value))},blur:function(e){return t.$forceUpdate()}}})])]),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"form-group"},[a("label",{staticClass:"bmd-label-floating"},[t._v("4. Số lượng sinh viên được ở ký túc xá")]),a("input",{directives:[{name:"model",rawName:"v-model.number",value:t.formData.sl_sv_dc_o,expression:"formData.sl_sv_dc_o",modifiers:{number:!0}},{name:"validate",rawName:"v-validate",value:"required|decimal:2",expression:"'required|decimal:2'"}],staticClass:"form-control",attrs:{type:"text",name:"gstotal"},domProps:{value:t.formData.sl_sv_dc_o},on:{input:function(e){e.target.composing||t.$set(t.formData,"sl_sv_dc_o",t._n(e.target.value))},blur:function(e){return t.$forceUpdate()}}})])])]),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("button",{staticClass:"btn btn-success",attrs:{type:"button"},on:{click:t.onSubmit}},[t._v("Cập nhật")])])])])])},r=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-md-12"},[a("h6",[t._v("Ký túc xá cho sinh viên:")])])}],n=(a("6b54"),a("2397"),a("d225")),s=a("b0b4"),c=a("4e2b"),l=a("308d"),o=a("6bb5"),u=a("9ab4"),d=a("60a3");function h(t){var e=f();return function(){var a,i=Object(o["a"])(t);if(e){var r=Object(o["a"])(this).constructor;a=Reflect.construct(i,arguments,r)}else a=i.apply(this,arguments);return Object(l["a"])(this,a)}}function f(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}var v=function(t){Object(c["a"])(a,t);var e=h(a);function a(){var t;return Object(n["a"])(this,a),t=e.apply(this,arguments),t.year=t.thisYear,t.formData={tong_dien_tich:0,sl_sinh_vien:0,sl_sv_co_nhu_cau:0,sl_sv_dc_o:0},t}return Object(s["a"])(a,[{key:"onSubmit",value:function(){var t=this;if(0===this.$validator.errors.all().length){for(var e in this.formData)delete this.formData[e].id,delete this.formData[e].university_id,delete this.formData[e].year;this.axios.post("sv-ktx/"+this.thisYear.getFullYear(),{tong_dien_tich:this.formData.tong_dien_tich,sl_sinh_vien:this.formData.sl_sinh_vien,sl_sv_co_nhu_cau:this.formData.sl_sv_co_nhu_cau,sl_sv_dc_o:this.formData.sl_sv_dc_o}).then((function(){t.$notify.success("Cập nhật thành công!"),t.$emit("onSubmitSuccess")}))}else this.$notify.error("Vui lòng nhập đủ và chính xác thông tin!")}},{key:"changeData",value:function(t){this.formData=this.data}},{key:"changeYear",value:function(t,e){t.getTime()!==e.getTime()&&this.$emit("changeYear",t)}},{key:"changePropYear",value:function(t){this.year=t}}]),a}(d["c"]);Object(u["a"])([Object(d["b"])({required:!0})],v.prototype,"data",void 0),Object(u["a"])([Object(d["b"])({required:!0,default:!0,type:Boolean})],v.prototype,"isCreate",void 0),Object(u["a"])([Object(d["b"])({required:!0})],v.prototype,"thisYear",void 0),Object(u["a"])([Object(d["d"])("isCreate",{immediate:!0,deep:!0})],v.prototype,"changeData",null),Object(u["a"])([Object(d["d"])("year",{immediate:!1,deep:!0})],v.prototype,"changeYear",null),Object(u["a"])([Object(d["d"])("thisYear",{immediate:!1,deep:!0})],v.prototype,"changePropYear",null),v=Object(u["a"])([d["a"]],v);var m=v,p=m,_=(a("ea11"),a("2877")),b=Object(_["a"])(p,i,r,!1,null,"4c369a9c",null);e["a"]=b.exports},aa3c:function(t,e,a){},e8b5:function(t,e,a){},ea11:function(t,e,a){"use strict";var i=a("7ce9"),r=a.n(i);r.a},ea79:function(t,e,a){"use strict";var i=a("f93d"),r=a.n(i);r.a},f93d:function(t,e,a){}}]);
//# sourceMappingURL=chunk-26825875.7566317a.js.map