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
date_default_timezone_set('PRC');
ob_start();
header('Content-Type: text/html; charset=UTF-8');
session_start();
define('ROOT', dirname(__FILE__));
define('SITE_URL',$_SERVER['PHP_SELF']);//不是真实的SITE_URL,这只是http://www.xxx.com/index.php

$_root = dirname(rtrim($_SERVER["SCRIPT_NAME"],'/'));
define('SITE', 'http:'.'//'.$_SERVER['HTTP_HOST'].(($_root == '/')?'':$_root));//当前项目的URL地址

//将模版文件目录添加大include_path中去
set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__).'/view');

$mod = isset($_GET['m'])?$_GET['m']:"Blog";
$classname = ucwords($mod)."Action";
$action = new $classname();
$action->init($mod);
