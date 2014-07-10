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
        $totalNum = d()->q("select count(*) as num from z_danciben ");
        include './view/danciben.php';
    }
}