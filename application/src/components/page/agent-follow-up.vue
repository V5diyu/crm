<template>
    <div class="table customer">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 代理商管理</el-breadcrumb-item>
                    <el-breadcrumb-item>已跟进代理商</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <el-row>
                <el-col :span="24">
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

                        <el-button type="success" style="float:right;" @click="downloadTemplate">导出沟通记录</el-button>
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
            <el-table-column prop="belongUserName" label="跟进销售人员"></el-table-column>
            <el-table-column label="销售沟通记录">
                <template scope="scope">
                    <el-button size="small" type="info" @click="look(scope.$index, scope.row)">查看</el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-table v-show="type == 2" :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="name" label="代理商名称"></el-table-column>
            <el-table-column prop="code" label="代理商编码"></el-table-column>
            <el-table-column prop="explain" label="其他情况说明"></el-table-column>
            <el-table-column prop="belongUserName" label="跟进销售人员"></el-table-column>
            <el-table-column label="销售沟通记录">
                <template scope="scope">
                    <el-button size="small" type="info" @click="look(scope.$index, scope.row)">查看</el-button>
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

        <el-dialog title="沟通记录" size="large" :visible.sync="dialogTableVisible">
            <el-table :data="recordListData" border>
                <el-table-column property="userName" label="销售人员"></el-table-column>
                <el-table-column property="customerName" label="沟通对象"></el-table-column>
                <el-table-column property="title" label="标题" width="150"></el-table-column>
                <el-table-column property="time" label="时间" width="200"></el-table-column>
                <el-table-column property="remark" label="内容"></el-table-column>
            </el-table>

            <div class="pagination">
                <el-pagination
                    @current-change ="handleCurChange"
                    layout="prev, pager, next"
                    :total="recordCount"
                    :page-size="pageSize">
                </el-pagination>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import service from '../../assets/service.js'

    export default {
        data() {
            return {
                dialogTableVisible: false,
                recordListData: [],
                recordCount: 0,
                recordPn: 1,

                tableData: [],
                loading: true,
                keyword: '',
                type: 1,
                cur_page: 1,
                count: 0,
                pageSize: 15,
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
                location.href = service.url('exportRecordAgent');
            },
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            handleCurChange(){
                this.recordPn = val;
                this.look();
            },
            getData(){
                this.loading = true;
                this.$axios.post('getAgent', {
                    type: this.type,
                    pn: this.cur_page,
                    name: this.keyword,
                    model: 3 // 1:代理商池获取  2：两周未联系的代理商  3:已跟进
                }, (res) => {
                    if (res.ret == true) {
                        this.tableData = res.data.list;
                        this.count = res.data.count;
                        this.loading = false
                    }
                })
            },
            look(index, row){
                this.$axios.post('getRecordAgent', {
                    pn: this.recordPn,
                    id: row.id
                }, (res) => {
                    if (res.ret == true) {
                        this.dialogTableVisible = true;
                        this.recordListData = res.data.list;
                        this.recordCount = res.data.count;
                        console.log(res.data)
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