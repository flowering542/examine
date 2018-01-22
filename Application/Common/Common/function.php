<?php

/*	生成学生/老师密码函数。
	*	参数：学号/电话号码
	*	返回值：密码数
	*	适用范围：老师/学生密码生成;
*/
function getPassword($str){
     return substr($str,strlen($str)-6,6);
}
/*  获取文件名函数。
    *   参数：变量值
    *   返回值：string
    *   适用范围：文件名;
*/
function getfname($str){
    $pm = explode('/',$str);
    $count1 = count($pm)-1;
    return $pm[$count1];
}
/*	判断变量的值男/女函数。
	*	参数：变量值
	*	返回值：string
	*	适用范围：input 选择框的判断;
*/
function checkSex1($str){
     if($str === "男"){
     	 return "checked";
     }
     return "";
}
function checkSex2($str){
     if($str === "女"){
     	 return "checked";
     }
     return "";
}
/*  判断单选题checked变量的值A,B,C,D函数。
    *   参数：变量值
    *   返回值：string
    *   适用范围：input 选择框的判断;
*/
function checkA1($str){
     $arr = explode(',', $str);
     $count1 = count($arr);
     for($i=0;$i<$count1;$i++){
          if($arr[$i] === "A"){
            return "checked";
          }
     }
     return "";
}
function checkB1($str){
     $arr = explode(',', $str);
     $count1 = count($arr);
     for($i=0;$i<$count1;$i++){
          if($arr[$i] === "B"){
            return "checked";
          }
     }
     return "";
}
function checkC1($str){
     $arr = explode(',', $str);
     $count1 = count($arr);
     for($i=0;$i<$count1;$i++){
          if($arr[$i] === "C"){
            return "checked";
          }
     }
     return "";
}
function checkD1($str){
     $arr = explode(',', $str);
     $count1 = count($arr);
     for($i=0;$i<$count1;$i++){
          if($arr[$i] === "D"){
            return "checked";
          }
     }
     return "";
}
/*  判断单选题radio变量的值A,B,C,D函数。
    *   参数：变量值
    *   返回值：string
    *   适用范围：input 选择框的判断;
*/
function check1radio4($str){
     if($str === "A"){
         return "checked";
     }
     return "";
}
function check2radio4($str){
     if($str === "B"){
         return "checked";
     }
     return "";
}function check3radio4($str){
     if($str === "C"){
         return "checked";
     }
     return "";
}function check4radio4($str){
     if($str === "D"){
         return "checked";
     }
     return "";
}
function check1radio2($str){
     if($str === "1"){
         return "checked";
     }
     return "";
}
function check2radio2($str){
     if($str === "0"){
         return "checked";
     }
     return "";
}

