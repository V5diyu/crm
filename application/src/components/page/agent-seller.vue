<template>
    <div class="table customer">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 代理商</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <el-row>
                <el-col :span="24">
                    <el-button v-show="type == 1" type="success" style="float:right;" @click="downloadTemplate">导出代理商</el-button>

                    <el-button v-show="type == 2" type="success" style="float:right;" @click="downloadTemplate">导出代理人</el-button>

                    <el-button type="success" style="float:right;margin-right: 20px;" @click="downloadRecord">导出沟通记录</el-button>
                    
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
        </el-table>

        <el-table v-show="type == 2" :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="name" label="代理商名称"></el-table-column>
            <el-table-column prop="code" label="代理商编码"></el-table-column>
            <el-table-column prop="explain" label="其他情况说明"></el-table-column>
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
                tableData: [],
                loading: true,
                keyword: '',
                type: 1,
                cur_page: 1,
                count: 0,
                pageSize: 15,
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
            downloadRecord(){
                location.href = service.url('exportRecordAgent');
            },
            downloadTemplate(){
                location.href = service.url('exportAgent') + '?type=' + this.type;
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