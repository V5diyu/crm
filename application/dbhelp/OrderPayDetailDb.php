<?php

class OrderPayDetailDb
{
    protected $con;

    public function __construct()
    {
        $this->con = mdb()->orderPayDetail;
    }

    public function get ($where = [], $skip = 0, $limit = 0, $sort = ['_id' => -1], $fields = ['_id' => false])
    {
        if ($limit == 0) {
            return $this->con->find($where)->fields($fields)->sort($sort);
        }
        return $this->con->find($where)->fields($fields)->sort($sort)->skip($skip)->limit($limit);
    }

    public function batchInsert($data)
    {
        $this->con->batchInsert($data);
    }

    public function count($where = [])
    {
        return $this->con->count($where);
    }

    public function update($setData, $where)
    {
        if (!is_array($where)) {
            $where = ['id' => $where];
        }
        $this->con->update($where, ['$set' => $setData]);
    }

    public function delete($where)
    {
        if (!is_array($where)) {
            $where = ['id' => $where];
        }
        $this->con->remove($where);
    }
}