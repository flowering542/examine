<?php
namespace Back\Controller;
use Think\Controller;
use Think\Upload;
header("Content-type: text/html; charset=utf-8");
class TeacherController extends CheckTeacherController {

      public function index(){
         $data['tPhone'] = session('tPhone');
         $teacher = M('Teacher');
         $res = $teacher->where($data)->getField('tName');
         $this->assign('tName',$res);
      	 $this->display();
      }

      public function dashboard(){
      	 $this->display();
      }

      public function personal(){
          $data['tPhone'] = session('tPhone');
          $teacher = M('Teacher');
          $list = $teacher->where($data)->find();
          $this->assign('list',$list);
          $this->display();
      }

      public function modifyPersonal(){
        if(IS_POST){
            $teacher = M('Teacher');
            $data = $teacher->create();
            $res = $teacher->save($data);
            if($res === false){
                $this->error('修改失败!');
            }
            else{
                $this->success('修改成功！','./personal');
            }
        }
        else{
              $data['tPhone'] = session('tPhone');
              $teacher = M('Teacher');
              $list = $teacher->where($data)->find();
              $this->assign('list',$list);
              $this->display('modifyPersonal');
        }
      }

      public function modifyPwd(){
        if(IS_AJAX){
              $tpwd = I('post.tpwd');
              $tpwd1 = I('post.tpwd1');
              $data['tPhone'] = session('tPhone');
              $teacher = M('Teacher');
              $list = $teacher->where($data)->getField('tPwd');
              if($list === md5($tpwd)){
                    $res = $teacher->where($data)->setField('tPwd',md5($tpwd1));
                    if($res != flase)  $this->ajaxReturn("ko");
                    else $this->ajaxReturn("no");
              }
              else{
                  $this->ajaxReturn("no");
              }
        }
        $this->display('modifyPwd');
      }

      public function announce(){
      	if(IS_POST){
    		$data['nTitle'] = I('post.nTitle');
    		$data['nContent'] = I('post.nContent','',false);
    		$data['nPerson'] = session('tPhone');
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
           $this->display();
        }
    }

    public function messageList(){
    	if(IS_POST){
    		$search = I('post.search');
    	}
    	$data['nPerson'] = session('tPhone');
    	$num = 8;  //一页多少条
    	$notice = M('Notice');  
    	if(empty($search)){
    		 $count = $notice->where($data)->count('nId'); //总条数
    		 $list = $notice->field('nId,nTitle,tName,ndate')->table(array('ks_notice'=>'a',"ks_teacher"=>'b'))->where('a.nPerson=b.tPhone')->where($data)->page($page,$num)->order('ndate desc')->select();
    	}
    	else{
    		 $data['nTitle'] = array('like','%'.$search.'%');
    		 $count = $notice->where($data)->count('nId'); //总条数
             $num = $count;
    		 $list = $notice->field('nId,nTitle,tName,ndate')->table(array('ks_notice'=>'a',"ks_teacher"=>'b'))->where('a.nPerson=b.tPhone')->where($data)->page($page,$num)->order('ndate desc')->select();
    	}
    	$pageCount = ceil($count/$num); //总页数
        if($page>$pageCount) $page=1;	 //防止出现list为空的情况
    	$this->assign('list',$list);
    	$this->assign('pageCount',$pageCount);
    	$this->assign('page',$page);
    	$this->assign('empty', '');
        $this->display('messageList');   
    }

    public function updMessage(){
    	 $notice = M('Notice');
     	 if(IS_GET){
     	 	 $data['nId'] = I('get.nId');
     	 	 $arr = $notice->where($data)->find();
            // dump($arr);exit;
             $this->assign('list',$arr);
             $this->display('updMessage');
     	 }
     	 else{
             $data['nTitle'] = I('post.nTitle');
             $data['nId'] = I('post.nId');
    		 $data['nContent'] = I('post.nContent','',false);
    		 $res = $notice->save($data);
            if($res === false){
            	$this->error("修改失败！","./messageList");
            }
            $this->success("修改成功！","./messageList");
     	 }
    }

