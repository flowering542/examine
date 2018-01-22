<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;

class StudentController extends CheckStudentController {

    public function index(){
         $this->display('Student/testCode');
    }

    public function testCode(){
         $data['pCode'] = I('post.pCode');
         $paper = M('Paper');
         $count1 = $paper->where($data)->count(); //访问码存在否
       // $this->ajaxReturn($count1); exit;
         if($count1 == 1){
            //1到考试时间没有
             $pBtime = $paper->where($data)->getField('pBtime');
             $now = date('Y-m-d H:i:s');
            // echo strtotime($now)."|".strtotime($pBtime); exit;
             if(strtotime($pBtime) <= strtotime($now)){
                 //判断考试是否结束
                 $pEtime = $paper->where($data)->getField('pEtime');
                 $now = date('Y-m-d H:i:s');
                  if(strtotime($pEtime) >= strtotime($now)){
                         //2是否是第一次进入
                         $res = $paper->where($data)->getField('pId');
                         $condition['sId'] = session('sId');
                         session('pId',$res);
                         $condition['pId'] = $res;
                         $testinfo = M('testinfo');
                         $count2 = $testinfo->where($condition)->count();
                         if($count2 == 1){ //$count2 == 1 代表第二次进入
                                //是否有剩余的时间
                                $remainTime = $testinfo->where($condition)->getField('remainTime');
                                if($remainTime > 0){
                                      $list['res'] = $condition;
                                      $list['info'] = "three";
                                      $this->ajaxReturn($list);
                                }
                                else{
                                      $list['res'] = '';
                                      $list['info'] = "noThree";
                                      $this->ajaxReturn($list);
                                }
                         }
                         else{
                              $list['res'] = $res;
                              $list['info'] = "noTwo";
                              $this->ajaxReturn($list);
                         }
                  }
                  else{
                         $list['res'] = '';
                         $list['info'] = "end";
                         $this->ajaxReturn($list);
                  }
                    
             }
             else{
                 $list['res'] = '';
                 $list['info'] = "noOne";
                 $this->ajaxReturn($list);
             }

         }
         else{
             $list['res'] = '';
             $list['info'] = "no";
             $this->ajaxReturn($list);
         }
    }

