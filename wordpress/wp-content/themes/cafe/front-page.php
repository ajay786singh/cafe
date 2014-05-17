<?php get_header(); ?>
<div style="background-color: #dfe0d5; height: 450px;">
<?php           

        $feeds = array(
                array('label'=>'recipes','link'=>'http://www.cabotcheese.coop/pages/recipes/rss-fgg.php?rss=atom20','filter'=>'recipes')
                //array('label'=>'instagram','link'=>'http://ink361.com/feed/user/cabotcheese','filter'=>'social')
        );
    //$results = json_cached_results($feeds);
    //show_feed_results($results);
?>
        
  </div>
 
<?php get_footer(); ?>