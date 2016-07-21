<?php
define("FULL_URL",$_SERVER['SERVER_NAME']);

#文件系统入口路径,路径尾部没有 /
define("FILE_SYSTEM_ENTRY",realpath("./"));

#网站HTTP入口路径,网站放在根目录定义为空，假如放在joyhr/1目录下，定义为  /joyhr/1   (以/开头，尾部没有 /)
#http_entry.txt这个文件不提交到SVN
if (file_exists(FILE_SYSTEM_ENTRY."/http_entry.txt")) {
	define("HTTP_ENTRY",file_get_contents(FILE_SYSTEM_ENTRY."/http_entry.txt"));
} else {
	define("HTTP_ENTRY","");
}
define("DEFAULT_MODULE","default");
define("DEFAULT_CONTROLLER","main");
define("DEFAULT_ACTION","index");



define("TEMPLATE_ROOT",dirname(__FILE__)."/../views");

define("URL_ROOT",dirname(__FILE__)."/");






#mysql setting
define("DB_DNS","mysql:host=localhost;dbname=test");
define("DB_HOST","localhost");
define("DB_NAME","goov");
define("DB_USER","root");
define("DB_PASS","soso");
define("DB_PORT","3306");
define("DB_CHARSET","utf8");
?>