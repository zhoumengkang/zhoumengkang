<?php
class DanciAction extends Action{
    public function __construct(){
        parent::__construct();
    }
    //单词本
    public function index(){

        $num = 100;
        $page = (int)$_GET['p']?(int)$_GET['p']:1;
        $start = ($page-1)*$num;
        $danciben = d()->q("select * from z_danciben order by `id` desc limit ".$start.','.$num);
        //dump($danciben);
        $totalNum = d()->q("select count(*) as num from z_danciben ");
        include 'Danciben/index.php';
    }

    public function info(){
        if($_POST){
            if($_POST['id']){
                //modify
                $sql = "update z_danciben set `word`='{$_POST['word']}',`translate`='{$_POST['translate']}',`sentence`='{$_POST['sentence']}',`from`='{$_POST['from']}' where `id`='{$_POST['id']}'";
                $flag = d()->q($sql);
                $_POST=null;
            }else{
                //insert
                $sql = "insert into z_danciben(`word`,`translate`,`sentence`,`from`)values('{$_POST['word']}','{$_POST['translate']}','".htmlspecialchars($_POST['sentence'])."','".htmlspecialchars($_POST['from'])."')";
                $flag = d()->q($sql);
                $_POST=null;
            }
        }else{
            if($_GET['id']){
                $info = d()->q("select * from z_danciben where id =".intval($_GET['id']));
            }

        }
        include 'Danciben/info.php';
    }
}