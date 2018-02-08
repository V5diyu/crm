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

    public function __construct()
    {
        $this->mod                       = new \SalespersonDB();
        $this->mod_salespersonStatistics = new \SalespersonStatisticsDB();
        $this->mod_companyStatistics     = new \CompanyStatisticsDB();
        $this->mod_orderInfoData         = new \OrderInfoDataDB();
        $this->mod_remind                = new \RemindDB();
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
        $companyStatistics = $this->mod_companyStatistics->getInfo(['time' => $time]);
        if ($isCharge == 2) {
            $userStatistics_y    = $this->mod_salespersonStatistics->get(['time_y' => $time_y]);
            $userStatistics_data = $this->mod_salespersonStatistics->get([]);

            $ranking               = 0;
            $myContractVolume      = 0;
            $companyContractVolume = isset($companyStatistics['companyContractVolume']) ? $companyStatistics['companyContractVolume'] : '';
            $myReturnAmount        = array_sum(array_column(iterator_to_array($userStatistics_y), 'myReturnAmount'));
            $myReceivables         = array_sum(array_column(iterator_to_array($userStatistics_data), 'myReceivables'));
            $myOverdueLoans        = $this->mod_orderInfoData->getOverdueLoansByName('');
        }
        else {
            $userStatistics = $this->mod_salespersonStatistics->getInfo(['name' => $userName, 'time' => $time]);
            if (empty($userStatistics)) {
                $ranking               = '';
                $myContractVolume      = 0;
                $companyContractVolume = 0;
                $myReturnAmount        = 0;
                $myReceivables         = 0;
                $myOverdueLoans        = 0;
            }
            else {
                $userStatistics_y      = $this->mod_salespersonStatistics->get([
                    'name'   => $userName,
                    'time_y' => $time_y
                ]);
                $userStatistics_data   = $this->mod_salespersonStatistics->get(['name' => $userName]);
                $ranking               = $this->mod_salespersonStatistics->count([
                        'myContractVolume' => ['$gt' => $userStatistics['myContractVolume']],
                        'time'             => $time
                    ]) + 1;
                $myContractVolume      = $userStatistics['myContractVolume'];
                $companyContractVolume = isset($companyStatistics['companyContractVolume']) ? $companyStatistics['companyContractVolume'] : '';
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
            'myReturnAmount'        => $myReturnAmount,
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
        $companyStatistics = $this->mod_companyStatistics->getInfo(['time' => $time]);
        if ($isCharge == 2) {
            $userStatistics_y    = $this->mod_salespersonStatistics->get(['time_y' => $time_y]);
            $userStatistics_data = $this->mod_salespersonStatistics->get([]);

            $ranking               = 0;
            $myContractVolume      = 0;
            $companyContractVolume = isset($companyStatistics['companyContractVolume']) ? $companyStatistics['companyContractVolume'] : '';
            $myReturnAmount        = array_sum(array_column(iterator_to_array($userStatistics_y), 'myReturnAmount'));
            $myReceivables         = array_sum(array_column(iterator_to_array($userStatistics_data), 'myReceivables'));
            $myOverdueLoans        = $this->mod_orderInfoData->getOverdueLoansByName('');
        }
        else {
            $userStatistics = $this->mod_salespersonStatistics->getInfo(['name' => $userName, 'time' => $time]);
            if (empty($userStatistics)) {
                $ranking               = '';
                $myContractVolume      = 0;
                $companyContractVolume = 0;
                $myReturnAmount        = 0;
                $myReceivables         = 0;
                $myOverdueLoans        = 0;
            }
            else {
                $userStatistics_y      = $this->mod_salespersonStatistics->get([
                    'name'   => $userName,
                    'time_y' => $time_y
                ]);
                $userStatistics_data   = $this->mod_salespersonStatistics->get(['name' => $userName]);
                $ranking               = $this->mod_salespersonStatistics->count([
                        'myContractVolume' => ['$gt' => $userStatistics['myContractVolume']],
                        'time'             => $time
                    ]) + 1;
                $myContractVolume      = $userStatistics['myContractVolume'];
                $companyContractVolume = isset($companyStatistics['companyContractVolume']) ? $companyStatistics['companyContractVolume'] : '';
                $myReturnAmount        = array_sum(array_column(iterator_to_array($userStatistics_y), 'myReturnAmount'));
                $myReceivables         = array_sum(array_column(iterator_to_array($userStatistics_data), 'myReceivables'));
                $myOverdueLoans        = $this->mod_orderInfoData->getOverdueLoansByName($userName);
            }
        }

        $result = [
            'ranking'               => $ranking,
            'myContractVolume'      => $myContractVolume,
            'companyContractVolume' => $companyContractVolume,
            'myReturnAmount'        => $myReturnAmount,
            'myReceivables'         => $myReceivables,
            'myOverdueLoans'        => $myOverdueLoans,

        ];
        return json(ok($result));
    }
}