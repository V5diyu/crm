<template>
    <div class="table customer">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 两周未联系</el-breadcrumb-item>
                    <el-breadcrumb-item>待联系客户</el-breadcrumb-item>
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
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                this.loading = true;
                this.$axios.post('getCustomer', {
                    type: this.type,
                    pn: this.cur_page,
                    name: this.keyword,
                    model: 2
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
    .customer .crumbs .el-form-item{
        margin-bottom: 0;
    }
    .customer .crumbs .el-upload{
        height: auto;
        width: auto;
        border: none;
    }
</style>