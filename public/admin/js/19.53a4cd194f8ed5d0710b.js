webpackJsonp([19],{522:function(t,e,a){a(652);var l=a(201)(a(551),a(626),null,null);t.exports=l.exports},551:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var l=a(202);e.default={data:function(){return{tableData:[],loading:!0,keyword:"",type:1,cur_page:1,count:0,pageSize:15,uploadExcelLink:l.a.url("uploadExcelAgent"),uploadExcelLink2:l.a.url("uploadExcelAgent2"),addDialogVisible:!1,applyList:[],curApplyData:{},curApplyIndex:0,selection:[]}},watch:{type:function(t){this.tableData=[],this.getData()}},created:function(){this.getData()},methods:{downloadTemplate:function(){location.href=l.a.url("downloadTemplateAgent")+"?type="+this.type},handleSelectionAll:function(t){console.log(t),this.selection=t},handleSelectionChange:function(t,e){console.log(t,e),this.selection=t},operationConfirm:function(){var t=this,e=[];this.selection.forEach(function(t){e.push(t.id)}),this.$axios.post("operationConfirmAgent",{id:this.curApplyData.id,applyId:e},function(e){1==e.ret&&(t.$message.success("审核成功"),t.curApplyData.applyNum=0,t.tableData.splice(t.curApplyIndex,1),t.addDialogVisible=!1)})},audit:function(t,e){var a=this;this.addDialogVisible=!0,this.curApplyData=e,this.curApplyIndex=t,this.$axios.post("getAgentApplyList",{id:e.id},function(t){1==t.ret&&(console.log(t.data),a.applyList=t.data)})},uploadExcelSuccess:function(){this.$message.success("上传成功"),this.getData()},add:function(){this.$router.push("addAgent")},edit:function(t,e){this.$router.push({path:"addAgent",query:{id:e.id}})},handleCurrentChange:function(t){this.cur_page=t,this.getData()},getData:function(){var t=this;this.loading=!0,this.$axios.post("getAgent",{type:this.type,pn:this.cur_page,name:this.keyword},function(e){1==e.ret&&(t.tableData=e.data.list,t.count=e.data.count,t.loading=!1)})},del:function(t,e){var a=this,l=this;this.$axios.post("delAgent",{id:e.id},function(e){1==e.ret&&(a.$message.success("删除成功"),l.tableData.splice(t,1))})}}}},595:function(t,e,a){e=t.exports=a(65)(),e.push([t.i,".customer .crumbs .el-form-item{margin-bottom:0}.customer .crumbs .el-upload{height:auto;width:auto;border:none}",""])},626:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"table customer"},[a("div",{staticClass:"crumbs"},[a("el-row",[a("el-breadcrumb",{attrs:{separator:"/"}},[a("el-breadcrumb-item",[a("i",{staticClass:"el-icon-menu"}),t._v(" 代理商管理")]),t._v(" "),a("el-breadcrumb-item",[t._v("代理商池")])],1)],1)],1),t._v(" "),a("div",{staticClass:"crumbs"},[a("el-row",[a("el-col",{attrs:{span:24}},[a("el-button",{staticStyle:{float:"right","margin-left":"20px"},attrs:{type:"primary"},on:{click:t.add}},[t._v("新增代理商")]),t._v(" "),a("el-upload",{directives:[{name:"show",rawName:"v-show",value:1==t.type,expression:"type == 1"}],staticStyle:{float:"right"},attrs:{"on-success":t.uploadExcelSuccess,"show-file-list":!1,action:t.uploadExcelLink}},[a("el-button",{attrs:{type:"primary"}},[t._v("导入代理商")])],1),t._v(" "),a("el-upload",{directives:[{name:"show",rawName:"v-show",value:2==t.type,expression:"type == 2"}],staticStyle:{float:"right"},attrs:{"on-success":t.uploadExcelSuccess,"show-file-list":!1,action:t.uploadExcelLink2}},[a("el-button",{attrs:{type:"primary"}},[t._v("导入代理人")])],1),t._v(" "),a("el-button",{staticStyle:{float:"right","margin-right":"20px"},attrs:{type:"success"},on:{click:t.downloadTemplate}},[t._v("下载导入模板")]),t._v(" "),a("el-form",{attrs:{inline:!0}},[a("el-form-item",[a("el-input",{staticClass:"inline",attrs:{placeholder:"请输入代理商名称搜索",icon:"search","on-icon-click":t.getData},nativeOn:{keyup:function(e){if(!("button"in e)&&t._k(e.keyCode,"enter",13,e.key))return null;t.getData(e)}},model:{value:t.keyword,callback:function(e){t.keyword=e},expression:"keyword"}})],1),t._v(" "),a("el-radio-group",{model:{value:t.type,callback:function(e){t.type=e},expression:"type"}},[a("el-radio-button",{attrs:{label:"1"}},[t._v("代理商")]),t._v(" "),a("el-radio-button",{attrs:{label:"2"}},[t._v("代理人")])],1)],1)],1)],1)],1),t._v(" "),a("el-table",{directives:[{name:"show",rawName:"v-show",value:1==t.type,expression:"type == 1"},{name:"loading",rawName:"v-loading.body",value:t.loading,expression:"loading",modifiers:{body:!0}}],staticStyle:{width:"100%"},attrs:{data:t.tableData,border:""}},[a("el-table-column",{attrs:{prop:"name",label:"代理商名称"}}),t._v(" "),a("el-table-column",{attrs:{prop:"code",label:"代理商编码"}}),t._v(" "),a("el-table-column",{attrs:{prop:"abbreviation",label:"代理商简称"}}),t._v(" "),a("el-table-column",{attrs:{prop:"legalRepresentative",label:"法定代表人"}}),t._v(" "),a("el-table-column",{attrs:{prop:"registeredCapital",label:"注册资金/万"}}),t._v(" "),a("el-table-column",{attrs:{prop:"lastYearSales",label:"去年贡献收入/万"}}),t._v(" "),a("el-table-column",{attrs:{prop:"proxyLevel",label:"代理级别"}}),t._v(" "),a("el-table-column",{attrs:{prop:"explain",label:"其他情况说明"}}),t._v(" "),a("el-table-column",{attrs:{label:"操作",width:"220"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{size:"small",type:"warning"},on:{click:function(a){t.edit(e.$index,e.row)}}},[t._v("修改")]),t._v(" "),a("el-button",{attrs:{size:"small",type:"danger"},on:{click:function(a){t.del(e.$index,e.row)}}},[t._v("删除")]),t._v(" "),e.row.applyNum>0?a("el-button",{attrs:{size:"small",type:"info"},on:{click:function(a){t.audit(e.$index,e.row)}}},[t._v("跟进审核")]):t._e()]}}])})],1),t._v(" "),a("el-table",{directives:[{name:"show",rawName:"v-show",value:2==t.type,expression:"type == 2"},{name:"loading",rawName:"v-loading.body",value:t.loading,expression:"loading",modifiers:{body:!0}}],staticStyle:{width:"100%"},attrs:{data:t.tableData,border:""}},[a("el-table-column",{attrs:{prop:"name",label:"代理商名称"}}),t._v(" "),a("el-table-column",{attrs:{prop:"code",label:"代理商编码"}}),t._v(" "),a("el-table-column",{attrs:{prop:"explain",label:"其他情况说明"}}),t._v(" "),a("el-table-column",{attrs:{label:"操作",width:"220"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{size:"small",type:"warning"},on:{click:function(a){t.edit(e.$index,e.row)}}},[t._v("修改")]),t._v(" "),a("el-button",{attrs:{size:"small",type:"danger"},on:{click:function(a){t.del(e.$index,e.row)}}},[t._v("删除")]),t._v(" "),e.row.applyNum>0?a("el-button",{attrs:{size:"small",type:"info"},on:{click:function(a){t.audit(e.$index,e.row)}}},[t._v("跟进审核")]):t._e()]}}])})],1),t._v(" "),a("el-dialog",{attrs:{title:"跟进审核"},model:{value:t.addDialogVisible,callback:function(e){t.addDialogVisible=e},expression:"addDialogVisible"}},[a("el-table",{staticStyle:{width:"100%"},attrs:{data:t.applyList,border:""},on:{"select-all":t.handleSelectionAll,select:t.handleSelectionChange}},[a("el-table-column",{attrs:{type:"selection",width:"55"}}),t._v(" "),a("el-table-column",{attrs:{prop:"userName",label:"姓名"}}),t._v(" "),a("el-table-column",{attrs:{prop:"create",label:"申请时间"}})],1),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.addDialogVisible=!1}}},[t._v("取 消")]),t._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:t.operationConfirm}},[t._v("同意跟进")])],1)],1),t._v(" "),a("div",{staticClass:"pagination"},[a("el-pagination",{attrs:{layout:"prev, pager, next",total:t.count,"page-size":t.pageSize},on:{"current-change":t.handleCurrentChange}})],1)],1)},staticRenderFns:[]}},652:function(t,e,a){var l=a(595);"string"==typeof l&&(l=[[t.i,l,""]]),l.locals&&(t.exports=l.locals);a(137)("599ba0f3",l,!0)}});