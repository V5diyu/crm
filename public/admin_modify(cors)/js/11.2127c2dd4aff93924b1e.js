webpackJsonp([11],{530:function(t,e,a){a(651);var r=a(201)(a(559),a(625),null,null);t.exports=r.exports},559:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={data:function(){return{tableData:[],loading:!0,cur_page:1,count:0,pageSize:15}},created:function(){this.getData()},methods:{handleCurrentChange:function(t){this.cur_page=t,this.getData()},getData:function(){var t=this;this.loading=!0,"产品交期表"==this.$route.query.page?this.$axios.post("getProductErrorList",{pn:this.cur_page,id:this.$route.query.id},function(e){1==e.ret&&(t.tableData=e.data,t.loading=!1)}):this.$axios.post("getOrderErrorList",{pn:this.cur_page,id:this.$route.query.id},function(e){1==e.ret&&(t.tableData=e.data,t.loading=!1)})}}}},594:function(t,e,a){e=t.exports=a(65)(),e.push([t.i,"",""])},625:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"table productTime"},[a("div",{staticClass:"crumbs"},[a("el-row",[a("el-breadcrumb",{attrs:{separator:"/"}},[a("el-breadcrumb-item",[a("i",{staticClass:"el-icon-menu"}),t._v(" 工作台")]),t._v(" "),a("el-breadcrumb-item",[t._v(t._s(t.$route.query.page))]),t._v(" "),a("el-breadcrumb-item",[t._v("纠错列表")])],1)],1)],1),t._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading.body",value:t.loading,expression:"loading",modifiers:{body:!0}}],staticStyle:{width:"100%"},attrs:{data:t.tableData,border:""}},[a("el-table-column",{attrs:{prop:"userName",label:"纠错人"}}),t._v(" "),a("el-table-column",{attrs:{prop:"create",label:"时间"}}),t._v(" "),a("el-table-column",{attrs:{prop:"content",label:"纠错内容"}})],1)],1)},staticRenderFns:[]}},651:function(t,e,a){var r=a(594);"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);a(137)("11507a7f",r,!0)}});