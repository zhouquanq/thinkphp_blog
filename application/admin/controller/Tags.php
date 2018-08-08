<?php
namespace app\admin\controller;

use \think\Db;
use \think\Request;

class Tags extends Auth
{
    public function index(){
        //获取总条数
        $count = Db::name('tag')->order('tid asc')->count();
        $tags = Db::name('tag')->order('tid asc')->paginate(10);
        $this->assign('count',$count);
        $this->assign('tags',$tags);
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
        }
    }
    
    public function del(){
        if(Request::instance()->isPost()){
            $id = input('post.id');
            $re =  Db::name('tag')->delete($id);
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
            $ids = $_POST['tids'];
            $map['tid'] = array('in',$ids);
            $re =  Db::name('tag')->where($map)->delete();
            if($re){
                $status = ['status'=>1];
            }else{
                $status = ['status'=>0];
            }
            return $status;
        }
    }
    
    public function edit(Request $request , $id=0){
        if(Request::instance()->isPost()){
            $tid = input('post.tid');
            $tagName = input('post.tagName');
            $re =  Db::name('tag')->where('tid',$tid)->update(['tagname' => $tagName]);
            if($re){
                $status = ['status'=>1];
            }else{
                $status = ['status'=>0];
            }
            return $status;
        }else{
            $tid = input('tid');
            $oldTag =  Db::name('tag')->where("tid = $tid")->find();
            $this->assign('oldTag',$oldTag);
            return $this->fetch();
        }
    }
}