    public function delMessage(){
    	 $data['nId'] = I('get.nId');
         $notice = M('Notice');
         $res = $notice->where($data)->delete();
         if($res === false){
         	  $this->error("删除失败！");
         }
         else{
         	  $this->redirect("Teacher/messageList");
         }
    }
 
    public function addSingle(){
         if(IS_POST){
              $single = M('Single');
             $data = $single->create();
             // dump($data); exit;
             $data['sPerson'] = session('tPhone');
             $res = $single->add($data);
             if($res){
                 $qulist = M('Qulist');
                 $teacher = M('Teacher');
                 $condition['tPhone'] = session('tPhone');
                 $vo['anId'] = $res;
                 $vo['quTitle'] = $data['sTitle'];
                 $vo['quType'] = "单选题";
                 $vo['score'] = $data['score'];
                 $vo['quPerson'] = $condition['tPhone'];
                 $vo['cName'] = $data['cName'];  
                 $vo['quTrue'] = $data['sTrue']; 
                 $vo['quDate'] = date("Y-m-d H:i:s");
                 $qulist->add($vo);
                 $this->success("添加成功！");
             }
             else{
                $this->error("添加失败！");
             }
         }
         else{
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list",$list);
             $this->display('addSingle');
         }
    	

    }

    public function addMulti(){
        if(IS_POST){
            $mT = $_POST['mT'];
            $multi = M('Multi');
            $data = $multi->create();
            $data['mTrue'] = implode(',',$mT);
            $data['mPerson'] = session('tPhone');
            $res = $multi->add($data);
            if($res){
                 $qulist = M('Qulist');
                 $teacher = M('Teacher');
                 $condition['tPhone'] = session('tPhone');
                 $vo['anId'] = $res;
                 $vo['quTitle'] = $data['mTitle'];
                 $vo['quType'] = "多选题";
                 $vo['score'] = $data['score'];
                 $vo['quPerson'] = $condition['tPhone'];
                 $vo['cName'] = $data['cName'];  
                 $vo['quTrue'] = $data['mTrue']; 
                 $vo['quDate'] = date("Y-m-d H:i:s");
                 $qulist->add($vo);
                 $this->success("添加成功！");
             }
             else{
                $this->error("添加失败！");
             }
        }
        else{
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list",$list);
             $this->display('addMulti');
        }
      

    }

    public function addJudge(){
       if(IS_POST){
            $judge = M('Judge');
             $data = $judge->create();
             $data['jPerson'] = session('tPhone');
             $res = $judge->add($data);
             if($res){
                 $qulist = M('Qulist');
                 $teacher = M('Teacher');
                 $condition['tPhone'] = session('tPhone');
                 $vo['anId'] = $res;
                 $vo['quTitle'] = $data['jTitle'];
                 $vo['quType'] = "判断题";
                 $vo['score'] = $data['score'];
                 $vo['quPerson'] = $condition['tPhone'];
                 $vo['quDate'] = date("Y-m-d H:i:s");
                 $vo['cName'] = $data['cName'];  
                 $vo['quTrue'] = $data['jTrue']; 
                 $qulist->add($vo);
                 $this->success("添加成功！");
             }
             else{
                $this->error("添加失败！");
             }
         }
         else{
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list",$list);
             $this->display('addJudge');
         }
        

    }

