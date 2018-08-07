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
        return $this->fetch();
    }
}
