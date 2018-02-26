webpackJsonp([23],{

/***/ 517:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(649)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(544),
  /* template */
  __webpack_require__(623),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 544:
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
            form: {
                type: 1,
                code: '', //代理商代码
                name: '', //代理商名称
                abbreviation: '', //代理商简称
                legalRepresentative: '', //法定代表人
                address: '', //地址
                registeredCapital: '', //注册资金
                lastYearSales: '', //去年贡献收入
                proxyLevel: '', //代理级别  1 2 3
                explain: '', //其他情况说明
                mainPersonnel: [{}] //主要人员{'duties':'','name':'','phone':'','remarks':''}
            }
        };
    },
    created() {
        if (this.$route.query.id) {
            this.getData();
        }
    },
    methods: {
        initData(val) {
            this.form = {
                type: val,
                code: '', //代理商代码
                name: '', //代理商名称
                abbreviation: '', //代理商简称
                legalRepresentative: '', //法定代表人
                address: '', //地址
                registeredCapital: '', //注册资金
                lastYearSales: '', //去年贡献收入
                proxyLevel: '', //代理级别  1 2 3
                explain: '', //其他情况说明
                mainPersonnel: [{}] //主要人员{'duties':'','name':'','phone':'','remarks':''}
            };
        },
        getData() {
            this.$axios.post('getAgentById', {
                id: this.$route.query.id
            }, res => {
                if (res.ret == true) {
                    this.form = res.data;
                }
            });
        },
        // 新增主要人员
        addMainPersonnel() {
            this.form.mainPersonnel.push({});
        },
        add() {
            let self = this;
            console.log(this.form);

            if (this.$route.query.id) {
                this.$axios.post('updateAgent', self.form, res => {
                    if (res.ret == true) {
                        self.$message.success('修改成功');
                    }
                });
            } else {
                this.$axios.post('addAgent', self.form, res => {
                    if (res.ret == true) {
                        self.initData(self.form.type);
                        self.$message.success('添加成功');
                    }
                });
            }
        }
    }
});

/***/ }),

/***/ 592:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".section-header{height:40px;line-height:40px;border-top:6px solid #e8e8e8;color:#999;font-size:14px}.mainForm .mainPerson input{width:400px}.mainForm input{width:600px}", ""]);

// exports


/***/ }),

