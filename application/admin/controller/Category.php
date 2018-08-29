<?php
namespace app\admin\controller;

use \think\Db;

class Category extends Auth
{
    public function index()
    {

    	//获取总条数
        // $count = Db::name('category')->order('tid asc')->count();
        // $category = Db::name('category')->order('cid asc')->paginate(10);
        $category = Db::name('category')->order('cid asc')->select();
        $data=$this->getTree($category);
//        p($res);
        // $this->assign('count',$count);
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    //无限极递归
    public function getTree($data,$pid=0,$level=0){
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
}
