webpackJsonp([2],{

/***/ 539:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(637)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(566),
  /* template */
  __webpack_require__(610),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 566:
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



/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            type: 1,
            tableData: [],
            loading: true,
            keyword: '',
            cur_page: 1,
            count: 0,
            pageSize: 15,
            uploadExcelLink: __WEBPACK_IMPORTED_MODULE_0__assets_service_js__["a" /* default */].url('uploadExcel')
        };
    },
    mounted() {
        this.getData();
    },
    watch: {
        type(val) {
            this.tableData = [];
            this.getData();
        }
    },
    methods: {
        uploadExcelSuccess() {
            console.log('upload success');
            this.getData();
        },
        handleCurrentChange(val) {
            this.cur_page = val;
            this.getData();
        },
        getData() {
            this.loading = true;
            this.$axios.post('getSeller', {
                name: this.keyword,
                pn: this.cur_page,
                type: this.type
            }, res => {
                if (res.ret == true) {
                    this.tableData = res.data.list;
                    this.count = res.data.count;
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

            this.$axios.post('delSeller', {
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

/***/ 580:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".seller .crumbs .el-form-item{margin-bottom:0}.crumbs .el-upload{height:auto;width:auto;border:none}", ""]);

// exports


/***/ }),

/***/ 610:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "table seller"
  }, [_c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-breadcrumb', {
    attrs: {
      "separator": "/"
    }
  }, [_c('el-breadcrumb-item', [_c('i', {
    staticClass: "el-icon-menu"
  }), _vm._v(" 销售员管理")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-radio-group', {
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
  }, [_vm._v("本月")]), _vm._v(" "), _c('el-radio-button', {
    attrs: {
      "label": "2"
    }
  }, [_vm._v("上个月")])], 1)], 1), _vm._v(" "), _c('el-table', {
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
      "label": "姓名"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "ranking",
      "label": "签约额排名"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "myContractVolume",
      "label": "本人签约额/元"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "companyContractVolume",
      "label": "公司签约额/元"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "myReturnAmount",
      "label": "本人回款额/元"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "myReceivables",
      "label": "本人应收额/元"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "myOverdueLoans",
      "label": "本人超期未回款/元"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "操作"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-button', {
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

/***/ 637:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(580);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("01114e3a", content, true);

/***/ })

});