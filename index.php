<?php
function __autoload($name){
	if(file_exists("./action/{$name}.class.php")){
		require("./action/{$name}.class.php");
	}elseif(file_exists("./model/{$name}.class.php")){
		require("./model/{$name}.class.php");
	}else{
		die("错误：没有找到对应{$name}类!");
	}
}
require("./config.php");
require("./function.php");
ini_set('display_errors',true);
error_reporting(E_ALL ^ E_NOTICE); 
ob_start();
header('Content-Type: text/html; charset=UTF-8');
session_start();
define('ROOT', dirname(__FILE__));
define('SITE_URL',$_SERVER['PHP_SELF']);
$mod = isset($_GET['m'])?$_GET['m']:"Blog";
$classname = $mod."Action";
$action = new $classname();
$action->init();
