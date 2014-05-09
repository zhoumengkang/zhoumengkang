<?php
class DemoAction extends Action{
	public function index(){
		//通过__autoload()魔术方法自动加载了./model/D.class.php
		$a = new D();
		$res = $a->q('select * from z_user;');
		dump($res);
		$a = new D();
		$res2 = $a ->q('insert into z_user(username,password) VALUES ("zhou12","'.md5("zmkzmk").'") ');
		var_dump($res2);
		//通过include来实现模版的加载
		include './view/index.php';
	}
	public function pagelist(){
		include './view/header.php';
		echo pagelist($_GET['p'],400,10);
	}
    public function sendEmail(){
        $test = new MailModel('i@zhoumengkang.com','康哥','sss');
    }
    public function test(){
        $a = new D();
        $res = $a ->q('insert into z_user(name,password) VALUES ("zhou12","'.md5("zmkzmk").'") ');
        echo $a->lastsql();
        dump($res);
    }
}