    public function addBlank(){
      if(IS_POST){
          $blank = M('Blank');
          $data = $blank->create();
          $data['bPerson'] = session('tPhone');
          $res = $blank->add($data);
         if($res){
             $qulist = M('Qulist');
             $teacher = M('Teacher');
             $condition['tPhone'] = session('tPhone');
             $vo['anId'] = $res;
             $vo['quTitle'] = $data['bTitle'];
             $vo['quType'] = "填空题";
             $vo['score'] = $data['score'];
             $vo['quPerson'] =  $condition['tPhone'];
             $vo['quDate'] = date("Y-m-d H:i:s");
             $vo['cName'] = $data['cName'];  
             $vo['quTrue'] = $data['bTrue'];  
             $qulist->add($vo);
             $this->success("添加成功！");
         }
         else{
            $this->error("添加失败！");
         }
      }
      else{
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list",$list);
             $this->display('addBlank');
         }
        
    }
    public function addQu(){
      if(IS_POST){
         $answer = M('Question');
         $data =  $answer ->create();
         $data['qPerson'] = session('tPhone');
         $res = $answer->add($data);
        if($res){
             $qulist = M('Qulist');
             $teacher = M('Teacher');
             $condition['tPhone'] = session('tPhone');
             $vo['anId'] = $res;
             $vo['quTitle'] = $data['qTitle'];
             $vo['quType'] = "简答题";
             $vo['score'] = $data['score'];
             $vo['quPerson'] =  $condition['tPhone'];
             $vo['cName'] = $data['cName'];
             $vo['quDate'] = date("Y-m-d H:i:s");
             $qulist->add($vo);
             $this->success("添加成功！");
         }
         else{
            $this->error("添加失败！");
         }
      }
      else{
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list",$list);
             $this->display('addQu');
       }
             
    }
    
    public function addFile(){
     if(IS_POST){
        $answer = M('File');
        $upload = new Upload();
        $filePath = "./Public/Upload/";
        $fileDir = "questionFile";
        if(!file_exists($filePath)){
            mkdir($filePath);
        }
        if(!file_exists($filePath.$fileDir)){
            mkdir($filePath.$fileDir);
        }
        $upload->maxSize = 5242880;
        $upload->saveName = '';
        $upload->exts = array('zip','rar','doc','docx');
        $upload->rootPath = "./Public/Upload/$fileDir/";
        $upload->autoSub = true;
        $info = $upload->upload();
        if(!$info){
               $this->error($upload->getError());
        }else{
                 $data =  $answer ->create();
                 $data['fPath'] =  "/Upload/".$fileDir."/".$info['myFile']['savepath'].$info['myFile']['savename'];
                 $data['fPerson'] = session('tPhone');
                 $res = $answer->add($data);
                if($res){
                      $qulist = M('Qulist');
                     $teacher = M('Teacher');
                     $condition['tPhone'] = session('tPhone');
                     $vo['anId'] = $res;
                     $vo['quTitle'] = $data['fTitle'];
                     $vo['quType'] = "文件上传题";
                     $vo['score'] = $data['score'];
                     $vo['quPerson'] = $condition['tPhone'];
                     $vo['cName'] = $data['cName'];
                     $vo['quDate'] = date("Y-m-d H:i:s");
                     $qulist->add($vo);
                     $this->success("添加成功！");
                 }
                 else{
                    $this->error("添加失败！");   
                 }
          }
      }
      else{
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list",$list);
             $this->display('addFile');
      }
       
        
    }
    public function questionList($page=1){
    	if(IS_POST){
            $search = I('post.search');
            $px = I('post.px');
        }
        if(empty($px)){
            $paixu = 'quDate desc';
        }
        else{
            $paixu = 'quType asc';
        }
        $num = 8;  //一页多少条
        $qulist = M('Qulist');
        $condition['quPerson'] = session('tPhone');  
        if(empty($search)){
             $count = $qulist->where($condition)->count(); //总条数
             $list =  $qulist->where($condition)->page($page,$num)->order($paixu)->select();
        }
        else{
             $data['cName'] = array('like','%'.$search.'%');
             $data['quPerson'] = $condition['quPerson'];
             $count = $qulist->where($data)->count(); //总条数
             $num = $count;
             $list = $qulist->where($data)->page($page,$num)->order($paixu)->select();
        }
        $pageCount = ceil($count/$num); //总页数
        if($page>$pageCount) $page=1; 
        //dump($list);exit;   //防止出现list为空的情况
        $this->assign('list',$list);
        $this->assign('pageCount',$pageCount);
        $this->assign('page',$page);
        $this->assign('empty', '');
        $this->display('questionList');   
    }

