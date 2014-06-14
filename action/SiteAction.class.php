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
        $this->title = "我的网址收藏夹 - 周梦康";
        $this->description = "我收藏的一些不错的技术性博客和网站";
        $sql = "select * from `z_link` where `status` > 0 and `is_mark` = 1 order by `id` desc";
        $sites = d()->q($sql);
        include 'Site/index.php';
    }

    /**
     * 增加
     */
    public function add(){
        if(!$_SESSION['uid']){
            die('先登陆');
        }
        if($_POST){
            //dump($_POST);
            if($_POST['id']){
                //update
                $sql = "update z_link set `name`='{$_POST['name']}',`url`='{$_POST['url']}',`des`='{$_POST['des']}' where `id`='{$_POST['id']}'";
                $flag = d()->q($sql);
                $_POST=null;
            }else{
                //insert
                $sql = "insert into z_link(`name`,`url`,`des`,`type`,`rank`,`is_mark`)values('{$_POST['name']}','{$_POST['url']}','{$_POST['des']}',{$_POST['type']},0,1)";
                //dump($sql);
                $flag = d()->q($sql);
                //$_POST=null;
                if($flag){
                    $url = U('Site/index');
                    header("Location: {$url}");
                }else{
                    header("Location: {$_SERVER['HTTP_REFERER']}");
                }
            }
        }else{
            $sql = "select * from `z_link` where `id` = ".intval($_GET['id'])." order by `id` desc";
            $info = d()->q($sql);
        }
        include 'Site/add.php';
    }

}