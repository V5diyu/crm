<template>
    <div class="table customer">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 客户管理</el-breadcrumb-item>
                    <el-breadcrumb-item>已跟进客户</el-breadcrumb-item>
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
                                placeholder="请输入客户名称搜索"
                                icon="search"
                                v-model="keyword"
                                @keyup.enter.native="getData"
                                :on-icon-click="getData">
                            </el-input>
                        </el-form-item>

                        <el-radio-group v-model="type">
                            <el-radio-button label="1">终端</el-radio-button>
                            <el-radio-button label="2">厂家</el-radio-button>
                        </el-radio-group>

                        <el-button type="success" style="float:right;" @click="downloadTemplate">导出沟通记录</el-button>
                    </el-form>
                </el-col>
            </el-row>
        </div>

        <el-table v-show="type == 1" :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="name" label="客户名称"></el-table-column>
            <el-table-column
                prop="type"
                label="类型"
                width="80">
                <template scope="scope">
                    <el-tag
                        :type="scope.row.type == 1 ? 'primary' : 'success'"
                        close-transition>{{scope.row.type == 1 ? '终端' : '厂家'}}</el-tag>
                </template>
            </el-table-column>
            <el-table-column prop="address" label="地址"></el-table-column>
            <el-table-column prop="intermediaryCompany" label="中间公司"></el-table-column>
            <el-table-column prop="stage" label="客户阶段"></el-table-column>
            <el-table-column prop="explain" label="其他情况说明"></el-table-column>
            <el-table-column prop="belongUserName" label="跟进销售人员"></el-table-column>
            <el-table-column label="销售沟通记录">
                <template scope="scope">
                    <el-button size="small" type="info" @click="look(scope.$index, scope.row)">查看</el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-table v-show="type == 2" :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="name" label="客户名称"></el-table-column>
            <el-table-column
                prop="type"
                label="客户类型">
                <template scope="scope">
                    <el-tag
                        :type="scope.row.type == 1 ? 'primary' : 'success'"
                        close-transition>{{scope.row.type == 1 ? '终端' : '厂家'}}</el-tag>
                </template>
            </el-table-column>
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
                <el-table-column property="title" label="是否可见">
                    <template scope="scope">
                        <el-tag
                            :type="scope.row.type == 1 ? 'primary' : 'success'"
                            close-transition>{{scope.row.status == 1 ? '自己可见' : '所有人可见'}}</el-tag>
                    </template>
                </el-table-column>
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

                addDialogVisible: false,
                tableData: [],
                loading: true,
                keyword: '',
                type: 1,
                cur_page: 1,
                count: 0,
                pageSize: 15,
                applyList: [],
                curApplyData: {},
                curApplyIndex: 0,
                selection: []
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
                location.href = service.url('exportRecordCustomer');
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
                this.$axios.post('getCustomer', {
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
                this.$axios.post('getRecordCustomer', {
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