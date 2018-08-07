<?php
namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'username'  =>  'require|min:3',
        'password' =>  'require',
    ];
    
    protected $message = [
        'username.require'  => '用户名不能为空！',
        'username.min'      => '用户名不能少于3位！',
        'password.require'  => '密码不能为空！',
    ];
}