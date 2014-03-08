<?php
/**
 * description  : 评论控制器
 * @author      : zhoumengkang
 * createTime   : 8/3/14 23:13
 */
class CommentAction extends Action{
    public function __construct(){
        parent::__construct();
    }

    /**
     * AJAX请求地址
     * 执行评论操作
     */
    public function doComment(){

    }

    /**
     * 删除评论操作
     * 前台博主操作
     */
    public function del(){
        //$res = M()->q();
    }
}