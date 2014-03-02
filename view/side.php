<div class="side">
	<p class="side_title">被围观次数最多的帖子</p>
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
    <p class="side_title">我希望得到您点评的帖子</p>
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
    <p class="side_title">标签云</p>
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
	<p class="side_title">收藏的站点</p>
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