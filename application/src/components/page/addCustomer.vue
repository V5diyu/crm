<template>
    <div class="table">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 客户管理</el-breadcrumb-item>
                    <el-breadcrumb-item>客户池</el-breadcrumb-item>
                    <el-breadcrumb-item>{{$route.query.id ? '修改客户' : '新增客户'}}</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <el-form ref="form" :model="form" label-position="left" label-width="100px" class="mainForm">
                <el-form-item label="客户类型">
                    <el-radio-group v-model="form.type">
                        <el-radio-button label="1">终端</el-radio-button>
                        <el-radio-button label="2">厂家</el-radio-button>
                    </el-radio-group>
                </el-form-item>

                <div class="section-header">基本信息</div>

                <!-- 终端 -->
                <div class="baseInfo" v-show="form.type == 1">
                    <el-form-item label="名称">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="编号">
                        <el-input v-model="form.code"></el-input>
                    </el-form-item>
                    
                    <v-city ref="vCity" :prov="form.province" :city.sync="form.city"></v-city>
                    <el-form-item label="地址">
                        <el-input v-model="form.address"></el-input>
                    </el-form-item>
                    <el-form-item label="阶段">
                        <el-input v-model="form.stage"></el-input>
                    </el-form-item>
                    <el-form-item label="其他情况说明">
                        <el-input v-model="form.explain"></el-input>
                    </el-form-item>
                    <el-form-item label="中间公司">
                        <el-input v-model="form.intermediaryCompany"></el-input>
                    </el-form-item>
                    <!-- <el-form-item label="跟进销售人员">
                        <el-input v-model="form.salesperson"></el-input>
                    </el-form-item> -->
                </div>

                <!-- 厂家 -->
                <div class="baseInfo" v-show="form.type == 2">
                    <el-form-item label="名称">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="编号">
                        <el-input v-model="form.code"></el-input>
                    </el-form-item>
                    <el-form-item label="简称">
                        <el-input v-model="form.abbreviation"></el-input>
                    </el-form-item>
                    <el-form-item label="法定代表人">
                        <el-input v-model="form.legalRepresentative"></el-input>
                    </el-form-item>
                    <el-form-item label="注册资金/万">
                        <el-input v-model="form.registeredCapital"></el-input>
                    </el-form-item>
                    <el-form-item label="去年销售额">
                        <el-input v-model="form.lastYearSales"></el-input>
                    </el-form-item>
                    <el-form-item label="评级">
                        <el-input v-model="form.customerRating"></el-input>
                    </el-form-item>
                    <el-form-item label="其他情况说明">
                        <el-input v-model="form.explain"></el-input>
                    </el-form-item>
                    <!-- <el-form-item label="跟进销售人员">
                        <el-input v-model="form.salesperson"></el-input>
                    </el-form-item> -->
                </div>
                

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

                <!-- <div v-show="form.type == 2">
                    <div class="section-header">合作情况</div>
                    
                    <div class="mainPerson" style="border-bottom: 1px dashed #e8e8e8;margin-bottom: 20px"v-for="(item, index) in form.cooperationSituation">
                        <el-form-item label="历史合作">
                            <el-input v-model="item.historical"></el-input>
                        </el-form-item>
                        <el-form-item label="去年合作收入">
                            <el-input v-model="item.income"></el-input>
                        </el-form-item>
                    </div>

                    <el-form-item label="">
                        <el-button type="primary" @click="addCooperationSituation">新增合作情况</el-button>
                    </el-form-item>
                </div> -->

                <div v-show="form.type == 1" style="margin-bottom: 30px;">
                    <div class="section-header">销售漏斗</div>

                    <el-select v-model="form.salesFunnel" placeholder="请选择">
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.key"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>

                <el-form-item label="">
                    <el-button type="success" size="large" @click="add">提交</el-button>
                </el-form-item>
            </el-form>
        </div>

        
    </div>
</template>

<script>
    import vCity from './TestCitySmarty.vue'
    export default {
        components: {
            vCity
        },
        data() {
            return {
                form: {
                    type: 1,                      //1:终端  2:厂家
                    code: '',
                    name: '',                     //客户名称
                    province: '',                 //省
                    city: '',                     //市
                    address: '',                  //地址
                    stage: '',                    //客户阶段
                    explain: '',                  //其他情况说明
                    intermediaryCompany: '',      //中间公司
                    // salesperson: '',              //跟进销售员
                    mainPersonnel: [{}],            //主要人员{'duties':'','name':'','phone':'','remarks':''}
                    salesFunnel: '',              //销售漏斗{'stage':'','remarks':'','time':''}
                    cooperationSituation: [{}],     //合作情况{'historical':'','income'：''}
                    abbreviation: '',             //简称
                    legalRepresentative: '',      //法定代表人
                    registeredCapital: '',        //注册资金
                    lastYearSales: '',            //去年年销售额
                    customerRating: '',           //客户评级
                },
                options: [
                    {
                        key: '初步接触',
                        value: '初步接触'
                    },{
                        key: '有兴趣',
                        value: '有兴趣'
                    },{
                        key: '询问价格',
                        value: '询问价格'
                    },{
                        key: '提交方案',
                        value: '提交方案'
                    },{
                        key: '下订单',
                        value: '下订单'
                    },{
                        key: '成交',
                        value: '成交'
                    },{
                        key: '丢单',
                        value: '丢单'
                    }
                ],
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
                    type: val,                      //1:终端  2:厂家
                    code: '',
                    name: '',                     //客户名称
                    province: '',                 //省
                    city: '',                     //市
                    address: '',                  //地址
                    stage: '',                    //客户阶段
                    explain: '',                  //其他情况说明
                    intermediaryCompany: '',      //中间公司
                    // salesperson: '',              //跟进销售员
                    mainPersonnel: [{}],            //主要人员{'duties':'','name':'','phone':'','remarks':''}
                    salesFunnel: '',              //销售漏斗{'stage':'','remarks':'','time':''}
                    cooperationSituation: [{}],     //合作情况{'historical':'','income'：''}
                    abbreviation: '',             //简称
                    legalRepresentative: '',      //法定代表人
                    registeredCapital: '',        //注册资金
                    lastYearSales: '',            //去年年销售额
                    customerRating: '',           //客户评级
                }
            },
            getData(){
                this.$axios.post('getCustomerById', {
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
            addCooperationSituation(){
                this.form.cooperationSituation.push({})
            },
            add(){
                let self = this;
                this.form.province = this.$refs.vCity.selectProv
                this.form.city = this.$refs.vCity.selectCity
                console.log(this.form)

                if (this.$route.query.id) {
                    this.$axios.post('updateCustomer', self.form, (res) => {
                        if (res.ret == true) {
                            self.$message.success('修改成功');
                        }
                    })
                }else{
                    this.$axios.post('addCustomer', self.form, (res) => {
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