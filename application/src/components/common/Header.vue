<template>
    <div class="header">
        <div class="logo">泰科力合销售CRM管理系统</div>
        <div class="user-info">
            <el-dropdown trigger="click" @command="handleCommand">
                <span class="el-dropdown-link">
                    <img class="user-logo" src="../../../static/img/defultAvatar.jpg">
                    {{username}}
                </span>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item command="edit">修改密码</el-dropdown-item>
                    <el-dropdown-item command="loginout">退出</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>

        <el-dialog title="修改密码" v-model="visible" size="tiny">
            <el-form ref="form" :model="form" label-width="80px">
                <el-form-item label="原密码">
                    <el-input v-model="form.yPwd" type="password" placeholder="请输入原密码"></el-input>
                </el-form-item>

                <el-form-item label="新密码">
                    <el-input v-model="form.pwd" type="password" placeholder="请输入新密码"></el-input>
                </el-form-item>

                <el-form-item label="确认新密码">
                    <el-input v-model="form.rpwd" type="password" placeholder="请再次输入新密码"></el-input>
                </el-form-item>
            </el-form>

            <span slot="footer" class="dialog-footer">
                <el-button @click="visible = false">取 消</el-button>
                <el-button type="primary" @click="edit">修 改</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    export default {
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
            }
        },
        computed:{
            username(){
                let userInfo = localStorage.getItem('userInfo') && JSON.parse(localStorage.getItem('userInfo'));
                this.userInfo = userInfo;
                this.form.id = userInfo.id;
                return userInfo.name;
            }
        },
        methods:{
            edit(){
                if (this.form.pwd != this.form.rpwd) {
                    this.$message.error('新密码与确认密码不一致');
                    return;
                }

                this.$axios.post('updatePwd', this.form, (res) => {
                    if (res.ret == true) {
                        this.$message.success('修改成功');
                        this.visible = false;
                    }else{
                        this.$message.error('修改失败');
                    }
                })
            },
            handleCommand(command) {
                if(command == 'loginout'){
                    this.$axios.post('logout', {}, (res) => {
                        if (res.ret == true) {
                            localStorage.removeItem('ms_username');
                            this.$router.push('/login');
                            this.$message.success('退出成功');
                        }
                    })
                }else if (command == "edit") {
                    this.visible = true;
                }
            }
        }
    }
</script>
<style scoped>
    .header {
        position: relative;
        box-sizing: border-box;
        width: 100%;
        height: 70px;
        font-size: 22px;
        line-height: 70px;
        color: #fff;
        background-color: #242424;
    }
    .header .logo{
        float: left;
        width:260px;
        text-indent: 20px;
    }
    .user-info {
        float: right;
        padding-right: 50px;
        font-size: 16px;
        color: #fff;
    }
    .user-info .el-dropdown-link{
        position: relative;
        display: inline-block;
        padding-left: 50px;
        color: #fff;
        cursor: pointer;
        vertical-align: middle;
    }
    .user-info .user-logo{
        position: absolute;
        left:0;
        top:15px;
        width:40px;
        height:40px;
        border-radius: 50%;
    }
    .el-dropdown-menu__item{
        text-align: center;
    }
</style>
