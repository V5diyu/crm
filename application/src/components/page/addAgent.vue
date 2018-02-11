<template>
    <div class="table">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 代理商管理</el-breadcrumb-item>
                    <el-breadcrumb-item>代理商池</el-breadcrumb-item>
                    <el-breadcrumb-item>{{$route.query.id ? '修改代理商' : '新增代理商'}}</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <el-form ref="form" :model="form" label-position="left" label-width="120px" class="mainForm">

                <el-form-item label="代理商类型">
                    <el-radio-group v-model="form.type">
                        <el-radio-button label="1">代理商</el-radio-button>
                        <el-radio-button label="2">代理人</el-radio-button>
                    </el-radio-group>
                </el-form-item>


                <div class="section-header">基本信息</div>

                <!-- 代理商 -->
                <div class="baseInfo" v-show="form.type == 1">
                    
                    <el-form-item label="代理商编码">
                        <el-input v-model="form.code"></el-input>
                    </el-form-item>
                    <el-form-item label="代理商名称">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="代理商简称">
                        <el-input v-model="form.abbreviation"></el-input>
                    </el-form-item>
                    <el-form-item label="法定代表人">
                        <el-input v-model="form.legalRepresentative"></el-input>
                    </el-form-item>
                    <el-form-item label="地址">
                        <el-input v-model="form.address"></el-input>
                    </el-form-item>
                    <el-form-item label="注册资金/万">
                        <el-input v-model="form.registeredCapital"></el-input>
                    </el-form-item>
                    <el-form-item label="去年贡献收入/万">
                        <el-input v-model="form.lastYearSales"></el-input>
                    </el-form-item>
                    <el-form-item label="代理级别">
                        <el-input v-model="form.proxyLevel"></el-input>
                    </el-form-item>
                    <el-form-item label="其他情况说明">
                        <el-input v-model="form.explain"></el-input>
                    </el-form-item>
                </div>

                <!-- 代理人 -->
                <div class="baseInfo" v-show="form.type == 2">
                    <el-form-item label="代理商编码">
                        <el-input v-model="form.code"></el-input>
                    </el-form-item>
                    <el-form-item label="代理商名称">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="其他情况说明">
                        <el-input v-model="form.explain"></el-input>
                    </el-form-item>
                </div>

                <div v-show="form.type == 1">
                    <div class="section-header">主要人员</div>
                    
                    <div class="mainPerson" style="border-bottom: 1px dashed #e8e8e8;margin-bottom: 20px" 
                        v-for="(item, index) in form.mainPersonnel">
                        <el-form-item label="职务">
                            <el-input v-model="item.duties"></el-input>
                        </el-form-item>
                        <el-form-item label="姓名">
                            <el-input v-model="item.name"></el-input>
                        </el-form-item>
                        <el-form-item label="电话">
                            <el-input v-model="item.phone"></el-input>
                        </el-form-item>
                        <el-form-item label="备注">
                            <el-input v-model="item.remarks"></el-input>
                        </el-form-item>
                    </div>

                    <el-form-item label="">
                        <el-button type="primary" @click="addMainPersonnel">新增主要人员</el-button>
                    </el-form-item>
                </div>
                

                <div class="section-header"></div>

                <el-form-item label="">
                    <el-button type="success" size="large" @click="add">提交</el-button>
                </el-form-item>
            </el-form>
        </div>

        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    type: 1,
                    code: '',                     //代理商代码
                    name: '',                     //代理商名称
                    abbreviation: '',             //代理商简称
                    legalRepresentative: '',      //法定代表人
                    address: '',                  //地址
                    registeredCapital: '',        //注册资金
                    lastYearSales: '',            //去年贡献收入
                    proxyLevel: '',               //代理级别  1 2 3
                    explain: '',                  //其他情况说明
                    mainPersonnel: [{}],            //主要人员{'duties':'','name':'','phone':'','remarks':''}
                }
            }
        },
        created(){
            if (this.$route.query.id) {
                this.getData();
            }
        },
        methods: {
            initData(val){
                this.form = {
                    type: val,
                    code: '',                     //代理商代码
                    name: '',                     //代理商名称
                    abbreviation: '',             //代理商简称
                    legalRepresentative: '',      //法定代表人
                    address: '',                  //地址
                    registeredCapital: '',        //注册资金
                    lastYearSales: '',            //去年贡献收入
                    proxyLevel: '',               //代理级别  1 2 3
                    explain: '',                  //其他情况说明
                    mainPersonnel: [{}],            //主要人员{'duties':'','name':'','phone':'','remarks':''}
                }
            },
            getData(){
                this.$axios.post('getAgentById', {
                    id: this.$route.query.id
                }, (res) => {
                    if (res.ret == true) {
                        this.form = res.data
                    }
                })
            },
            // 新增主要人员
            addMainPersonnel(){
                this.form.mainPersonnel.push({})
            },
            add(){
                let self = this;
                console.log(this.form)

                if (this.$route.query.id) {
                    this.$axios.post('updateAgent', self.form, (res) => {
                        if (res.ret == true) {
                            self.$message.success('修改成功');
                        }
                    })
                }else{
                    this.$axios.post('addAgent', self.form, (res) => {
                        if (res.ret == true) {
                            self.initData(self.form.type)
                            self.$message.success('添加成功');
                        }
                    })
                }
            },
        }
    }
</script>

<style>
   	.section-header{
        height: 40px;
        line-height: 40px;
        border-top: 6px solid #e8e8e8;
        color: #999;
        font-size: 14px;
        /*text-indent: 10px;*/
    }
    .mainForm .mainPerson input{
        width: 400px;
    }
    .mainForm input{
        width: 600px;
    }
</style>