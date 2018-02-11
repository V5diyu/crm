<template>
    <div class="table productTime">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 工作台</el-breadcrumb-item>
                    <el-breadcrumb-item>产品交期表</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs" style="overflow: hidden;">
            <el-upload
                v-show="setUp != 4"
                style="float: right;"
                :on-success="uploadExcelSuccess"
                :show-file-list="false"
                :action="uploadExcelLink">
                <el-button type="primary">导入</el-button>
            </el-upload>

            <el-button type="success" style="float:right;margin-right: 20px;" @click="exportExel">导出</el-button>
        </div>

        <el-table :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="A_khmc" label="客户名称"></el-table-column>
            <el-table-column prop="B_ywy" label="业务员"></el-table-column>
            <el-table-column prop="C_gcah" label="工程案号"></el-table-column>
            <el-table-column prop="D_dh" label="单号"></el-table-column>
            <el-table-column prop="E_ph" label="品号"></el-table-column>
            <el-table-column prop="F_pm" label="品名"></el-table-column>
            <el-table-column prop="G_hpgg" label="货品规格"></el-table-column>
            <el-table-column prop="H_dw" label="单位"></el-table-column>
            <el-table-column prop="I_ckrq" label="出库日期"></el-table-column>
            <el-table-column prop="J_sl" label="数量"></el-table-column>
            <el-table-column prop="K_xhsl" label="销货数量"></el-table-column>
            <el-table-column prop="L_wzxhsl" label="未转销货数量"></el-table-column>
            <el-table-column prop="M_shrmc" label="审核人名称"></el-table-column>
            <el-table-column prop="N_yjfhrq" label="预计发货日期"></el-table-column>
            <el-table-column prop="O_bz" label="备注"></el-table-column>
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

        <el-dialog title="修改产品交期表" v-model="dialogVisible">
            <el-form ref="form" :model="form" label-width="100px">
                
                <el-form-item label="客户名称">
                    <el-input v-model="form.A_khmc" placeholder="请输入客户名称"></el-input>
                </el-form-item>
                <el-form-item label="业务员">
                    <el-input v-model="form.B_ywy" placeholder="请输入业务员"></el-input>
                </el-form-item>
                <el-form-item label="工程案号">
                    <el-input v-model="form.C_gcah" placeholder="请输入工程案号"></el-input>
                </el-form-item>
                <el-form-item label="单号">
                    <el-input v-model="form.D_dh" placeholder="请输入单号"></el-input>
                </el-form-item>
                <el-form-item label="品号">
                    <el-input v-model="form.E_ph" placeholder="请输入品号"></el-input>
                </el-form-item>
                <el-form-item label="品名">
                    <el-input v-model="form.F_pm" placeholder="请输入品名"></el-input>
                </el-form-item>
                <el-form-item label="货品规格">
                    <el-input v-model="form.G_hpgg" placeholder="请输入货品规格"></el-input>
                </el-form-item>
                <el-form-item label="单位">
                    <el-input v-model="form.H_dw" placeholder="请输入单位"></el-input>
                </el-form-item>
                <el-form-item label="出库日期">
                    <el-input v-model="form.I_ckrq" placeholder="请输入出库日期"></el-input>
                </el-form-item>
                <el-form-item label="数量">
                    <el-input v-model="form.J_sl" placeholder="请输入数量"></el-input>
                </el-form-item>
                <el-form-item label="销货数量">
                    <el-input v-model="form.K_xhsl" placeholder="请输入销货数量"></el-input>
                </el-form-item>
                <el-form-item label="未转销货数量">
                    <el-input v-model="form.L_wzxhsl" placeholder="请输入未转销货数量"></el-input>
                </el-form-item>
                <el-form-item label="审核人名称">
                    <el-input v-model="form.M_shrmc" placeholder="请输入审核人名称"></el-input>
                </el-form-item>
                <el-form-item label="预计发货日期">
                    <el-input v-model="form.N_yjfhrq" placeholder="请输入预计发货日期"></el-input>
                </el-form-item>
                <el-form-item label="备注">
                    <el-input v-model="form.O_bz" placeholder="请输入备注"></el-input>
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
                tableData: [],
                loading: true,
                cur_page: 1,
                count: 0,
                pageSize: 15,
                uploadExcelLink: service.url('uploadProductExcel'),
                dialogVisible: false,
                form: {
                    A_khmc: '',
                    B_ywy: '',
                    C_gcah: '',
                    D_dh: '',
                    E_ph: '',
                    F_pm: '',
                    G_hpgg: '',
                    H_dw: '',
                    I_ckrq: '',
                    J_sl: '',
                    K_xhsl: '',
                    L_wzxhsl: '',
                    M_shrmc: '',
                    N_yjfhrq: '',
                    O_bz: '',
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
            errorList(index, row){
                this.$router.push({ path: 'errorList', query: { id: row.id, page: '产品交期表' }})
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
                this.$axios.post('getProductDelivery', {
                    pn: this.cur_page
                }, (res) => {
                    if (res.ret == true) {
                        this.tableData = res.data.list;
                        this.count = res.data.count;
                        this.loading = false
                    }
                })
            },
            exportExel(){
                location.href = service.url('downfileProduct');
            },
            del(index, row) {
                let self = this;

                this.$axios.post('delProductDelivery', {
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
                this.$axios.post('updateProductDelivery', this.form, (res) => {
                    if (res.ret == true) {
                        this.$message.success('修改成功');
                        this.getData();
                        this.dialogVisible = false;
                    }
                })
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