    public function testing(){
        $pId = I('get.pId');
        if(empty(I('get.pId'))){$pId = session('pId');}
        //第一次考试
         if(empty(I('get.sId'))){
               $my['pId'] = $pId;
               $my['sId'] = session('sId');
               $testi = M('testinfo');
               $wo = $testi->where($my)->count();
               //dump($wo);exit;
              if($wo <= 0){
              //  echo "string";exit;
                 $paper = M('Paper');
                 $testinfo = M('testinfo');
                 $data['pId'] = $pId;
                 $pEtime = $paper->where($data)->getField('pEtime');
                 $pName = $paper->where($data)->getField('pName');
                 $now = date('Y-m-d H:i:s');
                 $data['sId'] = session('sId');
                 $rtime = ceil((strtotime($pEtime)-strtotime($now))%86400/60);
                 //echo $rtime; exit;
                 if($rtime < 0) {$rtime = 0;}
                 $data['remainTime'] = $rtime;
                 $data['submit'] = false;
                 $data['bTime'] = $now;
                 $data['eTime'] = $pEtime;
                //dump($data); exit;
                 if(($testinfo->where($data)->count()) == 0){
                     $res = $testinfo->add($data);
                     if($res === false) $this->error("考试结束！");
                 }
                 $qCount = 0; //试卷大题数 
                 //单选题 个数
                 $con1['type'] = "单选题";
                 $con1['pId'] = $pId;
                 $paperdetail = M('Paperdetail');
                 $singleCount = $paperdetail->where($con1)->count();
                 if($singleCount >= 1) {$qCount++;$qAarry['single'] = "s";$qNum['s'] = $singleCount;}
                 else {$qNum['s'] = "";}
                  //单选题 数组
                 $single = $paperdetail->field('pId,tId,type,sTitle,sA,sB,sC,sD,sTrue,score')->table(array('ks_paperdetail'=>'a','ks_single'=>'b'))->where('b.sId=a.tId')->where($con1)->select();
                 shuffle($single); //打乱数组
                 //dump($single);
                 //多选题 个数
                 $con2['type'] = "多选题";
                 $con2['pId'] = $pId;
                 $multiCount = $paperdetail->where($con2)->count('tId');
                 if($multiCount >= 1)  {$qCount++;$qAarry['multi'] = "m";$qNum['m'] = $multiCount;}
                 else{$qNum['m'] = "";}
                 //多选题 数组
                 $multi = $paperdetail->field('pId,tId,type,mTitle,mA,mB,mC,mD,mTrue,score')->table(array('ks_paperdetail'=>'a','ks_multi'=>'b'))->where('b.mId=a.tId')->where($con2)->select();
                 shuffle($multi);
                 //dump($multi);
                //填空题 个数
                 $con3['type'] = "填空题";
                 $con3['pId'] = $pId;
                 $blankCount = $paperdetail->where($con3)->count();
                 //dump($blankCount); exit;
                 if($blankCount >= 1)  {$qCount++;$qAarry['blank'] = "b";$qNum['b'] = $blankCount;}
                 else{$qNum['b'] = "";}
                 //多选题 数组
                 $blank = $paperdetail->field('pId,tId,type,bTitle,bTrue,score')->table(array('ks_paperdetail'=>'a','ks_blank'=>'b'))->where('b.bId=a.tId')->where($con3)->select();
                 shuffle($blank);
                 //dump($multi);
                 //判断题 个数
                 $con4['type'] = "判断题";
                 $con4['pId'] = $pId;
                 $judgeCount = $paperdetail->where($con4)->count();
                 if($judgeCount >= 1)  {$qCount++;$qAarry['judge'] = "j";$qNum['j'] = $judgeCount;}
                 else{$qNum['j'] = "";}
                 //判断题 数组
                 $judge = $paperdetail->field('pId,tId,type,jTitle,jTrue,score')->table(array('ks_paperdetail'=>'a','ks_judge'=>'b'))->where('b.jId=a.tId')->where($con4)->select();
                 shuffle($judge);
                 //dump($multi);
                //简答题 个数
                 $con5['type'] = "简答题";
                 $con5['pId'] = $pId;
                 $questionCount = $paperdetail->where($con5)->count();
                 if($questionCount >= 1)  {$qCount++;$qAarry['question'] = "q";$qNum['q'] = $questionCount;}
                 else{$qNum['q'] = "";}
                 //多选题 数组
                 $question = $paperdetail->field('pId,tId,type,qTitle,qTrue,score')->table(array('ks_paperdetail'=>'a','ks_question'=>'b'))->where('b.qId=a.tId')->where($con5)->select();
                 shuffle($question);
                 //dump($multi);
                 //文件上传题 个数
                 $con6['type'] = "文件上传题";
                 $con6['pId'] = $pId;
                 $fileCount = $paperdetail->where($con6)->count();
                 if($fileCount >= 1)  {$qCount++;$qAarry['file'] = "f";$qNum['f'] = $fileCount;}
                 else{$qNum['f'] = "";}
                 //多选题 数组
                 $file = $paperdetail->field('pId,tId,type,fTitle,fPath,fTrue,score')->table(array('ks_paperdetail'=>'a','ks_file'=>'b'))->where('b.fId=a.tId')->where($con6)->select();
                 shuffle($file);
                 //dump($single);exit;
                 $this->assign('qCount',$qCount); //题型个数
                 $this->assign('qAarry',$qAarry);
                 $this->assign('qNum',$qNum);
                 $this->assign('single',$single);
                 $this->assign('multi',$multi);
                 $this->assign('judge',$judge);
                 $this->assign('blank',$blank);
                 $this->assign('question',$question);
                 $this->assign('file',$file);
                 //考试名称
                 $this->assign('pName',$pName);
                 //考试剩余时间
                 $this->assign('rtime',$rtime);
                 $this->display('Student/testing');
              }
            else{
                 $paper = M('Paper');
                 $testinfo = M('testinfo');
                 $data['pId'] = $pId;
                 $pEtime = $paper->where($data)->getField('pEtime');
                 $pName = $paper->where($data)->getField('pName');
                 $now = date('Y-m-d H:i:s');
                 $data['sId'] = session('sId');
                 $rtime = ceil((strtotime($pEtime)-strtotime($now))%86400/60);
                 //echo $rtime; exit;
                 if($rtime < 0) {$rtime = 0;}
                 $data['remainTime'] = $rtime;
                 $data['submit'] = false;
                 $data['bTime'] = $now;
                 $data['eTime'] = $pEtime;
                //dump($data); exit;
                 $res = $testinfo->save($data);
                 if($res === false) $this->error("考试结束！");
                 $qCount = 0; //试卷大题数   $qAarry
                 //单选题 个数
                 $paperdetail = M('Paperdetail');
                 $con1['type'] = "单选题";
                 $con1['pId'] = $pId;
                 $singleCount = $paperdetail->where($con1)->count();
                 if($singleCount >= 1) {$qCount++;$qAarry['single'] = "s";$qNum['s'] = $singleCount;}
                 else {$qNum['s'] = "";}
                  //单选题 数组
                 $single = $paperdetail->field('pId,tId,type,sTitle,sA,sB,sC,sD,sTrue,score')->table(array('ks_paperdetail'=>'a','ks_single'=>'b'))->where('b.sId=a.tId')->where($con1)->select();
                 shuffle($single); //打乱数组
                 //dump($single);
                 //多选题 个数
                 $con2['type'] = "多选题";
                 $con2['pId'] = $pId;
                 $multiCount = $paperdetail->where($con2)->count('tId');
                 if($multiCount >= 1)  {$qCount++;$qAarry['multi'] = "m";$qNum['m'] = $multiCount;}
                 else{$qNum['m'] = "";}
                 //多选题 数组
                 $multi = $paperdetail->field('pId,tId,type,mTitle,mA,mB,mC,mD,mTrue,score')->table(array('ks_paperdetail'=>'a','ks_multi'=>'b'))->where('b.mId=a.tId')->where($con2)->select();
                 shuffle($multi);
                 //dump($multi);
                //填空题 个数
                 $con3['type'] = "填空题";
                 $con3['pId'] = $pId;
                 $blankCount = $paperdetail->where($con3)->count();
                 //dump($blankCount); exit;
                 if($blankCount >= 1)  {$qCount++;$qAarry['blank'] = "b";$qNum['b'] = $blankCount;}
                 else{$qNum['b'] = "";}
                 //多选题 数组
                 $blank = $paperdetail->field('pId,tId,type,bTitle,bTrue,score')->table(array('ks_paperdetail'=>'a','ks_blank'=>'b'))->where('b.bId=a.tId')->where($con3)->select();
                 shuffle($blank);
                 //dump($multi);
                 //判断题 个数
                 $con4['type'] = "判断题";
                 $con4['pId'] = $pId;
                 $judgeCount = $paperdetail->where($con4)->count();
                 if($judgeCount >= 1)  {$qCount++;$qAarry['judge'] = "j";$qNum['j'] = $judgeCount;}
                 else{$qNum['j'] = "";}
                 //多选题 数组
                 $judge = $paperdetail->field('pId,tId,type,jTitle,jTrue,score')->table(array('ks_paperdetail'=>'a','ks_judge'=>'b'))->where('b.jId=a.tId')->where($con4)->select();
                 shuffle($judge);
                 //dump($multi);
                //简答题 个数
                 $con5['type'] = "简答题";
                 $con5['pId'] = $pId;
                 $questionCount = $paperdetail->where($con5)->count();
                 if($questionCount >= 1)  {$qCount++;$qAarry['question'] = "q";$qNum['q'] = $questionCount;}
                 else{$qNum['q'] = "";}
                 //多选题 数组
                 $question = $paperdetail->field('pId,tId,type,qTitle,qTrue,score')->table(array('ks_paperdetail'=>'a','ks_question'=>'b'))->where('b.qId=a.tId')->where($con5)->select();
                 shuffle($question);
                 //dump($multi);
                 //文件上传题 个数
                 $con6['type'] = "文件上传题";
                 $con6['pId'] = $pId;
                 $fileCount = $paperdetail->where($con6)->count();
                 if($fileCount >= 1)  {$qCount++;$qAarry['file'] = "f";$qNum['f'] = $fileCount;}
                 else{$qNum['f'] = "";}
                 //多选题 数组
                 $file = $paperdetail->field('pId,tId,type,fTitle,fPath,fTrue,score')->table(array('ks_paperdetail'=>'a','ks_file'=>'b'))->where('b.fId=a.tId')->where($con6)->select();
                 shuffle($file);
                 //dump($single);exit;
                //显示提交题型
                 $answer = M('Answer');
                 $da1['sId'] = session('sId');
                 $da1['pId'] = $pId;
                 $da1['type'] = "单选题";
                 $list1 = $answer->where($da1)->select();
                // dump($list1);exit;
                 $da2['sId'] = session('sId');
                 $da2['pId'] = $pId;
                 $da2['type'] = "多选题";
                 $list2 = $answer->where($da2)->select();
                // dump($list1);exit;
                 $da3['sId'] = session('sId');
                 $da3['pId'] = $pId;
                 $da3['type'] = "判断题";
                 $list3 = $answer->where($da3)->select();
                // dump($list1);exit;
                 $da4['sId'] = session('sId');
                 $da4['pId'] = $pId;
                 $da4['type'] = "填空题";
                 $list4 = $answer->where($da4)->select();
                // dump($list1);exit;
                 $da5['sId'] = session('sId');
                 $da5['pId'] = $pId;
                 $da5['type'] = "简答题";
                 $list5 = $answer->where($da5)->select();
                // dump($list1);exit;
                 $da6['sId'] = session('sId');
                 $da6['pId'] = $pId;
                 $da6['type'] = "文件上传题";
                 $list6 = $answer->where($da6)->select();
                // dump($list1);exit;
                 $this->assign('list1',$list1);
                 $this->assign('list2',$list2);
                 $this->assign('list3',$list3);
                 $this->assign('list4',$list4);
                 $this->assign('list5',$list5);
                 $this->assign('list6',$list6);
                 $this->assign('qCount',$qCount); //题型个数
                 $this->assign('qAarry',$qAarry);
                 $this->assign('qNum',$qNum);
                 $this->assign('single',$single);
                 $this->assign('multi',$multi);
                 $this->assign('judge',$judge);
                 $this->assign('blank',$blank);
                 $this->assign('question',$question);
                 $this->assign('file',$file);
                 //考试名称
                 $this->assign('pName',$pName);
                 //考试剩余时间
                 $this->assign('rtime',$rtime);
                 $this->display('Student/testing');
              }

         }
         else{
              //第二次进入试题
                 $paper = M('Paper');
                 $testinfo = M('testinfo');
                 $data['pId'] = $pId;
                 $pEtime = $paper->where($data)->getField('pEtime');
                 $pName = $paper->where($data)->getField('pName');
                 $now = date('Y-m-d H:i:s');
                 $data['sId'] = session('sId');
                 $rtime = ceil((strtotime($pEtime)-strtotime($now))%86400/60);
                 //echo $rtime; exit;
                 if($rtime < 0) {$rtime = 0;}
                 $data['remainTime'] = $rtime;
                 $data['submit'] = false;
                 $data['bTime'] = $now;
                 $data['eTime'] = $pEtime;
                //dump($data); exit;
                 $res = $testinfo->save($data);
                 if($res === false) $this->error("考试结束！");
                 $qCount = 0; //试卷大题数   $qAarry
                 $paperdetail = M('Paperdetail');
                 //单选题 个数
                 $con1['type'] = "单选题";
                 $con1['pId'] = $pId;
                 $singleCount = $paperdetail->where($con1)->count();
                 if($singleCount >= 1) {$qCount++;$qAarry['single'] = "s";$qNum['s'] = $singleCount;}
                 else {$qNum['s'] = "";}
                 //单选题 数组
                 $single = $paperdetail->field('pId,tId,type,sTitle,sA,sB,sC,sD,sTrue,score')->table(array('ks_paperdetail'=>'a','ks_single'=>'b'))->where('b.sId=a.tId')->where($con1)->select();
                 shuffle($single); //打乱数组
                 //dump($single);
                 //多选题 个数
                 $con2['type'] = "多选题";
                 $con2['pId'] = $pId;
                 $multiCount = $paperdetail->where($con2)->count('tId');
                 if($multiCount >= 1)  {$qCount++;$qAarry['multi'] = "m";$qNum['m'] = $multiCount;}
                 else{$qNum['m'] = "";}
                 //多选题 数组
                 $multi = $paperdetail->field('pId,tId,type,mTitle,mA,mB,mC,mD,mTrue,score')->table(array('ks_paperdetail'=>'a','ks_multi'=>'b'))->where('b.mId=a.tId')->where($con2)->select();
                 shuffle($multi);
                 //dump($multi);
                //填空题 个数
                 $con3['type'] = "填空题";
                 $con3['pId'] = $pId;
                 $blankCount = $paperdetail->where($con3)->count();
                 //dump($blankCount); exit;
                 if($blankCount >= 1)  {$qCount++;$qAarry['blank'] = "b";$qNum['b'] = $blankCount;}
                 else{$qNum['b'] = "";}
                 //多选题 数组
                 $blank = $paperdetail->field('pId,tId,type,bTitle,bTrue,score')->table(array('ks_paperdetail'=>'a','ks_blank'=>'b'))->where('b.bId=a.tId')->where($con3)->select();
                 shuffle($blank);
                 //dump($multi);
                 //判断题 个数
                 $con4['type'] = "判断题";
                 $con4['pId'] = $pId;
                 $judgeCount = $paperdetail->where($con4)->count();
                 if($judgeCount >= 1)  {$qCount++;$qAarry['judge'] = "j";$qNum['j'] = $judgeCount;}
                 else{$qNum['j'] = "";}
                 //多选题 数组
                 $judge = $paperdetail->field('pId,tId,type,jTitle,jTrue,score')->table(array('ks_paperdetail'=>'a','ks_judge'=>'b'))->where('b.jId=a.tId')->where($con4)->select();
                 shuffle($judge);
                 //dump($multi);
                //简答题 个数
                 $con5['type'] = "简答题";
                 $con5['pId'] = $pId;
                 $questionCount = $paperdetail->where($con5)->count();
                 if($questionCount >= 1)  {$qCount++;$qAarry['question'] = "q";$qNum['q'] = $questionCount;}
                 else{$qNum['q'] = "";}
                 //多选题 数组
                 $question = $paperdetail->field('pId,tId,type,qTitle,qTrue,score')->table(array('ks_paperdetail'=>'a','ks_question'=>'b'))->where('b.qId=a.tId')->where($con5)->select();
                 shuffle($question);
                 //dump($multi);
                 //文件上传题 个数
                 $con6['type'] = "文件上传题";
                 $con6['pId'] = $pId;
                 $fileCount = $paperdetail->where($con6)->count();
                 if($fileCount >= 1)  {$qCount++;$qAarry['file'] = "f";$qNum['f'] = $fileCount;}
                 else{$qNum['f'] = "";}
                 //多选题 数组
                 $file = $paperdetail->field('pId,tId,type,fTitle,fPath,fTrue,score')->table(array('ks_paperdetail'=>'a','ks_file'=>'b'))->where('b.fId=a.tId')->where($con6)->select();
                 shuffle($file);
                 //dump($single);exit;
                 //显示提交题型
                 $answer = M('Answer');
                 $da1['sId'] = session('sId');
                 $da1['pId'] = $pId;
                 $da1['type'] = "单选题";
                 $list1 = $answer->where($da1)->select();
                // dump($list1);exit;
                 $da2['sId'] = session('sId');
                 $da2['pId'] = $pId;
                 $da2['type'] = "多选题";
                 $list2 = $answer->where($da2)->select();
                // dump($list1);exit;
                 $da3['sId'] = session('sId');
                 $da3['pId'] = $pId;
                 $da3['type'] = "判断题";
                 $list3 = $answer->where($da3)->select();
                // dump($list1);exit;
                 $da4['sId'] = session('sId');
                 $da4['pId'] = $pId;
                 $da4['type'] = "填空题";
                 $list4 = $answer->where($da4)->select();
                // dump($list1);exit;
                 $da5['sId'] = session('sId');
                 $da5['pId'] = $pId;
                 $da5['type'] = "简答题";
                 $list5 = $answer->where($da5)->select();
                // dump($list1);exit;
                 $da6['sId'] = session('sId');
                 $da6['pId'] = $pId;
                 $da6['type'] = "文件上传题";
                 $list6 = $answer->where($da6)->select();
                 //dump($list1);exit;
                 $this->assign('list1',$list1);
                 $this->assign('list2',$list2);
                 $this->assign('list3',$list3);
                 $this->assign('list4',$list4);
                 $this->assign('list5',$list5);
                 $this->assign('list6',$list6);
                 $this->assign('qCount',$qCount); //题型个数
                 $this->assign('qAarry',$qAarry);
                 $this->assign('qNum',$qNum);
                 $this->assign('single',$single);
                 $this->assign('multi',$multi);
                 $this->assign('judge',$judge);
                 $this->assign('blank',$blank);
                 $this->assign('question',$question);
                 $this->assign('file',$file);
                 //考试名称
                 $this->assign('pName',$pName);
                 //考试剩余时间
                 $this->assign('rtime',$rtime);
                 $this->display('Student/testing');
         }
        
    }


