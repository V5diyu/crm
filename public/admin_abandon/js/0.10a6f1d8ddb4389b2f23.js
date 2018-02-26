webpackJsonp([0],{

/***/ 516:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(541),
  /* template */
  __webpack_require__(616),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 540:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            name: 'yly',
            visible: false,
            userInfo: {},
            form: {
                yPwd: '',
                pwd: '',
                rpwd: ''
            }
        };
    },
    computed: {
        username() {
            let userInfo = localStorage.getItem('userInfo') && JSON.parse(localStorage.getItem('userInfo'));
            this.userInfo = userInfo;
            this.form.id = userInfo.id;
            return userInfo.name;
        }
    },
    methods: {
        edit() {
            if (this.form.pwd != this.form.rpwd) {
                this.$message.error('新密码与确认密码不一致');
                return;
            }

            this.$axios.post('updatePwd', this.form, res => {
                if (res.ret == true) {
                    this.$message.success('修改成功');
                    this.visible = false;
                } else {
                    this.$message.error('修改失败');
                }
            });
        },
        handleCommand(command) {
            if (command == 'loginout') {
                this.$axios.post('logout', {}, res => {
                    if (res.ret == true) {
                        localStorage.removeItem('ms_username');
                        this.$router.push('/login');
                        this.$message.success('退出成功');
                    }
                });
            } else if (command == "edit") {
                this.visible = true;
            }
        }
    }
});

/***/ }),

/***/ 541:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Header_vue__ = __webpack_require__(594);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Header_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Header_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__Sidebar_vue__ = __webpack_require__(595);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__Sidebar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__Sidebar_vue__);
//
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
    components: {
        vHead: __WEBPACK_IMPORTED_MODULE_0__Header_vue___default.a, vSidebar: __WEBPACK_IMPORTED_MODULE_1__Sidebar_vue___default.a
    }
});

/***/ }),

/***/ 542:
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
            userMsg: {},
            setUp: 0 //1：管理人员 2：销售助理 3:财务 4：销售人员
        };
    },
    created() {
        //console.log(JSON.parse(localStorage.getItem('userInfo')));
        let userInfo = localStorage.getItem('userInfo') && JSON.parse(localStorage.getItem('userInfo'));
        this.setUp = userInfo.setUp;
    },
    computed: {
        onRoutes() {
            return this.$route.path.replace('/', '');
        }
    },
    methods: {}
});

/***/ }),

/***/ 583:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".sidebar[data-v-9a226862]{display:block;position:absolute;width:200px;left:0;top:70px;bottom:0;box-shadow:-6px 3px 12px 3px #000}.sidebar>ul[data-v-9a226862]{height:100%;overflow:auto;overflow-x:hidden}.sidebar .iconfont[data-v-9a226862]{vertical-align:middle;margin-right:5px;width:24px;font-size:20px;text-align:center;line-height:1;display:inline-block}", ""]);

// exports


/***/ }),

/***/ 591:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".header[data-v-e63bf92c]{position:relative;box-sizing:border-box;width:100%;height:70px;font-size:22px;line-height:70px;color:#fff;background-color:#242424}.header .logo[data-v-e63bf92c]{float:left;width:260px;text-indent:20px}.user-info[data-v-e63bf92c]{float:right;padding-right:50px;font-size:16px;color:#fff}.user-info .el-dropdown-link[data-v-e63bf92c]{position:relative;display:inline-block;padding-left:50px;color:#fff;cursor:pointer;vertical-align:middle}.user-info .user-logo[data-v-e63bf92c]{position:absolute;left:0;top:15px;width:40px;height:40px;border-radius:50%}.el-dropdown-menu__item[data-v-e63bf92c]{text-align:center}", ""]);

// exports


/***/ }),

/***/ 593:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "admin/img/defultAvatar.2aab7b4.jpg";

/***/ }),

