<template>
    <div class="table productTime">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 工作台</el-breadcrumb-item>
                    <el-breadcrumb-item>{{$route.query.page}}</el-breadcrumb-item>
                    <el-breadcrumb-item>纠错列表</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <el-table :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="userName" label="纠错人"></el-table-column>
            <el-table-column prop="create" label="时间"></el-table-column>
            <el-table-column prop="content" label="纠错内容"></el-table-column>
        </el-table>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                loading: true,
                cur_page: 1,
                count: 0,
                pageSize: 15,
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

                if (this.$route.query.page == '产品交期表') {
                    this.$axios.post('getProductErrorList', {
                        pn: this.cur_page,
                        id: this.$route.query.id
                    }, (res) => {
                        if (res.ret == true) {
                            this.tableData = res.data;
                            this.loading = false
                        }
                    })
                }else{
                    this.$axios.post('getOrderErrorList', {
                        pn: this.cur_page,
                        id: this.$route.query.id
                    }, (res) => {
                        if (res.ret == true) {
                            this.tableData = res.data;
                            this.loading = false
                        }
                    })
                }

                
            }
        }
    }
</script>

<style>

</style>