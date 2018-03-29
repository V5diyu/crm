var  util = {
    loadMore: function(cb){
        var bH = 0;
        var sH = 0;
        var top = 0;
        var num = 0;
        var ua = navigator.userAgent.toLowerCase();
        if (ua.match(/android/i) === 'android') {
            num = 74;
        }
        window.onscroll = function(){
            bH = document.body.scrollHeight;
            sH = screen.availHeight;
            top = document.documentElement.scrollTop || document.body.scrollTop;

            // alert(top + sH);
            // alert(bH);


            // console.log(top)
            // console.log(screen.availHeight)
            // console.log(top + sH)

            // alert(top)
            // alert(screen.availHeight)
            // alert(top + sH)



            if (top + sH - num >= bH) {
                cb && cb();
            }else{
                console.log(top + sH);
                console.log(bH);
            }
        };
    },
    getParams: function(name){
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if(r!=null)return  unescape(r[2]); return null;
    },
    getTime: function () {
        var d = new Date();
        var year = d.getFullYear();
        var mon = d.getMonth() + 1;
        var day = d.getDate();
        var hour = d.getHours();
        var minu = d.getMinutes();
        return year + '-' + mon + '-' + day + ' ' + hour + ':' + minu;
    }
};


var ajax = {
    post: function(url, data, cb){
        axios.post(url, Qs.stringify(data),{
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        }).then(function(res) {
            if (res.data.ret == true) {
                cb && cb(res.data);
            } else {
                ding.toast(res.data.msg)
            }
        })
    }
};