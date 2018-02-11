<template>
    <div class="sidebar">
        <el-menu :default-active="onRoutes" class="el-menu-vertical-demo" theme="dark" unique-opened router>
            <!-- 管理员权限 -->
            <div v-if="setUp == 1">
                <el-submenu index="1">
                    <template slot="title"><i class="iconfont icon-gongzuotai"></i>工作台</template>
                    <el-menu-item index="productTime">产品交期表</el-menu-item>
                    <el-menu-item index="order">订单信息</el-menu-item>
                </el-submenu>

                <el-submenu index="2">
                    <template slot="title"><i class="iconfont icon-kehu"></i>客户管理</template>
                    <el-menu-item index="customer">客户池</el-menu-item>
                    <el-menu-item index="customer-follow-up">已跟进客户</el-menu-item>
                    <el-menu-item index="customerSaleRecord">沟通记录</el-menu-item>
                </el-submenu>

                <el-submenu index="3">
                    <template slot="title"><i class="iconfont icon-dailishang"></i>代理商管理</template>
                    <el-menu-item index="agent">代理商池</el-menu-item>
                    <el-menu-item index="agent-follow-up">已跟进代理商</el-menu-item>
                    <el-menu-item index="agentSaleRecord">沟通记录</el-menu-item>
                </el-submenu>

                <el-submenu index="4">
                    <template slot="title"><i class="iconfont icon-chanpin2"></i>两周未联系</template>
                    <el-menu-item index="customer-contact">待联系客户</el-menu-item>
                    <el-menu-item index="agent-contact">待联系代理商</el-menu-item>
                </el-submenu>

                <el-menu-item index="seller">
                    <i class="iconfont icon-xiaoshouyuanzhongxin"></i>销售员管理
                </el-menu-item>

                <el-menu-item index="manager">
                    <i class="iconfont icon-admin"></i>账号管理
                </el-menu-item>
                <el-menu-item index="autosyn">
                    <i class="iconfont icon-log"></i>同步日志
                </el-menu-item>
            </div>

            <!-- 销售助理权限 -->
            <div v-if="setUp == 2">
                <el-menu-item index="productTime">
                    <i class="iconfont icon-gongzuotai"></i>产品交期表
                </el-menu-item>
                <el-menu-item index="customer">
                    <i class="iconfont icon-kehu"></i>客户管理
                </el-menu-item>
                <el-menu-item index="agent">
                    <i class="iconfont icon-dailishang"></i>代理商管理
                </el-menu-item>
                <el-menu-item index="autosyn">
                    <i class="iconfont icon-admin"></i>同步日志
                </el-menu-item>
            </div>

            <!-- 财务权限 -->
            <div v-if="setUp == 3">
                <el-menu-item index="order">
                    <i class="iconfont icon-gongzuotai"></i>订单信息
                </el-menu-item>
                <el-menu-item index="autosyn">
                    <i class="iconfont icon-admin"></i>同步日志
                </el-menu-item>
            </div>

            <!-- 销售人员权限 -->
            <div v-if="setUp == 4">
                <el-submenu index="1">
                    <template slot="title"><i class="iconfont icon-gongzuotai"></i>工作台</template>
                    <el-menu-item index="productTime">产品交期表</el-menu-item>
                    <el-menu-item index="order">订单信息</el-menu-item>
                </el-submenu>

                <el-submenu index="2">
                    <template slot="title"><i class="iconfont icon-kehu"></i>我的客户</template>
                    <el-menu-item index="customer-seller">客户列表</el-menu-item>
                    <el-menu-item index="customerSaleRecord">沟通记录</el-menu-item>
                </el-submenu>

                <el-submenu index="3">
                    <template slot="title"><i class="iconfont icon-dailishang"></i>我的代理商</template>
                    <el-menu-item index="agent-seller">代理商列表</el-menu-item>
                    <el-menu-item index="agentSaleRecord">沟通记录</el-menu-item>
                </el-submenu>

                <el-submenu index="4">
                    <template slot="title"><i class="iconfont icon-chanpin2"></i>两周未联系</template>
                    <el-menu-item index="customer-contact">待联系客户</el-menu-item>
                    <el-menu-item index="agent-contact">待联系代理商</el-menu-item>
                </el-submenu>

                <el-menu-item index="saleRecord">
                    <i class="iconfont icon-chanpin"></i>沟通记录
                </el-menu-item>
                <el-menu-item index="autosyn">
                    <i class="iconfont icon-log"></i>同步日志
                </el-menu-item>
            </div>
            
        </el-menu>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                userMsg: {},
                setUp: 0, //1：管理人员 2：销售助理 3:财务 4：销售人员
            }
        },
        created(){
            //console.log(JSON.parse(localStorage.getItem('userInfo')));
            let userInfo = localStorage.getItem('userInfo') && JSON.parse(localStorage.getItem('userInfo'));
            this.setUp = userInfo.setUp;
        },
        computed:{
            onRoutes(){
                return this.$route.path.replace('/','');
            }
        },
        methods: {
            
        }
    }
</script>

<style scoped>
    .sidebar{
        display: block;
        position: absolute;
        width: 200px;
        left: 0;
        top: 70px;
        bottom:0;
        box-shadow: -6px 3px 12px 3px #000;
    }
    .sidebar > ul {
        height:100%;
        overflow: auto;
        overflow-x: hidden;
    }

    .sidebar .iconfont {
        vertical-align: middle;
        margin-right: 5px;
        width: 24px;
        font-size: 20px;
        text-align: center;
        line-height: 1;
        display: inline-block;
    }

</style>
