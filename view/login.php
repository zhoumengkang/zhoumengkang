<?php
include 'header.php';
?>
<div id="login">
<form action="" method="post">
		
		<input class="password" type="password" name="password" value="" ><?php if($_GET['flag']==1){ ?>
			<font color="red">密码错误</font>
		<?php }?>
		<br/>
		<input class="sub" type="submit" value="提交">
	</div>
</form>
</div>
<?php
include 'footer.php';
?>