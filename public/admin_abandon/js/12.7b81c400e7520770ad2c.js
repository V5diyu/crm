webpackJsonp([12],{

/***/ 529:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(643)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(556),
  /* template */
  __webpack_require__(617),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 556:
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



/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            tableData: [],
            count: 0,
            pageSize: 15,
            addDialogVisible: false,
            loading: true,
            form: {}
        };
    },
    created() {
        this.getData();
    },
    methods: {
        downloadTemplate() {
            location.href = __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('exportRecordCustomer');
        },
        edit(index, row) {
            this.addDialogVisible = true;
            this.form = row;
        },
        handleCurrentChange(pn) {
            this.pn = pn;
            this.getData();
        },
        getData() {
            this.loading = true;
            this.$axios.post('getSaleRecordList', {
                pn: this.pn
            }, res => {
                if (res.ret == true) {
                    this.tableData = res.data.list;
                    this.count = res.data.count;
                    this.loading = false;
                }
            });
        },
        getTime: function (time) {
            var d = new Date(time);
            var year = d.getFullYear();
            var mon = d.getMonth() + 1;
            var day = d.getDate();
            var hour = d.getHours();
            var minu = d.getMinutes();
            return year + '-' + mon + '-' + day + ' ' + hour + ':' + minu;
        },
        add() {
            let self = this;

            self.form.time = self.getTime(self.form.time);

            this.$axios.post('updateSaleRecordList', self.form, res => {
                if (res.ret == true) {
                    self.getData();
                    self.$message.success('修改成功');
                    self.addDialogVisible = false;
                }
            });
        }
    }
});

/***/ }),

/***/ 586:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".el-popover{max-width:80%}", ""]);

// exports


/***/ }),

/***/ 617:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "table"
  }, [_c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-breadcrumb', {
    attrs: {
      "separator": "/"
    }
  }, [_c('el-breadcrumb-item', [_c('i', {
    staticClass: "el-icon-menu"
  }), _vm._v(" 沟通记录")])], 1), _vm._v(" "), _c('el-button', {
    staticStyle: {
      "float": "right"
    },
    attrs: {
      "type": "success"
    },
    on: {
      "click": _vm.downloadTemplate
    }
  }, [_vm._v("导出沟通记录")])], 1)], 1), _vm._v(" "), _c('el-table', {
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
      "prop": "title",
      "label": "标题"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-popover', {
          attrs: {
            "trigger": "hover",
            "placement": "bottom"
          }
        }, [_c('p', [_vm._v(_vm._s(scope.row.title))]), _vm._v(" "), _c('div', {
          staticClass: "name-wrapper",
          staticStyle: {
            "overflow": "hidden",
            "text-overflow": "ellipsis"
          },
          attrs: {
            "slot": "reference"
          },
          slot: "reference"
        }, [_vm._v("\n                        " + _vm._s(scope.row.title) + "\n                    ")])])]
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "cName",
      "label": "客户名称"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-popover', {
          attrs: {
            "trigger": "hover",
            "placement": "bottom"
          }
        }, [_c('p', [_vm._v(_vm._s(scope.row.cName))]), _vm._v(" "), _c('div', {
          staticClass: "name-wrapper",
          staticStyle: {
            "overflow": "hidden",
            "text-overflow": "ellipsis"
          },
          attrs: {
            "slot": "reference"
          },
          slot: "reference"
        }, [_vm._v("\n                        " + _vm._s(scope.row.cName) + "\n                    ")])])]
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "userName",
      "label": "销售人员"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "customerName",
      "label": "沟通对象"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "time",
      "label": "时间"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "remark",
      "label": "内容"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-popover', {
          attrs: {
            "trigger": "hover",
            "placement": "bottom"
          }
        }, [_c('p', [_vm._v(_vm._s(scope.row.remark))]), _vm._v(" "), _c('div', {
          staticClass: "name-wrapper",
          staticStyle: {
            "overflow": "hidden",
            "text-overflow": "ellipsis"
          },
          attrs: {
            "slot": "reference"
          },
          slot: "reference"
        }, [_vm._v("\n                        " + _vm._s(scope.row.remark) + "\n                    ")])])]
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "操作",
      "width": "80"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-button', {
          attrs: {
            "size": "small",
            "type": "warning"
          },
          on: {
            "click": function($event) {
              _vm.edit(scope.$index, scope.row)
            }
          }
        }, [_vm._v("修改")])]
      }
    }])
  })], 1), _vm._v(" "), _c('div', {
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
      "title": "修改沟通记录"
    },
    model: {
      value: (_vm.addDialogVisible),
      callback: function($$v) {
        _vm.addDialogVisible = $$v
      },
      expression: "addDialogVisible"
    }
  }, [_c('el-form', {
    ref: "form",
    attrs: {
      "model": _vm.form,
      "label-width": "80px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "标题"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入标题"
    },
    model: {
      value: (_vm.form.title),
      callback: function($$v) {
        _vm.$set(_vm.form, "title", $$v)
      },
      expression: "form.title"
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
      value: (_vm.form.userName),
      callback: function($$v) {
        _vm.$set(_vm.form, "userName", $$v)
      },
      expression: "form.userName"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "沟通对象"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入沟通对象"
    },
    model: {
      value: (_vm.form.customerName),
      callback: function($$v) {
        _vm.$set(_vm.form, "customerName", $$v)
      },
      expression: "form.customerName"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "时间"
    }
  }, [_c('el-date-picker', {
    attrs: {
      "type": "datetime",
      "placeholder": "选择时间"
    },
    model: {
      value: (_vm.form.time),
      callback: function($$v) {
        _vm.$set(_vm.form, "time", $$v)
      },
      expression: "form.time"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "内容"
    }
  }, [_c('el-input', {
    attrs: {
      "type": "textarea",
      "placeholder": "请输入内容"
    },
    model: {
      value: (_vm.form.remark),
      callback: function($$v) {
        _vm.$set(_vm.form, "remark", $$v)
      },
      expression: "form.remark"
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
        _vm.addDialogVisible = false
      }
    }
  }, [_vm._v("取 消")]), _vm._v(" "), _c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.add
    }
  }, [_vm._v("确 定")])], 1)], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 643:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(586);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("53838c78", content, true);

/***/ })

});