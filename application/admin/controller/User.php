<?php
namespace app\admin\controller;

use \think\Db;
use \think\Request;
use \think\Loader;

class User extends Auth
{
    public function adminList()
    {
        if(Request::instance()->isGet()){
            $find = input('find');
            $map['username']=array('like','%'.$find.'%');
        }
        $map['is_admin']  = array('eq','是');
        $count = Db::name('users')->where($map)->count();
        $users = Db::name('users')->where($map)->order('uid asc')->paginate(10,false,['query'=>request()->param()]);
        $this->assign('count',$count);
        $this->assign('users',$users);
        return $this->fetch();
    }
    
    public function userList(){
        if(Request::instance()->isGet()){
            $find = input('find');
            $map['username']=array('like','%'.$find.'%');
        }
        $map['is_admin']  = array('eq','否');
        $count = Db::name('users')->where($map)->count();
        $users = Db::name('users')->where($map)->order('uid asc')->paginate(10,false,['query'=>request()->param()]);
        $this->assign('count',$count);
        $this->assign('users',$users);
        return $this->fetch();
    }
    
    public function add(){
        if(Request::instance()->isPost()){
            $data = input('post.');
            $map['username'] = $data['username'];
            $newUser =  Db::name('users')->where($map)->find();
            if($newUser){
                $status = array(
                    'status'    => 0,
                    'message'   => '添加失败，用户名已存在！',
                );
                return $status;
            }
            $validate = Loader::validate('User');
            if (!$validate->check($data)) {
                $status = array(
                    'status'    => 0,
                    'message'   => $validate->getError(),
                );
                return $status;
            }
            $data['password'] = md5($data['password']);
            $re =  Db::name('users')->insert($data);
            if($re){
                $status = array(
                    'status'    => 1,
                    'message'   => '用户添加成功！',
                );
            }else{
                $status = array(
                    'status'    => 0,
                    'message'   => '用户添加失败！',
                );
            }
            return $status;
        }else{
            return $this->fetch();
        }
    }
    
    public function edit(){
        if(Request::instance()->isPost()){
            $data = input('post.');
            $validate = Loader::validate('User');
            //验证是否符合验证器里定义(验证码)的规范,不符合返回错误信息
            if (!$validate->check($data)) {
                $status = array(
                    'status'    => 0,
                    'message'   => $validate->getError(),
                );
                return $status;
            }
            $re =  Db::name('users')->where('uid',$data['uid'])->update($data);
            if($re){
                $status = array(
                    'status'    => 1,
                    'message'   => '用户修改成功！',
                );
            }else{
                $status = array(
                    'status'    => 0,
                    'message'   => '用户修改失败！',
                );
            }
            return $status;
        }else{
            $uid = input('uid');
            $oldUser =  Db::name('users')->where("uid = $uid")->find();
            $this->assign('oldUser',$oldUser);
            return $this->fetch();
        }
    }
    
    public function editStatus(){
        if(Request::instance()->isPost()){
            $id = input('post.id');
            $map['uid'] = $id;
            $User =  Db::name('users')->where($map)->find();
            if($User['supper'] == '是'){
                $status = array(
                    'status'    => 0,
                    'message'   => '超级管理员无法进行此操作！',
                );
                return $status;
            }
            $status = input('post.status');
            $status == '正常' ? $lock = '锁定' : $lock =  '正常' ;
            $re =  Db::name('users')->where('uid',$id)->update(['is_lock' => $lock]);
            if($re){
                $status = array(
                    'status'    => 1,
                    'lock'      => $lock,
                    'cls'       => 'layui-form-onswitch',
                );
            }else{
                $status = array(
                    'status'    => 0,
                );
            }
            return $status;
        }
    }
    
    public function del(){
        if(Request::instance()->isPost()){
            $id = input('post.id');
            $re =  Db::name('users')->delete($id);
            if($re){
                $status = ['status'=>1];
            }else{
                $status = ['status'=>0];
            }
            return $status;
        }
    }
    
    public function delAll(Request $request){
        if(Request::instance()->isPost()){
            $ids = $_POST['ids'];
            $map['uid'] = array('in',$ids);
            $re =  Db::name('users')->where($map)->delete();
            if($re){
                $status = ['status'=>1];
            }else{
                $status = ['status'=>0];
            }
            return $status;
        }
    }
}
