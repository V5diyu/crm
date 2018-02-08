<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/19
 * Time: 下午4:59
 */

namespace app\api\controller;


use think\Loader;

class Invoice extends Base
{
    private $mod;


    public function __construct()
    {
        $this->mod = new \InvoiceDB();
    }

    public function operationSubmit()
    {
        Loader::import('dingdingSDK/TopSdk');
        $userId     = input('userId');          //用户id
        $department = input('department');      //部门id
        $approvers  = input('approvers');       //审批人userid列表  如zhangsan,lisi
        $cc_list    = input('cc_list', '');     //抄送人userid列表   如zhangsan,lisi
        if (empty($userId) || empty($department) || empty($approvers)) {
            return json(error('缺少必要的参数'));
        }

        $sqr    = input('sqr');             //申请人
        $sqsj   = date('Y-m-d H:i');        //申请时间
        $ddbh   = input('ddbh');            //订单编号
        $khmc   = input('khmc');            //客户名称
        $ybnsr  = input('ybnsr');           //一般纳税人
        $edlx   = input('edlx');            //额度类型
        $ddje   = input('ddje');            //订单金额
        $fkqk   = input('fkqk');            //付款情况
        $cnfh   = input('cnfh');            //出纳复核
        $fhqk   = input('fhqk');            //发货情况
        $fplx   = input('fplx');            //发票类型
        $qtyq   = input('qtyq');            //其他要求
        $mc     = input('mc');              //名称
        $nsrsbh = input('nsrsbh');          //纳税人识别号
        $dz     = input('dz');              //地址
        $dh     = input('dh');              //电话
        $khh    = input('khh');             //开户行
        $zh     = input('zh');              //账号
        $kddz   = input('kddz');            //快递地址

        $config = config('dingding');
        $c      = new \DingTalkClient;
        $req    = new \SmartworkBpmsProcessinstanceCreateRequest;
        $req->setAgentId($config['agentId']);
        $req->setProcessCode($config['processCode']);
        $req->setOriginatorUserId($userId);
        $req->setDeptId($department);
        $req->setApprovers($approvers);
        $req->setCcList($cc_list);
        $req->setCcPosition("START_FINISH");
        $form = [
            [
                'name'  => '申请人',
                'value' => $sqr,
            ],
            [
                'name'  => '申请时间',
                'value' => $sqsj,
            ],
            [
                'name'  => '订单编号',
                'value' => $ddbh,
            ],
            [
                'name'  => '客户名称',
                'value' => $khmc,
            ],
            [
                'name'  => '一般纳税人',
                'value' => $ybnsr,
            ],
            [
                'name'  => '额度类型',
                'value' => $edlx,
            ],
            [
                'name'  => '订单金额',
                'value' => $ddje,
            ],
            [
                'name'  => '付款情况',
                'value' => $fkqk,
            ],
            [
                'name'  => '出纳复核',
                'value' => $cnfh,
            ],
            [
                'name'  => '发货情况',
                'value' => $fhqk,
            ],
            [
                'name'  => '发票类型',
                'value' => $fplx,
            ],
            [
                'name'  => '其他要求',
                'value' => $qtyq,
            ],
            [
                'name'  => '名称',
                'value' => $mc,
            ],
            [
                'name'  => '纳税人识别号',
                'value' => $nsrsbh,
            ],
            [
                'name'  => '地址',
                'value' => $dz,
            ],
            [
                'name'  => '电话',
                'value' => $dh,
            ],
            [
                'name'  => '开户行',
                'value' => $khh,
            ],
            [
                'name'  => '账号',
                'value' => $zh,
            ],
            [
                'name'  => '快递地址',
                'value' => $kddz,
            ],
        ];
        $req->setFormComponentValues(json_encode($form));
        $result = $c->execute($req, $this->getAccessToken());
        $result = json_decode(json_encode($result), true);
        if (isset($result['msg'])) {
            return json(error($result['msg']));
        }
        $insertData = [
            'userId'     => $userId,
            'department' => $department,
            'approvers'  => $approvers,
            'cc_list'    => $cc_list,
            'sqr'        => $sqr,
            'sqsj'       => $sqsj,
            'ddbh'       => $ddbh,
            'khmc'       => $khmc,
            'ybnsr'      => $ybnsr,
            'edlx'       => $edlx,
            'ddje'       => $ddje,
            'fkqk'       => $fkqk,
            'cnfh'       => $cnfh,
            'fhqk'       => $fhqk,
            'fplx'       => $fplx,
            'qtyq'       => $qtyq,
            'mc'         => $mc,
            'nsrsbh'     => $nsrsbh,
            'dz'         => $dz,
            'dh'         => $dh,
            'khh'        => $khh,
            'zh'         => $zh,
            'kddz'       => $kddz,
            'status'     => 0,
            'create'     => time()
        ];
        $this->mod->add($insertData);
        return json(ok());
    }

