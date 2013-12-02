<?php
include 'header.php';
?>
<link rel="stylesheet" href="./editor/kindeditor-4.1.7/themes/default/default.css" />
<link rel="stylesheet" href="./editor/kindeditor-4.1.7/plugins/code/prettify.css" />
<script charset="utf-8" src="./editor/kindeditor-4.1.7/kindeditor.js"></script>
<script charset="utf-8" src="./editor/kindeditor-4.1.7/lang/zh_CN.js"></script>
<script charset="utf-8" src="./editor/kindeditor-4.1.7/plugins/code/prettify.js"></script>
<script>
	KindEditor.ready(function(K) {
			editor = K.create('textarea[name="content"]', {
			cssPath : './editor/kindeditor-4.1.7/plugins/code/prettify.css',
			uploadJson : './editor/kindeditor-4.1.7/php/upload_json.php',
			fileManagerJson : './editor/kindeditor-4.1.7/php/file_manager_json.php',
			allowFileManager : true,
			afterCreate : function() {
				var self = this;
				K.ctrl(document, 13, function() {
					self.sync();
					K('form[name=myBlogForm]')[0].submit();
				});
				K.ctrl(self.edit.doc, 13, function() {
					self.sync();
					K('form[name=myBlogForm]')[0].submit();
				});
			}
		});
		prettyPrint();
	});
</script>
<div id="wrap">
<form class="myform" name="myBlogForm" action="<?php echo U('Blog/doPost') ;?>" method="post">
	<div>类型：<br/>
	<select name="type" >
		<?php
			foreach($this->type as $k=>$v){
				echo '<option value="'.$k.'">'.$v.'</option>';
			}
		?>
	</select>
	<div>标题：<br/>
	<input type="text" name="title" value="" class="password" style="width:600px" />
	</div>
	<style>
		.addedTags{
			margin:0 3px;
			padding:1px 3px;
			background:#08A5E0;
			color:#FFF;
		}
		.addedTags a{
			color:red;
		}
		.addedTags a:hover{
			font-size:larger ;
		}
		.selectedTags{
			margin-left:2px;
			padding-top:2px;
			padding-bottom:2px;
			min-height:20px;
		}
	</style>
	<script>
		function addTag(id){
			navName = $('#'+id).html();
			$(".selectedTags").append('<span class="addedTags" id="addNav"'+id+'>'+navName+' <a href="javascript:void(0)" onclick=\"deleteTags(id)\" title=\"取消添加该标签\"">X</a></span>');
		}
		function deleteTags(id){
			$("#addNav"+id).remove();
		}
		function checkAndPost(){
			navNum = $("span[id*=nav]").length;
			var tagValue ="";
			$("span[id*=nav]").each(function(){
				var tagId = $(this).attr('id');
				tagValue += tagId;
			})
			$("input[name='selected_nav']").attr('value',tagValue);
			//执行编辑器的sync()方法
			editor.sync();
			$("form[name='myBlogForm']").submit();
		}
	</script>
	<div class="tags">标签：<br/>
		<?php
			foreach($this->nav as $k=>$v ){
				echo '<span id="nav'.$v['id'].'" onclick="addTag(id)">'.$v['name'].'</span>';
			}
		?>
	</div>
		<div>
			<div class="modify selectedTags"></div>
			<input type="hidden" name="selected_nav"  value="">
		</div>
	<div>直接输入标签名以及添加新的标签:<br/>
		<input type="text" name="nav" value="" class="password"><br/>(标签中间用","隔开)
	</div>
	<div>内容：<br/>
		<textarea name="content" style="width:100%;height:200px;visibility:hidden;"></textarea>
	</div>
    <div class="inputClass">
    	<div style="text-align:center;margin-top:10px;font-size:15px;font-weight:800;background-color: #08A5E0;width:70px;color:#FFF;">发布</div>
    	<input type="button" value="提交" class="inputstyle" onclick="checkAndPost()" />
    </div>
</form>
</div>
<?php
include 'footer.php';
?>
