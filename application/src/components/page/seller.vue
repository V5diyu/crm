<template>
    <div class="table seller">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 销售员管理</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <!-- <el-upload
                style="float: right;"
                :on-success="uploadExcelSuccess"
                :show-file-list="false"
                :action="uploadExcelLink">
                <el-button type="primary">导入</el-button>
            </el-upload> -->

            <!-- <el-form :inline="true">
                <el-form-item>
                    <el-input
                        class="inline"
                        placeholder="请输入姓名搜索"
                        icon="search"
                        v-model="keyword"
                        @keyup.enter.native="getData"
                        :on-icon-click="getData">
                    </el-input>
                </el-form-item>
            </el-form> -->

            <el-radio-group v-model="type">
                <el-radio-button label="1">本月</el-radio-button>
                <el-radio-button label="2">上个月</el-radio-button>
            </el-radio-group>
        </div>

        <el-table :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="name" label="姓名"></el-table-column>
            <el-table-column prop="ranking" label="签约额排名"></el-table-column>
            <el-table-column prop="myContractVolume" label="本人签约额/元"></el-table-column>
            <el-table-column prop="companyContractVolume" label="公司签约额/元"></el-table-column>
            <el-table-column prop="myReturnAmount" label="本人回款额/元"></el-table-column>
            <el-table-column prop="myReceivables" label="本人应收额/元"></el-table-column>
            <el-table-column prop="myOverdueLoans" label="本人超期未回款/元"></el-table-column>
            <el-table-column label="操作">
                <template scope="scope">
                    <!-- <el-button size="small" type="warning"
                        @click="edit(scope.$index, scope.row)">修改</el-button> -->
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
    import service from '../../assets/service.js'

    export default {
        data() {
            return {
                type: 1,
                tableData: [],
                loading: true,
                keyword: '',
                cur_page: 1,
                count: 0,
                pageSize: 15,
                uploadExcelLink: service.url('uploadExcel')
            }
        },
        mounted(){
            this.getData();
        },
        watch: {
            type(val){
                this.tableData = [];
                this.getData();
            }
        },
        methods: {
            uploadExcelSuccess(){
                console.log('upload success')
                this.getData();
            },
            handleCurrentChange(val){
                this.cur_page = val;
                this.getData();
            },
            getData(){
                this.loading = true;
                this.$axios.post('getSeller', {
                    name: this.keyword,
                    pn: this.cur_page,
                    type: this.type
                }, (res) => {
                    if (res.ret == true) {
                        this.tableData = res.data.list;
                        this.count = res.data.count;
                        this.loading = false
                    }
                })
            },
            add(){
                let self = this;

                this.$axios.post('addBanner', self.form, (res) => {
                    if (res.ret == true) {
                        self.getData();
                        self.$message.success('添加成功');
                    }
                })
            },
            del(index, row) {
                let self = this;

                this.$axios.post('delSeller', {
                    id: row.id,
                    fid: self.$route.query.id || 0
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
   	.seller .crumbs .el-form-item{
        margin-bottom: 0;
    }
    .crumbs .el-upload{
        height: auto;
        width: auto;
        border: none;
    }
</style>