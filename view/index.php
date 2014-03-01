<?php
include 'header.php';
?>
<div style="height: 100px"></div>
<div id="wrap">

	<div id="main">
		<div class="main">
			<span class="side_title">最新文章</span>
			<?php
			if(is_array($res)){
				foreach($res as $k =>$v){
			?>
			<div class="list_item list_view" blogId="<?php echo $v['id'] ?>">
				<div class="article_title">
					<h3>
						<a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>"><span class="link_title"><?php echo msubstr($v['title'],0,50);?></span></a><span class="viewtimes" title="阅读次数">(<?php echo $v['count']?>)</span>
					</h3>
				</div>
				<div class="article_manage">
					<span class="link_postdate"><?php echo date('Y-m-d H:m:s',$v['ctime'])?></span>
					
					<?php if($_SESSION['uid']){ ?>
					<span class="link_edit"><a href="<?php echo U('Admin/modifyBlog',array('id'=>$v['id']));?>" title="编辑">编辑</a></span>
					<span class="link_edit"><a href="javascript:void(0);"  title="recommendBlog" recommendId="<?php echo $v['id']?>">推荐</a></span>
					<span class="link_delete"><a href="javascript:void(0);" deleteId="<?php echo $v['id']?>" title="deletdBlog">删除</a></span>
					<?php }?>
					
				</div>
			</div>
			<?php
				}
				echo pagelist($page,$totalNum[0]['num'],PERPAGES);
			}
			?>
			
		
		</div>
	</div>
	<div id="side">
		<?php
		include 'side.php';
		?>
	</div>
</div>
<?php
include 'footer.php';
?>
