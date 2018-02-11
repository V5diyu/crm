<template>
    <div class="table">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 管理员管理</el-breadcrumb-item>
                </el-breadcrumb>
            </el-row>
        </div>

        <div class="crumbs">
            <el-row>
                <el-col :span="24">
                    <el-button type="primary" style="float:right;" @click="addDialog">新增管理员</el-button>
                </el-col>
            </el-row>
        </div>

        <el-table :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="name" label="管理员名称"></el-table-column>
            <el-table-column prop="account" label="账号"></el-table-column>
            <el-table-column label="身份">
                <template scope="scope">
                    <el-tag type="primary" v-if="scope.row.setUp == 1">管理人员</el-tag>
                    <el-tag type="success" v-if="scope.row.setUp == 2">销售助理</el-tag>
                    <el-tag type="success" v-if="scope.row.setUp == 3">财务</el-tag>
                    <el-tag type="success" v-if="scope.row.setUp == 4">销售人员</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="操作" width="180">
                <template scope="scope">
                    <el-button size="small" type="warning"
                        @click="edit(scope.$index, scope.row)">修改</el-button>
                    <el-button size="small" type="danger"
                        @click="del(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog :title="addDialogTitle" v-model="addDialogVisible">
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
        </el-dialog>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
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
            addDialog(){
                this.addDialogVisible = true;
                this.addDialogTitle = '添加管理员';
                this.form = {
                    name: '',
                    account: '',
                    pwd: '',
                    setUp: 1
                }
            },
            edit(index, row) {
                this.addDialogVisible = true;
                this.addDialogTitle = '修改管理员';
                this.form = row;
            },
            getData(){
                this.loading = true;
                this.$axios.post('getAdmin', {
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

                if (self.form.id) {
                    this.$axios.post('updateAdmin', self.form, (res) => {
                        if (res.ret == true) {
                            self.getData();
                            self.$message.success('修改成功');
                            self.addDialogVisible = false;
                        }
                    })
                }else{
                    this.$axios.post('addAdmin', self.form, (res) => {
                        if (res.ret == true) {
                            self.getData();
                            self.$message.success('添加成功');
                            self.addDialogVisible = false;
                        }
                    })
                }
            },
            del(index, row) {
                let self = this;

                this.$axios.post('delAdmin', {
                    id: row.id,
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