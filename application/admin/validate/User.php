<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'  =>  'require|min:3|max:16',
        'password'  =>  'min:3|max:16',
        'email'     =>  'email',
        'phone'     =>  'number|length:11',
    ];
    
    protected $message = [
        'username.require'  => '用户名不能为空！',
        'username.min'      => '用户名不能少于3位！',
        'username.max'      => '用户名不能超过16位！',
        'password.min'      => '密码不能少于3位！',
        'password.max'      => '密码不能超过16位！',
        'email.email'       => '邮件格式错误！',
        'phone.number'      => '手机必须是数字！',
        'phone.length'      => '手机号长度必须为11位！',
    ];
}