jQuery(document).ready(function($) {
	$('.toggle-map a').click(function() {
		var text=$(this).text();
		var map = $('#map');
		var height=map.height();

		if(text=='Show more') {
			map.height(2*height);
			$(this).text('Hide more');
			$("html, body").animate({
			  scrollTop: $('.toggle-map').offset().top + $('.toggle-map').outerHeight(true)
			}, 500);
			
		}else {
			map.height(height/2);
			$(this).text('Show more');
		}
		return false;
	});	
});