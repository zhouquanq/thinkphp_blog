<?php
namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'username'  =>  'require|min:3',
        'password' =>  'require',
    ];
    
}