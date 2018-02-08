<?php

class AdminUserDB
{

    private $con;

    public function __construct()
    {
        $this->con = mdb()->admin_user;
    }

    public function add($inserData)
    {
        $data = $this->con->findOne(['account' => $inserData['account']]);
        if (empty($data)) {
            $inserData = array_merge(['id' => uniqueID()], $inserData);
            $this->con->insert($inserData);
        }
    }

    public function checkPwd($account, $pwd)
    {
        $data = $this->con->findOne(['account' => $account]);
        if (empty($data)) {
            return false;
        }
        if ($data['pwd'] != md5(md5($pwd))) {
            return false;
        }
        return [
            'id'      => $data['id'],
            'account' => $data['account'],
            'name'    => $data['name'],
            'power'   => $data['power'],
            'setUp'   => $data['setUp']
        ];
    }

    public function get($where = [], $fields = [])
    {
        return $this->con->find($where, ['details' => false])->fields($fields)->sort(['_id' => -1]);
    }

    public function getInfo($id)
    {
        return $this->con->findOne(['id' => $id]);
    }

    public function update($setData, $id)
    {
        $this->con->update(['id' => $id], ['$set' => $setData]);
    }

    public function delete($id)
    {
        $this->con->remove(['id' => $id]);
    }
}