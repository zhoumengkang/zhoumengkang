<?php
/**
 * Class SiteAction
 * 网址导航，单独写一个控制器的原因也是为了测试redis
 */
class SiteAction extends Action{
    /**
     * 列表
     */
    public function index(){
        $redis = new Redis(); #实例化redis类
        $redis->connect('127.0.0.1'); #连接服务器
        echo $redis->get('webname');
    }

    /**
     * 增加
     */
    public function add(){
        if(!$_SESSION['uid']){
            die('先登陆');
        }
        if($_POST){
            $data = user_filter($_POST);
            $redis = new Redis(); #实例化redis类
            $redis->connect('127.0.0.1'); #连接服务器
            $redis->mset($data);

            echo $redis->get('webname');
            $redis->close(); #关闭连接
            $this->display();
        }else{

            $this->display();
        }



    }

    /**
     * 修改
     */
    public function modify(){

    }
}