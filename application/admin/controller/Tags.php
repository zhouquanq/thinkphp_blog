<?php
namespace app\admin\controller;

use \think\Db;
use \think\Request;
use \think\Loader;

class Tags extends Auth
{
    public function tagList()
    {
        $tags = Db::name('tag')->order('tid asc')->paginate(10);
        $this->assign('tags',$tags);
        return $this->fetch();
    }
    
    public function add(){
        if(Request::instance()->isPost()){
            $data['tagname'] = input('post.tagname');
            $re =  Db::name('tag')->insert($data);
            $tagId = Db::name('user')->getLastInsID();
            if($re){
                $status = array(
                    'status'    => 1,
                    'tagId'     => $tagId,
                );
            }else{
                $status = ['status'=>0];
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
    
    public function delAll(Request $request , $ids=''){
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
}
