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
        }else{

        }
    }

    /**
     * 修改
     */
    public function modify(){

    }
}