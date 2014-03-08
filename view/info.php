<?php
include 'header.php';
?>
<div class="info">
<form action="" method="post">
	<input type="text" name="name"  class="password " value="<?php echo $this->info[0]['name']; ?>"><br/><br/>
	<input type="text" name="des" class="password info_des" value="<?php echo $this->info[0]['des']; ?>"><br/>
	<input type="submit" name="修改" class="sub"  >
</form>
<div style="padding-top:10px">
<?php
if($flag){
	if($flag==1){
		echo '<font color="green">修改成功</font>';
	}else{
		echo '<font color="red">修改失败</font>';
	}
}

?>
</div>
</div>

<?php
include 'footer.php';
?>