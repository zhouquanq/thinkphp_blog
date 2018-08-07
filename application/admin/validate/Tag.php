<?php
namespace app\admin\validate;

use think\Validate;

class Tag extends Validate
{
    protected $rule = [
        'tagname'  =>  'require|max:10',
    ];
    
    protected $message = [
        'tagname.require'  => '标签名不能为空！',
        'tagname.max'      => '标签名不能超过10位！',
    ];
}