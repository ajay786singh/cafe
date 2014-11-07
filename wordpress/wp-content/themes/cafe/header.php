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
    
    <?php wp_head(); ?>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.14&key=AIzaSyBIiiFbPAKfTIqOC8K4sKqf1DB39Uh1hZc&sensor=false"></script>
    <script type="text/javascript">
		
        var map;
		var infobox;
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
            map = new google.maps.Map(mapElement, mapOptions);
			var bounds = new google.maps.LatLngBounds();
            // Define Marker properties
            var image = new google.maps.MarkerImage('<?php bloginfo(template_url);?>/images/map-pointer.png',
                // This marker is 129 pixels wide by 42 pixels tall.
                new google.maps.Size(57, 73),
                // The origin for this image is 0,0.
                new google.maps.Point(0,0),
                // The anchor for this image is the base of the flagpole at 18,42.
                new google.maps.Point(25, 73)
            );
				var markers = [
					['Cafe Larue & Fils', 45.5378437, -73.6181039], //244 de Castelnau
					['Cafe Larue & Fils', 45.5428795,-73.6292336] // 405 Jarry
				];
				
				 // Info Window Content
				var infoWindowContent = [
					['<div class="info_content">' +
					'<h3>Cafe Larue & Fils</h3>' +
					'<p>244 de Castelnau Est.<br>272-8087</p>' +'</div>'],
					['<div class="info_content">' +
					'<h3>Cafe Larue & Fils</h3>' +
					'<p>405 Jarry Est,.<br>272-8087</p>' +
					'</div>']
				];
				
				// Display multiple markers on a map
				var infoWindow = new google.maps.InfoWindow(), marker, i;
				
				// Loop through our array of markers & place each one on the map  
				for( i = 0; i < markers.length; i++ ) {
					var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
					bounds.extend(position);
					marker = new google.maps.Marker({
						position: position,
						map: map,
						title: markers[i][0],
						icon: image
					});
					
					// Allow each marker to have an info window    
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infobox = new InfoBox({
								//content: document.getElementById("infobox1"),
								disableAutoPan: false,
								maxWidth: 150,
								pixelOffset: new google.maps.Size(-140, -190),
								zIndex: null,
								boxStyle: {
											background: "black",
											opacity: 1,
											width: "280px"
									},
								closeBoxMargin: "12px 4px 2px 2px",
								closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
								infoBoxClearance: new google.maps.Size(1, 1)
							});
							infobox.setContent(infoWindowContent[i][0]);
							infobox.open(map, marker);
						}
					})(marker, i));

					// Automatically center the map fitting all markers on the screen
					//map.fitBounds();
				}
				
				  // Create the DIV to hold the control and
				  // call the HomeControl() constructor passing
				  // in this DIV.
				  
				  var locationControlDiv1 = document.createElement('div');
				  var locationControl1 = new LocationControl1(locationControlDiv1, map);
				  locationControlDiv1.index = 1;
				  map.controls[google.maps.ControlPosition.TOP_LEFT].push(locationControlDiv1);
				  
				  var locationControlDiv2 = document.createElement('div');
				  var locationControl2 = new LocationControl2(locationControlDiv2, map);
				  locationControlDiv2.index = 2;
				  map.controls[google.maps.ControlPosition.TOP_LEFT].push(locationControlDiv2);
        }
		
		var location1 = new google.maps.LatLng(45.5378437, -73.6181039); // 244 de Castelnau Est
		var location2 = new google.maps.LatLng(45.5428795,-73.6292336);
		
		function LocationControl1(controlDiv, map) {
			// Set CSS styles for the DIV containing the control
			// Setting padding to 5 px will offset the control
			// from the edge of the map
			controlDiv.style.padding = '5px';

			// Set CSS for the control border
			var controlUI = document.createElement('div');
			controlUI.style.backgroundColor = 'black';
			controlUI.style.borderStyle = '';
			controlUI.style.borderWidth = '';
			controlUI.style.cursor = 'pointer';
			controlUI.style.textAlign = 'center';
			controlUI.title = 'Click to set the map to Home';
			controlDiv.appendChild(controlUI);

			// Set CSS for the control interior
			var controlText = document.createElement('div');
			controlText.style.fontFamily = 'Arial,sans-serif';
			controlText.style.fontSize = '15px';
			controlText.style.color = 'white';
			controlText.style.paddingLeft = '4px';
			controlText.style.paddingRight = '4px';
			controlText.innerHTML = '<b>244 de Castelnau Est</b>';
			controlUI.appendChild(controlText);

			// Setup the click event listeners: simply set the map to
			// Chicago
			google.maps.event.addDomListener(controlUI, 'click', function() {
				map.setCenter(location1)
			});

		}
		
		function LocationControl2(controlDiv, map) {
			// Set CSS styles for the DIV containing the control
			// Setting padding to 5 px will offset the control
			// from the edge of the map
			controlDiv.style.padding = '5px';

			// Set CSS for the control border
			var controlUI = document.createElement('div');
			controlUI.style.backgroundColor = 'black';
			controlUI.style.borderStyle = '';
			controlUI.style.borderWidth = '';
			controlUI.style.cursor = 'pointer';
			controlUI.style.textAlign = 'center';
			controlUI.title = 'Click to set the map to Home';
			controlDiv.appendChild(controlUI);

			// Set CSS for the control interior
			var controlText = document.createElement('div');
			controlText.style.fontFamily = 'Arial,sans-serif';
			controlText.style.fontSize = '15px';
			controlText.style.color = 'white';
			controlText.style.paddingLeft = '4px';
			controlText.style.paddingRight = '4px';
			controlText.innerHTML = '<b>405 Jarry Est</b>';
			controlUI.appendChild(controlText);

			// Setup the click event listeners: simply set the map to
			// Chicago
			google.maps.event.addDomListener(controlUI, 'click', function() {
				map.setCenter(location2)
			});

		}
		
        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'resize', init);
        google.maps.event.addDomListener(window, 'load', init);
    </script>

</head>

<body>
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=295402343969195&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<header>
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

            <?php if($attachment_id): ?>
                <a href="<?php echo $image_link; ?>"><img src="<?php echo $image_src[0]; ?>" alt="<?php the_title(); ?>"></a>
            <?php else: ?>
                <a class="owl-video" href="<?php echo $video_url; ?>"></a>
            <?php endif; ?>

    <?php endforeach; wp_reset_postdata();?>

    </div>
</header>
