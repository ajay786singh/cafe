<!DOCTYPE html>
<html>
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

</head>

<body>
    <header>
        <div id="owl-demo" class="owl-carousel" style="background-color: #000;">
            <div class="item"><img class="lazyOwl" data-src="<?php bloginfo('template_url');?>/images/larue-01.jpg" alt="Lazy Owl Image"></div>
            <div class="item"><img class="lazyOwl" data-src="<?php bloginfo('template_url');?>/images/larue-02.jpg" alt="Lazy Owl Image"></div>
            <div class="item"><img class="lazyOwl" data-src="<?php bloginfo('template_url');?>/images/larue-03.jpg" alt="Lazy Owl Image"></div>
            <div class="item"><img class="lazyOwl" data-src="<?php bloginfo('template_url');?>/images/larue-04.jpg" alt="Lazy Owl Image"></div>
            <div class="item"><img class="lazyOwl" data-src="<?php bloginfo('template_url');?>/images/larue-05.jpg" alt="Lazy Owl Image"></div>
            <div class="item"><img class="lazyOwl" data-src="<?php bloginfo('template_url');?>/images/larue-06.jpg" alt="Lazy Owl Image"></div>
        </div>
    </header>