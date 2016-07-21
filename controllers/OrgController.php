<?php
class OrgController extends Controller{
	function __construct () {
		parent::__construct("org"); //继承其父类的构造函数
	}
	public function actionIndex(){
		return $this->render('index', array());
	
	}
}