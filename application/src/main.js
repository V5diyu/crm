import Vue from 'vue';
import App from './App';
import router from './router';

import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-default/index.css';    // 默认主题
// import '../static/css/theme-green/index.css';       // 浅绿色主题
import '../static/css/index.css';       // 骚红主题

import "babel-polyfill";
// import './mock/index.js';
Vue.use(ElementUI);

import axios from 'assets/axios.js';
import util from 'assets/util.js';

router.beforeEach((to, from, next) => {
	if (!localStorage.getItem('ms_username') && to.query.isLoginPage !== 'true') {
		next({ path: '/login', query: { isLoginPage: 'true' } })
	}else{
		next();
	}
})



// Vue.directive('auth', {
//   	inserted: function (el, binding) {
//     	console.log(el, binding);
//     	el.disabled = 'disabled';
//     	el.className  = el.className + ' is-disabled'
//     	el.onmouseover = function(){
//     		alert('你没有权限')
//     	}
//   	}
// })

new Vue({
    router,
    render: h => h(App)
}).$mount('#app');

// 注册一个全局自定义指令 v-focus
Vue.directive('focus', {
  // 当绑定元素插入到 DOM 中。
  inserted: function (el) {
    // 聚焦元素
    el.focus()
  }
})