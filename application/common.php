<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//打印函数
function p($data){
    echo "<pre style='font-size:14px;padding:10px 20px;background:#FFB7DD'>";
    print_r($data);
    echo "</pre>";
}

//基于layui修改提示消息美化
function alert($msg='',$url='',$icon='',$time=3){
    $str='<script type="text/javascript" src="'.config('admin_static').'/script/js/jquery.min.js"></script><script type="text/javascript" src="'.config('admin_static').'/script/lib/layui/layui.js"></script>';//加载jquery和layui
    $str.='<script>$(layui.use(\'layer\', function(){layer.msg("'.$msg.'",{icon:'.$icon.',time:'.($time*1000).'}, function(){location.href="'.$url.'"})}));</script>';//主要方法
    return $str;
}

//无限级分类递归
function getTree($data,$pid=0,$level=0){
    static $arr=array();
    foreach($data as $key=>$value){
        if($value['pid'] == $pid){
            $value['level']=$level;     //用来作为在模版进行层级的区分
            $arr[] = $value;            //把内容存进去
            $this->getTree($data,$value['cid'],$level+1);    //回调进行无线递归
        }
    }
    return $arr;
}