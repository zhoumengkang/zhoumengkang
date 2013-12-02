function showMsg(msg){
	$(".messageBox").html(msg);
	var h = $(window).height();
	var w = $(window).width();
	h = $(window).scrollTop()+h;
	w= $(window).scrollLeft()+w; 
	var left = (w / 2) - parseInt($(".messageBox").css("width")) / 2;
	var top = (h / 2) - parseInt($(".messageBox").css("height")) / 2;	
	$(".messageBox").css({position:"absolute","z-index":"1000","left": left+"px" ,"top": top+"px"});
	$(".messageBox").fadeIn("slow");
	$(".messageBox").fadeOut("slow");
}
