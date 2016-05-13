$(document).ready(function(){
	$("#Content, footer").css('opacity',0);
	$("#HeaderBody, #ProfilePic").hide();
});
$(window).load(function(){
	$(document).scrollTop(0);

	$("#HeaderBody").slideDown("slow" , function(){
		$("#ProfilePic").fadeIn("slow");
		$("#Content, footer").fadeTo(500,1);
	});
});