    public function studentMessage(){
         $student = M('Student');
         $data['sId'] = session('sId');
         $list = $student->where($data)->find();
         $this->assign("list",$list);
         $this->display('Student/studentMessage');
    }
    
    public function modifyLink(){
         $student = M('Student');
         $data = $student->create();
         $res = $student->save();
         if($res === false){
             $this->error("修改失败！");
         }
         else{
            $this->ajaxReturn("ok");
         }
    }

      public function modifyPwd(){
         $student = M('Student');
         $data['sId'] = I('post.sId');
         $sPwding = $student->where($data)->getField('sPwd');
         $sPwd = md5(I('post.sPwd'));
         $sPwd1 = md5(I('post.sPwd1'));
         if($sPwd != $sPwding){
              $this->ajaxReturn("no");
         }
         $res = $student->where($data)->setField('sPwd',$sPwd1);
         if($res === false){
             $this->error("修改失败！");
         }
         else{
            $this->ajaxReturn("ok");
         }
    }

    public function testGrade(){
        $grade = M('Grade');
        $data['sId'] = session('sId');
        $list = $grade->field('cName,grade')->table(array('ks_grade'=>'a','ks_paper'=>'b'))->where('a.pId=b.pId')->where($data)->select();
        $this->assign('list',$list);
        $this->display('Student/testGrade');
    }

