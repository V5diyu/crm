webpackJsonp([11],{

/***/ 530:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(644)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(557),
  /* template */
  __webpack_require__(618),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 557:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            tableData: [],
            loading: true,
            cur_page: 1,
            count: 0,
            pageSize: 15
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

            if (this.$route.query.page == '产品交期表') {
                this.$axios.post('getProductErrorList', {
                    pn: this.cur_page,
                    id: this.$route.query.id
                }, res => {
                    if (res.ret == true) {
                        this.tableData = res.data;
                        this.loading = false;
                    }
                });
            } else {
                this.$axios.post('getOrderErrorList', {
                    pn: this.cur_page,
                    id: this.$route.query.id
                }, res => {
                    if (res.ret == true) {
                        this.tableData = res.data;
                        this.loading = false;
                    }
                });
            }
        }
    }
});

/***/ }),

/***/ 587:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 618:
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
  }), _vm._v(" 工作台")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v(_vm._s(_vm.$route.query.page))]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("纠错列表")])], 1)], 1)], 1), _vm._v(" "), _c('el-table', {
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
      "prop": "userName",
      "label": "纠错人"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "create",
      "label": "时间"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "content",
      "label": "纠错内容"
    }
  })], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 644:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(587);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("11507a7f", content, true);

/***/ })

});