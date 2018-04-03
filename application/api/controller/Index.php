<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/19
 * Time: 下午4:59
 */

namespace app\api\controller;


class Index extends Base
{
    private $mod;
    private $mod_salespersonStatistics;
    private $mod_companyStatistics;
    private $mod_orderInfoData;
    private $mod_remind;
    private $mod_salespersonReceive;


    public function __construct()
    {
        $this->mod                       = new \SalespersonDB();
        $this->mod_salespersonStatistics = new \SalespersonStatisticsDB();
        $this->mod_companyStatistics     = new \CompanyStatisticsDB();
        $this->mod_orderInfoData         = new \OrderInfoDataDB();
        $this->mod_remind                = new \RemindDB();
        $this->mod_salespersonReceive    = new \SalespersonReceiveDB();
    }

    public function index()
    {
        $userId   = input('userId');
        $isCharge = input('isCharge/d', 1);  //1:不是 2：是
        if (empty($userId)) {
            return json(error('缺少必要的参数'));
        }
        $userInfo          = $this->mod->getInfo(['userId' => $userId]);
        $userName          = $userInfo['name'];
        $time              = date('Y-m');
        $time_y            = date('Y');
        $companyStatistics = $this->mod_companyStatistics->getInfo(['time' => $time]);              //公司当月的订单数据


        if ($isCharge == 2) {
            $userStatistics_y    = $this->mod_salespersonStatistics->get(['time_y' => $time_y]);    //公司当年的订单数据
            $userStatistics_data = $this->mod_salespersonStatistics->get([]);                       //公司全部的订单数据
            $userReceive_y       = $this->mod_salespersonReceive->get(['time_y'=> $time_y]);        //公司当年的回款数据
            $userReceive_m       = $this->mod_salespersonReceive->get(['time' => $time]);           //公司当月的回款数据

            $ranking               = 0;
            $myContractVolume      = 0;
            $companyContractVolume = isset($companyStatistics['companyContractVolume']) ? $companyStatistics['companyContractVolume'] : '';                                             //公司当月的订单->签约额

            //===公司当年签约额
            $myContractVolumeYear = array_sum(array_column(iterator_to_array($userStatistics_y), 'myContractVolume'));
            //===

            //===公司当月回款额
            $myReceiveMonth   = array_sum(array_column(iterator_to_array($userReceive_m),'receive'));
            //===

            //===公司当年回款额
            $myReceiveYear    = array_sum(array_column(iterator_to_array($userReceive_y),'receive'));
            //===

            $myReturnAmount        = array_sum(array_column(iterator_to_array($userStatistics_y), 'myReturnAmount'));
                                                                                                    //公司当年的订单->回款额

            $myReceivables         = array_sum(array_column(iterator_to_array($userStatistics_data), 'myReceivables'));
            $myOverdueLoans        = $this->mod_orderInfoData->getOverdueLoansByName('');
        }
        else {
            //销售个人当月的订单数据
            $userStatistics = $this->mod_salespersonStatistics->getInfo(['name' => $userName, 'time' => $time]);

            if (empty($userStatistics)) {
                $ranking               = '';
                $myContractVolume      = 0;
                $companyContractVolume = 0;
                $myReturnAmount        = 0;
                $myReceivables         = 0;
                $myOverdueLoans        = 0;
                $myContractVolumeYear  = 0;
                $myReceiveMonth        = 0;
                $myReceiveYear         = 0;
            } else {
                //销售个人当年的订单数据
                $userStatistics_y      = $this->mod_salespersonStatistics->get([
                    'name'   => $userName,
                    'time_y' => $time_y
                ]);
                //===销售个人当月的回款数据
                $userReceive_m     = $this->mod_salespersonReceive->get([
                    'name'   => $userName,
                    'time'   => $time
                ]);
                //===

                //===销售个人当年的回款数据
                $userReceive_y       = $this->mod_salespersonReceive->get([
                    'name'   => $userName,
                    'time_y' => $time_y
                ]);
                //===


                //销售的全部数据
                $userStatistics_data   = $this->mod_salespersonStatistics->get(['name' => $userName]);

                $ranking               = $this->mod_salespersonStatistics->count([
                        'myContractVolume' => ['$gt' => $userStatistics['myContractVolume']],
                        'time'             => $time
                    ]) + 1;

                //销售月签约额
                $myContractVolume      = $userStatistics['myContractVolume'];
                //公司当月的签约额
                $companyContractVolume = isset($companyStatistics['companyContractVolume']) ? $companyStatistics['companyContractVolume'] : '';

                //===销售当年签约额
                $myContractVolumeYear  =  array_sum(array_column(iterator_to_array($userStatistics_y),'myContractVolume'));
                //===

                //===销售当月回款额
                $myReceiveMonth        = array_sum(array_column(iterator_to_array($userReceive_m), 'receive'));
                //===

                //销售当年回款额
                $myReceiveYear         = array_sum(array_column(iterator_to_array($userReceive_y), 'receive'));
                //===

                $myReturnAmount        = array_sum(array_column(iterator_to_array($userStatistics_y), 'myReturnAmount'));
                $myReceivables         = array_sum(array_column(iterator_to_array($userStatistics_data), 'myReceivables'));
                $myOverdueLoans        = $this->mod_orderInfoData->getOverdueLoansByName($userName);
            }
        }

        $remind_count = $this->mod_remind->count([
            'userId' => $userId,
            'status' => 0,
            'time'   => ['$lt' => time()]
        ]);
        $remind_info  = $this->mod_remind->get([
            'userId' => $userId,
            'status' => 0,
            'time'   => ['$lt' => time()]
        ], 0, 1, ['time' => -1]);
        $remind_info  = iterator_to_array($remind_info);

        $rankingList                 = [];
        $data_ranking_userStatistics = $this->mod_salespersonStatistics->get(['time' => $time], 0, 3, ['myContractVolume' => -1]);
        $userNames                   = array_column(iterator_to_array($data_ranking_userStatistics), 'name');
        $data_user                   = $this->mod->get(['name' => ['$in' => $userNames]]);
        $list_user                   = [];
        foreach ($data_user as $item) {
            $list_user[$item['name']] = $item;
        }
        foreach ($data_ranking_userStatistics as $item) {
            $rankingList[] = [
                'userId'           => isset($list_user[$item['name']]['userId']) ? $list_user[$item['name']]['userId'] : '',
                'name'             => $item['name'],
                'avatar'           => isset($list_user[$item['name']]['avatar']) ? $list_user[$item['name']]['avatar'] : '',
                'myContractVolume' => $item['myContractVolume']
            ];
        }
        $result = [
            'ranking'               => $ranking,
            'myContractVolume'      => $myContractVolume,
            'companyContractVolume' => $companyContractVolume,
            'myContractYear'        => $myContractVolumeYear,           //公司当年签约额
            'myReceiveMonth'        => $myReceiveMonth,                 //月回款额
            'myReceiveYear'         => $myReceiveYear,                  //年回款额
            'myReturnAmount'        => $myReturnAmount,                 //回款额原计算方式
            'myReceivables'         => $myReceivables,
            'myOverdueLoans'        => $myOverdueLoans,
            'remind'                => [
                'count'   => $remind_count,
                'content' => isset($remind_info[0]['content']) ? $remind_info[0]['content'] : ''
            ],
            'rankingList'           => $rankingList,
        ];
        return json(ok($result));
    }

