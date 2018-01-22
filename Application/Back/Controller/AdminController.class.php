<?php
namespace Back\Controller;
use Think\Controller;
use Think\Upload;

class AdminController extends CheckAdminController {
     
    //searchMessage
    public function index($page=1){
    	if(IS_POST){
    		$search = I('post.search');
    	}
    	$data['nPerson'] = session('aName');
    	$num = 8;  //一页多少条
    	$notice = M('Notice');  
    	if(empty($search)){
    		 $count = $notice->where($data)->count('nId'); //总条数
    		 $list = $notice->where($data)->page($page,$num)->order('ndate desc')->select();
    	}
    	else{
    		 $data['nTitle'] = array('like','%'.$search.'%');
    		 $count = $notice->where($data)->count('nId'); //总条数
         $num = $count;
    		 $list = $notice->where($data)->page($page,$num)->order('ndate desc')->select();
    	}
    	 $pageCount = ceil($count/$num); //总页数
         if($page>$pageCount) $page=1;	 //防止出现list为空的情况
    	$this->assign('list',$list);
    	$this->assign('pageCount',$pageCount);
    	$this->assign('page',$page);
    	$this->assign('empty', '<span style="color:#ce0f4b;display:block;width:100%;" class="text-center">没有任何数据</span>');
        $this->display("Admin/searchMessage");
    }

    public function sendMessage(){
    	if(IS_POST){
    		$data['nTitle'] = I('post.nTitle');
    		$data['nContent'] = I('post.nContent','',false);
    		$data['nPerson'] = session('aName');
    		$data['ndate'] = date("Y-m-d H:i:s");
            
            $notice = M('Notice');
            $res = $notice->add($data);
            if($res < 1){
            	 $this->error("发布失败！");
            }
            else{
              $this->success("发布成功！");
            }
    	  }
        else{
           $this->display('Admin/sendMessage');
        }
       
    }

    public function deleteMessage(){
         $data['nId'] = I('get.nId');
         $notice = M('Notice');
         $res = $notice->where($data)->delete();
         if($res === 1){
         	  $this->redirect("Admin/index");
         }
         else{
           	$this->error("删除失败！");
         }
    }

     public function updateMessage(){
     	 $notice = M('Notice');
     	 if(IS_GET){
     	 	 $data['nId'] = I('get.nId');
     	 	 $arr = $notice->where($data)->find();
             $this->assign('list',$arr);
             $this->display();
     	 }
     	 else{
             $data['nTitle'] = I('post.nTitle');
             $data['nId'] = I('post.nId');
    		 $data['nContent'] = I('post.nContent','',false);
    		 $res = $notice->save($data);
            if($res === false){
            	$this->error("发布失败！");
            }
            $this->redirect("Admin/index");
     	 }
    	
    }

    public function addStudent(){
       if(IS_AJAX){
       	     $data['sId'] = I('post.sId');
       	     $student = M('Student');
       	     $res = $student->where($data)->count();
       	     $this->ajaxReturn($res);
             
       }
       else if(IS_POST){
        	$student = M('Student');
        	$data = $student->create();
        	$data['sPwd'] = md5(getPassword($data['sId']));
        	$res = $student->add($data);
        	if($res != 1){
        		$this->error("添加失败！");
        	}
        	else{
        		echo "<script>alert('添加成功！');</script>";
        	}

       }
        $this->display('Admin/addStudent');
    	 
    }

    public function sInfo($page=1){
    	if(IS_POST){
    			$search = I('post.sId');
    	}
    	$num = 8;  //一页多少条
    	$student = M('Student');
    	if(empty($search)){
    		  $count = $student->count('sId'); //总条数
    		  $list = $student->page($page,$num)->order('sId asc')->select();
    	}
    	else{
    		  $data['sId'] = $search;
    		  $count = $student->where($data)->count('sId'); //总条数
           $num = $count;
    		 $list = $student->where($data)->page($page,$num)->order('sId asc')->select();
    	}
    	$pageCount = ceil($count/$num); //总页数
    	if($page>$pageCount) $page=1;	 //防止出现list为空的情况
    	$this->assign('list',$list);
    	$this->assign('pageCount',$pageCount);
    	$this->assign('page',$page);
    	$this->assign('empty', '');
        $this->display('Admin/sInfo');
    }

