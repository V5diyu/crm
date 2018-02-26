webpackJsonp([8],{

/***/ 533:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(639)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(560),
  /* template */
  __webpack_require__(612),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 560:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
            qiniuInitState: false,
            addDialogVisible: false,
            addDialogTitle: '添加管理员',
            loading: true,
            form: {
                name: '',
                account: '',
                pwd: '',
                setUp: 1
            }
        };
    },
    created() {
        this.getData();
    },
    methods: {
        addDialog() {
            this.addDialogVisible = true;
            this.addDialogTitle = '添加管理员';
            this.form = {
                name: '',
                account: '',
                pwd: '',
                setUp: 1
            };
        },
        edit(index, row) {
            this.addDialogVisible = true;
            this.addDialogTitle = '修改管理员';
            this.form = row;
        },
        getData() {
            this.loading = true;
            this.$axios.post('getAdmin', {
                type: this.type
            }, res => {
                if (res.ret == true) {
                    this.tableData = res.data;
                    this.loading = false;
                }
            });
        },
        add() {
            let self = this;

            if (self.form.id) {
                this.$axios.post('updateAdmin', self.form, res => {
                    if (res.ret == true) {
                        self.getData();
                        self.$message.success('修改成功');
                        self.addDialogVisible = false;
                    }
                });
            } else {
                this.$axios.post('addAdmin', self.form, res => {
                    if (res.ret == true) {
                        self.getData();
                        self.$message.success('添加成功');
                        self.addDialogVisible = false;
                    }
                });
            }
        },
        del(index, row) {
            let self = this;

            this.$axios.post('delAdmin', {
                id: row.id
            }, res => {
                if (res.ret == true) {
                    this.$message.success('删除成功');
                    self.tableData.splice(index, 1);
                }
            });
        }
    }
});

/***/ }),

/***/ 582:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 612:
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
  }), _vm._v(" 管理员管理")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 24
    }
  }, [_c('el-button', {
    staticStyle: {
      "float": "right"
    },
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.addDialog
    }
  }, [_vm._v("新增管理员")])], 1)], 1)], 1), _vm._v(" "), _c('el-table', {
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
      "prop": "name",
      "label": "管理员名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "account",
      "label": "账号"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "身份"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [(scope.row.setUp == 1) ? _c('el-tag', {
          attrs: {
            "type": "primary"
          }
        }, [_vm._v("管理人员")]) : _vm._e(), _vm._v(" "), (scope.row.setUp == 2) ? _c('el-tag', {
          attrs: {
            "type": "success"
          }
        }, [_vm._v("销售助理")]) : _vm._e(), _vm._v(" "), (scope.row.setUp == 3) ? _c('el-tag', {
          attrs: {
            "type": "success"
          }
        }, [_vm._v("财务")]) : _vm._e(), _vm._v(" "), (scope.row.setUp == 4) ? _c('el-tag', {
          attrs: {
            "type": "success"
          }
        }, [_vm._v("销售人员")]) : _vm._e()]
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
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
            "type": "warning"
          },
          on: {
            "click": function($event) {
              _vm.edit(scope.$index, scope.row)
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
  })], 1), _vm._v(" "), _c('el-dialog', {
    attrs: {
      "title": _vm.addDialogTitle
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
      "label": "管理员名称"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入管理员名称"
    },
    model: {
      value: (_vm.form.name),
      callback: function($$v) {
        _vm.$set(_vm.form, "name", $$v)
      },
      expression: "form.name"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "账号"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入账号"
    },
    model: {
      value: (_vm.form.account),
      callback: function($$v) {
        _vm.$set(_vm.form, "account", $$v)
      },
      expression: "form.account"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "密码"
    }
  }, [_c('el-input', {
    attrs: {
      "type": "password",
      "placeholder": "请输入密码"
    },
    model: {
      value: (_vm.form.pwd),
      callback: function($$v) {
        _vm.$set(_vm.form, "pwd", $$v)
      },
      expression: "form.pwd"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "身份"
    }
  }, [_c('el-radio-group', {
    model: {
      value: (_vm.form.setUp),
      callback: function($$v) {
        _vm.$set(_vm.form, "setUp", $$v)
      },
      expression: "form.setUp"
    }
  }, [_c('el-radio-button', {
    attrs: {
      "label": "1"
    }
  }, [_vm._v("管理人员")]), _vm._v(" "), _c('el-radio-button', {
    attrs: {
      "label": "2"
    }
  }, [_vm._v("销售助理")]), _vm._v(" "), _c('el-radio-button', {
    attrs: {
      "label": "3"
    }
  }, [_vm._v("财务")]), _vm._v(" "), _c('el-radio-button', {
    attrs: {
      "label": "4"
    }
  }, [_vm._v("销售人员")])], 1)], 1)], 1), _vm._v(" "), _c('span', {
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

/***/ 639:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(582);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("85fd188a", content, true);

/***/ })

});