<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/17
 * Time: 上午11:47
 */

namespace app\admin\controller;


class Salesperson extends Base
{
    private $mod;
    private $mod_salespersonStatistics;
    private $mod_companyStatistics;
    private $mod_orderInfoData;
    private $mod_salepersonReceive;

    public function __construct()
    {
        $this->mod                       = new \SalespersonDB();
        $this->mod_salespersonStatistics = new \SalespersonStatisticsDB();
        $this->mod_companyStatistics     = new \CompanyStatisticsDB();
        $this->mod_orderInfoData         = new \OrderInfoDataDB();
        $this->mod_salepersonReceive     = new \SalespersonReceiveDB();
    }


    public function uploadExcel()
    {
        if (empty($_FILES)) {
            return json(error());
        }
        $postfix = substr(strrchr($_FILES['file']['name'], '.'), 0);
        if ($postfix != '.xlsx' && $postfix != '.xls') {
            return json(error('上传文件格式不正确,请上传excel文件'));
        }
        $file_name    = $_FILES['file']['tmp_name'];
        $objReader    = \PHPExcel_IOFactory::createReader(\PHPExcel_IOFactory::identify($file_name));
        $obj_PHPExcel = $objReader->load($file_name);  //加载文件内容,编码utf-8
        $excel_array  = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
        array_splice($excel_array, 0, 3);
        $data       = $this->mod->get([], 0, 0, ['_id' => -1], ['userId' => true]);
        $userIdList = array_column(iterator_to_array($data), 'userId');
        $list       = [];
        foreach ($excel_array as $k => $v) {
            if (!in_array($v[0], $userIdList) && isset($v[0]) && !empty($v[0]) && isset($v[3]) && !empty($v[3] && isset($v[6]) && !empty($v[6]))) {
                $item         = [
                    'id'                    => getUuid(),
                    'userId'                => $v[0],             //用户id
                    'department'            => $v[1],             //部门
                    'position'              => $v[2],             //职位
                    'name'                  => $v[3],             //姓名
                    'avatar'                => '',                //头像
                    'jobNumber'             => $v[4],             //工号
                    'isDirector'            => $v[5],             //是否主管
                    'phone'                 => $v[6],             //手机号
                    'mail'                  => $v[7],             //邮箱
                    'extensionNumber'       => $v[8],             //分机号码
                    'officeLocation'        => $v[9],             //办公地点
                    'remarks'               => $v[10],            //备注
                    'entryTime'             => $v[11],            //入职时间
                    'myContractVolume'      => 0,
                    'companyContractVolume' => 0,
                    'myReturnAmount'        => 0,
                    'myReceivables'         => 0,
                    'create'                => time(),            //创建时间
                ];
                $list[]       = $item;
                $userIdList[] = $v[0];
            }
        }
        if (!empty($list)) {
            $this->mod->batchInsert($list);
        }
        return json(ok($list));
    }


    public function get()
    {
        $pn    = input('pn/d', 1);
        $type  = input('type/d', 1);
        $ps    = 15;
        $start = ($pn - 1) * $ps;


        if ($type == 1) {
            $time = date('Y-m');
        }
        else {
            $timestamp = strtotime(date('Y') . '-' . (date('m') - 1));
            $time      = date('Y-m', $timestamp);
        }
        //接口修改时间
        $time_y                       = date('Y');
        $where                        = ['time' => $time];
        /*$time_y  =  '2017';
        $where   =  ['time' => '2017-12'];
        $time    =  '2017-12';*/
        $rankingList                  = [];
        //销售当月的排名，按照签约额排名
        $data_ranking_userStatistics  = $this->mod_salespersonStatistics->get($where, $start, $ps, ['myContractVolume' => -1]);
        //销售总数
        $count_ranking_userStatistics = $this->mod_salespersonStatistics->count($where);
        //公司订单月数据
        $companyStatistics            = $this->mod_companyStatistics->getInfo(['time' => $time]);
        $i                            = $start;


        //此处为调试

        foreach ($data_ranking_userStatistics as $item) {
            $i++;

            //销售个人月回款数据
            $userReceive_m       = $this->mod_salepersonReceive->get([
                'name'   => $item['name'],
                'time'   => $time
            ]);

            //销售个人当年回款数据
            $userReceive_y       = $this->mod_salepersonReceive->get([
                'name'   => $item['name'],
                'time_y' => $time_y
            ]);

            //销售个人当年的订单数据
            $userStatistics_y    = $this->mod_salespersonStatistics->get([
                'name'   => $item['name'],
                'time_y' => $time_y
            ]);
            //销售个人全部的订单数据
            $userStatistics_data = $this->mod_salespersonStatistics->get(['name' => $item['name']]);
            $rankingList[]       = [
                'name'                  => $item['name'],
                'ranking'               => $i,
                'myContractVolume'      => $item['myContractVolume'],
                'companyContractVolume' => isset($companyStatistics['companyContractVolume']) ? $companyStatistics['companyContractVolume'] : '',
                //'myReturnAmount'        => array_sum(array_column(iterator_to_array($userStatistics_y), 'myReturnAmount')),
                'myReturnAmount'        => array_sum(array_column(iterator_to_array($userReceive_y),'receive')),
                'myReceivables'         => array_sum(array_column(iterator_to_array($userStatistics_data), 'myReceivables')),
                'myOverdueLoans'        => $this->mod_orderInfoData->getOverdueLoansByName($item['name']),
            ];
        }
        return json(ok(['list' => $rankingList, 'count' => $count_ranking_userStatistics]));
    }

    public function getInfo()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要参数'));
        }
        $info = $this->mod->getInfo($id);
        return json(ok($info));
    }

    public function update()
    {
        $id              = input('id');
        $userId          = input('userId');                     //用户id
        $name            = trim(input('name'));                 //姓名
        $department      = input('department');                 //部门
        $phone           = trim(input('phone'));                //手机号
        $position        = input('position');                   //职位
        $mail            = input('mail');                       //邮箱
        $jobNumber       = input('jobNumber');                  //工号
        $extensionNumber = input('extensionNumber');            //分机号码
        $officeLocation  = input('officeLocation');             //办公地点
        $entryTime       = input('entryTime');                  //入职时间
        $remarks         = input('remarks');                    //备注
        $isDirector      = input('isDirector');                 //是否主管
        if (empty($id) || empty($name) || empty($phone) || empty($department)) {
            return json(error('缺少必要参数'));
        }
        $userInfo = $this->mod->getInfo(['id' => ['$ne' => $id], 'userId' => $userId]);
        if (!empty($userInfo)) {
            return json(error('userId重复'));
        }
        $userInfo = $this->mod->getInfo(['id' => ['$ne' => $id], 'name' => $name]);
        if (!empty($userInfo)) {
            return json(error('用户信息重复'));
        }
        $setData = [
            'userId'          => $userId,           //用户id
            'name'            => $name,             //姓名
            'department'      => $department,       //部门
            'phone'           => $phone,            //手机号
            'position'        => $position,         //职位
            'mail'            => $mail,             //邮箱
            'jobNumber'       => $jobNumber,        //工号
            'extensionNumber' => $extensionNumber,  //分机号码
            'officeLocation'  => $officeLocation,   //办公地点
            'entryTime'       => $entryTime,        //入职时间
            'remarks'         => $remarks,          //备注
            'isDirector'      => $isDirector,       //是否主管
        ];
        $this->mod->update($setData, $id);
        return json(ok());
    }

    public function delete()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要参数'));
        }
        $this->mod->delete($id);
        return json(ok());
    }
}