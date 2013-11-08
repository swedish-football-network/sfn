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
        	<a href="/teams/tyreso-royal-crowns/"><img src="<?php bloginfo('template_directory'); ?>/images/trclogo.png" /></a>
		  	<a href="/teams/kristianstad-predators/"><img src="<?php bloginfo('template_directory'); ?>/images/kplogo.png" /></a>
		  	<a href="/teams/stu-northside-bulls/"><img src="<?php bloginfo('template_directory'); ?>/images/stulogo.png" /></a>
            <a href="/teams/arlanda-jets/"><img src="<?php bloginfo('template_directory'); ?>/images/ajlogo.png" /></a>
            <a href="http://safelit.wordpress.com" target="_blank"><img style="margin:0 20px" src="<?php bloginfo('template_directory'); ?>/images/sslogo.png" /></a>
            <a href="/teams/orebro-black-knights/"><img src="<?php bloginfo('template_directory'); ?>/images/obklogo.png" /></a>
            <a href="/teams/stockholm-mean-machines/"><img src="<?php bloginfo('template_directory'); ?>/images/smmlogo.png" /></a>
            <a href="/teams/uppsala-86ers/"><img src="<?php bloginfo('template_directory'); ?>/images/u86logo.png" /></a>
            <a href="/teams/carlstad-crusaders/"><img src="<?php bloginfo('template_directory'); ?>/images/cclogo.png" /></a>
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
        $start_week = 0;
        $last_week = 54;
        $real_week = date('W');
        $fb_week = $real_week - $start_week;
        $dayofweek = date('N');
      if($real_week != 36 || !is_home()){  
        if($dayofweek == "1" or $dayofweek == "2"){$real_week = $real_week - 1;};
       	if($real_week >= $start_week && $real_week <= $last_week){ ?>
        
        <div id="games">

        <?php $loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => -1, 'meta_key' => 'serie', 'meta_value' => array( 'TDS 1', 'TDS 2' ) ) ); ?>
            <?php while ( $loop->have_posts() ) : $loop->the_post();
	            $date = strtotime(get_field("datum"));
	            $game_week = date('W', $date);
	            if((get_field('serie') == "TDS 1" or get_field('serie') == "TDS 2") and ($game_week == $real_week or $game_week == $real_week+1 or $game_week == $real_week+2)){
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
	                            	echo date('j/n', $match['datum']); echo " ";
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

          
        </div>
        <?php }
        echo '<div class="content">'; 
	        }else if(is_home() && $real_week == 36){
		echo '<div class="content">';        	
		$idgm = 8740;
		$temp = get_field('hemmalag',$idgm);
		$id = $temp[0]->ID;
		$hemmabild = get_field("logo",$id);
		$hemmaroster = get_field("roster",$id);
		$hemmalag = get_the_title($id);
		if(get_field("link", $id) == 1){
			$hemmalink = get_permalink($id);
		}else{
			$hemmalink = "nope";
		}
		
		$temp = get_field('bortalag',$idgm);
		$id = $temp[0]->ID;
		$bortabild = get_field("logo",$id);
		$bortaroster = get_field("roster",$id);
		$bortalag = get_the_title($id);
		if(get_field("link", $id) == 1){
			$bortalink = get_permalink($id);
		}else{
			$bortalink = "nope";
		}
		
		$hemmares = get_field("hemmares",$idgm);
		$bortares = get_field("bortares",$idgm);
		$datum = get_field("datum",$idgm);
		$matchtid = get_field("matchtid",$idgm);
		$serie = get_field("serie",$idgm);
		$tid = get_field("tid",$idgm);
		$rubrik = get_the_title($idgm);
		$content = get_the_content($idgm);
		$stream = get_field("stream",$idgm);
		$twitter = get_field("twitter",$idgm);
		$stats = get_field("stats",$idgm);
		
	
	?>
	
    	<div style="width:396px;position:relative;margin-left: auto;margin-right:auto;"><img src="<?php bloginfo("template_directory") ?>/images/finallogo.png"/></div>
        <div id="game_header" style="margin-bottom:20px;" onclick="location.href='http://www.swedishfootballnetwork.se/games/sm-final/';">
        	<div id="hemmalag_hdr" class="hdr hemma">
            	<?php if($hemmalink != "nope"){echo "<a href='" . $hemmalink . "'>" . $hemmalag . "</a>";}else{echo $hemmalag;} ?>
            </div>
            <div id="hemmabild_hdr" class="hdr hemma" <?php if($hemmabild["url"] != ""){ ?> style='background:url(<?php echo $hemmabild["url"] ?>) no-repeat center #fff' <?php } ?>>
			<?php 
			if($hemmabild["url"] != ""){
			?>	
				<img src="<?php bloginfo("template_directory") ?>/images/overlay_game.png"/>
			<?php
            };
			?>
            	
            </div>
            <div id="hemmares_hdr" class="hdr hemma">
            	<?php echo $hemmares ?>
            </div>
            
            <div id="mitten" class="hdr">
            	<div id="serie_hdr">
                	<?php echo $serie ?>
                </div>
                <div id="tiden">
                	<?php 
					if($hemmares != "" and $matchtid == ""){
						echo "SLUT";
					}else if($hemmares == ""){
						echo date('j/n',strtotime($datum)) . " " . $tid;
					}else{
						echo $matchtid;	
					}
						
					
					
					
					
					
					?>
                </div>
            </div>
            
            <div id="bortalag_hdr" class="hdr borta">
            	<?php if($bortalink != "nope"){echo "<a href='" . $bortalink . "'>" . $bortalag . "</a>";}else{echo $bortalag;} ?>
            </div>
            <div id="bortabild_hdr" class="hdr borta" <?php if($bortabild["url"] != ""){ ?> style='background:url(<?php echo $bortabild["url"] ?>) no-repeat center #fff' <?php } ?>>
			<?php 
			if($bortabild["url"] != ""){
			?>	
				<img src="<?php bloginfo("template_directory") ?>/images/overlay_game.png"/>
			<?php
            };
			?>
            	
            </div>
            <div id="bortares_hdr" class="hdr borta">
            	<?php echo $bortares ?>
            </div>
        </div>
    
    	<?php
	        }
        ?>



	