    public function delStudent(){
         $data['sId'] = I('get.sId');
         $student = M('student');
         $res = $student->where($data)->delete();
         if($res == 1){
         	  $this->redirect("Admin/sInfo");
         }
         else{
         	$this->error("删除失败！");
         }
    }

     public function updStudent(){
     	 $student = M('student');
     	 if(IS_GET){
     	 	 $data['sId'] = I('get.sId');
     	 	 $arr = $student->where($data)->find();
             $this->assign('list',$arr);
             $this->display();
     	 }
       else if(IS_AJAX){
       	     $data['sId'] = I('post.sId');
       	     $res = $student->where($data)->count();
       	     $this->ajaxReturn($res);
             
       }
       else if(IS_POST){
        	$data = $student->create();
        	$res = $student->save($data);
        	if($res === false){
        		$this->error("修改失败！");
        	}
        	else{
              $this->redirect("Admin/sInfo");
        	}
       }
   }

    public function resetStudent(){
         $student = M('student');
     	 if(IS_GET){
     	 	 $data['sId'] = I('get.sId');
         $data['sPwd'] = md5(getPassword($data['sId']));
     	 	 $arr = $student->save($data);
     	 	 if($arr === false){
     	 	        $this->error("密码初始失败！");
     	 	 }
     	 	 else{
             $this->success("密码初始成功！");
     	 	 }
             
     	 }
    }

    public function addTeacher(){
    	 if(IS_AJAX){
       	     $data['tPhone'] = I('post.tPhone');
       	     $teacher = M('Teacher');
       	     $res = $teacher->where($data)->count();
       	     $this->ajaxReturn($res);
             
        }
    	else if(IS_POST){
        	$teacher = M('Teacher');
        	$data = $teacher->create();
        	$data['tPwd'] = md5(getPassword($data['tPhone']));
        	$res = $teacher->add($data);
        	if($res < 1){
        		$this->error("添加失败！");
        	}
        	else{
        		echo "<script>alert('添加成功！');</script>";
        	}

       }
    	$this->display('Admin/addTeacher');
    }

    public function tInfo($page=1){
    	if(IS_POST){
    			$search = I('post.tName');
    	}
    	$num = 8;  //一页多少条
    	$teacher = M('Teacher');
    	if(empty($search)){
    		 $count = $teacher->count('tId'); //总条数
    		 $list = $teacher->page($page,$num)->order('tId desc')->select();
    	}
    	else{
    		  $data['tName'] = $search;
    		  $count = $teacher->where($data)->count('tId'); //总条数
          $num = $count;
    		  $list = $teacher->where($data)->page($page,$num)->order('tId desc')->select();
    	}
    	$pageCount = ceil($count/$num); //总页数
    	if($page>$pageCount) $page=1;	 //防止出现list为空的情况
    	$this->assign('list',$list);
    	$this->assign('pageCount',$pageCount);
    	$this->assign('page',$page);
    	$this->assign('empty', '');
        $this->display('Admin/tInfo');
    }

    public function updTeacher(){
    	$teacher = M('Teacher');
    	if(IS_GET){
     	 	 $data['tId'] = I('get.tId');
     	 	 $arr = $teacher->where($data)->find();
             $this->assign('list',$arr);
             $this->display();
     	 }
       else if(IS_AJAX){
       	     $data['tPhone'] = I('post.tPhone');
       	     $res = $teacher->where($data)->count();
       	     $this->ajaxReturn($res);
       }
       else if(IS_POST){
        	$data = $teacher->create();
       //  dump($data); exit;
        	$res = $teacher->save($data);
        	if($res === false){
        		$this->error("修改失败！");
        	}
        	else{
                $this->redirect("Admin/tInfo");
        	}
       }
   
    }

