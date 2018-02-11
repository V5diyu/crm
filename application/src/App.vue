<template>
    <div id="app">
        <router-view></router-view>
    </div>
</template>
<style>
    @import "../static/css/main.css";
    @import "../static/css/color-dark.css";     /*深色主题*/
    /*@import "../static/css/theme-green/color-green.css";   !*浅绿色主题*!*/


    /* 上传按钮 */
    .upload-input{
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        width: 178px;
        height: 178px;
    }
    .el-upload {
        position: relative;
        width: 178px;
        height: 178px;
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .el-upload:hover {
        border-color: #20a0ff;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px!important;
        text-align: center;
    }
    .avatar {
        position: absolute;
        top: 0;
        left: 0;
        width: 178px;
        height: 178px;
        display: block;
    }
    .name-wrapper {
        height: 24px;
    }
</style>
<style>
    .search {
        float: right;
    }
    .buttonGroup1 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .buttonGroup1 > div {
        white-space: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
    }
    .buttonGroup1 > div:first-child {
        margin-right: 20px;
        overflow-x: hidden;
    }
    .el-table .cell {
        white-space: nowrap!important;
    }
</style>