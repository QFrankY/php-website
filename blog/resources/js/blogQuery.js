$(document).ready(function(){
	$("#SideBar .tags").click(function(event) {
		var tag = $(this ).html();
		var tagName = tag.substring(0, tag.length - 6);
		
		$("#MainContent").load("blog/blogQuery.php?tag="+tagName);
		$(document).scrollTop(0);
	});
	
	$("#SideBar #viewall").click(function(event) {
		$("#MainContent").load("blog/blogQuery.php");
		$(document).scrollTop(0);
	});
});//end document