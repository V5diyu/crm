<template>
    <div class="table customer">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 代理商管理</el-breadcrumb-item>
                    <el-breadcrumb-item>代理商池</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <el-row>
                <el-col :span="24">
                    <el-button type="primary" style="float:right;margin-left: 20px;" @click="add">新增代理商</el-button>
                    <el-upload
                        v-show="type == 1"
                        style="float: right;"
                        :on-success="uploadExcelSuccess"
                        :show-file-list="false"
                        :action="uploadExcelLink">
                        <el-button type="primary">导入代理商</el-button>
                    </el-upload>
                    <el-upload
                        v-show="type == 2"
                        style="float: right;"
                        :on-success="uploadExcelSuccess"
                        :show-file-list="false"
                        :action="uploadExcelLink2">
                        <el-button type="primary">导入代理人</el-button>
                    </el-upload>
                    <el-button type="success" style="float:right;margin-right: 20px;" @click="downloadTemplate">下载导入模板</el-button>
                    <el-form :inline="true">
                        <el-form-item>
                            <el-input
                                class="inline"
                                placeholder="请输入代理商名称搜索"
                                icon="search"
                                v-model="keyword"
                                @keyup.enter.native="getData"
                                :on-icon-click="getData">
                            </el-input>
                        </el-form-item>

                        <el-radio-group v-model="type">
                            <el-radio-button label="1">代理商</el-radio-button>
                            <el-radio-button label="2">代理人</el-radio-button>
                        </el-radio-group>
                    </el-form>
                </el-col>
            </el-row>
        </div>

        <el-table v-show="type == 1" :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="name" label="代理商名称"></el-table-column>
            <el-table-column prop="code" label="代理商编码"></el-table-column>
            <el-table-column prop="abbreviation" label="代理商简称"></el-table-column>
            <el-table-column prop="legalRepresentative" label="法定代表人"></el-table-column>
            <el-table-column prop="registeredCapital" label="注册资金/万"></el-table-column>
            <el-table-column prop="lastYearSales" label="去年贡献收入/万"></el-table-column>
            <el-table-column prop="proxyLevel" label="代理级别"></el-table-column>
            <el-table-column prop="explain" label="其他情况说明"></el-table-column>
            <el-table-column label="操作" width="220">
                <template scope="scope">
                    <el-button size="small" type="warning"
                        @click="edit(scope.$index, scope.row)">修改</el-button>
                    <el-button size="small" type="danger"
                        @click="del(scope.$index, scope.row)">删除</el-button>
                    <el-button size="small" type="info" v-if="scope.row.applyNum > 0"
                        @click="audit(scope.$index, scope.row)">跟进审核</el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-table v-show="type == 2" :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="name" label="代理商名称"></el-table-column>
            <el-table-column prop="code" label="代理商编码"></el-table-column>
            <el-table-column prop="explain" label="其他情况说明"></el-table-column>
            <!-- <el-table-column prop="belongUserName" label="跟进销售人员"></el-table-column> -->
            <el-table-column label="操作" width="220">
                <template scope="scope">
                    <el-button size="small" type="warning"
                        @click="edit(scope.$index, scope.row)">修改</el-button>
                    <el-button size="small" type="danger"
                        @click="del(scope.$index, scope.row)">删除</el-button>
                    <el-button size="small" type="info" v-if="scope.row.applyNum > 0"
                        @click="audit(scope.$index, scope.row)">跟进审核</el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog title="跟进审核" v-model="addDialogVisible">
            <el-table :data="applyList" border style="width: 100%" @select-all="handleSelectionAll" @select="handleSelectionChange">
                <el-table-column type="selection" width="55"></el-table-column>
                <el-table-column prop="userName" label="姓名"></el-table-column>
                <el-table-column prop="create" label="申请时间"></el-table-column>
            </el-table>

            <span slot="footer" class="dialog-footer">
                <el-button @click="addDialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="operationConfirm">同意跟进</el-button>
            </span>
        </el-dialog>

        <div class="pagination">
            <el-pagination
                @current-change ="handleCurrentChange"
                layout="prev, pager, next"
                :total="count"
                :page-size="pageSize">
            </el-pagination>
        </div>
    </div>
</template>

<script>
    import service from '../../assets/service.js'

    export default {
        data() {
            return {
                tableData: [],
                loading: true,
                keyword: '',
                type: 1,
                cur_page: 1,
                count: 0,
                pageSize: 15,
                uploadExcelLink: service.url('uploadExcelAgent'),
                uploadExcelLink2: service.url('uploadExcelAgent2'),
                addDialogVisible: false,
                applyList: [],
                curApplyData: {},
                curApplyIndex: 0,
                selection: [],
            }
        },
        watch: {
            type(val){
                this.tableData = [];
                this.getData();
            }
        },
        created(){
            this.getData();
        },
        methods: {
            downloadTemplate(){
                location.href = service.url('downloadTemplateAgent') + '?type=' + this.type;
            },
            handleSelectionAll(selection){
                console.log(selection)
                this.selection = selection;
            },
            handleSelectionChange(selection, row){
                console.log(selection, row)
                this.selection = selection;
            },
            operationConfirm(){
                var applyId = [];
                this.selection.forEach((item)=>{
                    applyId.push(item.id);
                })

                this.$axios.post('operationConfirmAgent', {
                    id: this.curApplyData.id,
                    applyId: applyId
                }, (res) => {
                    if (res.ret == true) {
                        this.$message.success('审核成功');
                        this.curApplyData.applyNum = 0;
                        this.tableData.splice(this.curApplyIndex, 1);
                        this.addDialogVisible = false;
                    }
                })
            },
            audit(index, row){
                this.addDialogVisible = true;
                this.curApplyData = row;
                this.curApplyIndex = index;
                this.$axios.post('getAgentApplyList', {
                    id: row.id
                }, (res) => {
                    if (res.ret == true) {
                        console.log(res.data)
                        this.applyList = res.data;
                    }
                })
            },
            uploadExcelSuccess(){
                this.$message.success('上传成功')
                this.getData();
            },
            add(){
                this.$router.push('addAgent');
            },
            edit(index, row){
                this.$router.push({ path: 'addAgent', query: { id: row.id }})
            },
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                this.loading = true;
                this.$axios.post('getAgent', {
                    type: this.type,
                    pn: this.cur_page,
                    name: this.keyword
                }, (res) => {
                    if (res.ret == true) {
                        this.tableData = res.data.list;
                        this.count = res.data.count;
                        this.loading = false
                    }
                })
            },
            del(index, row) {
                let self = this;

                this.$axios.post('delAgent', {
                    id: row.id
                }, (res) => {
                    if (res.ret == true) {
                        this.$message.success('删除成功');
                        self.tableData.splice(index, 1);
                    }
                })
            }
        }
    }
</script>

<style>
    .customer .crumbs .el-form-item{
        margin-bottom: 0;
    }
    .customer .crumbs .el-upload{
        height: auto;
        width: auto;
        border: none;
    }
</style>