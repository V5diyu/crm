<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/3/13
 * Time: 12:21
 */

namespace app\admin\controller;

use think\Request;

class Invoice extends Base
{
    private $mod;
    public function __construct ()
    {
        //parent::__construct($request);
        $this->mod = new \InvoiceDB();
    }

    public function get ()
    {
        //
        return json(ok());
    }
}
