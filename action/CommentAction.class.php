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
        if(!$_POST['email']){
            $this->ajaxReturn(0,'邮箱不能为空');
        }
        if(!$_POST['content']){
            $this->ajaxReturn(0,'内容不能为空');
        }
        if(!$_POST['blogid']){
            $this->ajaxReturn(0,'评论哪篇文章？');
        }
        $blogid = intval($_POST['blogid']);
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $username = htmlspecialchars(strip_tags($_POST['name']),ENT_QUOTES);
        $_POST['content'] = str_replace('·','`',$_POST['content']);
        $content = htmlspecialchars(strip_tags($_POST['content']),ENT_QUOTES);
        $link = htmlspecialchars(strip_tags($_POST['blog']));
        $sql = "insert into z_comment(`blogid`,`email`,`username`,`link`,`content`,`posttime`) values ({$blogid},'{$email}','{$username}','{$link}','{$content}',".time().")";
        $model = d();
        $res = $model->q($sql);
        $data = preg_replace('/`(.*?)`/','<code class="markdownTags">$1</code>',$content);
        if($res>0){
            //留言成功的情况
            //获取其楼层
            $floor = d()->q("select count(*) as num from z_comment where blogid = {$blogid} and `posttime` < {$res[0]['posttime']}");
            $floor = 1 + $floor[0]['num'];
            $url = SITE_URL.'/'.$blogid.'html#floor'.$floor;
            $blogtitle = d()->q("select `title` from z_blog where id = {$blogid}");
            $mailBody = '<p>'.$username.' < '.$email.' >对你的</p>
                        <h3>'.$blogtitle[0]['title'].'</h3>
                        <p>进行了评论。</p>
                        <p>内容为：'.$content.'</p>
                        <p><a href="'.$url.'">点击链接查看</a></p>';
            new MailModel('i@zhoumengkang.com','康哥',$mailBody,'主公，北剅轩有客来访');
            $this->ajaxReturn(1,'评论成功',$data);
        }else{
            $this->ajaxReturn(0,'评论失败',$data);
        }

    }

    /**
     * 删除评论操作
     * 前台博主操作
     */
    public function del(){
        if(!$_SESSION['uid']){
            $this->ajaxReturn(0,'先登陆',$data);
        }else{
            $res = M()->q('update z_comment set `status` = 0 where id = '.intval($_POST['id']));
            if($res>0){
                $this->ajaxReturn(1,'删除成功',$res);
            }else{
                $this->ajaxReturn(0,'删除失败',$res);
            }
        }
    }
}