<?php
namespace app\admin\controller;

use \think\Db;
use \think\Request;

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
            $data['tagname'] = input('post.tagname');
            $map['tagname'] = $data['tagname'];
            $newTag =  Db::name('tag')->where($map)->find();
            if($newTag){
                $status = array(
                    'status'    => 0,
                    'message'   => '添加失败，标签已存在！',
                );
                return $status;
            }
            $re =  Db::name('tag')->insert($data);
            $tagId = Db::name('user')->getLastInsID();
            if($re || !empty($newTag)){
                $status = array(
                    'status'    => 1,
                    'tagId'     => $tagId,
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
    
    public function editStatus(){
        if(Request::instance()->isPost()){
            $id = input('post.id');
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
