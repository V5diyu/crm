webpackJsonp([2],{539:function(e,t,l){l(637);var a=l(201)(l(569),l(609),null,null);e.exports=a.exports},541:function(e,t,l){e.exports={default:l(542),__esModule:!0}},542:function(e,t,l){var a=l(66),o=a.JSON||(a.JSON={stringify:JSON.stringify});e.exports=function(e){return o.stringify.apply(o,arguments)}},569:function(e,t,l){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=l(541),o=l.n(a),r=l(202);t.default={data:function(){return{tableData:[],loading:!0,cur_page:1,count:0,pageSize:15,uploadExcelLink:r.a.url("uploadProductExcel"),dialogVisible:!1,form:{A_khmc:"",B_ywy:"",C_gcah:"",D_dh:"",E_ph:"",F_pm:"",G_hpgg:"",H_dw:"",I_ckrq:"",J_sl:"",K_xhsl:"",L_wzxhsl:"",M_shrmc:"",N_yjfhrq:"",O_bz:""},setUp:0}},created:function(){this.getData();var e=localStorage.getItem("userInfo")&&JSON.parse(localStorage.getItem("userInfo"));this.setUp=e.setUp},methods:{errorList:function(e,t){this.$router.push({path:"errorList",query:{id:t.id,page:"产品交期表"}})},uploadExcelSuccess:function(){this.$message.success("上传成功"),this.getData()},handleCurrentChange:function(e){this.cur_page=e,this.getData()},getData:function(){var e=this;this.loading=!0,this.$axios.post("getProductDelivery",{pn:this.cur_page},function(t){1==t.ret&&(e.tableData=t.data.list,e.count=t.data.count,e.loading=!1)})},exportExel:function(){location.href=r.a.url("downfileProduct")},del:function(e,t){var l=this,a=this;this.$axios.post("delProductDelivery",{id:t.id},function(t){1==t.ret&&(l.$message.success("删除成功"),a.tableData.splice(e,1))})},editModal:function(e,t){this.dialogVisible=!0,this.form=JSON.parse(o()(t))},edit:function(){var e=this;this.$axios.post("updateProductDelivery",this.form,function(t){1==t.ret&&(e.$message.success("修改成功"),e.getData(),e.dialogVisible=!1)})}}}},578:function(e,t,l){t=e.exports=l(65)(),t.push([e.i,".productTime .crumbs .el-upload{height:auto;width:auto;border:none}",""])},609:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,l=e._self._c||t;return l("div",{staticClass:"table productTime"},[l("div",{staticClass:"crumbs"},[l("el-row",[l("el-breadcrumb",{attrs:{separator:"/"}},[l("el-breadcrumb-item",[l("i",{staticClass:"el-icon-menu"}),e._v(" 工作台")]),e._v(" "),l("el-breadcrumb-item",[e._v("产品交期表")])],1)],1)],1),e._v(" "),l("div",{staticClass:"crumbs",staticStyle:{overflow:"hidden"}},[l("el-upload",{directives:[{name:"show",rawName:"v-show",value:4!=e.setUp,expression:"setUp != 4"}],staticStyle:{float:"right"},attrs:{"on-success":e.uploadExcelSuccess,"show-file-list":!1,action:e.uploadExcelLink}},[l("el-button",{attrs:{type:"primary"}},[e._v("导入")])],1),e._v(" "),l("el-button",{staticStyle:{float:"right","margin-right":"20px"},attrs:{type:"success"},on:{click:e.exportExel}},[e._v("导出")])],1),e._v(" "),l("el-table",{directives:[{name:"loading",rawName:"v-loading.body",value:e.loading,expression:"loading",modifiers:{body:!0}}],staticStyle:{width:"100%"},attrs:{data:e.tableData,border:""}},[4!=e.setUp?l("el-table-column",{attrs:{label:"操作",width:"135"},scopedSlots:e._u([{key:"default",fn:function(t){return[l("el-button",{attrs:{size:"small",type:"success"},on:{click:function(l){e.editModal(t.$index,t.row)}}},[e._v("修改")]),e._v(" "),l("el-button",{attrs:{size:"small",type:"danger"},on:{click:function(l){e.del(t.$index,t.row)}}},[e._v("删除")])]}}])}):e._e(),e._v(" "),l("el-table-column",{attrs:{prop:"A_khmc",label:"客户名称"}}),e._v(" "),l("el-table-column",{attrs:{prop:"B_ywy",label:"业务员"}}),e._v(" "),l("el-table-column",{attrs:{prop:"C_gcah",label:"工程案号"}}),e._v(" "),l("el-table-column",{attrs:{prop:"D_dh",label:"单号"}}),e._v(" "),l("el-table-column",{attrs:{prop:"E_ph",label:"品号"}}),e._v(" "),l("el-table-column",{attrs:{prop:"F_pm",label:"品名"}}),e._v(" "),l("el-table-column",{attrs:{prop:"G_hpgg",label:"货品规格"}}),e._v(" "),l("el-table-column",{attrs:{prop:"H_dw",label:"单位"}}),e._v(" "),l("el-table-column",{attrs:{prop:"I_ckrq",label:"出库日期"}}),e._v(" "),l("el-table-column",{attrs:{prop:"J_sl",label:"数量"}}),e._v(" "),l("el-table-column",{attrs:{prop:"K_xhsl",label:"销货数量"}}),e._v(" "),l("el-table-column",{attrs:{prop:"L_wzxhsl",label:"未转销货数量"}}),e._v(" "),l("el-table-column",{attrs:{prop:"M_shrmc",label:"审核人名称"}}),e._v(" "),l("el-table-column",{attrs:{prop:"N_yjfhrq",label:"预计发货日期"}}),e._v(" "),l("el-table-column",{attrs:{prop:"O_bz",label:"备注"}})],1),e._v(" "),l("div",{staticClass:"pagination"},[l("el-pagination",{attrs:{layout:"prev, pager, next",total:e.count,"page-size":e.pageSize},on:{"current-change":e.handleCurrentChange}})],1),e._v(" "),l("el-dialog",{attrs:{title:"修改产品交期表"},model:{value:e.dialogVisible,callback:function(t){e.dialogVisible=t},expression:"dialogVisible"}},[l("el-form",{ref:"form",attrs:{model:e.form,"label-width":"100px"}},[l("el-form-item",{attrs:{label:"客户名称"}},[l("el-input",{attrs:{placeholder:"请输入客户名称"},model:{value:e.form.A_khmc,callback:function(t){e.$set(e.form,"A_khmc",t)},expression:"form.A_khmc"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"业务员"}},[l("el-input",{attrs:{placeholder:"请输入业务员"},model:{value:e.form.B_ywy,callback:function(t){e.$set(e.form,"B_ywy",t)},expression:"form.B_ywy"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"工程案号"}},[l("el-input",{attrs:{placeholder:"请输入工程案号"},model:{value:e.form.C_gcah,callback:function(t){e.$set(e.form,"C_gcah",t)},expression:"form.C_gcah"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"单号"}},[l("el-input",{attrs:{placeholder:"请输入单号"},model:{value:e.form.D_dh,callback:function(t){e.$set(e.form,"D_dh",t)},expression:"form.D_dh"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"品号"}},[l("el-input",{attrs:{placeholder:"请输入品号"},model:{value:e.form.E_ph,callback:function(t){e.$set(e.form,"E_ph",t)},expression:"form.E_ph"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"品名"}},[l("el-input",{attrs:{placeholder:"请输入品名"},model:{value:e.form.F_pm,callback:function(t){e.$set(e.form,"F_pm",t)},expression:"form.F_pm"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"货品规格"}},[l("el-input",{attrs:{placeholder:"请输入货品规格"},model:{value:e.form.G_hpgg,callback:function(t){e.$set(e.form,"G_hpgg",t)},expression:"form.G_hpgg"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"单位"}},[l("el-input",{attrs:{placeholder:"请输入单位"},model:{value:e.form.H_dw,callback:function(t){e.$set(e.form,"H_dw",t)},expression:"form.H_dw"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"出库日期"}},[l("el-input",{attrs:{placeholder:"请输入出库日期"},model:{value:e.form.I_ckrq,callback:function(t){e.$set(e.form,"I_ckrq",t)},expression:"form.I_ckrq"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"数量"}},[l("el-input",{attrs:{placeholder:"请输入数量"},model:{value:e.form.J_sl,callback:function(t){e.$set(e.form,"J_sl",t)},expression:"form.J_sl"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"销货数量"}},[l("el-input",{attrs:{placeholder:"请输入销货数量"},model:{value:e.form.K_xhsl,callback:function(t){e.$set(e.form,"K_xhsl",t)},expression:"form.K_xhsl"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"未转销货数量"}},[l("el-input",{attrs:{placeholder:"请输入未转销货数量"},model:{value:e.form.L_wzxhsl,callback:function(t){e.$set(e.form,"L_wzxhsl",t)},expression:"form.L_wzxhsl"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"审核人名称"}},[l("el-input",{attrs:{placeholder:"请输入审核人名称"},model:{value:e.form.M_shrmc,callback:function(t){e.$set(e.form,"M_shrmc",t)},expression:"form.M_shrmc"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"预计发货日期"}},[l("el-input",{attrs:{placeholder:"请输入预计发货日期"},model:{value:e.form.N_yjfhrq,callback:function(t){e.$set(e.form,"N_yjfhrq",t)},expression:"form.N_yjfhrq"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"备注"}},[l("el-input",{attrs:{placeholder:"请输入备注"},model:{value:e.form.O_bz,callback:function(t){e.$set(e.form,"O_bz",t)},expression:"form.O_bz"}})],1)],1),e._v(" "),l("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[l("el-button",{on:{click:function(t){e.dialogVisible=!1}}},[e._v("取 消")]),e._v(" "),l("el-button",{attrs:{type:"primary"},on:{click:e.edit}},[e._v("确 定")])],1)],1)],1)},staticRenderFns:[]}},637:function(e,t,l){var a=l(578);"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);l(137)("29742216",a,!0)}});