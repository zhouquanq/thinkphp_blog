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
        $this->assign('count',$count);
        
        return $this->fetch();
    }
    
    public function categoryData(){
        $count = Db::name('category')->count();
        $category = Db::name('category')->order('cid asc')->select();
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
    
    public function del(){
        if(Request::instance()->isPost()){
            $id = input('post.id');
            $map['pid'] = $id;
            $find =  Db::name('category')->where($map)->find();
            if($find){
                $status = array(
                    'status'    => 0,
                    'message'   => '删除失败，请先删除子分类！',
                );
                return $status;
            }
            $re =  Db::name('category')->delete($id);
            if($re){
                $status = array(
                    'status' => 1,
                    'message'   => '删除成功！',
                );
            }else{
                $status = array(
                    'status' => 0,
                    'message'   => '删除失败！',
                );
            }
            return $status;
        }
    }
    
    public function cateEdit(){
        if(Request::instance()->isPost()){
            $where['cname'] = array('eq',input('post.cname'));
            $where['cid'] = array('neq',input('post.cid'));
            $find =  Db::name('category')->where($where)->find();
            $map['cid'] = input('post.cid');
            $map['cname'] = input('post.cname');
            $map['csort'] = input('post.csort');
            $map['is_show'] = input('post.is_show');
            if($find){
                $status = array(
                    'status'    => 0,
                    'message'   => '修改失败，分类已存在！',
                );
                return $status;
            }
            
            $re =  Db::name('category')->update($map);
            if($re){
                $status = array(
                    'status'    => 1,
                    'message'   => '修改成功',
                );
            }else{
                $status = array(
                    'status'    => 0,
                    'message'   => '修改失败',
                );
            }
            return $status;
        }else{
            $id = input('id');
            $allCate =  Db::name('category')->select();
            $oldCate =  Db::name('category')->where("cid = $id")->find();
            $this->assign('allCate',$allCate);
            $this->assign('oldCate',$oldCate);
            return $this->fetch();
        }
    }
}
