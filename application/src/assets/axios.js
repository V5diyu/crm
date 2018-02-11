import Vue from 'vue';
import axios from 'axios';
import service from './service.js';
import qs from 'qs';


var ajax = {
    post: function(url, data, cb){
        axios.post(service.url(url), qs.stringify(data),{
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        }).then((res) => {
            if (res.data.ret == true) {
                cb && cb(res.data);
            }else if(res.data.code == 501){
                // Vue.prototype.$message.error('登录状态失效, 正在跳转...');
                setTimeout(function(){ location.href = "/" }, 2000);
            }else{
                Vue.prototype.$message.error(res.data.msg);
            }
        })
    },
    get: function(url, data, cb){
        axios.get(url, { params: data}).then((res) => {
            if (res.data.ret == true) {
                cb && cb(res.data);
            }else if(res.data.code == 501){
                // Vue.prototype.$message.error('登录状态失效, 正在跳转...');
                setTimeout(function(){ location.href = "/" }, 2000);
            }else{
                Vue.prototype.$message.error(res.data.msg);
            }
        }).catch((error) => {
            console.log(error);
        });
    }
}



Vue.prototype.$axios = ajax;