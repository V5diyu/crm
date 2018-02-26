webpackJsonp([4],{

/***/ 537:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(625)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(564),
  /* template */
  __webpack_require__(598),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 564:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            tableData: [],
            qiniuInitState: false,
            loading: true
        };
    },
    created() {
        this.getData();
    },
    methods: {
        filterTag(value, row) {},
        getData() {
            this.loading = true;
            this.$axios.post('getBanner', {
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

            this.$axios.post('addBanner', self.form, res => {
                if (res.ret == true) {
                    self.getData();
                    self.$message.success('添加成功');
                }
            });
        },
        del(index, row) {
            let self = this;

            this.$axios.post('delBanner', {
                id: row.id,
                fid: self.$route.query.id || 0
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

/***/ 568:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 598:
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
  }), _vm._v(" 工作台")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("销项发票")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
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
    }
  }, [_vm._v("导出")])], 1)], 1)], 1), _vm._v(" "), _c('el-table', {
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
      "label": "申请人"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "name",
      "label": "客户名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "name",
      "label": "申请时间"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "tag",
      "label": "发票类型",
      "filters": [{
        text: '家',
        value: '家'
      }, {
        text: '公司',
        value: '公司'
      }],
      "filter-method": _vm.filterTag,
      "filter-placement": "bottom-end"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-tag', {
          attrs: {
            "type": scope.row.tag === '家' ? 'primary' : 'success',
            "close-transition": ""
          }
        }, [_vm._v(_vm._s(scope.row.tag))])]
      }
    }])
  })], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 625:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(568);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("4fdf3076", content, true);

/***/ })

});