    public function get()
    {
        $userId = input('userId');
        $khmc   = input('khmc');
        $pn     = input('pn/d', 1);
        $ps     = 15;
        $start  = ($pn - 1) * $ps;
        if (empty($userId)) {
            return json(error('缺少必要的参数'));
        }
        $where = ['userId' => $userId];
        if (!empty($khmc)) {
            $where['khmc'] = ['$regex' => $khmc, '$options' => 'i'];
        }
        $data = $this->mod->get($where, $start, $ps);
        $list = [];
        foreach ($data as $item) {
            $list[] = [
                'id'     => $item['id'],
                'khmc'   => $item['khmc'],
                'fplx'   => $item['fplx'],
                'sqsj'   => $item['sqsj'],
                'status' => $item['status'],
            ];
        }
        return json(ok($list));
    }

    public function registerCallBack()
    {
        $access_token = $this->getAccessToken();
        $url          = config('dingding.apiUrl') . '/call_back/register_call_back?access_token=' . $access_token;
        $data         = [
            'call_back_tag' => ['bpms_instance_change'],
            'token'         => 'tglh',
            'aes_key'       => randstr(43, 4),
            'url'           => 'http://twelve.ylyedu.com/api/invoice/callBack'
        ];
        return postHttpRequestJson($url, json_encode($data));
    }

    public function callBack()
    {
        $data = input();
        $con  = mdb()->test;
        $con->insert($data);

        //        $res = [
        //            'msg_signature' => $data['signature'],
        //            'timeStamp'     => $data['timeStamp'],
        //            'nonce'         => $data['nonce'],
        //            'encrypt'       => '1ojQf0NSvw2WPvW7LijxS8UvISr8pdDP+rXpPbcLGOmIBNbWetRg7IP0vdhVgkVwSoZBJeQwY2zhROsJq/HJ+q6tp1qhl9L1+ccC9ZjKs1wV5bmA9NoAWQiZ+7MpzQVq+j74rJQljdVyBdI/dGOvsnBSCxCVW0ISWX0vn9lYTuuHSoaxwCGylH9xRhYHL9bRDskBc7bO0FseHQQasdfghjkl'
        //        ];
        $res               = [
            'msg_signature' => '595fab532aef4a80f68d14e61d01210189d3f579',
            'timeStamp'     => '1509015355346',
            'nonce'         => 'brmSDJS4',
            'encrypt'       => '1ojQf0NSvw2WPvW7LijxS8UvISr8pdDP+rXpPbcLGOmIBNbWetRg7IP0vdhVgkVwSoZBJeQwY2zhROsJq/HJ+q6tp1qhl9L1+ccC9ZjKs1wV5bmA9NoAWQiZ+7MpzQVq+j74rJQljdVyBdI/dGOvsnBSCxCVW0ISWX0vn9lYTuuHSoaxwCGylH9xRhYHL9bRDskBc7bO0FseHQQasdfghjkl'
        ];
        $res               = [
            'token'       => 'tglh',
            'timestamp'   => input('timestamp'),
            'nonce'       => input('nonce'),
            'msg_encrypt' => 'success'
        ];
        $dev_msg_signature = sha1(sort($res));
        return json($data);
    }


}