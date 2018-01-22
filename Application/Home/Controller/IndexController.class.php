<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
         //展示最新的5条消息
         $notice = M('Notice');
         $list = $notice->limit('5')->order('ndate desc')->select();
         modifyDate($list);
         //dump($list); exit;
         $this->assign('list',$list);
         $this->display('Login/login');
    }

    public function login(){
    	if(IS_AJAX){
    		 $sId = I('post.sId');
    		 $sPwd = md5(I('post.sPwd'));
    		 $data['sId'] = $sId;
    		 $student = M('Student');
    		 $pwd = $student->where($data)->getField('sPwd');
    		 if($sPwd === $pwd){
                 session('sId',$sId);
    		     $this->ajaxReturn("ok");
    		 }
    		 else{
                 $this->ajaxReturn('no');
    		 }
    	}

    }

     public function notice(){
         $notice = M('Notice');
         $list = $notice->order('ndate desc')->select();
         modifyDate($list);
         //dump($list); exit;
         $this->assign('list',$list);
        $this->display('Student/notice');
    }

    public function login_out(){
        session('[destroy]');
        $this->redirect('./index/');
    } 

}