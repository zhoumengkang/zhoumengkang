$(function() {
    //控制台隐藏
    $("a[name='consoleHide']").click( function(){
        var ele = $(this);
        if(parseInt($("#console").css("right"))>0){
            $("#console").animate({
                right:"-96px"
            },function(){
                ele.text("《《").addClass('showConsole');
            });
        }else{
            $("#console").animate({
                right:"20px"
            },function(){
                ele.removeClass('showConsole').text("X");
            });
        }


    });

    //顶部效果
    $(window).scroll(function() {
        if($(window).scrollTop()==0){
            //恢复
            if($("#intro").css('display')=="block"){
                return false;
            }else{
                $(".sign").fadeOut('100',function(){
                    $("#intro").fadeIn('slow')
                });
                $("#header").removeClass('fixed_top').addClass('header_relatvie').animate({
                 "height": "96px"

                 }).find(".logo").animate({
                 "font-size": "40px",
                 "line-height": "96px"
                 }).parent().parent().find(".nav").animate({
                        "line-height": "40px",
                        "padding":0,
                        "margin-top":"28px",
                        "margin-bottom":"28px"
                    });
            }
        }else{
            if($("#header").hasClass('fixed_top')){
                return false;
            }
            $("#header").removeClass('header_relatvie').addClass('fixed_top').animate({
                "height": "46px"
            },500).find(".logo").animate({
                    "font-size": "28px",
                    "line-height": "46px"
                }).parent().parent().find(".nav").animate({
                    "line-height": "46px",
                    "padding":0,
                    "margin-top":0,
                    "margin-bottom":0
                });
            $("#intro").fadeOut('100',function(){
                $(".sign").css({"padding-top":"15px"}).show();
            });
        }
    })


    //footer吸底效果
    var _ch = $("#content").height();
    var _wh = $(window).height();
    console.log("window's height",_wh,"content's height",_ch,"_wh - _ch:",_wh - _ch);
    if(_wh - _ch > 192){
        $("#content").css("height",(_wh-192)+"px");
    }




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