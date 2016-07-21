<?php
/**
 * Date: 2015年11月4日
 * Authro: Awei.tian
 * Description: 
 * 		requestUri = HTTP入口路径 + MODULE + CONTROL + ACTION + PATHINFO
 * 
 */

class router{
	private $ip;
	private $url;
	private $module;
	private $control;
	private $method;
	private $pathinfo;
	/**
	 * 模块所在的文件路径
	 * @var string
	 */
	private $module_loc;
	public function __construct(){
		$this->url = $this->requestUri();
	}
	public function getController(){
		return $this->control;
	}
	public function getAction(){
		return $this->method;
	}
	public function getPathinfo(){
		return $this->pathinfo;
	}
	public function getModule(){
		return $this->module;
	}
	public function response($msg) {
		echo '<!DOCTYPE html><html><head><meta content="text/html; charset=utf-8" http-equiv="content-type"/></head><body>';
		echo $msg;
		echo '</body></html>';
		exit;
	}
	public function _404(){
		@header('HTTP/1.x 404 Not Found');
		@header('Status: 404 Not Found');
		$this->response("<p align='center'>".file_get_contents(FILE_SYSTEM_ENTRY."/img/404.php")."<br><br><a href='".HTTP_ENTRY."'>back to Home</a></p>") ;
	}
	private function requestUri(){
		if (isset($_SERVER['HTTP_X_REWRITE_URL'])){
			$uri = $_SERVER['HTTP_X_REWRITE_URL'];
		}elseif (isset($_SERVER['REQUEST_URI'])){
			$uri = $_SERVER['REQUEST_URI'];
		}elseif (isset($_SERVER['ORIG_PATH_INFO'])){
			$uri = $_SERVER['ORIG_PATH_INFO'];
			if (! empty($_SERVER['QUERY_STRING'])){
				$uri .= '?' . $_SERVER['QUERY_STRING'];
			}
		}else{
			$uri = '';
		}
		return $uri;
	}
	private function stripHttpEntry() {
		if (HTTP_ENTRY != '') {
			if (strpos($this->url, HTTP_ENTRY) === 0) {
				return substr($this->url, strlen(HTTP_ENTRY));
			}
		} 
		return $this->url;
	}
	private function stripModule($path) {
		$u = explode("/", trim($path,"/"),3);
		if ($u[0] == "api") {
			$this->module = "api";
			$this->module_loc = "/api";
			array_shift($u);
			return join($u,"/");
		} else {
			$this->module = DEFAULT_MODULE;
			$this->module_loc = "/controllers";
			return $path;
		}
	}
	public function route() {
		$url = parse_url($this->stripHttpEntry());
		if($url["path"] == "" || $url["path"] == "/"){
			$url["path"] = "main";
		}
		$misc = "";
		
		if(isset($url["path"])) {
			$path = $url["path"];
			$cap = $this->stripModule($path);
			$cls = explode("/", trim($cap,"/"),3);
			if (count($cls) == 0) {
				$cls = "main";
				$this->method = "";
				$this->pathinfo = "";
			} else if(count($cls) == 1) {
				$cls = $cls[0];
				$this->method = "";
				$this->pathinfo = "";
			} else if(count($cls) == 2) {

				$this->method = $cls[1];
				$cls = $cls[0];
				$this->pathinfo = "";
			} else {
				$this->method = $cls[1];
				$this->pathinfo = $cls[2];
				$cls = $cls[0];
			}	
// 			var_dump($cls);

			$controlLoc = FILE_SYSTEM_ENTRY.$this->module_loc.DIRECTORY_SEPARATOR.""
					.ucfirst(($cls))."Controller.php";
// 			echo $controlLoc;		
			$clsName = $cls."Controller";
			if(!class_exists($clsName)){
				if(file_exists($controlLoc)){
					require_once($controlLoc);
				}
				if (!class_exists($clsName)){
					$this->_404();
				}
			}
			$this->inst($clsName);
		} else {
			$this->_404();
		}
	}
	private function inst($clsName){
		$rc=new ReflectionClass($clsName);
		if (!$rc->hasMethod("_checkPrivilege") or !$rc->getMethod("_checkPrivilege")->isStatic()) {
			$this->_404();
			return true;
		}
		if(call_user_func_array($clsName."::_checkPrivilege",array()) !== true){
			$this->response("Permission denied!");
		}
		if ($this->method) {
			$controller = $rc->newInstance();
			$m = "action".ucfirst(($this->method));
			if (!$rc->hasMethod($m)) {
				$this->_404();
			}
			$this->control = $clsName;
			$method=$rc->getMethod($m);
			$method->invokeArgs($controller, array($this->pathinfo));
		} else {
			$this->control = $clsName;
			$rc->newInstance();
		}
	}
}