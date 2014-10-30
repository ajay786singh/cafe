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
		var template_url="<?php bloginfo('template_url');?>";
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
