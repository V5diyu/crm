webpackJsonp([6],{535:function(t,e,a){a(629);var s=a(200)(a(563),a(603),null,null);t.exports=s.exports},563:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={data:function(){return{tableData:[],qiniuInitState:!1,loading:!0}},created:function(){this.getData()},methods:{filterTag:function(t,e){},getData:function(){var t=this;this.loading=!0,this.$axios.post("getBanner",{type:this.type},function(e){1==e.ret&&(t.tableData=e.data,t.loading=!1)})},add:function(){var t=this;this.$axios.post("addBanner",t.form,function(e){1==e.ret&&(t.getData(),t.$message.success("添加成功"))})},del:function(t,e){var a=this,s=this;this.$axios.post("delBanner",{id:e.id,fid:s.$route.query.id||0},function(e){1==e.ret&&(a.$message.success("删除成功"),s.tableData.splice(t,1))})}}}},574:function(t,e,a){e=t.exports=a(64)(),e.push([t.i,"",""])},603:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"table"},[a("div",{staticClass:"crumbs"},[a("el-row",[a("el-breadcrumb",{attrs:{separator:"/"}},[a("el-breadcrumb-item",[a("i",{staticClass:"el-icon-menu"}),t._v(" 工作台")]),t._v(" "),a("el-breadcrumb-item",[t._v("销项发票")])],1)],1)],1),t._v(" "),a("div",{staticClass:"crumbs"},[a("el-row",[a("el-col",{attrs:{span:24}},[a("el-button",{staticStyle:{float:"right"},attrs:{type:"primary"}},[t._v("导出")])],1)],1)],1),t._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading.body",value:t.loading,expression:"loading",modifiers:{body:!0}}],staticStyle:{width:"100%"},attrs:{data:t.tableData,border:""}},[a("el-table-column",{attrs:{prop:"name",label:"申请人"}}),t._v(" "),a("el-table-column",{attrs:{prop:"name",label:"客户名称"}}),t._v(" "),a("el-table-column",{attrs:{prop:"name",label:"申请时间"}}),t._v(" "),a("el-table-column",{attrs:{prop:"tag",label:"发票类型",filters:[{text:"家",value:"家"},{text:"公司",value:"公司"}],"filter-method":t.filterTag,"filter-placement":"bottom-end"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-tag",{attrs:{type:"家"===e.row.tag?"primary":"success","close-transition":""}},[t._v(t._s(e.row.tag))])]}}])})],1)],1)},staticRenderFns:[]}},629:function(t,e,a){var s=a(574);"string"==typeof s&&(s=[[t.i,s,""]]),s.locals&&(t.exports=s.locals);a(136)("1d8a873d",s,!0)}});