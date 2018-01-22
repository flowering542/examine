<?php
namespace Back\Controller;
use Think\Controller;

class ExamController extends CheckTeacherController {
    //添加试卷
    public function setExam(){
         $course = M("Course");
         $list = $course->field("cName")->select();
         $this->assign("list",$list);
         $this->display('Exam/setExam');
    }

    public function checkExam(){
         if(IS_AJAX){
              $data['pCode'] = I('post.pCode');
              $paper = M('Paper');
              $res = $paper->where($data)->count();
              $this->ajaxReturn($res);
         }
       
    }

    public function addExam(){
          if(IS_AJAX){
               $paper = M('Paper');
               $condition['tPhone'] = session('tPhone');
               $teacher = M('Teacher');
               $data = $paper->create();
               //$data['pPerson'] = $teacher->where($condition)->getfield('tName');
               $data['pPerson'] = $condition['tPhone'];
               $res = $paper->add($data);
               $this->ajaxReturn($res);
          }
    }
    //删除试卷
    public function modifyExam(){
        if(IS_POST){
             $paper = M('Paper');
             $data = $paper->create();
             $res = $paper->save($data);
             if($res === false){
                 $this->error("修改失败！"); 
             }
             else{
                 $this->success("修改成功！",'examList');
             }
        }
        else{
             $data['pId'] = I('get.pId');
             $course = M();
             $arr = $course->table('ks_paper')->where($data)->find();
             $list = $course->table('ks_course')->field("cName")->select();
             $this->assign("arr",$arr);
             $this->assign("list",$list);
             $this->display('modifyExam');
        }

    }
    //显示选择组卷
    public function toExam(){
        $pId = I('get.pId');
        if(!empty($pId)) session('pId',$pId);
        $vo['pId'] = session('pId');
        $vo['quPerson'] = session('tPhone');
        if(IS_POST){
               if(empty(I('post.quType'))&&empty($_POST['search'])){
                      $qulist = M('Qulist');
                      $paperdetail = M('Paperdetail');
                      $list2 = $paperdetail->field('pId,tId,quId,quTitle,quType,score,quPerson')->table(array('ks_paperdetail'=>'a','ks_qulist'=>'b'))->where('b.anId=a.tId and b.quType=a.type')->where($vo)->order('quType asc')->select();
                      $ids = array_column($list2,'quid');
                      $con = implode(',',$ids);
                      $condition['quPerson'] = session('tPhone');
                      $condition['quId'] = array('not in',$con);
                      $list1 = $qulist->where($condition)->order('quDate desc')->select();
                     $this->assign('list2',$list2);
                     $this->assign('list1',$list1);
                     $this->assign('pId',$pId);
                     $this->display('Exam/toExam');
               }
               else if(!empty(I('post.quType'))&&empty($_POST['search'])){
                    $data['quType'] = I('post.quType');
                    $qulist = M('Qulist');
                    $paperdetail = M('Paperdetail');
                    $list2 = $paperdetail->field('detailId,pId,tId,quId,quTitle,quType,score,quPerson')->table(array('ks_paperdetail'=>'a','ks_qulist'=>'b'))->where('b.anId=a.tId and quType=type')->where($vo)->order('quType asc')->select();
                  $ids = array_column($list2,'quid');
                  $con = implode(',',$ids);
                  $condition['quId'] = array('not in',$con);
                  $condition['quPerson'] = session('tPhone');
                  $list1 = $qulist->where($condition)->where($data)->order('quDate desc')->select();
                   $this->assign('list2',$list2);
                   $this->assign('list1',$list1);
                   $this->assign('pId',$pId);
                   $this->assign('quType', $data['quType']);
                   $this->display('Exam/toExam');
               }
                else if(empty(I('post.quType'))&&!empty($_POST['search'])){
                   $data['cName'] = array('like','%'.$_POST['search'].'%');
                   $qulist = M('Qulist');
                    $paperdetail = M('Paperdetail');
                    $list2 = $paperdetail->field('detailId,pId,tId,quId,quTitle,quType,score,quPerson')->table(array('ks_paperdetail'=>'a','ks_qulist'=>'b'))->where('b.anId=a.tId and b.quType=a.type')->where($vo)->order('quType asc')->select();
                  $ids = array_column($list2,'quid');
                  $con = implode(',',$ids);
                  $condition['quId'] = array('not in',$con);
                  $condition['quPerson'] = session('tPhone');
                  $list1 = $qulist->where($condition)->where($data)->order('quDate desc')->select();
                   $this->assign('list2',$list2);
                   $this->assign('list1',$list1);
                   $this->assign('pId',$pId);
                   $this->assign('quType', $data['quType']);
                   $this->display('Exam/toExam');
               }
               else{
                   $data['cName'] = array('like','%'.$_POST['search'].'%');
                   $data['quType'] = I('post.quType');
                   $qulist = M('Qulist');
                   $paperdetail = M('Paperdetail');
                   $list2 = $paperdetail->field('detailId,pId,tId,quId,quTitle,quType,score,quPerson')->table(array('ks_paperdetail'=>'a','ks_qulist'=>'b'))->where('b.anId=a.tId and b.quType=a.type')->where($vo)->order('quType asc')->select();
                  $ids = array_column($list2,'quid');
                  $con = implode(',',$ids);
                  $condition['quId'] = array('not in',$con);
                  $condition['quPerson'] = session('tPhone');
                  //选择页面
                  $list1 = $qulist->where($condition)->where($data)->order('quDate desc')->select();
                   $this->assign('list2',$list2);
                   $this->assign('list1',$list1);
                   $this->assign('pId',$pId);
                   $this->assign('quType', $data['quType']);
                   $this->display('Exam/toExam');
               }
             
        }
        else{
            $qulist = M('Qulist');
            $paperdetail = M('Paperdetail');
            $list2 = $paperdetail->field('detailId,pId,tId,quId,quTitle,quType,score,quPerson')->table(array('ks_paperdetail'=>'a','ks_qulist'=>'b'))->where('b.anId=a.tId and b.quType=a.type')->where($vo)->order('quType asc')->select();
           //dump($vo); exit;
            $ids = array_column($list2,'quid');
            $con = implode(',',$ids);
            $condition['quPerson'] = session('tPhone');
            $condition['quId'] = array('not in',$con);
            $list1 = $qulist->where($condition)->order('quDate desc')->select();
                     // dump($list1); exit;
            $this->assign('list2',$list2);
            $this->assign('list1',$list1);
            $this->assign('pId',$pId);
            $this->display('Exam/toExam');
        }
     
    }
    //添加题目到试卷
    public function paperDetail(){
     if(IS_POST){
          $condition1 = I('post.condition');
          if(empty(I('post.pId'))){
               $pId = session('pId');
          }
          else $pId = I('post.pId');
          $n = 0;
          $count1 = count($condition1);
          for($i=0;$i<$count1;$i++){
             $res = explode('&amp;',$condition1[$i]);
             $data[$n]['pId'] = $pId;
             $data[$n]['tId'] = $res[0];
             $data[$n]['type'] = $res[1];
             $n++; 
          }
          $paperdetail = M('Paperdetail');
          $jg = $paperdetail->addAll($data);
          if($jg === false)  $this->error("添加失败！");
          $this->redirect('Exam/toExam');
      }
}
   //修改分数
    public function setScore(){
        $score = I('post.score');
        $data['quId'] = I('post.quId');
        $quType1 = I('post.quType');
        $qulist = M('Qulist');
        $condition1 = $qulist->where($data)->getField('anId');
         switch ($quType1) {
            case '单选题':
                 $single = M('Single');
                 $condition['sId'] = $condition1;
                 $res1 = $single->where($condition)->setField('score',$score);
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '多选题':
                 $single = M('Multi');
                 $condition['mId'] = $condition1;
                 $res1 = $single->where($condition)->setField('score',$score);
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '判断题':
                 $single = M('Judge');
                 $condition['jId'] = $condition1;
                 $res1 = $single->where($condition)->setField('score',$score);
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '填空题':
                 $single = M('Blank');
                 $condition['bId'] = $condition1;
                 $res1 = $single->where($condition)->setField('score',$score);
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '简答题':
                 $single = M('Question');
                 $condition['qId'] = $condition1;
                 $res1 = $single->where($condition)->setField('score',$score);
                 if($res1 === false){$this->error("删除失败！");}
                 break;
            case '文件上传题':
                 $single = M('File');
                 $condition['fId'] = $condition1;
                 $result = $single->where($condition)->setField('score',$score);
                 if($res1 === false){$this->error("删除失败！");}
                // $b = delDirAndFile('./Public/'.$result,false);
             default:
                 # code...
                 break;
         }
        $res2 = $qulist->where($data)->setField('score',$score);;
        if($res2 === false){
            $this->error('删除失败！');
        }
        else{
            $this->ajaxReturn("ok");
        }
    }
   //删除试题
    public function delExam(){
        if(IS_POST){
             $condition1 = $_POST['condition'];
             $paperdetail = M('Paperdetail');
             $count1 = count($condition1);
             for($i=0;$i<$count1;$i++){
                 $res = explode('&',$condition1[$i]);
                 $data['pId'] = $res[0];
                 $data['tId'] = $res[1];
                 $jg = $paperdetail->where($data)->delete();
                 if($jg === false)  $this->error("删除失败!");
             }
             $this->redirect('Exam/toExam');
        }
    }
   //试卷列表
    public function examList($page=1){
            if(IS_POST){
                $search = I('post.search');
            }
            $num = 8;  //一页多少条
            $notice = M('Paper');
            $condition['pPerson'] = session('tPhone');    
            if(empty($search)){
                 $count = $notice->where($condition)->count(); //总条数
                 $list = $notice->field('pId,pCode,cName,pName,tName')->table(array('ks_paper'=>'a','ks_teacher'=>'b'))->where('a.pPerson=b.tPhone')->where($condition)->page($page,$num)->order('pBtime desc')->select();
            }
            else{
                 $data['pName'] = array('like','%'.$search.'%');
                 $data['pPerson'] = $condition['pPerson'];
                 $count = $notice->where($data)->count(); //总条数
                 $num = $count;
                 $list = $notice->field('pId,pCode,cName,pName,tName')->table(array('ks_paper'=>'a','ks_teacher'=>'b'))->where('a.pPerson=b.tPhone')->where($data)->page($page,$num)->order('pBtime desc')->select();
            }
             $pageCount = ceil($count/$num); //总页数
             if($page>$pageCount) $page=1;   //防止出现list为空的情况
            $this->assign('list',$list);
            $this->assign('pageCount',$pageCount);
            $this->assign('page',$page);
            $this->assign('empty', '');
            $this->display('Exam/examList');
        }
        //删除试题组卷的题目
        public function delTest(){
              if(IS_POST){
                 $condition1 = $_POST['condition'];
                 $paper = M('Paper');
                 $paperdetail = M('Paperdetail');
                 $answer = M('Answer');
                 $res = implode(',',$condition1);
                 //dump($condition1); exit;
                 $count1 = count($condition1);
                 for($i=0;$i<$count1;$i++){
                     $data['pId'] = $condition1[$i];
                     $jg = $paperdetail->where($data)->delete();
                     if($jg === false)  $this->error("删除失败!");
                 }
                 $jg2 = $paper->delete($res);
                 if($jg2 === false)  $this->error("删除失败!");
                 for($i=0;$i<$count1;$i++){
                     $data['pId'] = $condition1[$i];
                     $jg3 = $answer->where($data)->delete();
                       if($jg3 === false)  $this->error("删除失败!");
                 }
                $this->redirect('Exam/examList');
          }
   }

