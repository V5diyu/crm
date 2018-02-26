webpackJsonp([6],{

/***/ 535:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(638)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(562),
  /* template */
  __webpack_require__(611),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 562:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            tableData: [],
            loading: true,
            keyword: '',
            type: 0,
            cur_page: 1,
            count: 0,
            pageSize: 15
        };
    },
    created() {
        this.getData();
    },
    methods: {
        add() {
            this.$router.push('addAgent');
        },
        edit(index, row) {
            this.$router.push({ path: 'addAgent', query: { id: row.id } });
        },
        filterTag(value, row) {
            console.log(value);
            this.type = value;
            this.getData();
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
        },
        del(index, row) {
            let self = this;

            this.$axios.post('delAgent', {
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

/***/ 581:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".customer .crumbs .el-form-item{margin-bottom:0}", ""]);

// exports


/***/ }),

/***/ 611:
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
  }), _vm._v(" 代理商管理")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("其他代理商")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
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
  }, [_vm._v("新增代理商")]), _vm._v(" "), _c('el-button', {
    staticStyle: {
      "float": "right"
    },
    attrs: {
      "type": "primary"
    }
  }, [_vm._v("导入代理商")]), _vm._v(" "), _c('el-form', {
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
  })], 1)], 1)], 1)], 1)], 1), _vm._v(" "), _c('el-table', {
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
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [(scope.row.proxyLevel == 1) ? _c('el-tag', {
          attrs: {
            "type": "primary",
            "close-transition": ""
          }
        }, [_vm._v("级别" + _vm._s(scope.row.proxyLevel))]) : _vm._e(), _vm._v(" "), (scope.row.proxyLevel == 2) ? _c('el-tag', {
          attrs: {
            "type": "success",
            "close-transition": ""
          }
        }, [_vm._v("级别" + _vm._s(scope.row.proxyLevel))]) : _vm._e(), _vm._v(" "), (scope.row.proxyLevel == 3) ? _c('el-tag', {
          attrs: {
            "type": "info",
            "close-transition": ""
          }
        }, [_vm._v("级别" + _vm._s(scope.row.proxyLevel))]) : _vm._e()]
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "explain",
      "label": "其他情况说明"
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

/***/ 638:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(581);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("0192955c", content, true);

/***/ })

});