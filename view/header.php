<!Doctype html>
<head lang="zh-cn">
    <meta charset="utf-8">
	<title><?php echo $this->title ;?></title>
	<meta name="description" content="周梦康的博客，记录着我的学习笔记，也记录着我的生活琐事。"/>
	<link rel="stylesheet" href="./view/css/public.css" type="text/css">
	<script type="text/javascript" src="http://libs.baidu.com/jquery/1.7.2/jquery.js"></script>
	<script type="text/javascript" src="./view/js/zmk.js"></script>
	<script type="text/javascript" src="./view/js/msgBox.js"></script>
    <style type="text/css">
        #nav{
            float:right;
        }

        #nav ul li{
            float: left;
            padding: 0 10px;
            margin: 0 10px;

        }
        #nav span{
            color: #2e9fff;
            font-size: 20px;
        }
        #nav span:hover{color: #323232}
        .nav{
            height: 40px;
            line-height: 40px;
            margin: 28px 50px;
        }


    </style>
</head>
<body>
<!--这里增加header_relatvie样式是为了保证header底边的css样式能显示出来-->
<div id="header" class="header_relatvie">
	<a id="top"></a>
    <a href="<?php echo SITE_URL ;?>"><span class="logo" id="logo">
        胡场北剅轩
	</span></a>
	<div class="description" id="intro">
        <pre>
/**
 * @description 欲诉诸笔端，顾视，无可置者。故，多记于此。
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
                    echo '<li><a href="'.U('Blog/index',array('nav'=>$v['id'])).'" title="'.$v['name'].'"><span>'.$v['name'].'</span></a></li>';
                }
            }
        }
        ?>
    </ul>
    </div>
    <div class="clear"></div>
</div>
<div id="content">