<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    // 首页
    public function index()
    {
        return view();
    }
    // 客户
    public function customer()
    {
        return view();
    }
    // 客户详情
    public function customerDetail()
    {
        return view('customerDetail');
    }
    // 添加客户
    public function addCustomer()
    {
        return view('addCustomer');
    }
    // 代理商
    public function agent()
    {
        return view();
    }
    // 添加代理商
    public function addAgent()
    {
        return view('addAgent');
    }
    // 客户详情
    public function agentDetail()
    {
        return view('agentDetail');
    }
    // 跟踪方案
    public function programme()
    {
        return view('programme');
    }
    // 添加跟踪方案
    public function addProgramme()
    {
        return view('addProgramme');
    }
    // 沟通记录
    public function communication()
    {
        return view('communication');
    }
    // 添加沟通记录
    public function addCom()
    {
        return view('addCom');
    }
    // 销售漏斗
    public function salesFunnel()
    {
        return view('salesFunnel');
    }
    // 添加销售漏斗
    public function  addSalesFunnel()
    {
        return view('addSalesFunnel');
    }
    // 交期查询
    public function productTime()
    {
        return view('productTime');
    }
    // 交期查询详情
    public function productTimeDetail()
    {
        return view('productTimeDetail');
    }
    // 订单查询
    public function order()
    {
        return view('order');
    }
    // 订单查询详情
    public function orderDetail()
    {
        return view('orderDetail');
    }
    // 消息
    public function message()
    {
        return view('message');
    }
    // 排行榜
    public function ranking()
    {
        return view('ranking');
    }
    // 发票
    public function invoice()
    {
        return view();
    }
    public function invoiceOrder()
    {
        return view('invoiceOrder');
    }
    // 添加发票
    public function addInvoice()
    {
        return view('addInvoice');
    }

    // 管理员查看沟通记录
    public function managerRecord()
    {
        return view('managerRecord');
    }

    // 客户沟通记录
    public function customerRecord()
    {
        return view('customerRecord');
    }

    // 代理商沟通记录
    public function agentRecord()
    {
        return view('agentRecord');
    }
}
