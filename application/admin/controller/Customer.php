<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/17
 * Time: 上午11:47
 */

namespace app\admin\controller;


class Customer extends Base
{
    private $mod;
    private $mod_record;
    private $mod_apply;
    private $mod_salesperson;
    private $mod_agent;
    private $mod_agentRecord;

    public function __construct()
    {
        $this->mod             = new \CustomerDB();
        $this->mod_record      = new \CustomerRecordDB();
        $this->mod_apply       = new \ApplyDB();
        $this->mod_salesperson = new \SalespersonDB();
        $this->mod_agent       = new \AgentDB();
        $this->mod_agentRecord = new \AgentRecordDB();
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
        $arr_title    = array_shift($excel_array);
        if (!isset($arr_title[8]) || empty($arr_title[8]) || $arr_title[8] != '跟进销售员') {
            return json(error('excel格式不正确'));
        }
        $list = [];
        foreach ($excel_array as $k => $v) {
            if (isset($v[1]) && !empty($v[1]) && isset($v[8]) && !empty($v[8])) {
                $item         = [
                    'id'                   => getUuid(),
                    'type'                 => 1,                 //1:终端  2:厂家
                    'code'                 => $v[0],             //客户编号
                    'name'                 => $v[1],             //客户名称
                    'province'             => $v[2],             //省
                    'city'                 => $v[3],             //市
                    'address'              => $v[4],             //地址
                    'stage'                => $v[5],             //客户阶段
                    'explain'              => $v[6],             //其他情况说明
                    'intermediaryCompany'  => $v[7],             //中间公司
                    'abbreviation'         => '',                //简称
                    'legalRepresentative'  => '',                //法定代表人
                    'registeredCapital'    => '',                //注册资金
                    'lastYearSales'        => '',                //去年年销售额
                    'customerRating'       => '',                //客户评级
                    'mainPersonnel'        => [],                //主要人员{'duties':'','name':'','phone':'','remarks':''}
                    'salesFunnel'          => '',                //销售漏斗
                    'cooperationSituation' => '',                //去年合作收入
                    'belongUserId'         => empty($v[8]) ? [] : explode(',', $v[8]),   //跟进销售员id
                    'belongUserName'       => $v[8],                //跟进销售员name
                    'lastRecord'           => [],                //最后一条沟通记录
                    'lastProgramme'        => [],                //最后一条跟踪方案
                    'lastTime'             => time(),            //最后一次沟通时间
                    'applyNum'             => 0,                 //跟进数
                    'create'               => time(),            //创建时间


                    'proxyLevel'           => '',               //Customer表中缺少的数据
                    'flag'                 => 'customer',       //Customer表中缺少的数据

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

    public function uploadExcelTwo()
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
        $obj_PHPExcel = $objReader->load($file_name);               //加载文件内容,编码utf-8
        $excel_array  = $obj_PHPExcel->getsheet(0)->toArray();      //转换为数组格式
        $arr_title    = array_shift($excel_array);
        if (!isset($arr_title[9]) || empty($arr_title[9]) || $arr_title[9] != '跟进销售员') {
            return json(error('excel格式不正确'));
        }
        $list = [];
        foreach ($excel_array as $k => $v) {
            if (isset($v[1]) && !empty($v[1] && isset($v[9]) && !empty($v[9]))) {
                $item         = [
                    'id'                   => getUuid(),
                    'type'                 => 2,                    //1:终端  2:厂家
                    'code'                 => $v[0],                //客户编号
                    'name'                 => $v[1],                //客户名称
                    'abbreviation'         => $v[2],                //简称
                    'legalRepresentative'  => $v[3],                //法定代表人
                    'address'              => $v[4],                //地址
                    'registeredCapital'    => $v[5],                //注册资金
                    'lastYearSales'        => $v[6],                //去年年销售额
                    'customerRating'       => $v[7],                //客户评级
                    'explain'              => $v[8],                //其他情况说明
                    'province'             => '',                   //省
                    'city'                 => '',                   //市
                    'stage'                => '',                   //客户阶段
                    'intermediaryCompany'  => '',                   //中间公司
                    'mainPersonnel'        => [],                   //主要人员{'duties':'','name':'','phone':'','remarks':''}
                    'salesFunnel'          => '',                   //销售漏斗
                    'cooperationSituation' => '',                   //去年合作收入
                    'belongUserId'         => empty($v[9]) ? [] : explode(',', $v[9]),                //跟进销售员id
                    'belongUserName'       => $v[9],                //跟进销售员name
                    'lastRecord'           => [],                   //最后一条沟通记录
                    'lastProgramme'        => [],                   //最后一条跟踪方案
                    'lastTime'             => time(),               //最后一次沟通时间
                    'applyNum'             => 0,                    //跟进数
                    'create'               => time(),               //创建时间

                    'proxyLevel'           => '',                   //Customer表中缺少的数据
                    'flag'                 => 'customer',           //Customer表中缺少的数据
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

    public function create()
    {
        $type                 = input('type/d', 1);                      //1:终端  2:厂家
        $code                 = input('code');                           //客户编号
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
        $cooperationSituation = input('cooperationSituation', '');        //去年合作收入

        if (empty($type) || empty($name)) {
            return json(error('缺少必要参数'));
        }
        $insertData = [
            'type'                 => $type,                    //1:终端  2:厂家
            'code'                 => $code,
            'name'                 => $name,                    //客户名称
            'province'             => $province,                //省
            'city'                 => $city,                    //市
            'address'              => $address,                 //地址
            'stage'                => $stage,                   //客户阶段
            'explain'              => $explain,                 //其他情况说明
            'intermediaryCompany'  => $intermediaryCompany,     //中间公司
            'mainPersonnel'        => $mainPersonnel,           //主要人员{'duties':'','name':'','phone':'','remarks':''}
            'salesFunnel'          => $salesFunnel,             //销售漏斗
            'abbreviation'         => $abbreviation,            //简称
            'legalRepresentative'  => $legalRepresentative,     //法定代表人
            'registeredCapital'    => $registeredCapital,       //注册资金
            'lastYearSales'        => $lastYearSales,           //去年年销售额
            'customerRating'       => $customerRating,          //客户评级
            'cooperationSituation' => $cooperationSituation,    //去年合作收入
            'belongUserId'         => [],                       //跟进销售员id
            'belongUserName'       => '',                       //跟进销售员name
            'lastRecord'           => [],                       //最后一条沟通记录
            'lastProgramme'        => [],                       //最后一条跟踪方案
            'lastTime'             => time(),                   //最后一次沟通时间
            'applyNum'             => 0,                        //跟进数
            'create'               => time(),                   //创建时间

            'proxyLevel'           => '',                       //Customer表中缺少的数据
            'flag'                 => 'customer',               //Customer表中缺少的数据

        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function get()
    {
        $type  = input('type/d', 1);
        $model = input('model/d', 1);           //1:客户池获取  2：两周未联系的客户  3:已跟进
        $name  = input('name');
        $pn    = input('pn', 1);
        $ps    = 15;
        $start = ($pn - 1) * $ps;
        $where = [];

        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 3 || ($accountInfo['setUp'] == 2 && $model == 2) || ($accountInfo['setUp'] == 2 && $model == 3)) {
            return json(error('权限不足'));
        }
        if ($accountInfo['setUp'] == 4) {
            $where['belongUserId'] = $accountInfo['name'];
        }
        switch ($model) {
            case 1:
                if ($accountInfo['setUp'] == 1 || $accountInfo['setUp'] == 2) {
                    $where['belongUserId'] = [];
                }
                break;
            case 2:
                $where['lastTime'] = ['$lt' => time() - 1209600];
                break;
            case 3:
                if ($accountInfo['setUp'] == 1) {
                    $where['belongUserId'] = ['$ne' => []];
                }
        }
        if (!empty($name)) {
            $where['name'] = ['$regex' => $name, '$options' => 'i'];
        }
        if (!empty($type)) {
            $where['type'] = $type;
        }
        $data  = $this->mod->get($where, $start, $ps);
        $count = $this->mod->count($where);
        $list  = [];
        foreach ($data as $item) {
            $list[] = $item;
        }
        return json(ok(['list' => $list, 'count' => $count]));
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
        $type                 = input('type/d');                         //1:终端  2:厂家
        $code                 = input('code');
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

    public function getApplyList()
    {
        $id = input('id');
        if (empty($id)) {
            return json(error('缺少必要参数'));
        }
        $data = $this->mod_apply->get(['objId' => $id]);
        $list = [];
        foreach ($data as $item) {
            $list[] = [
                'id'       => $item['id'],
                'userId'   => $item['userId'],
                'userName' => $item['userName'],
                'create'   => date('Y-m-d H:i:s', $item['create'])
            ];
        }
        return json(ok($list));
    }

    public function operationConfirm()
    {
        $id      = input('id');
        $applyId = input('applyId/a', []);
        if (empty($id) || empty($applyId)) {
            return json(error('缺少必要参数'));
        }
        $info_customer = $this->mod->getInfo($id);
        if (empty($info_customer)) {
            return json(error('参数错误'));
        }
        $data_apply = $this->mod_apply->get(['id' => ['$in' => $applyId]]);
        $list       = [];
        foreach ($data_apply as $item) {
            $list[] = [
                'userId'   => $item['userId'],
                'userName' => $item['userName'],
            ];
        }
        if (empty($list)) {
            return json(error('参数错误'));
        }
        $this->mod->update([
            'belongUserId'   => array_column($list, 'userName'),
            'belongUserName' => implode(',', array_column($list, 'userName')),
            'applyNum'       => 0,
        ], $id);
        $this->mod_apply->delete(['objId' => $id]);
        return json(ok());
    }

    /**
     * 获取跟进记录
     * @return \think\response\Json
     */
    public function getRecord()
    {
        $id    = input('id');
        $pn    = input('pn', 1);
        $ps    = 15;
        $start = ($pn - 1) * $ps;
        if (empty($id)) {
            return json(error('缺少必要的参数'));
        }
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 2 || $accountInfo['setUp'] == 3) {
            return json(error('权限不足'));
        }
        $where = ['customerId' => $id];
        if ($accountInfo['setUp'] == 4) {
            $where['$or'] = [['userName' => $accountInfo['name']], ['status' => 2]];
        }

        $data  = $this->mod_record->get($where, $start, $ps);
        $count = $this->mod_record->count($where);
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
        return json(ok(['list' => $list, 'count' => $count]));
    }

    public function downloadTemplate()
    {
        $type = input('type/d', 1);
        if ($type == 1) {
            $path     = './template/customer1.xlsx'; //文件名
            $filename = '客户模版-终端.xlsx';
        }
        else {
            $path     = './template/customer2.xlsx'; //文件名
            $filename = '客户模版-厂家.xlsx';
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition:  attachment;  filename= $filename");
        echo file_get_contents($path);
    }

    public function export()
    {
        $type = input('type/d', 1);

        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();
        if ($type == 1) {
            $name = '终端数据';
            setExcelTitleStyle($PHPSheet, 9);
            $PHPSheet->setCellValue("A1", "名称")->setCellValue("B1", "编号")->setCellValue("C1", "省份")->setCellValue("D1", "城市")->setCellValue("E1", "地址")->setCellValue("F1", "阶段")->setCellValue("G1", "其他情况说明")->setCellValue("H1", "中间公司")->setCellValue("I1", "销售漏斗");
        }
        else {
            $name = '厂家数据';
            setExcelTitleStyle($PHPSheet, 9);
            $PHPSheet->setCellValue("A1", "名称")->setCellValue("B1", "编号")->setCellValue("C1", "简称")->setCellValue("D1", "法定代表人")->setCellValue("E1", "注册资金/万")->setCellValue("F1", "去年销售额")->setCellValue("G1", "评级")->setCellValue("H1", "其他情况说明")->setCellValue("I1", "销售漏斗");
        }
        $PHPSheet->setTitle($name);

        $where       = ['type' => $type];
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 2 || $accountInfo['setUp'] == 3) {
            return json(error('权限不足'));
        }
        if ($accountInfo['setUp'] == 4) {
            $where['belongUserId'] = $accountInfo['name'];
        }
        $data = $this->mod->get($where);
        $i    = 1;
        if ($type == 1) {
            foreach ($data as $item) {
                $i++;
                $PHPSheet->setCellValue("A$i", $item['name'])->setCellValue("B$i", $item['code'])->setCellValue("C$i", $item['province'])->setCellValue("D$i", $item['city'])->setCellValue("E$i", $item['address'])->setCellValue("F$i", $item['stage'])->setCellValue("G$i", $item['explain'])->setCellValue("H$i", $item['intermediaryCompany'])->setCellValue("I$i", $item['salesFunnel']);
            }
        }
        else {
            foreach ($data as $item) {
                $i++;
                $PHPSheet->setCellValue("A$i", $item['name'])->setCellValue("B$i", $item['code'])->setCellValue("C$i", $item['abbreviation'])->setCellValue("D$i", $item['legalRepresentative'])->setCellValue("E$i", $item['registeredCapital'])->setCellValue("F$i", $item['lastYearSales'])->setCellValue("G$i", $item['customerRating'])->setCellValue("H$i", $item['explain'])->setCellValue("I$i", $item['salesFunnel']);
            }
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$name.xlsx");
        $PHPWriter->save("php://output");
    }


    public function getRecordList()
    {
        $pn          = input('pn/d', 1);
        $ps          = 15;
        $start       = ($pn - 1) * $ps;
        $sort        = ['create' => -1];

        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 2 || $accountInfo['setUp'] == 3) {
            return json(error('权限不足'));
        }
        $where = ['type' => 1 ];
        if ($accountInfo['setUp'] == 4) {
            $where['userName'] = $accountInfo['name'];
        }
        $data_record  = $this->mod_record->get($where, $start, $ps, $sort);
        $count_record = $this->mod_record->count($where);

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
        return json(ok(['list' => $list_record, 'count' => $count_record]));
    }

    public function updateRecord()
    {
        $id           = input('id');
        $customerName = input('customerName');
        $userName     = input('userName');
        $title        = input('title');
        $time         = input('time');
        $remark       = input('remark');
        $status       = input('status/d', 1);
        if (empty($id) || empty($customerName) || empty($userName) || empty($title) || empty($time)) {
            return json(error('缺少必要的参数'));
        }
        $setData = [
            'userName'     => $userName,
            'customerName' => $customerName,
            'title'        => $title,
            'time'         => $time,
            'remark'       => $remark,
            'status'       => $status,              //1: 仅自己可见  2：所有人可见
        ];
        $this->mod_record->update($setData, $id);
        return json(ok());
    }


    public function exportRecord()
    {
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 2 || $accountInfo['setUp'] == 3) {
            return json(error('权限不足'));
        }

        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();
        $name     = '客户跟进记录';
        setExcelTitleStyle($PHPSheet, 7);
        $PHPSheet->setCellValue("A1", "客户名称")->setCellValue("B1", "沟通对象")->setCellValue("C1", "销售员")->setCellValue("D1", "标题")->setCellValue("E1", "内容")->setCellValue("F1", "时间")->setCellValue("G1", "状态");
        $PHPSheet->setTitle($name);
        if ($accountInfo['setUp'] == 4) {
            $data_customer = $this->mod->get(['belongUserId' => $accountInfo['name']]);
            $customerIds   = array_column(iterator_to_array($data_customer), 'id');
            $where         = [
                'customerId' => ['$in' => $customerIds],
                '$or'        => [['userName' => $accountInfo['name']], ['status' => 2]]
            ];
            $list_customer = [];
            foreach ($data_customer as $item) {
                $list_customer[$item['id']] = $item['name'];
            }
        }
        else {
            $where         = [];
            $data_customer = $this->mod->get();
            $list_customer = [];
            foreach ($data_customer as $item) {
                $list_customer[$item['id']] = $item['name'];
            }
        }
        $data = $this->mod_record->get($where, 0, 0, ['create' => -1]);
        $i    = 1;
        foreach ($data as $item) {
            $i++;
            $customerName = isset($list_customer[$item['customerId']]) ? $list_customer[$item['customerId']] : '';
            $status       = $item['status'] == 1 ? '仅自己可见' : '所有人可见';
            $PHPSheet->setCellValue("A$i", $customerName)->setCellValue("B$i", $item['customerName'])->setCellValue("C$i", $item['userName'])->setCellValue("D$i", $item['title'])->setCellValue("E$i", $item['remark'])->setCellValue("F$i", $item['time'])->setCellValue("G$i", $status);
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$name.xlsx");
        $PHPWriter->save("php://output");
    }

    public function upr()
    {
        $data = $this->mod_record->get();
        foreach ($data as $item) {
            $this->mod_record->update(['create' => strtotime($item['time'])], $item['id']);
        }
        return json(ok());
    }

    public function updateCustomerRecord()
    {
        $data = $this->mod_record->get();
        foreach ($data as $record_item) {
            $id = $record_item['id'];
            $type = 1;

            $this->mod_record->update([
                'type' => $type
            ],$id);
        }
    }

    public function updateCustomer ()
    {
        /*$customer_data = $this->mod->get();

        $proxyLevel = '';
        $flag       = 'customer';

        foreach ($customer_data as $customer_item) {
            $id = $customer_item['id'];
            $this->mod->update([
                'proxyLevel'    => $proxyLevel,
                'flag'          => $flag,
            ],$id);
        }*/
    }

    public function mergeTable()
    {
        $agent_data = $this->mod_agent->get();
        $list_agent_data = [];
        foreach ($agent_data as $agent_item) {

            if ($agent_item['type'] === 1) {
                $agent_item['type'] = 3;
            } else if ($agent_item['type'] === 2) {
                $agent_item['type'] = 4;
            }
            $agent_item['city']                 = '';
            $agent_item['cooperationSituation'] = '';
            $agent_item['customerRating']       = '';
            $agent_item['intermediaryCompany']  = '';
            $agent_item['lastProgramme']        = '';
            $agent_item['province']             = '';
            $agent_item['salesFunnel']          = '';
            $agent_item['stage']                = '';

            $list_agent_data[] = $agent_item;
        }
        dump(count($list_agent_data));
        /*if (!empty($list_agent_data)) {
            $this->mod->batchInsert($list_agent_data);
        }*/
    }


    public function mergeRecord ()
    {
        $data = $this->mod_agentRecord->get();
        $list_record_data = [];
        foreach ($data as $record_item) {

            $list_record_data[] = $record_item;

        }

        //dump(count($list_record_data));
        if (!empty($list_record_data) ) {
            dump(count($list_record_data));
            //$this->mod_record->batchInsert($list_record_data);
        }

    }

}