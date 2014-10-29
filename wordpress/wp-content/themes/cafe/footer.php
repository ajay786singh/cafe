<footer>
	<div id="map"></div>
	<div class="toggle-map"><a href="">Show more</a></div>
</footer>
<?php wp_footer();?>
<script>
	jQuery(document).ready(function(){
  		jQuery('#slider1').owlCarousel({
    		loop:true,
    		merge:true,
    		margin:0,
    		nav:true,
    		dots: false,
    		lazyLoad : true,
    		video: true,
    		center:true,
    		responsive:{
        		0:{
            		items:1
        		},
        		600:{
            		items:1
        		},
        		1000:{
            		items:1
        		}
    		}
		});

    jQuery('#slider2').owlCarousel({
            loop:true,
            merge:true,
            margin:0,
            nav:true,
            dots: false,
            lazyLoad : true,
            video: true,
            center:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });


	});	
</script>
</body>
</html>