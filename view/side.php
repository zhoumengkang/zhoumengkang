<div class="side">
	<span class="side_title side_title2" >被围观次数最多的帖子</span>
	<?php
	if(is_array($maxRead)){
		foreach($maxRead as $k =>$v){
	?>
	<div class="list_item list_view" style="margin-left:10px">			
		<div class="article_title">
			<h3><a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>"><span><?php echo msubstr($v['title'],0,17);?></span></a></h3>
		</div>
	</div>
	<?php
		}
	}	
	?>
</div>
<div class="side">
    <p class="side_title" style="float: left;">最常用的标签</p>
    <a href="<?php echo U('Blog/tags')?>"  class="side-for-more">更多 》》</a>
    <div class="clear"></div>
    <div class="tags">
        <?php
        if(is_array($tags)){
            foreach($tags as $k =>$v){
            ?>
            <a href="<?php echo U('Blog/readByTags',array('tag'=>$v['id']));?>"><?php echo $v['name'];?></a>
            <?php
            }
        }
        ?>
    </div>

</div>
<div class="side" style=" padding-bottom: 2px; ">
    <p class="side_title" style="float: left;margin-top: 20px;">搜索</p>
    <div style=" margin-left: 50px; margin-top: 18px; ">
        <form name="search" action="" method="get">
            <input type="hidden" name="m" value="Blog"/>
            <input type="hidden" name="a" value="search"/>
            <input type="text" name="keyword" value="" placeholder="输入关键词 回车" class="side-search" />
        </form>
    </div>
</div>
<div class="side" id="friendlinks">
	<p class="side_title" style="float: left;">友情链接</p>
    <a href="<?php echo U('Site/index');?>"  class="side-for-more">更多好站 》》</a>
    <div class="clear"></div>
	<ul class="links">
	<?php
	if(is_array($links)){
		foreach($links as $k =>$v){
	?>
		<li ><a href="<?php echo $v['url'];?>" class="links_li" target="_blank"><?php echo $v['name'];?></a></li>
	<?php
		}
	}	
	?>
	</ul>
</div>
