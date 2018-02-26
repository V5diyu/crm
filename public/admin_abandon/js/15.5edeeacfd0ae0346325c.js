webpackJsonp([15],{

/***/ 526:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(624)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(553),
  /* template */
  __webpack_require__(597),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 553:
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



/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            dialogTableVisible: false,
            recordListData: [],
            recordCount: 0,
            recordPn: 1,

            addDialogVisible: false,
            tableData: [],
            loading: true,
            keyword: '',
            type: 1,
            cur_page: 1,
            count: 0,
            pageSize: 15,
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
            location.href = __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('exportRecordCustomer');
        },
        handleCurrentChange(val) {
            this.cur_page = val;
            this.getData();
        },
        handleCurChange() {
            this.recordPn = val;
            this.look();
        },
        getData() {
            this.loading = true;
            this.$axios.post('getCustomer', {
                type: this.type,
                pn: this.cur_page,
                name: this.keyword,
                model: 3 // 1:代理商池获取  2：两周未联系的代理商  3:已跟进
            }, res => {
                if (res.ret == true) {
                    this.tableData = res.data.list;
                    this.count = res.data.count;
                    this.loading = false;
                }
            });
        },
        look(index, row) {
            this.$axios.post('getRecordCustomer', {
                pn: this.recordPn,
                id: row.id
            }, res => {
                if (res.ret == true) {
                    this.dialogTableVisible = true;
                    this.recordListData = res.data.list;
                    this.recordCount = res.data.count;
                    console.log(res.data);
                }
            });
        }
    }
});

/***/ }),

/***/ 567:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".customer .crumbs .el-form-item{margin-bottom:0}.customer .crumbs .el-upload{height:auto;width:auto;border:none}", ""]);

// exports


/***/ }),

/***/ 597:
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
  }), _vm._v(" 客户管理")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("已跟进客户")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 24
    }
  }, [_c('el-form', {
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
  }, [_vm._v("厂家")])], 1), _vm._v(" "), _c('el-button', {
    staticStyle: {
      "float": "right"
    },
    attrs: {
      "type": "success"
    },
    on: {
      "click": _vm.downloadTemplate
    }
  }, [_vm._v("导出沟通记录")])], 1)], 1)], 1)], 1), _vm._v(" "), _c('el-table', {
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
      "prop": "belongUserName",
      "label": "跟进销售人员"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "销售沟通记录"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-button', {
          attrs: {
            "size": "small",
            "type": "info"
          },
          on: {
            "click": function($event) {
              _vm.look(scope.$index, scope.row)
            }
          }
        }, [_vm._v("查看")])]
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
      "prop": "belongUserName",
      "label": "跟进销售人员"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "销售沟通记录"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-button', {
          attrs: {
            "size": "small",
            "type": "info"
          },
          on: {
            "click": function($event) {
              _vm.look(scope.$index, scope.row)
            }
          }
        }, [_vm._v("查看")])]
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
      "title": "沟通记录",
      "size": "large",
      "visible": _vm.dialogTableVisible
    },
    on: {
      "update:visible": function($event) {
        _vm.dialogTableVisible = $event
      }
    }
  }, [_c('el-table', {
    attrs: {
      "data": _vm.recordListData,
      "border": ""
    }
  }, [_c('el-table-column', {
    attrs: {
      "property": "userName",
      "label": "销售人员"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "property": "customerName",
      "label": "沟通对象"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "property": "title",
      "label": "是否可见"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-tag', {
          attrs: {
            "type": scope.row.type == 1 ? 'primary' : 'success',
            "close-transition": ""
          }
        }, [_vm._v(_vm._s(scope.row.status == 1 ? '自己可见' : '所有人可见'))])]
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "property": "title",
      "label": "标题",
      "width": "150"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "property": "time",
      "label": "时间",
      "width": "200"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "property": "remark",
      "label": "内容"
    }
  })], 1), _vm._v(" "), _c('div', {
    staticClass: "pagination"
  }, [_c('el-pagination', {
    attrs: {
      "layout": "prev, pager, next",
      "total": _vm.recordCount,
      "page-size": _vm.pageSize
    },
    on: {
      "current-change": _vm.handleCurChange
    }
  })], 1)], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 624:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(567);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("ad25d6a0", content, true);

/***/ })

});