(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0ceeb2"],{6200:function(t,i,e){"use strict";e.r(i);var n=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-12"},[e("div",{staticClass:"card"},[e("div",{staticClass:"card-header card-header-icon card-header-rose"},[e("div",{staticClass:"card-icon card-icon-right"},[e("router-link",{attrs:{title:"Thêm",to:{name:"adminAddSchool"}}},[e("i",{staticClass:"material-icons",staticStyle:{color:"#FFFFFF"}},[t._v("playlist_add")])])],1),e("div",{staticClass:"card-icon card-icon-right"},[e("router-link",{attrs:{title:"import",to:{name:"adminImportSchool"}}},[e("i",{staticClass:"material-icons",staticStyle:{color:"#FFFFFF"}},[t._v("import_export")])])],1),e("h4",{staticClass:"card-title"},[t._v("Quản lý trường học")])]),e("div",{staticClass:"card-body"},[e("div",{staticClass:"table-responsive"},[e("table",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"table"},[t._m(0),e("tbody",t._l(t.universities,(function(i,n){return e("tr",{key:n},[e("td",[t._v(t._s(i.id))]),e("td",[t._v(t._s(i.name_vi))]),e("td",[t._v(t._s(i.short_name_vi))]),e("td",[t._v(t._s(i.website))]),e("td",[e("div",{staticClass:"btn-group"},[e("router-link",{staticClass:"btn btn-sm btn-info",attrs:{to:{name:"uniDashboard",params:{id:i.id}}}},[t._v("\n                      Xem\n                      "),e("div",{staticClass:"ripple-container"})]),e("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(e){return t.removeSchools(i.id,i.name_vi)}}},[t._v("\n                      Xóa\n                      "),e("div",{staticClass:"ripple-container"})])],1)])])})),0)])])])])])])},a=[function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("thead",{staticClass:"text-primary"},[e("th",[t._v("ID")]),e("th",[t._v("Tên")]),e("th",[t._v("Viết tắt")]),e("th",[t._v("Website")]),e("th",[t._v("Hành động")])])}],s=(e("6b54"),e("2397"),e("d225")),c=e("b0b4"),r=e("4e2b"),o=e("308d"),l=e("6bb5"),d=e("9ab4"),u=e("60a3");function v(t){var i=h();return function(){var e,n=Object(l["a"])(t);if(i){var a=Object(l["a"])(this).constructor;e=Reflect.construct(n,arguments,a)}else e=n.apply(this,arguments);return Object(o["a"])(this,e)}}function h(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}var f=function(t){Object(r["a"])(e,t);var i=v(e);function e(){var t;return Object(s["a"])(this,e),t=i.apply(this,arguments),t.universities=[],t.loading=!0,t}return Object(c["a"])(e,[{key:"removeSchools",value:function(t,i){var e=this;this.$confirm("Bạn có chắc chắn muốn xóa trường "+i).then((function(i){e.axios.delete("university/delete/"+t).then((function(t){!0===t.data.success&&(e.$notify.success("Xóa trường thành công"),e.listUniversities())})).catch((function(t){console.log(t),e.$notify.error("Xóa trường thất bại")}))})).catch((function(t){console.log(4)}))}},{key:"listUniversities",value:function(){var t=this;this.axios.get("university/list").then((function(i){t.universities=i.data.data.university,t.loading=!1}))}},{key:"created",value:function(){this.listUniversities()}}]),e}(u["c"]);f=Object(d["a"])([Object(u["a"])({components:{}})],f);var b=f,m=b,_=e("2877"),p=Object(_["a"])(m,n,a,!1,null,"2177fba8",null);i["default"]=p.exports}}]);
//# sourceMappingURL=chunk-2d0ceeb2.b844eb76.js.map