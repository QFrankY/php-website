$(document).ready(function(){
	
	var Finished = false;
	
	$(window).scroll(function() {
		
		if ($(this).scrollTop() > 0 && $(this).scrollTop() < 100){
			if (!Finished) {
				$('#Featured').css('margin-left', 40 + $(this).scrollTop()/10);
				$('#Featured p').css("opacity",1-$(this).scrollTop()/200); 
				$('#Featured h1').css('margin-top',50-$(this).scrollTop()/10);
				$('#ProfilePic').css({	
					'margin-top': 70-$(this).scrollTop()/5
				});
			}
		}
		else if ($(this).scrollTop() >= 100 && !Finished) {
			$('#Featured').css('margin-left',50);
			$('#Featured h1').css('margin-top','40px');
			$('#Featured p').animate({opacity:0},250, function(){
				$('#Featured p').hide();
			}); 
			$('header').animate({height:'300px'}, 250);
			$('#ProfilePic img').animate({
					'height': 200,
					'width': 150
			}, 250);
			
			
			$('#ProfilePic').css({	
				'margin-top': '50px',
				'margin-left': '55px'
			});
			$('#ProfilePic img').css({
				'-webkit-box-shadow':'2px 2px 5px 0px #404040',
				'-moz-box-shadow':'2px 2px 5px 0px #404040',
				'box-shadow':'2px 2px 5px 0px #404040'
			});
			$('#Featured a').css('opacity', 1).hide().fadeIn();
			$('#Featured img').css({
				'height': '24px',
				'margin-right': '8px'
			});
			
			Finished = true;
		}
		else if (!Finished){
			$('#Featured').css('margin-left',40);
			$('#Featured p, #Featured a').css("opacity",1); 
			$('#Featured h1').css('margin-top','50px');
			$('header').css('height',450);
			$('#ProfilePic').css({	
				'margin-top': 70
			});
			$('#ProfilePic img').css({
				'height': 280,
				'width': 210,
				'-webkit-box-shadow':'2px 2px 5px 0px #000000',
				'-moz-box-shadow':'2px 2px 5px 0px #000000',
				'box-shadow':'2px 2px 5px 0px #000000'
			});

		}//end if
	});
});