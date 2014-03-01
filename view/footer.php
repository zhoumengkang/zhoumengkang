</div>
<div style="clear:both;"></div>
<div id="footer">
	<div class="login">
	<?php
		if($_SESSION['uid']){
	?>
			<a href="<?php echo U('Blog/post')?>">写博客</a>
			<a href="<?php echo U('Blog/rank')?>">最受欢迎的</a>
			<a href="<?php echo U('Admin/info')?>">博客信息</a>
			<a href="<?php echo U('Admin/links')?>">链接管理</a>
			<!-- <a href="<?php echo U('Admin/tags')?>">标签管理</a> -->
			<a href="<?php echo U('Admin/nav')?>">导航管理</a>
			<a href="<?php echo U('Blog/logout') ?>">登出</a>
	<?php	
		}else{
	?>
			<a href="<?php echo U('Blog/login');?>">登陆</a>
			<a href="<?php echo U('Blog/rank')?>">最受欢迎的</a>
	<?php	
		}
	?>
	</div>
	<span></span>
	<a href="http://www.miibeian.gov.cn" target="_blank"></a><span class="zhoumengkang">Powered by ZhouMengkang</span> 
	<div class="messageBox"></div>
</div>
<script type="text/javascript" src="./view/js/zmk.js"></script>
<div class="backToTop" title="返回顶部" style="display: none;">返回顶部</div>
</body>
</html>