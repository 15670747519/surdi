$(function(){
		$("li.menu").hover(function(){
			$(this).children('a').toggleClass("hover");
		 	$(this).children('ul').toggleClass("hover");
		});
		$(".gotoapp").hover(function(){
			$(this).toggleClass("gotoappline1");
			$(this).children('div.iconhoverb').toggleClass("iconhover");
		});
	})