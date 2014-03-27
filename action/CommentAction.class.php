<?php
/**
 * description  : 评论控制器
 * @author      : zhoumengkang
 * createTime   : 8/3/14 23:13
 */
class CommentAction extends Action{
    protected $authId = '94c0883d999094126593e729e56fb3a6';//发送邮件之前的验证码
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
        $dataOfcomment = preg_replace('/`(.*?)`/','<code class="markdownTags">$1</code>',$content);
        if($res>0){
            //留言成功的情况
            //TODO 关于网站site_url还需要重新配置定义，目前的是不够用的
            $url = 'http://'.$_SERVER['HTTP_HOST'].''.U('Blog/blog',array('id'=>$blogid));
            $blogtitle = d()->q("select `title` from z_blog where id = {$blogid}");
            $data = array();
            $data['authId'] = 'zhoumengkanghahaha';
            if(intval($_POST['replyId'])){
                echo 1;
                //回复别人的回复
                //查询出被回复留言的邮箱和昵称
                $userInfo = d()->q("select `username`,`email` from `z_comment` where `id` = ".intval($_POST['replyId']));
                $mailBody = '<h3>'.$userInfo[0]['username'].' 你在周梦康博客<span style="padding:15px">"'.$blogtitle[0]['title'].'"</span>的留言有回复</h3><p> '.$username.' 在评论中说：</p><div style="border-radius: 4px;margin: 10px 0 10px;border: 1px dashed #BEB0B0;padding: 8px;background: #F0F0F0;">'.$content.'</div><p><a href="'.$url.'">点击链接查看</a></p>';
                $data['email'] = $userInfo[0]['email'];
                $data['nickname'] = $userInfo[0]['username'];
                $data['mailBody'] = $mailBody;
            }else{
                echo 2;
                $mailBody = '<h3>康哥你的文章  <span style="padding:15px">"'.$blogtitle[0]['title'].'"</span>  有新的留言</h3><p>'.$username.' < '.$email.' >在评论中说：</p><div style="border-radius: 4px;margin: 10px 0 10px;border: 1px dashed #BEB0B0;padding: 8px;background: #F0F0F0;">'.$content.'</div><p><a href="'.$url.'">点击链接查看</a></p>';

                $data['email'] = 'i@zhoumengkang.com';
                $data['nickname'] = '康哥';
                $data['mailBody'] = $mailBody;
            }
            $url = 'http://'.$_SERVER['HTTP_HOST'].U('Comment/sendEmail');
            //异步邮件通知
            request_by_fsockopen($url,$data);
            $this->ajaxReturn(1,'评论成功',$dataOfcomment);
        }else{
            $this->ajaxReturn(0,'评论失败',$dataOfcomment);
        }

    }

    //简单的加密函数
    protected function auth_encode($data){
        return md5($data.'zmk');
    }

    public function sendEmail(){
        //解码已编码的URL字符串
        $data = array_map('urldecode',$_POST);
        //安全处理做
        //验证是不是我自己发送的，而非别人模拟发送的
        if($this->auth_encode($data['authId']) != $this->authId){
            return fasle;
        }
        $this->snyc_send($data);
    }

    protected function snyc_send($data){
        new MailModel($data['email'],$data['nickname'],$data['mailBody'],$data['title']);
    }

    /**
     * 删除评论操作
     * 前台博主操作
     */
    public function del(){
        if(!$_SESSION['uid']){
            $this->ajaxReturn(0,'先登陆',0);
        }else{
            $res = d()->q('update z_comment set `status` = 0 where id = '.intval($_POST['id']));
            if($res>0){
                $this->ajaxReturn(1,'删除成功',$res);
            }else{
                $this->ajaxReturn(0,'删除失败',$res);
            }
        }
    }

}