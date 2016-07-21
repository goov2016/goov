<?php
class MainController extends Controller{
	function __construct () {
		parent::__construct("site"); //继承其父类的构造函数
		//echo "MainController";
	}
	public function actionIndex(){
		return $this->render('index', array('title'=>"主页"));
		//echo "main/index";
	}
	public function actionLogin(){
		if(isset($_POST['name'])){
			$name = $_POST['name'];
			$pwd = $_POST['pwd'];
			
			setcookie("loginname", $name, time()+1200);
			//return $this->render('index', array());
			header("Location: /joyhr/index.php?ctr=comm&act=index");
			//确保重定向后，后续代码不会被执行
			exit;
		}else{
			return $this->render('login', array());
		}
	}
	public function actionInvalid(){
	     
		return $this->render('invalid', array());
	
	}
	
	
}