    public function lan(){
       $this->display();
   }
   
   //批卷
   public function waitExam(){
       $condition['tPhone'] = session('tPhone');
       $answer = M('Answer');
       $vo = $answer->field('pId,a.sId,sName')->table(array('ks_answer'=>'a','ks_student'=>'b'))->distinct('pId,a.sId,sName')->where('a.sId=b.sId and a.score is null')->select();
       $paper = M('Paper');
       for($i=0;$i<count($vo);$i++){
            $list1['pId'] = $vo[$i]['pid'];
            $list1['pPerson'] = $condition['tPhone'];
            $wo[$i]['data'] = $paper->where($list1)->select();
       }
       if(!empty($wo[0]['data'])){
           $this->assign("list1",$vo);
           $this->assign("list2",$wo);
       }
       $this->display('Exam/waitExam');  
   }

   public function correcting(){
        //查询简答题
        $answer = M('Answer');
        $sId = I('get.sId');
        $pId = I('get.pId');
        $tPhone = session('tPhone');

        $data['type'] = "简答题";
        $data['_string'] = "a.sId=$sId AND a.pId= $pId AND a.pId=b.pId and a.score is null AND pPerson=$tPhone AND a.tId=c.anId AND c.quType='简答题'";
        $vo1 = $answer->field('a.sId,a.tId,a.pId,a.type,a.answer,c.quTitle,c.score')->table(array('ks_answer'=>'a','ks_paper'=>'b','ks_qulist'=>'c'))->where($data)->select();
       
         $condition['type'] = "文件上传题";
         $condition['_string'] = "a.sId=$sId AND a.pId= $pId AND a.pId=b.pId and a.score is null AND pPerson=$tPhone AND a.tId=c.anId AND c.quType='文件上传题'";
        $vo2 = $answer->field('a.sId,a.tId,a.pId,a.type,a.answer,c.quTitle,c.score')->table(array('ks_answer'=>'a','ks_paper'=>'b','ks_qulist'=>'c'))->where($condition)->select();
        //dump($vo2);
        $this->assign('list1',$vo1);
        $this->assign('list2',$vo2);
        $this->display();
   }

