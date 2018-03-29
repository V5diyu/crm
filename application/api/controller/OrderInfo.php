<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/18
 * Time: 下午2:23
 */

namespace app\api\controller;


class OrderInfo extends Base
{
    private $mod_info;
    private $mod_data;
    private $mod_salesperson;
    private $mod_correctError;
    private $mod_product;
    private $mod_payDetail;
    private $mod_billDetail;

    public function __construct()
    {
        $this->mod_info         = new \OrderInfoDB();
        $this->mod_data         = new \OrderInfoDataDB();
        $this->mod_salesperson  = new \SalespersonDB();
        $this->mod_correctError = new \CorrectErrorDB();
        $this->mod_product      = new \ProductDeliveryDataDB();
        $this->mod_payDetail    = new \OrderPayDetailDb();
        $this->mod_billDetail   = new \BillDetailDB();
    }

    public function get()
    {
        $userName = input('userName');
        $isCharge = input('isCharge/d', 1);  //1:不是 2：是
        $D_khdw   = input('D_khdw');
        $pn       = input('pn/d', 1);
        $ps       = 15;
        $start    = ($pn - 1) * $ps;
        if (empty($userName)) {
            return json(error('缺少必要的参数'));
        }
        if ($isCharge == 2) {
            $where = [];
        }
        else {
            $where = ['F_xsry' => $userName];
        }
        if (!empty($D_khdw)) {
            $where['D_khdw'] = ['$regex' => $D_khdw, '$options' => 'i'];
        }
        $data = $this->mod_data->get($where, $start, $ps);
        $list = [];
        foreach ($data as $item) {
            $list[] = [
                'id'     => $item['id'],
                'A_hth'  => $item['A_hth'],
                'C_ssxm' => $item['C_ssxm'],
                'D_khdw' => $item['D_khdw'],
                'E_zj'   => $item['E_zj'],
                'H_fhbl' => $item['H_fhbl'] . '%',
                'J_fkje' => empty($item['J_fkje']) ? 0 : $item['J_fkje'],
                'K_fkbl' => round($item['K_fkbl'], 3) . '%',
                'N_wkdqr'=> empty($item['N_wkdqr']) ? '全部发货未完成' : date('Y-m-d',$item['N_wkdqr'])
            ];
        }
        return json(ok($list));
    }

    public function getInfo()
    {
        $id = input('id');
        if (empty($id) ) {
            return json(error('缺少必要的参数'));
        }
        //订单信息
        $info           = $this->mod_data->getInfo($id);
        $info['G_fh']   = empty($info['G_fh']) ? 0 : $info['G_fh'];
        $info['H_fhbl'] = round($info['H_fhbl'],3) . '%';
        $info['J_fkje'] = empty($info['J_fkje']) ? 0 : $info['J_fkje'];
        $info['K_fkbl'] = round($info['K_fkbl'], 3) . '%';
        //$info['K_fkbl'] = round($info['K_fkbl'] * 100, 2) . '%';

        $contract = $info['A_hth'];
        $productDetail  = [];
        $payDetail      = [];
        $billDetail     = [];
        //交期明细信息
        $product_data   = $this->mod_product->get(['C_gcah' => $contract]);
        foreach ($product_data as $product_item) {

            //$product_item['N_yjfhrq'] = empty($product_item['N_yjfhrq']) ? '' : $product_item['N_yjfhrq'];
            if ( is_numeric($product_item['N_yjfhrq'] )) {
                $product_item['N_yjfhrq'] = date('Y-m-d',$product_item['N_yjfhrq']);
            }
            $productDetail[] = $product_item;
        }
        //付款明细信息
        $pay_data       = $this->mod_payDetail->get(['contract' => $contract]);
        foreach ($pay_data as $pay_item) {
            $pay_item['paydate'] = date('Y年m月d日 H:i:s',strtotime($pay_item['paydate']['date']));
            $payDetail[] = $pay_item;
        }
        //发票明细信息
        $bill_data      = $this->mod_billDetail->get(['D_hth' => $contract]);
        foreach ($bill_data as $bill_item) {

            //时间格式转换
            $bill_item['C_kpsj'] = date("Y-m-d",$bill_item['C_kpsj']);
            $billDetail[] = $bill_item;
         }
        return json(ok(['order'=>$info, 'productDetail'=>$productDetail, 'payDetail'=>$payDetail, 'billDetail'=> $billDetail]));
    }

    public function correctError()
    {
        $id       = input('id');
        $userId   = input('userId');
        $userName = input('userName');
        $content  = input('content');
        if (empty($id) || empty($userId) || empty($userName) || empty($content)) {
            return json(error('缺少必要的参数'));
        }
        $data = $this->mod_info->get([], 0, 1);
        $info = iterator_to_array($data)[0];
        if (empty($info)) {
            return json(error('信息不存在'));
        }
        $insertData = [
            'objId'    => $id,
            'infoId'   => $info['id'],
            'userId'   => $userId,
            'userName' => $userName,
            'content'  => $content,
            'type'     => 2,          //1:交期  2：订单
            'create'   => time(),
        ];
        $this->mod_correctError->add($insertData);
        $this->mod_info->updateInc(['errorNum' => 1, 'errorStatus' => 1], $info['id']);
        return json(ok());
    }

}