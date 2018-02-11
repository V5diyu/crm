import Vue from 'vue';

var util = {
	getRoot(val){
        var userMsg = JSON.parse(localStorage.getItem('userInfo'))
        if (userMsg.power == '1' || userMsg.setUp[val].operate == '1') {
            return true
        }else {
            return false
        }
    },
}
	
Vue.prototype.$util = util;