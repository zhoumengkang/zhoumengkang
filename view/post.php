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
<form class="myform" name="myBlogForm" action="" method="post" enctype="multipart/form-data">
	<div>类型：<br/>
	<!--nav type-->
	<select name="type" id="type" >
		<?php
			echo "<option >请选择</option>\r\n";
			foreach($this->nav as $k=>$v){
				if ($v['pid']==0) {
					if($blog[0]['type']==$v['id']){
						echo '<option value="'.$v['id'].'" selected="selected">'.$v['name'].'</option>';
					}else{
						//
						echo '<option value="'.$v['id'].'">'.$v['name'].'</option>';
					}
				}
				
			}
		?>
	</select>
	<select name="nav" id="nav" style="display:none" ></select>
	<div>标题：<br/>
	<input type="text" name="title" class="password" style="width:600px" value="<?php echo $blog[0]['title'];?>"/>
	</div>
	
	<div class="tags">标签：<br/>
		<?php
		if (is_array($this->tags)) {
			foreach($this->tags as $k=>$v ){
				echo '<span id="tags'.$v['id'].'" onclick="addTag(id)">'.$v['name'].'</span>';
			}
		}
		?>
	</div>
	<div>
		<div class="modify selectedTags">
		<?php if(is_array($selectedTags)){
			echo '<input type="hidden" name="original_tags" value="'.$selectedTags_str.'">';
			 foreach ($selectedTags as $key => $value) {
				echo '<span class="addedTags" id="addtags'.$value['id'].'">'.$value['name'].' <a href="javascript:void(0)" name="deleteTags" title="取消添加该标签">X</a></span>';
			}
		}?>
		</div>
		<input type="hidden" name="selected_tags"  value="">
	</div>
	<div>直接输入标签名以及添加新的标签:<br/>
		<input type="text" name="tags" value="" class="password" style="width:600px"><br/>(标签中间用","隔开)
	</div>
	<div>内容：<br/>
		<textarea name="content" style="width:100%;height:200px;visibility:hidden;"><?php if(isset($blog)){
			echo $blog[0]['content'];
		}?></textarea>
	</div>
	<?php if($action == 'modifyBlog'){ ?>
		<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
	<div>修改日志：<br/>
		<input type="text" name="modifyLog" style="width:99%" class="password"  />
    </div>
	<?php }?>
    <div class="inputClass">
    	<div style="text-align:center;margin-top:10px;font-size:15px;font-weight:800;background-color: #08A5E0;width:70px;color:#FFF;">发布</div>
    	<input type="button" value="提交" class="inputstyle" onclick="checkAndPost('<?php echo $action;?>')" />
    </div>

</form>
</div>
<script>
	$("#type").change(function(){
		var typeId = $(this).val();
		var url = "<?php echo U('Blog/getNav') ?>";
		$.post(url,{id:typeId},function(data){
			//data = eval(data);//没有给$.post()函数传最后一个格式参数json的时候需要使用eval把字符串转成对象
			if (data) {
				$("#nav").fadeIn();
				var newOption = "";
				for (var i = data.length - 1; i >= 0; i--) {
				 	newOption += '<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';

				}; 
				$("#nav").html(newOption);
			} else{
				$("#nav").html('');
				$("#nav").fadeOut();
			};
			
		},'json');	
	})
	function addTag(id){
		tagName = $('#'+id).html();
		//console.log(tagName);
		$(".selectedTags").append('<span class="addedTags" id="add'+id+'">'+tagName+' <a href="javascript:void(0)" name="deleteTags" title="取消添加该标签">X</a></span>');
	}
	$('a[name="deleteTags"]').live('click',function(){
		$(this).parent().remove();
	})
	function checkAndPost(a){
		
		var tagValue ="";
		$("span[id*=addtags]").each(function(){
			var tagId = $(this).attr('id');
			tagValue += tagId;
		})
		//console.log(tagValue);
		$("input[name='selected_tags']").attr('value',tagValue);
		//执行编辑器的sync()方法
		editor.sync();
		if(a =='post'){
			$("form[name='myBlogForm']")[0].action='<?php echo U("Blog/doPost")?>';
		}else{
			$("form[name='myBlogForm']")[0].action='<?php echo U("Admin/doModify")?>';
		}
		$("form[name='myBlogForm']")[0].submit();
	}
</script>
<?php
include 'footer.php';
?>
