<?php
namespace Home\Controller;
use Think\Controller;


class CheckStudentController extends Controller
{	
	function _initialize()      //管理员权限
	{
		if(session('?sId')){

		 }
		 else{
				$this->redirect('./index/');
			}
     }
}