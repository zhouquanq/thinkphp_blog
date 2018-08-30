<?php
namespace app\admin\controller;

use \think\Db;
use \think\Request;

class Category extends Auth
{
    public function index()
    {

    	//获取总条数
         $count = Db::name('category')->count();
//        $category = Db::name('category')->order('cid asc')->paginate(10);
//        $category = Db::name('category')->order('cid asc')->select();
//        $data=$this->getTree($category);
//        $this->assign('data',$data);
        $this->assign('count',$count);
        
        return $this->fetch();
    }
    
    public function categoryData(){
        $count = Db::name('category')->count();
        $category = Db::name('category')->select();
        $data['code'] = 0;
        $data['msg'] = 'ok';
        $data['data'] = $category;
        return json($data);
    }
    
    public function addTopCate(){
        if(Request::instance()->isPost()){
            $data['cname'] = input('post.cname');
            $data['csort'] = input('post.csort');
            $data['is_show'] = input('post.is_show');
            $map['cname'] = $data['cname'];
            $newCate =  Db::name('category')->where($map)->find();
            if($newCate){
                $status = array(
                    'status'    => 0,
                    'message'   => '添加失败，分类已存在！',
                );
                return $status;
            }
            $re =  Db::name('category')->insert($data);
            if($re){
                $status = array(
                    'status'    => 1,
                    'message'   => '添加成功',
                );
            }else{
                $status = array(
                    'status'    => 0,
                    'message'   => '添加失败',
                );
            }
            return $status;
        }else{
            return $this->fetch();
        }
    }
    
    //无限极递归
//    public function getTree($data,$pid=0,$level=0){
//        static $arr=array();
//        foreach($data as $key=>$value){
//            if($value['pid'] == $pid){
//                $value['level']=$level;     //用来作为在模版进行层级的区分
//                $arr[] = $value;            //把内容存进去
//                $this->getTree($data,$value['cid'],$level+1);    //回调进行无线递归
//            }
//        }
//        return $arr;
//    }
}
