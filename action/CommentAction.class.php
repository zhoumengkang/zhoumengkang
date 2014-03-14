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
    //todo
    public function doComment(){
        /*if(!$_POST['name']){
            $this->ajaxReturn();
        }
        if(!$_POST['email']){

        }
        if(!$_POST['content']){

        }
        if(!$_POST['blogid']){

        }*/
        $blogid = intval($_POST['blogid']);
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $username = htmlspecialchars(strip_tags($_POST['name']));
        $content = htmlspecialchars(strip_tags($_POST['content']));
        $link = htmlspecialchars(strip_tags($_POST['blog']));
        $sql = "insert into z_comment(`blogid`,`email`,`username`,`link`,`content`,`posttime`) values ({$blogid},'{$email}','{$username}','{$link}','{$content}',".time().")";
        $model = d();
        $res = $model->q($sql);
        //echo $model->lastsql();
        echo $res;
    }

    /**
     * 删除评论操作
     * 前台博主操作
     */
    public function del(){
        //$res = M()->q();
    }
}