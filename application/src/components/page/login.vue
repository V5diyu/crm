<template>
    <div class="login-wrap">
        <div class="ms-login">
            <div class="ms-title">泰科力合销售CRM管理系统</div>  
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="0px" class="demo-ruleForm">
                <el-form-item prop="username">
                    <el-input v-model="ruleForm.username" placeholder="请输入用户名"></el-input>
                </el-form-item>
                <el-form-item prop="password">
                    <el-input type="password" placeholder="请输入密码" v-model="ruleForm.password" @keyup.enter.native="submitForm('ruleForm')"></el-input>
                </el-form-item>
                <div class="login-btn">
                    <el-button type="primary" @click="submitForm('ruleForm')">登录</el-button>
                </div>
            </el-form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                ruleForm: {
                    username: '',
                    password: ''
                },
                rules: {
                    username: [
                        { required: true, message: '请输入用户名', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            submitForm(formName) {
                const self = this;
                self.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$axios.post('login', {
                            account: self.ruleForm.username,
                            pwd: self.ruleForm.password,
                        }, (resp) => {
                            if (resp.ret) {
                                this.$message.success('登陆成功，正在跳转...');
                                localStorage.setItem('ms_username', self.ruleForm.username);
                                localStorage.setItem('userInfo', JSON.stringify(resp.data));

                                var path = '';
                                if (resp.data.setUp == 1) {
                                    path = '/manager';
                                }else if (resp.data.setUp == 2) {
                                    path = '/productTime';
                                }else if (resp.data.setUp == 3) {
                                    path = '/order';
                                }else if (resp.data.setUp == 4) {
                                    path = '/customer-seller';
                                }

                                setTimeout(function(){self.$router.push(path);},1000);
                            }else {
                                this.$message.error(resp.msg)
                            }

                        })
                    } else {
                        this.$message.error('请输入正确的账号密码');
                        return false;
                    }
                });
            },
        }
    }
</script>

<style scoped>
    .login-wrap{
        position: relative;
        width:100%;
        height:100%;
        background-image: url('/static/img/bj.jpg');
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }
    .ms-title{
        left: 50%;
        top: 20px;
        text-align: center;
        font-size:19px;
        margin-bottom: 20px;
        color: #fff;
    }
    .ms-login{
        position: absolute;
        left:50%;
        top:50%;
        width:300px;
        background-color: rgba(0,0,0, .6);
        margin:-180px 0 0 -190px;
        padding:40px;
        border-radius: 5px;
        box-shadow: 0 0 6px 0 rgba(0,0,0,.04), 0 2px 4px 0 rgba(0,0,0,.12);

    }
    .ms-login .el-form-item {
        margin-bottom: 30px;
    }
    .login-btn{
        text-align: center;
    }
    .login-btn button{
        width:100%;
        height:36px;
    }
    .configBtn {
        text-align: center;
        padding-top: 25px;
    }
    .configBtn .el-button--text{
        color: #20a0ff;
    }
</style>
