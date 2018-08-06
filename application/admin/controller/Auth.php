<?php
namespace app\admin\controller;

use \think\Controller;
use \think\Session;

class Auth extends controller
{
    public function _initialize()
    {
        if(!Session::has('admin_id') || !Session::has('admin_name')){
            $this->error('非法登录，信不信打死你！','Admin/login/index');
        }
    }
}
