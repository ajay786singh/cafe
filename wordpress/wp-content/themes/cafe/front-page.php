<?php get_header(); ?>

<div id="slider2" class="owl-carousel" style="background-color: #f7f6ed">



<?php           
	$feeds = array(
		array('label'=>'facebook','link'=>'http://www.facebook.com/feeds/page.php?id=145253518873861&format=rss20','filter'=>'social'),
		array('label'=>'pinterest','link'=>'http://www.pinterest.com/guillaumeadan/caf%C3%A9-montr%C3%A9al.rss','filter'=>'social')
		//array('label'=>'instagram','link'=>'http://iconosquare.com/feed/tag/cafelarueetfils','filter'=>'social'),
		//array('label'=>'instagram','link'=>'http://iconosquare.com/feed/cafelarue','filter'=>'social')
		//array('label'=>'instagram','link'=>'http://iconosquare.com/feed/tag/cafelarueetfilsjarry','filter'=>'social')
		
		//array('label'=>'instagram','link'=>'#','filter'=>'social')
	);
	$results = json_cached_results($feeds);
	show_feed_results($results);
?>

</div>

<?php get_footer(); ?>