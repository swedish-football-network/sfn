<?php
/*
Template Name: User specfic posts
*/
?>
<?php get_header(); ?>

	
	<?php 
	if (have_posts()) :  $first = true; 	
	 	while (have_posts()) : the_post();
	    	$name = get_the_title();
			$name = strtolower($name);
	   	endwhile;
		$temp = get_userdatabylogin($name);
		$userid = $temp ->ID;
	 	$author = 'author='.$userid;
		?>
       	<img style="max-width:none" src="<?php bloginfo('template_directory'); ?>/images/headers/<?php echo $name ?>.jpg" /><br />
        
		<div class="main">
		<ul class="post-list">
		<?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		query_posts( 'posts_per_page=10&'.$author.'&paged='.$paged );
		while (have_posts()) : the_post();
		
		$class="";
		$first = !$first;
		?>
			<!-- Start: Post -->
            <?php if (has_post_thumbnail()){ ?>
			<li <?php post_class($class); ?>>
				<div id="post-bild"><?php the_post_thumbnail(); ?></div>
				<div id="post-text"><p class="categories"><?php the_category(", "); ?></p>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> <?php edit_post_link(__('Edit', 'gray_white_black'), '', ''); ?></h2>
				<p class="post-meta"><span class="date"><?php the_time( get_option( 'date_format' ) ) ?></span> <?php if ( comments_open() ) : ?>, <span class="comments"><?php comments_popup_link( _x( '0', 'comments number', 'gray_white_black' ), _x( '1', 'comments number', 'gray_white_black' ), _x( '%', 'comments number', 'gray_white_black' ) ); ?></span> <?php endif; ?></p>
				<?php the_excerpt(); ?>
				<?php if(has_tag()): ?><p class="tags"><span><?php the_tags(""); ?></span></p><?php endif; ?>
                </div>
			</li>
            <?php  }else{?>
            <li <?php post_class($class); ?>>
				<div id="post-text-wo-img"><p class="categories"><?php the_category(", "); ?></p>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> <?php edit_post_link(__('Edit', 'gray_white_black'), '', ''); ?></h2>
				<p class="post-meta"><span class="date"><?php the_time( get_option( 'date_format' ) ) ?></span> <?php if ( comments_open() ) : ?>, <span class="comments"><?php comments_popup_link( _x( '0', 'comments number', 'gray_white_black' ), _x( '1', 'comments number', 'gray_white_black' ), _x( '%', 'comments number', 'gray_white_black' ) ); ?></span> <?php endif; ?></p>
				<?php the_excerpt(); ?>
				<?php if(has_tag()): ?><p class="tags"><span><?php the_tags(""); ?></span></p><?php endif; ?>
                </div>
			</li>
            <?php };?>
			<!-- End: Post -->
		<?php endwhile; ?>
		</ul>
		<p class="pagination">
			<span class="prev"><?php next_posts_link(__('&laquo; Previous Posts', 'gray_white_black')) ?></span>
			<span class="next"><?php previous_posts_link(__('Next posts &raquo;', 'gray_white_black')) ?></span>
		</p>
	<?php else : ?>
		<h2 class="center"><?php _e( 'Not found', 'gray_white_black' ); ?></h2>
		<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'gray_white_black' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
