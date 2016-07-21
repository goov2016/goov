<?php
/**
 * Date: 2015年12月4日
 * Author: lis
 * Description: 
 */
class UserController extends Controller{
	function __construct () {
		parent::__construct(""); //继承其父类的构造函数
	}
	public function actionLogin(){
		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
		$obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->telphone)){
			$dbrs = MysqlUtil::GetInstance()->get_row("select * from t_user where telphone=".$obj->telphone.' and pwd='.$obj->pwd);
			if(!isset($dbrs)){
				$result['actionstatus'] = "error";
            	$result['errorinfo'] = "no result";
			}
			
		}
		echo json_encode($result) ;
		die();
	}
	public function actionReg(){
	
        $result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
	    $obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->telphone)){
			//$model = new OrgModel();
			//$model->orgname = 
			$telphone = $obj->telphone;
			$pwd = $obj->pwd;
			$validcode = $obj->validcode;

			$param=array("telphone"=>$telphone ,"pwd"=>$validcode);
		
			$sql = MysqlUtil::GetInstance()->get_insert_db_sql("t_user",$param);

			$dbrs = MysqlUtil::GetInstance()->exec($sql);

            if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            }
	
		}else{

			$result['actionstatus'] = "error";
            $result['errorinfo'] = '参数有误';
			
		}

        echo json_encode($result);
		die();
	}
}