    public function delQuestion(){
         if(IS_GET){
             $data['quId'] = I('get.quId');
             $quType1 = I('get.quType');
         }
        $qulist = M('Qulist');
        $condition1 = $qulist->where($data)->getField('anId');
        switch ($quType1) {
            case '单选题':
                 $single = M('Single');
                 $condition['sId'] = $condition1;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '多选题':
                 $single = M('Multi');
                 $condition['mId'] = $condition1;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '判断题':
                 $single = M('Judge');
                 $condition['jId'] = $condition1;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '填空题':
                 $single = M('Blank');
                 $condition['bId'] = $condition1;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '简答题':
                 $single = M('Question');
                 $condition['qId'] = $condition1;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '文件上传题':
                 $single = M('File');
                 $condition['fId'] = $condition1;
                 $result = $single->where($condition)->getField('fPath');
                 //dump($result); exit;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 $b = delDirAndFile('./Public/'.$result,false);
                 break;
             default:
                 # code...
                 break;
         }
        $res2 = $qulist->where($data)->delete();
        if($res2 === false){
            $this->error('删除失败！');
        }
        $vo['tId'] = $condition1;
        $vo['type'] = $quType1;
        $paperdetail = M('Paperdetail');
        $a = M('Answer');
        $res3 = $a->where($vo)->delete();
        $res4 = $paperdetail->where($vo)->delete();
         if($res3 === false){
            $this->error('删除失败！');
         }
        if($res4 === false){
            $this->error('删除失败！');
         }
        else{
            $this->redirect('Teacher/questionList');
        }
        
    }

    public function delMulti(){
        $condition = $_POST['condition'];
        $count1 = count($condition);
        for($i=0;$i<$count1;$i++){
            $res = explode('&', $condition[$i]);
            $quId = $res[0];
            $quType = $res[1];
            $this->delQuestion1($quId,$quType);
        }
        $this->redirect('Teacher/questionList');
    }

     public function delQuestion1($quId,$quType){
        $data['quId'] = $quId;
        $quType1 = $quType;
        $qulist = M('Qulist');
        $condition1 = $qulist->where($data)->getField('anId');
         switch ($quType1) {
            case '单选题':
                 $single = M('Single');
                 $condition['sId'] = $condition1;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '多选题':
                 $single = M('Multi');
                 $condition['mId'] = $condition1;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '判断题':
                 $single = M('Judge');
                 $condition['jId'] = $condition1;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '填空题':
                 $single = M('Blank');
                 $condition['bId'] = $condition1;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '简答题':
                 $single = M('Question');
                 $condition['qId'] = $condition1;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '文件上传题':
                 $single = M('File');
                 $condition['fId'] = $condition1;
                 $result = $single->where($condition)->getField('fPath');
                 //dump($result); exit;
                 $res1 = $single->where($condition)->delete();
                 if($res1 === false){$this->error("删除失败！");}
                 $b = delDirAndFile('./Public'.$result,false);
             default:
                 # code...
                 break;
         }
        $res2 = $qulist->where($data)->delete();
        if($res2 === false){
            $this->error('删除失败！');
        }
        $vo['tId'] = $condition1;
        $vo['type'] = $quType1;
        $paperdetail = M('Paperdetail');
        $a = M('Answer');
        $res3 = $a->where($vo)->delete();
        $res4 = $paperdetail->where($vo)->delete();
         if($res3 === false){
            $this->error('删除失败！');
         }
        if($res4 === false){
            $this->error('删除失败！');
         }
        else{
           return true;
        }
        
    }

    public function modifySingle(){
         if(IS_GET){
             $data['quId'] = I('get.quId');
             $qulist = M('Qulist');
             $res1['sId'] = $qulist->where($data)->getField('anId');
             $single = M('Single');
             $condition1 = $single->where($res1)->find();
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list1",$condition1);
             $this->assign("list2",$list);
             $this->assign("quId",$data['quId']);
             $this->display('modifySingle');
         }
         else{
             $single = M('Single');
             $data = $single->create();
             $vo['quId'] =I('post.quId');
             //dump($vo); exit;
             $res = $single->save($data);
             //$res === 1 记录修改
             if($res === 1){
                 $qulist = M('Qulist');
                 $vo['quTitle'] = $data['sTitle'];
                 $vo['score'] = $data['score'];
                 $vo['cName'] = $data['cName'];  
                 $vo['quTrue'] = $data['sTrue']; 
                 $vo['quDate'] = date("Y-m-d H:i:s");
                 $qulist->save($vo);
                 $this->redirect('questionList');
             }
             else if($res === false){
                $this->error("修改失败！","questionList");
             }
             else  $this->redirect('questionList');
         }
    }

