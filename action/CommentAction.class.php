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
        $posttime = time();
        $sql = "insert into z_comment(`blogid`,`email`,`username`,`link`,`content`,`posttime`) values ({$blogid},'{$email}','{$username}','{$link}','{$content}',".$posttime.")";
        $model = d();
        $res = $model->q($sql);
        $data = preg_replace('/`(.*?)`/','<code class="markdownTags">$1</code>',$content);
        if($res>0){
            //留言成功的情况
            //获取其楼层
            $floor = d()->q("select count(*) as num from z_comment where blogid = {$blogid} and `posttime` < {$posttime}");
            $floor = 1 + $floor[0]['num'];
            //TODO 关于网站site_url还需要重新配置定义，目前的是不够用的
            $url = 'http://'.$_SERVER['HTTP_HOST'].'/'.U('Blog/blog',array('id'=>$blogid)).'#floor'.$floor;
            $blogtitle = d()->q("select `title` from z_blog where id = {$blogid}");
            $mailBody = '<h3>'.$blogtitle[0]['title'].'&nbsp&nbsp有新的留言</h3>
                        <p>'.$username.' < '.$email.' >在评论中说：</p>
                        <div style="border-radius: 4px;margin: 10px 0 10px;border: 1px dashed #BEB0B0;padding: 8px;background: #F0F0F0;">'.$content.'</div>
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
            $this->ajaxReturn(0,'先登陆',0);
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