    public function submitSingle(){
         $data['pId'] = session('pId');
         $data['sId'] = session('sId');
         $data['tId'] = I('post.tId');
         $data['type'] = I('post.type');
         $answer = M('Answer');
         $resCount = $answer->where($data)->count();
         if($resCount >= 1){
             //更新考试题目
             $vo['answer'] = I('post.answer');
             $vo['score'] = I('post.score');
             $res = $answer->where($data)->save($vo);
             $this->ajaxReturn($res);
         }
         else{
             $data['answer'] = I('post.answer');
             $data['score'] = I('post.score');
             $res = $answer->add($data);
             $this->ajaxReturn($res);
         }
 
    }

     public function modifySingle(){
         $data['pId'] = session('pId');
         $data['sId'] = session('sId');
         $data['tId'] = I('post.tId');
         $data['type'] = I('post.type');
         $answer = M('Answer');
         $vo['answer'] = I('post.answer');
         $vo['score'] = I('post.score');
         $res = $answer->where($data)->save($vo);
         $this->ajaxReturn($res);
    }

    public  function submitBlank(){
         $data['pId'] = session('pId');
         $data['sId'] = session('sId');
         $data['tId'] = I('post.tId');
         $data['type'] = I('post.type');
         $answer = M('Answer');
         $resCount = $answer->where($data)->count();
         if($resCount >= 1){
             //更新考试题目
             $vo['answer'] = I('post.answer');
             $vo['score'] = I('post.score');
             $res = $answer->where($data)->save($vo);
             $this->ajaxReturn($res);
         }
         else{
             $data['answer'] = I('post.answer');
             $data['score'] = I('post.score');
             $res = $answer->add($data);
             $this->ajaxReturn($res);
         }

    }

