<?php
include 'header.php';
?>
<link rel="stylesheet" href="./editor/kindeditor-4.1.7/plugins/code/prettify.css" />
<script charset="utf-8" src="./editor/kindeditor-4.1.7/plugins/code/prettify.js"></script>
<script>
$(function(){ prettyPrint(); });
</script>
<div id="wrap">
	<div id="blog">
			<?php
			if($res){
				foreach($res as $k =>$v){
			?>
			<div class="list_item">			
				<div class="article_title">
					<h3>
						<a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>"><span class="link_title"><?php echo $v['title'];?></span></a>
					</h3>
				</div>
				<div class="article_manage">
					<div style="margin-left:6px">
						<!-- Baidu Button BEGIN -->
						<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
						<a class="bds_qzone"></a>
						<a class="bds_sqq"></a>
						<a class="bds_qq"></a>
						<a class="bds_tsina"></a>
						<a class="bds_tqq"></a>
						<a class="bds_renren"></a>
						<a class="bds_douban"></a>
						<a class="bds_tieba"></a>
						<a class="bds_mshare"></a>
						<span class="bds_more"></span>
						<a class="shareCount"></a>
						</div>
						<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=623514" ></script>
						<script type="text/javascript" id="bdshell_js"></script>
						<script type="text/javascript">
						document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
						</script>
						<!-- Baidu Button END -->
					</div>
					<span class="link_postdate"><?php echo date('Y-m-d H:m:s',$v['ctime'])?></span>
					<span class="link_view" title="阅读次数"><a href="<?php echo U('Blog/blog',array('id'=>$v['id']));?>" title="阅读次数">阅读</a>(<?php echo $v['count']?>)</span>
					
					<?php if($_SESSION['uid']){ ?>
					<span class="link_edit"><a href="<?php echo U('Admin/modifyBlog',array('id'=>$_GET['id']))?>" title="编辑">编辑</a></span>
					<span class="link_edit"><a href="javascript:void(0);"  title="recommendBlog" recommendId="<?php echo $v['id']?>">顶置</a></span>
					<span class="link_delete"><a href="javascript:void(0);" deleteId="<?php echo $v['id']?>" title="deletdBlog">删除</a></span>
					<?php } ?>
				</div>
			</div>
			<div class="content">
				<style type="text/css">
					.tags{
						margin-left: 0px;
					}
				</style>
				<?php if (is_array($tags)){ ?>
					<div class="login tags">
					标签 : 
					<?php
						foreach ($tags as $key => $value) {
							echo '<a href="'.U('Blog/index',array('tag'=>$value['id'])).'" style="padding:0 5px;margin-left:3px;">'.$value['name'].'</a>';
						}
					?>
					</div><br/>
				<?php }?>
				
			<?php echo $v['content'];?>
			</div>
			<?php
				}
			}
			if($modify){
			?>
			<!--下面是修改记录(如果有的话)-->
			<div id="modify">
			<?php
				foreach($modify as $kk =>$vv){
			?>
				<div class="modify">
					<div class="modify_time">修改时间：<i><?php echo date('Y-m-d H:m:s',$vv['mtime']); ?></i></div>
					<div class="modify_reason">修改原因：<?php echo $vv['reason']; ?></div>
				</div>
			<?php	
				}
			}
			?>
			</div>
	</div>
</div>
<?php
include 'footer.php';
?>