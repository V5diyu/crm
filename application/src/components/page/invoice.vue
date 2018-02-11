<template>
    <div class="table">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 工作台</el-breadcrumb-item>
                    <el-breadcrumb-item>销项发票</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <el-row>
                <el-col :span="24">
                    <el-button type="primary" style="float:right;">导出</el-button>
                </el-col>
            </el-row>
        </div>

        <el-table :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="name" label="申请人"></el-table-column>
            <el-table-column prop="name" label="客户名称"></el-table-column>
            <el-table-column prop="name" label="申请时间"></el-table-column>
            <el-table-column
		      	prop="tag"
		      	label="发票类型"
		      	:filters="[{ text: '家', value: '家' }, { text: '公司', value: '公司' }]"
		      	:filter-method="filterTag"
		      	filter-placement="bottom-end">
		      	<template scope="scope">
		        	<el-tag
		          		:type="scope.row.tag === '家' ? 'primary' : 'success'"
		          		close-transition>{{scope.row.tag}}</el-tag>
		      	</template>
		    </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                qiniuInitState: false,
                loading: true
            }
        },
        created(){
            this.getData();
        },
        methods: {
        	filterTag(value, row){

        	},
            getData(){
                this.loading = true;
                this.$axios.post('getBanner', {
                    type: this.type
                }, (res) => {
                    if (res.ret == true) {
                        this.tableData = res.data;
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

                this.$axios.post('delBanner', {
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
   	
</style>