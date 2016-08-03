<?php
require(dirname(__FILE__)."/Controller.php");
require(dirname(__FILE__)."/MongodbUtil.php");
require(dirname(__FILE__)."/MysqlUtil.php");
require(dirname(__FILE__)."/Router.php");
class Application{
	/**
	 * 
	 * @var router
	 */
	public static $router;
	private function __construct(){
		
	}
	public static function run(){
		self::$router = new router();
		self::$router->route();
	}
	/**
	 * @param array $p
	 * array(
	 * 	"m" => "",
	 * 	"c" => "",
	 * 	"a" => ""
 	 * )
 	 * 将当前URL按MODULE,CONTROL,ACTION来相应替换
 	 * 返回新的URL
	 */
	public static function replace_url($p = array()){
		$module = isset($p["m"]) ? $p["m"] : self::$router->getModule();
		$contrl = isset($p["c"]) ? $p["c"] : self::$router->getController();
		$action = isset($p["a"]) ? $p["a"] : self::$router->getAction();
		$url = HTTP_ENTRY;
		if ($module !== DEFAULT_MODULE) {
			$url .= '/'.$module;
		}
		$url .= '/'.$contrl;
		$url .= '/'.$action;
		if (self::$router->getPathinfo()) {
			$url .= '/'.self::$router->getPathinfo();
		}
		$query = http_build_query($_GET);
		if ($query) {
			return $url . '?' . $query;
		}
		return $url;
	}
	public static function url_ca($ctl,$act) {
		return HTTP_ENTRY.'/'.$ctl.'/'.$act;
	}
	public static function isPost(){
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}
	public static function getUserAgent() {
		return $_SERVER['HTTP_USER_AGENT'];
	}
	public static function getClientIp() {
		$ip = $_SERVER["REMOTE_ADDR"];
		if(substr($ip,0,7) === "192.168" || substr($ip,0,3) === "127"){
			$fip = Application::getForwardIp();
			if ($fip) {
				$ip = $fip;
			}
		}
		return($ip);
	}
	private static function getForwardIp(){
		$ip = getenv("HTTP_X_Forwarded_For");
		if(strpos($ip, ",") !== false){
			$ips = explode(",",$ip);
			$ip = $ips[sizeof($ips)-1];
		}
		return $ip;
	}


	public static function tokenValid($telphone, $token){
		$tokendate = date("Ym",strtotime("now")).floor(date("d",strtotime("now"))/16); //15天过期
		$validtoken = md5($telphone.$tokendate);

		if($validtoken === $token){
			return true;
		}else{
			return fasle;
		}
	}
}