     public function modifyMultiple(){
          if(IS_GET){
             $data['quId'] = I('get.quId');
             $qulist = M('Qulist');
             $res1['mId'] = $qulist->where($data)->getField('anId');
             $multi = M('Multi');
             $condition1 = $multi->where($res1)->find();
             //dump($condition1); exit;
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list1",$condition1);
             $this->assign("list2",$list);
             $this->assign("quId",$data['quId']);
             $this->display('modifyMultiple');
         }
         else{
             $multi = M('Multi');
             $mT = $_POST['mT'];
             $data = $multi->create();
             $data['mTrue'] = implode(',',$mT);
             //dump($data); exit;
             $vo['quId'] =I('post.quId');
             $res = $multi->save($data);
             //$res === 1 记录修改
             if($res === 1){
                 $qulist = M('Qulist');
                 $vo['quTitle'] = $data['mTitle'];
                 $vo['score'] = $data['score'];
                 $vo['cName'] = $data['cName'];  
                 $vo['quTrue'] = $data['mTrue']; 
                 $vo['quDate'] = date("Y-m-d H:i:s");
                 $qulist->save($vo);
                 $this->redirect('questionList');
             }
             else if($res === false){
                $this->error("修改失败！","questionList");
             }
             else  $this->redirect('questionList');
         }
     }

     public function modifyJudge(){
         if(IS_GET){
             $data['quId'] = I('get.quId');
             $qulist = M('Qulist');
             $res1['jId'] = $qulist->where($data)->getField('anId');
             $judge = M('Judge');
             $condition1 = $judge->where($res1)->find();
             //dump($condition1); exit;
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list1",$condition1);
             $this->assign("list2",$list);
             $this->assign("quId",$data['quId']);
             $this->display('modifyJudge');
         }
         else{
             $judge = M('Judge');
             $data = $judge->create();
             $vo['quId'] =I('post.quId');
             $res = $judge->save($data);
             //$res === 1 记录修改
             if($res === 1){
                 $qulist = M('Qulist');
                 $vo['quTitle'] = $data['jTitle'];
                 $vo['score'] = $data['score'];
                 $vo['quDate'] = date("Y-m-d H:i:s");
                 $vo['cName'] = $data['cName'];  
                 $vo['quTrue'] = $data['jTrue']; 
                 $qulist->save($vo);
                 $this->redirect('questionList');
             }
             else if($res === false){
                $this->error("修改失败！","./questionList");
             }
             else  $this->redirect('questionList');
         }
     }

     public function modifyBlank(){
            if(IS_GET){
             $data['quId'] = I('get.quId');
             $qulist = M('Qulist');
             $res1['bId'] = $qulist->where($data)->getField('anId');
             $blank = M('blank');
             $condition1 = $blank->where($res1)->find();
             //dump($condition1); exit;
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list1",$condition1);
             $this->assign("list2",$list);
             $this->assign("quId",$data['quId']);
             $this->display('modifyBlank');
         }
         else{
             $blank = M('Blank');
             $data = $blank->create();
             $vo['quId'] =I('post.quId');
             $res = $blank->save($data);
             //$res === 1 记录修改
             if($res === 1){
                 $qulist = M('Qulist');
                 $vo['quTitle'] = $data['bTitle'];
                 $vo['score'] = $data['score'];
                 $vo['cName'] = $data['cName'];  
                 $vo['quTrue'] = $data['bTrue']; 
                 $vo['quDate'] = date("Y-m-d H:i:s");
                 $qulist->save($vo);
                 $this->redirect('questionList');
             }
             else if($res === false){
                $this->error("修改失败！","questionList");
             }
             else  $this->redirect('questionList');
         }
     }