    public function get()
    {
        $pn    = input('pn/d', 1);
        $type  = input('type/d', 1);
        $mold  = input('mold/d', 1);
        $ps    = 15;
        $start = ($pn - 1) * $ps;
        if ($mold == 1) {
            $start = 0;
            $ps    = 3;
        }
        if ($type == 1) {
            $time = date('Y-m');
        }
        else {
            $timestamp = strtotime(date('Y') . '-' . (date('m') - 1));
            $time      = date('Y-m', $timestamp);
        }
        $where                       = ['time' => $time];
        $rankingList                 = [];
        $data_ranking_userStatistics = $this->mod_salespersonStatistics->get($where, $start, $ps, ['myContractVolume' => -1]);
        $userNames                   = array_column(iterator_to_array($data_ranking_userStatistics), 'name');
        $data_user                   = $this->mod->get(['name' => ['$in' => $userNames]]);
        $list_user                   = [];
        foreach ($data_user as $item) {
            $list_user[$item['name']] = $item;
        }
        foreach ($data_ranking_userStatistics as $item) {
            $rankingList[] = [
                'userId'           => isset($list_user[$item['name']]['userId']) ? $list_user[$item['name']]['userId'] : '',
                'name'             => $item['name'],
                'avatar'           => isset($list_user[$item['name']]['avatar']) ? $list_user[$item['name']]['avatar'] : '',
                'myContractVolume' => $item['myContractVolume']
            ];
        }
        return json(ok($rankingList));
    }


