jQuery(document).ready(function($) {
	$('.toggle-map a').click(function() {
		var text=$(this).text();
		var map = $('#map');
		var height=map.height();

		if(text=='+ GROS') {
			map.height(2*height);
			$(this).text('- MOINS');
			$("html, body").animate({
			  scrollTop: $('.toggle-map').offset().top + $('.toggle-map').outerHeight(true)
			}, 500);
			
		}else {
			map.height(height/2);
			$(this).text('+ GROS');
		}
		return false;
	});	
});