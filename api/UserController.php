<?php
/**
 * Date: 2015年12月4日
 * Author: Awei.tian
 * Description: 
 */
class UserController extends Controller{
	function __construct () {
		parent::__construct(""); //继承其父类的构造函数
	}
	public function actionReg(){
	

	    $obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->telphone)){
			//$model = new OrgModel();
			//$model->orgname = 
			$telphone = $obj->telphone;
			$pwd = $obj->pwd;
			$validcode = $obj->validcode;
			// $model->email =  $_POST['email'];
			// $model->telphone = $_POST['telphone'];
			// $model->pcode = $_POST['pcode'];
			// $model->sex = $_POST['sex'];
			// $model->job = $_POST['job'];
			// $model->education = $_POST['education'];
			// $model->birthday = $_POST['birthday'];
			// $model->joindate = $_POST['joindate'];
			$param=array("telphone"=>$telphone ,"pwd"=>$validcode);
		
		    $result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
		

			$sql = MysqlUtil::GetInstance()->get_insert_db_sql("t_user",$param);
			//echo $sql;

			$dbrs = MysqlUtil::GetInstance()->exec($sql);

            if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            }
			//exit();

			// if($dbresult>0){
			// 	$result
			// }


			echo json_encode($result) ;
			
			// if($mysql->insert("user_info", $_POST))
			// {
			// 	echo "<script>alert('ok');</script>";
			// }
			
			// header("Location: /joyhr/index.php?ctr=user&act=index");
			exit();
			//return $this->render('index', array());
		}else{
			return $this->render('creat', array('model'=>$model));
		}


		echo "api/user/reg";
	}
}