    public function delTeacher(){
    	 $data['tId'] = I('get.tId');
    	 $teacher = M('Teacher');
         $res = $teacher->where($data)->delete();
         if($res === 1){
         	  $this->redirect("Admin/tInfo");
         }
         else{
         	$this->error("删除失败！");
         }

    }

    public function resetTeacher(){
    	 $teacher = M('Teacher');
         if(IS_GET){
     	 	  $data['tId'] = I('get.tId');
          $data['tPhone'] = $teacher->where($data)->getField('tPhone');
          $data['tPwd'] = md5(getPassword($data['tPhone']));
     	 	 $arr = $teacher->save($data);
     	 	 if($arr !== false){
     	 	 	 $this->success("密码初始成功！");
     	 	 }
     	 	 else{
     	 	 	$this->error("密码初始失败！");
     	 	 }
             
     	 }
    }

    public function classManage($page=1){
    	if(IS_AJAX){
    		 $data['cName'] = I('post.cName');
    		 $course = M('Course');
    		 $res = $course->where($data)->count();
    		 if($res > 0){
    		 	  $this->ajaxReturn("repeat");
    		 }
    		 else{
    		 	 $data['cdate'] = date("Y-m-d H-i-s");
    		 	 $list = $course->data($data)->add();
    		 	 if($list < 1){
    		 	 	$this->ajaxReturn("fail");
    		 	 }
    		 	 else{
    		 	 	 $this->ajaxReturn("ok");
    		 	 }

    		 }
    	}
    	
    	$num = 8;  //一页多少条
    	$course = M('Course');
    	$count = $course->count('cId'); //总条数
    	$pageCount = ceil($count/$num); //总页数
    	if($page>$pageCount) $page=1;	 //防止出现list为空的情况	
        $list = $course->page($page,$num)->order('cId desc')->select();
    	$this->assign('list',$list);
    	$this->assign('pageCount',$pageCount);
    	$this->assign('page',$page);
        $this->display('Admin/classManage');
    	
    }

    public function delCourse(){
    	 $course = M('Course');
    	 if(IS_GET){
    	 	 $data['cId'] = I('get.cId');
    	 	 $res = $course->where($data)->delete();
    	 	 if($res === 1){
    	 	 	$this->redirect("Admin/classManage");
    	 	 }
    	 	 else{
    	 	 	$this->error("删除失败！");
    	 	 }

    	 }
    }

    public function uploadStudent(){
        $upload = new Upload();
        $filePath = "./Public/Upload/";
        $fileDir = "dataModal";
        if(!file_exists($filePath)){
            mkdir($filePath);
        }
        if(!file_exists($filePath.$fileDir)){
            mkdir($filePath.$fileDir);
        }
        $upload->exts = array('xls','xlsx');
        $upload->rootPath = "./Public/Upload/$fileDir/";
        $upload->autoSub = false;
        $info = $upload->upload();
        if(!$info){
                $upload->getError();
                exit;
        }
        else{
           $res = inExcel($info);
           if(!empty($res)){
                $str = checkNull($res,4);
                if(!empty($str)){
                    $this->error($str,"./sInfo",5);
                }
                else{
                    $student = M("Student");
                    $list = $student->field('sId')->select();
                    $vo = checkData($res,$list);
                    if(!empty($vo)){
                         $this->error($vo,"./sInfo",5);
                     }
                     else{
                          $count1 = count($res);
                          $n = 0;
                          for($i=0;$i<$count1;$i++){
                              $data[$n]['sName'] = $res[$i][0];
                              $data[$n]['sId'] = $res[$i][1];
                              $data[$n]['sSex'] = $res[$i][2];
                              $data[$n]['sClass'] = $res[$i][3];
                              $data[$n]['sPhone'] = $res[$i][4];
                              $data[$n]['sEmail'] = $res[$i][5];
                              $data[$n]['sPwd'] = md5(getPassword($res[$i][1]));
                              $n++;
                          }
                          $student = M("Student");
                          $jg = $student->addAll($data);
                          if($jg === false){
                              $this->error("批量导入失败！");
                          }
                          else{
                              $this->redirect("Admin/sInfo");
                          }
                     }
                }
           }
           else{
              $this->error("导入文件失败！重新导入！");
           }
        
         }
     }

