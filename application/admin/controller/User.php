<?php
namespace app\admin\controller;

use \think\Db;
use \think\Request;

class User extends Auth
{
    public function adminList()
    {
        //获取总条数
//        $count = Db::name('users')->order('uid asc')->count();
        $users = Db::name('users')->where("is_admin= '是'")->order('uid asc')->paginate(10);
//        $this->assign('count',$count);
        $this->assign('users',$users);
        return $this->fetch();
    }
    
    public function userList()
    {
        return $this->fetch();
    }
}
