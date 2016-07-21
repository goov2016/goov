<?php
//header("Content-Type: text/html; charset=UTF-8"); //因为有时候要输出二进制数据
require(dirname(__FILE__)."/base/Init.php");
require(dirname(__FILE__)."/base/Application.php");   /*require,缺少不让运行；include,缺少不影响网站运行；加once,系统会主动判断只加载一次
														__FILE__,取当前文件的绝对路径。D:\www\test.php
														dirname(__FILE__),取当前文件的绝对目录。D:\www\	*/


Application::run();
// $ctr = "comm";
// $act = "invalid";

// $requri = rtrim($_SERVER["REQUEST_URI"], "/") ;

// $arruri = preg_split("/[\/,]+/", $requri);

// $len = count($arruri);
// //var_dump($arruri);
// $ctr = $arruri[$len-2];
// $act = $arruri[$len-1];

/*if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if(isset($_GET['ctr']))
	{
		global $ctr ;
		$ctr = $_GET['ctr'];
	}
	if(isset($_GET['act']))
	{
		global $act ;
		$act = $_GET['act'];
	}
}else if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['ctr']))
	{
		global $ctr ;
		$ctr = $_POST['ctr'];
	}
	if(isset($_POST['act']))
	{
		global $act;
		$act = $_POST['act'];
	}
}*/
//if (!isset($_COOKIE["loginname"])){
//	$ctr = "comm";
//	$act = "login";
//}
//echo $ctr;
//echo $act;

//exit;


// $actfile = dirname(__FILE__)."/controllers/".ucwords($ctr)."Controller.php";

// if(!file_exists($actfile))
// {
// 	$ctr = "comm";
// 	$act = "invalid";
// 	$actfile = dirname(__FILE__)."/controllers/"."CommController.php";
// }

// require($actfile);


// switch ($ctr)
// {
// 	case "org":
// 		$controller = new OrgController();
// 		switch ($act)
// 		{
// 			case "index":
// 				echo $controller->actionIndex();
// 				break;
// 			case "creat":
// 				echo $controller->actionCreat();
// 				break;
// 		}
// 		break;
// 	case "user":
// 		$controller = new UserController();
// 		switch ($act)
// 		{
// 			case "index":
// 				echo $controller->actionIndex();
// 				break;
// 			case "creat":
// 				echo $controller->actionCreat();
// 				break;
// 		}
// 		break;
// 	case "comm":
// 		$controller = new CommController();
// 		echo $act;
// 		//break;
// 		switch ($act)
// 		{
// 			case "index":
// 				echo $controller->actionIndex();
// 				break;
// 			case "login":
// 				echo $controller->actionLogin();
// 				break;
// 			default:
// 				echo $controller->actionInvalid();
// 				break;
// 		}
// 		break;
// 	case "api":
// 		$controller = new ApiController();
// 		//echo $act;
// 		//break;
// 		switch ($act)
// 		{
// 			case "user_regist":
// 				echo $controller->actionRegist();
// 				break;
// 			default:
// 				echo $controller->actionInvalid();
// 				break;
// 		}
// 		break;
// 	default:
// 		break;
// }
?>