/***/ 594:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(648)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(540),
  /* template */
  __webpack_require__(622),
  /* scopeId */
  "data-v-e63bf92c",
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 595:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(640)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(542),
  /* template */
  __webpack_require__(613),
  /* scopeId */
  "data-v-9a226862",
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 613:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "sidebar"
  }, [_c('el-menu', {
    staticClass: "el-menu-vertical-demo",
    attrs: {
      "default-active": _vm.onRoutes,
      "theme": "dark",
      "unique-opened": "",
      "router": ""
    }
  }, [(_vm.setUp == 1) ? _c('div', [_c('el-submenu', {
    attrs: {
      "index": "1"
    }
  }, [_c('template', {
    slot: "title"
  }, [_c('i', {
    staticClass: "iconfont icon-gongzuotai"
  }), _vm._v("工作台")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "productTime"
    }
  }, [_vm._v("产品交期表")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "order"
    }
  }, [_vm._v("订单信息")])], 2), _vm._v(" "), _c('el-submenu', {
    attrs: {
      "index": "2"
    }
  }, [_c('template', {
    slot: "title"
  }, [_c('i', {
    staticClass: "iconfont icon-kehu"
  }), _vm._v("客户管理")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "customer"
    }
  }, [_vm._v("客户池")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "customer-follow-up"
    }
  }, [_vm._v("已跟进客户")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "customerSaleRecord"
    }
  }, [_vm._v("沟通记录")])], 2), _vm._v(" "), _c('el-submenu', {
    attrs: {
      "index": "3"
    }
  }, [_c('template', {
    slot: "title"
  }, [_c('i', {
    staticClass: "iconfont icon-dailishang"
  }), _vm._v("代理商管理")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "agent"
    }
  }, [_vm._v("代理商池")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "agent-follow-up"
    }
  }, [_vm._v("已跟进代理商")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "agentSaleRecord"
    }
  }, [_vm._v("沟通记录")])], 2), _vm._v(" "), _c('el-submenu', {
    attrs: {
      "index": "4"
    }
  }, [_c('template', {
    slot: "title"
  }, [_c('i', {
    staticClass: "iconfont icon-chanpin2"
  }), _vm._v("两周未联系")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "customer-contact"
    }
  }, [_vm._v("待联系客户")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "agent-contact"
    }
  }, [_vm._v("待联系代理商")])], 2), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "seller"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-xiaoshouyuanzhongxin"
  }), _vm._v("销售员管理\n            ")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "manager"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-admin"
  }), _vm._v("账号管理\n            ")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "autosyn"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-log"
  }), _vm._v("同步日志\n            ")])], 1) : _vm._e(), _vm._v(" "), (_vm.setUp == 2) ? _c('div', [_c('el-menu-item', {
    attrs: {
      "index": "productTime"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-gongzuotai"
  }), _vm._v("产品交期表\n            ")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "customer"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-kehu"
  }), _vm._v("客户管理\n            ")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "agent"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-dailishang"
  }), _vm._v("代理商管理\n            ")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "autosyn"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-admin"
  }), _vm._v("同步日志\n            ")])], 1) : _vm._e(), _vm._v(" "), (_vm.setUp == 3) ? _c('div', [_c('el-menu-item', {
    attrs: {
      "index": "order"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-gongzuotai"
  }), _vm._v("订单信息\n            ")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "autosyn"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-admin"
  }), _vm._v("同步日志\n            ")])], 1) : _vm._e(), _vm._v(" "), (_vm.setUp == 4) ? _c('div', [_c('el-submenu', {
    attrs: {
      "index": "1"
    }
  }, [_c('template', {
    slot: "title"
  }, [_c('i', {
    staticClass: "iconfont icon-gongzuotai"
  }), _vm._v("工作台")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "productTime"
    }
  }, [_vm._v("产品交期表")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "order"
    }
  }, [_vm._v("订单信息")])], 2), _vm._v(" "), _c('el-submenu', {
    attrs: {
      "index": "2"
    }
  }, [_c('template', {
    slot: "title"
  }, [_c('i', {
    staticClass: "iconfont icon-kehu"
  }), _vm._v("我的客户")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "customer-seller"
    }
  }, [_vm._v("客户列表")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "customerSaleRecord"
    }
  }, [_vm._v("沟通记录")])], 2), _vm._v(" "), _c('el-submenu', {
    attrs: {
      "index": "3"
    }
  }, [_c('template', {
    slot: "title"
  }, [_c('i', {
    staticClass: "iconfont icon-dailishang"
  }), _vm._v("我的代理商")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "agent-seller"
    }
  }, [_vm._v("代理商列表")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "agentSaleRecord"
    }
  }, [_vm._v("沟通记录")])], 2), _vm._v(" "), _c('el-submenu', {
    attrs: {
      "index": "4"
    }
  }, [_c('template', {
    slot: "title"
  }, [_c('i', {
    staticClass: "iconfont icon-chanpin2"
  }), _vm._v("两周未联系")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "customer-contact"
    }
  }, [_vm._v("待联系客户")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "agent-contact"
    }
  }, [_vm._v("待联系代理商")])], 2), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "saleRecord"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-chanpin"
  }), _vm._v("沟通记录\n            ")]), _vm._v(" "), _c('el-menu-item', {
    attrs: {
      "index": "autosyn"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-log"
  }), _vm._v("同步日志\n            ")])], 1) : _vm._e()])], 1)
},staticRenderFns: []}

