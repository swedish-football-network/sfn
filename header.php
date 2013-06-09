<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes('xhtml'); ?>><head profile="http://gmpg.org/xfn/11">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/sfn_logo2.png"/>

    <title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	 function sort_game_array($a, $b){
	 	$ettan = $a['datum'] + strtotime($a['tid']);
	 	$tvaan = $b['datum'] + strtotime($b['tid']);

	 	if($ettan != $tvaan){
	 		return $ettan > $tvaan;
	 	}else{
		 	return 0;
	 	}

	 };

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
		echo " | $site_description ";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'gray_white_black'), max( $paged, $page ) );

	?></title>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="modal login arrow-box" id="login-modal">
		<h3>Logga in</h3>
		<p class="no-account">Har du inget konto? <a href="<?php echo bloginfo('url'); ?>/wp-login.php?action=register">Registrera dig här!</a></p>
		<?php wp_login_form( $args ); ?>
	</div>

	<div class="header">
    <div id="header_shadow">
    </div>
    <div id="search_social">
	    	<div class="login-button" id="login-button"><img src="<?php echo get_template_directory_uri(); ?>/images/padlock.png" /> Logga in</div>
    <?php get_search_form(); ?>
        <div class="sociala_medier">
        	<a href="https://www.facebook.com/swedishfootballnetwork"><img src="<?php bloginfo('template_directory'); ?>/images/facebook-icon.png" /></a>
            <a href="https://twitter.com/swefootballnet"><img src="<?php bloginfo('template_directory'); ?>/images/twitter.png" /></a>
            <a href="https://itunes.apple.com/se/podcast/lirresblog.com/id589995382?l=en"><img src="<?php bloginfo('template_directory'); ?>/images/itunes_icon.png" /></a>
        </div>
    </div>
    <div id="upper-holder">
		<div class="logo-box">
		  <p class="logo"><a href="<?php echo home_url(); ?>" name="top"><img src="<?php bloginfo('template_directory'); ?>/images/sfn_logo2.png" /></a></p>
		</div>
		<div class="teams_box">
        	<img src="<?php bloginfo('template_directory'); ?>/images/trclogo.png" />
		  	<img src="<?php bloginfo('template_directory'); ?>/images/kplogo.png" />
		  	<img src="<?php bloginfo('template_directory'); ?>/images/stulogo.png" />
            <img src="<?php bloginfo('template_directory'); ?>/images/ajlogo.png" />
            <a href="http://safelit.wordpress.com" target="_blank"><img style="margin:0 20px" src="<?php bloginfo('template_directory'); ?>/images/sslogo.png" /></a>
            <img src="<?php bloginfo('template_directory'); ?>/images/obklogo.png" />
           <img src="<?php bloginfo('template_directory'); ?>/images/smmlogo.png" />
            <img src="<?php bloginfo('template_directory'); ?>/images/u86logo.png" />
            <img src="<?php bloginfo('template_directory'); ?>/images/cclogo.png" />
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
		//
		$matcher = array();
        $start_week = 22;
        $last_week = 50;
        $real_week = date('W');
        $fb_week = $real_week - $start_week;
        $dayofweek = date('N');

        if($dayofweek == "1" or $dayofweek == "2"){$real_week = $real_week - 1;};
       	if($real_week >= $start_week && $real_week <= $last_week){ ?>
        <div id="games">

        <?php $loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => -1, 'meta_key' => 'serie', 'meta_value' => 'Superserien' ) ); ?>
            <?php while ( $loop->have_posts() ) : $loop->the_post();
	            $date = strtotime(get_field("datum"));
	            $game_week = date('W', $date);
	            if(get_field('serie') == "Superserien" and $game_week == $real_week){
					$temp = get_field('hemmalag');
					$hemmalag = $temp[0]->ID;
					$hemmalag = get_the_title($hemmalag) ;

					$temp = get_field('bortalag');
					$bortalag = $temp[0]->ID;
					$bortalag = get_the_title($bortalag) ;

					$matcher[] = array(
			                "hemmalag" => $hemmalag,
			                "bortalag" => $bortalag,
			                "datum" => $date,
			                "hemmares" => get_field('hemmares'),
			                "bortares" => get_field('bortares'),
			                "matchtid" => get_field('matchtid'),
			                "tid" => get_field('tid'),
			                "link" => get_permalink()
			        );
			   };
		    endwhile;



		        usort($matcher, 'sort_game_array');

		        foreach($matcher as $match){
		        ?>
                <div class="game" <?php if($match['matchtid'] == "" && $match["hemmares"] != ""){echo " style='height:62px;'";};?>  onclick="javascript:location.href='<?php echo $match['link'] ?>';">
                    <div class="date">

                            <?php
                            if($match['matchtid'] == ''){
	                            if($match['hemmares'] != ''){
		                            //Matchen är klar
	                            }else{
	                            	echo date('D', $match['datum']); echo " ";
	                            	echo $match['tid'];
	                            }
                            }else{
                            	echo $match['matchtid'];
                            };
                            ?>
                    </div>
                    <div style="position:absolute; bottom:27px;width:100%">
                        <div style="position:relative;float:left;width:65%; margin-left:13px ;font-weight:bold; line-height:15px">
                            <?php echo $match['hemmalag']; ?><br />
                            <?php echo $match['bortalag']; ?>
                        </div>
                        <div style="position:relative;float:left;width:20%; text-align:right; line-height:15px">
                            <?php echo $match['hemmares']; ?><br />
                            <?php echo $match['bortares']; ?>
                        </div>
                    </div>
                </div>
            <?php }; ?>

            <div class="sched" onclick="javascript:location.href='/superserien/';">
            	Spelschema
            </div>
        </div>
        <?php }?>



	<div class="content">
