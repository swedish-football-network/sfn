<?php get_header(); ?>

<div class="main">



	<?php if (have_posts()) :  $first = true; ?>
		<ul class="post-list">
       
		<?php while (have_posts()) : the_post();
		if($first) $class = "first-in-row";
		else $class="";
		$first = !$first;
		?>
			<!-- Start: Post -->
            <?php if (has_post_thumbnail()){ ?>
           
			<li <?php post_class($class); ?>>
				<div id="post-bild"><?php the_post_thumbnail(); ?></div>
				<div id="post-text"><p class="categories"><?php the_category(", "); ?></p>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> <?php edit_post_link(__('Edit', 'gray_white_black'), '', ''); ?></h2>
				<p class="post-meta"><span class="date"><?php the_author(); ?><br /><?php the_time( get_option( 'date_format' ) ) ?></span> <?php if ( comments_open() ) : ?>, <span class="comments"><?php comments_popup_link( _x( '0', 'comments number', 'gray_white_black' ), _x( '1', 'comments number', 'gray_white_black' ), _x( '%', 'comments number', 'gray_white_black' ) ); ?></span> <?php endif; ?></p>
				<?php the_excerpt(); ?>
				<?php if(has_tag()): ?><p class="tags"><span><?php the_tags(""); ?></span></p><?php endif; ?>
                </div>
			</li>
            <?php  }else{?>
            <li <?php post_class($class); ?>>
				<div id="post-text-wo-img"><p class="categories"><?php the_category(", "); ?></p>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> <?php edit_post_link(__('Edit', 'gray_white_black'), '', ''); ?></h2>
				<p class="post-meta"><span class="date"><?php the_author(); ?><br /><?php the_time( get_option( 'date_format' ) ) ?></span> <?php if ( comments_open() ) : ?>, <span class="comments"><?php comments_popup_link( _x( '0', 'comments number', 'gray_white_black' ), _x( '1', 'comments number', 'gray_white_black' ), _x( '%', 'comments number', 'gray_white_black' ) ); ?></span> <?php endif; ?></p>
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