   public function updateScore(){
       $data['score'] = I('post.score');
       $data['sId'] = I('post.sId');
       $data['tId'] = I('post.tId');
       $data['pId'] = I('post.pId');
       $data['type'] = I('post.type');
       $answer = M('answer');
       $res = $answer->save($data);
       $this->ajaxReturn($res);
   }

   public function grade(){
    //查询该老师组卷
       $tPhone = session('tPhone');
       $answer = M('Answer');
       $paper = M('Paper');
    
       $wo = $answer->field('pId')->distinct('pId')->where("score is null")->select();
       $wo1 = array_column($wo,'pid');
       $lj = implode(',',$wo1);
       if(empty($lj)){
             $data['_string'] = "a.pId=b.pId AND b.pPerson=$tPhone";
       }
       else{
           $data['_string'] = "a.pId=b.pId AND b.pPerson=$tPhone AND a.pId not in ($lj)";
       }

       $vo = $answer->field('a.pId')->distinct('pId')->table(array('ks_answer'=>'a','ks_paper'=>'b'))->where($data)->order('b.pBtime desc')->select();

       $count1 = count($vo);
       for($i=0;$i<$count1;$i++){
            $condition['pId'] = $vo[$i]['pid'];
            $list[$i]['data'] = $paper->field('a.pId,a.pCode,a.cName,a.pName,tName')->table(array('ks_paper'=>'a','ks_teacher'=>'b'))->where('a.pPerson=b.tPhone')->where($condition)->select();
       }
       //dump($lj);
       $this->assign("list",$list);
       $this->display();
   }

