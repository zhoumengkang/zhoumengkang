/**
 * 窗体对象，全站使用，统一窗体接口
 */
var ui = {
	/**
	 * 浮屏显示消息，提示信息框
	 * @param string message 信息内容
	 * @param integer error 是否是错误样式，1表示错误样式、0表示成功样式
	 * @param integer lazytime 提示时间
	 * @return void
	 */
	showMessage: function(message, error) {
		var style = (error=="1") ? "html_clew_box clew_error" : "html_clew_box";
		var ico = (error == "1") ? 'ico-error' : 'ico-ok';
		var html = '<div class="'+style+'" id="ui_messageBox" style="display:none">\
					<div class="html_clew_box_con" id="ui_messageContent">\
					<i class="'+ico+'"></i>'+message+'</div></div>';		
		var _u = function() {
			for (var i = 0; i < arguments.length; i++) {
		        if (typeof arguments[i] != 'undefined') return false;
			}
		    return true;
		};
		// 显示提示弹窗
		ui.showblackout();
		// 将弹窗加载到body后
		$(html).appendTo(document.body);
		// 获取高宽
		var _h = $('#ui_messageBox').height();
		var _w = $('#ui_messageBox').width();
		// 获取定位值
		var left = ($('body').width() - _w)/2 ;
		var top  = $(window).scrollTop() + ($(window).height()-_h)/2;
		// 添加弹窗样式与动画效果（出现）
		$('#ui_messageBox').css({
			left:left + "px",
			top:top + "px"
		}).fadeIn("slow",function(){
			$('#ui_messageBox').prepend('<iframe style="z-index:;position: absolute;visibility:inherit;width:'+_w+'px;height:'+_h+'px;top:0;left:0;filter=\'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)\'"'+
		 	'src="about:blank"  border="0" frameborder="0"></iframe>');
		});
		// 添加弹窗动画效果（消失）
		setTimeout(function() {
			$('#ui_messageBox').find('iframe').remove();
			$('#ui_messageBox').fadeOut("slow", function() {
			  ui.removeblackout();
			  $('#ui_messageBox').remove();
			});
		} , 1000);
	},
    /**
     * 成功提示框
     * @return void
     */
    success: function(msg){
        ui.showMessage(msg,0);
    },
    /**
     * 失败提示框
     * @return void
     */
    error: function(msg){
        ui.showMessage(msg,1);
    },
    /**
     * 处理ajax返回数据之后的刷新操作
     * @param   object obj  ajax返回的数据 {'data':xxx,'info':'xxxx','status':1}
     */
    ajaxReload: function(obj,callback){
        if("undefined" == typeof(callback)){
            callback = "location.href = location.href";
        }else{
            callback = 'eval('+callback+')';
        }
        if(obj.status == 1){
            ui.success(obj.data);
            setTimeout(callback,1500);
        }else{
            ui.error(obj.data);
        }
    },
	/**
	 * 添加提示框
	 * @return void
	 */
	showblackout: function() {
		if($('.boxy-modal-blackout').length > 0) {
			// TODO:???
	    } else {
	    	var height = $('body').height() > $(window).height() ? $('body').height() : $(window).height();
	    	$('<div class ="boxy-modal-blackout" ><iframe style="z-index:-1;position: absolute;visibility:inherit;width:'+$('body').width()+'px;height:'+height+'px;top:0;left:0;filter=\'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)\'"'+
		 'src="about:blank"  border="0" frameborder="0"></iframe></div>')
		.css({
		    height:height+'px',width:$('body').width()+'px',zIndex: 999, opacity: 0.5
		}).appendTo(document.body);
	    }
	},
	/**
	 * 移除提示框
	 * @return void
	 */
	removeblackout: function() {
		if($('#tsbox').length > 0) {
		 	if(document.getElementById('tsbox').style.display == 'none'){
		 		$('.boxy-modal-blackout').remove();
		 	}
		 } else {
		 	$('.boxy-modal-blackout').remove(); 	
		 }
	},

    /**
     * 弹窗（需要手动关闭点X才能关闭与上面的messagebox的区别）
     * @author  zhoumengkang <i@zhoumengkang.com>
     * @param   string  title   弹窗标题
     * @param   string  content 信息内容
     * @param   integer height  自定义个高端
     * @param   integer width   自定义宽度
     * @return  void
     */
    //box:function(title,content,height,width){
    box:function(title,content){
        //box样式均在box.css里面
        var popbackground= '<div class="popbackground" id="popbackground"></div>';
        $(popbackground).appendTo(document.body);
        var boxdiv = '<div class="popbox" id="popbox">\
            <div class="innerpopbox">\
                <div class="title">\
                    <div id="poptitle"></div>\
                    <a class="btn-close popclose" href="javascript:void(0);">×</a>\
                </div>\
                <div class="content" id="popcontent"></div>\
            </div>\
        </div>';

        $(boxdiv).appendTo(document.body);
        //往弹窗里写入内容
        $("#poptitle").html(title);
        $("#popcontent").html(content);

        //检测是否有传入宽度和高度
        //一般来说说不用传宽度，因为宽度是自适应的，因为$("#popbox")最开始是float:left
        /*if("undefined" == typeof(width)){
            var _w = $('#popbox').width();
        }else{
            var _w = width;
            $('#popbox').css({width:width+'px'});
        }
        if("undefined" == typeof(height)){
            var _h = $('#popbox').height();
        }else{
            var _h = height;
            var contentHeight = parseInt(height) - 30;
            console.log(contentHeight);
            $('#popcontent').css('height',contentHeight+'px');
        }*/
        var _w = $('#popbox').width();
        var _h = $('#popbox').height();
        // 获取定位值
        var left = ($('body').width() - _w)/2 ;
        var top  = ($(window).height()-_h)/2;
        // 添加弹窗样式与动画效果（出现）
        $('#popbox').css({
            position:'fixed',
            left:left + "px",
            top:top + "px",
            zIndex:1000
        }).fadeIn("slow");
    },
    /**
     * 确认框
     * @param string   content
     * @param callback _callback1
     * @param callback _callback2
     */
    confirm:function(content,_callback1,_callback2){
        var popbackground= '<div class="popbackground" id="popbackground"></div>';
        $(popbackground).appendTo(document.body);
        var boxdiv = '<div class="popbox" id="popbox">\
            <div class="innerpopbox">\
                <div class="title">\
                    <div id="poptitle">温馨提示</div>\
                </div>\
                <div class="content" id="popcontent"></div>\
                <div class="confirm">\
                    <button type="button" class="btn btn-success" id="ui_confirm_yes">是</button>\
                    <button type="button" class="btn btn-warning" id="ui_confirm_no">否</button>\
                </div>\
            </div>\
        </div>';

        $(boxdiv).appendTo(document.body);
        //往弹窗里写入内容
        $("#popcontent").html(content);
        var _w = $('#popbox').width();
        var _h = $('#popbox').height();
        // 获取定位值
        var left = ($('body').width() - _w)/2 ;
        var top  = ($(window).height()-_h)/2;
        // 添加弹窗样式与动画效果（出现）
        $('#popbox').css({
            position:'fixed',
            left:left + "px",
            top:top + "px",
            zIndex:10000
        }).fadeIn("slow");

        $("#ui_confirm_yes").click(function(){
            /*if("function"==typeof(_callback1)){
                _callback1();
            }else{
             eval(_callback1);
            }*/
            _callback1();
            if($("#popbox")){
                $("#popbox").remove();
            }
            if($("#popbackground")){
                $("#popbackground").remove();
            }
        });

        $("#ui_confirm_no").click(function(){
            _callback2();
            if($("#popbox")){
                $("#popbox").remove();
            }
            if($("#popbackground")){
                $("#popbackground").remove();
            }
        });

    }
}

$(".popclose").live('click',function(){
    $("#popbox").fadeOut('slow',function(){
        $("#popbox").remove();
        $("#popbackground").remove();
    });
})
