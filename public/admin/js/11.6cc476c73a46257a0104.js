webpackJsonp([11],{531:function(t,e,a){a(642);var i=a(201)(a(561),a(614),null,null);t.exports=i.exports},561:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});a(202);e.default={data:function(){return{startTime:"",endTime:"",keyword:"",cur_page:1,count:0,pageSize:15,tableData:[],loading:!0,qiniuInitState:!1}},created:function(){this.getData()},methods:{pickerOptions0:{disabledDate:function(t){return t.getTime()<Date.now()-864e5}},filterTag:function(t,e){},getData:function(){var t=this;this.loading=!0,this.$axios.post("getBillData",{pn:this.cur_page,search:this.keyword,startTime:this.startTime,endTime:this.endTime},function(e){1==e.ret&&(t.tableData=e.data,t.loading=!1)})},add:function(){var t=this;this.$axios.post("addBanner",t.form,function(e){1==e.ret&&(t.getData(),t.$message.success("添加成功"))})},del:function(t,e){var a=this,i=this;this.$axios.post("delBanner",{id:e.id,fid:i.$route.query.id||0},function(e){1==e.ret&&(a.$message.success("删除成功"),i.tableData.splice(t,1))})}}}},583:function(t,e,a){e=t.exports=a(65)(),e.push([t.i,"",""])},614:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"table"},[a("div",{staticClass:"crumbs"},[a("el-row",[a("el-breadcrumb",{attrs:{separator:"/"}},[a("el-breadcrumb-item",[a("i",{staticClass:"el-icon-menu"}),t._v(" 工作台")]),t._v(" "),a("el-breadcrumb-item",[t._v("发票信息")])],1)],1)],1),t._v(" "),a("div",{staticClass:"crumbs"},[a("el-form",{staticStyle:{float:"left"},attrs:{inline:!0}},[a("el-form-item",[a("el-input",{staticClass:"inline",attrs:{placeholder:"请输入票据号码搜索",icon:"search","on-icon-click":t.getData},nativeOn:{keyup:function(e){if(!("button"in e)&&t._k(e.keyCode,"enter",13,e.key))return null;t.getData(e)}},model:{value:t.keyword,callback:function(e){t.keyword=e},expression:"keyword"}})],1),t._v(" "),a("el-date-picker",{attrs:{type:"date",placeholder:"开始日期","picker-options":t.pickerOptions0},on:{change:t.getData},model:{value:t.startTime,callback:function(e){t.startTime=e},expression:"startTime"}}),t._v(" "),a("el-date-picker",{attrs:{type:"date",placeholder:"结束日期","picker-options":t.pickerOptions0},on:{change:t.getData},model:{value:t.endTime,callback:function(e){t.endTime=e},expression:"endTime"}})],1),t._v(" "),a("el-button",{staticStyle:{float:"right","margin-right":"20px"},attrs:{type:"success"},on:{click:function(t){}}},[t._v("导出")])],1),t._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading.body",value:t.loading,expression:"loading",modifiers:{body:!0}}],staticStyle:{width:"100%"},attrs:{data:t.tableData,border:""}},[a("el-table-column",{attrs:{prop:"A_pjhm",label:"票据号码"}}),t._v(" "),a("el-table-column",{attrs:{prop:"B_pmje",label:"票面金额"}}),t._v(" "),a("el-table-column",{attrs:{prop:"C_kpsj",label:"开票时间"}}),t._v(" "),a("el-table-column",{attrs:{prop:"tag",label:"发票类型",filters:[{text:"家",value:"家"},{text:"公司",value:"公司"}],"filter-method":t.filterTag,"filter-placement":"bottom-end"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-tag",{attrs:{type:"家"===e.row.tag?"primary":"success","close-transition":""}},[t._v(t._s(e.row.tag))])]}}])})],1)],1)},staticRenderFns:[]}},642:function(t,e,a){var i=a(583);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);a(137)("90ac8e86",i,!0)}});