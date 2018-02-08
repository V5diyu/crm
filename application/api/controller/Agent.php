<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/17
 * Time: 上午11:47
 */

namespace app\api\controller;


class Agent extends Base
{
    private $mod;
    private $mod_record;
    private $mod_apply;
    private $mod_salesperson;

    public function __construct()
    {
        $this->mod             = new \AgentDB();
        $this->mod_record      = new \AgentRecordDB();
        $this->mod_apply       = new \ApplyDB();
        $this->mod_salesperson = new \SalespersonDB();
    }

    public function create()
    {
        $userId              = input('userId');
        $belongUserName      = input('belongUserName');
        $type                = input('type/d', 1);                      //客户类型 1：代理商  2：代理人
        $code                = input('code', '');                       //代理商代码
        $name                = input('name');                           //代理商名称
        $abbreviation        = input('abbreviation', '');               //代理商简称
        $legalRepresentative = input('legalRepresentative', '');        //法定代表人
        $address             = input('address', '');                    //地址
        $registeredCapital   = input('registeredCapital', '');          //注册资金
        $lastYearSales       = input('lastYearSales', '');              //去年贡献收入
        $proxyLevel          = input('proxyLevel', '');                 //代理级别  1 2 3
        $explain             = input('explain', '');                    //其他情况说明
        $mainPersonnel       = input('mainPersonnel/a', []);            //主要人员{'duties':'','name':'','phone':'','remarks':''}
        if (empty($userId) || empty($belongUserName) || empty($name)) {
            return json(error('缺少必要参数'));
        }
        $userInfo = $this->mod_salesperson->getInfo(['userId' => $userId]);
        if (empty($userInfo)) {
            return json(error('参数错误'));
        }
        $insertData = [
            'type'                => $type,                     //客户类型 1：代理商  2：代理人
            'code'                => $code,                     //代理商代码
            'name'                => $name,                     //代理商名称
            'abbreviation'        => $abbreviation,             //代理商简称
            'legalRepresentative' => $legalRepresentative,      //法定代表人
            'address'             => $address,                  //地址
            'registeredCapital'   => $registeredCapital,        //注册资金
            'lastYearSales'       => $lastYearSales,            //去年贡献收入
            'proxyLevel'          => $proxyLevel,               //代理级别  1 2 3
            'explain'             => $explain,                  //其他情况说明
            'mainPersonnel'       => $mainPersonnel,            //主要人员{'duties':'','name':'','phone':'','remarks':''}
            'belongUserId'        => [$userInfo['name']],                 //跟进销售员id
            'belongUserName'      => $belongUserName,           //跟进销售员name
            'lastRecord'          => [],                        //最后一条沟通记录
            'lastTime'            => time(),                    //最后一次沟通时间
            'applyNum'            => 0,                         //跟进数
            'create'              => time(),                    //创建时间
        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function get()
    {
        $userId = input('userId');
        $belong = input('belong/d', 1);    // 1:我的代理商 2：代理商池
        $name   = input('name');
        $pn     = input('pn', 1);
        $ps     = 15;
        $start  = ($pn - 1) * $ps;
        $where  = [];
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
            $where['name'] = ['$regex' => $name, '$options' => 'i'];
        }
        $data = $this->mod->get($where, $start, $ps);
        $list = [];
        foreach ($data as $item) {
            $list[] = [
                'id'                  => $item['id'],
                'type'                => $item['type'] == 1 ? '代理商' : '代理人',
                'name'                => $item['name'],
                'code'                => $item['code'],
                'legalRepresentative' => $item['legalRepresentative'],
                'address'             => $item['address'],
                'lastRecord'          => empty($item['lastRecord']) ? [
                    'title'  => '',
                    'time'   => '',
                    'status' => ''
                ] : $item['lastRecord'],
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
        $id                  = input('id');
        $belongUserName      = input('belongUserName');
        $type                = input('type/d', 1);                      //客户类型 1：代理商  2：代理人
        $code                = input('code', '');                       //代理商代码
        $name                = input('name');                           //代理商名称
        $abbreviation        = input('abbreviation', '');               //代理商简称
        $legalRepresentative = input('legalRepresentative', '');        //法定代表人
        $address             = input('address', '');                    //地址
        $registeredCapital   = input('registeredCapital', '');          //注册资金
        $lastYearSales       = input('lastYearSales', '');              //去年贡献收入
        $proxyLevel          = input('proxyLevel', '');                 //代理级别  1 2 3
        $explain             = input('explain', '');                    //其他情况说明
        $mainPersonnel       = input('mainPersonnel/a', []);            //主要人员{'duties':'','name':'','phone':'','remarks':''}

        if (empty($id) || empty($name) || empty($belongUserName)) {
            return json(error('缺少必要参数'));
        }
        $setData = [
            'type'                => $type,                     //客户类型 1：代理商  2：代理人
            'code'                => $code,                     //代理商代码
            'name'                => $name,                     //代理商名称
            'abbreviation'        => $abbreviation,             //代理商简称
            'legalRepresentative' => $legalRepresentative,      //法定代表人
            'address'             => $address,                  //地址
            'registeredCapital'   => $registeredCapital,        //注册资金
            'lastYearSales'       => $lastYearSales,            //去年贡献收入
            'proxyLevel'          => $proxyLevel,               //代理级别  1 2 3
            'explain'             => $explain,                  //其他情况说明
            'mainPersonnel'       => $mainPersonnel,            //主要人员{'duties':'','name':'','phone':'','remarks':''}
            'belongUserName'      => $belongUserName,
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
            'create'       => strtotime($time),
        ];
        $this->mod_record->add($insertData);
        $this->mod->update([
            'lastRecord' => [
                'title' => $title,
                'time'  => date('Y-m-d', strtotime($time)),
            ],
            'lastTime'   => time(),
        ], $id);
        return json(ok());
    }

    public function getRecord()
    {
        $id    = input('id');
        $pn    = input('pn', 1);
        $ps    = 15;
        $start = ($pn - 1) * $ps;
        if (empty($id)) {
            return json(error('缺少必要的参数'));
        }
        $where = ['customerId' => $id];
        $data  = $this->mod_record->get($where, $start, $ps);
        $list  = [];
        foreach ($data as $item) {
            $list[] = [
                'title'        => $item['title'],
                'userName'     => $item['userName'],
                'customerName' => $item['customerName'],
                'time'         => $item['time'],
                'remark'       => $item['remark'],
            ];
        }
        return json(ok($list));
    }

    public function getRecordList()
    {
        $pn           = input('pn/d', 1);
        $ps           = 15;
        $start        = ($pn - 1) * $ps;
        $where        = [];
        $data_record  = $this->mod_record->get($where, $start, $ps);

        $customerIds = array_column(iterator_to_array($data_record), 'customerId');
        $data        = $this->mod->get(['id' => ['$in' => $customerIds]]);
        $list        = [];
        foreach ($data as $item) {
            $list[$item['id']] = $item;
        }
        $list_record = [];
        foreach ($data_record as $item) {
            $agentName     = isset($list[$item['customerId']]) ? $list[$item['customerId']]['name'] : '';
            $item['cName'] = $agentName;
            $list_record[] = $item;
        }
        return json(ok($list_record));
    }

    /**
     * 转回代理商池
     * @return \think\response\Json
     */
    public function operationTransfer()
    {
        $id     = input('id');
        $userId = input('userId');
        if (empty($id) || empty($userId)) {
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
        $info_agent = $this->mod->getInfo($id);
        if (empty($info_agent) || !empty($info_agent['belongUserId'])) {
            return json(error('参数错误'));
        }
        $info_apply = $this->mod_apply->getInfo(['objId' => $id, 'userId' => $userId]);
        if (!empty($info_apply)) {
            return json(error('不能重复申请'));
        }
        $insertData = [
            'objId'    => $id,
            'type'     => 2,           //1:客户 2：代理商
            'userId'   => $userId,
            'userName' => $userName,
            'create'   => time()
        ];
        $this->mod_apply->add($insertData);
        $this->mod->updateInc(['applyNum' => 1], $id);
        return json(ok());
    }
}