<!DOCTYPE html>
<html>
    <head profile="http://gmpg.org/xfn/11">
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta property="og:image" content="<?php echo get_template_directory_uri();?>/images/sfn_logo2.png"/>

    <title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	echo " | " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		echo ' | ' . sprintf( __( 'Page %s', 'sfn'), max( $paged, $page ) );
    }

	?></title>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
	<div class="modal login arrow-box" id="login-modal">
		<h3>Logga in</h3>
		<p class="no-account">Har du inget konto? <a href="<?php echo bloginfo('url'); ?>/wp-login.php?action=register">Registrera dig här!</a></p>
		<?php wp_login_form( $args ); ?>
	</div>
    <header class="grid site-header">
    <div class="grid__item one-whole">
        <div class="grid">
            <div class="grid__item one-half">
                <div class="login-button" id="login-button">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/padlock.png" /> Logga in
                </div>
            </div>
            <div class="grid__item one-half">
                <div class="alignright">
                	<a href="https://www.facebook.com/swedishfootballnetwork"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook-icon.png" /></a>
                    <a href="https://twitter.com/swefootballnet"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" /></a>
                    <a href="https://itunes.apple.com/se/podcast/lirresblog.com/id589995382?l=en"><img src="<?php echo get_template_directory_uri(); ?>/images/itunes_icon.png" /></a>
                    <!--<?php get_search_form(); ?>-->
                </div>
            </div>
        </div>
        <div class="grid">
            <div class="grid__item one-whole">
                <div class="logo-box">
                    <!-- INSERT H1 TEXT REPLACEMENT HERE -->
                    <a href="<?php echo home_url(); ?>" name="top"><img src="<?php echo get_template_directory_uri(); ?>/images/sfn_logo2.png" /></a>
                </div>
            </div>
        </div>
        <div class="grid">
            <div class="grid__item one-whole">
                <div class="teams-box">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/trclogo.png" />
                    <img src="<?php echo get_template_directory_uri(); ?>/images/kplogo.png" />
                    <img src="<?php echo get_template_directory_uri(); ?>/images/stulogo.png" />
                    <img src="<?php echo get_template_directory_uri(); ?>/images/ajlogo.png" />
                    <a href="http://safelit.wordpress.com" target="_blank"><img style="margin:0 20px" src="<?php echo get_template_directory_uri(); ?>/images/sslogo.png" /></a>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/obklogo.png" />
                    <img src="<?php echo get_template_directory_uri(); ?>/images/smmlogo.png" />
                    <img src="<?php echo get_template_directory_uri(); ?>/images/u86logo.png" />
                    <img src="<?php echo get_template_directory_uri(); ?>/images/cclogo.png" />
                </div>
            </div>
        </div>
    </div>
    </header>
    <div class="grid grid--extra-wide">
        <div class="grid__item one-whole">
            <div class="menu-box">
                <div>
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("widgetized-page-top") ) : ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
		<?php
		//
        $start_week = 59;
        $last_week = 60;
        $real_week = date('W');
        $fb_week = $real_week - $start_week; ?>

       	<?php if($real_week >= $start_week && $real_week <= $last_week){ ?>
        <div id="games">
        <?php $loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => 100 ) ); ?>
            <?php while ( $loop->have_posts() ) : $loop->the_post();
			$temp = get_field('hemmalag');
			$hemmalag = $temp[0]->ID;
			$hemmalag = get_the_title($hemmalag) ;

			$temp = get_field('bortalag');
			$bortalag = $temp[0]->ID;
			$bortalag = get_the_title($bortalag) ;

			$date = strtotime(get_field("datum"));
			$game_week = date('W', $date);


			if(get_field('serie') == "Superserien" and $game_week == $real_week){?>
                <div class="game" onclick="javascript:location.href='<?php the_permalink() ?>';">
                    <div class="date">

                            <?php echo date('D', get_field("datum")); echo " "; the_field('tid') ?>
                    </div>
                    <div style="position:absolute; bottom:27px;width:100%">
                        <div style="position:relative;float:left;width:65%; margin-left:13px ;font-weight:bold; line-height:15px">
                            <?php echo $hemmalag; ?><br />
                            <?php echo $bortalag; ?>
                        </div>
                        <div style="position:relative;float:left;width:20%; text-align:right; line-height:15px">
                            <?php the_field('hemmares'); ?><br />
                            <?php the_field('bortares'); ?>
                        </div>
                    </div>
                </div>
            <?php }
			endwhile; ?>
            <div class="sched" onclick="javascript:location.href='?page_id=4620';">
            	Spelschema
            </div>
        </div>
        <?php }?>
	<section class="grid white-bg main" role="main">