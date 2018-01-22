<?php
namespace Back\Controller;
use Think\Controller;


class CheckTeacherController extends Controller
{	
	function _initialize()      //管理员权限
	{
		if(session('?tPhone')){
                
		 }
		 else{
				// $this->redirect('./index/');
		 	    echo "<script> top.location.href = '../index';</script>";
			}
    }
}