$(function() {
	var $backToTopTxt = "返回顶部", $backToTopEle = $('<div class="backToTop"></div>').appendTo($("body"))
		.text($backToTopTxt).attr("title", $backToTopTxt).click(function() {
			$("html, body").animate({ scrollTop: 0 }, 120);
	}), $backToTopFun = function() {
		var st = $(document).scrollTop(), winh = $(window).height();
		(st > 100)? $backToTopEle.show(): $backToTopEle.hide();	
		//IE6下的定位
		if (!window.XMLHttpRequest) {
			$backToTopEle.css("top", st + winh - 166);	
		}
	};
	$(window).bind("scroll", $backToTopFun);
	$(function() { $backToTopFun(); });
	//定义js里的U函数
	var U = function(str){
		var oldUrl = location.href;
		var path = oldUrl.split('?');
		var parameters = str.split('/');
		var newUrl = path[0]+'?'+'m='+parameters[0]+'&a='+parameters[1];
		return newUrl;
	}

	//文章顶置功能
	$('a[title="recommendBlog"]').click(function(){
		var id = $(this).attr('recommendId');
		$.post( U('Admin/recommend'),{id:id},function(data){
			if(data==1){
				msg = '顶置成功';
				showMsg(msg);
			}else{
				msg = '操作失败';
				showMsg(msg);
			}
		})
	})
	//文章的删除
	$('a[title="deletdBlog"]').click(function(){
		var id = $(this).attr('deleteId');
		if (confirm("确定删除?")) {
			$.post(U('Admin/deleteBlog'),{id:id},function(data){
				if(data ==1){
					msg = '删除成功';
					showMsg(msg);
					var blog = $('div[blogId="'+id+'"]').html();
					if(blog!=null){
						$("div[blogId='"+id+"']").fadeOut('slow');
					}else{
						setTimeout(function(){
							location="<?php echo U('Blog/index')?>";
						},1500)
					}
				}else{
					msg = '操作失败';
					showMsg(msg);
				}
			})	
		}
		
	})
});