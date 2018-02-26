webpackJsonp([20],{

/***/ 521:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(630)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(548),
  /* template */
  __webpack_require__(603),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 548:
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



/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            tableData: [],
            loading: true,
            keyword: '',
            type: 1,
            cur_page: 1,
            count: 0,
            pageSize: 15
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
        downloadRecord() {
            location.href = __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('exportRecordAgent');
        },
        downloadTemplate() {
            location.href = __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('exportAgent') + '?type=' + this.type;
        },
        handleCurrentChange(val) {
            this.cur_page = val;
            this.getData();
        },
        getData() {
            this.loading = true;
            this.$axios.post('getAgent', {
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
        }
    }
});

/***/ }),

/***/ 573:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".customer .crumbs .el-form-item{margin-bottom:0}.customer .crumbs .el-upload{height:auto;width:auto;border:none}", ""]);

// exports


/***/ }),

/***/ 603:
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
  }), _vm._v(" 代理商")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 24
    }
  }, [_c('el-button', {
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
      "type": "success"
    },
    on: {
      "click": _vm.downloadTemplate
    }
  }, [_vm._v("导出代理商")]), _vm._v(" "), _c('el-button', {
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
      "type": "success"
    },
    on: {
      "click": _vm.downloadTemplate
    }
  }, [_vm._v("导出代理人")]), _vm._v(" "), _c('el-button', {
    staticStyle: {
      "float": "right",
      "margin-right": "20px"
    },
    attrs: {
      "type": "success"
    },
    on: {
      "click": _vm.downloadRecord
    }
  }, [_vm._v("导出沟通记录")]), _vm._v(" "), _c('el-form', {
    attrs: {
      "inline": true
    }
  }, [_c('el-form-item', [_c('el-input', {
    staticClass: "inline",
    attrs: {
      "placeholder": "请输入代理商名称搜索",
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
  }, [_vm._v("代理商")]), _vm._v(" "), _c('el-radio-button', {
    attrs: {
      "label": "2"
    }
  }, [_vm._v("代理人")])], 1)], 1)], 1)], 1)], 1), _vm._v(" "), _c('el-table', {
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
      "label": "代理商名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "code",
      "label": "代理商编码"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "abbreviation",
      "label": "代理商简称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "legalRepresentative",
      "label": "法定代表人"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "registeredCapital",
      "label": "注册资金/万"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "lastYearSales",
      "label": "去年贡献收入/万"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "proxyLevel",
      "label": "代理级别"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "explain",
      "label": "其他情况说明"
    }
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
      "label": "代理商名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "code",
      "label": "代理商编码"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "explain",
      "label": "其他情况说明"
    }
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
  })], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 630:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(573);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("4c042976", content, true);

/***/ })

});