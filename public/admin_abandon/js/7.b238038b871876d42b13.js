webpackJsonp([7],{

/***/ 534:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(632)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(561),
  /* template */
  __webpack_require__(605),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 561:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_service_js__ = __webpack_require__(202);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            startTime: '',
            endTime: '',
            keyword: '',
            tableData: [],
            payDetailData: [],
            loading: true,
            cur_page: 1,
            count: 0,
            pageSize: 15,
            uploadExcelLinkOne: __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('uploadOrderOne'),
            uploadExcelLinkTwo: __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('uploadOrderTwo'),
            uploadExcelLinkThree: __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('uploadOrderThree'),
            uploadExcelLink: __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('uploadOrder'),
            dialogVisible: false,
            payDetailVisible: false,
            form: {
                A_hth: '',
                B_htqyrq: '',
                C_ssxm: '',
                D_khdw: '',
                E_zj: '',
                F_xsry: '',
                G_fh: '',
                H_fhbl: '',
                I_fp: '',
                J_fkje: '',
                K_fkbl: '',
                L_fkxq: '',
                M_qkje: '',
                N_wkdqr: '',
                O_sfcq: '',
                P_cwhxclyj: '',
                Q_xsclfk: ''
            },
            setUp: 0 //1：管理人员 2：销售助理 3:财务 4：销售人员
        };
    },
    created() {
        this.getData();
        let userInfo = localStorage.getItem('userInfo') && JSON.parse(localStorage.getItem('userInfo'));
        this.setUp = userInfo.setUp;
    },
    methods: {
        pickerOptions0: {
            disabledDate(time) {
                return time.getTime() < Date.now() - 8.64e7;
            }
        },
        errorList(index, row) {
            this.$router.push({ path: 'errorList', query: { id: row.id, page: '订单信息' } });
        },
        uploadExcelSuccess() {
            this.$message.success('上传成功');
            this.getData();
        },
        handleCurrentChange(val) {
            this.cur_page = val;
            this.getData();
        },
        getData() {
            this.loading = true;

            if (this.startTime.toString().indexOf('T') != -1) {
                this.startTime = +new Date(this.startTime);
            }

            if (this.endTime.toString().indexOf('T') != -1) {
                this.endTime = +new Date(this.endTime);
            }

            this.$axios.post('getOrderInfo', {
                pn: this.cur_page,
                search: this.keyword,
                startTime: this.startTime,
                endTime: this.endTime
            }, res => {
                if (res.ret == true) {
                    this.tableData = res.data.list;
                    this.count = res.data.count;
                    this.loading = false;
                }
            });
        },
        exportExel(index, row) {
            location.href = __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('downfileOrder') + '?search=' + this.keyword + '&startTime=' + this.startTime + '&endTime=' + this.endTime;
        },
        del(index, row) {
            let self = this;

            this.$axios.post('delOrderInfo', {
                id: row.id
            }, res => {
                if (res.ret == true) {
                    this.$message.success('删除成功');
                    self.tableData.splice(index, 1);
                }
            });
        },
        editModal(index, row) {
            this.dialogVisible = true;
            this.form = JSON.parse(JSON.stringify(row));
        },
        edit() {
            this.$axios.post('updateOrderInfo', this.form, res => {
                if (res.ret == true) {
                    this.$message.success('修改成功');
                    this.getData();
                    this.dialogVisible = false;
                }
            });
        },
        payDetail(index, row) {
            //console.log(index);
            //console.log(row);
            this.$axios.post('getPayDetail', row, res => {
                if (res.ret == true) {
                    this.payDetailData = res.data;
                }
            });
            this.payDetailVisible = true;
            this.payDetailData = [];
        }
    }
});

/***/ }),

/***/ 575:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".productTime .crumbs .el-upload{height:auto;width:auto;border:none}", ""]);

// exports


/***/ }),

