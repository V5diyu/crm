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

    }

    public function getInfo ()
    {

    }
}