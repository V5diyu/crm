<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/17
 * Time: 上午11:47
 */

namespace app\admin\controller;


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
        if (!isset($arr_title[9]) || empty($arr_title[9]) || $arr_title[9] != '跟进销售员') {
            return json(error('excel格式不正确'));
        }
        $list = [];
        foreach ($excel_array as $k => $v) {
            if (isset($v[1]) && !empty($v[1] && isset($v[9]) && !empty($v[9]))) {
                $item         = [
                    'id'                  => getUuid(),
                    'type'                => 1,                 //代理商类型 1：代理商 2：代理人
                    'code'                => $v[0],             //代理商代码
                    'name'                => $v[1],             //代理商名称
                    'abbreviation'        => $v[2],             //代理商简称
                    'legalRepresentative' => $v[3],             //法定代表人
                    'address'             => $v[4],             //地址
                    'registeredCapital'   => $v[5],             //注册资金
                    'lastYearSales'       => $v[6],             //去年贡献收入
                    'proxyLevel'          => $v[7],             //代理级别  1 2 3
                    'explain'             => $v[8],             //其他情况说明
                    'mainPersonnel'       => [],             //主要人员{'duties':'','name':'','phone':'','remarks':''}
                    'belongUserId'        => empty($v[9]) ? [] : explode(',', $v[9]),                //跟进销售员id
                    'belongUserName'      => $v[9],                //跟进销售员name
                    'lastRecord'          => [],                //最后一条沟通记录
                    'lastTime'            => time(),            //最后一次沟通时间
                    'applyNum'            => 0,                 //跟进数
                    'create'              => time(),            //创建时间
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
        $obj_PHPExcel = $objReader->load($file_name);  //加载文件内容,编码utf-8
        $excel_array  = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
        $arr_title    = array_shift($excel_array);
        if (!isset($arr_title[3]) || empty($arr_title[3]) || $arr_title[3] != '跟进销售员') {
            return json(error('excel格式不正确'));
        }
        $list = [];
        foreach ($excel_array as $k => $v) {
            if (isset($v[1]) && !empty($v[1]) && isset($v[3]) && !empty($v[3])) {
                $item         = [
                    'id'                  => getUuid(),
                    'type'                => 2,                 //代理商类型 1：代理商 2：代理人
                    'code'                => $v[0],             //代理商代码
                    'name'                => $v[1],             //代理商名称
                    'abbreviation'        => '',                //代理商简称
                    'legalRepresentative' => '',                //法定代表人
                    'address'             => '',                //地址
                    'registeredCapital'   => '',                //注册资金
                    'lastYearSales'       => '',                //去年贡献收入
                    'proxyLevel'          => '',                //代理级别  1 2 3
                    'explain'             => $v[2],             //其他情况说明
                    'mainPersonnel'       => [],                //主要人员{'duties':'','name':'','phone':'','remarks':''}
                    'belongUserId'        => empty($v[3]) ? [] : explode(',', $v[3]),                //跟进销售员id
                    'belongUserName'      => $v[3],                //跟进销售员name
                    'lastRecord'          => [],                //最后一条沟通记录
                    'lastTime'            => time(),            //最后一次沟通时间
                    'applyNum'            => 0,                 //跟进数
                    'create'              => time(),            //创建时间
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
        $type                = input('type/d', 1);                      //代理商类型 1：代理商 2：代理人
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
        if (empty($name)) {
            return json(error('缺少必要参数'));
        }
        $insertData = [
            'type'                => $type,                     //代理商类型 1：代理商 2：代理人
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
            'belongUserId'        => [],                        //跟进销售员id
            'belongUserName'      => '',                        //跟进销售员name
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
        $type        = input('type/d', 1);
        $model       = input('model/d', 1);           //1:代理商池获取  2：两周未联系的代理商  3:已跟进
        $name        = input('name');
        $code        = input('code');
        $pn          = input('pn', 1);
        $ps          = 15;
        $start       = ($pn - 1) * $ps;
        $where       = [];
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
        if (!empty($type)) {
            $where['type'] = $type;
        }
        if (!empty($name)) {
            $where['name'] = ['$regex' => $name, '$options' => 'i'];
        }
        if (!empty($code)) {
            $where['code'] = ['$regex' => $code, '$options' => 'i'];
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
        $id                  = input('id');
        $type                = input('type/d', 1);                      //代理商类型 1：代理商 2：代理人
        $code                = input('code', '');                       //代理商代码
        $name                = input('name');                           //代理商名称
        $abbreviation        = input('abbreviation', '');               //代理商简称
        $legalRepresentative = input('legalRepresentative', '');        //法定代表人
        $address             = input('address', '');                    //地址
        $registeredCapital   = input('registeredCapital', '');          //注册资金
        $lastYearSales       = input('lastYearSales', '');              //去年贡献收入
        $proxyLevel          = input('proxyLevel', '');                //代理级别  1 2 3
        $explain             = input('explain', '');                    //其他情况说明
        $mainPersonnel       = input('mainPersonnel/a', []);            //主要人员{'duties':'','name':'','phone':'','remarks':''}

        if (empty($id) || empty($name)) {
            return json(error('缺少必要参数'));
        }
        $setData = [
            'type'                => $type,                     //代理商类型 1：代理商 2：代理人
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
        $info_agent = $this->mod->getInfo($id);
        if (empty($info_agent)) {
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
            ];
        }
        return json(ok(['list' => $list, 'count' => $count]));
    }

    public function downloadTemplate()
    {
        $type = input('type/d', 1);
        if ($type == 1) {
            $path     = './template/agent1.xlsx'; //文件名
            $filename = '代理商模版-代理商.xlsx';
        }
        else {
            $path     = './template/agent2.xlsx'; //文件名
            $filename = '代理商模版-代理人.xlsx';
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
            $name = '代理商数据';
            setExcelTitleStyle($PHPSheet, 9);
            $PHPSheet->setCellValue("A1", "代理商编码")->setCellValue("B1", "代理商名称")->setCellValue("C1", "代理商简称")->setCellValue("D1", "法定代表人")->setCellValue("E1", "地址")->setCellValue("F1", "注册资金/万")->setCellValue("G1", "去年贡献收入/万")->setCellValue("H1", "代理级别")->setCellValue("I1", "其他情况说明");
        }
        else {
            $name = '代理人数据';
            setExcelTitleStyle($PHPSheet, 3);
            $PHPSheet->setCellValue("A1", "代理商编码")->setCellValue("B1", "代理商名称")->setCellValue("C1", "其他情况说明");
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
                $PHPSheet->setCellValue("A$i", $item['code'])->setCellValue("B$i", $item['name'])->setCellValue("C$i", $item['abbreviation'])->setCellValue("D$i", $item['legalRepresentative'])->setCellValue("E$i", $item['address'])->setCellValue("F$i", $item['registeredCapital'])->setCellValue("G$i", $item['lastYearSales'])->setCellValue("H$i", $item['proxyLevel'])->setCellValue("I$i", $item['explain']);
            }
        }
        else {
            foreach ($data as $item) {
                $i++;
                $PHPSheet->setCellValue("A$i", $item['code'])->setCellValue("B$i", $item['name'])->setCellValue("C$i", $item['explain']);
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
        $accountInfo = $this->getUserInfo();
        if ($accountInfo['setUp'] == 2 || $accountInfo['setUp'] == 3) {
            return json(error('权限不足'));
        }
        $where = [];
        if ($accountInfo['setUp'] == 4) {
            $where['userName'] = $accountInfo['name'];
        }
        $data_record  = $this->mod_record->get($where, $start, $ps);
        $count_record = $this->mod_record->count($where);

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
        $name     = '代理商跟进记录';
        setExcelTitleStyle($PHPSheet, 6);
        $PHPSheet->setCellValue("A1", "代理商名称")->setCellValue("B1", "沟通对象")->setCellValue("C1", "销售员")->setCellValue("D1", "标题")->setCellValue("E1", "内容")->setCellValue("F1", "时间");
        $PHPSheet->setTitle($name);
        if ($accountInfo['setUp'] == 4) {
            $data_agent = $this->mod->get(['belongUserId' => $accountInfo['name']]);
            $agentIds   = array_column(iterator_to_array($data_agent), 'id');
            $where      = ['customerId' => ['$in' => $agentIds]];
            $list_agent = [];
            foreach ($data_agent as $item) {
                $list_agent[$item['id']] = $item['name'];
            }
        }
        else {
            $where      = [];
            $data_agent = $this->mod->get();
            $list_agent = [];
            foreach ($data_agent as $item) {
                $list_agent[$item['id']] = $item['name'];
            }
        }
        $data = $this->mod_record->get($where, 0, 0, ['create' => -1]);
        $i    = 1;
        foreach ($data as $item) {
            $i++;
            $agentName = isset($list_agent[$item['customerId']]) ? $list_agent[$item['customerId']] : '';
            $PHPSheet->setCellValue("A$i", $agentName)->setCellValue("B$i", $item['customerName'])->setCellValue("C$i", $item['userName'])->setCellValue("D$i", $item['title'])->setCellValue("E$i", $item['remark'])->setCellValue("F$i", $item['time']);
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
}