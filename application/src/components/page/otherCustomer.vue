<template>
    <div class="table customer">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 客户管理</el-breadcrumb-item>
                    <el-breadcrumb-item>其他客户</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <el-row>
                <el-col :span="24">
                    <el-button type="primary" style="float:right;margin-left: 20px;" @click="add">新增客户</el-button>
                    <el-button type="primary" style="float:right;">导入客户</el-button>
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
                    </el-form>
                </el-col>
            </el-row>
        </div>

        <el-table :data="tableData" v-loading.body="loading" border style="width: 100%">
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
            <el-table-column label="操作">
                <template scope="scope">
                    <el-button size="small" type="warning"
                        @click="edit(scope.$index, scope.row)">修改</el-button>
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                loading: true,
                keyword: '',
                type: 0,
                cur_page: 1,
                count: 0,
                pageSize: 15,
            }
        },
        created(){
            this.getData();
        },
        methods: {
            add(){
                this.$router.push('addCustomer');
            },
            edit(index, row){
                this.$router.push({ path: 'addCustomer', query: { id: row.id }})
            },
            filterTag(value, row){
                console.log(value)
                this.type = value;
                this.getData();
            },
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                this.loading = true;
                this.$axios.post('getCustomer', {
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

                this.$axios.post('delCustomer', {
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
</style>