webpackJsonp([13],{

/***/ 528:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(627)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(555),
  /* template */
  __webpack_require__(600),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 555:
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



/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            addDialogVisible: false,
            tableData: [],
            loading: true,
            keyword: '',
            type: 1,
            cur_page: 1,
            count: 0,
            pageSize: 15,
            uploadExcelLink: __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('uploadExcelCustomer'),
            uploadExcelLink2: __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('uploadExcelCustomer2'),
            applyList: [],
            curApplyData: {},
            curApplyIndex: 0,
            selection: []
        };
    },
    watch: {
        type(val) {
            this.tableData = [];
            this.getData();
        }
    },
    created() {
        this.getData();
    },
    methods: {
        downloadTemplate() {
            location.href = __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('downloadTemplateCustomer') + '?type=' + this.type;
        },
        handleSelectionAll(selection) {
            console.log(selection);
            this.selection = selection;
        },
        handleSelectionChange(selection, row) {
            console.log(selection, row);
            this.selection = selection;
        },
        operationConfirm() {
            var applyId = [];
            this.selection.forEach(item => {
                applyId.push(item.id);
            });

            this.$axios.post('operationConfirmCustomer', {
                id: this.curApplyData.id,
                applyId: applyId
            }, res => {
                if (res.ret == true) {
                    this.$message.success('审核成功');
                    this.curApplyData.applyNum = 0;
                    this.tableData.splice(this.curApplyIndex, 1);
                    this.addDialogVisible = false;
                }
            });
        },
        audit(index, row) {
            this.addDialogVisible = true;
            this.curApplyData = row;
            this.curApplyIndex = index;
            this.$axios.post('getCustomerApplyList', {
                id: row.id
            }, res => {
                if (res.ret == true) {
                    console.log(res.data);
                    this.applyList = res.data;
                }
            });
        },
        uploadExcelSuccess() {
            this.$message.success('上传成功');
            this.getData();
        },
        add() {
            this.$router.push('addCustomer');
        },
        edit(index, row) {
            this.$router.push({ path: 'addCustomer', query: { id: row.id } });
        },
        handleCurrentChange(val) {
            this.cur_page = val;
            this.getData();
        },
        getData() {
            this.loading = true;
            this.$axios.post('getCustomer', {
                type: this.type,
                pn: this.cur_page,
                name: this.keyword
            }, res => {
                if (res.ret == true) {
                    this.tableData = res.data.list;
                    this.count = res.data.count;
                    this.loading = false;
                }
            });
        },
        del(index, row) {
            let self = this;

            this.$axios.post('delCustomer', {
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

/***/ 570:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".customer .crumbs .el-form-item{margin-bottom:0}.customer .crumbs .el-upload{height:auto;width:auto;border:none}", ""]);

// exports


/***/ }),