/***/ 605:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "table productTime"
  }, [_c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-breadcrumb', {
    attrs: {
      "separator": "/"
    }
  }, [_c('el-breadcrumb-item', [_c('i', {
    staticClass: "el-icon-menu"
  }), _vm._v(" 工作台")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("订单信息")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs",
    staticStyle: {
      "overflow": "hidden"
    }
  }, [_c('el-form', {
    staticStyle: {
      "float": "left"
    },
    attrs: {
      "inline": true
    }
  }, [_c('el-form-item', [_c('el-input', {
    staticClass: "inline",
    attrs: {
      "placeholder": "请输入客户名称、合同号搜索",
      "icon": "search",
      "on-icon-click": _vm.getData
    },
    nativeOn: {
      "keyup": function($event) {
        if (!('button' in $event) && _vm._k($event.keyCode, "enter", 13, $event.key)) { return null; }
        _vm.getData($event)
      }
    },
    model: {
      value: (_vm.keyword),
      callback: function($$v) {
        _vm.keyword = $$v
      },
      expression: "keyword"
    }
  })], 1), _vm._v(" "), _c('el-date-picker', {
    attrs: {
      "type": "date",
      "placeholder": "开始日期",
      "picker-options": _vm.pickerOptions0
    },
    on: {
      "change": _vm.getData
    },
    model: {
      value: (_vm.startTime),
      callback: function($$v) {
        _vm.startTime = $$v
      },
      expression: "startTime"
    }
  }), _vm._v(" "), _c('el-date-picker', {
    attrs: {
      "type": "date",
      "placeholder": "结束日期",
      "picker-options": _vm.pickerOptions0
    },
    on: {
      "change": _vm.getData
    },
    model: {
      value: (_vm.endTime),
      callback: function($$v) {
        _vm.endTime = $$v
      },
      expression: "endTime"
    }
  })], 1), _vm._v(" "), _c('el-upload', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.setUp != 4),
      expression: "setUp != 4"
    }],
    staticStyle: {
      "float": "right",
      "margin-right": "20px"
    },
    attrs: {
      "on-success": _vm.uploadExcelSuccess,
      "show-file-list": false,
      "action": _vm.uploadExcelLinkThree
    }
  }, [_c('el-button', {
    attrs: {
      "type": "primary"
    }
  }, [_vm._v("导入收款明细")])], 1), _vm._v(" "), _c('el-upload', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.setUp != 4),
      expression: "setUp != 4"
    }],
    staticStyle: {
      "float": "right",
      "margin-right": "20px"
    },
    attrs: {
      "on-success": _vm.uploadExcelSuccess,
      "show-file-list": false,
      "action": _vm.uploadExcelLinkTwo
    }
  }, [_c('el-button', {
    attrs: {
      "type": "primary"
    }
  }, [_vm._v("导入发货统计")])], 1), _vm._v(" "), _c('el-upload', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.setUp != 4),
      expression: "setUp != 4"
    }],
    staticStyle: {
      "float": "right",
      "margin-right": "20px"
    },
    attrs: {
      "on-success": _vm.uploadExcelSuccess,
      "show-file-list": false,
      "action": _vm.uploadExcelLinkOne
    }
  }, [_c('el-button', {
    attrs: {
      "type": "primary"
    }
  }, [_vm._v("导入合同")])], 1), _vm._v(" "), _c('el-upload', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.setUp != 4),
      expression: "setUp != 4"
    }],
    staticStyle: {
      "float": "right",
      "margin-right": "20px"
    },
    attrs: {
      "on-success": _vm.uploadExcelSuccess,
      "show-file-list": false,
      "action": _vm.uploadExcelLink
    }
  }, [_c('el-button', {
    attrs: {
      "type": "primary"
    }
  }, [_vm._v("全量更新")])], 1), _vm._v(" "), _c('el-button', {
    staticStyle: {
      "float": "right",
      "margin-right": "20px"
    },
    attrs: {
      "type": "success"
    },
    on: {
      "click": _vm.exportExel
    }
  }, [_vm._v("导出")])], 1), _vm._v(" "), _c('el-table', {
    directives: [{
      name: "loading",
      rawName: "v-loading.body",
      value: (_vm.loading),
      expression: "loading",
      modifiers: {
        "body": true
      }
    }],
    staticStyle: {
      "width": "120%"
    },
    attrs: {
      "data": _vm.tableData,
      "border": ""
    }
  }, [_c('el-table-column', {
    attrs: {
      "prop": "A_hth",
      "label": "合同号"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "B_htqyrq",
      "label": "合同签约日期"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "D_khdw",
      "label": "客户名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "E_zj",
      "label": "总价"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "F_xsry",
      "label": "销售人员"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "G_fh",
      "label": "发货"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "H_fhbl",
      "label": "发货比例"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "J_fkje",
      "label": "付款金额"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "",
      "label": "付款明细",
      "width": "90"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-button', {
          attrs: {
            "size": "small",
            "type": "success"
          },
          on: {
            "click": function($event) {
              _vm.payDetail(scope.$index, scope.row.A_hth)
            }
          }
        }, [_vm._v("查看")])]
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "K_fkbl",
      "label": "付款比例"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "M_qkje",
      "label": "欠款金额"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "N_wkdqr",
      "label": "尾款到期日"
    }
  }), _vm._v(" "), (_vm.setUp != 4) ? _c('el-table-column', {
    attrs: {
      "label": "操作",
      "width": "180"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-button', {
          attrs: {
            "size": "small",
            "type": "success"
          },
          on: {
            "click": function($event) {
              _vm.editModal(scope.$index, scope.row)
            }
          }
        }, [_vm._v("修改")]), _vm._v(" "), _c('el-button', {
          attrs: {
            "size": "small",
            "type": "danger"
          },
          on: {
            "click": function($event) {
              _vm.del(scope.$index, scope.row)
            }
          }
        }, [_vm._v("删除")])]
      }
    }])
  }) : _vm._e()], 1), _vm._v(" "), _c('div', {
    staticClass: "pagination"
  }, [_c('el-pagination', {
    attrs: {
      "layout": "prev, pager, next",
      "total": _vm.count,
      "page-size": _vm.pageSize
    },
    on: {
      "current-change": _vm.handleCurrentChange
    }
  })], 1), _vm._v(" "), _c('el-dialog', {
    attrs: {
      "title": "付款明细信息"
    },
    model: {
      value: (_vm.payDetailVisible),
      callback: function($$v) {
        _vm.payDetailVisible = $$v
      },
      expression: "payDetailVisible"
    }
  }, [_c('el-table', {
    directives: [{
      name: "loading",
      rawName: "v-loading.body",
      value: (_vm.loading),
      expression: "loading",
      modifiers: {
        "body": true
      }
    }],
    attrs: {
      "data": _vm.payDetailData,
      "border": "",
      "label-width": "120px"
    }
  }, [_c('el-table-column', {
    attrs: {
      "prop": "",
      "label": "合同号"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "",
      "label": "付款金额"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "",
      "label": "付款时间"
    }
  })], 1)], 1), _vm._v(" "), _c('el-dialog', {
    attrs: {
      "title": "修改订单信息"
    },
    model: {
      value: (_vm.dialogVisible),
      callback: function($$v) {
        _vm.dialogVisible = $$v
      },
      expression: "dialogVisible"
    }
  }, [_c('el-form', {
    ref: "form",
    attrs: {
      "model": _vm.form,
      "label-width": "120px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "合同号"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入合同号"
    },
    model: {
      value: (_vm.form.A_hth),
      callback: function($$v) {
        _vm.$set(_vm.form, "A_hth", $$v)
      },
      expression: "form.A_hth"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "合同签约日期"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入合同签约日期"
    },
    model: {
      value: (_vm.form.B_htqyrq),
      callback: function($$v) {
        _vm.$set(_vm.form, "B_htqyrq", $$v)
      },
      expression: "form.B_htqyrq"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "所属项目"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入所属项目"
    },
    model: {
      value: (_vm.form.C_ssxm),
      callback: function($$v) {
        _vm.$set(_vm.form, "C_ssxm", $$v)
      },
      expression: "form.C_ssxm"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "客户单位"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入客户单位"
    },
    model: {
      value: (_vm.form.D_khdw),
      callback: function($$v) {
        _vm.$set(_vm.form, "D_khdw", $$v)
      },
      expression: "form.D_khdw"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "总价"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入总价"
    },
    model: {
      value: (_vm.form.E_zj),
      callback: function($$v) {
        _vm.$set(_vm.form, "E_zj", $$v)
      },
      expression: "form.E_zj"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "销售人员"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入销售人员"
    },
    model: {
      value: (_vm.form.F_xsry),
      callback: function($$v) {
        _vm.$set(_vm.form, "F_xsry", $$v)
      },
      expression: "form.F_xsry"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "发货"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入发货"
    },
    model: {
      value: (_vm.form.G_fh),
      callback: function($$v) {
        _vm.$set(_vm.form, "G_fh", $$v)
      },
      expression: "form.G_fh"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "发货比例"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入发货比例"
    },
    model: {
      value: (_vm.form.H_fhbl),
      callback: function($$v) {
        _vm.$set(_vm.form, "H_fhbl", $$v)
      },
      expression: "form.H_fhbl"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "发票"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入发票"
    },
    model: {
      value: (_vm.form.I_fp),
      callback: function($$v) {
        _vm.$set(_vm.form, "I_fp", $$v)
      },
      expression: "form.I_fp"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "付款金额"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入付款金额"
    },
    model: {
      value: (_vm.form.J_fkje),
      callback: function($$v) {
        _vm.$set(_vm.form, "J_fkje", $$v)
      },
      expression: "form.J_fkje"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "付款比例"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入付款比例"
    },
    model: {
      value: (_vm.form.K_fkbl),
      callback: function($$v) {
        _vm.$set(_vm.form, "K_fkbl", $$v)
      },
      expression: "form.K_fkbl"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "付款详情"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入付款详情"
    },
    model: {
      value: (_vm.form.L_fkxq),
      callback: function($$v) {
        _vm.$set(_vm.form, "L_fkxq", $$v)
      },
      expression: "form.L_fkxq"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "欠款金额"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入欠款金额"
    },
    model: {
      value: (_vm.form.M_qkje),
      callback: function($$v) {
        _vm.$set(_vm.form, "M_qkje", $$v)
      },
      expression: "form.M_qkje"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "尾款到期日"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入尾款到期日"
    },
    model: {
      value: (_vm.form.N_wkdqr),
      callback: function($$v) {
        _vm.$set(_vm.form, "N_wkdqr", $$v)
      },
      expression: "form.N_wkdqr"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "是否超期"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入是否超期"
    },
    model: {
      value: (_vm.form.O_sfcq),
      callback: function($$v) {
        _vm.$set(_vm.form, "O_sfcq", $$v)
      },
      expression: "form.O_sfcq"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "财务后续处理意见"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入财务后续处理意见"
    },
    model: {
      value: (_vm.form.P_cwhxclyj),
      callback: function($$v) {
        _vm.$set(_vm.form, "P_cwhxclyj", $$v)
      },
      expression: "form.P_cwhxclyj"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "销售处理反馈"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入销售处理反馈"
    },
    model: {
      value: (_vm.form.Q_xsclfk),
      callback: function($$v) {
        _vm.$set(_vm.form, "Q_xsclfk", $$v)
      },
      expression: "form.Q_xsclfk"
    }
  })], 1)], 1), _vm._v(" "), _c('span', {
    staticClass: "dialog-footer",
    attrs: {
      "slot": "footer"
    },
    slot: "footer"
  }, [_c('el-button', {
    on: {
      "click": function($event) {
        _vm.dialogVisible = false
      }
    }
  }, [_vm._v("取 消")]), _vm._v(" "), _c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.edit
    }
  }, [_vm._v("确 定")])], 1)], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 632:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(575);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("a1b05c24", content, true);

/***/ })

});