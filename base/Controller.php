<?php
//! Controller

class Controller {
	public $subview; // View 对象
	public static function _checkPrivilege() {
		return true;
	}
	public function __construct($_subview) {
		$this->subview = $_subview;
	}
	public function url($ctr=DEFAULT_CONTROLLER,$act=DEFAULT_ACTION,$module=""){
		return HTTP_ENTRY
		. ($module == "" ? "" : "/".$module) . "/".$ctr . "/".$ctr
		;
	}
	public function render($template, array $para = array()) { //获取View函数

		extract($para);   // 抽取数组中的变量
		//ob_end_clean (); //关闭顶层的输出缓冲区内容
		ob_start ();     // 开始一个新的缓冲区  require
		include   TEMPLATE_ROOT . "/".$this->subview."/". $template . '.php';  //加载视图view
	

		$content = ob_get_contents();             // 获得缓冲区的内容
			
		ob_end_clean ();           // 关闭缓冲区
	
		////ob_end_flush();      // 这个是直接输出缓冲区的内容了，不用再次缓存起来。
		//ob_start();            //开始新的缓冲区，给后面的程序用


		echo $content;       // 返回文本，此处也可以字节echo出来，并结束代码
		

	}
}

class AuthController extends Controller {
	public static function _checkPrivilege() {
		return false;
	}
}
