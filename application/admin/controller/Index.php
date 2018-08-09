<?php
namespace app\admin\controller;

use \think\Session;

class Index extends Auth
{
    public function index()
    {
        return $this->fetch();
    }
    
    public function welCome()
    {
        $info = array(
            'serverPath'    => GetHostByName($_SERVER['SERVER_NAME']),
            'serverOS'      => PHP_OS,
            'phpVersion'    => PHP_VERSION,
            'webServer'   => php_sapi_name(),
            'tpVersion' => THINK_VERSION,
        );
//        p($info);
        $this->assign('info',$info);
        return $this->fetch();
    }
}
