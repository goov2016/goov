<?php

class ComplainController extends Controller{
	function __construct () {
		parent::__construct(""); //继承其父类的构造函数
	}
	public function actionCreat(){
		//echo date("d",strtotime("now"))/2;

		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
		$obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->uid)){
			$uid = $obj->uid;
			$title = $obj->title;
			$content = $obj->content;
			

			$param=array("uid"=>$uid ,"title"=>$title,"content"=>$content,"status"=>1, "creatdate"=> time());
			$sql = MysqlUtil::GetInstance()->get_insert_db_sql("t_complain",$param);
			$dbrs = MysqlUtil::GetInstance()->exec($sql);

            if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            }
		}
		echo json_encode($result,JSON_UNESCAPED_UNICODE) ;
		die();
	}

	public function actionList(){

		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
	    $obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->uid)){
            $uid = $obj->uid;
            $sql = "select * from t_complain where uid = ".$uid." order by creatdate desc ";//limit 1
            $dbrs = MysqlUtil::GetInstance()->get_all($sql);
            $result['data'] = $dbrs;
		}else{

			$result['actionstatus'] = "error";
            $result['errorinfo'] = '参数有误';
			
		}


        echo json_encode($result,JSON_UNESCAPED_UNICODE);
		die();
    }

    public function actionReply(){
		//echo date("d",strtotime("now"))/2;

		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
		$obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->uid)){
			$uid = $obj->uid;
			$complainid = $obj->complainid;
			$content = $obj->content;
			

			$param=array("uid"=>$uid ,"complainid"=>$complainid,"content"=>$content,"anonymous"=>1, "replydate"=> time());
			$sql = MysqlUtil::GetInstance()->get_insert_db_sql("t_complain_reply",$param);
			$dbrs = MysqlUtil::GetInstance()->exec($sql);

            if (!$dbrs['rs']){
            	$result['actionstatus'] = "error";
            	$result['errorinfo'] = $dbrs['errorinfo'];
            }
		}
		echo json_encode($result,JSON_UNESCAPED_UNICODE) ;
		die();
	}

	public function actionReplyList(){

		$result = array('actionstatus' => "ok", 'errorcode'=>0,'errorinfo'=>'');
	    $obj = json_decode(file_get_contents("php://input"));
		if(isset($obj->complainid)){
            $complainid = $obj->complainid;
            $sql = "select * from v_complain_reply where complainid = ".$complainid." order by replydate desc ";//limit 1
            $dbrs = MysqlUtil::GetInstance()->get_all($sql);
            $result['data'] = $dbrs;
		}else{

			$result['actionstatus'] = "error";
            $result['errorinfo'] = '参数有误';
			
		}


        echo json_encode($result,JSON_UNESCAPED_UNICODE);
		die();
    }
}