/*  判断变量的值男/女函数。
    *   参数：变量值
    *   返回值：boolean
    *   适用范围：select 选择框的判断;
*/
function selectSex1($str){
     if($str === "男"){
         return "selected";
     }
     return "";
}
function selectSex2($str){
     if($str === "女"){
         return "selected";
     }
     return "";
}
/*   删除文件目录函数。
     *    参数：路径，是否删除目录
     *    返回值：boolean
     *    适用范围：文件删除
*/
function delDirAndFile($path, $delDir = FALSE) {
    //$path= iconv('utf-8' , 'gbk' ,$path);
    $handle = opendir($path);
    if ($handle) {
        while (($item = readdir($handle)) !== false ) {
            if ($item != "." && $item != "..")
                is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
        }
        closedir($handle);
        if ($delDir) return rmdir($path);
    }else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return FALSE;
        }
    }
}
/*        读取excel函数。
     *    参数：上传excel信息的数组
     *    返回值：数组
     *    适用范围：老师/学生/课程的批量导入
*/
function inExcel($file_arr){
    error_reporting(0);
    set_time_limit(0); //设置页面等待时间
    import("Vendor.excel.PHPExcel","",".php");            //   反斜杠代表当前引入的目录
    $uploadfile =  "./Public/Upload/dataModal/".$file_arr['myFile']['savename'];
     $type = strtolower($file_arr['myFile']['ext']);
     $res = array();
       if($uploadfile){

             if ($type === 'xls') {
                $reader = \PHPExcel_IOFactory::createReader('Excel5'); // 读取 excel 文档

             }
             else if ( $type === 'xlsx') {
                  $reader = \PHPExcel_IOFactory::createReader('Excel2007'); // 读取 excel 文档
              }

             else{
                  exit("上传文件类型错误！");
             }

             $PHPExcel = $reader->load($uploadfile); // 文档名称
             $objWorksheet = $PHPExcel->getActiveSheet();
             $highestRow = $objWorksheet->getHighestRow(); // 取得总行数
             $highestColumn = $objWorksheet->getHighestColumn(); // 取得总列数
             $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
             // 一次读取一列
            
             for ($row = 2; $row <=$highestRow; $row++) {
                 for ($column = 0; $column < $highestColumnIndex; $column++) {
                     $res[$row-2][$column] =(string)$objWorksheet->getCellByColumnAndRow($column,$row)->getValue();
                 //  $val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                 //  $res[$row - 2][$column] = $val;
               }
            }
        }
        else   exit("上传文件不存在！");
        delDirAndFile("./Public/Upload/dataModal/",false);
        return $res;

}
/*        检查读取excel数据字段是否重复函数。
     *    参数：数据数组 / 比较的数组 / 比较的行数 / 信息
     *    返回值：String
     *    适用范围：老师/学生/课程的批量导入 数据的检查
*/
function checkData($excel,$res,$zd="sid",$t=1,$msg="学号已存在！"){
     $count1 = count($excel); 
     $count2 = count($res);
     $str = "";
     //自身比较
     for($i=0;$i<$count1;$i++){
          for($j=$i+1;$j<$count1;$j++){
               if($excel[$i][$t] === $excel[$j][$t]){
                    $a = $i+2;
                    $b = $t+1;
                    $c = $j+2;
                    $str.= "excel表格第".$a."行"."第".$b."列与第".$c."行"."第".$b."列重复存在！<br>";
               }
          }
     }
     //与数据库中的数据比较
     for($i=0;$i<$count1;$i++){
          for($j=0;$j<$count2;$j++){
               if($excel[$i][$t] === $res[$j][$zd]){
                    $m = $i+2;
                    $n = $t+1;
                    $str.= "excel表格第".$m."行"."第".$n."列". $res[$j][$zd].$msg."<br>";
               }
          }
     }
    return $str;
}
/*        检查读取excel数据是否为空函数。
     *    参数：数据数组 / 必填数据到第几列
     *    返回值：String
     *    适用范围：老师/学生/课程的批量导入 数据的检查
*/
function checkNull($excel,$t){
     $count1 = count($excel); 
     $str = "";
     for($i=0;$i<$count1;$i++){
          for($j=0;$j<$t;$j++){
              
                if(empty($excel[$i][$j])){
                     $m = $i+2;
                     $n = $j+1;
                     $str.= "excel表格第".$m."行"."第".$n."列不能为空！<br>";
                }
          }
     }
     return $str;
}
/*        根据试题类型判断进入那个页面
     *    参数：试题Id
     *    返回值：String
     *    适用范围：试题的修改
*/
function judgeIn($quId,$quType){
     switch ($quType) {
            case '单选题':
            return "modifySingle?quId=$quId";
            case '多选题':
             return "modifyMultiple?quId=$quId";
            case '判断题':
             return "modifyJudge?quId=$quId";  
            case '填空题':
            return "modifyBlank?quId=$quId";   
            case '简答题':
              return "modifyQuestion?quId=$quId"; 
            case '文件上传题':
              return "modifyUpload?quId=$quId";      
             default:
                 # code...
            return "#";
         }

}
/*        datetime 类型 转化 date类型
     *    参数：datetime类型的数组
     *    返回值：String
     *    适用范围：日期的修改
*/
function modifyDate(&$arr,$str="ndate"){
    $count1 = count($arr);
    for($i=0;$i<$count1;$i++){
        $date = strtotime($arr[$i][$str]);
        $date = date('Y-m-d',$date);
        $arr[$i][$str] = $date;
    }
}

/*        不超过6的余数
     *    参数：int类型整数
     *    返回值：int
     *    适用范围：
*/
function checkSix($num){
    $num = $num%5;
    return "student/images/".$num.".png";
}