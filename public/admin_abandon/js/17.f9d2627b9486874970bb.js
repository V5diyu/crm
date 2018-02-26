webpackJsonp([17],{

/***/ 524:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(636)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(551),
  /* template */
  __webpack_require__(609),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 551:
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
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            tableData: [],
            cur_page: 1,
            count: 0,
            pageSize: 15,
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
        handleCurrentChange(val) {
            this.cur_page = val;
            this.getData();
        },
        getData() {
            this.loading = true;
            this.$axios.post('getSynLog', {
                pn: this.cur_page
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

/***/ 579:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 609:
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
  }), _vm._v(" 自动同步日志")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 24
    }
  })], 1)], 1), _vm._v(" "), _c('el-table', {
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
      "prop": "syn_time",
      "label": "同步时间",
      "width": "170"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "syn_cont",
      "label": "数据表",
      "width": "95"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "syn_field",
      "label": "同步内容"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "flag",
      "label": "标记ID",
      "width": "150"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "type",
      "label": "类型",
      "width": "90"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [(scope.row.type == 1) ? _c('el-tag', [_vm._v("插 入")]) : _vm._e(), _vm._v(" "), (scope.row.type == 2) ? _c('el-tag', [_vm._v("更 新")]) : _vm._e()]
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
  })], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 636:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(579);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("3b565624", content, true);

/***/ })

});