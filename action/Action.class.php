<?php
//Action的控制基类
class Action{
	protected $nav =null;
	/**
	 *action初始化方法(在这个方法里根据参数a的值决定调用对应的方法)
	 *
	 */
	public function __construct(){
		//获取网站的导航条信息
		$this->nav = d()->q("select * from z_nav where status = 1");
		//dump($this->nav);
		$this->tags = d()->q("SELECT a.id, a.name, COUNT( b.tag_id ) AS pinlv FROM  `z_tags` a LEFT JOIN `z_blog_to_tags` b  ON b.tag_id = a.id GROUP BY b.tag_id ORDER BY pinlv DESC LIMIT 30");
		//dump($this->tags);
		$this->tags = d()->q("select * from z_tags");
		//dump($this->tags);
		$this->info = d()->q("select * from z_info");
		$this->title = '北剅轩-往(网)事多记于此-周梦康';
	}
	public function init(){
		//获取a参数的值
		$a  = isset($_GET["a"])?$_GET["a"]:"index"; //默认值为index
		//判断当前Action是否存在此方法
		if(method_exists($this,$a)){
			//调用此方法
			$a = $this->$a();
		}else{
			die("没有找到{$a}对应的方法");
		}
	}
}