    public  function modifyBlank(){
        $data['pId'] = session('pId');
         $data['sId'] = session('sId');
         $data['tId'] = I('post.tId');
         $data['type'] = I('post.type');
         $answer = M('Answer');
         $vo['answer'] = I('post.answer');
         $vo['score'] = I('post.score');
         $res = $answer->where($data)->save($vo);
         $this->ajaxReturn($res);

    }

    public  function submitQuestion(){
         $data['pId'] = session('pId');
         $data['sId'] = session('sId');
         $data['tId'] = I('post.tId');
         $data['type'] = I('post.type');
         $answer = M('Answer');
         $resCount = $answer->where($data)->count();
         if($resCount >= 1){
             //更新考试题目
             $vo['answer'] = I('post.answer');
             $res = $answer->where($data)->save($vo);
             $this->ajaxReturn($data);
         }
         else{
             $data['answer'] = I('post.answer');
             $res = $answer->add($data);
             $this->ajaxReturn($res);
         }

    }

    public  function modifyQuestion(){
         $data['pId'] = session('pId');
         $data['sId'] = session('sId');
         $data['tId'] = I('post.tId');
         $data['type'] = I('post.type');
         $answer = M('Answer');
         $vo['answer'] = I('post.answer');
         $res = $answer->where($data)->save($vo);
         $this->ajaxReturn($res);

    }

