<?php
namespace Back\Controller;
use Think\Controller;


class CheckAdminController extends Controller
{	
	function _initialize()      //管理员权限
	{
		if(session('?aName')){

		 }
		 else{
				$this->redirect('./index/');
			}
}
}