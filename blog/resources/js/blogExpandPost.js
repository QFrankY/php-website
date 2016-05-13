$(document).ready(function(){
	$(".cont, .close").hide();

	$(".button").click(function(event) {
		var parentID = $(this).parent().parent().attr('id');
		$("#" + parentID + " .button").hide();
		$("#" + parentID + " .desc").slideUp("fast", function(){
			$("#" + parentID + " .cont").slideDown( function(){
				$("#" + parentID + " .close").fadeIn();
			});
		});
	});

	$(".close").click(function(event) {
		var parentID = $(this).parent().parent().parent().attr('id');
		$("#" + parentID + " .close").hide();
		$("#" + parentID + " .cont").slideUp( function(){
			$("#" + parentID + " .button").fadeIn();
			$("#" + parentID + " .desc").slideDown();
		});
	});
});