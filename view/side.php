<div class="side">
	<div class="side_title" style="padding:15px 0 3px 10px">我希望得到您点评的文章</div>
	<?php
	if($top){
		foreach($top as $k =>$v){
	?>
	<div class="list_item list_view" style="margin-left:10px">			
		<div class="article_title">
			<h3><a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>"><span class="link_title"><?php echo msubstr($v['title'],0,17);?></span></a></h3>
		</div>
	</div>
	<?php
		}
	}	
	?>
</div>
<div class="side">
	<p class="side_title">也许是比较好的站点</p>
	<ul class="links">
	<?php
	if($links){
		foreach($links as $k =>$v){
	?>
		<li ><a href="<?php echo $v['url'];?>" class="links_li"><?php echo $v['name'];?></a></li>
	<?php
		}
	}	
	?>
	</ul>
</div>
<!-- <div class="side">
	<p class="side_title">我的github</p>
	<ul class="links">
	<li><a href="https://github.com/zhoumengkang">https://github.com/zhoumengkang</a></li>
	</ul>
</div> -->