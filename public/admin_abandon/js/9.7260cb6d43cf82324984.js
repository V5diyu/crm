webpackJsonp([9],{

/***/ 532:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(647)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(559),
  /* template */
  __webpack_require__(621),
  /* scopeId */
  "data-v-e228b8c0",
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 559:
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

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function () {
        return {
            ruleForm: {
                username: '',
                password: ''
            },
            rules: {
                username: [{ required: true, message: '请输入用户名', trigger: 'blur' }],
                password: [{ required: true, message: '请输入密码', trigger: 'blur' }]
            }
        };
    },
    methods: {
        submitForm(formName) {
            const self = this;
            self.$refs[formName].validate(valid => {
                if (valid) {
                    this.$axios.post('login', {
                        account: self.ruleForm.username,
                        pwd: self.ruleForm.password
                    }, resp => {
                        if (resp.ret) {
                            this.$message.success('登陆成功，正在跳转...');
                            localStorage.setItem('ms_username', self.ruleForm.username);
                            localStorage.setItem('userInfo', JSON.stringify(resp.data));

                            var path = '';
                            if (resp.data.setUp == 1) {
                                path = '/manager';
                            } else if (resp.data.setUp == 2) {
                                path = '/productTime';
                            } else if (resp.data.setUp == 3) {
                                path = '/order';
                            } else if (resp.data.setUp == 4) {
                                path = '/customer-seller';
                            }

                            setTimeout(function () {
                                self.$router.push(path);
                            }, 1000);
                        } else {
                            this.$message.error(resp.msg);
                        }
                    });
                } else {
                    this.$message.error('请输入正确的账号密码');
                    return false;
                }
            });
        }
    }
});

/***/ }),

/***/ 590:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".login-wrap[data-v-e228b8c0]{position:relative;width:100%;height:100%;background-image:url(\"/static/img/bj.jpg\");background-position:50%;background-size:cover;background-repeat:no-repeat}.ms-title[data-v-e228b8c0]{left:50%;top:20px;text-align:center;font-size:19px;margin-bottom:20px;color:#fff}.ms-login[data-v-e228b8c0]{position:absolute;left:50%;top:50%;width:300px;background-color:rgba(0,0,0,.6);margin:-180px 0 0 -190px;padding:40px;border-radius:5px;box-shadow:0 0 6px 0 rgba(0,0,0,.04),0 2px 4px 0 rgba(0,0,0,.12)}.ms-login .el-form-item[data-v-e228b8c0]{margin-bottom:30px}.login-btn[data-v-e228b8c0]{text-align:center}.login-btn button[data-v-e228b8c0]{width:100%;height:36px}.configBtn[data-v-e228b8c0]{text-align:center;padding-top:25px}.configBtn .el-button--text[data-v-e228b8c0]{color:#20a0ff}", ""]);

// exports


/***/ }),

/***/ 621:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "login-wrap"
  }, [_c('div', {
    staticClass: "ms-login"
  }, [_c('div', {
    staticClass: "ms-title"
  }, [_vm._v("泰科力合销售CRM管理系统")]), _vm._v(" "), _c('el-form', {
    ref: "ruleForm",
    staticClass: "demo-ruleForm",
    attrs: {
      "model": _vm.ruleForm,
      "rules": _vm.rules,
      "label-width": "0px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "prop": "username"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入用户名"
    },
    model: {
      value: (_vm.ruleForm.username),
      callback: function($$v) {
        _vm.$set(_vm.ruleForm, "username", $$v)
      },
      expression: "ruleForm.username"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "prop": "password"
    }
  }, [_c('el-input', {
    attrs: {
      "type": "password",
      "placeholder": "请输入密码"
    },
    nativeOn: {
      "keyup": function($event) {
        if (!('button' in $event) && _vm._k($event.keyCode, "enter", 13, $event.key)) { return null; }
        _vm.submitForm('ruleForm')
      }
    },
    model: {
      value: (_vm.ruleForm.password),
      callback: function($$v) {
        _vm.$set(_vm.ruleForm, "password", $$v)
      },
      expression: "ruleForm.password"
    }
  })], 1), _vm._v(" "), _c('div', {
    staticClass: "login-btn"
  }, [_c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": function($event) {
        _vm.submitForm('ruleForm')
      }
    }
  }, [_vm._v("登录")])], 1)], 1)], 1)])
},staticRenderFns: []}

/***/ }),

/***/ 647:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(590);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("6281cf1e", content, true);

/***/ })

});