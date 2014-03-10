<div class="side">
	<p class="side_title">被围观次数最多的帖子</p>
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
    <p class="side_title">我希望得到您点评的帖子</p>
    <?php
    if(is_array($top)){
        foreach($top as $k =>$v){
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
    <a href="<?php echo U('Blog/tags')?>" style=" padding: 16px; font-size: 13px; float: right; color: #bbb; ">更多 》》</a>
    <div class="tags">
        <?php
        if(is_array($tags)){
            foreach($tags as $k =>$v){
            ?>
            <a href="<?php echo U('Blog/index',array('tag'=>$v['id']));?>"><?php echo $v['name'];?></a>
            <?php
            }
        }
        ?>
    </div>

</div>
<div class="side" id="friendlinks">
	<p class="side_title">友情链接</p>
	<ul class="links">
	<?php
	if(is_array($links)){
		foreach($links as $k =>$v){
	?>
		<li ><a href="<?php echo $v['url'];?>" class="links_li"><?php echo $v['name'];?></a></li>
	<?php
		}
	}	
	?>
	</ul>
</div>