     public function uploadTeacher(){
        $upload = new Upload();
        $filePath = "./Public/Upload/";
        $fileDir = "dataModal";
        if(!file_exists($filePath)){
            mkdir($filePath);
        }
        if(!file_exists($filePath.$fileDir)){
            mkdir($filePath.$fileDir);
        }
        $upload->exts = array('xls','xlsx');
        $upload->rootPath = "./Public/Upload/$fileDir/";
        $upload->autoSub = false;
        $info = $upload->upload();
        if(!$info){
                $upload->getError();
                exit;
        }
        else{
           $res = inExcel($info);
           if(!empty($res)){
                $str = checkNull($res,3);
                if(!empty($str)){
                    $this->error($str,"./tInfo",5);
                }
                else{
                    $Teacher = M("Teacher");
                    $list = $Teacher->field('tPhone')->select();
                    $vo = checkData($res,$list,"tphone",2,"电话号码已存在！");
                    if(!empty($vo)){
                         $this->error($vo,"./tInfo",5);
                     }
                     else{
                          $count1 = count($res);
                          $n = 0;
                          for($i=0;$i<$count1;$i++){
                              $data[$n]['tName'] = $res[$i][0];
                              $data[$n]['tSex'] = $res[$i][1];
                              $data[$n]['tPhone'] = $res[$i][2];
                              $data[$n]['tEmail'] = $res[$i][3];
                              $data[$n]['tPwd'] = md5(getPassword($res[$i][2]));
                              $n++;
                          }
                          $teacher = M("teacher");
                          $jg = $teacher->addAll($data);
                          if($jg === false){
                              $this->error("批量导入失败！");
                          }
                          else{
                              $this->redirect("Admin/tInfo");
                          }
                     }
                }
           }
           else{
              $this->error("导入文件失败！重新导入！");
           }
        
         }
    }

    public function uploadCourse(){
        $upload = new Upload();
        $filePath = "./Public/Upload/";
        $fileDir = "dataModal";
        if(!file_exists($filePath)){
            mkdir($filePath);
        }
        if(!file_exists($filePath.$fileDir)){
            mkdir($filePath.$fileDir);
        }
        $upload->exts = array('xls','xlsx');
        $upload->rootPath = "./Public/Upload/$fileDir/";
        $upload->autoSub = false;
        $info = $upload->upload();
        if(!$info){
                $upload->getError();
                exit;
        }
        else{
           $res = inExcel($info);
           if(!empty($res)){
                $str = checkNull($res,1);
                if(!empty($str)){
                    $this->error($str,"./classManage",5);
                }
                else{
                    $course = M("Course");
                    $list = $course->field('cName')->select();
                    $vo = checkData($res,$list,"cname",0,"课程名称已存在！");
                    if(!empty($vo)){
                         $this->error($vo,"./classManage",5);
                     }
                     else{
                          $count1 = count($res);
                          $n = 0;
                          for($i=0;$i<$count1;$i++){
                              $data[$n]['cName'] = $res[$i][0];
                              $data[$n]['cdate'] = date("Y-m-d H-i-s");
                              $n++;
                          }
                          $course = M("Course");
                          $jg = $course->addAll($data);
                          if($jg === false){
                              $this->error("批量导入失败！");
                          }
                          else{
                              $this->redirect("Admin/classManage");
                          }
                     }
                }
           }
           else{
              $this->error("导入文件失败！重新导入！");
           }
        
         }
    }

}