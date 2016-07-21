<?php
class UserController extends Controller{
	function __construct () {
		parent::__construct("user"); //继承其父类的构造函数
		$dir = dirname(__FILE__);
		require_once($dir . '/../models/UserModel.php');
	}
	public function actionIndex(){
		$mongo = new MongodbUtil("127.0.0.1:27017");
		$mongo->selectDb("hrdb");
		$result = $mongo->find("user_info", array('telphone'=>array('$exists'=>true)),array(),array('_id'=>false));
 		return $this->render('index', $result);
		
	}
	
	public function actionCreat(){
	
		if(isset($_POST['name'])){
			$model = new UserModel();
			$model->username = $_POST['name'];
			$model->email =  $_POST['email'];
			$model->telphone = $_POST['telphone'];
			$model->pcode = $_POST['pcode'];
			$model->sex = $_POST['sex'];
			$model->job = $_POST['job'];
			$model->education = $_POST['education'];
			$model->birthday = $_POST['birthday'];
			$model->joindate = $_POST['joindate'];
			
			
			$mongo = new MongodbUtil("127.0.0.1:27017");
			$mongo->selectDb("hrdb");
			if($mongo->insert("user_info", $_POST))
			{
				echo "<script>alert('ok');</script>";
			}
			
			header("Location: /joyhr/index.php?ctr=user&act=index");
			exit;
			//return $this->render('index', array());
		}else{
			return $this->render('creat', array(
					'model'=>$model));
		}
	

		
	
	
	
	}
}
?>