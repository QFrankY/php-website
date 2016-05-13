//Animations
$(document).ready(function(){
	
	//Loading Animation
	var Finished = false;
	
	$(window).scroll(function() {
		
		if ($(this).scrollTop() > 0 && $(this).scrollTop() < 100){
			if (!Finished) {
				$('#Featured p, #Featured a').css("opacity",1-$(this).scrollTop()/90); 
				$('header').css('height',450-1.5*$(this).scrollTop());
			}
		}
		else if ($(this).scrollTop() >= 100 && !Finished) {
			$('#Featured p').hide();
			$('header').css('height','300');
			$('#Featured a').css({
				'opacity': 1,
				'margin-top': 25
			}).hide().fadeIn();
			$('#Featured img').css({
				'height': '24px',
				'margin-right': '8px'
			});
			
			Finished = true;
		}
		else if (!Finished){
			$('#Featured p, #Featured a').css("opacity",1); 
			$('header').css('height',450);
		}//end if
		
		if ($(this).scrollTop() >= 310) {
			$("#SideBar").css({
				'padding-top': $(this).scrollTop() - 275
			});
		} else {
			$("#SideBar").css({
				'padding-top': 35
			});
		}
	});
	
	//Query
	$("#SideBar .tags").click(function(event) {
		var tag = $(this ).html();
		var tagName = tag.substring(0, tag.length - 6);
		
		$("#MainContent").load("portfolio/viewProjects.php?query="+tagName);
		$(document).scrollTop(0);
		$(window).load(function() {
			showProjects(); 
		});
	});
	
	$("#SideBar #viewall").click(function(event) {
		$("#MainContent").load("portfolio/viewProjects.php");
		$(document).scrollTop(0);
		$(window).load(function() {
			showProjects(); 
		});
	});
});

//Functions
function showProjects() {
	$('#Highlights').animate({opacity:1},500);
	
	var delay = 0;
	$('.projectPost').each(function(){
		$(this).delay(delay).animate({opacity:1},500);
		delay += 100;
	});
	
	$(".viewUpdates").click(function(event) {
		var project = $(this).parent().attr('id');
		var projectID = project.substring(7, project.length);
		
		$("#MainContent").load("portfolio/viewUpdates.php?project="+projectID);
		$(document).scrollTop(0);
		$(window).load(function() {
			showProjects(); 
		});

	});
	
	$(".recentUpdate").click(function(event) {
		var project = $(this).attr('id');
		var projectID = project.substring(4, project.length);
		
		$("#MainContent").load("portfolio/viewUpdates.php?project="+projectID);
		$(document).scrollTop(0);
		$(window).load(function() {
			showProjects(); 
		});
	});
}

function showUpdates() {
	$(".viewUpdates").click(function(event) {
		var project = $(this).parent().attr('id');
		var projectID = project.substring(7, project.length);
		
		$("#MainContent").load("portfolio/viewUpdates.php?project="+projectID);
		$(document).scrollTop(0);
		$(window).load(function() {
			showProjects(); 
		});

	});
	
	$(".recentUpdate").click(function(event) {
		var project = $(this).attr('id');
		var projectID = project.substring(4, project.length);
		
		$("#MainContent").load("portfolio/viewUpdates.php?project="+projectID);
		$(document).scrollTop(0);
		$(window).load(function() {
			showProjects(); 
		});
	});
	
	$('#infobar').animate({opacity:1}, 500);
	
	$(window).scroll(function() {
		if ($(this).scrollTop() > 310) {
			$("#infobar").css({
				'padding-top': $(this).scrollTop() - 310
			});
		} else {
			$("#infobar").css({
				'padding-top': 0
			});
		}
	});
	
	$(".updatePost a").attr("target", "_blank");
}

function accessGranted() {
	$("#viewPrivate").html("<h2 id='AccessGranted'>Access Granted</h2><p>Private projects are now listed</p>");
}

function wrongPassword() {
	$('input[name=passcode]').val("Incorrect!");
	alert ("Access Denied. To view all projects, contact me at Q.Frank.Yu@gmail.com");
}