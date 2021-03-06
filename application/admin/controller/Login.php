<?php
namespace app\admin\controller;

use \think\Controller;
use \think\Request;
use \think\Loader;
use \think\Db;
use \think\Session;

class Login extends Controller{
    public function index(){
        return $this->fetch();
    }
    public function login($username='',$password=''){
        if (Request::instance()->isPost()) { //判断是否是是否为 POST 请求
            $data = input('post.');
            $username = $data['username'];
            $password = md5($data['password']);
            //调用验证器
            $validate = Loader::validate('Login');
            $data = ['username' => $username, 'password' => $password];
            //验证是否符合验证器里定义(验证码)的规范,不符合返回错误信息
            if (!$validate->check($data)) {
                return alert($validate->getError(),'/admin/login',5,2);
            }
            //查询数据试库
            $where['username'] = $username;
            $where['is_admin'] = '是';
            $userInfo = Db::name('users')->where($where)->find();
            if ($userInfo && $userInfo['password'] === $password) {
                //登录成功写入session
                Session::set('admin_id',$userInfo['uid']);
                Session::set('admin_name',$userInfo['username']);
                return alert('登录成功！','/admin',6,2);
            } else {
                return alert('用户名或密码错误！','/admin/login',5,2);
            }
        } else {
            return $this->fetch('Admin/login/index');
        }
//        $this->success('新增成功', 'User/list');
//        $this->redirect('News/category', ['cate_id' => 2]);
//        $this->redirect('Admin/index/index');
    }
    
    public function loginOut(){
        Session::delete('admin_id');
        Session::delete('admin_name');
        return alert('退出成功！','/admin/login',6,2);
    }
}