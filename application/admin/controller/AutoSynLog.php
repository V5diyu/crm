<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/2/8
 * Time: 18:06
 */
namespace app\admin\controller;

class AutoSynLog extends Base
{
    private $mod_autoSynLog;

    public function __construct()
    {
        $this->mod_autoSynLog = new \AutosynLogDb();
    }

    public function get ()
    {
        $search    = input('search');
        $startTime = input('startTime');
        $endTime   = input('endTime');
        $pn    = input('pn', 1);
        $ps    = 15;
        $start = ($pn - 1) * $ps;
        $where = [];
        $sort = ['syn_timestamp'=> -1];
        if (!empty($search)) {
            /*$where['$eq'] = ['flag' => ['$regex' => $search, '$options' => 'i']];*/
            $where['flag'] = $search;
        }

        if (!empty($startTime) || !empty($endTime)) {
            $timeWhere = [];
            if (!empty($startTime)) {
                $timeWhere['$gte'] = $startTime / 1000;
            }
            if (!empty($endTime)) {
                $timeWhere['$lt'] = $endTime / 1000;
            }
            $where['syn_timestamp'] = $timeWhere;
        }
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 4) {
            $where['sale_man'] = $accountInfo['name'];
        }
        $data = $this->mod_autoSynLog->get($where, $start, $ps, $sort);
        $count = $this->mod_autoSynLog->count($where);

        $list = [];
        foreach ($data as $key => $item) {
            $item['syn_time'] = date('Y-m-d H:i:s',$item['syn_timestamp']);
            $list[] = $item;
        }
        return json(ok(['list'=>$list,'count'=>$count, 'account'=>$accountInfo]));
    }

    /*public function get ()
    {
        //$search = input('');
        $pn    = input('pn', 1);
        $ps    = 15;
        $start = ($pn - 1) * $ps;
        $where = [];

        if (!empty($search)) {
            $where[''] = [];
        }

        $data = $this->mod_autoSynLog->get($where, $start, $ps);
        $count = $this->mod_autoSynLog->count($where);

        $list = [];
        foreach ($data as $key => $item) {
            $item['syn_time'] = date('Y-m-d H:i:s',$item['syn_timestamp']);
            $list[] = $item;
        }
        return json(ok(['list'=>$list,'count'=>$count]));
    }*/

    public function getInfo ()
    {

    }
}