     public function modifyQuestion(){
           if(IS_GET){
             $data['quId'] = I('get.quId');
             $qulist = M('Qulist');
             $res1['qId'] = $qulist->where($data)->getField('anId');
             $blank = M('Question');
             $condition1 = $blank->where($res1)->find();
             //dump($condition1); exit;
             $course = M("Course");
             $list = $course->field("cName")->select();
             $this->assign("list1",$condition1);
             $this->assign("list2",$list);
             $this->assign("quId",$data['quId']);
             $this->display('modifyQuestion');
         }
         else{
             $blank = M('Question');
             $data = $blank->create();
             $vo['quId'] =I('post.quId');
             $res = $blank->save($data);
             //$res === 1 记录修改
             if($res === 1){
                 $qulist = M('Qulist');
                 $vo['quTitle'] = $data['qTitle'];
                 $vo['score'] = $data['score'];
                 $vo['cName'] = $data['cName'];  
                 $vo['quDate'] = date("Y-m-d H:i:s");
                 $qulist->save($vo);
                 $this->redirect('questionList');
             }
             else if($res === false){
                $this->error("修改失败！","questionList");
             }
             else  $this->redirect('questionList');
         }
     }

     public function modifyUpload(){
          $sz = $_POST['sz'];
          if(IS_AJAX){
                 $data['quId'] = I('get.quId');
                 $qulist = M('Qulist');
                 $res1['fId'] = $qulist->where($data)->getField('anId');
                 $file1 = M('File');
                 $condition1 = $file1->where($res1)->find();
                 $pathFile = './Public/'.$condition1['fpath'];
                 $b = delDirAndFile($pathFile,false);
                 $this->ajaxReturn($b);
          }
         elseif(IS_GET){
             $data['quId'] = I('get.quId');
             $qulist = M('Qulist');
             $res1['fId'] = $qulist->where($data)->getField('anId');
             $file1 = M('File');
             $condition1 = $file1->where($res1)->find();
             $pathFile = './Public/'.$condition1['fpath'];
          //   dump($res1); exit;
             $course = M("Course");
             $list = $course->field("cName")->select();
             $pm = explode('/',$condition1['fpath']);
             $this->assign("list1",$condition1);
             $this->assign("list2",$list);
             $this->assign("quId",$data['quId']);
             $this->assign("pm",$pm[count($pm)-1]);
             $this->display('modifyUpload');
          }
          else{
             $answer = M('File');
             if(!empty($sz)){
              //  dump($sz); exit;
                $upload = new Upload();
                $filePath = "./Public/Upload/";
                $fileDir = "questionFile";
                if(!file_exists($filePath)){
                    mkdir($filePath);
                }
                if(!file_exists($filePath.$fileDir)){
                    mkdir($filePath.$fileDir);
                }
                $upload->maxSize = 10485760;
                $upload->saveName = '';
                $upload->exts = array('zip','rar','doc','docx');
                $upload->rootPath = "./Public/Upload/$fileDir/";
                $upload->autoSub = true;
                $info = $upload->upload();
                if(!$info){
                       $this->error($upload->getError());
                }
              }
                $data =  $answer ->create();
                $condition['quId'] = I('post.quId');
               //   dump($data); exit;
                 if(!empty($sz)){
                       $data['fPath'] =  "/Upload/".$fileDir."/".$info['myFile']['savepath'].$info['myFile']['savename'];
                 }
                $res = $answer->save($data);
                if($res === 1){
                     $qulist = M('Qulist');
                     $vo['anId'] = $data['fId'];
                     $vo['quTitle'] = $data['fTitle'];
                     $vo['score'] = $data['score'];
                     $vo['quDate'] = date("Y-m-d H:i:s");
                     $vo['cName'] = $data['cName'];  
                     $qulist->where($condition)->save($vo);
                     $this->success("修改成功！",'./questionList');
                 }
                 else if($res === 0){
                        $this->success("修改成功！",'./questionList');
                 }
                 else{
                    $this->error("添加失败！",'./questionList');   
                 }
             
          }
     }



}