<template>
    <div class="table productTime">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 工作台</el-breadcrumb-item>
                    <el-breadcrumb-item>订单信息</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs" style="overflow: hidden;">

            <el-form :inline="true" style="float: left;">
                <el-form-item>
                    <el-input
                        class="inline"
                        placeholder="请输入客户名称、合同号搜索"
                        icon="search"
                        v-model="keyword"
                        @keyup.enter.native="getData"
                        :on-icon-click="getData">
                    </el-input>
                </el-form-item>

                <el-date-picker
                    v-model="startTime"
                    type="date"
                    placeholder="开始日期"
                    @change="getData"
                    :picker-options="pickerOptions0">
                </el-date-picker>

                <el-date-picker
                    v-model="endTime"
                    type="date"
                    placeholder="结束日期"
                    @change="getData"
                    :picker-options="pickerOptions0">
                </el-date-picker>
            </el-form>

            <el-upload
                v-show="setUp != 4"
                style="float: right;margin-right: 20px;"
                :on-success="uploadExcelSuccess"
                :show-file-list="false"
                :action="uploadExcelLinkThree">
                <el-button type="primary">导入收款明细</el-button>
            </el-upload>

            <el-upload
                v-show="setUp != 4"
                style="float: right;margin-right: 20px;"
                :on-success="uploadExcelSuccess"
                :show-file-list="false"
                :action="uploadExcelLinkTwo">
                <el-button type="primary">导入发货统计</el-button>
            </el-upload>

            <el-upload
                v-show="setUp != 4"
                style="float: right;margin-right: 20px;"
                :on-success="uploadExcelSuccess"
                :show-file-list="false"
                :action="uploadExcelLinkOne">
                <el-button type="primary">导入合同</el-button>
            </el-upload>

            <el-upload
                v-show="setUp != 4"
                style="float: right;margin-right: 20px;"
                :on-success="uploadExcelSuccess"
                :show-file-list="false"
                :action="uploadExcelLink">
                <el-button type="primary">全量更新</el-button>
            </el-upload>

            <el-button type="success" style="float:right;margin-right: 20px;" @click="exportExel">导出</el-button>
        </div>

        <el-table :data="tableData" v-loading.body="loading" border style="width: 120%">
            <el-table-column prop="A_hth" label="合同号"></el-table-column>
            <el-table-column prop="B_htqyrq" label="合同签约日期"></el-table-column>
            <!-- <el-table-column prop="C_ssxm" label="所属项目"></el-table-column> -->
            <el-table-column prop="D_khdw" label="客户名称"></el-table-column>
            <el-table-column prop="E_zj" label="总价"></el-table-column>
            <el-table-column prop="F_xsry" label="销售人员"></el-table-column>
            <el-table-column prop="G_fh" label="发货"></el-table-column>
            <el-table-column prop="H_fhbl" label="发货比例"></el-table-column>
            <!-- <el-table-column prop="I_fp" label="发票"></el-table-column> -->
            <el-table-column prop="J_fkje" label="付款金额"></el-table-column>
            <el-table-column prop="" label="付款明细" width="90">
                <template scope="scope">
                    <el-button size="small" type="success"
                        @click="payDetail(scope.$index, scope.row.A_hth)">查看</el-button>
                </template>
            </el-table-column>
            <el-table-column prop="K_fkbl" label="付款比例"></el-table-column>
            <!-- <el-table-column prop="L_fkxq" label="付款详情"></el-table-column> -->
            <el-table-column prop="M_qkje" label="欠款金额"></el-table-column>
            <el-table-column prop="N_wkdqr" label="尾款到期日"></el-table-column>
            <!-- <el-table-column prop="O_sfcq" label="是否超期"></el-table-column> -->
            <!-- <el-table-column prop="P_cwhxclyj" label="财务后续处理意见"></el-table-column> -->
            <!-- <el-table-column prop="Q_xsclfk" label="销售处理反馈"></el-table-column> -->
            <!-- <el-table-column label="纠错数">
                <template scope="scope">
                    <el-tag type="success" style="margin-right: 10px;">{{scope.row.errorNum}}</el-tag>
                    <el-button size="small" type="info" @click="errorList(scope.$index, scope.row)">查看记录</el-button>
                    <el-tag type="danger" v-if="scope.row.errorStatus > 0">新纠错</el-tag>
                </template>
            </el-table-column> -->
           
            <el-table-column v-if="setUp != 4" label="操作" width="180">
                <template scope="scope">
                    <el-button size="small" type="success"
                        @click="editModal(scope.$index, scope.row)">修改</el-button>
                    <el-button size="small" type="danger"
                        @click="del(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <div class="pagination">
            <el-pagination
                @current-change ="handleCurrentChange"
                layout="prev, pager, next"
                :total="count"
                :page-size="pageSize">
            </el-pagination>
        </div>
        <el-dialog title="付款明细信息" v-model="payDetailVisible">
            <el-table :data="payDetailData"  v-loading.body="loading" border label-width="120px">
                <el-table-column prop="" label="合同号"></el-table-column>
                <el-table-column prop="" label="付款金额"></el-table-column>
                <el-table-column prop="" label="付款时间"></el-table-column>
            </el-table>
        </el-dialog>
        <el-dialog title="修改订单信息" v-model="dialogVisible">
            <el-form ref="form" :model="form" label-width="120px">

                <el-form-item label="合同号">
                    <el-input v-model="form.A_hth" placeholder="请输入合同号"></el-input>
                </el-form-item>
                <el-form-item label="合同签约日期">
                    <el-input v-model="form.B_htqyrq" placeholder="请输入合同签约日期"></el-input>
                </el-form-item>
                <el-form-item label="所属项目">
                    <el-input v-model="form.C_ssxm" placeholder="请输入所属项目"></el-input>
                </el-form-item>
                <el-form-item label="客户单位">
                    <el-input v-model="form.D_khdw" placeholder="请输入客户单位"></el-input>
                </el-form-item>
                <el-form-item label="总价">
                    <el-input v-model="form.E_zj" placeholder="请输入总价"></el-input>
                </el-form-item>
                <el-form-item label="销售人员">
                    <el-input v-model="form.F_xsry" placeholder="请输入销售人员"></el-input>
                </el-form-item>
                <el-form-item label="发货">
                    <el-input v-model="form.G_fh" placeholder="请输入发货"></el-input>
                </el-form-item>
                <el-form-item label="发货比例">
                    <el-input v-model="form.H_fhbl" placeholder="请输入发货比例"></el-input>
                </el-form-item>
                <el-form-item label="发票">
                    <el-input v-model="form.I_fp" placeholder="请输入发票"></el-input>
                </el-form-item>
                <el-form-item label="付款金额">
                    <el-input v-model="form.J_fkje" placeholder="请输入付款金额"></el-input>
                </el-form-item>
                <el-form-item label="付款比例">
                    <el-input v-model="form.K_fkbl" placeholder="请输入付款比例"></el-input>
                </el-form-item>
                <el-form-item label="付款详情">
                    <el-input v-model="form.L_fkxq" placeholder="请输入付款详情"></el-input>
                </el-form-item>
                <el-form-item label="欠款金额">
                    <el-input v-model="form.M_qkje" placeholder="请输入欠款金额"></el-input>
                </el-form-item>
                <el-form-item label="尾款到期日">
                    <el-input v-model="form.N_wkdqr" placeholder="请输入尾款到期日"></el-input>
                </el-form-item>
                <el-form-item label="是否超期">
                    <el-input v-model="form.O_sfcq" placeholder="请输入是否超期"></el-input>
                </el-form-item>
                <el-form-item label="财务后续处理意见">
                    <el-input v-model="form.P_cwhxclyj" placeholder="请输入财务后续处理意见"></el-input>
                </el-form-item>
                <el-form-item label="销售处理反馈">
                    <el-input v-model="form.Q_xsclfk" placeholder="请输入销售处理反馈"></el-input>
                </el-form-item>

            </el-form>

            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="edit">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import service from '../../assets/service.js'

    export default {
        data() {
            return {
                startTime: '',
                endTime: '',
                keyword: '',
                tableData: [],
                payDetailData: [],
                loading: true,
                cur_page: 1,
                count: 0,
                pageSize: 15,
                uploadExcelLinkOne: service.url('uploadOrderOne'),
                uploadExcelLinkTwo: service.url('uploadOrderTwo'),
                uploadExcelLinkThree: service.url('uploadOrderThree'),
                uploadExcelLink: service.url('uploadOrder'),
                dialogVisible: false,
                payDetailVisible: false,
                form: {
                    A_hth: '',
                    B_htqyrq: '',
                    C_ssxm: '',
                    D_khdw: '',
                    E_zj: '',
                    F_xsry: '',
                    G_fh: '',
                    H_fhbl: '',
                    I_fp: '',
                    J_fkje: '',
                    K_fkbl: '',
                    L_fkxq: '',
                    M_qkje: '',
                    N_wkdqr: '',
                    O_sfcq: '',
                    P_cwhxclyj: '',
                    Q_xsclfk: '',
                },
                setUp: 0, //1：管理人员 2：销售助理 3:财务 4：销售人员
            }
        },
        created(){
            this.getData();
            let userInfo = localStorage.getItem('userInfo') && JSON.parse(localStorage.getItem('userInfo'));
            this.setUp = userInfo.setUp;
        },
        methods: {
            pickerOptions0: {
                disabledDate(time) {
                    return time.getTime() < Date.now() - 8.64e7;
                }
            },
            errorList(index, row){
                this.$router.push({ path: 'errorList', query: { id: row.id , page: '订单信息'}})
            },
            uploadExcelSuccess(){
                this.$message.success('上传成功')
                this.getData();
            },
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                this.loading = true;

                if (this.startTime.toString().indexOf('T') != -1) {
                    this.startTime = +new Date(this.startTime);
                }

                if (this.endTime.toString().indexOf('T') != -1) {
                    this.endTime = +new Date(this.endTime);
                }

                this.$axios.post('getOrderInfo', {
                    pn: this.cur_page,
                    search: this.keyword,
                    startTime: this.startTime,
                    endTime: this.endTime
                }, (res) => {
                    if (res.ret == true) {
                        this.tableData = res.data.list;
                        this.count = res.data.count;
                        this.loading = false
                    }
                })
            },
            exportExel(index, row) {
                location.href = service.url('downfileOrder') + '?search=' + this.keyword + '&startTime=' + this.startTime + '&endTime=' + this.endTime;
            },
            del(index, row) {
                let self = this;

                this.$axios.post('delOrderInfo', {
                    id: row.id
                }, (res) => {
                    if (res.ret == true) {
                        this.$message.success('删除成功');
                        self.tableData.splice(index, 1);
                    }
                })
            },
            editModal(index, row){
                this.dialogVisible = true;
                this.form = JSON.parse(JSON.stringify(row));
            },
            edit(){
                this.$axios.post('updateOrderInfo', this.form, (res) => {
                    if (res.ret == true) {
                        this.$message.success('修改成功');
                        this.getData();
                        this.dialogVisible = false;
                    }
                })
            },
            payDetail(index,row) {
                //console.log(index);
                //console.log(row);
                this.$axios.post('getPayDetail', row, (res) => {
                    if (res.ret == true) {
                        this.payDetailData = res.data;
                    }
                });
                this.payDetailVisible = true;
                this.payDetailData = [];
            }
        }
    }
</script>

<style>
    .productTime .crumbs .el-upload{
        height: auto;
        width: auto;
        border: none;
    }
</style>