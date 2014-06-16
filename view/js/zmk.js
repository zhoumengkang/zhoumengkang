$(function() {
    //我就当它是手机浏览器了
    if($(window).width()<=910){
        $("#nav").remove();
        $(".copyright").find("small").css({"padding-top": "25px","display":"block","line-height":"25px"});
        //文章图片的大小修改
        $("img").css("max-width",($(".content").width() -10));
        $(".link_postdate").css({"clear":"both","float":"left"});
        $(".link_view").css({"float":"left"});
        $(".article_manage").remove();
    }
    //修复手机浏览器下顶部不贴边
    $(document).bind('scroll',function(){
        $("#header").css("top","0");
    })
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
    $(window).scroll(function() {
        //想通过延时来缓解狂上下滚动的bug...似乎没效果
        if($(window).scrollTop() <= 90){
            $(".header").removeClass("public-transparency");
            $("#header").removeClass("small-header");
        }else{
            $(".header").addClass("public-transparency");
            $("#header").addClass("small-header");
        }
    })


    //footer吸底效果
    var _ch = $("#content").height();
    var _wh = $(window).height();
    console.log("window's height",_wh,"content's height",_ch,"_wh - _ch:",_wh - _ch);
    if(_wh - _ch > 186){
        $("#content").css("min-height",(_wh-186)+"px");
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
            zIndex:998
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

    //回车搜索
    $("input[name='keyword']").bind('keydown', function(e) {
        var key = e.which;
        if(key == 13) {
            $("form[name='search']").submit();
        }
    });

    //返回操作
    $(".closeLoginBox").click(function(){
        $('.loginBox').fadeOut('slow',function(){
            $("#login").hide();
        });
    })

    //回到顶部
	var $backToTopTxt = "返回顶部", $backToTopEle = $('<div class="backToTop"></div>').appendTo($("#footer"))
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


	//文章顶置功能
	$('a[title="recommendBlog"]').click(function(){
		var id = $(this).attr('recommendId');
        var status = $(this).attr('status');
		$.post( U('Admin/recommend'),{id:id,status:status},function(data){
			if(parseInt(data.flag)==1){
				ui.success(data.info);
			}else{
				ui.error(data.info);
			}
		},'json');
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
							location.href="/";
						},1500)
					}
				}else{
                    ui.error('操作失败');
				}
			})	
		}
		
	})

    //查看原图
    $("img").click(function(){
        if($(window).width()<=1000){
            location.href = $(this).attr('src');
            return;
        }
        var img = '<img src="'+$(this).attr('src')+'">';
        ui.box('查看图片',img);
    })

    $('.magnifier').live('click',function(){
        if($(window).width()<=1000){
            location.href = $(this).prev('img').attr('src');
            return;
        }
        var img = '<img src="'+$(this).prev('img').attr('src')+'">';
        ui.box('查看图片',img);
    })



});
//定义js里的U函数
var U = function(str){
    var parameters = str.split('/');
    var newUrl = SITE_URL+'?'+'m='+parameters[0]+'&a='+parameters[1];
    return newUrl;
}
//Cookie操作函数
function setcookie(name,value,days){
    if("undefined" == typeof(days)){
        days = 30;
    }else{
        days = parseInt(days);
    }
    var exp  = new Date();
    exp.setTime(exp.getTime() + days*24*60*60*1000);
    document.cookie = name + "="+ value + ";expires=" + exp.toGMTString();
}

function getcookie(name){
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr != null){
        return (arr[2]);
    }else{
        return "";
    }
}

//执行评论
var post_comment_flag = true;
var post_comment = function(){
    if(!post_comment_flag){
        ui.error('...稍等一会，上一条还没发送过去哦');
        return false;
    }
    post_comment_flag = false;
    var post_comment = $("textarea[name='comment']").val();
    if(post_comment.length < 1){
        ui.error('...说点什么吧');
        return false;
    }
    var post_email = $("input[name='email']").val();
    if(!post_email.match(/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/)){
        ui.error('邮箱格式不正确');
        return false;
    }
    var blogurl = $("input[name='blog']").val();
    if(blogurl){
        var blogUrlArr = blogurl.split('://');
        if(blogUrlArr.length < 2){
            blogurl = 'http://'+blogurl;
        }
    }
    var post_yourname = $("input[name='yourname']").val();
    //第一次留言，则把用户的邮箱、称呼、博客地址存到客户端cookie里方便下次调用，而不用浏览的人手动输入了
    if(!getcookie('yourname') || getcookie('yourname') != post_yourname){
        setcookie('yourname',post_yourname);
    }
    if(!getcookie('email') || getcookie('email') != post_email){
        setcookie('email',post_email);
    }
    if(!getcookie('blog') || getcookie('blog') != blogurl){
        setcookie('blog',blogurl);
    }
    $.post(U('Comment/doComment'),{
        replyId:$("input[name='replyId']").val(),
        blogid: $("input[name='blogid']").val(),
        blog:blogurl,
        content: post_comment,
        email: post_email,
        name: post_yourname
    },function(data){
        post_comment_flag = true;
        if(parseInt(data.flag)>0){
            ui.success(data.info);
            $("#commentList").append('<div class="commentlist"><div><a href="'+blogurl+'">'+$("input[name='yourname']").val()+'</a>刚刚</div>'+data.data+'</div>');
            $("textarea[name='comment']").val('');
        }else{
            ui.error(data.info);
        }
    })
}