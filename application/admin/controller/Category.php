<?php
namespace app\admin\controller;

use \think\Session;

class Category extends Auth
{
    public function index()
    {
        return $this->fetch();
    }

}
