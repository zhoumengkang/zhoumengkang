<?php
if(defined('ROUTE') && ROUTE){
    if(strstr($_SERVER['REQUEST_URI'],'index.php')){
        parse_str($_SERVER['QUERY_STRING'],$params);
        if(in_array(strtolower($params['a']),array('blog','bloglist','readbytags','danciben'))){
            switch(strtolower($params['a'])){
                case 'blog':
                    $route = $params['id'];
                    break;
                case 'bloglist':
                    $type = array(1=>'notebook',2=>'homesick',3=>'playground');
                    $route = $type[$params['nav']];
                    break;
                case 'readbytags':
                    $route = 'tag-'.$params['tag'];
                    break;
                case 'danciben':
                    $route = "danciben";
                    break;

            }
            if($params['p']<2){
                header('Location:'.SITE.'/'.$route.'.html');
            }else{
                header('Location:'.SITE.'/'.$route.'-'.$params['p'].'.html');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head lang="zh-cn">
    <meta charset="utf-8">
	<title><?php echo $this->title ;?></title>
    <?php if($_GET['a'] == 'blog'){?><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"><?php }?>
	<meta name="description" content="<?php if($this->description){echo $this->description;}else{ echo '周梦康的博客，记录着我的学习笔记，也记录着我的生活琐事。';}?>"/>
    <meta name="keywords" content="<?php if($this->keywords){echo $this->keywords;}else{ echo '周梦康,梦康,mengkang,北剅轩';}?>" />
    <link rel="shortcut icon" href="<?php echo STATIC_URL;?>/favicon.ico">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>/view/css/public.css" type="text/css">
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>/view/css/box.css" type="text/css">
	<script type="text/javascript" src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
    <?php if($_GET['a'] == 'blog'){?>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>/view/js/jquery.lazyload.min.js"></script>
    <?php }?>
    <script type="text/javascript">
        var SITE_URL = '<?php echo SITE.SITE_URL; ?>';
    </script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>/view/js/zmk.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>/view/js/box.js"></script>
</head>
<body>
<header class="header">
    <div id="header">
        <a href="<?php echo SITE;?>" id="top">北剅轩</a>
        <div id="nav">
            <ul>
                <?php
                if (is_array($this->nav)) {
                    foreach($this->nav as $k =>$v){
                        if($v['pid']==0){
                            echo '<li><a href="'.U('Blog/blogList',array('nav'=>$v['id'])).'" title="'.$v['name'].'">'.$v['name'].'</a></li>';
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</header>

<div id="content">

    <?php
    if($_SESSION['uid']){
    ?>
    <!--博主控制台-->
    <div class="console" id="console">
        <a href="javascript:void(0)" title="隐藏控制台" name="consoleHide" class="showConsole">《《</a>
        <ul>
            <li><a href="<?php echo U('Blog/post')?>">书写博客</a></li>
            <li><a href="<?php echo U('Site/add')?>">收藏管理</a></li>
            <li><a href="<?php echo U('Danci/info')?>">添加单词</a></li>
            <li><a href="<?php echo U('Admin/delpic')?>">删除图片</a></li>
            <li><a href="<?php echo U('Admin/links')?>">链接管理</a></li>
            <!--<li><a href="<?php /*echo U('Admin/tags')*/?>">标签管理</a></li>-->
            <li><a href="<?php echo U('Admin/nav')?>">导航管理</a></li>
            <li><a href="<?php echo U('Blog/logout') ?>">退出管理</a></li>
        </ul>
    </div>
    <?php
    }
    ?>
