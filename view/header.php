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
            height: 40px;
            color: #ffffff;
            background-color: #2e9fff;
            border-color: #2e9fff;
        }
        #nav ul li{
            float: left;
        }

    </style>
</head>
<body>
<!--这里增加header_relatvie样式是为了保证header底边的css样式能显示出来-->
<div id="header" class="header_relatvie">
	<a id="top"></a>
	<span class="logo" id="logo">
        北剅轩
	</span>
	<div class="description" id="intro">
        <pre>
/**
 * @description 欲诉诸笔端，顾视，无可置者。故，多记于此。
 * @author      周梦康 < i@zhoumengkang.com >
 */
        </pre>
    </div>
<!--    <div id="nav">
<ul>
    <li>1</li>
    <li>1</li>
    <li>1</li>
    <li>1</li>
</ul>
    </div>-->
	<!--<div class="navbg">
	  <div class="col960">
		<ul id="navul" class="cl">
		  <li class="navhome"><a href="<?php /*echo SITE_URL ;*/?>">首页</a></li>
		  <?php
/*		  if (is_array($this->nav)) {
		  	foreach($this->nav as $k =>$v){
				if($v['pid']==0){
				  echo '<li><a href="'.U('Blog/index',array('nav'=>$v['id'])).'" title="'.$v['name'].'">'.$v['name'].'</a>';
				  echo '<ul>';
				  foreach($this->nav as $key =>$value){
					if($value['pid']==$v['id']){
					  echo '<li><a href="'.U('Blog/index',array('nav'=>$value['id'])).'" title="'.$value['name'].'">'.$value['name'].'</a></li>';
					}
				  }
				  echo '</ul>';
				  echo '</li>';
				}
			  }
		  }
		  
		  */?>
		</ul>
	  </div>
	</div>
	<script  type="text/javascript">
	$(".navbg").capacityFixed();
	</script>-->
</div>
<div id="content">