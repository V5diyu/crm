import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            redirect: '/login'
        },
        {
            path: '/readme',
            component: resolve => require(['../components/common/Home.vue'], resolve),
            children:[
                {
                    path: '/productTime',
                    component: resolve => require(['../components/page/productTime.vue'], resolve)
                },
                {
                    path: '/errorList',
                    component: resolve => require(['../components/page/errorList.vue'], resolve)
                },
                {
                    path: '/order',
                    component: resolve => require(['../components/page/order.vue'], resolve)
                },
                {
                    path: '/invoice',
                    component: resolve => require(['../components/page/invoice.vue'], resolve)
                },
                {
                    path: '/customer',
                    component: resolve => require(['../components/page/customer.vue'], resolve)
                },
                {
                    path: '/addCustomer',
                    component: resolve => require(['../components/page/addCustomer.vue'], resolve)
                },
                {
                    path: '/otherCustomer',
                    component: resolve => require(['../components/page/otherCustomer.vue'], resolve)
                },
                {
                    path: '/agent',
                    component: resolve => require(['../components/page/agent.vue'], resolve)
                },
                {
                    path: '/addAgent',
                    component: resolve => require(['../components/page/addAgent.vue'], resolve)
                },
                {
                    path: '/otherAgent',
                    component: resolve => require(['../components/page/otherAgent.vue'], resolve)
                },
                {
                    path: '/product',
                    component: resolve => require(['../components/page/product.vue'], resolve)
                },
                {
                    path: '/seller',
                    component: resolve => require(['../components/page/seller.vue'], resolve)
                },
                {
                    path: '/manager',
                    component: resolve => require(['../components/page/manager.vue'], resolve)
                },
                {
                    path: '/autosyn',
                    component: resolve => require(['../components/page/autosyn.vue'], resolve)
                },
                {
                    path: '/customer-contact',
                    component: resolve => require(['../components/page/customer-contact.vue'], resolve)
                },
                {
                    path: '/agent-contact',
                    component: resolve => require(['../components/page/agent-contact.vue'], resolve)
                },
                {
                    path: '/customer-seller',
                    component: resolve => require(['../components/page/customer-seller.vue'], resolve)
                },
                {
                    path: '/agent-seller',
                    component: resolve => require(['../components/page/agent-seller.vue'], resolve)
                },
                {
                    path: '/customer-follow-up',
                    component: resolve => require(['../components/page/customer-follow-up.vue'], resolve)
                },
                {
                    path: '/agent-follow-up',
                    component: resolve => require(['../components/page/agent-follow-up.vue'], resolve)
                },
                {
                    path: '/customerSaleRecord',
                    component: resolve => require(['../components/page/customerSaleRecord.vue'], resolve)
                },
                {
                    path: '/agentSaleRecord',
                    component: resolve => require(['../components/page/agentSaleRecord.vue'], resolve)
                },
            ]
        },
        {
            path: '/login',
            component: resolve => require(['../components/page/login.vue'], resolve)
        }
    ]
})
