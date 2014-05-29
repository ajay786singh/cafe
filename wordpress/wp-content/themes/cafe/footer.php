<footer>
	<div id="map"></div>
</footer>
<?php wp_footer();?>

<script>
	jQuery(document).ready(function() {
		jQuery("#owl-demo").owlCarousel({
			items : 1,
            lazyLoad : true,
            navigation : false,
            itemsDesktop : [1199,1],
		    itemsDesktopSmall : [980,1],
		    itemsTablet: [980,1],
		    itemsTabletSmall: false,
		    itemsMobile : [479,1],
		    singleItem : false,
		    itemsScaleUp : false,
		    pagination: false,
		    navigation: true
            }); 
        });
	jQuery(document).ready(function() {
		jQuery("#owl-demo2").owlCarousel({
			items : 5,
            lazyLoad : true,
            navigation : false,
            itemsDesktop : [1499,3],
		    itemsDesktopSmall : [980,1],
		    itemsTablet: [980,2],
		    itemsTabletSmall: false,
		    itemsMobile : [630,1],
		    singleItem : false,
		    itemsScaleUp : false,
		    pagination: false,
		    navigation: true
            }); 
        });
</script>
</body>
</html>