   public function gradeList1(){
       if(IS_GET){
           $data['pId'] = I('get.pId');
           $cname = I('get.cName');
           $answer = M('Answer');
           $vo = $answer->field('sId')->distinct('sId')->where($data)->select();
           $count1 = count($vo);
           $student = M('Student');

           for($i=0;$i<$count1;$i++){
              $condition['sId'] = $vo[$i]['sid'];
              $data['sId'] = $vo[$i]['sid'];
              $list[$i]['list'] = $student->field('sId,sName,sSex,sClass')->where($condition)->select();
              $list[$i]['score'] =  $answer->where($data)->sum('score');
           }
          $this->assign('pId',$data['pId']);
          $this->assign('cname',$cname);
          $this->assign('list',$list);
          $this->display('Exam/gradeList1');
       }
       else{
          $this->display('Exam/gradeList1');
       }
        
   }

   public function addGrade(){
       $condition = $_POST['condition'];
       $count1 = count($condition);
       for($i=0;$i<$count1;$i++){
            $vv = explode('&',$condition[$i]);
            $data[$i]['pId'] = $vv[0];
            $data[$i]['sId'] = $vv[1];
            $data[$i]['grade'] = $vv[2];
       }
       
       $grade = M('grade');
       // dump($data);
       $count2 = count($data);
       for($i=0;$i<$count2;$i++){
             $res = $grade->where($data[$i])->count();
             if($res >= 1){
                  $result1 = $grade->save($data[$i]);
                  if($result1 === false){$this->error('发布失败！');exit;}
             }
             else{
                  $result1 = $grade->add($data[$i]);
                  if($result1 === false){$this->error('发布失败！');exit;}
             } 
       }
       $this->success("成绩发布成功！");
   }

     public function gradeList2(){
       $tPhone = session('tPhone');
       $answer = M('Answer');
       $paper = M('Paper');
    
       $wo = $answer->field('pId')->distinct('pId')->where("score is null")->select();
       $wo1 = array_column($wo,'pid');
       $lj = implode(',',$wo1);
       if(empty($lj)){
             $data['_string'] = "a.pId=b.pId AND b.pPerson=$tPhone";
       }
       else{
           $data['_string'] = "a.pId=b.pId AND b.pPerson=$tPhone AND a.pId not in ($lj)";
       }

       $vo = $answer->field('a.pId')->distinct('pId')->table(array('ks_answer'=>'a','ks_paper'=>'b'))->where($data)->order('b.pBtime desc')->select();

       $count1 = count($vo);
       for($i=0;$i<$count1;$i++){
            $condition['pId'] = $vo[$i]['pid'];
            $list[$i]['data'] = $paper->field('a.pId,a.pCode,a.cName,a.pName')->table(array('ks_paper'=>'a','ks_teacher'=>'b'))->where('a.pPerson=b.tPhone')->where($condition)->select();
       }
       //dump($lj);
       $this->assign("list",$list);
       $this->display('Exam/gradeList2');
   }

    public function analysis(){
       $grade = M('Grade');
       //0-30分
       $data['pId'] = I('get.pId');
       $data['grade'] = array(array('egt', 0), array('lt', 30));
       $one = $grade->where($data)->count();

       $data['grade'] = array(array('egt', 30), array('lt', 60));
       $two = $grade->where($data)->count();

       $data['grade'] = array(array('egt', 60), array('lt', 80));
       $three = $grade->where($data)->count();

       $data['grade'] = array(array('egt', 80), array('elt', 100));
       $four = $grade->where($data)->count();
  
       $this->assign('one',$one);
       $this->assign('two',$two);
       $this->assign('three',$three);
       $this->assign('four',$four);

       $this->display();
   }
    

}