<?php
namespace Back\Controller;
use Think\Controller;
use Think\Verify;
class IndexController extends Controller {

    public function index(){
        $this->display("Login/login");
    }

    public function login(){
        if(IS_AJAX){
            $type = I("post.userType");
            switch ($type) {
            	case 'teacher':
            		$data['tPhone'] = I('post.userName');
            		$tPwd1 = md5(I('post.password'));
            		$teacher = M('teacher');
            	    $count = $teacher->where($data)->getField('tPwd');;
            	    if($count === $tPwd1){
            	    	session('tPhone',$data['tPhone']);
            	    	$this->ajaxReturn("teacherOk");
            	    }
            	    $this->ajaxReturn("teacherNo");
            		break;
            	case 'admin':
            	    $data['aName'] = I('post.userName');
            		$aPwd1 = md5(I('post.password'));
            		$admin = M('admin');
            		$count = $admin->where($data)->getField('aPwd');
            		if($count === $aPwd1){
            			session('aName',$data['aName']);
                        $this->ajaxReturn("adminOk");
            		}
            		$this->ajaxReturn("adminNo");
            	    break;
            	default:
            		$this->ajaxReturn("no");
            }
        }
    	 
    }

    public function checkyzm(){
        $Verify = new Verify;
        if( $Verify->check($_POST['yzm'])){
        	$this->ajaxReturn("yzmok");
        }
        else{
        	$this->ajaxReturn("yzmno");
        }
      //  return $Verify->check($yzm);
    }

    public function yzm(){
        ob_clean();
        $verify=new Verify();  //创建验证码
        $verify->length=4;     //验证码的长度
        $verify->fontSize=16;  //验证码字体的大小
        $verify->useNoise = false;  //是否有污点
        //$verify->useCurve = false; //曲线的混淆
        $verify->codeSet="0123456789";
        $verify->entry();  //生成
    }

     public function login_out(){
        session('[destroy]');
        $this->redirect('./index/');
    } 


}