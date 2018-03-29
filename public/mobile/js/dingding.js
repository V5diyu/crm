var ding = {
    // 线上 ding754fc15c56c1f77a
    // 线下 dingaf5e12d89641dea835c2f4657eb6378f
    corpId: "ding754fc15c56c1f77a", // online
    // corpId: "dingaf5e12d89641dea835c2f4657eb6378f", // dev

    // 技术经理userId
    technicalManagerUserId: "043316155723737968", // online
    // technicalManagerUserId: "162423286138193306", // dev
    /**
     * ready 初始化钉钉SDK
     * @param cb
     */
    ready: function(cb){
        var self = this;



        axios.get('/api/tools/getJsapiConfig1', {
            params: {
                url: location.href,
                random: Math.random()
            }
        }).then(function (resp) {
            // alert(JSON.stringify(resp.data.timeStamp))

            dd.config({
                agentId: resp.data.agentId, // 必填，微应用ID
                corpId: resp.data.corpId,//必填，企业ID
                timeStamp: resp.data.timeStamp, // 必填，生成签名的时间戳
                nonceStr: resp.data.nonceStr, // 必填，生成签名的随机串
                signature: resp.data.signature, // 必填，签名
                type: 0,   //选填。0表示微应用的jsapi,1表示服务窗的jsapi。不填默认为0。该参数从dingtalk.js的0.8.3版本开始支持
                jsApiList : [ 'runtime.info', 'biz.contact.choose',
                    'device.notification.confirm', 'device.notification.alert',
                    'device.notification.prompt', 'biz.ding.post',
                    'biz.util.openLink', 'runtime.permission.requestOperateAuthCode',
                    'biz.chat.chooseConversationByCorpId', 'biz.contact.departmentsPicker',
                    'biz.user', 'biz.contact.complexPicker', 'biz.ding.create'] // 必填，需要使用的jsapi列表，注意：不要带dd。
            });
            dd.ready(function(){
                // self.toast('ready');
                cb && cb();
            });
            dd.error(function(error){
                alert(resp.data.jsticket+'||'+resp.data.timeStamp + 'dd error: ' + JSON.stringify(error));
            });
        }).catch(function (error) {
            alert(JSON.stringify(error));
        });
    },
    /**
     * getUserInfo 获取当前用户信息
     * @param cb
     */
    getUserInfo: function(cb){
        var self = this;
        var dingUserInfoTime = localStorage.getItem('dingUserInfoTime');
        if (+new Date() - dingUserInfoTime > 600000) {
            localStorage.removeItem('dingUserInfo');
        }
        var userInfo = localStorage.getItem('dingUserInfo');
        if (userInfo && userInfo != 'undefined') {
            cb && cb({data: JSON.parse(userInfo)});
            return;
        }
        dd.runtime.permission.requestAuthCode({
            corpId: self.corpId,
            onSuccess: function(result) {
                axios.get('/api/user/getUserInfo', {
                    params: {
                        code: result.code
                    }
                }).then(function (resp) {
                    // alert(JSON.stringify(resp));

                    var department = resp.data.data.department;

                    resp.data.data.auth = 0; // 1（销售部） 2 （技术部） 3（Boos）4（技术经理）

                    // 线上 销售部门 （57721718、57721714） 技术支持部门 49158037
                    // 线下 销售部门 53371089 技术支持部门 57597413

                    // dev
                    // 销售部
                    // if (department.indexOf(53371089) > -1) {
                    //     resp.data.data.auth = 1;
                    // }
                    // // 技术部
                    // if (department.indexOf(57597413) > -1) {
                    //     resp.data.data.auth = 2;
                    // }

                    // online
                    // 销售部
                    if (department.indexOf(57721718) > -1 || department.indexOf(57721714) > -1) {
                        resp.data.data.auth = 1;
                    }
                    // 技术部
                    if (department.indexOf(49158037) > -1) {
                        resp.data.data.auth = 2;
                    }
                    //  3（Boos）4（技术经理）
                    if (resp.data.data.roles && resp.data.data.roles.length > 0) {
                        resp.data.data.roles.forEach(function(item){
                            // 查看首页总记录
                            if (item.name === '主管') {
                                resp.data.data.auth = 3;
                            }
                            if (item.name === '技术经理'){
                                resp.data.data.auth = 4;
                            }
                        })
                    }

                    if (resp.data.data.auth === 0) {
                        alert('权限不足');
                        return;
                    }

                    localStorage.setItem('dingUserInfo', JSON.stringify(resp.data.data));
                    localStorage.setItem('dingUserInfoTime', +new Date());
                    cb && cb(resp.data);
                }).catch(function (error) {
                    // alert(JSON.stringify(error));
                    alert('JSDK权限不足');
                });
            },
            onFail : function(err) {
                alert(JSON.stringify(err))
            }

        });
    },
    /**
     * sendDing
     * 发钉
     */
    sendDing: function(params, cb){
        var self = this;
        dd.biz.ding.create({
            users : params.userId,// 用户列表，工号
            corpId: self.corpId, // 企业id
            type: 2, // 附件类型 1：image  2：link
            alertType: 0, // 钉发送方式 0:电话, 1:短信, 2:应用内
            alertDate: {"format":"yyyy-MM-dd HH:mm","value":"2015-05-09 08:00"},
            attachment: {
                title: '技术申请页面',
                url: params.url,
                image: '',
                text: '点击查看'
            }, // 附件信息
            text: params.text,  // 正文
            bizType :0, // 业务类型 0：通知DING；1：任务；2：会议；
            // confInfo:{
            //     bizSubType:0, // 子业务类型如会议：0：预约会议；1：预约电话会议；2：预约视频会议；（注：目前只有会议才有子业务类型）
            //     location:'某某会议室' , //会议地点；（非必填）
            //     startTime:{"format":"yyyy-MM-dd HH:mm","value":"2015-05-09 08:00"},// 会议开始时间
            //     endTime:{"format":"yyyy-MM-dd HH:mm","value":"2015-05-09 08:00"}, // 会议结束时间
            //     remindMinutes:30, // 会前提醒。单位分钟-1：不提醒；0：事件发生时提醒；5：提前5分钟；15：提前15分钟；30：提前30分钟；60：提前1个小时；1440：提前一天；
            //     remindType:2 // 会议提前提醒方式。0:电话, 1:短信, 2:应用内
            // },
            // taskInfo:{
            //     ccUsers: ['100', '101'], // 抄送用户列表，工号
            //     deadlineTime:{"format":"yyyy-MM-dd HH:mm","value":"2015-05-09 08:00"} , // 任务截止时间
            //     taskRemind:30// 任务提醒时间，单位分钟0：不提醒；15：提前15分钟；60：提前1个小时；180：提前3个小时；1440：提前一天；
            // },
            onSuccess : function() {
                //onSuccess将在点击发送之后调用
                cb && cb();
            },
            onFail : function(err) {
                alert(JSON.stringify(err));
            }
        })
    },
    /**
     * chooseContact
     * 选择联系人
     */
    chooseContact: function(cb){
        var self = this;
        dd.biz.contact.choose({
            startWithDepartmentId: -1, //-1表示打开的通讯录从自己所在部门开始展示, 0表示从企业最上层开始，(其他数字表示从该部门开始:暂时不支持)
            multiple: true, //是否多选： true多选 false单选； 默认true
            users: [], //默认选中的用户列表，userid；成功回调中应包含该信息
            disabledUsers:[],// 不能选中的用户列表，员工userid
            corpId: self.corpId, //企业id
            max: 1500, //人数限制，当multiple为true才生效，可选范围1-1500
            limitTips:"xxx", //超过人数限制的提示语可以用这个字段自定义
            isNeedSearch: true, // 是否需要搜索功能
            title : "选择xxxx", // 如果你需要修改选人页面的title，可以在这里赋值
            local:"true", // 是否显示本地联系人，默认false
            onSuccess: function(data) {
                cb && cb(data);
            },
            onFail : function(err) {}
        });
    },
    chooseContactAndDepartments: function (cb) {
        var self = this;
        dd.biz.contact.complexPicker({
            title: "指派技术人员",            //标题
            corpId: self.corpId,              //企业的corpId
            multiple: true,            //是否多选
            limitTips: "超出了",          //超过限定人数返回提示
            maxUsers: 1000,            //最大可选人数
            pickedUsers: [],            //已选用户
            pickedDepartments: [],          //已选部门
            disabledUsers:[],            //不可选用户
            disabledDepartments:[],        //不可选部门
            requiredUsers:[],            //必选用户（不可取消选中状态）
            requiredDepartments:[],        //必选部门（不可取消选中状态）
            appId: 157845448,              //微应用的Id
            permissionType: "GLOBAL",          //选人权限，目前只有GLOBAL这个参数
            responseUserOnly:false,        //返回人，或者返回人和部门
            onSuccess: function(result) {
                cb && cb(result);
                /**
                 {
                     selectedCount:1,                              //选择人数
                     users:[{"name":"","avatar":"","emplId":""}]，//返回选人的列表，列表中的对象包含name（用户名），avatar（用户头像），emplId（用户工号）三个字段
                     departments:[{"id":,"name":"","number":}]//返回已选部门列表，列表中每个对象包含id（部门id）、name（部门名称）、number（部门人数）
                 }
                 */
            },
            onFail : function(err) {
                alert(JSON.stringify(err))
            }
        });

    },
    /**
     * chooseDepartments
     * 选择部门
     */
    chooseDepartments: function(cb){
        var self = this;
        dd.biz.contact.departmentsPicker({
            title:"选择本人所在部门",            //标题
            corpId: self.corpId,              //企业的corpId
            multiple: false,            //是否多选
            limitTips: "超出了",          //超过限定人数返回提示
            maxDepartments:100,            //最大选择部门数量
            pickedDepartments:[],          //已选部门
            disabledDepartments:[],        //不可选部门
            requiredDepartments:[],        //必选部门（不可取消选中状态）
            appId: 129778405,              //微应用的Id
            permissionType: "GLOBAL",          //选人权限，目前只有GLOBAL这个参数
            onSuccess: function(result) {
                // alert(JSON.stringify(result))
                cb && cb(result.departments[0]);
            },
            onFail : function(err) {
                alert(JSON.stringify(err))
            }
        });
    },
    /**
     * showLoading 显示loading动画
     */
    showLoading: function(){
        dd.device.notification.showPreloader({
            text: "加载中..",
            showIcon: true
        })
    },
    /**
     * hideLoading 隐藏loading动画
     */
    hideLoading: function(){
        dd.device.notification.hidePreloader({})
    },
    /**
     * toast 显示提示信息
     * @param text      提示文本
     * @param duration  时长
     * @param delay     延迟时间
     */
    toast: function(text, duration, delay){
        dd.device.notification.toast({
            icon: '', //icon样式，有success和error，默认为空 0.0.2
            text: text, //提示信息
            duration: duration || 2, //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
            delay: delay || 0 //延迟显示，单位秒，默认0
        })
    },
    /**
     * actionSheet 单选列表
     * @param cb            回调函数
     * @param title         标题
     * @param cancelButton  取消文本
     * @param otherButtons  选项
     */
    actionSheet: function (cb, title, cancelButton, otherButtons) {
        dd.device.notification.actionSheet({
            title: title || "标题", //标题
            cancelButton: cancelButton || '取消', //取消按钮文本
            otherButtons: otherButtons || ["孙悟空","猪八戒","唐僧","沙和尚"],
            onSuccess : function(result) {
                cb && cb(result);
            }
        })
    },
    /**
     * modal 弹出层
     * @param cb
     * @param image
     * @param banner
     * @param title
     * @param content
     * @param buttonLabels
     */
    modal: function (cb, image, banner, title, content, buttonLabels) {
        dd.device.notification.modal({
            image:  "http://gw.alicdn.com/tps/i2/TB1SlYwGFXXXXXrXVXX9vKJ2XXX-2880-1560.jpg_200x200.jpg", // 标题图片地址
            banner: ["http://gw.alicdn.com/tps/i2/TB1SlYwGFXXXXXrXVXX9vKJ2XXX-2880-1560.jpg_200x200.jpg"],   // 图片地址列表
            title: "2.4版本更新", //标题
            content: "1.功能更新2.功能更新;", //文本内容
            buttonLabels: ["了解更多","知道了"],// 最多两个按钮，至少有一个按钮。
            onSuccess : function(result) {
                cb && cb(result);
            },
            onFail : function(err) {}
        })
    },
    /**
     * alert
     * @param cb
     * @param message
     * @param title
     * @param buttonName
     */
    alert: function(cb, message, title, buttonName){
        dd.device.notification.alert({
            message: message || "",
            title: title || "",//可传空
            buttonName: buttonName || "确认",
            onSuccess : function() {
                cb && cb();
            }
        });
    },
    /**
     * confirm
     * @param cb
     * @param message
     * @param title
     * @param buttonLabels
     */
    confirm: function(cb, message, title, buttonLabels){
        dd.device.notification.confirm({
            message: message || "",
            title: title || "提示",
            buttonLabels: buttonLabels || ['确定', '取消'],
            onSuccess : function(result) {
                cb && cb(result);
            }
        });
    },
    /**
     * prompt
     * @param cb
     * @param message
     * @param title
     * @param buttonLabels
     */
    prompt: function(cb, title, message, buttonLabels){
        dd.device.notification.prompt({
            message: message || "",
            title: title || "提示",
            defaultText: "",
            buttonLabels: buttonLabels || ['确定', '取消'],
            onSuccess : function(result) {
                cb && cb(result);
            }
        });
    },
    /**
     * datepicker 日期选择器
     * @param value
     */
    datepicker: function(cb, value){
        var d = new Date();
        var year = d.getFullYear();
        var mon = d.getMonth() + 1;
        var day = d.getDate();
        var hour = d.getHours();
        var minu = d.getMinutes();
        var val = year + '-' + mon + '-' + day + ' ' + hour + ':' + minu;

        dd.biz.util.datetimepicker({
            format: 'yyyy-MM-dd HH:mm',
            value: val,
            onSuccess : function(result) {
                cb && cb(result);
            },
            onFail : function(err) {}
        })
    }

};