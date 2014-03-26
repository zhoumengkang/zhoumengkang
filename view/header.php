<!DOCTYPE html>
<head lang="zh-cn">
    <meta charset="utf-8">
	<title><?php echo $this->title ;?></title>
	<meta name="description" content="<?php if($this->description){echo $this->description;}else{ echo '周梦康的博客，记录着我的学习笔记，也记录着我的生活琐事。';}?>"/>
    <meta name="keywords" content="<?php if($this->keywords){echo $this->keywords;}else{ echo '北剅轩,周梦康';}?>" />
    <link rel="stylesheet" href="./view/css/public.css" type="text/css">
	<link rel="stylesheet" href="./view/css/box.css" type="text/css">
	<script type="text/javascript" src="http://libs.baidu.com/jquery/1.7.2/jquery.js"></script>
    <script type="text/javascript">
        var SITE_URL = '<?php echo SITE_URL; ?>';
    </script>
	<script type="text/javascript" src="./view/js/zmk.js"></script>
	<script type="text/javascript" src="./view/js/box.js"></script>
</head>
<body>
<header id="header" class="header_fixed">
	<a id="top"></a>
    <a href="./"><span class="logo" id="logo">北剅轩</span></a>
	<div class="description" id="intro">
        <pre>
/**
 * @description 笔记和生活！
 * @author      周梦康 < i@zhoumengkang.com >
 */
        </pre>
    </div>
    <span class="sign">代码，生活，只言片语皆回忆。</span>
    <div class="nav" id="nav">
    <ul>
        <?php
        if (is_array($this->nav)) {
            foreach($this->nav as $k =>$v){
                if($v['pid']==0){
                    echo '<li><a href="'.U('Blog/blogList',array('nav'=>$v['id'])).'" title="'.$v['name'].'"><span>'.$v['name'].'</span></a></li>';
                }
            }
        }
        ?>
    </ul>
    </div>
    <div class="clear"></div>
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
            <li><a href="<?php echo U('Blog/rank')?>">最受欢迎</a></li>
            <li><a href="<?php echo U('Admin/info')?>">博客信息</a></li>
            <li><a href="<?php echo U('Admin/links')?>">链接管理</a></li>
            <li><a href="<?php echo U('Admin/tags')?>">标签管理</a></li>
            <li><a href="<?php echo U('Admin/nav')?>">导航管理</a></li>
            <li><a href="<?php echo U('Blog/logout') ?>">退出管理</a></li>
        </ul>
    </div>
    <?php
    }
    ?>
