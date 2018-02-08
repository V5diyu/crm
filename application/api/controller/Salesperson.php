<?php
/**
 * Created by PhpStorm.
 * User: luotao
 * Date: 2017/10/17
 * Time: 上午11:47
 */

namespace app\api\controller;


class Salesperson extends Base
{
    private $mod;

    public function __construct()
    {
        $this->mod = new \SalespersonDB();
    }

    public function getUserInfo()
    {
        $code = input('code');
        if (empty($code)) {
            return json(error('缺少必要的参数'));
        }
        $token    = $this->getAccessToken();
        $getUrl   = config('dingding.apiUrl') . '/user/getuserinfo?access_token=' . $token . '&code=' . $code;
        $res      = json_decode(getHttpRequest($getUrl), true);
        $userid   = $res['userid'];
        $getUrl   = config('dingding.apiUrl') . '/user/get?access_token=' . $token . '&userid=' . $userid;
        $userInfo = json_decode(getHttpRequest($getUrl), true);
        $info     = $this->mod->getInfo(['userId' => $userInfo['userid']]);
        if (empty($info)) {
            $insertData = [
                'userId'                => $userInfo['userid'],
                //用户id
                'department'            => '',
                //部门
                'position'              => isset($userInfo['position']) ? $userInfo['position'] : '',
                //职位
                'name'                  => $userInfo['name'],
                //姓名
                'avatar'                => $userInfo['avatar'],
                //头像
                'jobNumber'             => isset($userInfo['jobnumber']) ? $userInfo['jobnumber'] : '',
                //工号
                'isDirector'            => '',
                //是否主管
                'phone'                 => $userInfo['mobile'],
                //手机号
                'mail'                  => isset($userInfo['email']) ? $userInfo['email'] : '',
                //邮箱
                'extensionNumber'       => isset($userInfo['tel']) ? $userInfo['tel'] : '',
                //分机号码
                'officeLocation'        => isset($userInfo['workPlace']) ? $userInfo['workPlace'] : '',
                //办公地点
                'remarks'               => isset($userInfo['remark']) ? $userInfo['remark'] : '',
                //备注
                'entryTime'             => '',
                //入职时间
                'myContractVolume'      => 0,
                'companyContractVolume' => 0,
                'myReturnAmount'        => 0,
                'myReceivables'         => 0,
                'data'                  => $userInfo,
                'create'                => time(),
                //创建时间
            ];
            $this->mod->add($insertData);
        }
        else {
            $setData = [
                'position'        => isset($userInfo['position']) ? $userInfo['position'] : '',             //职位
                'name'            => $userInfo['name'],                                                     //姓名
                'avatar'          => $userInfo['avatar'],                                                   //头像
                'jobNumber'       => isset($userInfo['jobnumber']) ? $userInfo['jobnumber'] : '',           //工号
                'phone'           => $userInfo['mobile'],                                                   //手机号
                'mail'            => isset($userInfo['email']) ? $userInfo['email'] : '',                   //邮箱
                'extensionNumber' => isset($userInfo['tel']) ? $userInfo['tel'] : '',                       //分机号码
                'officeLocation'  => isset($userInfo['workPlace']) ? $userInfo['workPlace'] : '',           //办公地点
                'remarks'         => isset($userInfo['remark']) ? $userInfo['remark'] : '',                 //备注
                'data'            => $userInfo,
            ];
            $this->mod->update($setData, ['userId' => $userInfo['userid']]);
        }
        return json(ok($userInfo));
    }

}