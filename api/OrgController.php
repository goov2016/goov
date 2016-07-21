<?php
/**
 * Date: 2015年12月4日
 * Author: Awei.tian
 * Description: 
 */
class OrgController extends Controller{
	function __construct () {
		parent::__construct(""); //继承其父类的构造函数

		require_once(dirname(__FILE__) . '/../models/OrgModel.php');
	}
	public function actionReg(){

		//var_dump($_POST);
		$obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->name)){
			$model = new OrgModel();
			$model->orgname = $obj->name;
			// $model->email =  $_POST['email'];
			// $model->telphone = $_POST['telphone'];
			// $model->pcode = $_POST['pcode'];
			// $model->sex = $_POST['sex'];
			// $model->job = $_POST['job'];
			// $model->education = $_POST['education'];
			// $model->birthday = $_POST['birthday'];
			// $model->joindate = $_POST['joindate'];
		
			$result = MysqlUtil::GetInstance()->query_num();
			echo $result;
			
			// if($mysql->insert("user_info", $_POST))
			// {
			// 	echo "<script>alert('ok');</script>";
			// }
			
			// header("Location: /joyhr/index.php?ctr=user&act=index");
			exit;
			//return $this->render('index', array());
		}else{
			return $this->render('creat', array('model'=>$model));
		}
	}
}