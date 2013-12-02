<?php
include 'header.php';
?>
<style type="text/css">
.addTags,.romveTags{
	margin:10px 0 0 10px;
	font-size: 20px;
	font-weight: 800;
	cursor:pointer ;
}
.addTags{
	color:lime;
}
.romveTags{
	color:red;
	font-weight: 400;
}
.tagsAdd{
	border: 0px;
	padding-left: 10px;
	border-radius:6px;
	border:1px dashed #BEB0B0;
	background-color: #FFF;
}
.addTagsSub{
	margin-left: 5px;
	padding:0 5px;
	border-radius:6px;
	background-color: #08A5E0;
	cursor:pointer ;
	color: #fff;
}
.hiddenInput{
	display: none;
	padding-left: 20px;
}
</style>
<div class="linklist" id="linklist">

<?php 
if(is_array($res)){
	foreach($res as $v){
		if($v['pid']==0 &&$v['status']==1){
			echo '<div tagid="'.$v['id'].'">|--'.$v['name'].'<span class="addTags" title="增加子标签">+</span><span class="romveTags" title="从导航中移出">x</span>
					<div class="hiddenInput">|--<input name="name" type="text" class="tagsAdd"><input name=pid value="'.$v['id'].'" type="hidden"><span class="addTagsSub">提交</span></div>';
			foreach($res as $vv){
				if($vv['pid']==$v['id'] && $vv['status']==1){
					echo '<div style="margin-left:20px" tagid="'.$vv['id'].'">|--'.$vv['name'].'<span class="romveTags" title="从导航中移出">x</span></div>';
				}
			}
			echo '</div>';
		}
	}
}
?>
|--<span class="addTags addNav" title="增加导航">+</span>
<div class="hiddenInput"><input name="name" type="text" class="tagsAdd"><span class="addTagsSub">提交</span></div>
</div>


<script type="text/javascript">
$(function(){
	$(".addNav").click(function(){
		$(this).next().fadeIn('slow');
	})
	$(".modify_tags").click(function(){
		var id = $(this).attr('spanid');
		var name = $(this).html();
		$("#linklist").append('<div tagid='+id+'>|--'+name+'<span class="addTags">+</span><span class="romveTags">x</span><div class="hiddenInput">|--<input name="name" type="text" class="tagsAdd"><input name=pid value="'+id+'" type="hidden"><span class="addTagsSub">提交</span></div></div>');

		$.post('<?php echo U('Admin/navSwitch') ?>',{id:id,flag:1});
	})
	$(".addTags").live('click',function(){
		var id = $(this).parent().attr('tagid');
		$('div[tagid="'+id+'"]').children('.hiddenInput').fadeIn('slow');
	})
	$(".addTagsSub").live('click',function(){
		var parentDiv = $(this).parent();
		var name = parentDiv.children('input[name="name"]').val();
		var pid = parentDiv.children('input[name="pid"]').val();
		$.post('<?php echo U('Admin/addNav')?>',{name:name,pid:pid},function(id){
			if (typeof pid =="string" ) {
				if (id) {
					parentDiv.parent().append('<div style="margin-left:20px" tagid="'+id+'">|--'+name+'<span class="romveTags" title="从导航中移出">x</span></div>');
				} else{
					showMsg('已经添加过了');
				};
			}else{
				window.location.reload();
			}
			
			
		});
		
	}) 
	$(".romveTags").live('click',function(){
		var id = $(this).parent().attr('tagid');
		if (confirm("确定删除?")) {
			$.post('<?php echo U('Admin/navSwitch') ?>',{id:id,flag:0},function(data){
				$("div[tagid='"+id+"']").fadeOut('slow');
			})
		};
		
	})
})
</script>
<?php
include 'footer.php';
?>