/***/ 623:
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
  }), _vm._v(" 代理商管理")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("代理商池")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v(_vm._s(_vm.$route.query.id ? '修改代理商' : '新增代理商'))])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-form', {
    ref: "form",
    staticClass: "mainForm",
    attrs: {
      "model": _vm.form,
      "label-position": "left",
      "label-width": "120px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "代理商类型"
    }
  }, [_c('el-radio-group', {
    model: {
      value: (_vm.form.type),
      callback: function($$v) {
        _vm.$set(_vm.form, "type", $$v)
      },
      expression: "form.type"
    }
  }, [_c('el-radio-button', {
    attrs: {
      "label": "1"
    }
  }, [_vm._v("代理商")]), _vm._v(" "), _c('el-radio-button', {
    attrs: {
      "label": "2"
    }
  }, [_vm._v("代理人")])], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "section-header"
  }, [_vm._v("基本信息")]), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.form.type == 1),
      expression: "form.type == 1"
    }],
    staticClass: "baseInfo"
  }, [_c('el-form-item', {
    attrs: {
      "label": "代理商编码"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.code),
      callback: function($$v) {
        _vm.$set(_vm.form, "code", $$v)
      },
      expression: "form.code"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "代理商名称"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.name),
      callback: function($$v) {
        _vm.$set(_vm.form, "name", $$v)
      },
      expression: "form.name"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "代理商简称"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.abbreviation),
      callback: function($$v) {
        _vm.$set(_vm.form, "abbreviation", $$v)
      },
      expression: "form.abbreviation"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "法定代表人"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.legalRepresentative),
      callback: function($$v) {
        _vm.$set(_vm.form, "legalRepresentative", $$v)
      },
      expression: "form.legalRepresentative"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "地址"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.address),
      callback: function($$v) {
        _vm.$set(_vm.form, "address", $$v)
      },
      expression: "form.address"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "注册资金/万"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.registeredCapital),
      callback: function($$v) {
        _vm.$set(_vm.form, "registeredCapital", $$v)
      },
      expression: "form.registeredCapital"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "去年贡献收入/万"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.lastYearSales),
      callback: function($$v) {
        _vm.$set(_vm.form, "lastYearSales", $$v)
      },
      expression: "form.lastYearSales"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "代理级别"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.proxyLevel),
      callback: function($$v) {
        _vm.$set(_vm.form, "proxyLevel", $$v)
      },
      expression: "form.proxyLevel"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "其他情况说明"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.explain),
      callback: function($$v) {
        _vm.$set(_vm.form, "explain", $$v)
      },
      expression: "form.explain"
    }
  })], 1)], 1), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.form.type == 2),
      expression: "form.type == 2"
    }],
    staticClass: "baseInfo"
  }, [_c('el-form-item', {
    attrs: {
      "label": "代理商编码"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.code),
      callback: function($$v) {
        _vm.$set(_vm.form, "code", $$v)
      },
      expression: "form.code"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "代理商名称"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.name),
      callback: function($$v) {
        _vm.$set(_vm.form, "name", $$v)
      },
      expression: "form.name"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "其他情况说明"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.explain),
      callback: function($$v) {
        _vm.$set(_vm.form, "explain", $$v)
      },
      expression: "form.explain"
    }
  })], 1)], 1), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.form.type == 1),
      expression: "form.type == 1"
    }]
  }, [_c('div', {
    staticClass: "section-header"
  }, [_vm._v("主要人员")]), _vm._v(" "), _vm._l((_vm.form.mainPersonnel), function(item, index) {
    return _c('div', {
      staticClass: "mainPerson",
      staticStyle: {
        "border-bottom": "1px dashed #e8e8e8",
        "margin-bottom": "20px"
      }
    }, [_c('el-form-item', {
      attrs: {
        "label": "职务"
      }
    }, [_c('el-input', {
      model: {
        value: (item.duties),
        callback: function($$v) {
          _vm.$set(item, "duties", $$v)
        },
        expression: "item.duties"
      }
    })], 1), _vm._v(" "), _c('el-form-item', {
      attrs: {
        "label": "姓名"
      }
    }, [_c('el-input', {
      model: {
        value: (item.name),
        callback: function($$v) {
          _vm.$set(item, "name", $$v)
        },
        expression: "item.name"
      }
    })], 1), _vm._v(" "), _c('el-form-item', {
      attrs: {
        "label": "电话"
      }
    }, [_c('el-input', {
      model: {
        value: (item.phone),
        callback: function($$v) {
          _vm.$set(item, "phone", $$v)
        },
        expression: "item.phone"
      }
    })], 1), _vm._v(" "), _c('el-form-item', {
      attrs: {
        "label": "备注"
      }
    }, [_c('el-input', {
      model: {
        value: (item.remarks),
        callback: function($$v) {
          _vm.$set(item, "remarks", $$v)
        },
        expression: "item.remarks"
      }
    })], 1)], 1)
  }), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": ""
    }
  }, [_c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.addMainPersonnel
    }
  }, [_vm._v("新增主要人员")])], 1)], 2), _vm._v(" "), _c('div', {
    staticClass: "section-header"
  }), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": ""
    }
  }, [_c('el-button', {
    attrs: {
      "type": "success",
      "size": "large"
    },
    on: {
      "click": _vm.add
    }
  }, [_vm._v("提交")])], 1)], 1)], 1)])
},staticRenderFns: []}

/***/ }),

/***/ 649:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(592);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("57042f5b", content, true);

/***/ })

});