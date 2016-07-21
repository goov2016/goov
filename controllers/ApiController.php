<?php
class ApiController extends Controller{
	function __construct () {
		parent::__construct(""); //继承其父类的构造函数
	}
	public function actionRegist(){

       /* if(isset($_POST['name'])){
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
		}*/


		return 'ok';

	}
	public function actionInvalid(){
	     
		return $this->render('invalid', array());
	
	}
	
	
}