$(function() {
    //控制台隐藏
    $("a[name='consoleHide']").click( function(){
        var ele = $(this);
        if(parseInt($("#console").css("right"))>0){
            $("#console").animate({
                right:"-96px"
            },function(){
                ele.text("《《").removeClass('xx').addClass('showConsole');
            });
        }else{
            $("#console").animate({
                right:"16px"
            },function(){
                ele.removeClass('showConsole').addClass('xx').text("X");
            });
        }


    });

    //顶部效果
    //TODO:BUG越来越严重了，我擦！
    /*$(window).scroll(function() {
        if($(window).scrollTop()==0){
            //恢复
             $(".sign").hide(function(){
                 $("#intro").fadeIn('slow');
             });
             $("#header").removeClass('fixed_top').animate({
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
        }else{
            $("#header").addClass('fixed_top').animate({
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
            $("#intro").hide(function(){
                $(".sign").css({"padding-top":"15px"}).show();
            });
        }
    })*/


    //footer吸底效果
    var _ch = $("#content").height();
    var _wh = $(window).height();
    console.log("window's height",_wh,"content's height",_ch,"_wh - _ch:",_wh - _ch);
    if(_wh - _ch > 192){
        $("#content").css("height",(_wh-192)+"px");
    }


    //ajax登录
    //显示登录框
    $("a[name='login']").click( function(){

        $("#login").fadeIn('slow');
        var _w = $('#loginBox').width();
        var _h = $('#loginBox').height();
        // 获取定位值
        var left = ($('body').width() - _w)/2 ;
        var top  = ($(window).height()-_h)/2;
        // 添加弹窗样式与动画效果（出现）
        $('.loginBox').css({
            position:'fixed',
            left:left + "px",
            top:top + "px",
            zIndex:5
        }).fadeIn("slow");
    })
    //登录操作
    var loginFun = function(){
        $.post(U('Blog/login'),{password:$("input[name='password']").val()},function(data){
            if(parseInt(data)==1){
                ui.success('登录成功');
                setTimeout(function(){
                    $('.loginBox').fadeOut('slow',function(){
                        $("#login").hide(function(){
                            location.reload();
                        });
                    });
                },500);
            }else{
                ui.error('登录失败');
            }
        })
    };

    $(".loginActive").click(function(){
        loginFun();
    });
    $("input[name='password']").bind('keydown', function(e) {
        var key = e.which;
        if(key == 13) {
            loginFun();
        }
    });

    //返回操作
    $(".closeLoginBox").click(function(){
        $('.loginBox').fadeOut('slow',function(){
            $("#login").hide();
        });
    })

    //回到顶部
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
				ui.success('顶置成功');
			}else{
				ui.error('操作失败');
			}
		})
	})
	//文章的删除
	$('a[title="deletdBlog"]').click(function(){
		var id = $(this).attr('deleteId');
		if (confirm("确定删除?")) {
			$.post(U('Admin/deleteBlog'),{id:id},function(data){
				if(data ==1){
					ui.success('删除成功');
					var blog = $('div[blogId="'+id+'"]').html();
					if(blog!=null){
						$("div[blogId='"+id+"']").fadeOut('slow');
					}else{
						setTimeout(function(){
							location="<?php echo U('Blog/index')?>";
						},1500)
					}
				}else{
                    ui.error('操作失败');
				}
			})	
		}
		
	})
});