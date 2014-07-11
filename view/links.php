<?php
include 'header.php';
?>
<div id="wrap">
    <div class="site-list">
<table class="linklist">
<tr>
	<th>名称</th>
	<th>地址</th>
	<th>排名</th>
	<th>操作</th>
</tr>
<?php if(is_array($links)){
    foreach($links as $v){ ?>
<tr trid="<?php echo $v['id']?>">
	<td nametd="<?php echo $v['id']?>"><?php echo $v['name'] ?></td>
	<td urltd="<?php echo $v['id']?>"><?php echo $v['url'] ?></td>
	<td ranktd="<?php echo $v['id']?>"><?php echo $v['rank'] ?></td>
	<td>
        <a href="javascript:void(0);" title="<?php echo $v['id']?>" class="modify_links">修改</a> | <a href="javascript:void(0);" title="<?php echo $v['id']?>" class="del_links">删除</a>
    </td>
</tr>
<?php }} ?>
</table>
<div class="info" style="width:600px;float:left">
<form action="" method="post">
	<input type="hidden" name="id" value="">
	网站名称：<input type="text" name="name"  class="link_input" ><br/><br/>
	网站地址：<input type="text" name="url" class="link_input info_des" ><br/><br/>
	网站描述：<input type="text" name="des" class="link_input info_des" ><br/><br/>
	前台排名：<input type="text" name="rank" class="link_input" style="width:50px" ><br/>
	<input type="submit" name="添加"  >
</form>
	<div style="padding-top:10px">
	<?php
	if($flag){
		if($flag>0){
			echo '<font color="green">修改成功</font>';
		}else{
			echo '<font color="red">修改失败</font>';
		}
	}
	?>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(function(){
	$(".modify_links").click(function(){
		var id = $(this).attr('title');
		var name = $("td[nametd='"+id+"']").html();
		var url = $("td[urltd='"+id+"']").html();
		var rank = $("td[ranktd='"+id+"']").html();
		$("input[name='name']").val(name);
		$("input[name='url']").val(url);
		$("input[name='rank']").val(rank);
		$("input[name='id']").val(id);
	})
	$(".del_links").click(function(){
		var id = $(this).attr('title');
		$("tr[trid='"+id+"']").fadeOut('slow');
		$.post('<?php echo U('Admin/delLinks') ?>',{id:id});
	})
})
</script>
    </div>
</div>
<?php
include 'footer.php';
?>