<?php
/**
 * Date: 2015年12月4日
 * Author: lis
 * Description: 
 */
class OrgController extends Controller{
	function __construct () {
		parent::__construct(""); //继承其父类的构造函数

		require_once(dirname(__FILE__) . '/../models/OrgModel.php');
	}
	public function actionReg(){

		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
	    $obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->email)){
			//$model = new OrgModel();
			//$model->orgname = 
			$email = $obj->email;
			$pwd = $obj->pwd;
			$validcode = $obj->validcode;

            $orgcode = uniqid();
	
	        MysqlUtil::GetInstance()->autocommit(false); // 开始事务
			$param=array("orgcode"=>$orgcode ,"regdate"=> time());
			$sql = MysqlUtil::GetInstance()->get_insert_db_sql("t_org",$param);
			$dbrs = MysqlUtil::GetInstance()->exec($sql);
			if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            	MysqlUtil::GetInstance()->rollback();
                echo json_encode($result);
		        die();
            }
            $orgid = MysqlUtil::GetInstance()->last_id();
			$param=array("orgid"=>$orgid,"telphone"=>$email ,"pwd"=>$pwd,"roleid"=>3, "regdate"=> time());
			$sql = MysqlUtil::GetInstance()->get_insert_db_sql("t_user",$param);
	        $dbrs = MysqlUtil::GetInstance()->exec($sql);
			if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            	MysqlUtil::GetInstance()->rollback();
                echo json_encode($result);
		        die();
            }
			$userid = MysqlUtil::GetInstance()->last_id();
			$param=array("orgid"=>$orgid,"uid"=>$userid ,"status"=>2, "enterdate"=> time());
			$sql = MysqlUtil::GetInstance()->get_insert_db_sql("t_uorgrecord",$param);
	        $dbrs = MysqlUtil::GetInstance()->exec($sql);
			if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            	MysqlUtil::GetInstance()->rollback();
                echo json_encode($result);
		        die();
            }

            MysqlUtil::GetInstance()->commit();


            $to = $email;
			$subject = "倾说账号激活";
			$message = "http://localhost:81/api/org/active?orgcode=".$orgcode ;
			$from = "admin@mycompany.com";
			$headers = "From: 倾说";
			mail($to,$subject,$message,$headers);
			echo "Mail Sent.";
	
		}else{

			$result['actionstatus'] = "error";
            $result['errorinfo'] = '参数有误';
			
		}

        echo json_encode($result,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function actionActive(){

		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
	    $orgcode = $_GET["orgcode"];//    json_decode(file_get_contents("php://input"));
		if(isset($orgcode)){
			//$orgcode = $obj->orgcode;
			$param=array("status"=>1);
			$sql = MysqlUtil::GetInstance()->get_update_db_sql("t_org",$param," orgcode = '".$orgcode."'");
			$dbrs = MysqlUtil::GetInstance()->exec($sql);
            if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            }
	
		}else{

			$result['actionstatus'] = "error";
            $result['errorinfo'] = '参数有误';
		}

        echo json_encode($result,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function actionComplete(){

		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
	    $obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->orgcode)){
			$orgcode = $obj->orgcode;
            $orgname = $obj->orgname;
            $licenseno = $obj->licenseno;
            $address = $obj->address;
            $owner = $obj->owner;
            $ownerlic = $obj->ownerlic;
            $ownertel = $obj->ownertel;
            $validcode = $obj->validcode;
            $param=array("orgname"=>$orgname,"licenseno"=>$licenseno,"address"=>$address,"owner"=>$owner,"ownerlic"=>$ownerlic,"ownertel"=>$ownertel);
			$sql = MysqlUtil::GetInstance()->get_update_db_sql("t_org",$param," orgcode = '".$orgcode."'");
			$dbrs = MysqlUtil::GetInstance()->exec($sql);
            if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            }

		}else{

			$result['actionstatus'] = "error";
            $result['errorinfo'] = 'param error';
		}

        echo json_encode($result,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function actionSearch(){

		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
	    $obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->searchkey)){
       
            $sql = "select * from t_org where orgname like '%".$obj->searchkey."%'";
            $dbrs = MysqlUtil::GetInstance()->get_all($sql);
            $result['data'] = $dbrs;
		}else{

			$result['actionstatus'] = "error";
            $result['errorinfo'] = '参数有误';
			
		}


        echo json_encode($result,JSON_UNESCAPED_UNICODE);
		die();
    }

//请求进入公司
    public function actionReqJoin(){

		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
	    $obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->orgid)){
            $orgid = $obj->orgid;
            $userid = $obj->userid;

          	$param=array("orgid"=>$orgid,"uid"=>$userid ,"status"=>1, "enterdate"=> time());
			$sql = MysqlUtil::GetInstance()->get_insert_db_sql("t_uorgrecord",$param);
	        $dbrs = MysqlUtil::GetInstance()->exec($sql);
			if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
		        die();
            }
		}else{

			$result['actionstatus'] = "error";
            $result['errorinfo'] = '参数有误';
			
		}


        echo json_encode($result,JSON_UNESCAPED_UNICODE);
		die();
    }

//答复请求，同意或拒绝
    public function actionReply(){

		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
	    $obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->urecid)){
            $urecid = $obj->urecid;
            $reply = $obj->reply;  //同意或失败true 或 false
            //$userid = $obj->userid;  //同意或失败true 或 false

            $dbrs = MysqlUtil::GetInstance()->get_row("select * from t_uorgrecord where urecid=".$urecid);

            var_dump($dbrs);
            $userid = $dbrs["uid"];
            $orgid = $dbrs["orgid"];

            MysqlUtil::GetInstance()->autocommit(false); // 开始事务
          	$param=array("status"=>$reply?2:3,"enterdate"=> time());
			$sql = MysqlUtil::GetInstance()->get_update_db_sql("t_uorgrecord",$param," urecid = '".$urecid."'");
			$dbrs = MysqlUtil::GetInstance()->exec($sql);
            if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            	MysqlUtil::GetInstance()->rollback();
                echo json_encode($result);
		        die();
            }


            $param=array("orgid"=>$orgid);
			$sql = MysqlUtil::GetInstance()->get_update_db_sql("t_user",$param," uid = '".$userid."'");
			$dbrs = MysqlUtil::GetInstance()->exec($sql);
            if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            	MysqlUtil::GetInstance()->rollback();
                echo json_encode($result);
		        die();
            }


            MysqlUtil::GetInstance()->commit();
		}else{

			$result['actionstatus'] = "error";
            $result['errorinfo'] = '参数有误';
			
		}


        echo json_encode($result,JSON_UNESCAPED_UNICODE);
		die();
    }
}