export default{
    url(u){
        let t = this;
        return t.baseURL.trim() + t[u.trim()];
    },
    // baseURL: "http://twelve.ylyedu.com",
    //baseURL: "",
    baseURL: "http://localhost:8009/",

    // 管理员相关
    login: "/admin/admin_user/login",
    logout: "/admin/admin_user/logout",
    updatePwd: "admin/admin_user/updatePwd",

    addAdmin: "/admin/admin_user/create",
    getAdmin: "/admin/admin_user/get",
    updateAdmin: "/admin/admin_user/update",
    delAdmin: "/admin/admin_user/delete",

    // 产品交期表
    uploadProductExcel: "/admin/product_delivery/uploadExcel",
    getProductDelivery: "/admin/product_delivery/get",
    updateProductDelivery: "/admin/product_delivery/update",
    delProductDelivery: "/admin/product_delivery/delete",
    downfileProduct: "/admin/product_delivery/downfile",

    // 纠错
    getOrderErrorList: "/admin/order_info/getErrorList",
    getProductErrorList: "/admin/product_delivery/getErrorList",

    // 订单信息
    uploadOrder: "/admin/order_info/uploadExcel",
    uploadOrderOne: "/admin/order_info/uploadOne",
    uploadOrderTwo: "/admin/order_info/uploadTwo",
    uploadOrderThree: "/admin/order_info/uploadThree",
    getOrderInfo: "/admin/order_info/get",
    updateOrderInfo: "/admin/order_info/update",
    delOrderInfo: "/admin/order_info/delete",
    downfileOrder: "/admin/order_info/downfile",

    // 客户池
    addCustomer: "/admin/customer/create",
    getCustomer: "/admin/customer/get",
    getCustomerById: "/admin/customer/getInfo",
    delCustomer: "/admin/customer/delete",
    updateCustomer: "/admin/customer/update",
    uploadExcelCustomer: "/admin/customer/uploadExcel",
    uploadExcelCustomer2: "/admin/customer/uploadExcelTwo",
    getCustomerApplyList: "/admin/customer/getApplyList",
    operationConfirmCustomer: "/admin/customer/operationConfirm",
    downloadTemplateCustomer: "/admin/customer/downloadTemplate",
    exportCustomer: "/admin/customer/export",

    // 代理商
    addAgent: "/admin/agent/create",
    getAgent: "/admin/agent/get",
    getAgentById: "/admin/agent/getInfo",
    delAgent: "/admin/agent/delete",
    updateAgent: "/admin/agent/update",
    uploadExcelAgent: "/admin/agent/uploadExcel",
    uploadExcelAgent2: "/admin/agent/uploadExcelTwo",
    getAgentApplyList: "/admin/agent/getApplyList",
    operationConfirmAgent: "/admin/agent/operationConfirm",
    downloadTemplateAgent: "/admin/agent/downloadTemplate",
    exportAgent: "/admin/agent/export",

    // 获取客户沟通记录
    getSaleRecordList: "/admin/customer/getRecordList",
    // 修改客户沟通记录
    updateSaleRecordList: "/admin/customer/updateRecord",

    // 获取代理商沟通记录
    getAgentSaleRecordList: "/admin/agent/getRecordList",
    // 修改代理商沟通记录
    updateAgentSaleRecordList: "/admin/agent/updateRecord",


    // 跟进客户
    getRecordCustomer: "/admin/customer/getRecord", // 获取客户跟进记录
    exportRecordCustomer: "/admin/customer/exportRecord", // 导出客户跟进记录

    // 跟进代理商
    getRecordAgent: "/admin/agent/getRecord", // 获取代理商跟进记录 
    exportRecordAgent: "/admin/agent/exportRecord", // 导出代理商跟进记录 

    // 销售员管理
    getSeller: "/admin/salesperson/get",
    delSeller: "/admin/salesperson/delete",
    uploadExcel: "/admin/salesperson/uploadExcel",

    // qiniu
    qiniu: "/api/tools/getToken",

    //自动同步日志
    getSynLog:"/admin/auto_syn_log/get",

    //付款明细(订单页面查看弹窗)
    getPayDetail:"/admin/order_pay_detail/get",
}
