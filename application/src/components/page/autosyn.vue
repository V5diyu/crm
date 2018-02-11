<template>
    <div class="table">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 自动同步日志</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <el-row>
                <el-col :span="24">
                    <!--<el-button type="primary" style="float:right;" @click="addDialog">新增管理员</el-button>-->
                </el-col>
            </el-row>
        </div>

        <el-table :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="syn_time" label="同步时间" width="170"></el-table-column>
            <el-table-column prop="syn_cont" label="数据表" width="95"></el-table-column>
            <!--<el-table-column prop="db_name" label="同步数据表"></el-table-column>-->
            <el-table-column prop="syn_field" label="同步内容"></el-table-column>
            <el-table-column prop="flag" label="标记ID" width="150"></el-table-column>
            <el-table-column prop="type" label="类型" width="90">
                <template scope="scope">
                    <el-tag  v-if="scope.row.type == 1">插&nbsp;入</el-tag>
                    <el-tag  v-if="scope.row.type == 2">更&nbsp;新</el-tag>
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

        <!--<el-dialog :title="addDialogTitle" v-model="addDialogVisible">
            <el-form ref="form" :model="form" label-width="80px">

                <el-form-item label="管理员名称">
                    <el-input v-model="form.name" placeholder="请输入管理员名称"></el-input>
                </el-form-item>

                <el-form-item label="账号">
                    <el-input v-model="form.account" placeholder="请输入账号"></el-input>
                </el-form-item>

                <el-form-item label="密码">
                    <el-input v-model="form.pwd" type="password" placeholder="请输入密码"></el-input>
                </el-form-item>

                <el-form-item label="身份">
                    <el-radio-group v-model="form.setUp">
                        <el-radio-button label="1">管理人员</el-radio-button>
                        <el-radio-button label="2">销售助理</el-radio-button>
                        <el-radio-button label="3">财务</el-radio-button>
                        <el-radio-button label="4">销售人员</el-radio-button>
                    </el-radio-group>
                </el-form-item>

            </el-form>

            <span slot="footer" class="dialog-footer">
                <el-button @click="addDialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="add">确 定</el-button>
            </span>
        </el-dialog>-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                cur_page: 1,
                count: 0,
                pageSize: 15,
                qiniuInitState: false,
                addDialogVisible: false,
                addDialogTitle: '添加管理员',
                loading: true,
                form: {
                    name: '',
                    account: '',
                    pwd: '',
                    setUp: 1
                }
            }
        },
        created(){
            this.getData();
        },
        methods: {
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                this.loading = true;
                this.$axios.post('getSynLog', {
                    pn: this.cur_page
                }, (res) => {
                    if (res.ret == true) {
                        this.tableData = res.data.list;
                        this.count = res.data.count;
                        this.loading = false
                    }
                })
            }
        }
    }
</script>

<style>

</style>