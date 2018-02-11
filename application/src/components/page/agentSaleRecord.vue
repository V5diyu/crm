<template>
    <div class="table">
        <div class="crumbs">
            <el-row>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item><i class="el-icon-menu"></i> 沟通记录</el-breadcrumb-item>
                </el-breadcrumb>
                <el-button type="success" style="float:right;" @click="downloadTemplate">导出沟通记录</el-button>
            </el-row>
        </div>

        <el-table :data="tableData" v-loading.body="loading" border style="width: 100%">
            <el-table-column prop="title" label="标题">
                <template slot-scope="scope">
                    <el-popover trigger="hover" placement="bottom">
                        <p>{{ scope.row.title }}</p>
                        <div slot="reference" class="name-wrapper" style="overflow:hidden;text-overflow: ellipsis;">
                            {{ scope.row.title }}
                        </div>
                    </el-popover>
                </template>
            </el-table-column>
            <el-table-column prop="cName" label="代理商名称">
                <template slot-scope="scope">
                    <el-popover trigger="hover" placement="bottom">
                        <p>{{ scope.row.cName }}</p>
                        <div slot="reference" class="name-wrapper" style="overflow:hidden;text-overflow: ellipsis;">
                            {{ scope.row.cName }}
                        </div>
                    </el-popover>
                </template>
            </el-table-column>
            <el-table-column prop="userName" label="销售人员"></el-table-column>
            <el-table-column prop="customerName" label="沟通对象"></el-table-column>
            <el-table-column prop="time" label="时间"></el-table-column>
            <el-table-column prop="remark" label="内容">
                <template slot-scope="scope">
                    <el-popover trigger="hover" placement="bottom">
                        <p>{{ scope.row.remark }}</p>
                        <div slot="reference" class="name-wrapper" style="overflow:hidden;text-overflow: ellipsis;">
                            {{ scope.row.remark }}
                        </div>
                    </el-popover>
                </template>
            </el-table-column>
            <!-- <el-table-column label="仅自己可见">
                <template scope="scope">
                    <el-tag type="primary" v-if="scope.row.setUp == 1">是</el-tag>
                    <el-tag type="success" v-if="scope.row.setUp == 2">否</el-tag>
                </template>
            </el-table-column> -->
            <el-table-column label="操作" width="80">
                <template scope="scope">
                    <el-button size="small" type="warning"
                        @click="edit(scope.$index, scope.row)">修改</el-button>
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

        <el-dialog title="修改沟通记录" v-model="addDialogVisible">
            <el-form ref="form" :model="form" label-width="80px">

                <el-form-item label="标题">
                    <el-input v-model="form.title" placeholder="请输入标题"></el-input>
                </el-form-item>

                <el-form-item label="销售人员">
                    <el-input v-model="form.userName" placeholder="请输入销售人员"></el-input>
                </el-form-item>

                <el-form-item label="沟通对象">
                    <el-input v-model="form.customerName" placeholder="请输入沟通对象"></el-input>
                </el-form-item>

                <el-form-item label="时间">
                    <el-date-picker
                        v-model="form.time"
                        type="datetime"
                        placeholder="选择时间">
                    </el-date-picker>
                </el-form-item>

                <el-form-item label="内容">
                    <el-input type="textarea" v-model="form.remark" placeholder="请输入内容"></el-input>
                </el-form-item>

                <!-- <el-form-item label="身份">
                    <el-radio-group v-model="form.setUp">
                        <el-radio-button label="1">管理人员</el-radio-button>
                        <el-radio-button label="2">销售助理</el-radio-button>
                        <el-radio-button label="3">财务</el-radio-button>
                        <el-radio-button label="4">销售人员</el-radio-button>
                    </el-radio-group>
                </el-form-item> -->

            </el-form>

            <span slot="footer" class="dialog-footer">
                <el-button @click="addDialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="add">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import service from '../../assets/service.js'

    export default {
        data() {
            return {
                tableData: [],
                count: 0,
                pageSize: 15,
                addDialogVisible: false,
                loading: true,
                form: {}
            }
        },
        created(){
            this.getData();
        },
        methods: {
            downloadTemplate(){
                location.href = service.url('exportRecordAgent');
            },
            edit(index, row) {
                this.addDialogVisible = true;
                this.form = row;
            },
            handleCurrentChange(pn){
                this.pn = pn;
                this.getData();
            },
            getData(){
                this.loading = true;
                this.$axios.post('getAgentSaleRecordList', {
                    pn: this.pn
                }, (res) => {
                    if (res.ret == true) {
                        this.tableData = res.data.list;
                        this.count = res.data.count;
                        this.loading = false
                    }
                })
            },
            getTime: function (time) {
                var d = new Date(time);
                var year = d.getFullYear();
                var mon = d.getMonth() + 1;
                var day = d.getDate();
                var hour = d.getHours();
                var minu = d.getMinutes();
                return year + '-' + mon + '-' + day + ' ' + hour + ':' + minu;
            },
            add(){
                let self = this;

                self.form.time = self.getTime(self.form.time);

                this.$axios.post('updateAgentSaleRecordList', self.form, (res) => {
                    if (res.ret == true) {
                        self.getData();
                        self.$message.success('修改成功');
                        self.addDialogVisible = false;
                    }
                })
            }
        }
    }
</script>

<style>
   	.el-popover{
        max-width: 80%;
    }
</style>