/***/ 600:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "table customer"
  }, [_c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-breadcrumb', {
    attrs: {
      "separator": "/"
    }
  }, [_c('el-breadcrumb-item', [_c('i', {
    staticClass: "el-icon-menu"
  }), _vm._v(" 客户管理")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("客户池")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 24
    }
  }, [_c('el-button', {
    staticStyle: {
      "float": "right",
      "margin-left": "20px"
    },
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.add
    }
  }, [_vm._v("新增客户")]), _vm._v(" "), _c('el-upload', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.type == 1),
      expression: "type == 1"
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
  }, [_vm._v("导入终端客户")])], 1), _vm._v(" "), _c('el-upload', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.type == 2),
      expression: "type == 2"
    }],
    staticStyle: {
      "float": "right"
    },
    attrs: {
      "on-success": _vm.uploadExcelSuccess,
      "show-file-list": false,
      "action": _vm.uploadExcelLink2
    }
  }, [_c('el-button', {
    attrs: {
      "type": "primary"
    }
  }, [_vm._v("导入厂家客户")])], 1), _vm._v(" "), _c('el-button', {
    staticStyle: {
      "float": "right",
      "margin-right": "20px"
    },
    attrs: {
      "type": "success"
    },
    on: {
      "click": _vm.downloadTemplate
    }
  }, [_vm._v("下载导入模板")]), _vm._v(" "), _c('el-form', {
    attrs: {
      "inline": true
    }
  }, [_c('el-form-item', [_c('el-input', {
    staticClass: "inline",
    attrs: {
      "placeholder": "请输入客户名称搜索",
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
  })], 1), _vm._v(" "), _c('el-radio-group', {
    model: {
      value: (_vm.type),
      callback: function($$v) {
        _vm.type = $$v
      },
      expression: "type"
    }
  }, [_c('el-radio-button', {
    attrs: {
      "label": "1"
    }
  }, [_vm._v("终端")]), _vm._v(" "), _c('el-radio-button', {
    attrs: {
      "label": "2"
    }
  }, [_vm._v("厂家")])], 1)], 1)], 1)], 1)], 1), _vm._v(" "), _c('el-table', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.type == 1),
      expression: "type == 1"
    }, {
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
      "label": "客户名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "type",
      "label": "类型",
      "width": "80"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-tag', {
          attrs: {
            "type": scope.row.type == 1 ? 'primary' : 'success',
            "close-transition": ""
          }
        }, [_vm._v(_vm._s(scope.row.type == 1 ? '终端' : '厂家'))])]
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "address",
      "label": "地址"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "intermediaryCompany",
      "label": "中间公司"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "stage",
      "label": "客户阶段"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "explain",
      "label": "其他情况说明"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "操作",
      "width": "220"
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
        }, [_vm._v("删除")]), _vm._v(" "), (scope.row.applyNum > 0) ? _c('el-button', {
          attrs: {
            "size": "small",
            "type": "info"
          },
          on: {
            "click": function($event) {
              _vm.audit(scope.$index, scope.row)
            }
          }
        }, [_vm._v("跟进审核")]) : _vm._e()]
      }
    }])
  })], 1), _vm._v(" "), _c('el-table', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.type == 2),
      expression: "type == 2"
    }, {
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
      "label": "客户名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "type",
      "label": "客户类型"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-tag', {
          attrs: {
            "type": scope.row.type == 1 ? 'primary' : 'success',
            "close-transition": ""
          }
        }, [_vm._v(_vm._s(scope.row.type == 1 ? '终端' : '厂家'))])]
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "explain",
      "label": "其他情况说明"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "操作",
      "width": "220"
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
        }, [_vm._v("删除")]), _vm._v(" "), (scope.row.applyNum > 0) ? _c('el-button', {
          attrs: {
            "size": "small",
            "type": "info"
          },
          on: {
            "click": function($event) {
              _vm.del(scope.$index, scope.row)
            }
          }
        }, [_vm._v("跟进审核")]) : _vm._e()]
      }
    }])
  })], 1), _vm._v(" "), _c('el-dialog', {
    attrs: {
      "title": "跟进审核"
    },
    model: {
      value: (_vm.addDialogVisible),
      callback: function($$v) {
        _vm.addDialogVisible = $$v
      },
      expression: "addDialogVisible"
    }
  }, [_c('el-table', {
    staticStyle: {
      "width": "100%"
    },
    attrs: {
      "data": _vm.applyList,
      "border": ""
    },
    on: {
      "select-all": _vm.handleSelectionAll,
      "select": _vm.handleSelectionChange
    }
  }, [_c('el-table-column', {
    attrs: {
      "type": "selection",
      "width": "55"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "userName",
      "label": "姓名"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "create",
      "label": "申请时间"
    }
  })], 1), _vm._v(" "), _c('span', {
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
      "click": _vm.operationConfirm
    }
  }, [_vm._v("同意跟进")])], 1)], 1), _vm._v(" "), _c('div', {
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
  })], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 627:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(570);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("b208bffe", content, true);

/***/ })

});