    public function submitUpload(){
        $answer = M('Answer');
        $upload = new Upload();
        $filePath = "./Public/Upload/";
        $fileDir = "studentUpload";
        if(!file_exists($filePath)){
            mkdir($filePath);
        }
        if(!file_exists($filePath.$fileDir)){
            mkdir($filePath.$fileDir);
        }
        $upload->maxSize = 10485760;
        $upload->saveName = session('sId').'_'.mt_rand();
        $upload->exts = array('zip','rar','doc','docx');
        $upload->rootPath = "./Public/Upload/$fileDir/";
        $upload->autoSub = true;
        $info = $upload->upload();
        if(!$info){
               $this->error($upload->getError());
        }
        else{
            $vo['pId'] = session('pId');
            $vo['sId'] = session('sId');
            $data = $answer->create();
            $vo['type'] = $data['type'];
            $vo['tId'] = $data['tId'];
            $res1 = $answer->where($vo)->count();
            if($res1 == 0){
                    $data['pId'] = $vo['pId'];
                    $data['sId'] = $vo['sId'];
                    $data['answer'] =  "/Upload/".$fileDir."/".$info['myFile']['savepath'].$info['myFile']['savename'];
                    $res = $answer->add($data);
                    if($res == false){
                        $this->error('上传失败！');
                    }
                    else{
                        $this->redirect('testing');
                    }
            }
            else{
                    $data['pId'] = $vo['pId'];
                    $data['sId'] = $vo['sId'];
                    $data['answer'] =  "/Upload/".$fileDir."/".$info['myFile']['savepath'].$info['myFile']['savename'];
                    $res = $answer->save($data);
                    if($res == false){
                        $this->error('上传失败！');
                    }
                    else{
                        $this->redirect('testing');
                    }
            }
        }
    }

    public function modifyUpload(){
        if(IS_AJAX){
             $data['tId'] = I('post.tId');
             $data['type'] = I('post.type');
             $data['pId'] = session('pId');
             $data['sId'] = session('sId');
             $answer = M('Answer');
             $fileName = $answer->where($data)->getField('answer');
             $pathFile = './Public/'.$fileName;
             $res = $answer->where($data)->delete();
             $b = delDirAndFile($pathFile,false);
             $this->ajaxReturn($res);
        }
    }

}