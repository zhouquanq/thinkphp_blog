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
        $users = Db::name('users')->where($map)->order('uid asc')->paginate(10,false,['query'=>request()->param()]);
        $this->assign('users',$users);
        return $this->fetch();
    }
    
    public function userList(){
        return $this->fetch();
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
