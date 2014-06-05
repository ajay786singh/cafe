<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name') ?></title>
    <?php 
        $args   =array('post_type' => 'post','posts_per_page' => 1);query_posts($args);
        if (have_posts()) : while(have_posts()) : the_post();
        if (is_single()) { ?>
            <meta property="og:url" content="<?php the_permalink() ?>"/>
            <meta property="og:title" content="<?php single_post_title(''); ?>" />
            <meta property="og:description" content="<?php echo strip_tags(get_the_excerpt($post->ID)); ?>" />
            <meta property="og:type" content="article" />
            <meta property="og:image" content="<?php if (function_exists('catch_that_image')) {echo catch_that_image(); }?>" />
        <?php } else { ?>
            <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
            <meta property="og:description" content="<?php bloginfo('description'); ?>" />
            <meta property="og:type" content="website" />
            <meta property="og:image" content="<?php bloginfo('template_url' ); ?>/images/logo.png">
    <?php } endwhile; endif; ?>
    <?php wp_reset_query(); ?>
    <script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
    
    <?php wp_head(); ?>
    
    <script type="text/javascript">
        /*Google Analytics
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-1322597-2']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
        */
    </script>

    <!--         
    When using Google Maps on your own site you MUST signup for your own API key at:
    https://developers.google.com/maps/documentation/javascript/tutorial#api_key
    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.14&(key=AIzaSyBIiiFbPAKfTIqOC8K4sKqf1DB39Uh1hZc)&sensor=false"></script>
    <script type="text/javascript">
        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'resize', init);
        google.maps.event.addDomListener(window, 'load', init);
        
        function init() {
            // Basic options for a simple Google Map
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
            var mapOptions = {
                zoom: 16,
                center: new google.maps.LatLng(45.538776, -73.618085,17),

                mapTypeId: google.maps.MapTypeId.ROADMAP,

                // How you would like to style the map. 
                // This is where you would paste any style found on Snazzy Maps.
                styles: [
                            {   
                            featureType:"administrative",
                            stylers:[ 
                                { visibility:"off"}
                                ]
                            },{
                            featureType:"landscape",
                            stylers:[
                                { color:"#f0ede5" }
                                ]
                            },{
                            featureType:"poi",
                            stylers:[
                                { visibility:"on" }
                                ]
                            },{
                            featureType:"poi.business",
                            stylers:[
                                { visibility:"off" }
                                ]
                            },{
                            featureType:"poi.park",
                            stylers:[
                                { color:"#74c7a3" }
                                ]
                            },{
                            featureType:"poi.park",
                            elementType:"labels.text.fill",
                            stylers:[
                                { color:"#ffffff" }
                                ]
                            },{
                            featureType:"road",
                            elementType:"labels",
                            stylers:[
                                { visibility:"on" }
                                ]
                            },{
                            featureType:"road.highway",
                            stylers:[
                                { visibility:"off" }
                                ]
                            },{
                            featureType:"road.highway",
                            elementType:"geometry",
                            stylers:[
                                { visibility:"on" }
                                ]
                            },{
                            featureType:"road.local",
                            stylers:[
                                { visibility:"on" },
                                { color:"#57544b" }
                                ]
                            },{
                            featureType:"road.local",
                            elementType:"labels.text.fill",
                            stylers:[
                                { color:"#ffffff" }
                                ]
                            },{
                            featureType:"road.local",
                            elementType:"labels.text.stroke",
                            stylers:[
                                { visibility:"on" },
                                ]
                            },{
                            featureType:"water",
                            stylers:[
                                { visibility:"simplified"},
                                { color:"#6fcac7" } 
                                ]
                            },{
                            featureType:"landscape",
                            stylers:[
                                { visibility:"simplified" }
                                ]
                            },{
                            featureType:"transit",
                            stylers:[
                                { visibility:"on" }
                                ]
                            },{
                            featureType:"transit.line",
                            elementType:"geometry",
                            stylers:[
                                { color:"#3f518c" }
                                ]
                            }
                        ]
            };

            // Get the HTML DOM element that will contain your map 
            // We are using a div with id="map" seen below in the <body>
            var mapElement = document.getElementById('map');

            // Create the Google Map using out element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);

            // Define Marker properties
            var image = new google.maps.MarkerImage('<?php bloginfo(template_url)?>/images/map-pointer.png',
                // This marker is 129 pixels wide by 42 pixels tall.
                new google.maps.Size(57, 73),
                // The origin for this image is 0,0.
                new google.maps.Point(0,0),
                // The anchor for this image is the base of the flagpole at 18,42.
                new google.maps.Point(25, 73)
            );

            // Add Marker
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(45.537776, -73.618085,17),
                map: map,
                icon: image // This path is the custom pin to be shown. Remove this line and the proceeding comma to use default pin

            });

            // Create our info window content   
            var infoWindowContent = '<div class="info_content">' +
                '<h3>Cafe Larue & Fils</h3>' +
                '<p>244 de Castelnau Est.<br>272-8087</p>' +
            '</div>';

            // Initialise the inforWindow
            var infoWindow = new google.maps.InfoWindow({
                content: infoWindowContent
            });

            // Display our info window when the marker is clicked
            google.maps.event.addListener(marker, 'click', function() {
                infoWindow.open(map, marker);
            });
        }
    </script>

</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=295402343969195&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<header>
    <!--<div id="owl-demo" class="owl-carousel" style="background-color: #000;">-->
    <div id="slider1" class="owl-carousel">

    <?php
        $args = array(
            'post_type'         => 'slider',
            'posts_per_page'    => 10,
            'orderby'           => 'menu_order',
            'order'             => 'ASC',
        );
    
        $myposts = get_posts( $args );

        foreach ( $myposts as $post ) : setup_postdata( $post ); 
        
        $attachment_id  = get_post_meta( $post->ID, '_id_image',true);
        $image_link     = get_post_meta($post->ID, '_id_image_link' ,true);
        $video_url      = get_post_meta($post->ID, '_id_video_url' ,true);
        $image_src      = wp_get_attachment_image_src($attachment_id, slider);
    ?>

        <!--<div class="item">-->
            <?php if($attachment_id): ?>
                <a href="<?php echo $image_link; ?>"><img src="<?php echo $image_src[0]; ?>" alt="<?php the_title(); ?>"></a>
            <?php else: ?>
                <a class="owl-video" href="<?php echo $video_url; ?>"></a>
            <?php endif; ?>
        <!--</div>-->

    <?php endforeach; wp_reset_postdata();?>

    </div>
</header>
