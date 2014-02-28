<!Doctype html>
<head>
	<meta http-equiv=Content-Type content="text/html;charset=utf-8">
	<title><?php echo $this->title ;?></title>
	<meta name="description" content="周梦康的博客，记录着我的学习笔记，也记录着我的生活琐事。"/>
	<link rel="stylesheet" href="./view/css/public.css" type="text/css">
	<script type="text/javascript" src="./view/js/work.js"></script>
	<script type="text/javascript" src="./view/js/msgBox.js"></script>
</head>
<body>
<div id="header">
	<div class="top">
	<a id="top"></a>
	<div class="logo">
		<?php echo $this->info[0]['name'] ;?>
	</div>
	<div class="description">—— <?php echo $this->info[0]['des'] ;?></div>
	</div>
	<div class="navbg">
	  <div class="col960">
		<ul id="navul" class="cl">
		  <li class="navhome"><a href="<?php echo SITE_URL ;?>">首页</a></li>
		  <?php
		  if (is_array($this->nav)) {
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
		  
		  ?>
		</ul>
	  </div>
	</div>
	<script  type="text/javascript"> 
	$(".navbg").capacityFixed();
	</script>
</div>