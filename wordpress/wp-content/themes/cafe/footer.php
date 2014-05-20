<footer>
<div class="Flexible-container">
    <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2794.6237754007248!2d-73.61808500000002!3d45.537775999999944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc9191405cae271%3A0x8c4505ded4db7656!2sCaf%C3%A9+Larue+%26+fils!5e0!3m2!1sen!2sca!4v1400288207634"></iframe>
</div>

</footer>
<?php wp_footer();?>
<script>
	jQuery(document).ready(function() {
		jQuery("#owl-demo").owlCarousel({
			items : 2,
            lazyLoad : true,
            navigation : false,
            itemsDesktop : [1199,2],
		    itemsDesktopSmall : [980,1],
		    itemsTablet: [980,1],
		    itemsTabletSmall: false,
		    itemsMobile : [479,1],
		    singleItem : false,
		    itemsScaleUp : false
            }); 
        });
	jQuery(document).ready(function() {
		jQuery("#owl-demo2").owlCarousel({
			items : 5,
            lazyLoad : true,
            navigation : false,
            itemsDesktop : [1199,3],
		    itemsDesktopSmall : [980,1],
		    itemsTablet: [980,2],
		    itemsTabletSmall: false,
		    itemsMobile : [479,1],
		    singleItem : false,
		    itemsScaleUp : false
            }); 
        });
</script>
</body>
</html>