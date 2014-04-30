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

    }

    /**
     * 增加
     */
    public function add(){
        if(!$_SESSION['uid']){
            die('先登陆');
        }
        if($_POST){
            $redis = new Redis(); #实例化redis类
            $redis->connect('127.0.0.1'); #连接服务器
            $redis->set('key', 'hello '); #调用方法，设置string类型值
            $redis->append('key', 'world'); #修改string类型值
            echo $redis->get('key');  #获取redis key的值，并输出显示
            echo $redis->type('key'); #获取key 的数据类型
            $redis->close(); #关闭连接
        }else{
            $a = 2222;
            $this->display($a);
        }



    }

    /**
     * 修改
     */
    public function modify(){

    }
}