/***/ }),

/***/ 616:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "wrapper"
  }, [_c('v-head'), _vm._v(" "), _c('v-sidebar'), _vm._v(" "), _c('div', {
    staticClass: "content"
  }, [_c('transition', {
    attrs: {
      "name": "move",
      "mode": "out-in"
    }
  }, [_c('router-view')], 1)], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 622:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "header"
  }, [_c('div', {
    staticClass: "logo"
  }, [_vm._v("泰科力合销售CRM管理系统")]), _vm._v(" "), _c('div', {
    staticClass: "user-info"
  }, [_c('el-dropdown', {
    attrs: {
      "trigger": "click"
    },
    on: {
      "command": _vm.handleCommand
    }
  }, [_c('span', {
    staticClass: "el-dropdown-link"
  }, [_c('img', {
    staticClass: "user-logo",
    attrs: {
      "src": __webpack_require__(593)
    }
  }), _vm._v("\n                " + _vm._s(_vm.username) + "\n            ")]), _vm._v(" "), _c('el-dropdown-menu', {
    attrs: {
      "slot": "dropdown"
    },
    slot: "dropdown"
  }, [_c('el-dropdown-item', {
    attrs: {
      "command": "edit"
    }
  }, [_vm._v("修改密码")]), _vm._v(" "), _c('el-dropdown-item', {
    attrs: {
      "command": "loginout"
    }
  }, [_vm._v("退出")])], 1)], 1)], 1), _vm._v(" "), _c('el-dialog', {
    attrs: {
      "title": "修改密码",
      "size": "tiny"
    },
    model: {
      value: (_vm.visible),
      callback: function($$v) {
        _vm.visible = $$v
      },
      expression: "visible"
    }
  }, [_c('el-form', {
    ref: "form",
    attrs: {
      "model": _vm.form,
      "label-width": "80px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "原密码"
    }
  }, [_c('el-input', {
    attrs: {
      "type": "password",
      "placeholder": "请输入原密码"
    },
    model: {
      value: (_vm.form.yPwd),
      callback: function($$v) {
        _vm.$set(_vm.form, "yPwd", $$v)
      },
      expression: "form.yPwd"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "新密码"
    }
  }, [_c('el-input', {
    attrs: {
      "type": "password",
      "placeholder": "请输入新密码"
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
      "label": "确认新密码"
    }
  }, [_c('el-input', {
    attrs: {
      "type": "password",
      "placeholder": "请再次输入新密码"
    },
    model: {
      value: (_vm.form.rpwd),
      callback: function($$v) {
        _vm.$set(_vm.form, "rpwd", $$v)
      },
      expression: "form.rpwd"
    }
  })], 1)], 1), _vm._v(" "), _c('span', {
    staticClass: "dialog-footer",
    attrs: {
      "slot": "footer"
    },
    slot: "footer"
  }, [_c('el-button', {
    on: {
      "click": function($event) {
        _vm.visible = false
      }
    }
  }, [_vm._v("取 消")]), _vm._v(" "), _c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.edit
    }
  }, [_vm._v("修 改")])], 1)], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 640:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(583);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("1723caa4", content, true);

/***/ }),

/***/ 648:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(591);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("7f1ee1ca", content, true);

/***/ })

});