<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes('xhtml'); ?>>
<head profile="http://gmpg.org/xfn/11">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'gray_white_black'), max( $paged, $page ) );

	?></title>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" />
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
	
	
	<div class="header">
    <div id="header_shadow">
    </div>
    <div id="search_social">
    <?php get_search_form(); ?>
        <div class="sociala_medier">
        	<a href="https://www.facebook.com/pages/lirresblogcom/167411549974524"><img src="<?php bloginfo('template_directory'); ?>/images/facebook-icon.png" /></a>
            <a href="https://twitter.com/#!/lirresblog"><img src="<?php bloginfo('template_directory'); ?>/images/twitter.png" /></a>
            <a href="https://itunes.apple.com/se/podcast/lirresblog.com/id589995382?l=en"><img src="<?php bloginfo('template_directory'); ?>/images/itunes_icon.png" /></a>
        </div>
    </div>
    <div id="upper-holder">
    <div id="saff" class="right_logo" onclick="javascript:location.href='http://www.saff.se';"></div>
    <div id="ifaf" class="right_logo" onclick="javascript:location.href='http://www.ifaf.org';"></div>
    <div id="tds" class="right_logo" onclick="javascript:location.href='http://tdsverige.se';"></div>
    <div id="ep" class="right_logo" onclick="javascript:location.href='http://www.europlayers.com';"></div>
    
		<div class="logo-box">
		  <p class="logo"><a href="<?php echo home_url(); ?>" name="top"><img src="<?php bloginfo('template_directory'); ?>/images/sfn_logo2.png" /></a></p>
		</div>
		<div class="teams_box">
        	<a href="http://www2.idrottonline.se/TyresoRoyalCrownsAFF-AmerikanskFotboll/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/trclogo.png" />	</a>
		  	<a href="http://www.predators.se/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/kplogo.png" /></a>
		  	<a href="http://www.svenskalag.se/northsidebulls" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/stulogo.png" /></a>
            <a href="http://www.arlandajets.com/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/ajlogo.png" /></a>
            <img style="margin:0 10px" src="<?php bloginfo('template_directory'); ?>/images/sslogo.png" />
            <a href="http://www.laget.se/BLACKKNIGHTS" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/obklogo.png" /></a>	
            <a href="http://www.meanmachines.se/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/smmlogo.png" /></a>
            <a href="http://www.laget.se/86ers" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/u86logo.png" /></a>
            <a href="http://www.crusaders.se" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/cclogo.png" /></a>
		</div>
    </div>
		<div class="menubox">
			<div>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("widgetized-page-top") ) : ?>
				<?php endif; ?>
				<div class="clear"></div>
			</div>
		</div>
        </div> 
		<?php 
        $start_week = 24;
        $last_week = 58;
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
			
			if(get_field('serie') == "Superserien"){?>
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
        
	

	<div class="content">
   