    public function getStatistics()
    {
        $userId   = input('userId');
        $type     = input('type/d', 1);
        $isCharge = input('isCharge/d', 1);  //1:不是 2：是
        if (empty($userId)) {
            return json(error('缺少必要的参数'));
        }
        $userInfo = $this->mod->getInfo(['userId' => $userId]);
        $userName = $userInfo['name'];
        if ($type == 1) {
            $time = date('Y-m');
        }
        else {
            $timestamp = strtotime(date('Y') . '-' . (date('m') - 1));
            $time      = date('Y-m', $timestamp);
        }
        $time_y            = date('Y');

        $companyStatistics = $this->mod_companyStatistics->getInfo(['time' => $time]);              //公司当月订单数据

        if ($isCharge == 2) {

            $userStatistics_y    = $this->mod_salespersonStatistics->get(['time_y' => $time_y]);    //公司当年的订单数据
            $userStatistics_data = $this->mod_salespersonStatistics->get([]);                       //公司全部的订单数据
            $userReceive_y       = $this->mod_salespersonReceive->get(['time_y'=> $time_y]);        //公司当年的回款数据
            $userReceive_m       = $this->mod_salespersonReceive->get(['time' => $time]);           //公司当月的回款数据

            $ranking               = 0;
            $myContractVolume      = 0;
            //公司当月签约额
            $companyContractVolume = isset($companyStatistics['companyContractVolume']) ? $companyStatistics['companyContractVolume'] : '';

            //===公司当年签约额
            $myContractVolumeYear = array_sum(array_column(iterator_to_array($userStatistics_y), 'myContractVolume'));
            //===

            //===公司当月回款额
            $myReceiveMonth   = array_sum(array_column(iterator_to_array($userReceive_m),'receive'));
            //===

            //===公司当年回款额
            $myReceiveYear    = array_sum(array_column(iterator_to_array($userReceive_y),'receive'));
            //===

            $myReturnAmount        = array_sum(array_column(iterator_to_array($userStatistics_y), 'myReturnAmount'));
            $myReceivables         = array_sum(array_column(iterator_to_array($userStatistics_data), 'myReceivables'));
            $myOverdueLoans        = $this->mod_orderInfoData->getOverdueLoansByName('');
        }
        else {
            $userStatistics = $this->mod_salespersonStatistics->getInfo(['name' => $userName, 'time' => $time]);    //销售当月的订单数据
            if (empty($userStatistics)) {
                $ranking               = '';
                $myContractVolume      = 0;
                $companyContractVolume = 0;
                $myReturnAmount        = 0;
                $myReceivables         = 0;
                $myOverdueLoans        = 0;
                $myContractVolumeYear  = 0;
                $myReceiveMonth        = 0;
                $myReceiveYear         = 0;
            }
            else {
                //销售当年订单数据
                $userStatistics_y      = $this->mod_salespersonStatistics->get([
                    'name'   => $userName,
                    'time_y' => $time_y
                ]);

                //===销售个人当月的回款数据
                $userReceive_m     = $this->mod_salespersonReceive->get([
                    'name'   => $userName,
                    'time'   => $time
                ]);
                //===

                //===销售个人当年的回款数据
                $userReceive_y       = $this->mod_salespersonReceive->get([
                    'name'   => $userName,
                    'time_y' => $time_y
                ]);
                //===

                //销售全部的订单数据
                $userStatistics_data   = $this->mod_salespersonStatistics->get(['name' => $userName]);

                $ranking               = $this->mod_salespersonStatistics->count([
                        'myContractVolume' => ['$gt' => $userStatistics['myContractVolume']],
                        'time'             => $time
                    ]) + 1;
                //销售当月签约额
                $myContractVolume      = $userStatistics['myContractVolume'];
                //公司当月签约额
                $companyContractVolume = isset($companyStatistics['companyContractVolume']) ? $companyStatistics['companyContractVolume'] : '';

                //===销售当年签约额
                $myContractVolumeYear  =  array_sum(array_column(iterator_to_array($userStatistics_y),'myContractVolume'));
                //===

                //===销售当月回款额
                $myReceiveMonth        = array_sum(array_column(iterator_to_array($userReceive_m), 'receive'));
                //===

                //销售当年回款额
                $myReceiveYear         = array_sum(array_column(iterator_to_array($userReceive_y), 'receive'));
                //===

                $myReturnAmount        = array_sum(array_column(iterator_to_array($userStatistics_y), 'myReturnAmount'));
                $myReceivables         = array_sum(array_column(iterator_to_array($userStatistics_data), 'myReceivables'));
                $myOverdueLoans        = $this->mod_orderInfoData->getOverdueLoansByName($userName);
            }
        }

        $result = [
            'ranking'               => $ranking,
            'myContractVolume'      => $myContractVolume,
            'companyContractVolume' => $companyContractVolume,
            'myContractYear'        => $myContractVolumeYear,           //公司当年签约额
            'myReceiveMonth'        => $myReceiveMonth,                 //月回款额
            'myReceiveYear'         => $myReceiveYear,                  //年回款额
            'myReturnAmount'        => $myReturnAmount,
            'myReceivables'         => $myReceivables,
            'myOverdueLoans'        => $myOverdueLoans,

        ];
        return json(ok($result));
    }


    public function statisticsCheck ()
    {
        $time   = date('Y-m');
        $time_y = date('Y');
        $userStatistics_data = $this->mod_salespersonStatistics->get([]);
        $myReceivables = array_sum(array_column(iterator_to_array($userStatistics_data), 'myReceivables'));
        dump($myReceivables);
    }
}