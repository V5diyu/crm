<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/17
 * Time: 上午11:47
 */

namespace app\api\controller;


class Customer extends Base
{
    private $mod;
    private $mod_record;
    private $mod_apply;
    private $mod_remind;
    private $mod_programme;
    private $mod_salesperson;

    public function __construct()
    {
        $this->mod             = new \CustomerDB();
        $this->mod_record      = new \CustomerRecordDB();
        $this->mod_apply       = new \ApplyDB();
        $this->mod_remind      = new \RemindDB();
        $this->mod_programme   = new \CustomerProgrammeDB();
        $this->mod_salesperson = new \SalespersonDB();
    }

    public function create()
    {
        $userId               = input('userId');
        $belongUserName       = input('belongUserName');
        $type                 = input('type/d', 1);                      //1:终端  2:厂家  3:代理商  4:代理人
        $code                 = input('code', '');                       //客户编号
        $name                 = input('name');                           //客户名称
        $province             = input('province', '');                   //省
        $city                 = input('city', '');                       //市
        $address              = input('address', '');                    //地址
        $stage                = input('stage', '');                      //客户阶段
        $explain              = input('explain', '');                    //其他情况说明
        $intermediaryCompany  = input('intermediaryCompany', '');        //中间公司
        $mainPersonnel        = input('mainPersonnel/a', []);            //主要人员{'duties':'','name':'','phone':'','remarks':''}
        $salesFunnel          = input('salesFunnel', '');                //销售漏斗
        $abbreviation         = input('abbreviation', '');               //简称
        $legalRepresentative  = input('legalRepresentative', '');        //法定代表人
        $registeredCapital    = input('registeredCapital', '');          //注册资金
        $lastYearSales        = input('lastYearSales', '');              //去年年销售额
        $customerRating       = input('customerRating', '');             //客户评级
        $cooperationSituation = input('cooperationSituation', '');       //去年合作收入
        if (empty($userId) || empty($belongUserName) || empty($type) || empty($name)) {
            return json(error('缺少必要参数'));
        }
        $userInfo = $this->mod_salesperson->getInfo(['userId' => $userId]);
        if (empty($userInfo)) {
            return json(error('参数错误'));
        }
        $insertData = [
            'type'                 => $type,                     //1:终端  2:厂家
            'code'                 => $code,                     //客户编号
            'name'                 => $name,                     //客户名称
            'province'             => $province,                 //省
            'city'                 => $city,                     //市
            'address'              => $address,                  //地址
            'stage'                => $stage,                    //客户阶段
            'explain'              => $explain,                  //其他情况说明
            'intermediaryCompany'  => $intermediaryCompany,      //中间公司
            'mainPersonnel'        => $mainPersonnel,            //主要人员{'duties':'','name':'','phone':'','remarks':''}
            'salesFunnel'          => $salesFunnel,              //销售漏斗
            'abbreviation'         => $abbreviation,             //简称
            'legalRepresentative'  => $legalRepresentative,      //法定代表人
            'registeredCapital'    => $registeredCapital,        //注册资金
            'lastYearSales'        => $lastYearSales,            //去年年销售额
            'customerRating'       => $customerRating,           //客户评级
            'cooperationSituation' => $cooperationSituation,     //去年合作收入
            'belongUserId'         => [$userInfo['name']],       //跟进销售员id
            'belongUserName'       => $belongUserName,           //跟进销售员name
            'lastRecord'           => [],                        //最后一条沟通记录
            'lastProgramme'        => [],                        //最后一条跟踪方案
            'lastTime'             => time(),                    //最后一次沟通时间
            'applyNum'             => 0,                         //跟进数
            'create'               => time(),                    //创建时间



        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function get()
    {
        $userId = input('userId');
        $belong = input('belong/d', 1);    // 1:我的客户 2：客户池
        $name   = input('name');
        $pn     = input('pn', 1);
        $ps     = 15;
        $start  = ($pn - 1) * $ps;
        if (empty($userId) || empty($belong)) {
            return json(error('缺少必要的参数'));
        }

        $where = [];
        if ($belong == 1) {
            $userInfo = $this->mod_salesperson->getInfo(['userId' => $userId]);
            if (empty($userInfo)) {
                return json(error('参数错误'));
            }
            $where['belongUserId'] = $userInfo['name'];
        }
        else {
            $where['belongUserId'] = [];
        }
        if (!empty($name)) {
            $where['$or'] = [
                ['name' => ['$regex' => $name, '$options' => 'i']],
                ['salesFunnel' => ['$regex' => $name, '$options' => 'i']]
            ];
        }
        $data        = $this->mod->get($where, $start, $ps);
        $customerIds = array_column(iterator_to_array($data), 'id');
        $data_record = $this->mod_record->get([
            '$or'        => [['userId' => $userId], ['status' => 2]],
            'customerId' => ['$in' => $customerIds]
        ]);
        $list_record = [];
        foreach ($data_record as $item) {
            if (!isset($list_record[$item['customerId']])) {
                $list_record[$item['customerId']] = [
                    'title' => $item['title'],
                    'time'  => $item['time'],
                ];
            }
        }
        $list = [];
        foreach ($data as $item) {

            switch ($item['type']) {
                case 1:
                    $item['type'] = '终端';
                    break;
                case 2:
                    $item['type'] = '厂家';
                    break;
                case 3:
                    $item['type'] = '代理商';
                    break;
                case 4:
                    $item['type'] = '代理人';
                    break;
                default:
                    $item['type'] = '终端';
            }

            $list[] = [
                'id'                  => $item['id'],
                //'type'                => $item['type'] == 1 ? '终端' : '厂家',
                'type'                => $item['type'],
                'name'                => $item['name'],
                'legalRepresentative' => $item['legalRepresentative'],
                'address'             => $item['address'],
                'salesFunnel'         => $item['salesFunnel'],
                'lastRecord'          => isset($list_record[$item['id']]) ? $list_record[$item['id']] : [
                    'title' => '',
                    'time'  => '',
                ],
                'lastProgramme'       => empty($item['lastProgramme']) ? [
                    'time'    => '',
                    'content' => ''
                ] : $item['lastProgramme'],
                'applyNum'            => $item['applyNum'],
            ];
        }
        return json(ok($list));
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
        $id                   = input('id');
        $belongUserName       = input('belongUserName');
        $type                 = input('type');                           //1:终端  2:厂家
        $code                 = input('code', '');                       //客户编号
        $name                 = input('name');                           //客户名称
        $province             = input('province', '');                   //省
        $city                 = input('city', '');                       //市
        $address              = input('address', '');                    //地址
        $stage                = input('stage', '');                      //客户阶段
        $explain              = input('explain', '');                    //其他情况说明
        $intermediaryCompany  = input('intermediaryCompany', '');        //中间公司
        $mainPersonnel        = input('mainPersonnel/a', []);            //主要人员{'duties':'','name':'','phone':'','remarks':''}
        $salesFunnel          = input('salesFunnel', '');                //销售漏斗
        $abbreviation         = input('abbreviation', '');               //简称
        $legalRepresentative  = input('legalRepresentative', '');        //法定代表人
        $registeredCapital    = input('registeredCapital', '');          //注册资金
        $lastYearSales        = input('lastYearSales', '');              //去年年销售额
        $customerRating       = input('customerRating', '');             //客户评级
        $cooperationSituation = input('cooperationSituation', '');       //去年合作收入
        if (empty($id) || empty($type) || empty($name)) {
            return json(error('缺少必要参数'));
        }
        $setData = [
            'type'                 => $type,                     //1:终端  2:厂家
            'code'                 => $code,
            'name'                 => $name,                     //客户名称
            'province'             => $province,                 //省
            'city'                 => $city,                     //市
            'address'              => $address,                  //地址
            'stage'                => $stage,                    //客户阶段
            'explain'              => $explain,                  //其他情况说明
            'intermediaryCompany'  => $intermediaryCompany,      //中间公司
            'mainPersonnel'        => $mainPersonnel,            //主要人员{'duties':'','name':'','phone':'','remarks':''}
            'salesFunnel'          => $salesFunnel,              //销售漏斗
            'abbreviation'         => $abbreviation,             //简称
            'legalRepresentative'  => $legalRepresentative,      //法定代表人
            'registeredCapital'    => $registeredCapital,        //注册资金
            'lastYearSales'        => $lastYearSales,            //去年年销售额
            'customerRating'       => $customerRating,           //客户评级
            'cooperationSituation' => $cooperationSituation,     //去年合作收入
            'belongUserName'       => $belongUserName,           //跟进销售员name
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

    public function createRecord()
    {
        $id       = input('id');
        $name     = input('name');
        $userId   = input('userId');
        $userName = input('userName');
        $title    = input('title');
        $time     = input('time');
        $remark   = input('remark');
        $status   = input('status/d', 1);
        if (empty($id) || empty($name) || empty($userId) || empty($userName) || empty($title) || empty($time)) {
            return json(error('缺少必要的参数'));
        }
        $insertData = [
            'userId'       => $userId,
            'userName'     => $userName,
            'customerId'   => $id,
            'customerName' => $name,
            'title'        => $title,
            'time'         => $time,
            'remark'       => $remark,
            'status'       => $status,              //1: 仅自己可见  2：所有人可见
            'create'       => strtotime($time),
        ];
        $this->mod_record->add($insertData);
        $this->mod->update([
            'lastRecord' => [
                'title'  => $title,
                'time'   => $time,
                'status' => $status
            ],
            'lastTime'   => time(),
        ], $id);
        return json(ok());
    }

    public function getRecord()
    {
        $userId = input('userId');
        $id     = input('id');
        $pn     = input('pn', 1);
        $ps     = 15;
        $start  = ($pn - 1) * $ps;
        if (empty($id) || empty($userId)) {
            return json(error('缺少必要的参数'));
        }
        $where = ['$or' => [['userId' => $userId], ['status' => 2]], 'customerId' => $id];
        $data  = $this->mod_record->get($where, $start, $ps);
        $list  = [];
        foreach ($data as $item) {
            $list[] = [
                'title'        => $item['title'],
                'userName'     => $item['userName'],
                'customerName' => $item['customerName'],
                'time'         => $item['time'],
                'remark'       => $item['remark'],
                'status'       => $item['status'],
            ];
        }
        return json(ok($list));
    }

    public function getRecordList()
    {
        $pn          = input('pn/d', 1);
        $ps          = 15;
        $start       = ($pn - 1) * $ps;
        $where       = [];
        $data_record = $this->mod_record->get($where, $start, $ps);

        $customerIds = array_column(iterator_to_array($data_record), 'customerId');
        $data        = $this->mod->get(['id' => ['$in' => $customerIds]]);
        $list        = [];
        foreach ($data as $item) {
            $list[$item['id']] = $item;
        }
        $list_record = [];
        foreach ($data_record as $item) {
            $customerName   = isset($list[$item['customerId']]) ? $list[$item['customerId']]['name'] : '';
            //$item['status'] = $item['status'] == 1 ? '仅自己可见' : '所有人可见';
            $item['status'] = empty($item['status']) ? '' : ($item['status'] == 1 ? '仅自己可见' : '所有人可见' );
            $item['cName']  = $customerName;
            $list_record[]  = $item;
        }
        return json(ok($list_record));
    }

    public function updateSalesFunnel()
    {
        $id          = input('id');
        $salesFunnel = input('salesFunnel');
        if (empty($id) || empty($salesFunnel)) {
            return json(error('缺少必要的参数'));
        }
        $this->mod->update(['salesFunnel' => $salesFunnel], $id);
        return json(ok());
    }


    public function createProgramme()
    {
        $userId  = input('userId');
        $id      = input('id');
        $time    = input('time');
        $content = input('content');
        if (!strtotime($time)) {
            $time = time();
        }
        if (empty($userId) || empty($id) || empty($time) || empty($content)) {
            return json(error('缺少必要的参数'));
        }
        $insertData    = [
            'customerId' => $id,
            'time'       => $time,
            'content'    => $content,
        ];
        $res           = $this->mod_programme->add($insertData);
        $lastProgramme = [
            'time'    => $time,
            'content' => $content,
        ];
        $this->mod->update(['lastProgramme' => $lastProgramme], $id);
        $insertData_remind = [
            'userId'     => $userId,
            'type'       => 1,         //1：跟踪方案  2：客户提醒  3：代理商提醒
            'objId'      => $res,
            'time'       => strtotime($time),
            'status'     => 0,         //0：未读  1：已读
            'sendStatus' => 0,         //0:未发送 1：已发送
            'content'    => $content,
        ];
        $this->mod_remind->add($insertData_remind);
        return json(ok());
    }

    public function getProgranmme()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要的参数'));
        }
        $data = $this->mod_programme->get(['customerId' => $id]);
        $list = [];
        foreach ($data as $item) {
            $list[] = $item;
        }
        return json(ok($list));
    }

    public function deleteProgranmme()
    {
        $progranmmeId = input('progranmmeId');
        if (empty($progranmmeId)) {
            return json(error('缺少必要的参数'));
        }
        $this->mod_programme->delete($progranmmeId);
        $this->mod_remind->delete(['objId' => $progranmmeId]);
        return json(ok());
    }

    /**
     * 转回客户池
     * @return \think\response\Json
     */
    public function operationTransfer()
    {
        $id     = input('id');
        $userId = input('userId');
        if (empty($id)) {
            return json(error('缺少必要的参数'));
        }
        $info = $this->mod->getInfo($id);
        if (empty($info)) {
            return json(error('参数错误'));
        }
        $userInfo = $this->mod_salesperson->getInfo(['userId' => $userId]);
        if (empty($userInfo)) {
            return json(error('参数错误'));
        }
        $belongUserId = $info['belongUserId'];
        $lastRecord   = $info['lastRecord'];
        if (!in_array($userInfo['name'], $belongUserId)) {
            return json(error('参数错误'));
        }
        $index = array_search($userInfo['name'], $belongUserId);
        array_splice($belongUserId, $index, 1);
        if (empty($belongUserId)) {
            $lastRecord = [];
        }
        $this->mod->update([
            'belongUserId'   => $belongUserId,
            'belongUserName' => implode(',', $belongUserId),
            'lastRecord'     => $lastRecord
        ], $id);
        return json(ok());
    }

    /**
     * 我要跟进
     * @return \think\response\Json
     */
    public function operationApply()
    {
        $userId   = input('userId');
        $userName = input('userName');
        $id       = input('id');
        if (empty($userId) || empty($id) || empty($userName)) {
            return json(error('缺少必要的参数'));
        }
        $info_customer = $this->mod->getInfo($id);
        if (empty($info_customer) || !empty($info_customer['belongUserId'])) {
            return json(error('参数错误'));
        }
        $info_apply = $this->mod_apply->getInfo(['objId' => $id, 'userId' => $userId]);
        if (!empty($info_apply)) {
            return json(error('不能重复申请'));
        }
        $insertData = [
            'objId'    => $id,
            'type'     => 1,           //1:客户 2：代理商
            'userId'   => $userId,
            'userName' => $userName,
            'create'   => time()
        ];
        $this->mod_apply->add($insertData);
        $this->mod->updateInc(['applyNum' => 1], $id);
        return json(ok());
    }



    public function indexRecordAdd ()
    {
        $userId     = input('userId');      //
        $userName   = input('username');    //
        $recordList = input('recordList');  //多条记录情况
        $record_list = [];

        if (empty($recordList)) {
            return json(error('未接收到内容'));
        }
        foreach ($recordList as $recordItem) {

            if (empty($recordItem['customer']) || empty($recordItem['customerName']) || empty($recordItem['remark'])) {
                continue;
            }
            $where['$or'] = [
                    ['abbreviation' => ['$regex' => $recordItem['customer'], '$options' => 'i'] ],
                    ['name'         => ['$regex' => $recordItem['customer'], '$options' => 'i'] ]
            ];
            $customer_data = $this->mod->getInfo($where);

            if (!empty($customer_data)) {
                $record_list[] = [
                    'id'            => $customer_data['id'],
                    'userId'        => $userId,
                    'userName'      => $userName,
                    'customerId'    => $customer_data['id'],
                    'customerName'  => $recordItem['customerName'],
                    'title'         => '',
                    'time'          => date('Y-m-d H:i:s'),
                    'remark'        => $recordItem['remark'],
                    'status'        => 1,
                    'create'        => time(),
                    'type'          => 1
                ];
            }

        }

        if (!empty($record_list)) {
            //$this->mod_record->batchInsert($record_list);
        }

        //return json(ok($record_list));
        return json(ok($recordList));

    }

    public function testId ()
    {
        /*$data = $this->mod->getInfo(['name'=> '湖南创世智能科技有限公司']);*/
        $data = 15120549010377588;
        $data = dechex($data);

        return json(ok($data));
    }

}