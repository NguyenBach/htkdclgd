(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-48d04672"],{2187:function(t,n,a){"use strict";var i=a("95df"),e=a.n(i);e.a},"305a":function(t,n,a){"use strict";a.r(n);var i=function(){var t=this,n=t.$createElement,a=t._self._c||n;return a("div",{staticClass:"card"},[a("div",{staticClass:"card-header card-header-icon card-header-rose"},[a("h2",{staticClass:"card-title"},[t._v("Tóm tắt chỉ số quan trọng")]),a("div",[a("el-date-picker",{attrs:{type:"year",placeholder:"Pick a year"},model:{value:t.year,callback:function(n){t.year=n},expression:"year"}})],1),a("el-button-group",[a("el-button",{staticStyle:{margin:"10px"},attrs:{type:"primary"},on:{click:t.handleAuto}},[t._v("Tự tính kết quả tóm tắt")])],1)],1),a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.isLoading,expression:"isLoading"}],staticClass:"card-content"},[a("div",{staticClass:"text-custom"},[t._v("\n      Từ kết quả KS ở trên, tổng hợp thành một số chỉ số quan trọng dưới đây\n      (số liệu năm cuối kỳ đánh giá):\n    ")]),a("ul",[a("li",[a("div",{staticClass:"text-custom"},[t._v("1. Giảng viên:")]),a("div",{staticClass:"text-custom"},[t._v("\n          Tổng số giảng viên cơ hữu (người):\n          "),a("preview",{attrs:{data:t.data.tong_gv_co_huu,keyData:"tong_gv_co_huu"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ giảng viên cơ hữu trên tổng số cán bộ cơ hữu (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_gv_cb,keyData:"ti_le_gv_cb"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ giảng viên cơ hữu có trình độ tiến sĩ trở lên trên tổng số\n          giảng viên cơ hữu (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_gv_ts,keyData:"ti_le_gv_ts"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ giảng viên cơ hữu có trình độ thạc sĩ trên tổng số giảng viên\n          cơ hữu (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_gv_ths,keyData:"ti_le_gv_ths"},on:{edit:t.handleEdit}})],1)]),a("li",[a("div",{staticClass:"text-custom"},[t._v("2. Sinh viên:")]),a("div",{staticClass:"text-custom"},[t._v("\n          Tổng số sinh viên chính quy (người):\n          "),a("preview",{attrs:{data:t.data.tong_sv,keyData:"tong_sv"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ số sinh viên trên giảng viên (sau khi quy đổi):\n          "),a("preview",{attrs:{data:t.data.ti_le_sv_gv,keyData:"ti_le_sv_gv"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ sinh viên tốt nghiệp so với số tuyển vào (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_tot_nghiep,keyData:"ti_le_tot_nghiep"},on:{edit:t.handleEdit}})],1)]),a("li",[a("div",{staticClass:"text-custom"},[t._v("\n          3. Đánh giá của sinh viên tốt nghiệp về chất lượng đào tạo của nhà\n          trường:\n        ")]),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ sinh viên trả lời đã học được những kiến thức và kỹ năng cần\n          thiết cho công việc theo ngành tốt nghiệp (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_tra_loi_duoc,keyData:"ti_le_tra_loi_duoc"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ sinh viên trả lời chỉ học được một phần kiến thức và kỹ năng\n          cần thiết cho công việc theo ngành tốt nghiệp (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_tra_loi_1_phan,keyData:"ti_le_tra_loi_1_phan"},on:{edit:t.handleEdit}})],1)]),a("li",[a("div",{staticClass:"text-custom"},[t._v("\n          4. Sinh viên có việc làm trong năm đầu tiên sau khi tốt nghiệp:\n        ")]),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ sinh viên có việc làm đúng ngành đào tạo, trong đó bao gồm cả\n          sinh viên chưa có việc làm học tập nâng cao (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_dung_nganh,keyData:"ti_le_dung_nganh"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ sinh viên có việc làm trái ngành đào tạo (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_trai_nganh,keyData:"ti_le_trai_nganh"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ tự tạo được việc làm trong số sinh viên có việc làm (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_tu_tao,keyData:"ti_le_tu_tao"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Thu nhập bình quân/tháng của sinh viên có việc làm (triệu VNĐ):\n          "),a("preview",{attrs:{data:t.data.thu_nhap_binh_quan,keyData:"thu_nhap_binh_quan"},on:{edit:t.handleEdit}})],1)]),a("li",[a("div",{staticClass:"text-custom"},[t._v("\n          5. Đánh giá của nhà sử dụng về sinh viên tốt nghiệp có việc làm đúng\n          ngành đào tạo:\n        ")]),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ sinh viên đáp ứng yêu cầu của công việc, có thể sử dụng được\n          ngay (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_dap_ung_ngay,keyData:"ti_le_dap_ung_ngay"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ lệ sinh viên cơ bản đáp ứng yêu cầu của công việc, nhưng phải đào\n          tạo thêm (%):\n          "),a("preview",{attrs:{data:t.data.ti_le_dao_tao_them,keyData:"ti_le_dao_tao_them"},on:{edit:t.handleEdit}})],1)]),a("li",[a("div",{staticClass:"text-custom"},[t._v("\n          6. Nghiên cứu khoa học, chuyển giao công nghệ và phục vụ cộng đồng:\n        ")]),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ số đề tài nghiên cứu khoa học, chuyển giao khoa học công nghệ và\n          phục vụ cộng đồng trên cán bộ cơ hữu:\n          "),a("preview",{attrs:{data:t.data.ti_so_bai_bao_cb,keyData:"ti_so_bai_bao_cb"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ số doanh thu từ nghiên cứu khoa học, chuyển giao công nghệ và\n          phục vụ cộng đồng trên cán bộ cơ hữu:\n          "),a("preview",{attrs:{data:t.data.ti_le_de_tai_cb,keyData:"ti_le_de_tai_cb"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ số sách đã được xuất bản trên cán bộ cơ hữu:\n          "),a("preview",{attrs:{data:t.data.ti_so_sach_cb,keyData:"ti_so_sach_cb"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ số bài đăng tạp chí trên cán bộ cơ hữu:\n          "),a("preview",{attrs:{data:t.data.ti_so_tap_chi_cb,keyData:"ti_so_tap_chi_cb"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ số bài báo cáo trên cán bộ cơ hữu:\n          "),a("preview",{attrs:{data:t.data.ti_so_bai_bao_cb,keyData:"ti_so_bai_bao_cb"},on:{edit:t.handleEdit}})],1)]),a("li",[a("div",{staticClass:"text-custom"},[t._v("\n          7. Cơ sở vật chất (số liệu năm cuối kỳ đánh giá):\n        ")]),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ số diện tích sàn xây dựng trên sinh viên chính quy:\n          "),a("preview",{attrs:{data:t.data.ti_so_dien_tich_sv,keyData:"ti_so_dien_tich_sv"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Tỷ số chỗ ở ký túc xá trên sinh viên chính quy:\n          "),a("preview",{attrs:{data:t.data.ti_so_ktx_sv,keyData:"ti_so_ktx_sv"},on:{edit:t.handleEdit}})],1)]),a("li",[a("div",{staticClass:"text-custom"},[t._v("\n          8. Kết quả kiểm định chất lượng giáo dục\n        ")]),a("div",{staticClass:"text-custom"},[t._v("\n          Cấp cơ sở giáo dục:\n          "),a("preview",{attrs:{data:t.data.cap_co_so,keyData:"cap_co_so"},on:{edit:t.handleEdit}})],1),a("div",{staticClass:"text-custom"},[t._v("\n          Cấp chương trình đào tạo:\n          "),a("preview",{attrs:{data:t.data.cap_ctdt,keyData:"cap_ctdt"},on:{edit:t.handleEdit}})],1)]),a("li",{staticClass:"bold"},[t._v("\n        [1] Việc xác định giảng viên cơ hữu và thỉnh giảng áp dụng theo các\n        quy định hiện hành.\n      ")]),a("li",{staticClass:"bold"},[t._v("\n        [2] Giảng viên cơ hữu được xác định theo quy định hiện hành.\n      ")])])])])},e=[],c=(a("6b54"),a("2397"),a("96cf"),a("3b8d")),s=a("d225"),o=a("b0b4"),r=a("4e2b"),h=a("308d"),_=a("6bb5"),d=a("9ab4"),l=a("60a3"),u=function(){var t=this,n=t.$createElement,a=t._self._c||n;return a("span",[t.isEdit?[a("el-input",{staticClass:"input-with-select",attrs:{placeholder:"Nhập"},model:{value:t.input,callback:function(n){t.input=n},expression:"input"}},[a("el-button",{attrs:{slot:"append",type:"success",icon:"el-icon-check"},on:{click:t.handleSave},slot:"append"})],1)]:[a("span",{staticClass:"text-content"},[t._v("\n      "+t._s(t.data)+"\n      "),a("el-button",{staticClass:"t-button",attrs:{type:"text",icon:"el-icon-edit"},on:{click:t.handleEdit}})],1)]],2)},v=[];function g(t){var n=p();return function(){var a,i=Object(_["a"])(t);if(n){var e=Object(_["a"])(this).constructor;a=Reflect.construct(i,arguments,e)}else a=i.apply(this,arguments);return Object(h["a"])(this,a)}}function p(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}var b=function(t){Object(r["a"])(a,t);var n=g(a);function a(){var t;return Object(s["a"])(this,a),t=n.apply(this,arguments),t.isEdit=!1,t.input="",t}return Object(o["a"])(a,[{key:"handleEdit",value:function(){this.isEdit=!0}},{key:"handleSave",value:function(){this.isEdit=!1,this.$emit("edit",{key:this.keyData,newVal:this.input})}}]),a}(l["c"]);Object(d["a"])([Object(l["b"])({required:!1,default:""})],b.prototype,"data",void 0),Object(d["a"])([Object(l["b"])({type:String,required:!1,default:""})],b.prototype,"keyData",void 0),b=Object(d["a"])([l["a"]],b);var y=b,m=y,f=(a("2187"),a("2877")),k=Object(f["a"])(m,u,v,!1,null,"6e4d0a1f",null),x=k.exports;function w(t){var n=C();return function(){var a,i=Object(_["a"])(t);if(n){var e=Object(_["a"])(this).constructor;a=Reflect.construct(i,arguments,e)}else a=i.apply(this,arguments);return Object(h["a"])(this,a)}}function C(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}var D=function(t){Object(r["a"])(a,t);var n=w(a);function a(){var t;return Object(s["a"])(this,a),t=n.apply(this,arguments),t.year=new Date,t.isLoading=!1,t.data={},t}return Object(o["a"])(a,[{key:"changeYear",value:function(t){t&&this.init()}},{key:"created",value:function(){this.init()}},{key:"init",value:function(){var t=Object(c["a"])(regeneratorRuntime.mark((function t(){var n;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.prev=0,this.isLoading=!0,this.resetData(),t.next=5,this.axios.get("tom-tat-chi-so/".concat(this.year.getFullYear()));case 5:n=t.sent,n.data.data.tom_tat&&(this.data=n.data.data.tom_tat),this.isLoading=!1,t.next=14;break;case 10:t.prev=10,t.t0=t["catch"](0),this.isLoading=!1,console.log(t.t0);case 14:case"end":return t.stop()}}),t,this,[[0,10]])})));function n(){return t.apply(this,arguments)}return n}()},{key:"handleEdit",value:function(){var t=Object(c["a"])(regeneratorRuntime.mark((function t(n){var a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.prev=0,this.data[n.key]=n.newVal,a={},a[n.key]=n.newVal,t.next=6,this.axios.post("tom-tat-chi-so/".concat(this.year.getFullYear()),a);case 6:this.$notify.success("Cập nhật thông tin thành công"),t.next=12;break;case 9:t.prev=9,t.t0=t["catch"](0),console.log(t.t0);case 12:case"end":return t.stop()}}),t,this,[[0,9]])})));function n(n){return t.apply(this,arguments)}return n}()},{key:"handleAuto",value:function(){var t=Object(c["a"])(regeneratorRuntime.mark((function t(){var n;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.prev=0,this.isLoading=!0,this.resetData(),t.next=5,this.axios.post("tom-tat-chi-so/".concat(this.year.getFullYear(),"/tinh-toan"));case 5:n=t.sent,n.data.data.tom_tat&&(this.data=n.data.data.tom_tat),this.isLoading=!1,t.next=14;break;case 10:t.prev=10,t.t0=t["catch"](0),this.isLoading=!1,console.log(t.t0);case 14:case"end":return t.stop()}}),t,this,[[0,10]])})));function n(){return t.apply(this,arguments)}return n}()},{key:"resetData",value:function(){this.data={tong_gv_co_huu:0,ti_le_gv_cb:0,ti_le_gv_ts:0,ti_le_gv_ths:0,tong_sv:0,ti_le_sv_gv:0,ti_le_tot_nghiep:0,ti_le_tra_loi_duoc:0,ti_le_tra_loi_1_phan:0,ti_le_dung_nganh:0,ti_le_trai_nganh:0,ti_le_tu_tao:0,thu_nhap_binh_quan:0,ti_le_dap_ung_ngay:0,ti_le_dao_tao_them:0,ti_le_de_tai_cb:0,ti_so_doanh_thu:0,ti_so_sach_cb:0,ti_so_tap_chi_cb:0,ti_so_bai_bao_cb:0,ti_so_dien_tich_sv:0,ti_so_ktx_sv:0,cap_co_so:null,cap_ctdt:null}}}]),a}(l["c"]);Object(d["a"])([Object(l["d"])("year")],D.prototype,"changeYear",null),D=Object(d["a"])([Object(l["a"])({components:{Preview:x}})],D);var E=D,j=E,O=(a("7649"),Object(f["a"])(j,i,e,!1,null,"3e852255",null));n["default"]=O.exports},7649:function(t,n,a){"use strict";var i=a("767c"),e=a.n(i);e.a},"767c":function(t,n,a){},"95df":function(t,n,a){}}]);
//# sourceMappingURL=chunk-48d04672.10548b43.js.map