webpackJsonp([3],{

/***/ 538:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(626)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(565),
  /* template */
  __webpack_require__(599),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 565:
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



/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            tableData: [],
            loading: true,
            cur_page: 1,
            count: 0,
            pageSize: 15,
            uploadExcelLink: __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('uploadProductExcel'),
            dialogVisible: false,
            form: {
                A_khmc: '',
                B_ywy: '',
                C_gcah: '',
                D_dh: '',
                E_ph: '',
                F_pm: '',
                G_hpgg: '',
                H_dw: '',
                I_ckrq: '',
                J_sl: '',
                K_xhsl: '',
                L_wzxhsl: '',
                M_shrmc: '',
                N_yjfhrq: '',
                O_bz: ''
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
        errorList(index, row) {
            this.$router.push({ path: 'errorList', query: { id: row.id, page: '产品交期表' } });
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
            this.$axios.post('getProductDelivery', {
                pn: this.cur_page
            }, res => {
                if (res.ret == true) {
                    this.tableData = res.data.list;
                    this.count = res.data.count;
                    this.loading = false;
                }
            });
        },
        exportExel() {
            location.href = __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('downfileProduct');
        },
        del(index, row) {
            let self = this;

            this.$axios.post('delProductDelivery', {
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
            this.$axios.post('updateProductDelivery', this.form, res => {
                if (res.ret == true) {
                    this.$message.success('修改成功');
                    this.getData();
                    this.dialogVisible = false;
                }
            });
        }
    }
});

/***/ }),

/***/ 569:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".productTime .crumbs .el-upload{height:auto;width:auto;border:none}", ""]);

// exports


/***/ }),

/***/ 599:
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
  }), _vm._v(" 工作台")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("产品交期表")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs",
    staticStyle: {
      "overflow": "hidden"
    }
  }, [_c('el-upload', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.setUp != 4),
      expression: "setUp != 4"
    }],
    staticStyle: {
      "float": "right"
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
  }, [_vm._v("导入")])], 1), _vm._v(" "), _c('el-button', {
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
      "width": "100%"
    },
    attrs: {
      "data": _vm.tableData,
      "border": ""
    }
  }, [_c('el-table-column', {
    attrs: {
      "prop": "A_khmc",
      "label": "客户名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "B_ywy",
      "label": "业务员"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "C_gcah",
      "label": "工程案号"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "D_dh",
      "label": "单号"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "E_ph",
      "label": "品号"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "F_pm",
      "label": "品名"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "G_hpgg",
      "label": "货品规格"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "H_dw",
      "label": "单位"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "I_ckrq",
      "label": "出库日期"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "J_sl",
      "label": "数量"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "K_xhsl",
      "label": "销货数量"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "L_wzxhsl",
      "label": "未转销货数量"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "M_shrmc",
      "label": "审核人名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "N_yjfhrq",
      "label": "预计发货日期"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "O_bz",
      "label": "备注"
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
      "title": "修改产品交期表"
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
      "label-width": "100px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "客户名称"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入客户名称"
    },
    model: {
      value: (_vm.form.A_khmc),
      callback: function($$v) {
        _vm.$set(_vm.form, "A_khmc", $$v)
      },
      expression: "form.A_khmc"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "业务员"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入业务员"
    },
    model: {
      value: (_vm.form.B_ywy),
      callback: function($$v) {
        _vm.$set(_vm.form, "B_ywy", $$v)
      },
      expression: "form.B_ywy"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "工程案号"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入工程案号"
    },
    model: {
      value: (_vm.form.C_gcah),
      callback: function($$v) {
        _vm.$set(_vm.form, "C_gcah", $$v)
      },
      expression: "form.C_gcah"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "单号"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入单号"
    },
    model: {
      value: (_vm.form.D_dh),
      callback: function($$v) {
        _vm.$set(_vm.form, "D_dh", $$v)
      },
      expression: "form.D_dh"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "品号"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入品号"
    },
    model: {
      value: (_vm.form.E_ph),
      callback: function($$v) {
        _vm.$set(_vm.form, "E_ph", $$v)
      },
      expression: "form.E_ph"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "品名"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入品名"
    },
    model: {
      value: (_vm.form.F_pm),
      callback: function($$v) {
        _vm.$set(_vm.form, "F_pm", $$v)
      },
      expression: "form.F_pm"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "货品规格"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入货品规格"
    },
    model: {
      value: (_vm.form.G_hpgg),
      callback: function($$v) {
        _vm.$set(_vm.form, "G_hpgg", $$v)
      },
      expression: "form.G_hpgg"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "单位"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入单位"
    },
    model: {
      value: (_vm.form.H_dw),
      callback: function($$v) {
        _vm.$set(_vm.form, "H_dw", $$v)
      },
      expression: "form.H_dw"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "出库日期"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入出库日期"
    },
    model: {
      value: (_vm.form.I_ckrq),
      callback: function($$v) {
        _vm.$set(_vm.form, "I_ckrq", $$v)
      },
      expression: "form.I_ckrq"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "数量"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入数量"
    },
    model: {
      value: (_vm.form.J_sl),
      callback: function($$v) {
        _vm.$set(_vm.form, "J_sl", $$v)
      },
      expression: "form.J_sl"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "销货数量"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入销货数量"
    },
    model: {
      value: (_vm.form.K_xhsl),
      callback: function($$v) {
        _vm.$set(_vm.form, "K_xhsl", $$v)
      },
      expression: "form.K_xhsl"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "未转销货数量"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入未转销货数量"
    },
    model: {
      value: (_vm.form.L_wzxhsl),
      callback: function($$v) {
        _vm.$set(_vm.form, "L_wzxhsl", $$v)
      },
      expression: "form.L_wzxhsl"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "审核人名称"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入审核人名称"
    },
    model: {
      value: (_vm.form.M_shrmc),
      callback: function($$v) {
        _vm.$set(_vm.form, "M_shrmc", $$v)
      },
      expression: "form.M_shrmc"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "预计发货日期"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入预计发货日期"
    },
    model: {
      value: (_vm.form.N_yjfhrq),
      callback: function($$v) {
        _vm.$set(_vm.form, "N_yjfhrq", $$v)
      },
      expression: "form.N_yjfhrq"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "备注"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入备注"
    },
    model: {
      value: (_vm.form.O_bz),
      callback: function($$v) {
        _vm.$set(_vm.form, "O_bz", $$v)
      },
      expression: "form.O_bz"
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

/***/ 626:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(569);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("29742216", content, true);

/***/ })

});