<template>
    <div class="table customer">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 代理商管理</el-breadcrumb-item>
                    <el-breadcrumb-item>其他代理商</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <el-row>
                <el-col :span="24">
                    <el-button type="primary" style="float:right;margin-left: 20px;" @click="add">新增代理商</el-button>
                    <el-button type="primary" style="float:right;">导入代理商</el-button>
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
                    </el-form>
                </el-col>
            </el-row>
        </div>

        <el-table :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="name" label="代理商名称"></el-table-column>
            <el-table-column prop="code" label="代理商编码"></el-table-column>
            <el-table-column prop="abbreviation" label="代理商简称"></el-table-column>
            <el-table-column prop="legalRepresentative" label="法定代表人"></el-table-column>
            <el-table-column prop="registeredCapital" label="注册资金/万"></el-table-column>
            <el-table-column prop="lastYearSales" label="去年贡献收入/万"></el-table-column>
            <el-table-column
                prop="proxyLevel"
                label="代理级别">
                <template scope="scope">
                    <el-tag v-if="scope.row.proxyLevel == 1" type="primary" close-transition>级别{{scope.row.proxyLevel}}</el-tag>
                    <el-tag v-if="scope.row.proxyLevel == 2" type="success" close-transition>级别{{scope.row.proxyLevel}}</el-tag>
                    <el-tag v-if="scope.row.proxyLevel == 3" type="info" close-transition>级别{{scope.row.proxyLevel}}</el-tag>
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
                this.$router.push('addAgent');
            },
            edit(index, row){
                this.$router.push({ path: 'addAgent', query: { id: row.id }})
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
</style>