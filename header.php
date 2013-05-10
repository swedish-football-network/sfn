<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes('xhtml'); ?>><head profile="http://gmpg.org/xfn/11">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<meta property="og:image" content="http://www.swedishfootballnetwork.se/wp-content/themes/gray-white-black/images/sfn_logo2.png"/>

    <title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;



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
    <script type="text/javascript" src="wp-content/themes/gray-white-black/tablesorter/jquery.tablesorter.js"></script>
    <script type="text/javascript">
		jQuery(document).ready(function($){
			var head = $("#roster table tbody").find("tr:first-child").html();
			head = "<thead><tr>"+head+"</tr></thead>";
			$("#roster table tbody").find("tr:first-child").remove();
			$("#roster table tbody").before(head);
			$("#roster table thead td").each(function(index) {
				var content = $(this).text();
			  	var thisTD = this;
			  	var newElement = $("<th></th>");
			  	$.each(this.attributes, function(index) {
					$(newElement).attr(thisTD.attributes[index].name, thisTD.attributes[index].value);
			  	});
			  	$(this).after(newElement).remove();
				$(newElement).text(content);
			});
			$("#roster table").tablesorter();
			$("#tabell_div table tbody tr td").each(function(){
				if($("#hiddenteamforjscript").text() == $(this).text()){
					$(this).parent().css("background","#94A8C5");
				};
			});
		});
    </script>
</head>
<body <?php body_class(); ?>>
	<div class="modal login arrow-box" id="login-modal">
		Logga in
	</div>

	<div class="header">
    <div id="header_shadow">
    </div>
    <div id="search_social">
	    	<div class="login-button" id="login-button"># Logga in</div>
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



	<div class="content">
